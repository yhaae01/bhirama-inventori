<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReturBarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('pengguna_model', 'pengguna');
    }
    public function index()
    {
        $data['title'] = 'Retur Barang';
        $data['user'] = $this->pengguna->cekPengguna();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/retur-barang/index');
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Retur Barang';
        $data['user'] = $this->pengguna->cekPengguna();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/retur-barang/tambah');
        $this->load->view('templates/footer');
    }
}

/* End of file ReturBarang.php */
