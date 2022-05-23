<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Varian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Varian_model', 'varian');
		$this->load->model('Pengguna_model', 'pengguna');
		cek_login();
		cek_pengguna();
	}

	public function index()
	{
		$data['title'] = 'Varian';
		$data['user'] = $this->pengguna->cekPengguna();
		$data['ukuran'] = $this->varian->getAllUkuran();
		$data['warna'] = $this->varian->getAllWarna();
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('master/varian/index', $data);
		$this->load->view('templates/footer');
	}

	public function warnaTambah()
	{
		$data['title'] = 'Tambah Warna';
		$data['user'] = $this->pengguna->cekPengguna();
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();

		$this->form_validation->set_rules('nama_warna', 'Warna', 'required|trim|is_unique[warna.nama_warna]', [
			'required'  => 'Warna harus diisi!',
			'is_unique' => 'Warna sudah ada!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/varian/warna/tambah', $data);
			$this->load->view('templates/footer');
		} else {
			$this->varian->tambah_warna();
		}
	}

	public function warnaUbah($id_warna)
	{
		$data['title'] = 'Ubah warna';
		$data['user'] = $this->pengguna->cekPengguna();
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();
		$data['warna'] = $this->varian->getWarnaById($id_warna);

		$this->form_validation->set_rules('nama_warna', 'Warna', 'required|trim|is_unique[warna.nama_warna]', [
			'required'  => 'Warna harus diisi!',
			'is_unique' => 'Warna sudah ada!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/varian/warna/ubah', $data);
			$this->load->view('templates/footer');
		} else {
			$this->varian->ubah_warna();
		}
	}

	public function warnaHapus($id_warna)
	{
		$this->varian->hapus_warna($id_warna);
	}

	public function ukuranTambah()
	{
		$data['title'] = 'Tambah Ukuran';
		$data['user'] = $this->pengguna->cekPengguna();
		$data['ukuran'] = $this->varian->getAllUkuran();
		$data['warna'] = $this->varian->getAllWarna();

		$this->form_validation->set_rules('nama_ukuran', 'ukuran', 'required|trim|is_unique[ukuran.nama_ukuran]|max_length[3]', [
			'required'  => 'Ukuran harus diisi!',
			'is_unique' => 'Ukuran sudah ada!',
			'max_length' => 'Ukuran terlalu besar'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/varian/index', $data);
			$this->load->view('templates/footer');
		} else {
			$this->varian->tambah_ukuran();
		}
	}

	public function ukuranUbah()
	{
		$data['title'] = 'Ubah Ukuran';
		$data['user'] = $this->pengguna->cekPengguna();
		$data['ukuran'] = $this->varian->getAllUkuran();
		$data['warna'] = $this->varian->getAllWarna();
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();
		// $data['ukuran'] = $this->varian->getukuranById($id_ukuran);

		$this->form_validation->set_rules('nama_ukuran', 'Ukuran', 'required|trim|is_unique[ukuran.nama_ukuran]', [
			'required'  => 'Ukuran harus diisi!',
			'is_unique' => 'Ukuran sudah ada!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/varian/index', $data);
			$this->load->view('templates/footer');
		} else {
			$this->varian->ubah_ukuran();
		}
	}

	public function ukuranHapus($id_ukuran)
	{
		$this->varian->hapus_ukuran($id_ukuran);
	}
}
