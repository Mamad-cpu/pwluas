<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger animate-fadeInUp" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card animate-fadeInUp" style="opacity:0">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-plus-circle-fill me-2" style="color: #0d9488;"></i>
                Buat Pesanan Baru
            </h5>
            <a href="<?= base_url('/pesanan') ?>" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/pesanan/store') ?>" method="POST" id="formPesanan">
            <?= csrf_field() ?>

            <div class="row g-3 mb-4">
                <!-- Member -->
                <div class="col-md-4">
                    <label for="member_id" class="form-label">Member <span class="text-danger">*</span></label>
                    <select class="form-select" id="member_id" name="member_id" required>
                        <option value="">-- Pilih Member --</option>
                        <?php foreach ($members as $m) : ?>
                            <option value="<?= $m['id'] ?>"><?= esc($m['nama_member']) ?> (<?= esc($m['no_handphone'] ?: 'No HP') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tanggal Terima -->
                <div class="col-md-4">
                    <label for="tgl_terima" class="form-label">Tanggal Terima <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tgl_terima" name="tgl_terima" value="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- Estimasi Selesai -->
                <div class="col-md-4">
                    <label for="tgl_selesai" class="form-label">Estimasi Selesai</label>
                    <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                </div>
            </div>

            <!-- ITEM LAYANAN -->
            <h6 class="fw-bold mb-3"><i class="bi bi-list-check me-2" style="color:#0d9488;"></i>Rincian Cucian</h6>
            <div class="table-responsive mb-3">
                <table class="table" id="itemTable">
                    <thead>
                        <tr>
                            <th style="min-width:200px;">Paket Layanan</th>
                            <th style="width:120px;">Tarif</th>
                            <th style="width:100px;">Jumlah</th>
                            <th style="width:150px;">Subtotal</th>
                            <th style="width:60px;"></th>
                        </tr>
                    </thead>
                    <tbody id="itemBody">
                        <!-- Dynamic rows added by JS -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold" style="font-size:1rem;">Total Tagihan:</td>
                            <td class="price-tag" style="font-size:1.1rem;" id="totalDisplay">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button type="button" class="btn btn-outline-primary mb-4" style="border-radius:10px;font-size:0.85rem;" onclick="addItem()">
                <i class="bi bi-plus-lg me-1"></i> Tambah Item
            </button>

            <!-- Catatan -->
            <div class="mb-4">
                <label for="catatan_khusus" class="form-label">Catatan Khusus</label>
                <textarea class="form-control" id="catatan_khusus" name="catatan_khusus" rows="2" placeholder="Catatan tambahan (opsional)..."></textarea>
            </div>

            <hr class="mb-4" style="border-color: #e2e8f0;">
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary-gradient" id="btnSubmit">
                    <i class="bi bi-check-lg" id="submitIcon"></i> <span id="submitText">Buat Pesanan</span>
                </button>
                <a href="<?= base_url('/pesanan') ?>" class="btn btn-outline-secondary" style="border-radius:10px;padding:10px 24px;">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var layananData = <?= json_encode($layanan) ?>;
    var itemIndex = 0;

    function addItem() {
        var row = document.createElement('tr');
        row.id = 'row-' + itemIndex;

        var optionsHtml = '<option value="">-- Pilih Paket --</option>';
        layananData.forEach(function(l) {
            optionsHtml += '<option value="' + l.id + '" data-tarif="' + l.tarif + '" data-satuan="' + l.satuan_hitung + '">' + l.nama_paket + ' (' + l.satuan_hitung + ')</option>';
        });

        row.innerHTML = `
            <td>
                <select class="form-select form-select-sm" name="items[${itemIndex}][layanan_id]" onchange="updateTarif(this, ${itemIndex})" required style="border-radius:8px;">
                    ${optionsHtml}
                </select>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" id="tarif-${itemIndex}" readonly style="background:#f8fafc;border-radius:8px;" placeholder="0">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" name="items[${itemIndex}][qty]" id="qty-${itemIndex}" min="0.1" step="0.1" value="1" onchange="calcSubtotal(${itemIndex})" oninput="calcSubtotal(${itemIndex})" required style="border-radius:8px;">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" id="subtotal-display-${itemIndex}" readonly style="background:#f8fafc;border-radius:8px;font-weight:600;color:#0d9488;" placeholder="Rp 0">
                <input type="hidden" name="items[${itemIndex}][subtotal]" id="subtotal-${itemIndex}" value="0">
            </td>
            <td>
                <button type="button" class="btn-action btn-delete" onclick="removeItem(${itemIndex})" title="Hapus"><i class="bi bi-x-lg"></i></button>
            </td>
        `;

        document.getElementById('itemBody').appendChild(row);
        itemIndex++;
    }

    function updateTarif(select, idx) {
        var option = select.options[select.selectedIndex];
        var tarif = option.getAttribute('data-tarif') || 0;
        document.getElementById('tarif-' + idx).value = 'Rp ' + parseInt(tarif).toLocaleString('id-ID');
        document.getElementById('tarif-' + idx).setAttribute('data-raw', tarif);
        calcSubtotal(idx);
    }

    function calcSubtotal(idx) {
        var tarifEl = document.getElementById('tarif-' + idx);
        var tarif = parseFloat(tarifEl.getAttribute('data-raw')) || 0;
        var qty = parseFloat(document.getElementById('qty-' + idx).value) || 0;
        var subtotal = tarif * qty;

        document.getElementById('subtotal-' + idx).value = subtotal;
        document.getElementById('subtotal-display-' + idx).value = 'Rp ' + subtotal.toLocaleString('id-ID');
        calcTotal();
    }

    function removeItem(idx) {
        var row = document.getElementById('row-' + idx);
        if (row) row.remove();
        calcTotal();
    }

    function calcTotal() {
        var total = 0;
        document.querySelectorAll('[id^="subtotal-"]:not([id*="display"])').forEach(function(el) {
            total += parseFloat(el.value) || 0;
        });
        document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    addItem();

    document.getElementById('formPesanan').addEventListener('submit', function(e) {
        var btn = document.getElementById('btnSubmit');
        btn.setAttribute('disabled', 'disabled');
        btn.classList.add('opacity-75');
        document.getElementById('submitText').textContent = 'Memproses...';
        document.getElementById('submitIcon').className = 'spinner-border spinner-border-sm';
    });
</script>
<?= $this->endSection() ?>
