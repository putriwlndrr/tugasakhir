<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation']); // Load multiple libraries
        $this->load->helper('url');
        $this->load->database();
        $this->initialize_admin();
    }

    // Tambahkan method baru untuk inisialisasi admin
    private function initialize_admin()
    {
        // Cek apakah admin sudah ada
        $admin_exists = $this->db->get_where('data_user', [
            'username' => 'admin',
            'role' => 'admin'
        ])->num_rows();

        // Jika admin belum ada, buat akun admin
        if ($admin_exists === 0) {
            $this->db->insert('data_user', [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin'
            ]);
        }
    }

    public function index()
    {
        // Perbaikan: Redirect ke halaman admin jika sudah login
        if ($this->session->userdata('username')) {
            redirect('admin/dashboard');
        }

        $this->load->view('auth'); // login view
    }

    public function login()
    {
        // Perbaikan: Validasi input terlebih dahulu
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username dan password harus diisi!');
            redirect('auth');
            return;
        }

        $username = $this->input->post('username', true);
        $password = $this->input->post('password');

        // Query dengan prepared statement untuk keamanan
        $query = $this->db->get_where('data_user', [
            'username' => $username,
            'role' => 'admin' // Hanya admin yang bisa login
        ]);

        if ($query->num_rows() > 0) {
            $user = $query->row();

            if (password_verify($password, $user->password)) {
                // Set session data
                $this->session->set_userdata([
                    'username' => $user->username,
                    'role'     => $user->role,
                    'logged_in' => true // Tambahan status login
                ]);

                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan atau Anda bukan admin!');
            redirect('auth');
        }
    }

    public function logout()
    {
        // Perbaikan: Hapus semua data session
        $this->session->unset_userdata(['username', 'role', 'logged_in']);
        $this->session->sess_destroy();
        redirect('auth');
    }
}