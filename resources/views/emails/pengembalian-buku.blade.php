<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku – Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #eff6ff;
            font-family: 'Poppins', Arial, sans-serif;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        /* ── WRAPPER ── */
        .wrapper {
            max-width: 720px;
            margin: 40px auto;
        }

        /* ── PREHEADER ── */
        .preheader {
            text-align: right;
            font-size: 11px;
            color: #94a3b8;
            padding: 0 4px 10px;
        }

        .preheader a {
            color: #2563eb;
            text-decoration: none;
        }

        /* ── HEADER ── */
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 60%, #3b82f6 100%);
            border-radius: 16px 16px 0 0;
            padding: 36px 32px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .header-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.2);
            font-size: 28px;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }

        .header h1 {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.3px;
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .header p {
            color: rgba(255, 255, 255, 0.82);
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        /* ── BODY ── */
        .body {
            background: #fff;
            padding: 32px;
        }

        .greeting {
            font-size: 14px;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .greeting strong {
            color: #1e40af;
        }

        /* ── STATUS BAR ── */
        .status-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 28px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #2563eb;
            flex-shrink: 0;
            box-shadow: 0 0 0 3px #bfdbfe;
        }

        .status-bar span {
            font-size: 13px;
            font-weight: 600;
            color: #1e3a8a;
        }

        .status-bar small {
            font-size: 11px;
            color: #64748b;
            margin-left: auto;
        }

        /* ── SECTION LABEL ── */
        .section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        /* ── BOOK CARD ── */
        .book-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .book-card-inner {
            display: flex;
            gap: 20px;
            padding: 20px;
            align-items: flex-start;
        }

        .book-cover {
            width: 90px;
            height: 120px;
            flex-shrink: 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: linear-gradient(145deg, #dbeafe, #e0e7ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .book-info {
            flex: 1;
            min-width: 0;
        }

        .book-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .book-author {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 12px;
        }

        .book-code {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* ── DATES GRID ── */
        .dates-grid {
            display: flex;
            border-top: 1px solid #f1f5f9;
            padding: 14px 20px;
        }

        .date-item {
            flex: 1;
            text-align: center;
            padding: 0 8px;
        }

        .date-item+.date-item {
            border-left: 1px solid #e2e8f0;
        }

        .date-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #94a3b8;
            margin-bottom: 5px;
        }

        .date-value {
            font-size: 12px;
            font-weight: 600;
            color: #334155;
        }

        .date-value.blue {
            color: #1d4ed8;
        }

        .date-value.red {
            color: #dc2626;
        }

        /* ── DENDA ROW ── */
        .denda-row {
            border-top: 1px solid #f1f5f9;
            padding: 14px 20px;
        }

        .denda-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #94a3b8;
            margin-bottom: 4px;
        }

        .denda-value {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        /* ── BOOK LIST ── */
        .list-section {
            margin-bottom: 24px;
        }

        .book-list-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 10px;
            background: #fafafa;
        }

        .list-num {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .list-thumb {
            width: 38px;
            height: 50px;
            border-radius: 6px;
            background: linear-gradient(145deg, #bfdbfe, #c7d2fe);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            overflow: hidden;
        }

        .list-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .list-meta {
            flex: 1;
            min-width: 0;
        }

        .list-title {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .list-code {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .badge {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
            flex-shrink: 0;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ── INFO BOX ── */
        .info-box {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
        }

        .info-box.amber {
            background: #fffbeb;
            border: 1.5px solid #fde68a;
        }

        .info-box.red {
            background: #fff1f2;
            border: 1.5px solid #fecaca;
        }

        .info-box .icon {
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-box p {
            font-size: 12px;
            line-height: 1.7;
        }

        .info-box.amber p {
            color: #92400e;
        }

        .info-box.red p {
            color: #991b1b;
        }

        .info-box.amber strong {
            color: #78350f;
        }

        .info-box.red strong {
            color: #7f1d1d;
        }

        /* ── DIVIDER ── */
        .divider {
            border: none;
            border-top: 1.5px dashed #e2e8f0;
            margin: 24px 0;
        }

        /* ── CTA ── */
        .cta-wrap {
            text-align: center;
            padding: 8px 0 4px;
        }

        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            color: #fff;
            text-decoration: none;
            padding: 14px 40px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.4);
        }

        .cta-sub {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 10px;
        }

        /* ── FOOTER ── */
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            border-radius: 0 0 16px 16px;
            padding: 28px 32px;
            text-align: center;
        }

        .footer-brand {
            font-size: 14px;
            font-weight: 800;
            color: #1e40af;
            margin-bottom: 16px;
            letter-spacing: -0.3px;
        }

        .footer-brand span {
            color: #334155;
        }

        .footer-links {
            margin-bottom: 14px;
        }

        .footer-links a {
            color: #2563eb;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            margin: 0 10px;
        }

        .footer-legal {
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.9;
            max-width: 400px;
            margin: 0 auto;
        }

        .footer-legal a {
            color: #2563eb;
        }
    </style>
</head>

<body>
    @php
        $jatuhTempo = strtotime($pengembalian->peminjaman->tanggal_jatuh_tempo);
        $sekarang = strtotime(date('Y-m-d'));

        $jumlahHariKeterlambatan = floor(($sekarang - $jatuhTempo) / (60 * 60 * 24));

        if ($jumlahHariKeterlambatan < 0) {
            $jumlahHariKeterlambatan = 0;
        }

        $total_denda = $jumlahHariKeterlambatan * 1000;
    @endphp
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">📚</div>
            <h1>Pengembalian Buku Berhasil</h1>
            @if ($pengembalian->total_denda > 0)
                <p>Buku dikembalikan terlambat {{ $jumlahHariKeterlambatan }} hari — denda Rp
                    {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</p>
            @else
                <p>Terima kasih telah mengembalikan buku tepat waktu</p>
            @endif
        </div>

        <!-- Body -->
        <div class="body">

            <!-- Greeting -->
            <p class="greeting">
                Halo, <strong>{{ $pengembalian->peminjaman->anggota->nama }}</strong> 👋<br>
                Pengembalian buku Anda telah kami terima dan dicatat dalam sistem perpustakaan.
                Berikut adalah ringkasan lengkap pengembalian Anda.
            </p>

            <!-- Status Bar -->
            <div class="status-bar">
                <div class="status-dot"></div>
                <span>✅ Pengembalian Dikonfirmasi</span>
                <small>{{ $pengembalian->tanggal_pengembalian }}</small>
            </div>

            <!-- Book Card -->
            <div class="section-label">Detail Buku Dikembalikan</div>
            <div class="book-card">
                <div class="book-card-inner">
                    <div class="book-cover">
                        <img src="{{ asset('storage/' . $pengembalian->peminjaman->itemBuku->buku->cover_buku) }}"
                            alt="Cover Buku" onerror="this.parentElement.innerHTML='📖'">
                    </div>
                    <div class="book-info">
                        <div class="book-title">{{ $pengembalian->peminjaman->itemBuku->buku->judul_buku }}</div>
                        <div class="book-author">
                            Penulis:
                            {{ $pengembalian->peminjaman->itemBuku->buku->penulis->pluck('nama_penulis')->join(', ') }}
                        </div>
                        <span class="book-code">{{ $pengembalian->peminjaman->itemBuku->id_item }}</span>
                    </div>
                </div>

                <!-- Dates -->
                <div class="dates-grid">
                    <div class="date-item">
                        <div class="date-label">📅 Tanggal Pinjam</div>
                        <div class="date-value">{{ $pengembalian->peminjaman->tanggal_peminjaman }}</div>
                    </div>
                    <div class="date-item">
                        <div class="date-label">⏰ Jatuh Tempo</div>
                        <div class="date-value red">{{ $pengembalian->peminjaman->tanggal_jatuh_tempo }}</div>
                    </div>
                    <div class="date-item">
                        <div class="date-label">✅ Dikembalikan</div>
                        <div class="date-value blue">{{ $pengembalian->tanggal_pengembalian->format('Y-m-d') }}</div>
                    </div>
                </div>

                <!-- Denda -->
                <div class="denda-row">
                    <div class="denda-label">💰 Total Denda</div>
                    <div class="denda-value">Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</div>
                </div>
            </div>


            <!-- Info Box -->
            @if ($pengembalian->total_denda > 0)
                <div class="info-box red">
                    <div class="icon">⚠️</div>
                    <p>
                        <strong>Terdapat denda keterlambatan.</strong>
                        Buku dikembalikan terlambat selama <strong>{{ $jumlahHariKeterlambatan }} hari</strong>
                        dari tanggal jatuh tempo. Total denda yang dikenakan adalah
                        <strong>Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</strong>.
                        Mohon kembalikan buku tepat waktu pada peminjaman berikutnya.
                    </p>
                </div>
            @else
                <div class="info-box amber">
                    <div class="icon">💡</div>
                    <p>
                        <strong>Tidak ada denda.</strong>
                        Buku dikembalikan sebelum atau tepat pada tanggal jatuh tempo.
                        Pastikan Anda selalu mengembalikan buku tepat waktu untuk menghindari biaya keterlambatan.
                    </p>
                </div>
            @endif

            <hr class="divider">

            <!-- CTA -->
            <div class="cta-wrap">
                <a href="" class="cta-btn">🔖 Pinjam Buku Baru</a>
                <div class="cta-sub">Akses ribuan koleksi buku di perpustakaan kami</div>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">📚 <span>Libra</span>Tech</div>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Bantuan</a>
                <a href="#">Tentang Kami</a>
                <a href="#">Berhenti Langganan</a>
            </div>
            <div class="footer-legal">
                Email ini dikirim karena Anda adalah anggota perpustakaan kami.<br>
                Jika tidak merasa mendaftar, silakan <a href="#">hubungi kami</a>.
            </div>
        </div>

    </div>
</body>

</html>
