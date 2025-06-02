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
        <div class="card-header py-3">
            <h2 class="m-0 font-weight-bold text-primary">Daftar Pengguna Sistem</h2>
        </div>
        <div class="card-body">
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle mr-2"></i> Halaman ini hanya menampilkan daftar pengguna yang terdaftar dalam sistem.
            </div>

            <!-- Tabel User -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="25%">Username</th>
                            <th width="25%">Password</th>
                            <th width="20%">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-user-slash mr-2"></i> Tidak ada data pengguna
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($users as $user): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($user->username) ?></td>
                                    <td><?= htmlspecialchars($user->password) ?></td>
                                    <td><?= htmlspecialchars($user->role) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->
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
