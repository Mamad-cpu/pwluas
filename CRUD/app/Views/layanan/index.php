<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

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
    <!-- TABLE CARD -->
    <div class="col-12 animate-fadeInUp animate-delay-1" style="opacity:0">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-tags-fill me-2" style="color: #0d9488;"></i>
                        Daftar Paket Layanan
                    </h5>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="<?= base_url('/layanan/pdf') ?>" target="_blank" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 9px 18px; font-size: 0.85rem;">
                        <i class="bi bi-file-earmark-pdf-fill me-1" style="color: #dc2626;"></i> Cetak PDF
                    </a>
                    <?php if (session()->get('user_role') === 'admin') : ?>
                        <a href="<?= base_url('/layanan/create') ?>" class="btn btn-primary-gradient">
                            <i class="bi bi-plus-lg"></i>
                            Tambah Paket
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (empty($layanan)) : ?>
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h5>Belum Ada Data</h5>
                        <p>Belum ada paket layanan yang terdaftar. Klik tombol "Tambah Paket" untuk menambahkan.</p>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mt-2" id="tabel-layanan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Keterangan</th>
                                    <th>Tarif</th>
                                    <th>Satuan</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($layanan as $item) : ?>
                                    <tr>
                                        <td class="fw-semibold text-secondary"><?= $no++ ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= esc($item['nama_paket']) ?></div>
                                        </td>
                                        <td>
                                            <span class="text-secondary" style="font-size: 0.82rem;">
                                                <?= esc(character_limiter($item['keterangan'] ?? '-', 50)) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="price-tag">Rp <?= number_format($item['tarif'], 0, ',', '.') ?></span>
                                        </td>
                                        <td><?= esc($item['satuan_hitung']) ?></td>
                                        <td>
                                            <i class="bi bi-clock text-secondary me-1"></i>
                                            <?= $item['durasi_jam'] ?> jam
                                        </td>
                                        <td>
                                            <span class="badge-status badge-<?= $item['status_layanan'] ?>">
                                                <?= ucfirst($item['status_layanan']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= base_url('/cart/add/' . $item['id']) ?>"
                                                   class="btn-action btn-info bg-teal text-white border-0" title="Beli / Tambah Ke Keranjang" style="background-color: #0d9488 !important; padding: 6px 10px; border-radius: 8px;">
                                                    <i class="bi bi-cart-plus-fill"></i>
                                                </a>
                                                <?php if (session()->get('user_role') === 'admin') : ?>
                                                    <a href="<?= base_url('/layanan/edit/' . $item['id']) ?>"
                                                       class="btn-action btn-edit" title="Edit">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                    <button type="button" class="btn-action btn-delete"
                                                            title="Hapus"
                                                            onclick="confirmDelete(<?= $item['id'] ?>, '<?= esc($item['nama_paket']) ?>')">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
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
        <div class="row g-4">
            <?php
                $totalLayanan  = count($layanan);
                $totalAktif    = count(array_filter($layanan, fn($l) => $l['status_layanan'] === 'aktif'));
                $totalNonaktif = $totalLayanan - $totalAktif;
                $avgTarif      = $totalLayanan > 0 ? array_sum(array_column($layanan, 'tarif')) / $totalLayanan : 0;
            ?>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card stat-purple">
                    <div class="stat-icon"><i class="bi bi-tags-fill"></i></div>
                    <div class="stat-value"><?= $totalLayanan ?></div>
                    <div class="stat-label">Total Paket</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card stat-green">
                    <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="stat-value"><?= $totalAktif ?></div>
                    <div class="stat-label">Paket Aktif</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card stat-orange">
                    <div class="stat-icon"><i class="bi bi-x-circle-fill"></i></div>
                    <div class="stat-value"><?= $totalNonaktif ?></div>
                    <div class="stat-label">Paket Nonaktif</div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card stat-blue">
                    <div class="stat-icon"><i class="bi bi-currency-exchange"></i></div>
                    <div class="stat-value">Rp <?= number_format($avgTarif, 0, ',', '.') ?></div>
                    <div class="stat-label">Rata-rata Tarif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- LAYANAN POPULER -->
    <div class="col-12 animate-fadeInUp animate-delay-3 mt-4" style="opacity:0">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Paket Terpopuler</h6>
            </div>
            <div class="card-body">
                <?php if (empty($layananPopuler)) : ?>
                    <p class="text-secondary text-center py-3">Belum ada paket terpopuler.</p>
                <?php else : ?>
                    <div class="row g-3">
                        <?php $rank = 1; foreach ($layananPopuler as $lp) : ?>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3 p-3" style="background:#f8fafc;border-radius:12px;">
                                    <div style="width:36px;height:36px;background:<?= $rank <= 3 ? 'var(--primary-gradient)' : '#e2e8f0' ?>;border-radius:8px;display:flex;align-items:center;justify-content:center;color:<?= $rank <= 3 ? '#fff' : '#64748b' ?>;font-weight:700;font-size:0.9rem;">
                                        <?= $rank ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold" style="font-size:0.85rem;"><?= esc($lp['nama_paket'] ?? '-') ?></div>
                                        <small class="text-secondary"><?= $lp['total_order'] ?> order</small>
                                    </div>
                                </div>
                            </div>
                        <?php $rank++; endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-body text-center p-4">
                <div style="width: 70px; height: 70px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem; color: #dc2626;"></i>
                </div>
                <h5 class="fw-bold mb-2">Konfirmasi Hapus</h5>
                <p class="text-secondary mb-0">Apakah Anda yakin ingin menghapus paket</p>
                <p class="fw-bold mb-4" id="deleteItemName"></p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" style="border-radius: 10px;" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="deleteLink" class="btn btn-danger px-4" style="border-radius: 10px;">
                        <i class="bi bi-trash-fill me-1"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function confirmDelete(id, name) {
        document.getElementById('deleteItemName').textContent = '"' + name + '"?';
        document.getElementById('deleteLink').href = '<?= base_url('/layanan/delete/') ?>' + id;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        });
    }, 4000);
</script>
<?= $this->endSection() ?>
