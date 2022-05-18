<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Kategori_model', 'kategori');
		$this->load->model('Pengguna_model', 'pengguna');
	}

	public function index()
	{
		$data['title'] = 'Kategori';
		$data['user'] = $this->pengguna->cekPengguna();
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();
		$data['kategori'] = $this->kategori->getAllKategori();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('master/kategori/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambah()
	{
		$data['title'] = 'Tambah Kategori';
		$data['user'] = $this->pengguna->cekPengguna();
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();

		$this->form_validation->set_rules('nama_kategori', 'Kategori', 'required|trim|is_unique[kategori.nama_kategori]', [
			'required'  => 'Kategori harus diisi!',
			'is_unique' => 'Kategori sudah ada!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/kategori/tambah');
			$this->load->view('templates/footer');
		} else {
			$this->kategori->tambah_kategori();
		}
	}

	public function ubah($id_kategori)
	{
		$data['title'] = 'Ubah Kategori';
		$data['user'] = $this->pengguna->cekPengguna();
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();
		$data['kategori'] = $this->kategori->getKategoriById($id_kategori);

		$this->form_validation->set_rules('nama_kategori', 'Kategori', 'required|trim', [
			'required'   => 'Kategori harus diisi!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/kategori/ubah');
			$this->load->view('templates/footer');
		} else {
			$this->kategori->ubah_kategori();
		}
	}

	public function hapus($id_kategori)
	{
		$this->kategori->hapus_kategori($id_kategori);
	}
}
