<div class="container-fluid">
    <!-- Dashboard Header - Diperbaiki Responsif -->
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4">
        <h1 class="h3 mb-3 mb-md-0 text-gray-800">Dashboard Admin</h1>
        <div class="ms-md-auto">
            <span class="badge bg-primary text-white p-2">
                <i class="fas fa-calendar-alt me-1"></i>
                <?php echo date('d F Y'); ?>
            </span>
        </div>
    </div>

    <!-- Stats Cards Row - Diperbaiki Responsif -->
    <div class="row">
        <!-- Data User Card -->
        <div class="col-12 col-md-6 col-xl-4 mb-4">
            <div class="card border-start border-primary border-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted fw-bold fs-xs">Total Pengguna Sistem</div>
                            <div class="fw-bold fs-3 text-dark"><?php echo $user ?></div>
                            <div class="mt-2 text-muted fs-xs">
                                <i class="fas fa-info-circle me-1"></i>
                                Akses level administrator
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-cog fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Karyawan Card -->
        <div class="col-12 col-md-6 col-xl-4 mb-4">
            <div class="card border-start border-success border-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted fw-bold fs-xs">Total Perangkat Kampung</div>
                            <div class="fw-bold fs-3 text-dark"><?php echo $pegawai ?></div>
                            <div class="mt-2 text-muted fs-xs">
                                <i class="fas fa-project-diagram me-1"></i>
                                Terbagi dalam <?php echo $jabatan ?> bidang jabatan
                            </div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Jabatan Card -->
        <div class="col-12 col-md-6 col-xl-4 mb-4">
            <div class="card border-start border-info border-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase text-muted fw-bold fs-xs">Jenis Jabatan</div>
                            <div class="fw-bold fs-3 text-dark"><?php echo $jabatan ?></div>
                            <div class="mt-2 text-muted fs-xs">
                                <i class="fas fa-sitemap me-1"></i>
                                Struktur jabatan instansi
                            </div>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-id-card-alt fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map and Information Section - Diperbaiki Responsif -->
    <div class="row mt-4">
        <!-- Map Column -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-primary">Lokasi Kantor</h6>
                </div>
                <div class="card-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3980.847073423841!2d105.2177223147587!3d-4.767268996385333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3f9536e6f10a91%3A0x3d7f60a75afdf578!2sBalai%20Kampung%20Adijaya!5e0!3m2!1sen!2sid!4v1710000000000!5m2!1sen!2sid" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                    <div class="p-3 text-center text-muted fs-xs">
                        <i class="fas fa-map-marker-alt me-1"></i> Jl. Dr. Sutomo, Adi Jaya, Lampung Tengah
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information Column -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-primary">Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <!-- <div class="text-center mb-4">
                        <img class="img-fluid" style="max-height: 150px;" src="<?php echo base_url(); ?>assets/img/undraw_team_spirit.svg" alt="Team Illustration">
                    </div> -->
                    <!-- <h5 class="text-center mb-4">SIMPAGADESA</h5> -->
                    
                    <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                        <div class="d-flex">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <strong class="d-block">Fungsi Sistem:</strong>
                                <ul class="mt-2 mb-1 ps-3">
                                    <li>Pencatatan data perangkat kampung non-ASN,</li>
                                    <li>Pengelolaan administrasi personalia</li>
                                    <li>Monitoring status berkas perangkat kampung</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                            <div>
                                <strong class="d-block">Prosedur Penggajian:</strong>
                                <p class="mt-2 mb-1">Proses penggajian perangkat kampung mengikuti ketentuan resmi pemerintah daerah dan mengacu pada SK Bupati sebagai dasar hukum penetapan honorarium. Setelah SK Bupati diterbitkan dan dana ditransfer ke rekening kampung, pencatatan gaji dilakukan melalui sistem.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center text-muted fs-xs mt-4">
                        <i class="fas fa-headset me-1"></i> Untuk bantuan teknis, hubungi Tim TI di balai kampung
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>