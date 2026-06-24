<?php

namespace App\Http\Controllers\Admin\Pengembalian;

use App\Http\Controllers\Controller;
use App\Mail\PengembalianBukuMail;
use App\Models\ItemBuku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Reservasi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Exception;

class PengembalianCepatController extends Controller
{
    public function index()
    {
        $peminjaman = null;

        if (session()->has('kode_peminjaman')) {
            $peminjaman = Peminjaman::with([
                'itemBuku.buku.penulis',
                'anggota.jenisKeanggotaan'
            ])
                ->where(
                    'kode_peminjaman',
                    session('kode_peminjaman')
                )
                ->first();
        }

        return view(
            'admin.pengembalian.pengembalian-cepat',
            compact('peminjaman')
        );
    }

    public function pengembalianCepat(Request $request)
    {
        try {
            $kode_peminjaman = null;

            DB::transaction(function () use ($request, &$kode_peminjaman) {
                $request->validate([
                    'id_item' => 'required'
                ]);

                $peminjaman = Peminjaman::where('status', 'Dipinjam')->where('id_item', $request->id_item)->with(['itemBuku.buku.penulis', 'anggota.jenisKeanggotaan'])->firstOrFail();

                $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

                $jumlahHariKeterlambatan = $jatuhTempo->diffInDays(now()->format('Y-m-d'), false);

                if ($jumlahHariKeterlambatan < 0) {
                    $jumlahHariKeterlambatan = 0;
                }

                $total_denda = $jumlahHariKeterlambatan * 1000;

                $peminjaman->status = "Dikembalikan";
                $peminjaman->save();

                $itemBuku = ItemBuku::find($peminjaman->id_item);
                $itemBuku->status_item = "Tersedia";
                $itemBuku->save();

                $pengembalian = Pengembalian::create([
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                    'tanggal_pengembalian' => now(),
                    'total_denda' => $total_denda,
                ]);

                $this->kirimEmailPengembalian($pengembalian);
                $this->checkReservasi($itemBuku->id_buku, $peminjaman->id_item);

                $kode_peminjaman = $peminjaman->kode_peminjaman;
            });

            return redirect()
                ->route('admin.pengembalian.cepat')
                ->with([
                    'kode_peminjaman' => $kode_peminjaman,
                    'success' => 'Pengembalian buku berhasil, terima kasih telah meminjam buku disini'
                ]);
        } catch (ModelNotFoundException $e) {

            return redirect()
                ->back()
                ->with('error', 'Peminjaman tidak ditemukan atau buku sudah dikembalikan.');

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Pengembalian buku gagal');
        }
    }

    public function kirimEmailPengembalian($pengembalian)
    {
        $pengembalian->load([
            'peminjaman.anggota',
            'peminjaman.itemBuku.buku'
        ]);

        // Mail::to($pengembalian->peminjaman->anggota->email)
        //     ->send(new PengembalianBukuMail($pengembalian));
        Mail::to('danielbatubara813@gmail.com')
            ->send(new PengembalianBukuMail($pengembalian));
    }

    public function checkReservasi($id_buku, $id_item)
    {
        $reservasi = Reservasi::where('id_buku', $id_buku)
            ->where('status', 'Menunggu Antrian')
            ->orderBy('tanggal_diajukan')
            ->first();

        if (!$reservasi) {
            return;
        }

        $itemBuku = ItemBuku::where('id_item', $id_item)->first();
        $itemBuku->update([
            'status_item' => 'Dipesan'
        ]);

        $reservasi->update([
            'id_item' => $itemBuku->id_item,
            'status' => 'Menunggu Konfirmasi',
            'tanggal_diterima' => now(),
        ]);
        return;
    }
}
