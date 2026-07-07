<?php

namespace App\Http\Controllers\Admin\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\AturanPeminjaman;
use App\Models\ItemBuku;
use App\Models\Peminjaman;
use App\Models\Reservasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReservasiController extends Controller
{
    public function reservasi(Request $request)
    {
        $reservasi = Reservasi::with(['anggota', 'buku', 'itemBuku'])
            // pencarian
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_reservasi', 'like', "%{$search}%")
                        ->orWhereHas('anggota', function ($anggota) use ($search) {
                            $anggota->where('nama', 'like', "%{$search}%")
                                ->orWhere('nomor_identitas', 'like', "%{$search}%");
                        })
                        ->orWhereHas('buku', function ($buku) use ($search) {
                            $buku->where('judul_buku', 'like', "%{$search}%");
                        });
                });
            })

            // filter waktu
            ->when($request->waktu, function ($query) use ($request) {
                if ($request->waktu == 'today') {
                    $query->whereDate('tanggal_diajukan', today());
                }

                if ($request->waktu == '7') {
                    $query->whereBetween('tanggal_diajukan', [now()->subDays(7), now()]);
                }

                if ($request->waktu == '30') {
                    $query->whereBetween('tanggal_diajukan', [now()->subDays(30), now()]);
                }
            })

            // filter status
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest('tanggal_dibuat')->paginate(10)->withQueryString();

        return view('admin.peminjaman.daftar-reservasi', compact('reservasi'));
    }

    public function reservasiDisetujui(Request $request)
    {
        try {
            $reservasi = Reservasi::with('anggota')
                ->where('nomor_reservasi', $request->nomor_reservasi)
                ->firstOrFail();

            if (! $reservasi->anggota || ! $reservasi->anggota->dapatMengaksesLayanan()) {
                return back()->with('error', $reservasi->anggota?->pesanAksesDitolak() ?? 'Data anggota pada reservasi ini tidak ditemukan.');
            }

            $reservasi->update([
                'status' => 'Siap Diambil',
                'tanggal_konfirmasi' => now(),
                'tanggal_expired' => now()->addDays(2),
            ]);

            return back()->with('success', 'Reservasi berhasil dikonfirmasi');
        } catch (Exception $e) {
            return back()->with('error', 'Reservasi gagal dikonfirmasi');
        }
    }

    public function reservasiDitolak(Request $request)
    {
        try {
            $reservasi = Reservasi::where('nomor_reservasi', $request->nomor_reservasi)->firstOrFail();
            $reservasi->update([
                'status' => 'Ditolak',
            ]);

            if ($reservasi->id_item) {
                ItemBuku::where('id_item', $reservasi->id_item)->update([
                    'status_item' => 'Tersedia',
                ]);
            }

            return back()->with('success', 'Reservasi berhasil ditolak');
        } catch (Exception $e) {
            return back()->with('error', 'Reservasi gagal ditolak');
        }
    }

    public function jadikanPeminjaman(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $reservasi = Reservasi::with(['anggota', 'itemBuku.buku'])
                    ->where('nomor_reservasi', $request->nomor_reservasi)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! $reservasi->anggota) {
                    throw ValidationException::withMessages([
                        'nomor_reservasi' => 'Data anggota pada reservasi ini tidak ditemukan.',
                    ]);
                }

                if (! $reservasi->anggota->dapatMengaksesLayanan()) {
                    throw ValidationException::withMessages([
                        'nomor_reservasi' => $reservasi->anggota->pesanAksesDitolak(),
                    ]);
                }

                if (! $reservasi->itemBuku || ! $reservasi->itemBuku->buku) {
                    throw ValidationException::withMessages([
                        'nomor_reservasi' => 'Data item buku pada reservasi ini tidak lengkap.',
                    ]);
                }

                $aturan = AturanPeminjaman::where(function ($q) use ($reservasi) {
                    $q->where('id_jenis', $reservasi->anggota->id_jenis)->orWhereNull('id_jenis');
                })->where(function ($q) use ($reservasi) {
                    $q->where('id_tipe', $reservasi->itemBuku->buku->id_tipe)->orWhereNull('id_tipe');
                })->first();

                if (! $aturan) {
                    throw ValidationException::withMessages([
                        'nomor_reservasi' => 'Aturan peminjaman belum tersedia.',
                    ]);
                }

                // cek jumlah pinjaman aktif
                $jumlahPinjam = Peminjaman::where('id_anggota', $reservasi->id_anggota)
                    ->where('status', 'Dipinjam')->count();

                if ($jumlahPinjam >= $aturan->batas_peminjaman) {
                    throw ValidationException::withMessages([
                        'nomor_reservasi' => 'Melebihi batas peminjaman.',
                    ]);
                }

                // buat peminjaman
                Peminjaman::create([
                    'kode_peminjaman' => $this->buatKodePeminjaman(),
                    'id_anggota' => $reservasi->id_anggota,
                    'id_item' => $reservasi->id_item,
                    'tanggal_peminjaman' => now(),
                    'tanggal_jatuh_tempo' => now()->addDays($aturan->periode_peminjaman),
                    'status' => 'Dipinjam',
                ]);

                $reservasi->update([
                    'status' => 'Selesai',
                    'tanggal_selesai' => now(),
                ]);

                $reservasi->itemBuku->update([
                    'status_item' => 'Dipinjam',
                ]);

            });

            return back()->with('success', 'Reservasi berhasil dibuat menjadi peminjaman');
        } catch (ValidationException $e) {
            return back()->with('error', collect($e->errors())->flatten()->implode(' '));
        } catch (Exception $e) {
            return back()->with('error', 'Reservasi gagal dibuat menjadi peminjaman');
        }
    }

    private function buatKodePeminjaman(): string
    {
        do {
            $kodePeminjaman = 'PJ'.strtoupper(Str::random(6));
        } while (
            Peminjaman::where(
                'kode_peminjaman',
                $kodePeminjaman
            )->exists()
        );

        return $kodePeminjaman;
    }
}
