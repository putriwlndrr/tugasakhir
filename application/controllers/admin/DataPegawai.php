<?php
class DataPegawai extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');

        // Proteksi agar hanya admin yang bisa akses
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Perangkat Kampung';

        // Daftar jabatan yang ditambahkan
        $data['jabatan_list'] = [
            'Kepala Kampung',
            'Sekretaris Kampung',
            'Kepala Seksi Pemerintahan',
            'Kepala Seksi Kesejahteraan',
            'Kepala Seksi Pelayanan',
            'Kaur Umum dan Perencanaan',
            'Kaur Keuangan',
            'Kadus Adi Luhur',
            'Kadus Adi Luwih',
            'Kadus Adi Mulyo',
            'Kadus Adi Negoro',
            'Kadus Adi Rejo'
        ];

        // Check if there's input from the search form
        if ($this->input->post('keyword')) {
            $keyword = $this->input->post('keyword');
            $this->db->like('nama_pegawai', $keyword);
            $data['pegawai'] = $this->db->get('data_pegawai')->result();
        } else {
            $data['pegawai'] = $this->db->get('data_pegawai')->result();
        }

        // Load the view
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dataPegawai', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah()
    {
        // Prepare the data for insert
        $data = [
            'nik' => $this->input->post('nik'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'jabatan' => $this->input->post('jabatan'),
            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
            'status' => $this->input->post('status'),
            'photo' => $_FILES['photo']['name'] ? $_FILES['photo']['name'] : ''
        ];

        // Handle photo upload
        if ($data['photo']) {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo')) {
                $data['photo'] = $this->upload->data('file_name');
            }
        }

        $this->db->insert('data_pegawai', $data);
        redirect('admin/dataPegawai');
    }

    public function hapus($id)
    {
        $this->db->delete('data_pegawai', ['id_pegawai' => $id]);
        redirect('admin/dataPegawai');
    }

    public function edit($id)
    {
        // Ambil data existing dulu
        $pegawai = $this->db->get_where('data_pegawai', ['id_pegawai' => $id])->row();

        $photo = $_FILES['photo']['name'];

        // Jika ada upload file baru
        if ($photo) {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo')) {
                // Hapus file lama jika ada
                if (!empty($pegawai->photo) && file_exists('./assets/img/' . $pegawai->photo)) {
                    unlink('./assets/img/' . $pegawai->photo);
                }
                $photo_name = $this->upload->data('file_name');
            } else {
                $photo_name = $pegawai->photo; // jika upload gagal, pakai foto lama
            }
        } else {
            $photo_name = $pegawai->photo; // jika tidak upload, pakai foto lama
        }

        $data = [
            'nik' => $this->input->post('nik'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'jabatan' => $this->input->post('jabatan'),
            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
            'status' => $this->input->post('status'),
            'photo' => $photo_name
        ];

        $this->db->where('id_pegawai', $id);
        $this->db->update('data_pegawai', $data);
        redirect('admin/dataPegawai');
    }
}
