<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Sirkulasi Buku - Libratech</title>
    <style>
        /* Standarisasi Cetak & Font Halaman */
        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        /* Header Laporan Modern & Formal */
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #111;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }

        /* Meta Informasi Dokumen */
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .meta-table td {
            vertical-align: top;
            font-size: 11px;
        }

        /* Ringkasan Akuntansi (Summary Cards) */
        .summary-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .summary-card {
            border: 1px solid #e0e0e0;
            background: #f9f9f9;
            padding: 10px;
            width: 20%;
        }

        .summary-card .title {
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .summary-card .value {
            font-size: 14px;
            font-weight: bold;
            color: #111;
        }

        .summary-card.highlight {
            background: #fff3cd;
            border-color: #ffeba2;
        }

        .summary-card.danger {
            background: #f8d7da;
            border-color: #f5c6cb;
        }

        /* Tabel Utama Data */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            page-break-inside: auto;
        }

        .data-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .data-table th {
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
            color: #212529;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            padding: 8px 6px;
        }

        .data-table td {
            border: 1px solid #dee2e6;
            padding: 7px 6px;
            vertical-align: middle;
        }

        /* Striping baris untuk kemudahan pembacaan data */
        .data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Helper alignment data (Prinsip Akuntansi) */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .badge-dipinjam,
        .badge-dikembalikan,
        .badge-terlambat {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-dipinjam {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .badge-dikembalikan {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-terlambat {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .narrative {
            text-align: justify;
            margin-bottom: 20px;
            color: #4a5568;
        }

        /* Bagian Tanda Tangan */
        .footer-container {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            text-align: center;
            width: 250px;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            font-weight: bold;
        }

        .text-tebal {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Transaksi Peminjaman & Pengembalian Buku</h2>
        <p>Libratech Perpustakaan Digital</p>
    </div>

    <table class="meta-table">
        <tr>
            <td>
                <strong>Periode Laporan:</strong><br>
                @if (request('jenis_filter') == 'periode')
                    {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }}
                    s.d.
                    {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}
                @else
                    Seluruh Data Transaksi (All-Time)
                @endif
            </td>
            <td style="text-align:right">
                <strong>Tanggal Cetak</strong><br>
                {{ now()->translatedFormat('d F Y H:i') }}
            </td>
        </tr>
    </table>

    <p class="narrative">
        Laporan sirkulasi ini menyajikan rekonsiliasi data aktivitas peminjaman dan pengembalian koleksi buku yang
        tercatat pada sistem informasi perpustakaan. Data ringkas dan rincian transaksi di bawah ini ditujukan untuk
        keperluan audit operasional serta evaluasi denda keterlambatan.
    </p>

    <table class="summary-container">
        <tr>
            <td class="summary-card">
                <div class="title">Total Transaksi</div>
                <div class="value">{{ number_format($totalPeminjaman) }}</div>
            </td>
            <td class="summary-card">
                <div class="title">Transaksi Selesai</div>
                <div class="value" style="color: #2b8a3e;">{{ number_format($totalDikembalikan) }}</div>
            </td>
            <td class="summary-card highlight">
                <div class="title">Transaksi Aktif</div>
                <div class="value" style="color: #d9480f;">{{ number_format($totalMasihDipinjam) }}</div>
            </td>
            <td class="summary-card danger">
                <div class="title">Total Terlambat</div>
                <div class="value" style="color: #c92a2a;">{{ number_format($totalTerlambat) }}</div>
            </td>
            <td class="summary-card" style="background: #edf2ff; border-color: #bac8ff;">
                <div class="title">Akumulasi Denda</div>
                <div class="value" style="color: #364fc7;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">No. Transaksi</th>
                <th style="width: 15%;">Nama Anggota</th>
                <th style="width: 22%;">Judul Buku</th>
                <th style="width: 9%;">Tgl Pinjam</th>
                <th style="width: 9%;">Jatuh Tempo</th>
                <th style="width: 9%;">Tgl Kembali</th>
                <th style="width: 11%;">Status</th>
                <th style="width: 12%;">Nilai Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center" style="font-family: monospace; font-size: 12px;">
                        {{ $item->kode_peminjaman }}</td>
                    <td>
                        <span class="text-tebal">
                            {{ $item->anggota->nama }}
                        </span><br>
                        {{ $item->anggota->nomor_identitas }}
                    </td>
                    <td>
                        <span class="text-tebal">
                            {{ $item->itemBuku->buku->judul_buku }}
                        </span><br>
                        {{ $item->id_item }}
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }}
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        @if ($item->pengembalian)
                            {{ \Carbon\Carbon::parse($item->pengembalian->tanggal_pengembalian)->format('d/m/Y') }}
                        @else
                            <span style="color: #adb5bd;">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ strtolower(str_replace(' ', '-', $item->status)) }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="text-right" style="font-weight: 500;">
                        @if ($item->pengembalian && $item->pengembalian->total_denda > 0)
                            Rp {{ number_format($item->pengembalian->total_denda, 0, ',', '.') }}
                        @elseif ($item->pengembalian)
                            Rp 0
                        @else
                            <span style="color: #adb5bd;">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; color: #666; font-style: italic;">
                        Tidak ditemukan rekaman data transaksi untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top:20px;text-align:justify;">
        Berdasarkan data transaksi peminjaman yang tercatat pada sistem
        perpustakaan selama periode pelaporan, terdapat
        <strong>{{ number_format($totalPeminjaman) }}</strong>
        transaksi peminjaman buku yang dilakukan oleh anggota perpustakaan.

        Dari jumlah tersebut,
        <strong>{{ number_format($totalDikembalikan) }}</strong>
        transaksi telah selesai dan buku telah dikembalikan,
        <strong>{{ number_format($totalTerlambat) }}</strong>
        transaksi mengalami keterlambatan pengembalian,
        serta
        <strong>{{ number_format($totalMasihDipinjam) }}</strong>
        transaksi masih berada dalam status peminjaman aktif.

        Adapun total denda yang tercatat selama periode laporan adalah sebesar
        <strong>Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong>.
        Informasi ini dapat digunakan sebagai bahan evaluasi terhadap tingkat
        pemanfaatan koleksi perpustakaan dan kepatuhan anggota dalam memenuhi
        kewajiban pengembalian buku sesuai dengan ketentuan yang berlaku.
    </p>

    <div class="footer-container">
        <div class="signature-box">
            <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
            <p style="margin-top: 5px;"><strong>Petugas Administrasi,</strong></p>

            <div class="signature-line">
                Tim Inkaso & Sirkulasi
            </div>
            <p style="margin: 2px 0 0 0; color: #666; font-size: 10px;">Libratech Digital Library</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>

</html>
