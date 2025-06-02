<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0"><?= $title ?></h5>
                </div>

                <div class="card-body">
                    <!-- Form Filter -->
                    <form method="post" action="<?= base_url('admin/SlipGaji') ?>" class="no-print">
                        <div class="form-group mb-3">
                            <label for="bulan">Bulan</label>
                            <select name="bulan" class="form-control" required>
                                <option value="">-- Pilih Bulan --</option>
                                <?php
                                $daftar_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                foreach ($daftar_bulan as $b): ?>
                                    <option value="<?= $b ?>" <?= ($bulan == $b) ? 'selected' : '' ?>><?= $b ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tahun">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= $tahun ?: date('Y') ?>" min="2000" max="<?= date('Y') + 5 ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_pegawai">Nama Perangkat Kampung</label>
                            <select name="id_pegawai" class="form-control" required>
                                <option value="">-- Pilih Perangkat Kampung --</option>
                                <?php foreach ($pegawai as $p): ?>
                                    <option value="<?= $p->id_pegawai ?>" <?= (isset($_POST['id_pegawai']) && $_POST['id_pegawai'] == $p->id_pegawai) ? 'selected' : '' ?>>
                                        <?= $p->nama_pegawai ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search mr-2"></i>Tampilkan Slip
                            </button>
                        </div>
                    </form>

                    <!-- Slip Gaji -->
                    <?php if ($slip): ?>
                        <div class="print-area mt-4 p-4 border">
                            <div class="text-center mb-4">
                              <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" height="40" width="40" class="mb-3">
                                <h5 class="mt-2 mb-0">Balai Kampung Adijaya</h5>
                                <small>Lampung Tengah</small>
                                <hr class="my-3">
                                <h4 class="mt-3"><strong>SLIP GAJI Perangkat Kampung</strong></h4>
                                <p class="mb-0">Periode: <?= $bulan ?> <?= $tahun ?></p>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            <tr><th width="40%">NIK</th><td>: <?= $slip->nik ?></td></tr>
                                            <tr><th>Nama</th><td>: <?= $slip->nama_pegawai ?></td></tr>
                                            <tr><th>Jabatan</th><td>: <?= $slip->jabatan ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                            <tr><th width="40%">Tanggal Cetak</th><td>: <?= date('d/m/Y') ?></td></tr>
                                            <tr><th>Status</th><td>: Lunas</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h6 class="mt-4 mb-3"><strong>Rincian Gaji</strong></h6>
                            <table class="table table-sm table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Komponen</th>
                                        <th class="text-right">Jumlah (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Gaji Pokok</td>
                                        <td class="text-right"><?= number_format($slip->gaji_pokok, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tunjangan</td>
                                        <td class="text-right"><?= number_format($slip->tunjangan, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr class="table-active">
                                        <td><strong>Total Gaji</strong></td>
                                        <td class="text-right"><strong><?= number_format($slip->total_gaji, 0, ',', '.') ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row mt-5 pt-4">
                                <div class="col text-center">
                                    <p class="mb-5">Mengetahui,</p>
                                    <p class="mt-5">_________________</p>
                                    <p>Kepala Kampung</p>
                                </div>
                                <div class="col text-center">
                                    <p class="mb-5">Hormat saya,</p>
                                    <p class="mt-5">_________________</p>
                                    <p><?= $slip->nama_pegawai ?></p>
                                </div>
                            </div>

                            <div class="mt-4 text-center small text-muted">
                                <p>Slip gaji ini adalah bukti pembayaran yang sah</p>
                            </div>
                        </div>

                        <div class="text-center mt-3 no-print">
                            <button class="btn btn-primary mr-2" onclick="window.print()">
                                <i class="fas fa-print mr-2"></i>Cetak Slip
                            </button>
                            <a href="<?= base_url('admin/SlipGaji') ?>" class="btn btn-secondary">
                                <i class="fas fa-redo mr-2"></i>Filter Baru
                            </a>
                        </div>
                    <?php elseif ($this->input->post()): ?>
                        <div class="alert alert-danger text-center mt-3">
                            <i class="fas fa-exclamation-circle mr-2"></i>Slip gaji tidak ditemukan untuk periode dan Perangkat Kampung yang dipilih.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kembali ke awal setelah print -->
<script>
    window.onafterprint = function() {
        window.location.href = "<?= base_url('admin/SlipGaji') ?>";
    };
</script>

<style>
    /* Style untuk tampilan normal (tidak diubah) */
    .print-area {
        background: #fff;
        border-radius: 5px;
    }
    .table-sm th, .table-sm td {
        padding: 0.5rem;
    }

    /* CSS khusus untuk print - PERBAIKAN FINAL */
    @media print {
        body, html {
            height: auto;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 12px;
        }
        
        body * {
            visibility: hidden;
        }
        
        .print-area, .print-area * {
            visibility: visible;
        }
        
        .print-area {
            position: absolute;
            left: 0;
            top: 0 !important; /* Pastikan dimulai dari paling atas */
            width: 100%;
            padding: 5mm 10mm !important; /* Padding atas diperkecil */
            margin: 0;
            border: none;
            background: white;
            font-size: 12px;
            page-break-after: avoid;
            page-break-inside: avoid;
        }
        
        /* Penyesuaian header - lebih ketat */
        .print-area .text-center {
            margin-bottom: 3mm !important;
            padding-top: 0 !important;
        }
        
        .print-area img {
            height: 35px !important; /* Diperkecil lagi */
            margin-bottom: 1mm !important; /* Diperkecil lagi */
            margin-top: 0 !important;
        }
        
        .print-area h5 {
            font-size: 13px !important;
            margin-top: 1mm !important;
            margin-bottom: 0.5mm !important;
        }
        
        .print-area small {
            font-size: 10px !important;
        }
        
        .print-area hr {
            margin-top: 1mm !important;
            margin-bottom: 1mm !important;
            border-top-width: 1px;
        }
        
        .print-area h4 {
            font-size: 15px !important;
            margin-top: 1mm !important;
            margin-bottom: 0.5mm !important;
        }
        
        /* Penyesuaian tabel - lebih kompak */
        .print-area .row {
            margin-bottom: 2mm !important;
        }
        
        .print-area table {
            font-size: 10px !important;
            margin-bottom: 2mm !important;
        }
        
        .print-area th, 
        .print-area td {
            padding: 1px 3px !important;
            line-height: 1.2;
        }
        
        /* Tanda tangan lebih rapat */
        .print-area .mt-5 {
            margin-top: 5mm !important;
        }
        
        .print-area .pt-4 {
            padding-top: 3mm !important;
        }
        
        .print-area .mb-5 {
            margin-bottom: 5mm !important;
        }
        
        /* Footer lebih kecil */
        .print-area .text-muted {
            font-size: 9px !important;
            margin-top: 2mm !important;
        }
        
        .no-print, .no-print * {
            display: none !important;
        }
        
        /* Pengaturan halaman lebih ketat */
        @page {
            size: A4 portrait;
            margin: 5mm 5mm 5mm 5mm; /* Margin atas dan bawah diperkecil */
        }
    }
</style>

<script>
    // Fungsi untuk reset sebelum print
    function prepareForPrint() {
        // Reset semua margin dan padding yang mungkin mempengaruhi
        const printArea = document.querySelector('.print-area');
        printArea.style.marginTop = '0';
        printArea.style.paddingTop = '0';
        
        // Optimasi elemen-elemen kritis
        const logo = printArea.querySelector('img');
        logo.style.marginTop = '0';
        logo.style.marginBottom = '1mm';
        logo.style.height = '35px';
    }
    
    // Fungsi print yang dioptimasi
    function printSlip() {
        prepareForPrint();
        setTimeout(() => {
            window.print();
        }, 100);
    }
    
    // Ganti onclick default
    const printBtn = document.querySelector('button[onclick="window.print()"]');
    printBtn.onclick = printSlip;
    printBtn.setAttribute('onclick', 'printSlip()');
    
    // Kembali ke awal setelah print
    window.onafterprint = function() {
        window.location.href = "<?= base_url('admin/SlipGaji') ?>";
    };
</script>