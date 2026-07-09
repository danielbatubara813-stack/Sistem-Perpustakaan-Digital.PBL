<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Admin\Peminjaman\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    private function getProfileData(): array
    {
        $user = Anggota::find(Auth::guard('web')->id());

        $totalPeminjaman = Peminjaman::where('id_anggota', $user->id_anggota)->count();

        $totalJudul = Peminjaman::where('id_anggota', $user->id_anggota)
            ->distinct('id_item')
            ->count('id_item');

        return compact('user', 'totalPeminjaman', 'totalJudul');
    }

    private function formatPeminjaman(Peminjaman $p): array
    {
        $jatuhTempo = Carbon::parse($p->tanggal_jatuh_tempo);

        // Tentukan status berdasarkan field status di DB dan tanggal
        if ($p->status === 'Dikembalikan') {
            $status = 'Dikembalikan';
        } elseif ($jatuhTempo->isPast()) {
            $status = 'Jatuh Tempo';
        } else {
            $status = 'Masa Peminjaman';
        }

        // Ambil buku melalui relasi itemBuku -> buku
        $buku = $p->itemBuku?->buku ?? null;

        // Gabungkan semua nama penulis
        $penulis = $buku
            ? $buku->penulis->pluck('nama_penulis')->join(', ')
            : '-';

        // Cover disimpan di storage/covers/
        $cover = ($buku && $buku->cover_buku)
            ? asset('storage/covers/' . $buku->cover_buku)
            : asset('image/bookcover.png');

        return [
            'id' => $buku?->id_buku ?? $p->id_item,
            'judul' => $buku?->judul_buku ?? '-',
            'penulis' => $penulis ?: '-',
            'cover' => $cover,
            'edisi' => $buku?->edisi ?? '-',
            'isbn' => $buku?->isbn ?? '-',
            'no_panggil' => $buku?->no_panggil ?? '-',
            'kode_item_buku' => $p->id_item,
            'tanggal_peminjaman' => $p->tanggal_peminjaman,
            'tanggal_jatuh_tempo' => $p->tanggal_jatuh_tempo,
            'status_peminjaman' => $status,
        ];
    }

    public function peminjamanSekarangPage()
    {
        $user = Auth::guard('web')->user();

        $peminjaman = Peminjaman::where('id_anggota', $user->id_anggota)
            ->where('status', 'Dipinjam')
            ->with([
                'itemBuku.buku.penulis',
            ])
            ->orderBy('tanggal_jatuh_tempo')
            ->get();

        return view('profile.peminjaman-sekarang', $this->getProfileData())
            ->with('peminjaman', $peminjaman)
            ->with('totalAktif', $peminjaman->count());
    }

    public function perpanjang(Request $request, string $kodePeminjaman)
    {
        $user = Auth::guard('web')->user();

        $milikAnggota = Peminjaman::where('kode_peminjaman', $kodePeminjaman)
            ->where('id_anggota', $user->id_anggota)
            ->exists();

        if (! $milikAnggota) {
            return redirect()
                ->back()
                ->with('error', 'Data peminjaman tidak ditemukan.');
        }

        return app(AdminPeminjamanController::class)->perpanjang($request, $kodePeminjaman);
    }

    public function sejarahPeminjamanPage()
    {
        $user = Auth::guard('web')->user();

        $peminjaman = Peminjaman::where('id_anggota', $user->id_anggota)
            ->with([
                'itemBuku.buku.penulis',
            ])
            ->orderByDesc('tanggal_peminjaman')
            ->get();

        return view('profile.sejarah-peminjaman', $this->getProfileData())
            ->with('peminjaman', $peminjaman);
    }
}
