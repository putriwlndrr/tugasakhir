<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Judul dan Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
    </div>

    <!-- Card Container -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 font-weight-bold text-primary">Daftar Data Jabatan</h2>
            <div>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data Jabatan
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Tambahkan teks untuk memperjelas fungsi tombol -->
            <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle mr-2"></i> Klik tombol <strong>Tambah Data Jabatan</strong> di atas untuk menambahkan data jabatan baru.
            </div>
            
            <!-- Search Form -->
            <form method="post" action="<?= base_url('admin/dataJabatan') ?>" class="mb-4">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari jabatan..." value="<?= $this->input->post('keyword') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="<?= base_url('admin/dataJabatan') ?>" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            </form>

            <!-- Tabel Jabatan -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Jabatan</th>
                            <th>Deskripsi</th>
                            <th width="12%" class="text-right">Gaji Pokok</th>
                            <th width="12%" class="text-right">Tunjangan</th>
                            <th width="12%" class="text-right">Total</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($jabatan)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-briefcase-slash mr-2"></i> Tidak ada data jabatan
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($jabatan as $j): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($j->nama_jabatan) ?></td>
                                    <td><?= htmlspecialchars($j->deskripsi_jabatan) ?></td>
                                    <td class="text-right">Rp <?= number_format($j->gaji_pokok, 0, ',', '.') ?></td>
                                    <td class="text-right">Rp <?= number_format($j->tunjangan, 0, ',', '.') ?></td>
                                    <td class="text-right">Rp <?= number_format($j->gaji_pokok + $j->tunjangan, 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#editModal<?= $j->id_jabatan ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/dataJabatan/hapus/'.$j->id_jabatan) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Yakin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div> <!-- Penutup card-body -->
    </div> <!-- Penutup card -->
</div> <!-- Penutup container-fluid -->

<!-- Tambahkan CSS Profesional -->
<style>
/* Custom Table Styles */
.table {
    font-family: 'Nunito', sans-serif;
    font-size: 0.92rem;
    color: #343a40;
    background-color: #fff;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    font-size: 0.95rem;
    font-weight: 700;
    background-color: #f8f9fa;
    color: #212529;
    padding: 12px 16px;
    vertical-align: middle;
    border-bottom: 2px solid #e3e6f0;
    position: sticky;
    top: 0;
}

.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border-top: 1px solid #e3e6f0;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Alignment for number columns */
.text-right {
    padding-right: 20px;
}

/* Breadcrumb Styles */
.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item a {
    color: #4e73df;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #858796;
}

/* Card Header Styles */
.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

/* Alert Styles */
.alert-info {
    background-color: #e7f5fe;
    border-color: #b8e2fb;
    color: #0c5460;
}

/* Button Styles */
.btn {
    transition: all 0.2s ease;
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-success {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

.btn-secondary {
    background-color: #858796;
    border-color: #858796;
}
</style>


<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Data Jabatan</h5>
            </div>
            <form action="<?= base_url('admin/dataJabatan/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <select name="nama_jabatan" class="form-control" id="tambahJabatanSelect" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach($jabatan_list as $option): ?>
                                <option value="<?= $option ?>"><?= $option ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Jabatan</label>
                        <textarea name="deskripsi_jabatan" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gaji Pokok</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="gaji_pokok" id="tambahGajiPokok" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tunjangan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="tunjangan" id="tambahTunjangan" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach($jabatan as $j): ?>
<div class="modal fade" id="editModal<?= $j->id_jabatan ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Jabatan</h5>
            </div>
            <form action="<?= base_url('admin/dataJabatan/edit/'.$j->id_jabatan) ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <select name="nama_jabatan" class="form-control" id="editJabatanSelect<?= $j->id_jabatan ?>" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach($jabatan_list as $option): ?>
                                <option value="<?= $option ?>" <?= ($option == $j->nama_jabatan) ? 'selected' : '' ?>>
                                    <?= $option ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi_jabatan" class="form-control" rows="3" required><?= $j->deskripsi_jabatan ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gaji Pokok</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="editGajiPokok<?= $j->id_jabatan ?>" class="form-control" value="<?= number_format($j->gaji_pokok, 0, ',', '.') ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tunjangan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="editTunjangan<?= $j->id_jabatan ?>" class="form-control" value="<?= number_format($j->tunjangan, 0, ',', '.') ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
// Data gaji sesuai controller
const gajiData = {
    'Kepala Kampung': { gaji_pokok: 2500000, tunjangan: 50000 },
    'Sekretaris Kampung': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kepala Seksi Pemerintahan': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kepala Seksi Kesejahteraan': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kepala Seksi Pelayanan': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kaur Umum dan Perencanaan': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kaur Keuangan': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kadus Adi Luhur': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kadus Adi Luwih': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kadus Adi Mulyo': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kadus Adi Negoro': { gaji_pokok: 2250000, tunjangan: 50000 },
    'Kadus Adi Rejo': { gaji_pokok: 2250000, tunjangan: 50000 }
};

// Format Rupiah
function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Handle perubahan select jabatan di modal tambah
document.getElementById('tambahJabatanSelect').addEventListener('change', function() {
    const selectedJabatan = this.value;
    const gajiPokokInput = document.getElementById('tambahGajiPokok');
    const tunjanganInput = document.getElementById('tambahTunjangan');
    
    if (gajiData[selectedJabatan]) {
        gajiPokokInput.value = formatRupiah(gajiData[selectedJabatan].gaji_pokok);
        tunjanganInput.value = formatRupiah(gajiData[selectedJabatan].tunjangan);
    } else {
        gajiPokokInput.value = '';
        tunjanganInput.value = '';
    }
});

// Handle perubahan select jabatan di modal edit
document.addEventListener('change', function(e) {
    if (e.target && e.target.id.startsWith('editJabatanSelect')) {
        const id = e.target.id.replace('editJabatanSelect', '');
        const selectedJabatan = e.target.value;
        const gajiPokokInput = document.getElementById('editGajiPokok' + id);
        const tunjanganInput = document.getElementById('editTunjangan' + id);
        
        if (gajiData[selectedJabatan]) {
            gajiPokokInput.value = formatRupiah(gajiData[selectedJabatan].gaji_pokok);
            tunjanganInput.value = formatRupiah(gajiData[selectedJabatan].tunjangan);
        }
    }
});
</script>

