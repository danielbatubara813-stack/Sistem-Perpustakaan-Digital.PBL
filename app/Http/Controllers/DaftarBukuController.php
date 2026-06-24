<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DokBahasa;
use App\Models\Penerbit;
use App\Models\Subjek;
use App\Models\TipeKoleksi;
use Illuminate\Http\Request;

class DaftarBukuController extends Controller
{
    public function cariBukuPage(Request $request)
    {
        $tahunRange = $this->publicationYearRange();
        $selectedYears = $this->selectedPublicationYears($request, $tahunRange);

        $query = Buku::with(['penulis', 'penerbit', 'tipe', 'bahasa', 'items', 'subjek']);
        $this->applyFilters($query, $request, $selectedYears);

        $sort = $request->input('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->orderBy('tanggal_dibuat', 'asc'),
            'judul-az' => $query->orderBy('judul_buku', 'asc'),
            'judul-za' => $query->orderBy('judul_buku', 'desc'),
            default => $query->orderBy('tanggal_dibuat', 'desc'),
        };

        $koleksi_baru = $query->paginate(12)->withQueryString()->through(
            fn($buku) => $this->formatBook($buku)
        );

        return view('cari-buku', [
            'koleksi_baru' => $koleksi_baru,
            'selectedFilters' => $this->selectedFilters($request, $sort, $selectedYears),
            'tahunRange' => $tahunRange,
            'tipeList' => TipeKoleksi::orderBy('nama_tipe')->get(),
            'subjekList' => Subjek::orderBy('nama_subjek')->get(),
            'penerbitList' => Penerbit::orderBy('nama_penerbit')->get(),
            'bahasaList' => DokBahasa::orderBy('nama_bahasa')->get(),
        ]);
    }

    public function detailBukuPage($id_buku)
    {
        $buku = Buku::with(['penulis', 'penerbit', 'tipe', 'bahasa', 'items', 'subjek'])
            ->findOrFail($id_buku);

        $bukuData = array_merge($this->formatBook($buku), [
            'penulis' => $buku->penulis->pluck('nama_penulis')->filter()->values()->all(),
            'subjek' => $buku->subjek->pluck('nama_subjek')->filter()->values()->all(),
            'no_rak' => $buku->no_rak ?? '-',
            'tanggal_terbit' => $buku->tanggal_terbit
                ? date('d M Y', strtotime($buku->tanggal_terbit))
                : '-',
            'items' => $buku->items->map(fn($item) => [
                'id' => $item->id_item,
                'status' => $item->status_item,
            ])->values()->all(),
        ]);

        $subjectIds = $buku->subjek->pluck('id_subjek')->all();
        $rekomendasi = Buku::with(['penulis', 'penerbit', 'tipe', 'bahasa', 'items', 'subjek'])
            ->whereKeyNot($buku->id_buku)
            ->where(function ($query) use ($buku, $subjectIds) {
                $query->where('id_tipe', $buku->id_tipe);

                if (!empty($subjectIds)) {
                    $query->orWhereHas('subjek', fn($q) => $q->whereIn('subjek.id_subjek', $subjectIds));
                }
            })
            ->latest('tanggal_dibuat')
            ->limit(6)
            ->get()
            ->map(fn($item) => $this->formatBook($item));

        return view('detail-buku', compact('bukuData', 'rekomendasi'));
    }

    private function applyFilters($query, Request $request, array $selectedYears): void
    {
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('no_panggil', 'like', "%{$search}%")
                    ->orWhereHas('penulis', fn($penulis) => $penulis->where('nama_penulis', 'like', "%{$search}%"))
                    ->orWhereHas('penerbit', fn($penerbit) => $penerbit->where('nama_penerbit', 'like', "%{$search}%"))
                    ->orWhereHas('subjek', fn($subjek) => $subjek->where('nama_subjek', 'like', "%{$search}%"));
            });
        }

        $query->whereBetween('tanggal_terbit', [
            $selectedYears['from'] . '-01-01',
            $selectedYears['to'] . '-12-31',
        ]);

        if ($request->filled('tipe')) {
            $query->whereIn('id_tipe', (array) $request->input('tipe'));
        }

        if ($request->filled('subjek')) {
            $query->whereHas('subjek', fn($q) => $q->whereIn('subjek.id_subjek', (array) $request->input('subjek')));
        }

        if ($request->filled('penerbit')) {
            $query->whereIn('id_penerbit', (array) $request->input('penerbit'));
        }

        if ($request->filled('bahasa')) {
            $query->whereIn('kode_bahasa', (array) $request->input('bahasa'));
        }

        if ($request->input('ketersediaan') === 'tersedia') {
            $query->whereHas('items', fn($q) => $q->where('status_item', 'Tersedia'));
        }

        if ($request->input('ketersediaan') === 'tidak-tersedia') {
            $query->whereDoesntHave('items', fn($q) => $q->where('status_item', 'Tersedia'));
        }
    }

    private function selectedFilters(Request $request, string $sort, array $selectedYears): array
    {
        return [
            'search' => $request->input('search', ''),
            'tipe' => (array) $request->input('tipe', []),
            'subjek' => (array) $request->input('subjek', []),
            'penerbit' => (array) $request->input('penerbit', []),
            'bahasa' => (array) $request->input('bahasa', []),
            'ketersediaan' => $request->input('ketersediaan', ''),
            'dari_tahun' => $selectedYears['from'],
            'ke_tahun' => $selectedYears['to'],
            'sort' => $sort,
        ];
    }

    private function publicationYearRange(): array
    {
        $range = Buku::query()
            ->selectRaw('MIN(tanggal_terbit) as min_date, MAX(tanggal_terbit) as max_date')
            ->first();

        $minYear = $range?->min_date ? (int) date('Y', strtotime($range->min_date)) : 1950;
        $maxYear = $range?->max_date ? (int) date('Y', strtotime($range->max_date)) : (int) date('Y');

        if ($minYear > $maxYear) {
            [$minYear, $maxYear] = [$maxYear, $minYear];
        }

        return [
            'min' => $minYear,
            'max' => $maxYear,
        ];
    }

    private function selectedPublicationYears(Request $request, array $tahunRange): array
    {
        $from = (int) $request->input('dari-tahun', $tahunRange['min']);
        $to = (int) $request->input('ke-tahun', $tahunRange['max']);

        $from = max($tahunRange['min'], min($from, $tahunRange['max']));
        $to = max($tahunRange['min'], min($to, $tahunRange['max']));

        if ($from > $to) {
            [$from, $to] = [$to, $from];
        }

        return [
            'from' => $from,
            'to' => $to,
        ];
    }

    private function formatBook(Buku $buku): array
    {
        return [
            'id' => $buku->id_buku,
            'judul' => $buku->judul_buku,
            'penulis' => $buku->penulis->pluck('nama_penulis')->filter()->join(', ') ?: '-',
            'cover' => $buku->cover_buku
                ? asset('storage/covers/' . $buku->cover_buku)
                : asset('images/bookcover.png'),
            'isbn' => $buku->isbn ?? '-',
            'edisi' => $buku->edisi ?? '-',
            'penerbit' => $buku->penerbit->nama_penerbit ?? '-',
            'no_panggil' => $buku->no_panggil ?? '-',
            'deskripsi' => $buku->deskripsi ?? '-',
            'tipe' => $buku->tipe->nama_tipe ?? '-',
            'bahasa' => $buku->bahasa->nama_bahasa ?? '-',
            'subjek' => $buku->subjek->pluck('nama_subjek')->filter()->join(', ') ?: '-',
            'ketersediaan' => $buku->items->where('status_item', 'Tersedia')->count(),
            'total_item' => $buku->items->count(),
        ];
    }
}

