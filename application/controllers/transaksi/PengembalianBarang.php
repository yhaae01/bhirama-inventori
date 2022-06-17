<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengembalianBarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('pengguna_model', 'pengguna');
        cek_login();
        cek_cs();
    }

    public function index()
    {
        $data['title'] = 'Pengembalian Barang';
        $data['user'] = $this->pengguna->cekPengguna();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_list');
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Pengembalian Barang';
        $data['user'] = $this->pengguna->cekPengguna();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_form');
        $this->load->view('templates/footer');
    }
}

/* End of file PengembalianBarang.php */
