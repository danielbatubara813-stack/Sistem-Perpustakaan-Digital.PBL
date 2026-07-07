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
        $reservasi = Reservasi::with(['anggota', 'buku'])->where('status', '=', 'Draft')->where('tanggal_diajukan', '!=', null)->orderBy('tanggal_diajukan', 'ASC')->whereHas('anggota', function ($q) use ($user) {
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
                'id_buku' => 'required|integer|exists:buku,id_buku',
            ]);

            // Cek apakah anggota sudah memiliki reservasi untuk buku yang sama
            $exists = Reservasi::where('id_anggota', $user->id_anggota)
                ->where('id_buku', $request->id_buku)
                ->whereIn('status', [
                    'Draft',
                    'Menunggu Konfirmasi',
                    'Menunggu Antrian',
                    'Siap Diambil',
                    'Diterima'
                ])
                ->exists();

            if ($exists) {
                return back()->with(
                    'error',
                    'Reservasi gagal dibuat, buku ini sudah ada pada daftar reservasi Anda.'
                );
            }

            Reservasi::create([
                'id_anggota' => $user->id_anggota,
                'id_buku' => $request->id_buku,
                'tanggal_diajukan' => now(),
                'status' => 'Draft',
            ]);

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Buku berhasil ditambahkan ke daftar reservasi. Silakan buka menu Reservasi pada profil untuk mengajukan reservasi.'
                );

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Reservasi gagal dibuat.');
        }
    }
    public function ajukanReservasi(Request $request)
    {
        try {
            $request->validate([
                'nomor_reservasi' => 'required|array',
                'nomor_reservasi.*' => 'exists:reservasi,nomor_reservasi'
            ]);

            // Jika tombol batal ditekan
            if ($request->action === 'batal') {

                Reservasi::whereIn(
                    'nomor_reservasi',
                    $request->nomor_reservasi
                )->update([
                            'status' => 'Dibatalkan'
                        ]);

                return back()->with(
                    'success',
                    'Reservasi berhasil dibatalkan'
                );
            }

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
        })->paginate(10);
        return view('profile.daftar-reservasi', compact('reservasi'));
    }

    public function batalkanReservasi(Request $request)
    {
        $request->validate([
            'nomor_reservasi' => 'required|exists:reservasi,nomor_reservasi'
        ]);

        $reservasi = Reservasi::where(
            'nomor_reservasi',
            $request->nomor_reservasi
        )->firstOrFail();

        // Jika ada item buku yang sudah dipesan
        if ($reservasi->itemBuku) {
            $reservasi->itemBuku->update([
                'status_item' => 'Tersedia'
            ]);

            $reservasi->update([
                'id_item' => null
            ]);
        }

        $reservasi->update([
            'status' => 'Dibatalkan'
        ]);

        return back()->with(
            'success',
            'Reservasi berhasil dibatalkan'
        );
    }
}
