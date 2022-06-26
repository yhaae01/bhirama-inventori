<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengguna_model', 'pengguna');
		$this->load->model('DetailPesanan_model', 'detail_pesanan');
		$this->load->model('DetailBarangMasuk_model', 'detail_barang_masuk');
		$this->load->model('DetailPengembalian_model', 'detail_pengembalian');
		$this->load->model('DetailReturBarang_model', 'detail_retur_barang');
		cek_login();
	}
	public function index()
	{

		$data['title'] = 'Dashboard';
		$data['user']  = $this->pengguna->cekPengguna();
		$data['total_pesanan'] = $this->detail_pesanan->getTotalQty();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');
	}
}
