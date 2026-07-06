<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 20px;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #0d9488;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 10px;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h2 {
            margin: 0;
            font-size: 16px;
            color: #1e293b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: bold;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-aktif {
            background-color: #dcfce7;
            color: #15803d;
        }
        .status-nonaktif {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>AROMAFRESH LAUNDRY</h1>
        <p>Layanan Laundry Profesional dengan Keharuman Tahan Lama</p>
    </div>

    <div class="title">
        <h2>Daftar Paket Layanan Laundry</h2>
        <p style="margin: 5px 0 0; color: #64748b; font-size: 10px;">Dicetak pada tanggal: <?= date('d M Y - H:i:s') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Nama Paket</th>
                <th style="width: 20%;">Tarif</th>
                <th style="width: 15%;">Estimasi Waktu</th>
                <th style="width: 20%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($layanan as $l) : ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td>
                        <strong><?= esc($l['nama_paket']) ?></strong>
                        <?php if ($l['keterangan']) : ?>
                            <br><span style="font-size: 9px; color: #64748b; font-weight: normal;"><?= esc($l['keterangan']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>Rp <?= number_format($l['tarif'], 0, ',', '.') ?> / <?= esc($l['satuan_hitung']) ?></td>
                    <td><?= $l['durasi_jam'] ?> Jam</td>
                    <td>
                        <span class="status-badge status-<?= $l['status_layanan'] ?>">
                            <?= esc($l['status_layanan']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem Manajemen AromaFresh Laundry. Halaman 1 dari 1.
    </div>

</body>
</html>
