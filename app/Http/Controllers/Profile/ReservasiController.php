<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\AturanPeminjaman;
use App\Models\ItemBuku;
use App\Models\Peminjaman;
use App\Models\Reservasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class ReservasiController extends Controller
{
    public function reservasi()
    {
        $user = Auth::guard('web')->user();
        $reservasi = Reservasi::with(['anggota', 'buku'])->where('status', '=', 'Draft')->where('tanggal_diajukan', '!=', null)->whereHas('anggota', function ($q) use ($user) {
            $q->where('id_anggota', '=', $user->id_anggota);
        })->paginate(10);

        // dd($reservasi);
        return view('profile.reservasi', compact('reservasi'));
    }

    public function createReservasiSementara(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();
            $request->validate([
                'id_buku' => 'required|integer',
            ]);

            $exists = Reservasi::where(['id_anggota' => $user->id_anggota, 'id_buku' => $request->id_buku,])
                ->whereIn('status', ['Menunggu Konfirmasi', 'Menunggu Antrian', 'Diterima'])->exists();

            if ($exists) {
                return back()->with('error', "Reservasi gagal dibuat, reservasi sudah pernah dilakukan");
            }

            $reservasi = Reservasi::create([
                'id_anggota' => $user->id_anggota,
                'id_buku' => $request->id_buku,
                'tanggal_diajukan' => now(),
            ]);

            return redirect()
                ->back()
                ->with('success', "Reservasi berhasil dibuat silahkan ke menu reservasi pada profile untuk mengajukan reservasi");
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', "Reservasi gagal dibuat");
        }
    }
    public function ajukanReservasi(Request $request)
    {
        try {
            $request->validate([
                'nomor_reservasi' => 'required|array',
                'nomor_reservasi.*' => 'exists:reservasi,nomor_reservasi'
            ]);

            $reservasi = Reservasi::with(['anggota', 'buku', 'itemBuku'])
                ->whereIn('nomor_reservasi', $request->nomor_reservasi)->get();

            foreach ($reservasi as $data) {
                // ambil aturan
                $aturan = AturanPeminjaman::where('id_jenis', $data->anggota->id_jenis)
                    ->where(function ($q) use ($data) {
                        $q->where('id_tipe', $data->buku->id_tipe)
                            ->orWhereNull('id_tipe');
                    })->first();
                if (!$aturan) {
                    return back()->with('error', 'Aturan peminjaman belum tersedia');
                }

                // cek jumlah buku dipinjam
                $jumlahPinjam = Peminjaman::where('id_anggota', $data->id_anggota)
                    ->where('status', 'Dipinjam')->count();

                // cek reservasi aktif
                $jumlahReservasi = Reservasi::where('id_anggota', $data->id_anggota)
                    ->whereIn('status', ['Menunggu Konfirmasi', 'Menunggu Antrian', 'Siap Diambil'])
                    ->count();

                if (($jumlahPinjam + $jumlahReservasi) >= $aturan->batas_peminjaman) {
                    return back()->with('error', 'Anggota sudah mencapai batas peminjaman');
                }

                // lanjut proses reservasi
                $itemBuku = ItemBuku::where('id_buku', $data->id_buku)
                    ->where('status_item', 'Tersedia')->first();

                if ($itemBuku) {
                    $itemBuku->update([
                        'status_item' => 'Dipesan'
                    ]);

                    $data->update([
                        'id_item' => $itemBuku->id_item,
                        'status' => 'Menunggu Konfirmasi',
                        'tanggal_diterima' => now()
                    ]);
                } else {
                    $data->update([
                        'status' => 'Menunggu Antrian'
                    ]);
                }
            }

            return back()->with('success', 'Reservasi berhasil diproses');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', "Reservasi gagal diajukan");
        }
    }

    public function daftarReservasi()
    {
        $user = Auth::guard('web')->user();
        $reservasi = Reservasi::with(['anggota', 'buku'])->where('status', '!=', 'Menunggu')->whereHas('anggota', function ($q) use ($user) {
            $q->where('id_anggota', '=', $user->id_anggota);
        })->get();
        return view('profile.daftar-reservasi', compact('reservasi'));
    }
}
