<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengembalianBarang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pengguna_model', 'pengguna');
		cek_login();
		cek_gudang();
		cek_cs();
	}
	public function index()
	{
		$data['title'] = 'Laporan Pengembalian Barang';
		$data['user'] = $this->pengguna->cekPengguna();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('laporan/pengembalian-barang/pengembalian_list');
		$this->load->view('templates/footer');
	}
}

/* End of file PengembalianBarang.php */
