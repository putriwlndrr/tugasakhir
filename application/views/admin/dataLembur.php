<div class="container-fluid">
    <?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

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

    <div class="alert alert-warning" role="alert">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    Lembur dicatat hanya untuk kepentingan <strong>monitoring dan evaluasi</strong>tidak dihitung dalam gaji karena tidak ada kompensasi lembur di kebijakan intansi pemerintah.
    </div>


    <!-- Card Container -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 font-weight-bold text-primary">Daftar Lembur Perangkat Kampung</h2>
            <div>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Lembur
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle mr-2"></i> Klik tombol <strong>Tambah Lembur</strong> di atas untuk menambahkan data lembur baru.
            </div>

            <!-- Filter Status -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" role="group">
                        <a href="<?= base_url('admin/dataLembur') . ($this->input->get('keyword') ? '?keyword='.$this->input->get('keyword') : '') ?>"
                           class="btn btn-outline-primary <?= !isset($_GET['status']) || $_GET['status'] == '' ? 'active' : '' ?>">
                            <i class="fas fa-list"></i> Semua
                        </a>
                        <a href="<?= base_url('admin/dataLembur?status=pending') . ($this->input->get('keyword') ? '&keyword='.$this->input->get('keyword') : '') ?>"
                           class="btn btn-outline-warning <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'active' : '' ?>">
                            <i class="fas fa-clock"></i> Pending
                        </a>
                        <a href="<?= base_url('admin/dataLembur?status=approved') . ($this->input->get('keyword') ? '&keyword='.$this->input->get('keyword') : '') ?>"
                           class="btn btn-outline-success <?= isset($_GET['status']) && $_GET['status'] == 'approved' ? 'active' : '' ?>">
                            <i class="fas fa-check-circle"></i> Approved
                        </a>
                        <a href="<?= base_url('admin/dataLembur?status=rejected') . ($this->input->get('keyword') ? '&keyword='.$this->input->get('keyword') : '') ?>"
                           class="btn btn-outline-danger <?= isset($_GET['status']) && $_GET['status'] == 'rejected' ? 'active' : '' ?>">
                            <i class="fas fa-times-circle"></i> Rejected
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Pencarian -->
            <form method="get" action="<?= base_url('admin/dataLembur') ?>" class="mb-4">
                <?php if(isset($_GET['status'])): ?>
                    <input type="hidden" name="status" value="<?= $_GET['status'] ?>">
                <?php endif; ?>
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari Nama Perangkat Kamp..." 
                           value="<?= $this->input->get('keyword') ?>" autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="<?= base_url('admin/dataLembur') ?>" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            </form>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-custom" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Perangkat</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Durasi</th>
                            <th>Alasan</th>
                            <th width="12%">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($lembur)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="fas fa-clock mr-2"></i>Tidak ada data lembur
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($lembur as $l): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($l->nama_pegawai) ?></td>
                                    <td><?= date('d/m/Y', strtotime($l->tanggal)) ?></td>
                                    <td><?= date('H:i', strtotime($l->jam_mulai)) ?></td>
                                    <td><?= date('H:i', strtotime($l->jam_selesai)) ?></td>
                                    <td><?= $l->durasi ?> jam</td>
                                    <td><?= htmlspecialchars($l->alasan) ?></td>
                                    <td>
                                        <?php if($l->status == 'pending'): ?>
                                            <span class="badge badge-warning p-2">
                                                <i class="fas fa-clock mr-1"></i> Pending
                                            </span>
                                        <?php elseif($l->status == 'approved'): ?>
                                            <span class="badge badge-success p-2">
                                                <i class="fas fa-check-circle mr-1"></i> Approved
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-danger p-2">
                                                <i class="fas fa-times-circle mr-1"></i> Rejected
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?php if ($l->status == 'pending'): ?>
                                                <a href="<?= site_url('admin/dataLembur/setApproved/' . $l->id_lembur) ?>" 
                                                   class="btn btn-sm btn-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="<?= site_url('admin/dataLembur/setRejected/' . $l->id_lembur) ?>" 
                                                   class="btn btn-sm btn-danger" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= site_url('admin/dataLembur/hapus/' . $l->id_lembur) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   title="Hapus"
                                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url('admin/dataLembur/store') ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Lembur</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Perangkat Kampung</label>
                        <select name="id_pegawai" class="form-control select2" required>
                            <option value="" disabled selected>-- Pilih Perangkat Kampung --</option>
                            <?php foreach ($pegawai as $p): ?>
                                <option value="<?= $p->id_pegawai ?>">
                                    <?= $p->nik ?> - <?= $p->nama_pegawai ?> (<?= $p->jabatan ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lembur</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alasan Lembur</label>
                        <textarea name="alasan" class="form-control" rows="3" required></textarea>
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

.badge {
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.5em 0.75em;
    display: inline-flex;
    align-items: center;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

.breadcrumb .breadcrumb-item a {
    text-decoration: none;
}

.breadcrumb .breadcrumb-item.active {
    font-weight: 500;
}

h1.h3 {
    color: #2c3e50;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e3e6f0;
}

.alert-info {
    background-color: #e7f5fe;
    border-color: #b8e2fb;
    color: #0c5460;
}
</style>

<script>
$(document).ready(function() {
    // Inisialisasi Select2
    if($('.select2').length) {
        $('.select2').select2({
            placeholder: "Pilih Perangkat Kampung",
            width: '100%'
        });
    }

    // Validasi jam selesai harus setelah jam mulai
    $('input[name="jam_selesai"]').change(function() {
        const start = $('input[name="jam_mulai"]').val();
        const end = $(this).val();
        
        if(start && end && start >= end) {
            alert('Jam selesai harus setelah jam mulai!');
            $(this).val('');
        }
    });
});

</script>


