<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pengguna_model', 'pengguna');
	}
	public function index()
	{
		$data['title'] = 'Laporan Pesanan';
		$data['user'] = $this->pengguna->cekPengguna();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('laporan/pesanan');
		$this->load->view('templates/footer');
	}
}

/* End of file Pesanan.php */
