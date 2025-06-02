<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTransaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');

        if ($this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = "Data Pencatatan Gaji";
        $keyword = $this->input->get('keyword'); // Ubah dari post ke get karena form menggunakan method get
        $status = $this->input->get('status'); // Tambahkan ini untuk filter status
    
        $this->db->select('transaksi_gaji.*, data_pegawai.nik, data_pegawai.nama_pegawai');
        $this->db->from('transaksi_gaji');
        $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = transaksi_gaji.id_pegawai');
    
        // Tambahkan filter status jika ada
        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $this->db->where('transaksi_gaji.status', $status);
        }
    
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('data_pegawai.nik', $keyword);
            $this->db->or_like('data_pegawai.nama_pegawai', $keyword);
            $this->db->or_like('transaksi_gaji.jabatan', $keyword);
            $this->db->group_end();
        }
    
        $data['dataTransaksi'] = $this->db->get()->result();
        $data['pegawai'] = $this->db->get('data_pegawai')->result();
        $data['jabatan'] = $this->db->get('data_jabatan')->result();
    
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dataTransaksi', $data);
        $this->load->view('templates_admin/footer');
    }

    private function getGajiByJabatan($jabatan) {
        return $this->db->get_where('data_jabatan', ['nama_jabatan' => $jabatan])->row();
    }

    public function store() {
        $this->form_validation->set_rules('id_pegawai', 'Pegawai', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/dataTransaksi');
            return;
        }
    
        $id_pegawai = $this->input->post('id_pegawai');
        $pegawai = $this->db->get_where('data_pegawai', ['id_pegawai' => $id_pegawai])->row();
    
        if (!$pegawai) {
            $this->session->set_flashdata('error', 'Data pegawai tidak ditemukan');
            redirect('admin/dataTransaksi');
            return;
        }
    
        $jabatan_data = $this->getGajiByJabatan($pegawai->jabatan);
    
        if (!$jabatan_data) {
            $this->session->set_flashdata('error', 'Data gaji untuk jabatan ini belum diatur');
            redirect('admin/dataTransaksi');
            return;
        }
    
        $data = [
            'id_pegawai' => $id_pegawai,
            'jabatan' => $pegawai->jabatan,
            'gaji_pokok' => $jabatan_data->gaji_pokok,
            'tunjangan' => $jabatan_data->tunjangan,
            'total_gaji' => $jabatan_data->gaji_pokok + $jabatan_data->tunjangan,
            'status' => 'pending'  // Status transaksi gaji adalah pending saat pertama kali ditambahkan
        ];
    
        $this->db->insert('transaksi_gaji', $data);
        $this->session->set_flashdata('success', 'Data transaksi berhasil ditambahkan');
        redirect('admin/dataTransaksi');
    }
    
    public function update($id) {
        $this->form_validation->set_rules('id_pegawai', 'Pegawai', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/dataTransaksi');
            return;
        }
    
        $id_pegawai = $this->input->post('id_pegawai');
        $pegawai = $this->db->get_where('data_pegawai', ['id_pegawai' => $id_pegawai])->row();
    
        if (!$pegawai) {
            $this->session->set_flashdata('error', 'Data pegawai tidak ditemukan');
            redirect('admin/dataTransaksi');
            return;
        }
    
        $jabatan_data = $this->getGajiByJabatan($pegawai->jabatan);
    
        if (!$jabatan_data) {
            $this->session->set_flashdata('error', 'Data gaji untuk jabatan ini belum diatur');
            redirect('admin/dataTransaksi');
            return;
        }
    
        $data = [
            'id_pegawai' => $id_pegawai,
            'jabatan' => $pegawai->jabatan,
            'gaji_pokok' => $jabatan_data->gaji_pokok,
            'tunjangan' => $jabatan_data->tunjangan,
            'total_gaji' => $jabatan_data->gaji_pokok + $jabatan_data->tunjangan,
            'status' => 'pending'  // Status transaksi tetap pending saat diperbarui
        ];
    
        $this->db->where('id_transaksi', $id)->update('transaksi_gaji', $data);
        $this->session->set_flashdata('success', 'Data transaksi berhasil diperbarui');
        redirect('admin/dataTransaksi');
    }

    public function setApproved($id) {
        // Update status transaksi gaji menjadi 'approved'
        $this->db->where('id_transaksi', $id)->update('transaksi_gaji', ['status' => 'approved']);
        $this->session->set_flashdata('success', 'Transaksi telah disetujui');
        redirect('admin/dataTransaksi');
    }
    
    public function setRejected($id) {
        // Update status transaksi gaji menjadi 'rejected'
        $this->db->where('id_transaksi', $id)->update('transaksi_gaji', ['status' => 'rejected']);
        $this->session->set_flashdata('success', 'Transaksi telah ditolak');
        redirect('admin/dataTransaksi');
    }

    public function hapus($id) {
        // Memeriksa apakah transaksi sudah 'approved' atau 'rejected'
        $transaksi = $this->db->get_where('transaksi_gaji', ['id_transaksi' => $id])->row();
        
        if ($transaksi && ($transaksi->status == 'approved' || $transaksi->status == 'rejected')) {
            // Hapus data transaksi
            $this->db->where('id_transaksi', $id)->delete('transaksi_gaji');
            $this->session->set_flashdata('success', 'Data transaksi berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Transaksi tidak dapat dihapus karena belum disetujui atau ditolak');
        }
    
        redirect('admin/dataTransaksi');
    }
    // Contoh di Controller
public function dataTransaksi()
{
    $status = $this->input->get('status');
    
    if($status) {
        $data['transaksi'] = $this->db->get_where('transaksi', ['status' => $status])->result();
    } else {
        $data['transaksi'] = $this->db->get('transaksi')->result();
    }
    
    $this->load->view('admin/dataTransaksi', $data);
}
    
}
