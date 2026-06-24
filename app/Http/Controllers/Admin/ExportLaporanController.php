<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportLaporanController extends Controller
{
    public function export(Request $request)
    {
        switch ($request->jenis_laporan) {
            case 'transaksi':
                return $this->exportTransaksi($request);

            case 'reservasi':
                return $this->exportReservasi($request);

            case 'anggota':
                return $this->exportAnggota($request);

            case 'buku':
                return $this->exportBuku($request);

            default:
                return back()->with(
                    'error',
                    'Jenis laporan tidak ditemukan'
                );
        }
    }
    private function exportTransaksi(Request $request)
    {
        $query = Peminjaman::with([
            'anggota',
            'pengembalian',
            'itemBuku.buku'
        ]);

        if ($request->jenis_filter === 'periode') {

            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date',
            ]);

            $query->whereBetween(
                'tanggal_peminjaman',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $data = $query->get();

        $totalPeminjaman = $data->count();
        $totalDikembalikan = $data->where('status', 'Dikembalikan')->count();
        $totalTerlambat = $data->where('status', 'Terlambat')->count();
        $totalMasihDipinjam = $data->where('status', 'Dipinjam')->count();
        $totalDenda = $data->sum(function ($item) {
            return $item->pengembalian?->total_denda ?? 0;
        });

        return Pdf::loadView(
            'admin.laporan.laporan-transaksi',
            compact(
                'data',
                'totalPeminjaman',
                'totalDikembalikan',
                'totalTerlambat',
                'totalMasihDipinjam',
                'totalDenda'
            )
        )->download('laporan-transaksi.pdf');
    }

    private function exportReservasi(Request $request)
    {
        $query = Reservasi::with([
            'anggota',
            'buku'
        ]);

        if ($request->jenis_filter === 'periode') {

            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date',
            ]);

            $query->whereBetween(
                'tanggal_diajukan',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $data = $query->get();

        $totalReservasi = $data->count();
        $totalMenungguKonfirmasi = $data->where('status', 'Menunggu Konfirmasi')->count();
        $totalMenungguAntrian = $data->where('status', 'Menunggu Antrian')->count();
        $totalSiapDiambil = $data->where('status', 'Siap Diambil')->count();
        $totalSelesai = $data->where('status', 'Selesai')->count();
        $totalDitolak = $data->where('status', 'Ditolak')->count();
        $totalKadaluarsa = $data->where('status', 'Kadaluarsa')->count();
        $totalDibatalkan = $data->where('status', 'Dibatalkan')->count();

        return Pdf::loadView(
            'admin.laporan.laporan-reservasi',
            compact(
                'data',
                'totalReservasi',
                'totalMenungguKonfirmasi',
                'totalMenungguAntrian',
                'totalSiapDiambil',
                'totalSelesai',
                'totalDitolak',
                'totalKadaluarsa',
                'totalDibatalkan'

            )
        )->download('laporan-reservasi.pdf');
    }
    private function exportAnggota(Request $request)
    {

        $query = Anggota::with([
            'jenisKeanggotaan',
        ]);

        if ($request->jenis_filter === 'periode') {

            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date',
            ]);

            $query->whereBetween(
                'tanggal_dibuat',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $data = $query->get();

        $totalAnggota = $data->count();

        // Verifikasi
        $totalMenunggu = $data->where('verifikasi_admin', 'Menunggu')->count();
        $totalTerverifikasi = $data->where('verifikasi_admin', 'Terverifikasi')->count();
        $totalDitolak = $data->where('verifikasi_admin', 'Ditolak')->count();

        // Status anggota
        $totalAktif = $data->where('status_anggota', 'Aktif')->count();
        $totalTidakAktif = $data->where('status_anggota', 'Tidak Aktif')->count();

        $anggotaPerJenis = $data->groupBy('jenisKeanggotaan.nama_jenis');
        return Pdf::loadView(
            'admin.laporan.laporan-anggota',
            compact(
                'data',
                'totalAnggota',
                'totalMenunggu',
                'totalTerverifikasi',
                'totalDitolak',
                'totalAktif',
                'totalTidakAktif',
                'anggotaPerJenis',
            )
        )->download('laporan-anggota.pdf');
    }
    private function exportBuku(Request $request)
    {
        $query = Buku::with([
            'penulis',
            'penerbit',
            'tipe',
            'items'
        ]);

        if ($request->jenis_filter === 'periode') {

            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date',
            ]);

            $query->whereBetween(
                'tanggal_dibuat',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );
        }

        $data = $query->get();

        // Statistik Koleksi
        $totalJudul = $data->count();

        $totalEksemplar = $data->sum(function ($buku) {
            return $buku->items->count();
        });

        $totalTersedia = $data->sum(function ($buku) {
            return $buku->items
                ->where('status_item', 'Tersedia')
                ->count();
        });

        $totalDipinjam = $data->sum(function ($buku) {
            return $buku->items
                ->where('status_item', 'Sedang Dipinjam')
                ->count();
        });

        $totalDipesan = $data->sum(function ($buku) {
            return $buku->items
                ->where('status_item', 'Dipesan')
                ->count();
        });

        // Distribusi berdasarkan tipe koleksi
        $koleksiPerTipe = $data->groupBy('tipe.nama_tipe');

        return Pdf::loadView(
            'admin.laporan.laporan-buku',
            compact(
                'data',
                'totalJudul',
                'totalEksemplar',
                'totalTersedia',
                'totalDipinjam',
                'totalDipesan',
                'koleksiPerTipe'
            )
        )->download('laporan-koleksi-buku.pdf');
    }
}
