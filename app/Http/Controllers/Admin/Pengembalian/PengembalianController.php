<?php

namespace App\Http\Controllers\Admin\Pengembalian;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::with([
            'peminjaman.anggota',
            'peminjaman.itemBuku.buku'
        ]);

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('peminjaman.anggota', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")->orWhere('nomor_identitas', 'like', "%{$search}%");
            })->orWhereHas('peminjaman.itemBuku.buku', function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status_pengembalian', $request->status);
        }

        // Filter Tanggal
        if ($request->tanggal == 'hari_ini') {
            $query->whereDate('tanggal_pengembalian', today());
        } elseif ($request->tanggal == '7_hari') {
            $query->where('tanggal_pengembalian', '>=', now()->subDays(7));
        } elseif ($request->tanggal == '30_hari') {
            $query->where('tanggal_pengembalian', '>=', now()->subDays(30));
        }

        // Sort
        if ($request->sort == 'terlama') {
            $query->orderBy('tanggal_pengembalian', 'asc');
        } else {
            $query->orderBy('tanggal_pengembalian', 'desc');
        }

        $pengembalian = $query
            ->paginate(10)
            ->withQueryString();
        return view(
            'admin.pengembalian.pengembalian',
            compact('pengembalian')
        );
    }
}
