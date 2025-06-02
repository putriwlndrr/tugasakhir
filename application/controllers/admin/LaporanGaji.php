<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanGaji extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Cek apakah user sudah login dan memiliki role admin
        if (!$this->session->userdata('username') || $this->session->userdata('role') !== 'admin') {
            // Jika bukan admin, arahkan ke halaman login
            redirect('auth'); // Ganti sesuai dengan URL login kamu
        }
    }

    public function index()
    {
        $nama = $this->input->get('nama');

        $this->db->select('transaksi_gaji.*, data_pegawai.nama_pegawai, data_pegawai.jabatan');
        $this->db->from('transaksi_gaji');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = transaksi_gaji.id_pegawai');

        if (!empty($nama)) {
            $this->db->where('data_pegawai.nama_pegawai', $nama);
        }

        $data['title'] = 'Laporan Gaji Perangkat Kampung';
        $data['laporan'] = $this->db->get()->result();
        $data['pegawai'] = $this->db->get('data_pegawai')->result();

        // Pastikan tampilan yang digunakan sudah sesuai
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/laporanGaji', $data);
        $this->load->view('templates_admin/footer');
    }

    public function print()
    {
        $nama = $this->input->get('nama');

        $this->db->select('transaksi_gaji.*, data_pegawai.nama_pegawai, data_pegawai.jabatan');
        $this->db->from('transaksi_gaji');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = transaksi_gaji.id_pegawai');

        if (!empty($nama)) {
            $this->db->where('data_pegawai.nama_pegawai', $nama);
        }

        $data['title'] = 'Laporan Gaji Pegawai';
        $data['laporan'] = $this->db->get()->result();

        echo '<html><head><title>'.$data['title'].'</title>
        <style>
            body { font-family: Arial, sans-serif; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #000; padding: 8px; text-align: center; }
            th { background-color: #f2f2f2; }
            h2 { text-align: center; }
        </style>
        </head><body onload="window.print()">
        <h2>'.$data['title'].'</h2>';

        echo '<table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perangkat Kampung</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Total Gaji</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>';

        $no = 1;
        foreach ($data['laporan'] as $lp) {
            $tanggal = $lp->tanggal_transaksi ?? '-';
            $formattedDate = $tanggal ? date('d-m-Y H:i', strtotime($tanggal)) : '-';
            echo '<tr>
                <td>'.$no++.'</td>
                <td>'.$lp->nama_pegawai.'</td>
                <td>'.$lp->jabatan.'</td>
                <td>Rp'.number_format($lp->gaji_pokok, 0, ',', '.').'</td>
                <td>Rp'.number_format($lp->tunjangan, 0, ',', '.').'</td>
                <td>Rp'.number_format($lp->total_gaji, 0, ',', '.').'</td>
                <td>'.$formattedDate.'</td>
            </tr>';
        }

        echo '</tbody></table></body></html>';
    }
}
