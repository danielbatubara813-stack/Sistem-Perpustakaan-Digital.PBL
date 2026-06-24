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

        .badge {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Verifikasi */
        .badge-verifikasi-menunggu {
            background: #fff3bf;
            color: #e67700;
        }

        .badge-verifikasi-terverifikasi {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-verifikasi-ditolak {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Status anggota */
        .badge-status-aktif {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-status-tidak-aktif {
            background: #e5e7eb;
            color: #495057;
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
        <h2>Laporan Data Koleksi Buku</h2>
        <p>Libratech Perpustakaan Digital</p>
    </div>

    <div class="info">
        <table style="width:100%">
            <tr>
                <td>
                    <strong>Periode Laporan</strong><br>
                    @if (request('jenis_filter') == 'periode')
                        {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}
                    @else
                        Seluruh Data Koleksi
                    @endif
                </td>

                <td style="text-align:right">
                    <strong>Tanggal Cetak</strong><br>
                    {{ now()->translatedFormat('d F Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <p style="text-align:justify;">
        Laporan data koleksi buku ini menyajikan informasi mengenai jumlah
        dan kondisi koleksi yang tersedia pada sistem perpustakaan digital.
        Data digunakan sebagai dasar pengelolaan koleksi, evaluasi tingkat
        pemanfaatan bahan pustaka, serta perencanaan pengembangan koleksi
        perpustakaan.
    </p>

    <table class="summary-container">
        <tr>
            <td class="summary-card">
                <div class="title">Total Judul Buku</div>
                <div class="value">
                    {{ number_format($totalJudul) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Total Eksemplar</div>
                <div class="value">
                    {{ number_format($totalEksemplar) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Tersedia</div>
                <div class="value" style="color:#2b8a3e">
                    {{ number_format($totalTersedia) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Dipinjam</div>
                <div class="value" style="color:#1971c2">
                    {{ number_format($totalDipinjam) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Dipesan</div>
                <div class="value" style="color:#e67700">
                    {{ number_format($totalDipesan) }}
                </div>
            </td>
        </tr>
    </table>

    <h4 style="margin-top:20px;">
        Distribusi Koleksi Berdasarkan Tipe
    </h4>

    <table class="data-table">
        <thead>
            <tr>
                <th>Tipe Koleksi</th>
                <th>Jumlah Judul</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($koleksiPerTipe as $tipe => $buku)
                <tr>
                    <td>{{ $tipe }}</td>
                    <td>{{ $buku->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ISBN</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Tipe Koleksi</th>
                <th>Jumlah Eksemplar</th>
                <th>Tersedia</th>
                <th>Dipinjam</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->isbn }}</td>

                    <td>{{ $item->judul_buku }}</td>

                    <td>
                        {{ $item->penulis->isNotEmpty() ? $item->penulis->pluck('nama_penulis')->join(', ') : '-' }}
                    </td>

                    <td>
                        {{ $item->penerbit->nama_penerbit ?? '-' }}
                    </td>

                    <td>
                        {{ $item->tahun_terbit }}
                    </td>

                    <td>
                        {{ $item->tipe->nama_tipe ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->items->count() }}
                    </td>

                    <td class="text-center">
                        {{ $item->items->where('status_item', 'Tersedia')->count() }}
                    </td>

                    <td class="text-center">
                        {{ $item->items->where('status_item', 'Sedang Dipinjam')->count() }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">
                        Tidak ditemukan data koleksi buku.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <p style="margin-top:20px;text-align:justify;">
        Berdasarkan data yang tercatat pada sistem perpustakaan digital,
        jumlah koleksi yang tersedia hingga tanggal laporan adalah
        <strong>{{ number_format($totalJudul) }}</strong>
        judul buku dengan total
        <strong>{{ number_format($totalEksemplar) }}</strong>
        eksemplar.
        Dari jumlah tersebut,
        <strong>{{ number_format($totalTersedia) }}</strong>
        eksemplar tersedia untuk dipinjam,
        <strong>{{ number_format($totalDipinjam) }}</strong>
        eksemplar sedang dipinjam oleh anggota,
        dan
        <strong>{{ number_format($totalDipesan) }}</strong>
        eksemplar sedang dialokasikan untuk proses reservasi.
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
