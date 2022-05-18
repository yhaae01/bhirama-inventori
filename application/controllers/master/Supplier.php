<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('pengguna_model', 'pengguna');
	}
	public function index()
	{
		$data['title'] = "Supplier";
		$data['user'] = $this->pengguna->cekPengguna();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('master/supplier/index');
		$this->load->view('templates/footer');
	}

	public function tambah()
	{
		$data['title'] = "Tambah Supplier";
		$data['user'] = $this->pengguna->cekPengguna();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('master/supplier/tambah');
		$this->load->view('templates/footer');
	}
}
