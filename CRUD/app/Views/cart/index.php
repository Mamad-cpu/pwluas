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
    <!-- CART ITEMS CARD -->
    <div class="col-lg-8">
        <div class="card animate-fadeInUp" style="opacity:0; animation-delay: 0.1s">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-cart3 me-2" style="color: #0d9488;"></i>
                    Daftar Item Layanan
                </h5>
                <?php if (!empty($cartItems)) : ?>
                    <a href="<?= base_url('/cart/clear') ?>" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;">
                        <i class="bi bi-trash3-fill me-1"></i> Kosongkan Keranjang
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if (empty($cartItems)) : ?>
                    <div class="empty-state py-5">
                        <i class="bi bi-cart-x text-secondary" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Keranjang Belanja Kosong</h5>
                        <p class="text-secondary">Anda belum memilih layanan laundry apa pun.</p>
                        <a href="<?= base_url('/layanan') ?>" class="btn btn-primary-gradient px-4 mt-2">
                            <i class="bi bi-tags-fill me-1"></i> Pilih Layanan
                        </a>
                    </div>
                <?php else : ?>
                    <form action="<?= base_url('/cart/update') ?>" method="POST" id="form-cart">
                        <?= csrf_field() ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Nama Layanan</th>
                                        <th class="text-end" style="width: 20%;">Harga</th>
                                        <th class="text-center" style="width: 20%;">Jumlah (Qty)</th>
                                        <th class="text-end" style="width: 20%;">Subtotal</th>
                                        <th class="text-center" style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($cartItems as $item) : ?>
                                        <tr>
                                            <td class="text-secondary fw-semibold"><?= $no++ ?></td>
                                            <td>
                                                <div class="fw-bold text-dark"><?= esc($item['name']) ?></div>
                                                <small class="text-secondary">
                                                    Satuan: <?= esc($item['options']['satuan'] ?? '-') ?> | 
                                                    Estimasi: <?= esc($item['options']['durasi'] ?? '-') ?> Jam
                                                </small>
                                            </td>
                                            <td class="text-end fw-semibold">
                                                Rp <?= number_format($item['price'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="input-group input-group-sm mx-auto" style="max-width: 120px;">
                                                    <input type="number" 
                                                           name="items[<?= $item['id'] ?>][qty]" 
                                                           value="<?= $item['qty'] ?>" 
                                                           min="0.1" 
                                                           step="0.1" 
                                                           class="form-control text-center fw-semibold border-secondary-subtle" 
                                                           style="border-radius: 8px;"
                                                           onchange="this.form.submit()">
                                                    <span class="input-group-text bg-light text-secondary border-secondary-subtle" style="font-size: 0.75rem;">
                                                        <?= esc($item['options']['satuan'] ?? '') ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold text-teal">
                                                Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('/cart/remove/' . $item['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger border-0" 
                                                   style="border-radius: 50%; width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"
                                                   title="Hapus item">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- SUMMARY CARD -->
    <div class="col-lg-4">
        <div class="card animate-fadeInUp" style="opacity:0; animation-delay: 0.2s">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-receipt me-2" style="color: #0d9488;"></i>
                    Ringkasan Belanja
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary">Subtotal</span>
                    <span class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="text-secondary font-weight-bold">Total Pembayaran</span>
                    <span class="fs-4 fw-extrabold text-teal">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>

                <hr class="my-3">

                <a href="<?= base_url('/pesanan/create') ?>" class="btn btn-primary-gradient w-100 py-2.5 <?= empty($cartItems) ? 'disabled' : '' ?>" style="border-radius: 12px; font-weight: 600;">
                    <i class="bi bi-check-lg me-1"></i> Lanjutkan Pemesanan
                </a>
                <a href="<?= base_url('/layanan') ?>" class="btn btn-outline-secondary w-100 py-2.5 mt-2" style="border-radius: 12px; font-weight: 600;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Lain
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
