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
            <h2 class="m-0 font-weight-bold text-primary">Daftar Data Perangkat Kampung</h2>
            <div>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data Perangkat Kampung
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Tambahkan teks untuk memperjelas fungsi tombol -->
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle mr-2"></i> Klik tombol <strong>Tambah Data Perangkat Kampung</strong> di atas untuk menambahkan data Perangkat Kampung baru.
            </div>

            <!-- Search Form -->
            <form method="post" action="<?= base_url('admin/dataPegawai') ?>" class="mb-4">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari Perangkat Kampung..." value="<?= $this->input->post('keyword') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="<?= base_url('admin/dataPegawai') ?>" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            </form>

            <!-- Tabel Pegawai -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="15%">NIK</th>
                            <th>Nama Perangkat Kampung</th>
                            <th width="10%" class="text-center">Jenis Kelamin</th>
                            <th width="15%">Jabatan</th>
                            <th width="12%" class="text-center">Tanggal Masuk</th>
                            <th width="8%" class="text-center">Foto</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($pegawai)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-user-slash mr-2"></i> Tidak ada data Perangkat Kampung
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($pegawai as $p): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($p->nik) ?></td>
                                    <td><?= htmlspecialchars($p->nama_pegawai) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($p->jenis_kelamin) ?></td>
                                    <td><?= htmlspecialchars($p->jabatan) ?></td>
                                    <td class="text-center"><?= date('d-m-Y', strtotime($p->tanggal_masuk)) ?></td>
                                    <td class="text-center">
                                        <?php if(!empty($p->photo)): ?>
                                            <img src="<?= base_url('assets/img/'.$p->photo) ?>" alt="Foto" width="40" class="rounded-circle">
                                        <?php else: ?>
                                            <i class="fas fa-user-circle text-muted" style="font-size: 1.5rem;"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#editModal<?= $p->id_pegawai ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/dataPegawai/hapus/'.$p->id_pegawai) ?>" 
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
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Data Perangkat Kampung</h5>
            </div>
            <form action="<?= base_url('admin/dataPegawai/tambah') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Perangkat Kampung</label>
                        <input type="text" name="nama_pegawai" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="jabatan" class="form-control" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach($jabatan_list as $j): ?>
                                <option value="<?= $j ?>"><?= $j ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <div class="custom-file">
                            <input type="file" name="photo" class="custom-file-input" id="customFile">
                            <!-- <label class="custom-file-label" for="customFile">Pilih file</label> -->
                        </div>
                        <small class="form-text text-muted">Format: JPG/PNG (Maks. 2MB)</small>
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
<?php foreach($pegawai as $p): ?>
<div class="modal fade" id="editModal<?= $p->id_pegawai ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Perangkat Kampung</h5>
            </div>
            <form action="<?= base_url('admin/dataPegawai/edit/'.$p->id_pegawai) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?= $p->nik ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Perangkat Kampung</label>
                        <input type="text" name="nama_pegawai" class="form-control" value="<?= $p->nama_pegawai ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="Laki-laki" <?= $p->jenis_kelamin == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $p->jenis_kelamin == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="jabatan" class="form-control" required>
                            <?php foreach($jabatan_list as $j): ?>
                                <option value="<?= $j ?>" <?= $p->jabatan == $j ? 'selected' : '' ?>><?= $j ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="<?= $p->tanggal_masuk ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <div class="custom-file">
                            <input type="file" name="photo" class="custom-file-input" id="customFile<?= $p->id_pegawai ?>">
                            <label class="custom-file-label" for="customFile<?= $p->id_pegawai ?>"><?= $p->photo ?: 'Pilih file' ?></label>
                        </div>
                        <?php if($p->photo): ?>
                            <small class="form-text text-muted">Foto saat ini: <?= $p->photo ?></small>
                        <?php else: ?>
                            <small class="form-text text-muted">Format: JPG/PNG (Maks. 2MB)</small>
                        <?php endif; ?>
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
    border-left: 4px solid #4e73df;
}

/* Button Styles */
.btn {
    transition: all 0.2s ease;
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #3d5dd9;
    border-color: #3a56d4;
}

.btn-secondary {
    background-color: #858796;
    border-color: #858796;
}

.btn-secondary:hover {
    background-color: #717384;
    border-color: #6b6d7d;
}

/* Custom File Input */
/* .custom-file-label::after {
    content: "Browse";
} */

/* Modal Styles */
.modal-header {
    padding: 1rem 1.25rem;
}

.modal-title {
    font-weight: 600;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        display: block;
        overflow-x: auto;
    }
}
</style>

<script>
// Untuk menampilkan nama file di input file
document.querySelectorAll('.custom-file-input').forEach(input => {
    input.addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || e.target.nextElementSibling.textContent;
        e.target.nextElementSibling.textContent = fileName;
    });
});
</script>