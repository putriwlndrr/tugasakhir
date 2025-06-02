<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">

    <style>
        /* System Header Styling */
        .system-header {
            background-color: #4e73df;
            color: white;
            padding: 12px 0;
            border-bottom: 1px solid rgba(189, 205, 238, 0.1);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .system-logo {
            height: 45px;
            margin-right: 15px;
            border-radius: 4px;
        }
        
        .system-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0;
            letter-spacing: 0.5px;
        }
        
        .system-subtitle {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 2px;
        }
        
        /* User Profile Section */
        .user-profile {
            display: flex;
            align-items: center;
            margin-left: auto;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid rgba(255,255,255,0.3);
            object-fit: cover;
        }
        
        .user-info {
            line-height: 1.2;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
        }
        
        /* Navbar Styling */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 0.5rem 1rem;
        }
        
        .navbar-nav .nav-item .nav-link {
            color: #495057;
            padding: 0.8rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-radius: 4px;
            margin: 0 2px;
        }
        
        .navbar-nav .nav-item .nav-link:hover,
        .navbar-nav .nav-item .nav-link.active {
            color: #467fcf;
            background-color: rgba(70, 127, 207, 0.1);
        }
        
        .navbar-nav .nav-item .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
            font-size: 0.95rem;
        }
        
        /* Dropdown Styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-radius: 6px;
            padding: 0.5rem 0;
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item i {
            margin-right: 10px;
            color: #467fcf;
        }
        
        .dropdown-divider {
            border-color: rgba(0,0,0,0.05);
        }
        
        /* Login Indicator */
        .login-indicator {
            font-size: 0.75rem;
            color:rgb(121, 241, 149);
            background-color: rgba(40, 167, 69, 0.1);
            padding: 3px 8px;
            border-radius: 10px;
            margin-left: 10px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 992px) {
            .system-header {
                padding: 10px 0;
            }
            
            .system-logo {
                height: 38px;
            }
            
            .system-title {
                font-size: 1.2rem;
            }
            
            .user-profile {
                margin: 10px 0;
            }
            
            .navbar-collapse {
                padding: 15px;
                background: white;
                margin-top: 10px;
                border-radius: 5px;
                box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            }
            
            .navbar-nav .nav-item {
                margin-bottom: 5px;
            }
            
            .dropdown-menu {
                position: static !important;
                transform: none !important;
                margin-top: 5px;
                border: 1px solid rgba(0,0,0,0.1);
            }
        }
    </style>
</head>

<body>
    <!-- System Header with Logo and User Profile -->
    <div class="system-header">
        <div class="container-fluid d-flex align-items-center">
            <div class="d-flex align-items-center">
                <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="Logo Desa" class="system-logo">
                <div>
                    <h1 class="system-title">SIPERGAJI</h1>
                    <p class="system-subtitle mb-0">Sistem Informasi Pencatatan Gaji Perangkat Kampung</p>
                </div>
            </div>
            
            <!-- User Profile Section -->
            <div class="user-profile">
                <div class="user-avatar-default">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="user-info">
                    <div class="user-name">Admin Desa</div>
                    <div class="user-role">Administrator</div>
                </div>
                <span class="login-indicator">
                    <i class="fas fa-circle"></i> Online
                </span>
            </div>
        </div>
    </div>

  <!-- Main Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo base_url('admin/dashboard'); ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Master Data Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="masterDataDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-database"></i>
                        <span>Master Data</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="masterDataDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('admin/dataUser'); ?>">
                            <i class="fas fa-users"></i>Data Login Admin
                        </a>
                        <a class="dropdown-item" href="<?php echo base_url('admin/dataPegawai'); ?>">
                            <i class="fas fa-id-card"></i>Data Perangkat Kampung
                        </a>
                        <a class="dropdown-item" href="<?php echo base_url('admin/dataJabatan'); ?>">
                            <i class="fas fa-briefcase"></i>Data Jabatan
                        </a>
                    </div>
                </li>

                <!-- Absensi Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/dataAbsensi'); ?>">
                        <i class="fas fa-calendar-check"></i>
                        <span>Absensi</span>
                    </a>
                </li>

                <!-- Lembur Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/dataLembur'); ?>">
                        <i class="fas fa-business-time"></i>
                        <span>Lembur</span>
                    </a>
                </li>

                <!-- Salary Menu -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('admin/dataTransaksi'); ?>">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Pencatatan Gaji</span>
                    </a>
                </li>

                <!-- Reports Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="laporanDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="laporanDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('admin/laporanGaji'); ?>">
                            <i class="fas fa-file-invoice-dollar"></i>Laporan Gaji
                        </a>
                        <a class="dropdown-item" href="<?php echo base_url('admin/slipGaji'); ?>">
                            <i class="fas fa-receipt"></i>Slip Gaji
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Logout Button -->
            <div class="d-flex">
                <a class="btn btn-danger ms-2" href="<?= base_url('auth/logout'); ?>" 
                   onclick="return confirm('Yakin ingin keluar?')">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>


    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <!-- Your existing content here -->
    </div>

    <!-- JavaScript Libraries -->
    <!-- jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Then Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Ensure navbar toggle works
        document.addEventListener('DOMContentLoaded', function() {
            // Set active menu item
            var currentPage = window.location.pathname.split('/').pop();
            document.querySelectorAll('.nav-link').forEach(function(link) {
                if(link.getAttribute('href').endsWith(currentPage)) {
                    link.classList.add('active');
                    // Also activate parent dropdown if exists
                    let parentDropdown = link.closest('.dropdown-menu');
                    if(parentDropdown) {
                        parentDropdown.previousElementSibling.classList.add('active');
                    }
                }
            });
        });
    </script>
</body>
</html>