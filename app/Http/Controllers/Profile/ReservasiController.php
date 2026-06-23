<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ItemBuku;
use App\Models\Reservasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class ReservasiController extends Controller
{
    public function ambilData()
    {
        $reservasi = [
            [
                'id' => 1,
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'cover' => 'https://imgv2-1-f.scribdassets.com/img/document/443499450/original/75e0895939/1?v=1',
                'edisi' => 'Cet. 1',
                'isbn' => '9786024246945',
                'no_panggil' => '813 LEI l',
                'tahun' => 2017,
                'penerbit' => 'Kepustakaan Populer Gramedia',
                'bahasa' => 'Indonesia',
                'halaman' => 379,
                'subject' => ['Fiksi', 'Sejarah', 'Sosial Politik', 'Novel Indonesia'],
                'deskripsi' => 'Novel yang mengangkat kisah aktivis mahasiswa pada masa Orde Baru.',

                'tanggal_pengajuan' => '16-04-2026',
                'status_reservasi' => 'Menunggu Konfirmasi',
            ],

            [
                'id' => 2,
                'judul' => 'Semua Bisa Menjadi Programmer Laravel Basic',
                'penulis' => 'Yuniar Supardi',
                'cover' => 'https://cdn.gramedia.com/uploads/items/9786230010460_Cov_Semua_Bisa_Menjadi_Programmer_Laravel_Basic.jpg',
                'edisi' => 'Cet. 1',
                'isbn' => '9786230010460',
                'no_panggil' => '005.262 YUN s',
                'tahun' => 2022,
                'penerbit' => 'Elex Media',
                'bahasa' => 'Indonesia',
                'halaman' => 320,
                'subject' => ['Programming', 'Laravel', 'PHP', 'Web Development'],
                'deskripsi' => 'Panduan dasar framework Laravel untuk pemula.',

                'tanggal_pengajuan' => '26-04-2026',
                'status_reservasi' => 'Sudah Konfirmasi',
            ],
        ];
        return $reservasi;
    }
    public function reservasi()
    {
        $user = Auth::guard('web')->user();
        $reservasi = Reservasi::with(['anggota', 'buku'])->where('status', '=', 'Draft')->where('tanggal_diajukan', '!=', null)->whereHas('anggota', function ($q) use ($user) {
            $q->where('id_anggota', '=', $user->id_anggota);
        })->get();

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
        $user = Auth::guard('web')->user();

        $request->validate([
            'nomor_reservasi' => 'required|array',
            'nomor_reservasi.*' => 'exists:reservasi,nomor_reservasi'
        ]);

        $reservasi = Reservasi::whereIn('nomor_reservasi', $request->nomor_reservasi)->get();
        foreach ($reservasi as $data) {
            $itemBuku = ItemBuku::where('id_buku', '=', $data->id_buku)->where('status_item', '=', 'Tersedia')->first();

            if ($itemBuku) {
                $itemBuku->status_item = "Dipesan";
                $itemBuku->save();

                $data->id_item = $itemBuku->id_item;
                $data->status = 'Menunggu Konfirmasi';
                $data->tanggal_diterima = now();
                $data->save();
            } else {
                $data->status = 'Menunggu Antrian';
                $data->save();
            }
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
