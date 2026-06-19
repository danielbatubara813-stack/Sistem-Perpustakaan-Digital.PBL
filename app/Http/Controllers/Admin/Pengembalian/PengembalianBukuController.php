<?php

namespace App\Http\Controllers\Admin\Pengembalian;

use App\Http\Controllers\Controller;
use App\Mail\PengembalianBukuMail;
use App\Models\Anggota;
use App\Models\ItemBuku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class PengembalianBukuController extends Controller
{
    public function index(Request $request)
    {
        $anggota = null;
        $peminjaman = collect();

        if ($request->filled('nomor_identitas')) {

            $anggota = Anggota::where('nomor_identitas', $request->nomor_identitas)->with('jenisKeanggotaan')->first();

            $peminjaman = Peminjaman::where('status', 'Dipinjam')->where('id_anggota', $anggota->id_anggota)->with('itemBuku.buku.penulis')->get();
        }

        return view('admin.pengembalian.buku', compact(
            'anggota',
            'peminjaman'
        ));
    }

    public function kembalikanBuku(Request $request)
    {
        try {
            $request->validate([
                'kode_peminjaman' => 'required'
            ]);

            $peminjaman = Peminjaman::where('kode_peminjaman', '=', $request->kode_peminjaman)->first();

            $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

            $jumlahHariKeterlambatan = $jatuhTempo->diffInDays(now()->format('Y-m-d'), false);

            if ($jumlahHariKeterlambatan < 0) {
                $jumlahHariKeterlambatan = 0;
            }

            $total_denda = $jumlahHariKeterlambatan * 1000;

            if ($jumlahHariKeterlambatan < 0) {
                $peminjaman->status = "Dikembalikan";
                $peminjaman->save();
                $message = "Pengembalian buku berhasil, terima kasih telah meminjam buku disini";
            } else {
                $peminjaman->status = "Terlambat";
                $peminjaman->save();
                $message = "Pengembalian buku berhasil, terdapat denda buku total: " . $total_denda;
            }


            $itemBuku = ItemBuku::find($peminjaman->id_item);
            $itemBuku->status_item = "Tersedia";
            $itemBuku->save();

            $pengembalian = Pengembalian::create([
                'kode_peminjaman' => $request->kode_peminjaman,
                'tanggal_pengembalian' => now(),
                'total_denda' => $total_denda,
            ]);

            $this->kirimEmailPengembalian($pengembalian);

            return redirect()
                ->back()
                ->with('success', $message);
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
        Mail::to('franklinchang0129@gmail.com')
            ->send(new PengembalianBukuMail($pengembalian));
    }
}
