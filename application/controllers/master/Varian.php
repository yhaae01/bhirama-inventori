<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Varian extends CI_Controller 
{
	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('master/varian/index');
		$this->load->view('templates/footer');
	}

	public function warnaTambah()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('master/varian/warna/tambah');
		$this->load->view('templates/footer');
	}

	public function ukuranTambah()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('master/varian/ukuran/tambah');
		$this->load->view('templates/footer');
	}
}
