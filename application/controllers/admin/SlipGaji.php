<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SlipGaji extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Cek apakah user sudah login dan memiliki role admin
        if (!$this->session->userdata('username') || $this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Filter Slip Gaji';
        $data['slip'] = null;
        $data['bulan'] = null;
        $data['tahun'] = null;

        // Ambil semua pegawai untuk dropdown
        $data['pegawai'] = $this->db->get('data_pegawai')->result();

        // Jika form disubmit
        if ($this->input->post()) {
            $id_pegawai = $this->input->post('id_pegawai');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');

            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;

            // Konversi nama bulan ke angka
            $bulan_array = [
                'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 
                'April' => '04', 'Mei' => '05', 'Juni' => '06',
                'Juli' => '07', 'Agustus' => '08', 'September' => '09',
                'Oktober' => '10', 'November' => '11', 'Desember' => '12'
            ];
            $bulan_angka = $bulan_array[$bulan];

            $this->db->select('transaksi_gaji.*, data_pegawai.nama_pegawai, data_pegawai.nik, data_pegawai.jabatan');
            $this->db->from('transaksi_gaji');
            $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = transaksi_gaji.id_pegawai');
            $this->db->where('transaksi_gaji.id_pegawai', $id_pegawai);
            $this->db->where('MONTH(transaksi_gaji.tanggal_transaksi)', $bulan_angka);
            $this->db->where('YEAR(transaksi_gaji.tanggal_transaksi)', $tahun);

            $data['slip'] = $this->db->get()->row();
        }

        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/slipGaji', $data);
        $this->load->view('templates_admin/footer');
    }
}