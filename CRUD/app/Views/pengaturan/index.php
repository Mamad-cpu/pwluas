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
<?php if (session()->has('validation')) : ?>
    <div class="alert alert-danger animate-fadeInUp" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <div>
            <ul class="mb-0 ps-3">
                <?php foreach (session('validation')->getErrors() as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-10 animate-fadeInUp">
        <!-- TOGGLE CONTROL BOARD -->
        <div class="d-flex justify-content-center mb-4">
            <div class="toggle-pill-container">
                <div class="active-pill-bg"></div>
                <button type="button" class="btn-toggle-tab text-white" id="tab-laundry" onclick="switchSettingsTab('laundry')">
                    <i class="bi bi-shop me-2"></i> Profil Laundry
                </button>
                <button type="button" class="btn-toggle-tab text-secondary" id="tab-user" onclick="switchSettingsTab('user')">
                    <i class="bi bi-person-badge me-2"></i> Profil Saya
                </button>
            </div>
        </div>

        <!-- MAIN SETTINGS CARD -->
        <div class="card card-settings-wrapper overflow-hidden" style="border-radius: 20px;">
            <!-- HEADER -->
            <div class="card-header bg-white py-4 px-4" style="border-bottom: 1px solid #f1f5f9;">
                <!-- Laundry Header -->
                <div id="header-laundry" class="d-flex align-items-center gap-3">
                    <div style="width: 42px; height: 42px; background: #ede9fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #7c3aed;">
                        <i class="bi bi-shop fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Profil Laundry</h5>
                        <small class="text-secondary">Ubah identitas toko dan deskripsi nota</small>
                    </div>
                </div>
                <!-- User Header -->
                <div id="header-user" class="d-flex align-items-center gap-3 d-none">
                    <div style="width: 42px; height: 42px; background: #e0f2fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #0284c7;">
                        <i class="bi bi-person-badge fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Profil Saya</h5>
                        <small class="text-secondary">Kelola informasi akun dan kata sandi Anda</small>
                    </div>
                </div>
            </div>

            <!-- BODY PANEL -->
            <div class="card-body p-4" style="position: relative; min-height: 400px;">
                <!-- LAUNDRY SETTINGS PANEL -->
                <div id="panel-laundry" class="settings-panel transition-fade">
                    <form action="<?= base_url('/pengaturan/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nama_toko" class="form-label">Nama Toko</label>
                                <input type="text" class="form-control" id="nama_toko" name="nama_toko" value="<?= esc($settings['nama_toko'] ?? '') ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="jam_buka" class="form-label">Jam Operasional</label>
                                <input type="text" class="form-control" id="jam_buka" name="jam_buka" value="<?= esc($settings['jam_buka'] ?? '') ?>" placeholder="Misal: 08:00 - 20:00">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="telepon_toko" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="telepon_toko" name="telepon_toko" value="<?= esc($settings['telepon_toko'] ?? '') ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email_toko" class="form-label">Email Kontak</label>
                                <input type="email" class="form-control" id="email_toko" name="email_toko" value="<?= esc($settings['email_toko'] ?? '') ?>">
                            </div>
                            
                            <div class="col-12">
                                <label for="alamat_toko" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat_toko" name="alamat_toko" rows="2"><?= esc($settings['alamat_toko'] ?? '') ?></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="deskripsi" class="form-label">Catatan Tambahan di Nota</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= esc($settings['deskripsi'] ?? '') ?></textarea>
                                <div class="form-text">Pesan tambahan yang akan dicetak di bagian bawah struk transaksi pelanggan.</div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <hr class="mb-4" style="border-color: #e2e8f0;">
                                <button type="submit" class="btn btn-primary-gradient px-4 py-2.5">
                                    <i class="bi bi-check-lg me-1"></i> Simpan Profil Laundry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- USER SETTINGS PANEL -->
                <div id="panel-user" class="settings-panel transition-fade d-none">
                    <form action="<?= base_url('/pengaturan/update-profile') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $user['nama']) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                            </div>

                            <div class="col-12">
                                <hr style="border-color:#e2e8f0;margin:1rem 0;">
                                <h6 class="fw-bold mb-1"><i class="bi bi-lock-fill me-2" style="color:#0d9488;"></i>Ubah Password</h6>
                                <p class="form-text text-secondary mb-3">Kosongkan kolom di bawah jika tidak ingin mengubah password.</p>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter">
                            </div>
                            
                            <div class="col-12 mt-4">
                                <hr class="mb-4" style="border-color: #e2e8f0;">
                                <button type="submit" class="btn btn-primary-gradient px-4 py-2.5">
                                    <i class="bi bi-check-lg me-1"></i> Simpan Profil Saya
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Slide toggle design */
    .toggle-pill-container {
        position: relative;
        display: inline-flex;
        background: #ffffff;
        padding: 4px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    
    .active-pill-bg {
        position: absolute;
        top: 4px;
        left: 4px;
        bottom: 4px;
        width: 160px;
        background: var(--primary-gradient);
        border-radius: 25px;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
    }
    
    .btn-toggle-tab {
        position: relative;
        border: none;
        background: none;
        border-radius: 25px;
        font-size: 0.88rem;
        font-weight: 700;
        width: 160px;
        height: 42px;
        z-index: 2;
        transition: color 0.3s ease;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Transition styling */
    .transition-fade {
        transition: opacity 0.3s ease, transform 0.3s ease;
        opacity: 1;
        transform: translateY(0);
    }
    
    .transition-fade.fade-out {
        opacity: 0;
        transform: translateY(15px);
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Tab switcher function
    function switchSettingsTab(tabName) {
        const laundryBtn = document.getElementById('tab-laundry');
        const userBtn = document.getElementById('tab-user');
        const activeBg = document.querySelector('.active-pill-bg');
        
        const headerLaundry = document.getElementById('header-laundry');
        const headerUser = document.getElementById('header-user');
        
        const panelLaundry = document.getElementById('panel-laundry');
        const panelUser = document.getElementById('panel-user');

        if (tabName === 'laundry') {
            // Button styles
            laundryBtn.classList.remove('text-secondary');
            laundryBtn.classList.add('text-white');
            userBtn.classList.remove('text-white');
            userBtn.classList.add('text-secondary');
            
            // Slider pill shift
            activeBg.style.transform = 'translateX(0)';

            // Hide user panel with fade-out
            panelUser.classList.add('fade-out');
            setTimeout(() => {
                panelUser.classList.add('d-none');
                headerUser.classList.add('d-none');
                
                panelLaundry.classList.remove('d-none');
                headerLaundry.classList.remove('d-none');
                setTimeout(() => {
                    panelLaundry.classList.remove('fade-out');
                }, 50);
            }, 300);

        } else {
            // Button styles
            userBtn.classList.remove('text-secondary');
            userBtn.classList.add('text-white');
            laundryBtn.classList.remove('text-white');
            laundryBtn.classList.add('text-secondary');
            
            // Slider pill shift (exactly 160px corresponding to button width)
            activeBg.style.transform = 'translateX(160px)';

            // Hide laundry panel with fade-out
            panelLaundry.classList.add('fade-out');
            setTimeout(() => {
                panelLaundry.classList.add('d-none');
                headerLaundry.classList.add('d-none');
                
                panelUser.classList.remove('d-none');
                headerUser.classList.remove('d-none');
                setTimeout(() => {
                    panelUser.classList.remove('fade-out');
                }, 50);
            }, 300);
        }
    }

    // Auto-focus tab on load if there are validation errors or error alerts for User Profile
    window.addEventListener('DOMContentLoaded', (event) => {
        <?php if (session()->has('validation') || session()->getFlashdata('error') || old('nama')) : ?>
            switchSettingsTab('user');
        <?php endif; ?>
    });

    // Auto-hide alert blocks
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(a) {
            a.style.transition = 'opacity 0.5s ease'; a.style.opacity = '0';
            setTimeout(function() { a.remove(); }, 500);
        });
    }, 4000);
</script>
<?= $this->endSection() ?>
