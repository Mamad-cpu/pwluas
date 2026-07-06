<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<style>
    /* Small stat card design */
    .stat-card-sm {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }
    .stat-card-sm::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
    }
    .stat-card-sm:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
    }
    .stat-card-sm .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.0rem;
        margin-bottom: 10px;
    }
    .stat-card-sm .stat-value {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }
    .stat-card-sm .stat-label {
        font-size: 0.72rem;
        color: var(--text-secondary);
        font-weight: 500;
        margin-top: 4px;
    }
</style>

<!-- FLASH MESSAGE -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success animate-fadeInUp" role="alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger animate-fadeInUp" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- ROW 1: STATUS PESANAN (STRETCHED TO RIGHT / col-12) -->
    <div class="col-12 animate-fadeInUp animate-delay-1" style="opacity:0">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-pie-chart-fill me-2" style="color: #0d9488;"></i>
                    Status Pesanan
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between align-items-center p-3" style="background: #fef3c7; border-radius: 12px;">
                            <div>
                                <div class="fw-bold" style="color: #d97706;">Antrean</div>
                                <small class="text-secondary">Menunggu proses cucian</small>
                            </div>
                            <span class="fs-3 fw-bold" style="color: #d97706;"><?= $statusAntrian ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between align-items-center p-3" style="background: #dbeafe; border-radius: 12px;">
                            <div>
                                <div class="fw-bold" style="color: #2563eb;">Sedang Dicuci</div>
                                <small class="text-secondary">Pakaian sedang diproses</small>
                            </div>
                            <span class="fs-3 fw-bold" style="color: #2563eb;"><?= $statusProses ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between align-items-center p-3" style="background: #dcfce7; border-radius: 12px;">
                            <div>
                                <div class="fw-bold" style="color: #16a34a;">Siap Diambil</div>
                                <small class="text-secondary">Menunggu member</small>
                            </div>
                            <span class="fs-3 fw-bold" style="color: #16a34a;"><?= $statusSelesai ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: SMALL STAT CARDS (PLACED UNDER STATUS PESANAN) -->
    <div class="col-12 animate-fadeInUp animate-delay-2" style="opacity:0">
        <div class="row g-3">
            <?php 
                $isAdmin = (session()->get('user_role') === 'admin');
                $cardCol = $isAdmin ? 'col-sm-6 col-md-3' : 'col-md-4';
            ?>
            <div class="<?= $cardCol ?>">
                <div class="stat-card-sm stat-purple">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-value"><?= $totalMember ?></div>
                    <div class="stat-label">Member Terdaftar</div>
                </div>
            </div>
            <div class="<?= $cardCol ?>">
                <div class="stat-card-sm stat-blue">
                    <div class="stat-icon"><i class="bi bi-receipt"></i></div>
                    <div class="stat-value"><?= $pesananHariIni ?></div>
                    <div class="stat-label">Pesanan Masuk Hari Ini</div>
                </div>
            </div>
            <?php if ($isAdmin) : ?>
                <div class="<?= $cardCol ?>">
                    <div class="stat-card-sm stat-green">
                        <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
                        <div class="stat-value">Rp <?= number_format($pendapatanBulanIni, 0, ',', '.') ?></div>
                        <div class="stat-label">Pemasukan Bulan Ini</div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="<?= $cardCol ?>">
                <div class="stat-card-sm stat-orange">
                    <div class="stat-icon"><i class="bi bi-tags-fill"></i></div>
                    <div class="stat-value"><?= $totalLayananAktif ?></div>
                    <div class="stat-label">Layanan Aktif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 3: RECENT TRANSACTIONS (STRETCHED TO RIGHT / col-12) -->
    <div class="col-12 animate-fadeInUp animate-delay-3" style="opacity:0">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2" style="color: #0d9488;"></i>Pesanan Terakhir</h6>
                <a href="<?= base_url('/pesanan') ?>" class="text-decoration-none" style="font-size: 0.82rem; color: #0d9488; font-weight: 600;">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($pesananTerakhir)) : ?>
                    <div class="empty-state py-4">
                        <i class="bi bi-inbox" style="font-size: 2.5rem;"></i>
                        <h6 class="text-secondary mt-3">Belum ada pesanan masuk sama sekali.</h6>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mt-2">
                            <thead>
                                <tr>
                                    <th>Nota</th>
                                    <th>Member</th>
                                    <th>Total Tagihan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pesananTerakhir as $trx) : ?>
                                    <tr>
                                        <td><span class="fw-semibold" style="color: #0d9488;"><?= esc($trx['nomor_invoice']) ?></span></td>
                                        <td><?= esc($trx['nama_member'] ?? '-') ?></td>
                                        <td><span class="price-tag">Rp <?= number_format($trx['total_tagihan'], 0, ',', '.') ?></span></td>
                                        <?php
                                            $statusText = [
                                                'antrian' => 'Antrean',
                                                'proses'  => 'Sedang Dicuci',
                                                'selesai' => 'Siap Diambil',
                                                'diambil' => 'Sudah Diambil'
                                            ];
                                        ?>
                                        <td><span class="badge-status badge-<?= $trx['status_laundry'] ?>"><?= $statusText[$trx['status_laundry']] ?? ucfirst($trx['status_laundry']) ?></span></td>
                                        <td class="text-secondary"><?= date('d M Y', strtotime($trx['tgl_terima'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto-hide flash messages
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        });
    }, 4000);
</script>
<?= $this->endSection() ?>
