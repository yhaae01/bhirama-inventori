<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengembalianBarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->library('datatables');
        $this->load->model('pengembalianBarang_model', 'pengembalianBarang');
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
        $this->load->view('transaksi/pengembalian-barang/pengembalian_js', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->pengembalianBarang->json();
    }

    public function create()
    {
        $data = array(
            'button' => 'Tambah',
        );
        $data['title'] = 'Tambah Pengembalian Barang';
        $data['user'] = $this->pengguna->cekPengguna();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_form');
        $this->load->view('templates/footer');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_js', $data);
    }
}

/* End of file PengembalianBarang.php */
