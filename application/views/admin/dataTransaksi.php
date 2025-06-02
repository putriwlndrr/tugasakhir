<!-- view/admin/data_transaksi.php -->
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

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 font-weight-bold text-primary">Daftar Data Catatan Gaji</h2>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">
                <i class="fas fa-plus"></i> Tambah Catatan Gaji
            </button>
        </div>
        <div class="card-body">
            <div class="alert alert-info"><i class="fas fa-info-circle mr-2"></i> Klik tombol <strong>Tambah Catatan Gaji</strong> untuk menambahkan data baru.</div>

            <!-- Status Filter -->
            <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                <a href="<?= base_url('admin/dataTransaksi') ?>" class="btn btn-outline-primary <?= !isset($_GET['status']) ? 'active' : '' ?>"><i class="fas fa-list"></i> Semua</a>
                <a href="<?= base_url('admin/dataTransaksi?status=pending') ?>" class="btn btn-outline-warning <?= @$_GET['status'] == 'pending' ? 'active' : '' ?>"><i class="fas fa-clock"></i> Pending</a>
                <a href="<?= base_url('admin/dataTransaksi?status=approved') ?>" class="btn btn-outline-success <?= @$_GET['status'] == 'approved' ? 'active' : '' ?>"><i class="fas fa-check-circle"></i> Approved</a>
                <a href="<?= base_url('admin/dataTransaksi?status=rejected') ?>" class="btn btn-outline-danger <?= @$_GET['status'] == 'rejected' ? 'active' : '' ?>"><i class="fas fa-times-circle"></i> Rejected</a>
            </div>

            <!-- Search -->
            <form method="get" action="<?= base_url('admin/dataTransaksi') ?>" class="mb-4">
                <?php if (isset($_GET['status'])): ?>
                    <input type="hidden" name="status" value="<?= $_GET['status'] ?>">
                <?php endif; ?>
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari NIK, Nama, Jabatan..." value="<?= $this->input->get('keyword') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        <a href="<?= base_url('admin/dataTransaksi') ?>" class="btn btn-secondary"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Total Gaji</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dataTransaksi)): ?>
                            <tr><td colspan="8" class="text-center text-muted">Tidak ada data ditemukan</td></tr>
                        <?php else: $no = 1; foreach ($dataTransaksi as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $t->nama_pegawai ?></td>
                                <td><?= $t->jabatan ?></td>
                                <td>Rp <?= number_format($t->gaji_pokok, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($t->tunjangan, 0, ',', '.') ?></td>
                                <td class="font-weight-bold">Rp <?= number_format($t->total_gaji, 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($t->status == 'pending'): ?>
                                        <span class="badge badge-warning p-2"><i class="fas fa-clock"></i> Pending</span>
                                    <?php elseif ($t->status == 'approved'): ?>
                                        <span class="badge badge-success p-2"><i class="fas fa-check-circle"></i> Approved</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger p-2"><i class="fas fa-times-circle"></i> Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <?php if ($t->status == 'pending'): ?>
                                            <a href="<?= site_url('admin/dataTransaksi/setApproved/' . $t->id_transaksi) ?>" class="btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                                            <a href="<?= site_url('admin/dataTransaksi/setRejected/' . $t->id_transaksi) ?>" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                        <?php else: ?>
                                            <a href="<?= site_url('admin/dataTransaksi/hapus/' . $t->id_transaksi) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Catatan Gaji -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('admin/dataTransaksi/store') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Tambah Catatan Gaji</h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Perangkat Kampung</label>
            <select name="id_pegawai" class="form-control select2" id="pegawaiSelect" required>
              <option value="">Pilih</option>
              <?php foreach ($pegawai as $p): 
                $jabatan = $this->db->get_where('data_jabatan', ['nama_jabatan' => $p->jabatan])->row(); ?>
                <option value="<?= $p->id_pegawai ?>"
                        data-nik="<?= $p->nik ?>"
                        data-nama="<?= $p->nama_pegawai ?>"
                        data-jabatan="<?= $p->jabatan ?>"
                        data-gaji-pokok="<?= $jabatan->gaji_pokok ?? 0 ?>"
                        data-tunjangan="<?= $jabatan->tunjangan ?? 0 ?>">
                  <?= $p->nik ?> - <?= $p->nama_pegawai ?> (<?= $p->jabatan ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" id="nik" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Gaji Pokok</label>
            <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label>Tunjangan</label>
            <input type="number" name="tunjangan" id="tunjangan" class="form-control" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button class="btn btn-primary" type="submit">Simpan</button>
        </div>
      </div>
    </form>
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
// Auto-fill data untuk modal tambah
document.getElementById('pegawaiSelect').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('nik').value = selected.dataset.nik;
    document.getElementById('nama_pegawai').value = selected.dataset.nama;
    document.getElementById('jabatan').value = selected.dataset.jabatan;
    document.getElementById('gaji_pokok').value = formatRupiah(selected.dataset.gajiPokok);
    document.getElementById('tunjangan').value = formatRupiah(selected.dataset.tunjangan);
    document.getElementById('total_gaji').value = formatRupiah(parseInt(selected.dataset.gajiPokok) + parseInt(selected.dataset.tunjangan));
});

// Format angka ke Rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}

// Inisialisasi Select2 jika ada
$(document).ready(function() {
    if($('.select2').length) {
        $('.select2').select2({
            placeholder: "Pilih Perangkat Kampung",
            width: '100%'
        });
    }
});
</script>

<!-- Script untuk mengisi otomatis -->
<script>
document.getElementById('pegawaiSelect').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];
    document.getElementById('nik').value = selected.dataset.nik || '';
    document.getElementById('nama_pegawai').value = selected.dataset.nama || '';
    document.getElementById('jabatan').value = selected.dataset.jabatan || '';
    document.getElementById('gaji_pokok').value = selected.dataset.gajiPokok || 0;
    document.getElementById('tunjangan').value = selected.dataset.tunjangan || 0;
});
</script>
