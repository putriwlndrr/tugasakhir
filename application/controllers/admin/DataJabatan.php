<?php
class DataJabatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        // Check admin role
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }

        $data['title'] = 'Data Jabatan';
        $data['jabatan_list'] = $this->getJabatanList();

        // Search functionality
        if ($this->input->post('keyword')) {
            $this->db->like('nama_jabatan', $this->input->post('keyword'));
        }
        $data['jabatan'] = $this->db->get('data_jabatan')->result();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dataJabatan', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah() {
        $nama_jabatan = $this->input->post('nama_jabatan');
        $deskripsi_jabatan = $this->input->post('deskripsi_jabatan');
        $gaji = $this->getGajiDanTunjangan($nama_jabatan);

        $data = [
            'nama_jabatan' => $nama_jabatan,
            'deskripsi_jabatan' => $deskripsi_jabatan,
            'gaji_pokok' => $gaji['gaji_pokok'],
            'tunjangan' => $gaji['tunjangan']
        ];

        $this->db->insert('data_jabatan', $data);
        redirect('admin/dataJabatan');
    }

    public function hapus($id) {
        $this->db->delete('data_jabatan', ['id_jabatan' => $id]);
        redirect('admin/dataJabatan');
    }

    public function edit($id) {
        $nama_jabatan = $this->input->post('nama_jabatan');
        $deskripsi_jabatan = $this->input->post('deskripsi_jabatan');
        $gaji = $this->getGajiDanTunjangan($nama_jabatan);

        $data = [
            'nama_jabatan' => $nama_jabatan,
            'deskripsi_jabatan' => $deskripsi_jabatan,
            'gaji_pokok' => $gaji['gaji_pokok'],
            'tunjangan' => $gaji['tunjangan']
        ];

        $this->db->where('id_jabatan', $id);
        $this->db->update('data_jabatan', $data);
        redirect('admin/dataJabatan');
    }

    private function getJabatanList() {
        return [
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
    }

    private function getGajiDanTunjangan($jabatan) {
        $gaji_map = [
            'Kepala Kampung' => ['gaji_pokok' => 2500000, 'tunjangan' => 50000],
            'Sekretaris Kampung' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kepala Seksi Pemerintahan' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kepala Seksi Kesejahteraan' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kepala Seksi Pelayanan' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kaur Umum dan Perencanaan' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kaur Keuangan' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kadus Adi Luhur' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kadus Adi Luwih' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kadus Adi Mulyo' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kadus Adi Negoro' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000],
            'Kadus Adi Rejo' => ['gaji_pokok' => 2250000, 'tunjangan' => 50000]
        ];

        return $gaji_map[$jabatan] ?? ['gaji_pokok' => 0, 'tunjangan' => 0];
    }
}