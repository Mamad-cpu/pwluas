<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card animate-fadeInUp" style="opacity:0">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-gear me-2" style="color: #0d9488;"></i>
                        Edit Data Member
                    </h5>
                    <a href="<?= base_url('/member') ?>" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
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

                <form action="<?= base_url('/member/update/' . $member['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nama_member" class="form-label">
                                Nama Lengkap Member <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control <?= session('validation') && session('validation')->hasError('nama_member') ? 'is-invalid' : '' ?>"
                                   id="nama_member" name="nama_member"
                                   value="<?= old('nama_member', $member['nama_member']) ?>"
                                   required>
                        </div>

                        <div class="col-12">
                            <label for="no_handphone" class="form-label">
                                No. Handphone <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control <?= session('validation') && session('validation')->hasError('no_handphone') ? 'is-invalid' : '' ?>"
                                   id="no_handphone" name="no_handphone"
                                   value="<?= old('no_handphone', $member['no_handphone']) ?>"
                                   required>
                        </div>

                        <div class="col-12">
                            <label for="alamat_lengkap" class="form-label">
                                Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control <?= session('validation') && session('validation')->hasError('alamat_lengkap') ? 'is-invalid' : '' ?>"
                                      id="alamat_lengkap" name="alamat_lengkap"
                                      rows="3"
                                      required><?= old('alamat_lengkap', $member['alamat_lengkap']) ?></textarea>
                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-4 text-secondary" style="font-size: 0.78rem;">
                                <span><i class="bi bi-calendar-plus me-1"></i> Terdaftar: <?= date('d M Y, H:i', strtotime($member['created_at'])) ?></span>
                                <span><i class="bi bi-calendar-check me-1"></i> Diperbarui: <?= date('d M Y, H:i', strtotime($member['updated_at'])) ?></span>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <hr style="border-color: #e2e8f0;">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary-gradient">
                                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                                </button>
                                <a href="<?= base_url('/member') ?>" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 10px 24px;">
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
