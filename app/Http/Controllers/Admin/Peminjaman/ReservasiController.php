<?php

namespace App\Http\Controllers\Admin\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\ItemBuku;
use App\Models\Peminjaman;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function reservasi()
    {
        $reservasi = Reservasi::with(['anggota', 'buku', 'itemBuku'])->paginate(10);
        return view('admin.peminjaman.daftar-reservasi', compact('reservasi'));
    }

    public function reservasiDisetujui(Request $request)
    {
        $reservasi = Reservasi::where('nomor_reservasi', $request->nomor_reservasi)->firstOrFail();
        $reservasi->update([
            'status' => 'Siap Diambil',
            'tanggal_konfirmasi' => now()
        ]);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi');
    }

    public function reservasiDitolak(Request $request)
    {
        $reservasi = Reservasi::where('nomor_reservasi', $request->nomor_reservasi)->firstOrFail();
        $reservasi->update([
            'status' => 'Ditolak',
            'tanggal_konfirmasi' => now()
        ]);

        if ($reservasi->id_item) {
            ItemBuku::where('id_item', $reservasi->id_item)->update([
                'status_item' => 'Tersedia'
            ]);
        }

        return back()->with('success', 'Reservasi ditolak');
    }

    // public function reservasikonfirmasi(Request $request)
    // {
    //     $reservasi = Reservasi::where('nomor_reservasi', $request->nomor_reservasi)->firstOrFail();
    //     $reservasi->update([
    //         'status' => 'Siap Diambil',
    //         'tanggal_selesai' => now()
    //     ]);

    //     return back()->with('success', 'Reservasi berhasil dikonfirmasi');
    // }
}
