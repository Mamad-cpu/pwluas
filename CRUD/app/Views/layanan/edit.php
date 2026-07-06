<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card animate-fadeInUp" style="opacity:0">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2" style="color: #0d9488;"></i>
                        Edit Paket Layanan
                    </h5>
                    <a href="<?= base_url('/layanan') ?>" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (session()->has('validation')) : ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-1">
                                <?php foreach (session('validation')->getErrors() as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/layanan/update/' . $layanan['id']) ?>" method="POST" id="form-edit-layanan">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <!-- Nama Paket -->
                        <div class="col-md-8">
                            <label for="nama_paket" class="form-label">
                                Nama Paket <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control <?= session('validation') && session('validation')->hasError('nama_paket') ? 'is-invalid' : '' ?>"
                                   id="nama_paket"
                                   name="nama_paket"
                                   value="<?= old('nama_paket', $layanan['nama_paket']) ?>"
                                   required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label for="status_layanan" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="status_layanan" name="status_layanan" required>
                                <option value="aktif"    <?= old('status_layanan', $layanan['status_layanan']) === 'aktif'    ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status_layanan', $layanan['status_layanan']) === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>

                        <!-- Tarif -->
                        <div class="col-md-4">
                            <label for="tarif" class="form-label">
                                Tarif (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 10px 0 0 10px; border: 1.5px solid #e2e8f0; background: #f8fafc; font-size: 0.85rem; font-weight: 600; color: #64748b;">Rp</span>
                                <input type="number"
                                       class="form-control <?= session('validation') && session('validation')->hasError('tarif') ? 'is-invalid' : '' ?>"
                                       id="tarif"
                                       name="tarif"
                                       value="<?= old('tarif', $layanan['tarif']) ?>"
                                       min="1"
                                       step="500"
                                       style="border-radius: 0 10px 10px 0;"
                                       required>
                            </div>
                        </div>

                        <!-- Satuan Hitung -->
                        <div class="col-md-4">
                            <label for="satuan_hitung" class="form-label">
                                Satuan Hitung <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="satuan_hitung" name="satuan_hitung" required>
                                <option value="">-- Pilih Satuan --</option>
                                <option value="kg"     <?= old('satuan_hitung', $layanan['satuan_hitung']) === 'kg'    ? 'selected' : '' ?>>Kilogram (kg)</option>
                                <option value="pcs"    <?= old('satuan_hitung', $layanan['satuan_hitung']) === 'pcs'   ? 'selected' : '' ?>>Pieces (pcs)</option>
                                <option value="m²"     <?= old('satuan_hitung', $layanan['satuan_hitung']) === 'm²'    ? 'selected' : '' ?>>Meter Persegi (m²)</option>
                                <option value="set"    <?= old('satuan_hitung', $layanan['satuan_hitung']) === 'set'   ? 'selected' : '' ?>>Set</option>
                                <option value="pasang" <?= old('satuan_hitung', $layanan['satuan_hitung']) === 'pasang'? 'selected' : '' ?>>Pasang</option>
                            </select>
                        </div>

                        <!-- Durasi Jam -->
                        <div class="col-md-4">
                            <label for="durasi_jam" class="form-label">
                                Durasi Pengerjaan (Jam) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control <?= session('validation') && session('validation')->hasError('durasi_jam') ? 'is-invalid' : '' ?>"
                                       id="durasi_jam"
                                       name="durasi_jam"
                                       value="<?= old('durasi_jam', $layanan['durasi_jam']) ?>"
                                       min="1"
                                       style="border-radius: 10px 0 0 10px;"
                                       required>
                                <span class="input-group-text" style="border-radius: 0 10px 10px 0; border: 1.5px solid #e2e8f0; background: #f8fafc; font-size: 0.85rem; font-weight: 600; color: #64748b;">Jam</span>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control"
                                      id="keterangan"
                                      name="keterangan"
                                      rows="3"><?= old('keterangan', $layanan['keterangan']) ?></textarea>
                            <div class="form-text">Opsional. Berikan penjelasan singkat tentang paket layanan.</div>
                        </div>

                        <!-- Info -->
                        <div class="col-12">
                            <div class="d-flex gap-4 text-secondary" style="font-size: 0.78rem;">
                                <span><i class="bi bi-calendar-plus me-1"></i> Dibuat: <?= date('d M Y, H:i', strtotime($layanan['created_at'])) ?></span>
                                <span><i class="bi bi-calendar-check me-1"></i> Diperbarui: <?= date('d M Y, H:i', strtotime($layanan['updated_at'])) ?></span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-12 mt-4">
                            <hr class="mb-4" style="border-color: #e2e8f0;">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary-gradient">
                                    <i class="bi bi-check-lg"></i>
                                    Simpan Perubahan
                                </button>
                                <a href="<?= base_url('/layanan') ?>" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 10px 24px;">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
