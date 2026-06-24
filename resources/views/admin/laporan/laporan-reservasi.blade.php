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

        .badge-draft,
        .badge-menunggu-konfirmasi,
        .badge-menunggu-antrian,
        .badge-siap-diambil,
        .badge-selesai,
        .badge-ditolak,
        .badge-kadaluarsa,
        .badge-dibatalkan {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-draft {
            background: #f1f3f5;
            color: #495057;
        }

        .badge-menunggu-konfirmasi {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-menunggu-antrian {
            background: #fff3bf;
            color: #e67700;
        }

        .badge-siap-diambil {
            background: #ede9fe;
            color: #6d28d9;
        }

        .badge-selesai {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-ditolak {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-kadaluarsa {
            background: #e9ecef;
            color: #495057;
        }

        .badge-dibatalkan {
            background: #f1f3f5;
            color: #6b7280;
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
        <h2>Laporan Transaksi Reservasi Buku</h2>
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
        Laporan transaksi reservasi buku ini menyajikan data pengajuan reservasi
        koleksi oleh anggota perpustakaan selama periode pelaporan.
        Informasi yang disajikan dapat digunakan untuk memantau tingkat
        permintaan koleksi, efektivitas layanan reservasi, serta jumlah
        reservasi yang berhasil diproses menjadi transaksi peminjaman.
    </p>

    <table class="summary-container">
        <tr>
            <td class="summary-card">
                <div class="title">Total Reservasi</div>
                <div class="value">{{ number_format($totalReservasi) }}</div>
            </td>

            <td class="summary-card">
                <div class="title">Menunggu Konfirmasi</div>
                <div class="value" style="color:#1971c2">
                    {{ number_format($totalMenungguKonfirmasi) }}
                </div>
            </td>

            <td class="summary-card highlight">
                <div class="title">Menunggu Antrian</div>
                <div class="value" style="color:#d9480f">
                    {{ number_format($totalMenungguAntrian) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Siap Diambil</div>
                <div class="value" style="color:#6741d9">
                    {{ number_format($totalSiapDiambil) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Reservasi Selesai</div>
                <div class="value" style="color:#2b8a3e">
                    {{ number_format($totalSelesai) }}
                </div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>No Reservasi</th>
                <th>Anggota</th>
                <th>Judul Buku</th>
                <th>Tgl Pengajuan</th>
                <th>Tgl Konfirmasi</th>
                <th>Batas Pengambilan</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ $item->nomor_reservasi }}
                    </td>

                    <td>
                        <span class="text-tebal">
                            {{ $item->anggota->nama }}
                        </span>
                        <br>
                        {{ $item->anggota->nomor_identitas }}
                    </td>

                    <td>
                        {{ $item->buku->judul_buku }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_diajukan)->format('d/m/Y') }}
                    </td>

                    <td class="text-center">
                        {{ $item->tanggal_diterima ? \Carbon\Carbon::parse($item->tanggal_diterima)->format('d/m/Y') : '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->tanggal_expired ? \Carbon\Carbon::parse($item->tanggal_expired)->format('d/m/Y') : '-' }}
                    </td>

                    <td class="text-center">
                        <span class="badge badge-{{ strtolower(str_replace(' ', '-', $item->status)) }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Tidak ditemukan data reservasi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <p style="margin-top:20px;text-align:justify;">
        Berdasarkan data yang tercatat pada sistem perpustakaan,
        selama periode pelaporan terdapat
        <strong>{{ number_format($totalReservasi) }}</strong>
        transaksi reservasi buku yang diajukan oleh anggota.
        Sebanyak
        <strong>{{ number_format($totalSelesai) }}</strong>
        reservasi telah berhasil diproses,
        sementara
        <strong>{{ number_format($totalMenungguAntrian) }}</strong>
        reservasi masih berada dalam daftar antrian dan
        <strong>{{ number_format($totalMenungguKonfirmasi) }}</strong>
        reservasi sedang menunggu konfirmasi anggota.
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
