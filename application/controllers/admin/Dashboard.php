<?php
class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Proteksi agar hanya admin yang bisa akses halaman ini
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard';

        // Ambil total karyawan dari data_pegawai
        $pegawai = $this->db->query("SELECT * FROM data_pegawai");

        // Ambil total user dari data_user
        $user = $this->db->query("SELECT * FROM data_user");

        // Ambil total jabatan dari data_jabatan
        $jabatan = $this->db->query("SELECT * FROM data_jabatan");

        // Simpan jumlah data ke array
        $data['pegawai'] = $pegawai->num_rows();
        $data['user'] = $user->num_rows();
        $data['jabatan'] = $jabatan->num_rows();
        // Hapus bagian terkait absensi karena tidak diperlukan
        // $data['kehadiran'] = $kehadiran->num_rows(); // Dihapus

        // Load view
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates_admin/footer');
    }
}
?>
