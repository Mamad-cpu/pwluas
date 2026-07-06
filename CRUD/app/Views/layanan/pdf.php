<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk Jasa Laundry - AromaFresh</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #fff;
        }

        .header {
            background: linear-gradient(135deg, #0d9488, #06b6d4);
            color: white;
            padding: 20px 30px;
            margin-bottom: 20px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .brand-sub {
            font-size: 10px;
            opacity: 0.85;
            margin-top: 2px;
        }

        .divider {
            border: none;
            border-top: 2px solid #0d9488;
            margin: 0 30px 16px;
        }

        .section-label {
            margin: 0 30px 8px;
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table {
            width: calc(100% - 60px);
            margin: 0 30px 20px;
            border-collapse: collapse;
            font-size: 10px;
        }

        thead tr {
            background: #0d9488;
            color: white;
        }

        thead th {
            padding: 9px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:hover {
            background: #f0fdfa;
        }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .badge-aktif {
            background: #dcfce7;
            color: #166534;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 600;
        }

        .badge-nonaktif {
            background: #fee2e2;
            color: #991b1b;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 600;
        }

        .price {
            font-weight: 600;
            color: #0d9488;
        }

        .no-col { width: 30px; text-align: center; color: #64748b; }
        .nama-col { width: 22%; }
        .desc-col { width: 28%; color: #64748b; }
        .harga-col { width: 14%; }
        .satuan-col { width: 9%; text-align: center; }
        .estimasi-col { width: 10%; text-align: center; }
        .status-col { width: 10%; text-align: center; }

        .footer {
            margin: 10px 30px 0;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 9px;
            color: #94a3b8;
        }
        
        .footer-table {
            width: calc(100% - 60px);
            margin: 10px 30px 0;
            border-collapse: collapse;
        }
        
        .footer-table td {
            padding: 0;
            border: none;
            font-size: 9px;
            color: #94a3b8;
        }

        .footer-table .watermark {
            font-weight: 600;
            color: #0d9488;
            opacity: 0.5;
            text-align: right;
        }
    </style>
</head>
<body>

    <?php
        $totalLayanan  = count($layanan);
        $totalAktif    = count(array_filter($layanan, fn($l) => $l['status_layanan'] === 'aktif'));
        $totalNonaktif = $totalLayanan - $totalAktif;
        $avgHarga      = $totalLayanan > 0 ? array_sum(array_column($layanan, 'tarif')) / $totalLayanan : 0;
    ?>

    <div class="header">
        <table style="width:100%; margin:0; border:none; background:transparent;">
            <tr>
                <td style="color:white; padding:0; border:none;">
                    <div class="brand-name">&#9901; AromaFresh Laundry</div>
                    <div class="brand-sub">Sistem Manajemen Laundry Profesional</div>
                </td>
                <td style="text-align:right; color:white; padding:0; font-size:9px; opacity:0.9; border:none;">
                    <div style="font-size:13px; font-weight:bold; margin-bottom:4px;">DAFTAR PRODUK JASA LAUNDRY</div>
                    <div>Tanggal Cetak : <?= date('d F Y, H:i') ?> WIB</div>
                    <div>Dicetak oleh : <?= esc(session()->get('user_nama') ?? 'Admin') ?></div>
                </td>
            </tr>
        </table>
    </div>

    <hr class="divider">

    <div class="section-label">Ringkasan Data</div>
    <table style="width: calc(100% - 60px); margin: 0 30px 16px; border:none;">
        <tr>
            <td style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:12px 16px; text-align:center; width:25%;">
                <div style="font-size:18px; font-weight:bold; color:#0d9488;"><?= $totalLayanan ?></div>
                <div style="font-size:9px; color:#64748b;">Total Layanan</div>
            </td>
            <td style="width:4%; border:none;"></td>
            <td style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:12px 16px; text-align:center; width:25%;">
                <div style="font-size:18px; font-weight:bold; color:#16a34a;"><?= $totalAktif ?></div>
                <div style="font-size:9px; color:#64748b;">Layanan Aktif</div>
            </td>
            <td style="width:4%; border:none;"></td>
            <td style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:12px 16px; text-align:center; width:25%;">
                <div style="font-size:18px; font-weight:bold; color:#dc2626;"><?= $totalNonaktif ?></div>
                <div style="font-size:9px; color:#64748b;">Layanan Nonaktif</div>
            </td>
            <td style="width:4%; border:none;"></td>
            <td style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:12px 16px; text-align:center; width:25%;">
                <div style="font-size:13px; font-weight:bold; color:#0891b2;">Rp <?= number_format($avgHarga, 0, ',', '.') ?></div>
                <div style="font-size:9px; color:#64748b;">Rata-rata Harga</div>
            </td>
        </tr>
    </table>

    <div class="section-label">Detail Layanan</div>
    <table>
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th class="nama-col">Nama Layanan</th>
                <th class="desc-col">Deskripsi</th>
                <th class="harga-col">Harga</th>
                <th class="satuan-col">Satuan</th>
                <th class="estimasi-col">Estimasi</th>
                <th class="status-col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($layanan as $item) : ?>
                <tr>
                    <td class="no-col"><?= $no++ ?></td>
                    <td class="nama-col" style="font-weight:600;"><?= esc($item['nama_paket']) ?></td>
                    <td class="desc-col" style="font-size:9px;"><?= esc(substr($item['keterangan'] ?? '-', 0, 80)) ?><?= strlen($item['keterangan'] ?? '') > 80 ? '...' : '' ?></td>
                    <td class="harga-col price">Rp <?= number_format($item['tarif'], 0, ',', '.') ?></td>
                    <td class="satuan-col"><?= esc($item['satuan_hitung']) ?></td>
                    <td class="estimasi-col"><?= $item['durasi_jam'] ?> jam</td>
                    <td class="status-col">
                        <span class="badge-<?= $item['status_layanan'] ?>">
                            <?= ucfirst($item['status_layanan']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td style="text-align:left; border-top:1px solid #e2e8f0; padding-top:10px;">
                Dokumen ini digenerate otomatis oleh sistem AromaFresh Laundry
            </td>
            <td class="watermark" style="text-align:right; border-top:1px solid #e2e8f0; padding-top:10px;">
                AromaFresh &copy; <?= date('Y') ?>
            </td>
        </tr>
    </table>

</body>
</html>
