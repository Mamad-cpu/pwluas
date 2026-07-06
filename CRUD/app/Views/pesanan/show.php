<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- PESANAN HEADER -->
        <div class="card mb-4 animate-fadeInUp" style="opacity:0">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-receipt me-2" style="color: #0d9488;"></i>
                    <?= esc($pesanan['nomor_invoice']) ?>
                </h5>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('/pesanan/pdf/' . $pesanan['id']) ?>" target="_blank"
                       class="btn btn-sm" style="background:#dc2626;color:#fff;border-radius:8px;font-size:0.82rem;padding:7px 14px;">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak Nota
                    </a>
                    <a href="<?= base_url('/pesanan') ?>" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <table style="font-size:0.88rem;">
                            <tr>
                                <td class="text-secondary pe-3 pb-2">Member</td>
                                <td class="fw-semibold pb-2">: <?= esc($pesanan['nama_member'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td class="text-secondary pe-3 pb-2">Kasir</td>
                                <td class="pb-2">: <?= esc($pesanan['nama_kasir'] ?? '-') ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table style="font-size:0.88rem;">
                            <tr>
                                <td class="text-secondary pe-3 pb-2">Tgl. Terima</td>
                                <td class="pb-2">: <?= date('d M Y', strtotime($pesanan['tgl_terima'])) ?></td>
                            </tr>
                            <tr>
                                <td class="text-secondary pe-3 pb-2">Tgl. Selesai</td>
                                <td class="pb-2">: <?= $pesanan['tgl_selesai'] ? date('d M Y', strtotime($pesanan['tgl_selesai'])) : '-' ?></td>
                            </tr>
                            <tr>
                                <td class="text-secondary pe-3 pb-2">Status</td>
                                <td class="pb-2">: <span class="badge-status badge-<?= $pesanan['status_laundry'] ?>"><?= ucfirst($pesanan['status_laundry']) ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <?php if ($pesanan['catatan_khusus']): ?>
                        <div class="col-12">
                            <div class="p-3" style="background:#f1f5f9;border-radius:10px;font-size:0.85rem;">
                                <strong>Catatan Khusus:</strong> <?= esc($pesanan['catatan_khusus']) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- DETAIL ITEM -->
        <div class="card animate-fadeInUp" style="opacity:0; animation-delay:0.2s">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-list-check me-2" style="color:#0d9488;"></i>Rincian Item Cucian</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Paket Layanan</th>
                                <th>Tarif Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($detail as $item) : ?>
                                <tr>
                                    <td class="fw-semibold text-secondary"><?= $no++ ?></td>
                                    <td class="fw-semibold"><?= esc($item['nama_paket'] ?? '-') ?></td>
                                    <td>Rp <?= number_format($item['tarif'] ?? 0, 0, ',', '.') ?>/<?= esc($item['satuan'] ?? '') ?></td>
                                    <td><?= $item['qty'] ?> <?= esc($item['satuan'] ?? '') ?></td>
                                    <td class="price-tag">Rp <?= number_format($item['subtotal_tagihan'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold" style="font-size:1.1rem;">Total Tagihan:</td>
                                <td class="price-tag" style="font-size:1.2rem;font-weight:800;">Rp <?= number_format($pesanan['total_tagihan'], 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
