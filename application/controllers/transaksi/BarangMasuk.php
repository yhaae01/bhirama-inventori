<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('pengguna_model', 'pengguna');
        cek_login();
    }

    public function index()
    {
        $data['title'] = 'Purchase Order';
        $data['user'] = $this->pengguna->cekPengguna();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/barang-masuk/index');
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Purchase Order';
        $data['user'] = $this->pengguna->cekPengguna();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/barang-masuk/tambah');
        $this->load->view('templates/footer');
    }
}

/* End of file PurchaseOrder.php */
