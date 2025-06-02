<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataAbsensi extends CI_Controller {

    private $potongan_absensi = 50000;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('date', 'download'));
        $this->load->library('pagination');

        if(!$this->session->userdata('username')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Absensi';

        // Filter Logic
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $pegawai = $this->input->get('pegawai');

        // Pagination Config
        $config['base_url'] = base_url('admin/dataAbsensi');
        $config['total_rows'] = $this->db
            ->from('absensi')
            ->where('MONTH(tanggal)', $bulan)
            ->where('YEAR(tanggal)', $tahun)
            ->where('id_pegawai', $pegawai)
            ->count_all_results();
        $config['per_page'] = 10;
        $config['reuse_query_string'] = TRUE;
        $this->pagination->initialize($config);

        $page = $this->input->get('per_page') ?? 0;

        // Get Data
        $this->db->select('absensi.*, data_pegawai.nama_pegawai')
            ->from('absensi')
            ->join('data_pegawai', 'data_pegawai.id_pegawai = absensi.id_pegawai', 'left');

        if ($bulan) $this->db->where('MONTH(tanggal)', $bulan);
        if ($tahun) $this->db->where('YEAR(tanggal)', $tahun);
        if ($pegawai) $this->db->where('absensi.id_pegawai', $pegawai);

        $data['absensi'] = $this->db
            ->limit($config['per_page'], $page)
            ->get()
            ->result();

        // Other Data
        $data['pegawai_list'] = $this->db->get('data_pegawai')->result();
        $data['tanggal_libur'] = $this->get_tanggal_libur();
        $data['potongan_absensi'] = $this->potongan_absensi;
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/DataAbsensi', $data);
        $this->load->view('templates_admin/footer');
    }

    private function get_tanggal_libur()
    {
        return [
            date('Y').'-01-01',
            date('Y').'-05-01',
            date('Y').'-08-17'
        ];
    }

    public function tambah()
    {
        $this->form_validation->set_rules('id_pegawai', 'Perangkat Kampung', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/dataAbsensi');
        }

        // Hadir harus ada jam
       if ($this->input->post('status') == 'Hadir' && 
    (empty($this->input->post('jam_masuk')) || empty($this->input->post('jam_keluar')))) {
            $this->session->set_flashdata('error', 'Jam masuk dan keluar wajib untuk status Hadir');
            redirect('admin/dataAbsensi');
        }

        $data = [
            'id_pegawai'    => $this->input->post('id_pegawai'),
            'tanggal'       => $this->input->post('tanggal'),
            'jam_masuk'    => $this->input->post('jam_masuk'),
            'jam_keluar'    => $this->input->post('jam_keluar'),
            'status'       => $this->input->post('status'),
            'keterangan'    => $this->input->post('keterangan')
        ];

        $this->db->insert('absensi', $data);
        $this->session->set_flashdata('success', 'Data berhasil ditambahkan!');
        redirect('admin/dataAbsensi');
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('id_pegawai', 'Perangkat Kampung', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/dataAbsensi');
        }

        // Validasi jam untuk status Hadir
       if ($this->input->post('status') == 'Hadir' && 
    (empty($this->input->post('jam_masuk')) || empty($this->input->post('jam_keluar')))) {
            $this->session->set_flashdata('error', 'Jam masuk dan keluar wajib untuk status Hadir');
            redirect('admin/dataAbsensi');
        }

        $data = [
            'id_pegawai'    => $this->input->post('id_pegawai'),
            'tanggal'       => $this->input->post('tanggal'),
            'jam_masuk'    => $this->input->post('jam_masuk'),
            'jam_keluar'    => $this->input->post('jam_keluar'),
            'status'       => $this->input->post('status'),
            'keterangan'    => $this->input->post('keterangan')
        ];

        $this->db->where('id_absensi', $id)->update('absensi', $data);
        $this->session->set_flashdata('success', 'Data berhasil diupdate!');
        redirect('admin/dataAbsensi');
    }

    public function hapus($id)
    {
        $this->db->where('id_absensi', $id)->delete('absensi');
        $this->session->set_flashdata('success', 'Data berhasil dihapus!');
        redirect('admin/dataAbsensi');
    }

    public function export()
    {
        // Load data
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $pegawai = $this->input->get('pegawai');

        $this->db->select('absensi.*, data_pegawai.nama_pegawai')
            ->from('absensi')
            ->join('data_pegawai', 'data_pegawai.id_pegawai = absensi.id_pegawai');

        if ($bulan) $this->db->where('MONTH(tanggal)', $bulan);
        if ($tahun) $this->db->where('YEAR(tanggal)', $tahun);
        if ($pegawai) $this->db->where('absensi.id_pegawai', $pegawai);

        $data = $this->db->get()->result();

        // Generate Excel
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data_Absensi_".date('Ymd').".xls");

        $html = '<table border="1">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Perangkat</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>';

        $no = 1;
        foreach($data as $d) {
            $html .= '<tr>
                <td>'.$no++.'</td>
                <td>'.date('d-m-Y', strtotime($d->tanggal)).'</td>
                <td>'.$d->nama_pegawai.'</td>
                <td>'.$d->jam_masuk.'</td>
                <td>'.$d->jam_keluar.'</td>
                <td>'.$d->status.'</td>
                <td>'.$d->keterangan.'</td>
            </tr>';
        }

        $html .= '</table>';

        echo $html;
        exit();
    }
}