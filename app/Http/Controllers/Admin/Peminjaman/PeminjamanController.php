<?php

namespace App\Http\Controllers\Admin\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\AturanPeminjaman;
use App\Models\ItemBuku;
use App\Models\JenisKeanggotaan;
use App\Models\Peminjaman;
use App\Models\TipeKoleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PeminjamanController extends Controller
{
    private const PERIODE_PERPANJANGAN_HARI = 7;

    public function ambilDataLoan(Request $request)
    {
        $query = Peminjaman::with([
            'anggota',
            'itemBuku.buku.penulis'
        ])
            ->where('status', 'Dipinjam');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('anggota', function ($query) use ($search) {
                $query
                    ->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nomor_identitas', 'like', '%' . $search . '%');
            });
        }

        $this->terapkanFilterTanggal(
            $query,
            'tanggal_peminjaman',
            $request->input('tanggal')
        );

        $jatuhTempo = $this->normalisasiFilter($request->input('jatuh_tempo'));

        if (in_array($jatuhTempo, ['jatuh_tempo', 'sudah_jatuh_tempo'], true)) {
            $query->whereDate('tanggal_jatuh_tempo', '<=', Carbon::today());
        } elseif ($jatuhTempo === 'belum_jatuh_tempo') {
            $query->whereDate('tanggal_jatuh_tempo', '>', Carbon::today());
        }

        $arahUrutan = $this->normalisasiFilter($request->input('sort')) === 'terlama'
            ? 'asc'
            : 'desc';

        $query
            ->orderBy('tanggal_peminjaman', $arahUrutan)
            ->orderBy('tanggal_dibuat', $arahUrutan)
            ->orderBy('kode_peminjaman', $arahUrutan);

        return $query
            ->paginate(10)
            ->withQueryString();
    }

    public function ambilDataRules(Request $request)
    {
        $query = AturanPeminjaman::with([
            'jenisKeanggotaan',
            'tipeKoleksi',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query
                    ->whereHas('jenisKeanggotaan', function ($query) use ($search) {
                        $query->where('nama_jenis', 'like', '%' . $search . '%');
                    });
            });
        }

        $this->terapkanFilterTanggal(
            $query,
            'tanggal_dibuat',
            $request->input('tanggal')
        );

        $arahUrutan = $this->normalisasiFilter($request->input('sort')) === 'terlama'
            ? 'asc'
            : 'desc';

        $query
            ->orderBy('tanggal_dibuat', $arahUrutan)
            ->orderBy('id_aturan', $arahUrutan);

        return $query
            ->paginate(10)
            ->withQueryString();
    }

    public function index(Request $request)
    {
        $loans = $this->ambilDataLoan($request);

        $title = 'Peminjaman';

        $description = 'Kelola daftar peminjaman buku';

        return view(
            'admin.peminjaman.peminjaman',
            compact('title', 'description', 'loans')
        );
    }

    public function aturan(Request $request)
    {
        $title = 'Aturan Peminjaman';

        $description =
            'Aturan peminjaman untuk tiap tipe keanggotaan dan koleksi';

        $rules = $this->ambilDataRules($request);

        return view(
            'admin.peminjaman.aturan',
            compact('title', 'description', 'rules')
        );
    }

    public function catatPeminjaman(Request $request)
    {
        $title = 'Peminjaman';

        $description = 'Kelola daftar peminjaman buku dan catat peminjaman baru.';

        $anggota = null;

        $itemBuku = null;

        $memberLoans = collect();

        $aturanPerpanjangan = collect();

        $anggotaMemilikiDenda = false;

        $pesanDendaAnggota = null;

        $loanPreview = null;

        $anggotaNotFound = false;

        $itemNotFound = false;

        if ($request->filled('nomor_identitas')) {
            $anggota = Anggota::with('jenisKeanggotaan')
                ->where('nomor_identitas', $request->nomor_identitas)
                ->first();

            $anggotaNotFound = !$anggota;

            if ($anggota) {
                $memberLoans = Peminjaman::with('itemBuku.buku.penulis')
                    ->where('id_anggota', $anggota->id_anggota)
                    ->where('status', 'Dipinjam')
                    ->orderByDesc('tanggal_peminjaman')
                    ->get();

                $pesanDendaAnggota = $this->pesanDendaAnggota($anggota);

                $anggotaMemilikiDenda = $pesanDendaAnggota !== null;

                $aturanPerpanjangan = $memberLoans->mapWithKeys(function ($loan) use ($pesanDendaAnggota) {
                    return [
                        $loan->kode_peminjaman => $this->statusPerpanjangan($loan, $pesanDendaAnggota),
                    ];
                });
            }
        }

        if ($request->filled('id_item')) {
            $itemBuku = ItemBuku::with([
                'buku.penulis',
                'buku.tipe'
            ])
                ->where('id_item', $request->id_item)
                ->first();

            $itemNotFound = !$itemBuku;
        }

        if ($anggota && $itemBuku) {
            $tanggalPeminjaman = Carbon::today();

            $aturanPeminjaman = $this->ambilAturanPeminjaman(
                $anggota,
                $itemBuku
            );

            $periodePeminjaman = (int) ($aturanPeminjaman?->periode_peminjaman ?: 7);
            $batasPeminjaman = (int) ($aturanPeminjaman?->batas_peminjaman ?? 2);
            $jumlahPeminjamanAktif = $this->jumlahPeminjamanAktifSesuaiAturan(
                $anggota,
                $itemBuku,
                $aturanPeminjaman
            );

            $loanPreview = [
                'tanggal_peminjaman' => $tanggalPeminjaman,
                'tanggal_jatuh_tempo' => $tanggalPeminjaman
                    ->copy()
                    ->addDays($periodePeminjaman),
                'periode_peminjaman' => $periodePeminjaman,
                'batas_peminjaman' => $batasPeminjaman,
                'jumlah_peminjaman_aktif' => $jumlahPeminjamanAktif,
                'peminjaman_ditutup' => $batasPeminjaman === 0,
                'maksimal_tercapai' => $jumlahPeminjamanAktif >= $batasPeminjaman,
            ];
        }

        return view(
            'admin.peminjaman.catat-peminjaman',
            compact(
                'title',
                'description',
                'anggota',
                'itemBuku',
                'memberLoans',
                'aturanPerpanjangan',
                'anggotaMemilikiDenda',
                'pesanDendaAnggota',
                'loanPreview',
                'anggotaNotFound',
                'itemNotFound'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_identitas' => [
                'required',
                'exists:anggota,nomor_identitas'
            ],
            'id_item' => [
                'required',
                'exists:item_buku,id_item'
            ],
        ], [
            'nomor_identitas.required' => 'ID anggota wajib diisi.',
            'nomor_identitas.exists' => 'ID anggota tidak ditemukan.',
            'id_item.required' => 'Kode item buku wajib diisi.',
            'id_item.exists' => 'Kode item buku tidak ditemukan.',
        ]);

        DB::transaction(function () use ($validated) {
            $anggota = Anggota::where(
                'nomor_identitas',
                $validated['nomor_identitas']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $itemBuku = ItemBuku::with('buku')
                ->where('id_item', $validated['id_item'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($itemBuku->status_item !== 'Tersedia') {
                throw ValidationException::withMessages([
                    'id_item' => 'Item buku ini tidak tersedia untuk dipinjam.',
                ]);
            }

            $sedangDipinjam = Peminjaman::where(
                'id_item',
                $itemBuku->id_item
            )
                ->where('status', 'Dipinjam')
                ->exists();

            if ($sedangDipinjam) {
                throw ValidationException::withMessages([
                    'id_item' => 'Item buku ini masih tercatat sedang dipinjam.',
                ]);
            }

            $tanggalPeminjaman = Carbon::today();

            $aturanPeminjaman = $this->ambilAturanPeminjaman($anggota, $itemBuku);

            $hariIni = Carbon::today();


            $terlambat = Peminjaman::where('id_anggota', $anggota->id_anggota)
                ->where('status', 'Dipinjam')
                ->whereDate('tanggal_jatuh_tempo', '<', $hariIni)
                ->exists();

            if ($terlambat) {
                throw ValidationException::withMessages([
                    'id_item' => 'Anggota memiliki peminjaman yang sudah melewati batas pengembalian. Silakan kembalikan buku terlebih dahulu.',
                ]);
            }

            $periodePeminjaman = (int) ($aturanPeminjaman?->periode_peminjaman ?: 7);
            $batasPeminjaman = (int) ($aturanPeminjaman?->batas_peminjaman ?? 2);
            $jumlahPeminjamanAktif = $this->jumlahPeminjamanAktifSesuaiAturan($anggota, $itemBuku, $aturanPeminjaman);

            if ($batasPeminjaman === 0) {
                throw ValidationException::withMessages([
                    'id_item' => 'Buku dengan tipe koleksi ini tidak boleh dipinjam berdasarkan aturan peminjaman.',
                ]);
            }

            if ($jumlahPeminjamanAktif >= $batasPeminjaman) {
                throw ValidationException::withMessages([
                    'id_item' => 'Anggota sudah mencapai maksimal peminjaman untuk aturan ini.',
                ]);
            }

            Peminjaman::create([
                'kode_peminjaman' => $this->buatKodePeminjaman(),
                'id_anggota' => $anggota->id_anggota,
                'id_item' => $itemBuku->id_item,
                'tanggal_peminjaman' => $tanggalPeminjaman->toDateString(),
                'tanggal_jatuh_tempo' => $tanggalPeminjaman
                    ->copy()
                    ->addDays($periodePeminjaman)
                    ->toDateString(),
                'status' => 'Dipinjam',
            ]);

            $itemBuku->update([
                'status_item' => 'Dipinjam',
            ]);
        });

        return redirect()
            ->route('admin.peminjaman')
            ->with('success', 'Data peminjaman berhasil disimpan.');
    }

    public function perpanjang(Request $request, string $kodePeminjaman)
    {
        $pesanSukses = null;

        try {
            DB::transaction(function () use ($kodePeminjaman, &$pesanSukses) {
                $peminjaman = Peminjaman::where('kode_peminjaman', $kodePeminjaman)
                    ->lockForUpdate()
                    ->first();

                if (!$peminjaman) {
                    throw ValidationException::withMessages([
                        'kode_peminjaman' => 'Data peminjaman tidak ditemukan.',
                    ]);
                }

                $peminjaman->load(['anggota', 'itemBuku.buku']);

                if (!$peminjaman->anggota) {
                    throw ValidationException::withMessages([
                        'kode_peminjaman' => 'Data anggota pada peminjaman ini tidak ditemukan.',
                    ]);
                }

                $statusPerpanjangan = $this->statusPerpanjangan(
                    $peminjaman,
                    $this->pesanDendaAnggota($peminjaman->anggota)
                );

                if (!$statusPerpanjangan['boleh']) {
                    throw ValidationException::withMessages([
                        'kode_peminjaman' => $statusPerpanjangan['pesan'],
                    ]);
                }

                $tanggalJatuhTempoBaru = Carbon::parse($peminjaman->tanggal_jatuh_tempo)
                    ->startOfDay()
                    ->addDays(self::PERIODE_PERPANJANGAN_HARI);

                $peminjaman->update([
                    'tanggal_jatuh_tempo' => $tanggalJatuhTempoBaru->toDateString(),
                    'tanggal_perpanjangan' => Carbon::today()->toDateString(),
                ]);

                $judulBuku = $peminjaman->itemBuku?->buku?->judul_buku ?? $peminjaman->id_item;

                $pesanSukses = 'Perpanjangan buku "' . $judulBuku . '" berhasil selama '
                    . self::PERIODE_PERPANJANGAN_HARI . ' hari. Tanggal jatuh tempo baru: '
                    . $tanggalJatuhTempoBaru->format('d-m-Y') . '.';
            });
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->with('error', collect($e->errors())->flatten()->implode(' '));
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Perpanjangan gagal diproses. Silakan coba lagi.');
        }

        return redirect()
            ->back()
            ->with('success', $pesanSukses);
    }

    public function aturanCreate()
    {
        [$jenisKeanggotaan, $tipeKoleksi] = $this->ambilPilihanAturan();

        $rule = new AturanPeminjaman();

        return view(
            'admin.peminjaman.form-aturan-peminjaman',
            compact('jenisKeanggotaan', 'tipeKoleksi', 'rule')
        );
    }

    public function aturanStore(Request $request)
    {
        AturanPeminjaman::create($this->validasiAturan($request));

        return redirect()
            ->route('admin.peminjaman.aturan')
            ->with('success', 'Aturan peminjaman berhasil ditambahkan.');
    }

    public function aturanEdit($id)
    {
        $rule = AturanPeminjaman::findOrFail($id);

        [$jenisKeanggotaan, $tipeKoleksi] = $this->ambilPilihanAturan();

        return view(
            'admin.peminjaman.form-aturan-peminjaman',
            compact('jenisKeanggotaan', 'tipeKoleksi', 'rule')
        );
    }

    public function aturanUpdate(Request $request, $id)
    {
        $rule = AturanPeminjaman::findOrFail($id);

        $rule->update($this->validasiAturan($request, $rule));

        return redirect()
            ->route('admin.peminjaman.aturan')
            ->with('success', 'Aturan peminjaman berhasil diperbarui.');
    }

    public function aturanDestroy($id)
    {
        AturanPeminjaman::findOrFail($id)->delete();

        return redirect()
            ->route('admin.peminjaman.aturan')
            ->with('success', 'Aturan peminjaman berhasil dihapus.');
    }

    public function aturanDestroyMultiple(Request $request)
    {
        $ids = $request->input('id_aturan', []);

        if (!is_array($ids) || !count($ids)) {
            return redirect()
                ->back()
                ->with('error', 'Pilih minimal satu aturan peminjaman.');
        }

        AturanPeminjaman::whereIn('id_aturan', $ids)->delete();

        return redirect()
            ->back()
            ->with('success', count($ids) . ' aturan peminjaman berhasil dihapus.');
    }

    private function statusPerpanjangan(Peminjaman $peminjaman, ?string $pesanDendaAnggota): array
    {
        $tanggalHariIni = Carbon::today();
        $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();
        $hariMenujuJatuhTempo = (int) $tanggalHariIni->diffInDays($tanggalJatuhTempo, false);
        $tanggalJatuhTempoBaru = $tanggalJatuhTempo
            ->copy()
            ->addDays(self::PERIODE_PERPANJANGAN_HARI);
        $tanggalPerpanjangan = $peminjaman->tanggal_perpanjangan
            ? Carbon::parse($peminjaman->tanggal_perpanjangan)->format('d-m-Y')
            : null;

        if ($peminjaman->status !== 'Dipinjam') {
            return [
                'boleh' => false,
                'kode' => 'status_tidak_aktif',
                'pesan' => 'Perpanjangan ditolak. Status peminjaman saat ini "' . $peminjaman->status
                    . '"; hanya peminjaman aktif dengan status Dipinjam yang dapat diperpanjang.',
                'tanggal_jatuh_tempo_baru' => $tanggalJatuhTempoBaru,
                'hari_menuju_jatuh_tempo' => $hariMenujuJatuhTempo,
            ];
        }

        if ($tanggalPerpanjangan) {
            return [
                'boleh' => false,
                'kode' => 'sudah_diperpanjang',
                'pesan' => 'Perpanjangan tidak tersedia. Item buku ini sudah pernah diperpanjang pada '
                    . $tanggalPerpanjangan . '; setiap peminjaman satu item buku hanya dapat diperpanjang satu kali.',
                'tanggal_jatuh_tempo_baru' => $tanggalJatuhTempoBaru,
                'hari_menuju_jatuh_tempo' => $hariMenujuJatuhTempo,
            ];
        }

        if ($pesanDendaAnggota !== null) {
            return [
                'boleh' => false,
                'kode' => 'anggota_memiliki_denda',
                'pesan' => $pesanDendaAnggota,
                'tanggal_jatuh_tempo_baru' => $tanggalJatuhTempoBaru,
                'hari_menuju_jatuh_tempo' => $hariMenujuJatuhTempo,
            ];
        }

        if ($hariMenujuJatuhTempo < 1) {
            return [
                'boleh' => false,
                'kode' => $hariMenujuJatuhTempo < 0 ? 'lewat_jatuh_tempo' : 'hari_jatuh_tempo',
                'pesan' => $hariMenujuJatuhTempo < 0
                    ? 'Perpanjangan ditolak. Buku sudah melewati tanggal jatuh tempo '
                        . $tanggalJatuhTempo->format('d-m-Y') . ' selama '
                        . abs($hariMenujuJatuhTempo) . ' hari; perpanjangan hanya dapat dilakukan 1 atau 2 hari sebelum jatuh tempo.'
                    : 'Perpanjangan ditolak. Hari ini adalah tanggal jatuh tempo '
                        . $tanggalJatuhTempo->format('d-m-Y') . '; perpanjangan harus dilakukan 1 atau 2 hari sebelum jatuh tempo.',
                'tanggal_jatuh_tempo_baru' => $tanggalJatuhTempoBaru,
                'hari_menuju_jatuh_tempo' => $hariMenujuJatuhTempo,
            ];
        }

        if ($hariMenujuJatuhTempo > 2) {
            return [
                'boleh' => false,
                'kode' => 'terlalu_awal',
                'pesan' => 'Perpanjangan ditolak. Perpanjangan hanya dapat dilakukan 1 atau 2 hari sebelum jatuh tempo. Hari ini '
                    . $tanggalHariIni->format('d-m-Y') . ', jatuh tempo '
                    . $tanggalJatuhTempo->format('d-m-Y') . ', sisa '
                    . $hariMenujuJatuhTempo . ' hari.',
                'tanggal_jatuh_tempo_baru' => $tanggalJatuhTempoBaru,
                'hari_menuju_jatuh_tempo' => $hariMenujuJatuhTempo,
            ];
        }

        return [
            'boleh' => true,
            'kode' => 'boleh',
            'pesan' => 'Dapat diperpanjang selama ' . self::PERIODE_PERPANJANGAN_HARI
                . ' hari sampai ' . $tanggalJatuhTempoBaru->format('d-m-Y') . '.',
            'tanggal_jatuh_tempo_baru' => $tanggalJatuhTempoBaru,
            'hari_menuju_jatuh_tempo' => $hariMenujuJatuhTempo,
        ];
    }

    private function anggotaMemilikiDenda(Anggota $anggota): bool
    {
        return $this->pesanDendaAnggota($anggota) !== null;
    }

    private function pesanDendaAnggota(Anggota $anggota): ?string
    {
        $pengembalianDenda = DB::table('pengembalian')
            ->join('peminjaman', 'pengembalian.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
            ->where('peminjaman.id_anggota', $anggota->id_anggota)
            ->where('pengembalian.total_denda', '>', 0)
            ->orderByDesc('pengembalian.tanggal_pengembalian')
            ->select([
                'pengembalian.total_denda',
                'pengembalian.tanggal_pengembalian',
                'peminjaman.kode_peminjaman',
                'peminjaman.id_item',
            ])
            ->first();

        if ($pengembalianDenda) {
            return 'Perpanjangan ditolak karena anggota masih memiliki denda Rp '
                . number_format((int) $pengembalianDenda->total_denda, 0, ',', '.')
                . ' pada peminjaman ' . $pengembalianDenda->kode_peminjaman
                . ' (item ' . $pengembalianDenda->id_item . ', tanggal pengembalian '
                . Carbon::parse($pengembalianDenda->tanggal_pengembalian)->format('d-m-Y')
                . '). Selesaikan denda terlebih dahulu.';
        }

        $peminjamanTerlambat = Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('status', 'Dipinjam')
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->orderBy('tanggal_jatuh_tempo')
            ->first();

        if (!$peminjamanTerlambat) {
            return null;
        }

        $tanggalJatuhTempo = Carbon::parse($peminjamanTerlambat->tanggal_jatuh_tempo)->startOfDay();
        $hariTerlambat = (int) $tanggalJatuhTempo->diffInDays(Carbon::today(), false);

        return 'Perpanjangan ditolak karena anggota memiliki peminjaman terlambat '
            . $peminjamanTerlambat->kode_peminjaman . ' (item '
            . $peminjamanTerlambat->id_item . ') yang jatuh tempo pada '
            . $tanggalJatuhTempo->format('d-m-Y') . ' dan sudah terlambat '
            . $hariTerlambat . ' hari. Kembalikan buku atau selesaikan denda terlebih dahulu.';
    }

    private function ambilPeriodePeminjaman(Anggota $anggota, ItemBuku $itemBuku): int
    {
        $aturan = $this->ambilAturanPeminjaman($anggota, $itemBuku);

        return (int) ($aturan?->periode_peminjaman ?: 7);
    }

    private function jumlahPeminjamanAktifSesuaiAturan(
        Anggota $anggota,
        ItemBuku $itemBuku,
        ?AturanPeminjaman $aturan
    ): int {
        $query = Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('status', 'Dipinjam');

        if ($aturan?->id_tipe) {
            $query->whereHas('itemBuku.buku', function ($query) use ($aturan) {
                $query->where('id_tipe', $aturan->id_tipe);
            });
        }

        return $query->count();
    }

    private function ambilAturanPeminjaman(Anggota $anggota, ItemBuku $itemBuku): ?AturanPeminjaman
    {
        $idTipe = $itemBuku->buku?->id_tipe;

        return AturanPeminjaman::where(function ($query) use ($anggota) {
            $query
                ->where('id_jenis', $anggota->id_jenis)
                ->orWhereNull('id_jenis');
        })
            ->where(function ($query) use ($idTipe) {
                $query
                    ->where('id_tipe', $idTipe)
                    ->orWhereNull('id_tipe');
            })
            ->orderByRaw('CASE WHEN id_tipe IS NULL THEN 1 ELSE 0 END')
            ->orderByRaw('CASE WHEN id_jenis IS NULL THEN 1 ELSE 0 END')
            ->first();
    }

    private function ambilPilihanAturan(): array
    {
        return [
            JenisKeanggotaan::orderBy('nama_jenis')->get(),
            TipeKoleksi::orderBy('nama_tipe')->get(),
        ];
    }

    private function validasiAturan(Request $request, ?AturanPeminjaman $rule = null): array
    {
        $request->merge([
            'id_jenis' => $request->filled('id_jenis') ? $request->input('id_jenis') : null,
            'id_tipe' => $request->filled('id_tipe') ? $request->input('id_tipe') : null,
        ]);

        $validated = $request->validate([
            'id_jenis' => [
                'nullable',
                'integer',
                'exists:jenis_keanggotaan,id_jenis',
            ],
            'id_tipe' => [
                'nullable',
                'integer',
                'exists:tipe_koleksi,id_tipe',
            ],
            'batas_peminjaman' => [
                'required',
                'integer',
                'min:0',
                'max:255',
            ],
            'periode_peminjaman' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],
        ], [], [
            'id_jenis' => 'tipe keanggotaan',
            'id_tipe' => 'tipe koleksi',
            'batas_peminjaman' => 'maksimal peminjaman',
            'periode_peminjaman' => 'periode peminjaman',
        ]);

        $duplicateRule = AturanPeminjaman::query();

        if ($validated['id_jenis'] === null) {
            $duplicateRule->whereNull('id_jenis');
        } else {
            $duplicateRule->where('id_jenis', $validated['id_jenis']);
        }

        if ($validated['id_tipe'] === null) {
            $duplicateRule->whereNull('id_tipe');
        } else {
            $duplicateRule->where('id_tipe', $validated['id_tipe']);
        }

        if ($rule && $rule->exists) {
            $duplicateRule->where('id_aturan', '!=', $rule->id_aturan);
        }

        if ($duplicateRule->exists()) {
            throw ValidationException::withMessages([
                'id_jenis' => 'Aturan untuk tipe keanggotaan dan tipe koleksi ini sudah ada.',
            ]);
        }

        return $validated;
    }

    private function terapkanFilterTanggal($query, string $kolom, ?string $filter): void
    {
        $filter = $this->normalisasiFilter($filter);
        $hariIni = Carbon::today();

        if ($filter === 'hari_ini') {
            $query->whereDate($kolom, $hariIni->toDateString());
            return;
        }

        if ($filter === '7_hari') {
            $query
                ->whereDate($kolom, '>=', $hariIni->copy()->subDays(6)->toDateString())
                ->whereDate($kolom, '<=', $hariIni->toDateString());
            return;
        }

        if ($filter === '30_hari') {
            $query
                ->whereDate($kolom, '>=', $hariIni->copy()->subDays(29)->toDateString())
                ->whereDate($kolom, '<=', $hariIni->toDateString());
        }
    }

    private function normalisasiFilter(?string $nilai): string
    {
        return strtolower(str_replace([' ', '-'], '_', trim((string) $nilai)));
    }

    private function buatKodePeminjaman(): string
    {
        do {
            $kodePeminjaman = 'PJ' . strtoupper(Str::random(6));
        } while (
            Peminjaman::where(
                'kode_peminjaman',
                $kodePeminjaman
            )->exists()
        );

        return $kodePeminjaman;
    }
}
