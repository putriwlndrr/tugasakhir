<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataLembur extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        if(!$this->session->userdata('username')){
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = "Data Lembur";
        $data['pegawai'] = $this->db->get('data_pegawai')->result();

        $this->db->select('lembur.*, data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jabatan');
        $this->db->from('lembur');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = lembur.id_pegawai');

        $status = $this->input->get('status');
        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $this->db->where('lembur.status', $status);
        }

        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $this->db->group_start()
                ->like('data_pegawai.nik', $keyword)
                ->or_like('data_pegawai.nama_pegawai', $keyword)
                ->or_like('lembur.alasan', $keyword)
                ->group_end();
        }

        $data['lembur'] = $this->db->order_by('tanggal', 'DESC')->get()->result();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dataLembur', $data);
        $this->load->view('templates_admin/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('id_pegawai', 'Perangkat Kampung', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');
        $this->form_validation->set_rules('alasan', 'Alasan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Data gagal ditambahkan! Periksa inputan Anda.');
            redirect('admin/dataLembur');
        }

        $tanggal = $this->input->post('tanggal');
        $jam_mulai = $this->input->post('jam_mulai');
        $jam_selesai = $this->input->post('jam_selesai');

        $startDateTime = strtotime("$tanggal $jam_mulai");
        $endDateTime = strtotime("$tanggal $jam_selesai");

        if ($startDateTime == $endDateTime) {
            $this->session->set_flashdata('error', 'Jam mulai dan jam selesai tidak boleh sama!');
            redirect('admin/dataLembur');
        }

        if ($endDateTime < $startDateTime) {
            $endDateTime = strtotime("+1 day", $endDateTime);
        }

        $selisih = $endDateTime - $startDateTime;
        $durasi_format = gmdate("H:i:s", $selisih);

        $data = [
            'id_pegawai' => $this->input->post('id_pegawai'),
            'tanggal' => $tanggal,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'durasi' => $durasi_format,
            // Bonus dihapus karena tidak digunakan
            'alasan' => $this->input->post('alasan'),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('lembur', $data);
        $this->session->set_flashdata('success', 'Data lembur berhasil ditambahkan!');
        redirect('admin/dataLembur');
    }

    public function setApproved($id)
    {
        $this->db->where('id_lembur', $id)->update('lembur', [
            'status' => 'approved',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        redirect('admin/dataLembur');
    }

    public function setRejected($id)
    {
        $this->db->where('id_lembur', $id)->update('lembur', [
            'status' => 'rejected',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        redirect('admin/dataLembur');
    }

    public function hapus($id)
    {
        $this->db->where('id_lembur', $id)->delete('lembur');
        $this->session->set_flashdata('success', 'Data lembur berhasil dihapus!');
        redirect('admin/dataLembur');
    }
}
