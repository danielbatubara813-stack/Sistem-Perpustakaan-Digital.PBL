<?php

namespace App\Http\Controllers\Admin\Pengembalian;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

            $pengembalian = Pengembalian::create([
                'kode_peminjaman' => $peminjaman->kode_peminjaman,
                'tanggal_pengembalian' => now(),
                'total_denda' => $total_denda,
            ]);

            return redirect()
                ->route('admin.pengembalian.cepat')
                ->with([
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
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
}
