<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<!-- FILTER -->
<div class="card mb-4 animate-fadeInUp" style="opacity:0">
    <div class="card-body">
        <form action="<?= base_url('/laporan') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="dari" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="dari" name="dari" value="<?= $dari ?>">
            </div>
            <div class="col-md-4">
                <label for="sampai" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="sampai" name="sampai" value="<?= $sampai ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary-gradient w-100">
                    <i class="bi bi-funnel me-1"></i> Tampilkan Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- TABEL LAPORAN (STRETCHED FULL WIDTH) -->
    <div class="col-12 animate-fadeInUp animate-delay-1" style="opacity:0">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-table me-2" style="color:#0d9488;"></i>Rincian Pesanan</h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($pesanan)) : ?>
                    <div class="empty-state py-4">
                        <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                        <h6 class="text-secondary mt-3">Belum ada pemasukan pada rentang tanggal ini. Coba pilih tanggal yang berbeda.</h6>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mt-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nota</th>
                                    <th>Member</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($pesanan as $trx) : ?>
                                    <tr>
                                        <td class="text-secondary"><?= $no++ ?></td>
                                        <td><span class="fw-semibold" style="color:#0d9488;"><?= esc($trx['nomor_invoice']) ?></span></td>
                                        <td><?= esc($trx['nama_member'] ?? '-') ?></td>
                                        <td class="text-secondary"><?= date('d M Y', strtotime($trx['tgl_terima'])) ?></td>
                                        <?php
                                            $statusText = [
                                                'antrian' => 'Antrean',
                                                'proses'  => 'Sedang Dicuci',
                                                'selesai' => 'Siap Diambil',
                                                'diambil' => 'Sudah Diambil'
                                            ];
                                        ?>
                                        <td><span class="badge-status badge-<?= $trx['status_laundry'] ?>"><?= $statusText[$trx['status_laundry']] ?? ucfirst($trx['status_laundry']) ?></span></td>
                                        <td class="price-tag">Rp <?= number_format($trx['total_tagihan'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- STAT CARDS (PLACED UNDER TABLE CARD) -->
    <div class="col-12 animate-fadeInUp animate-delay-2" style="opacity:0">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="stat-card stat-blue">
                    <div class="stat-icon"><i class="bi bi-receipt"></i></div>
                    <div class="stat-value"><?= $totalPesanan ?></div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card stat-green">
                    <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
                    <div class="stat-value" style="font-size:1.4rem;">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card stat-purple">
                    <div class="stat-icon"><i class="bi bi-calculator"></i></div>
                    <div class="stat-value" style="font-size:1.4rem;">Rp <?= $totalPesanan > 0 ? number_format($totalPendapatan / $totalPesanan, 0, ',', '.') : '0' ?></div>
                    <div class="stat-label">Rata-rata per Pesanan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
