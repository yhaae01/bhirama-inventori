<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MetodePembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('MetodePembayaran_model', 'MetodePembayaran');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {
        $data['title'] = 'Metode Pembayaran';
        $data['user'] = $this->pengguna->cekPengguna();
        $data['metodePembayaran'] = $this->MetodePembayaran->getAllMetodePembayaran();
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/metode-pembayaran/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Metode Pembayaran';
        $data['user'] = $this->pengguna->cekPengguna();
        $data['metodePembayaran'] = $this->MetodePembayaran->getAllMetodePembayaran();
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

        $this->form_validation->set_rules('nama_metodePembayaran', 'MetodePembayaran', 'required|trim|is_unique[metodePembayaran.nama_metodePembayaran]', [
            'required'  => 'Metode Pembayaran harus diisi!',
            'is_unique' => 'Metode Pembayaran sudah ada!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('master/metode-pembayaran/index');
            $this->load->view('templates/footer');
        } else {
            $this->MetodePembayaran->tambah_metodePembayaran();
        }
    }

    public function ubah()
    {
        $data['title'] = 'Ubah Metode Pembayaran';
        $data['user'] = $this->pengguna->cekPengguna();
        $data['metodePembayaran'] = $this->MetodePembayaran->getAllMetodePembayaran();
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

        $this->form_validation->set_rules('nama_metodePembayaran', 'Metode Pembayaran', 'required|trim|is_unique[metodePembayaran.nama_metodePembayaran]', [
            'required'   => 'Metode Pembayaran harus diisi!',
            'is_unique' => 'Metode Pembayaran Sudah Ada'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('master/metode-pembayaran/index');
            $this->load->view('templates/footer');
        } else {
            $this->MetodePembayaran->ubah_metodePembayaran();
        }
    }

    public function hapus($id_metodePembayaran)
    {
        $this->MetodePembayaran->hapus_metodePembayaran($id_metodePembayaran);
    }
}
