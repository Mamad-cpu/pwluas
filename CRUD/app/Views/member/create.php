<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card animate-fadeInUp" style="opacity:0">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-plus-fill me-2" style="color: #0d9488;"></i>
                        Registrasi Member Baru
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

                <form action="<?= base_url('/member/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nama_member" class="form-label">
                                Nama Lengkap Member <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control <?= session('validation') && session('validation')->hasError('nama_member') ? 'is-invalid' : '' ?>"
                                   id="nama_member" name="nama_member"
                                   value="<?= old('nama_member') ?>"
                                   placeholder="Nama lengkap member"
                                   required>
                        </div>

                        <div class="col-12">
                            <label for="no_handphone" class="form-label">
                                No. Handphone <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control <?= session('validation') && session('validation')->hasError('no_handphone') ? 'is-invalid' : '' ?>"
                                   id="no_handphone" name="no_handphone"
                                   value="<?= old('no_handphone') ?>"
                                   placeholder="Contoh: 0812xxxxxxxx"
                                   required>
                        </div>

                        <div class="col-12">
                            <label for="alamat_lengkap" class="form-label">
                                Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control <?= session('validation') && session('validation')->hasError('alamat_lengkap') ? 'is-invalid' : '' ?>"
                                      id="alamat_lengkap" name="alamat_lengkap"
                                      rows="3"
                                      placeholder="Jl. ..., Kelurahan, Kecamatan, Kota"
                                      required><?= old('alamat_lengkap') ?></textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <hr style="border-color: #e2e8f0;">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary-gradient">
                                    <i class="bi bi-check-lg"></i> Daftarkan Member
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
