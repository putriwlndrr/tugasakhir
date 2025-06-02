<div class="container-fluid">
    <!-- Judul dan Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
            </ol>
        </nav>
    </div>

    <!-- Card Container -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 font-weight-bold text-primary">Daftar Laporan Gaji Perangkat Kampung</h2>
        </div>
        <div class="card-body">
            <!-- Tambahkan teks untuk memperjelas fungsi filter -->
            <div class="alert alert-info mb-4" role="alert">
                Gunakan filter di bawah untuk melihat laporan gaji berdasarkan Perangkat Kampung tertentu.
            </div>
            
            <!-- Filter Section -->
            <div class="row align-items-end mb-4">
                <div class="col-md-8">
                    <form method="get" action="<?= base_url('admin/laporanGaji') ?>" class="form-inline flex-wrap">
                        <div class="form-group mr-3 mb-2">
                            <label for="nama" class="mr-2">Nama Perangkat Kampung</label>
                            <select name="nama" id="nama" class="form-control">
                                <option value="">-- Semua Perangkat Kampung --</option>
                                <?php foreach ($pegawai as $p): ?>
                                    <option value="<?= $p->nama_pegawai ?>" <?= ($this->input->get('nama') == $p->nama_pegawai) ? 'selected' : '' ?>>
                                        <?= $p->nama_pegawai ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2 mb-2">
                            <i class="fas fa-eye"></i> Tampilkan
                        </button>
                        <a href="<?= base_url('admin/laporanGaji') ?>" class="btn btn-secondary mb-2">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </form>
                </div>

                <!-- Cetak Button Aligned Bottom -->
                <div class="col-md-4 d-flex justify-content-end align-items-end">
                    <a href="<?= base_url('admin/laporanGaji/print?nama=' . urlencode($this->input->get('nama'))) ?>" 
                       target="_blank" 
                       class="btn btn-success mb-2">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </a>
                </div>
            </div>

            <!-- Tabel Laporan -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th width="12%" class="text-right">Gaji Pokok</th>
                            <th width="12%" class="text-right">Tunjangan</th>
                            <th width="12%" class="text-right">Total Gaji</th>
                            <th width="15%" class="text-center">Tanggal Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($laporan)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-file-alt mr-2"></i> Tidak ada data ditemukan
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach ($laporan as $lp): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($lp->nama_pegawai); ?></td>
                                    <td><?= htmlspecialchars($lp->jabatan); ?></td>
                                    <td class="text-right">Rp <?= number_format($lp->gaji_pokok, 0, ',', '.'); ?></td>
                                    <td class="text-right">Rp <?= number_format($lp->tunjangan, 0, ',', '.'); ?></td>
                                    <td class="text-right font-weight-bold">Rp <?= number_format($lp->total_gaji, 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <?php 
                                            $tanggal = $lp->tanggal_transaksi ?? null;
                                            echo $tanggal ? date('d-m-Y H:i', strtotime($tanggal)) : '-';                                        
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
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
</style>