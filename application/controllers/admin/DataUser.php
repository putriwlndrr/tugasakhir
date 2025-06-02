<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataUser extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->database();

        // Cek apakah user sudah login dan memiliki role 'admin'
        if (!$this->session->userdata('username') || $this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Login Admin';

        // Proses pencarian
        $keyword = $this->input->post('keyword');
        if ($keyword) {
            $this->db->like('username', $keyword); // Hanya cari berdasarkan username
        }

        // Ambil data user dari tabel data_user
        $data['users'] = $this->db->get('data_user')->result();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dataUser', $data);
        $this->load->view('templates_admin/footer');
    }
}
