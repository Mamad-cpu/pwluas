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
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-people-fill me-2" style="color: #0d9488;"></i>
                    Daftar Member Laundry
                </h5>
                <a href="<?= base_url('/member/create') ?>" class="btn btn-primary-gradient">
                    <i class="bi bi-plus-lg"></i>
                    Daftar Member Baru
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($members)) : ?>
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h5>Belum Ada Data Member</h5>
                        <p class="text-secondary mt-2">Mulai daftarkan member pertama Anda dengan menekan tombol di atas.</p>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mt-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Member</th>
                                    <th>No. Handphone</th>
                                    <th>Alamat</th>
                                    <th>Terdaftar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($members as $item) : ?>
                                    <tr>
                                        <td class="fw-semibold text-secondary"><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="https://i.pravatar.cc/150?u=member<?= esc($item['id']) ?>" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                <div class="fw-semibold"><?= esc($item['nama_member']) ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="bi bi-telephone text-secondary me-1"></i>
                                            <?= esc($item['no_handphone'] ?: '-') ?>
                                        </td>
                                        <td>
                                            <span class="text-secondary" style="font-size: 0.82rem;">
                                                <?= esc(character_limiter($item['alamat_lengkap'] ?? '-', 40)) ?>
                                            </span>
                                        </td>
                                        <td class="text-secondary" style="font-size: 0.82rem;">
                                            <?= date('d M Y', strtotime($item['created_at'])) ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= base_url('/member/edit/' . $item['id']) ?>"
                                                   class="btn-action btn-edit" title="Ubah Data">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <button type="button" class="btn-action btn-delete" title="Hapus Member"
                                                        onclick="confirmDelete(<?= $item['id'] ?>, '<?= esc($item['nama_member']) ?>')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
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
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="stat-card stat-purple">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-value"><?= count($members) ?></div>
                    <div class="stat-label">Total Member</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-body text-center p-4">
                <div style="width:70px;height:70px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size:2rem;color:#dc2626;"></i>
                </div>
                <h5 class="fw-bold mb-2">Konfirmasi Hapus</h5>
                <p class="text-secondary mb-0">Apakah Anda yakin ingin menghapus member</p>
                <p class="fw-bold mb-4" id="deleteItemName"></p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" style="border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="deleteLink" class="btn btn-danger px-4" style="border-radius:10px;">
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
        document.getElementById('deleteLink').href = '<?= base_url('/member/delete/') ?>' + id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(a) {
            a.style.transition = 'opacity 0.5s ease'; a.style.opacity = '0';
            setTimeout(function() { a.remove(); }, 500);
        });
    }, 4000);
</script>
<?= $this->endSection() ?>
