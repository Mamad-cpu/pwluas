<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota - <?= esc($pesanan['nomor_invoice']) ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 30px;
            font-size: 12px;
            line-height: 1.6;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }
        .header-left {
            display: table-cell;
        }
        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: top;
        }
        .brand-name {
            color: #0d9488;
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }
        .brand-sub {
            color: #64748b;
            font-size: 9px;
            margin: 2px 0 0;
        }
        .invoice-label {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
        }
        .invoice-num {
            color: #0d9488;
            font-weight: bold;
        }
        .divider {
            border: none;
            border-top: 2px solid #0d9488;
            margin: 16px 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info-table .label {
            color: #64748b;
            width: 130px;
        }
        .info-table .value {
            font-weight: 600;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.items th {
            background-color: #0d9488;
            color: #fff;
            padding: 10px 12px;
            text-align: left;
            font-size: 11px;
        }
        table.items td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        table.items tr:last-child td {
            border-bottom: none;
        }
        table.items tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .total-row {
            background-color: #f0fdfa;
        }
        .total-row td {
            font-size: 14px;
            font-weight: bold;
            color: #0d9488;
            border-top: 2px solid #0d9488 !important;
        }
        .text-right {
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-antrian { background: #fef3c7; color: #b45309; }
        .status-proses  { background: #dbeafe; color: #1d4ed8; }
        .status-selesai { background: #dcfce7; color: #15803d; }
        .status-diambil { background: #f1f5f9; color: #475569; }
        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <p class="brand-name">AROMAFRESH LAUNDRY</p>
            <p class="brand-sub">Layanan Laundry Profesional dengan Keharuman Tahan Lama</p>
        </div>
        <div class="header-right">
            <div class="invoice-label">NOTA PESANAN</div>
            <div class="invoice-num"><?= esc($pesanan['nomor_invoice']) ?></div>
        </div>
    </div>

    <hr class="divider">

    <table class="info-table">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="label">Nama Member</td>
                        <td>: <span class="value"><?= esc($pesanan['nama_member'] ?? '-') ?></span></td>
                    </tr>
                    <tr>
                        <td class="label">Kasir</td>
                        <td>: <span class="value"><?= esc($pesanan['nama_kasir'] ?? '-') ?></span></td>
                    </tr>
                </table>
            </td>
            <td style="text-align: right; vertical-align: top;">
                <table style="margin-left: auto;">
                    <tr>
                        <td class="label">Tgl. Terima</td>
                        <td>: <span class="value"><?= date('d M Y', strtotime($pesanan['tgl_terima'])) ?></span></td>
                    </tr>
                    <tr>
                        <td class="label">Tgl. Selesai</td>
                        <td>: <span class="value"><?= $pesanan['tgl_selesai'] ? date('d M Y', strtotime($pesanan['tgl_selesai'])) : '-' ?></span></td>
                    </tr>
                    <tr>
                        <td class="label">Status</td>
                        <td>:
                            <span class="status-badge status-<?= $pesanan['status_laundry'] ?>">
                                <?php
                                $statusLabels = [
                                    'antrian' => 'Antrean',
                                    'proses'  => 'Sedang Dicuci',
                                    'selesai' => 'Siap Diambil',
                                    'diambil' => 'Sudah Diambil',
                                ];
                                echo $statusLabels[$pesanan['status_laundry']] ?? ucfirst($pesanan['status_laundry']);
                                ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Paket Layanan</th>
                <th style="width: 20%;">Tarif Satuan</th>
                <th style="width: 15%;">Jumlah</th>
                <th style="width: 20%; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($detail as $item) : ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><strong><?= esc($item['nama_paket'] ?? '-') ?></strong></td>
                    <td>Rp <?= number_format($item['tarif'] ?? 0, 0, ',', '.') ?>/<?= esc($item['satuan'] ?? '') ?></td>
                    <td><?= $item['qty'] ?> <?= esc($item['satuan'] ?? '') ?></td>
                    <td class="text-right"><strong>Rp <?= number_format($item['subtotal_tagihan'], 0, ',', '.') ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL TAGIHAN</td>
                <td class="text-right">Rp <?= number_format($pesanan['total_tagihan'], 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <?php if ($pesanan['catatan_khusus']) : ?>
        <p style="font-size: 10px; color: #64748b; margin-top: 0;">
            <strong>Catatan Khusus:</strong> <?= esc($pesanan['catatan_khusus']) ?>
        </p>
    <?php endif; ?>

    <div class="footer">
        Terima kasih telah mempercayakan cucian Anda kepada AromaFresh Laundry. &mdash; Dicetak pada <?= date('d M Y H:i') ?>
    </div>

</body>
</html>
