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
        <h2>Laporan Data Anggota Perpustakaan</h2>
        <p>Libratech Perpustakaan Digital</p>
    </div>

    <div class="info">
        <table style="width:100%; margin-bottom:15px;">
            <tr>
                <td>
                    <strong>Periode Laporan</strong><br>
                    @if (request('jenis_filter') == 'periode')
                        {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}
                    @else
                        Seluruh Data Anggota
                    @endif
                </td>

                <td style="text-align:right;">
                    <strong>Tanggal Cetak</strong><br>
                    {{ now()->translatedFormat('d F Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <p style="text-align:justify;">
        Laporan data anggota ini menyajikan informasi mengenai anggota yang
        terdaftar pada sistem perpustakaan digital. Data digunakan sebagai
        bahan monitoring jumlah anggota aktif, distribusi jenis keanggotaan,
        serta evaluasi perkembangan keanggotaan perpustakaan.
    </p>

    <table class="summary-container">
        <tr>
            <td class="summary-card">
                <div class="title">Total Anggota</div>
                <div class="value">{{ number_format($totalAnggota) }}</div>
            </td>

            <td class="summary-card">
                <div class="title">Terverifikasi</div>
                <div class="value" style="color:#2b8a3e">
                    {{ number_format($totalTerverifikasi) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Menunggu Verifikasi</div>
                <div class="value" style="color:#e67700">
                    {{ number_format($totalMenunggu) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Ditolak</div>
                <div class="value" style="color:#c92a2a">
                    {{ number_format($totalDitolak) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="title">Anggota Aktif</div>
                <div class="value" style="color:#1971c2">
                    {{ number_format($totalAktif) }}
                </div>
            </td>
        </tr>
    </table>
    
    <h4 style="margin-top:20px;">
        Distribusi Jenis Keanggotaan
    </h4>

    <table class="data-table">
        <thead>
            <tr>
                <th>Jenis Keanggotaan</th>
                <th>Jumlah Anggota</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($anggotaPerJenis as $jenis => $anggota)
                <tr>
                    <td>{{ $jenis }}</td>
                    <td>{{ $anggota->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Identitas</th>
                <th>Nama Anggota</th>
                <th>Email</th>
                <th>Jenis Keanggotaan</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th>Verifikasi Admin</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ $item->nomor_identitas }}
                    </td>

                    <td>
                        {{ $item->nama }}
                    </td>

                    <td>
                        {{ $item->email }}
                    </td>

                    <td>
                        {{ $item->jenisKeanggotaan->nama_jenis ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                    </td>

                    <td>
                        <span class="badge badge-verifikasi-{{ strtolower($item->verifikasi_admin) }}">
                            {{ $item->verifikasi_admin }}
                        </span>
                    </td>

                    <td>
                        <span
                            class="badge badge-status-{{ strtolower(str_replace(' ', '-', $item->status_anggota)) }}">
                            {{ $item->status_anggota }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ditemukan data anggota.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <p style="text-align:justify;">
        Laporan data anggota ini menyajikan informasi mengenai anggota yang
        terdaftar pada sistem perpustakaan digital. Sampai dengan periode
        pelaporan, terdapat
        <strong>{{ number_format($totalAnggota) }}</strong>
        anggota terdaftar, dengan
        <strong>{{ number_format($totalTerverifikasi) }}</strong>
        anggota telah berhasil diverifikasi oleh administrator,
        <strong>{{ number_format($totalMenunggu) }}</strong>
        anggota masih dalam proses verifikasi, dan
        <strong>{{ number_format($totalDitolak) }}</strong>
        pengajuan keanggotaan ditolak.
    </p>

    <p style="text-align:justify;">
        Dari seluruh anggota yang terdaftar,
        <strong>{{ number_format($totalAktif) }}</strong>
        anggota berstatus aktif dan dapat menggunakan layanan perpustakaan,
        sedangkan
        <strong>{{ number_format($totalTidakAktif) }}</strong>
        anggota berstatus tidak aktif.
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
