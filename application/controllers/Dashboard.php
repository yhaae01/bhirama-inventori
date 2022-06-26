<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengguna_model', 'pengguna');
		$this->load->model('Pesanan_model', 'pesanan');
		$this->load->model('DetailPesanan_model', 'detail_pesanan');
		$this->load->model('PengembalianBarang_model', 'pengembalian');
		$this->load->model('DetailPengembalian_model', 'detail_pengembalian');
		$this->load->model('BarangMasuk_model', 'barang_masuk');
		$this->load->model('DetailBarangMasuk_model', 'detail_barang_masuk');
		$this->load->model('ReturBarang_model', 'retur_barang');
		$this->load->model('DetailReturBarang_model', 'detail_retur_barang');
		cek_login();
	}
	public function index()
	{

		$data['title']                    = 'Dashboard';
		$data['user']                     = $this->pengguna->cekPengguna();
		$data['total_pesanan']            = $this->pesanan->getTotalPesanan();
		$data['total_terjual']            = $this->detail_pesanan->getTotalQty();
		$data['total_pengembalian']       = $this->pengembalian->getTotalPengembalian();
		$data['total_dikembalikan']       = $this->detail_pengembalian->getTotalQty();
		$data['total_barangmasuk']        = $this->barang_masuk->getTotalBarangMasuk();
		$data['total_detail_barangmasuk'] = $this->detail_barang_masuk->getTotalQty();
		$data['total_retur']              = $this->retur_barang->getTotalRetur();
		$data['total_retur_barang']       = $this->detail_retur_barang->getTotalQty();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');
	}
}
