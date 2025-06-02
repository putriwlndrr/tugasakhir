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

    <div class="alert alert-warning" role="alert">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    Halaman ini hanya digunakan untuk <strong>monitoring kehadiran</strong>data bersifat informatif dan tidak memengaruhi perhitungan gaji.
</div>


    <!-- Card Container -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 font-weight-bold text-primary">Daftar Absensi Perangkat Kampung</h2>
            <div>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data Absensi
                </button>
                <a href="<?= base_url('admin/dataAbsensi/export') ?>" class="btn btn-success btn-sm ml-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="get" action="<?= base_url('admin/dataAbsensi') ?>" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Bulan</label>
                            <select name="bulan" class="form-control">
                                <option value="">-- Semua Bulan --</option>
                                <?php for($i=1; $i<=12; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($this->input->get('bulan') == $i) ? 'selected' : '' ?>>
                                        <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select name="tahun" class="form-control">
                                <option value="">-- Semua Tahun --</option>
                                <?php for($i=date('Y'); $i>=date('Y')-5; $i--): ?>
                                    <option value="<?= $i ?>" <?= ($this->input->get('tahun') == $i) ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Perangkat Kampung</label>
                            <select name="pegawai" class="form-control">
                                <option value="">-- Semua Perangkat Kampung --</option>
                                <?php foreach($pegawai_list as $p): ?>
                                    <option value="<?= $p->id_pegawai ?>" <?= ($this->input->get('pegawai') == $p->id_pegawai) ? 'selected' : '' ?>>
                                        <?= $p->nama_pegawai ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Tabel Absensi -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="15%">Tanggal</th>
                            <th>Nama Perangkat</th>
                            <th width="10%" class="text-center">Jam Masuk</th>
                            <th width="10%" class="text-center">Jam Keluar</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Keterangan</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($absensi)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-calendar-times mr-2"></i> Tidak ada data absensi
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($absensi as $a): ?>
                                <?php 
                                  $is_weekend = (date('N', strtotime($a->tanggal)) >= 6);
                                    $is_holiday = in_array($a->tanggal, $tanggal_libur);
                                    $status_class = '';
                                    
                                   if($is_holiday) {
                                        $status_class = 'bg-success text-white';
                                    } elseif($is_weekend) {
                                        $status_class = 'bg-info text-white';
                                    } elseif($a->status == 'Tidak Hadir') {
                                        $status_class = 'bg-danger text-white';
                                    } elseif($a->status == 'Hadir') {
                                        $status_class = 'bg-primary text-white';
                                    } elseif($a->status == 'Izin') {
                                        $status_class = 'bg-warning text-white';
                                    }
                                    elseif($a->status == 'Sakit') {
                                        $status_class = 'bg-secondary text-white';
                                    }

                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <?= date('d-m-Y', strtotime($a->tanggal)) ?>
                                        <?php if($is_holiday): ?>
                                            <span class="badge badge-success ml-1">Libur</span>
                                        <?php elseif($is_weekend): ?>
                                            <span class="badge badge-info ml-1">Weekend</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($a->nama_pegawai) ?></td>
                                    <td class="text-center"><?= $a->jam_masuk ?: '-' ?></td>
                                    <td class="text-center"><?= $a->jam_keluar ?: '-' ?></td>
                                    <td class="text-center <?= $status_class ?>">
                                        <?= $a->status ?>
                                        <?php if($a->status == 'Tidak Hadir' && !$is_holiday && !$is_weekend): ?>
                                            <br><small>(Potongan: <?= format_rupiah($potongan_absensi) ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($a->keterangan) ?: '-' ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#editModal<?= $a->id_absensi ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/dataAbsensi/hapus/'.$a->id_absensi) ?>" 
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
                <?php if(isset($pagination)): ?>
                    <div class="mt-3">
                        <?= $pagination ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Data Absensi</h5>
            </div>
            <form action="<?= base_url('admin/dataAbsensi/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Perangkat Kampung</label>
                        <select name="id_pegawai" class="form-control" required>
                            <option value="">-- Pilih Perangkat Kampung --</option>
                            <?php foreach($pegawai_list as $p): ?>
                                <option value="<?= $p->id_pegawai ?>"><?= $p->nama_pegawai ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jam Keluar</label>
                        <input type="time" name="jam_keluar" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Tidak Hadir">Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
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
<?php foreach($absensi as $a): ?>
<div class="modal fade" id="editModal<?= $a->id_absensi ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Absensi</h5>
            </div>
            <form action="<?= base_url('admin/dataAbsensi/edit/'.$a->id_absensi) ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Perangkat Kampung</label>
                        <select name="id_pegawai" class="form-control" required>
                            <?php foreach($pegawai_list as $p): ?>
                                <option value="<?= $p->id_pegawai ?>" <?= ($a->id_pegawai == $p->id_pegawai) ? 'selected' : '' ?>>
                                    <?= $p->nama_pegawai ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $a->tanggal ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk" class="form-control" value="<?= $a->jam_masuk ?>">
                    </div>
                    <div class="form-group">
                        <label>Jam Keluar</label>
                        <input type="time" name="jam_keluar" class="form-control" value="<?= $a->jam_keluar ?>">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Hadir" <?= ($a->status == 'Hadir') ? 'selected' : '' ?>>Hadir</option>
                            <option value="Izin" <?= ($a->status == 'Izin') ? 'selected' : '' ?>>Izin</option>
                            <option value="Sakit" <?= ($a->status == 'Sakit') ? 'selected' : '' ?>>Sakit</option>
                            <option value="Tidak Hadir" <?= ($a->status == 'Tidak Hadir') ? 'selected' : '' ?>>Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"><?= $a->keterangan ?></textarea>
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
/* ========== Status Styles ========== */

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

</style>

<script>
$(document).ready(function() {
    // Validasi dan update form
    $('form').submit(function() {
        const status = $(this).find('select[name="status"]').val();
        const jamMasuk = $(this).find('input[name="jam_masuk"]').val();
        const jamKeluar = $(this).find('input[name="jam_keluar"]').val();
        
        if(status === 'Hadir' && (!jamMasuk || !jamKeluar)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jam masuk dan jam keluar wajib diisi untuk status Hadir!',
            });
            return false;
        }
        return true;
    });

    // Update form berdasarkan status
    $('select[name="status"]').change(function() {
        const formGroup = $(this).closest('.modal-content');
        const jamInputs = formGroup.find('input[name="jam_masuk"], input[name="jam_keluar"]');
        
        if($(this).val() !== 'Hadir') {
            jamInputs.val('').prop('disabled', true);
        } else {
            jamInputs.prop('disabled', false);
        }
    });

    // Tooltip untuk keterangan
    $('[data-toggle="tooltip"]').tooltip();
});
</script>