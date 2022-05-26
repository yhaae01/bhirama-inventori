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
		cek_login();
		// cek_pengguna();
		// cek_cs();
	}

	public function index()
	{
		$data['title'] = 'Kategori';
		$data['user'] = $this->pengguna->cekPengguna();
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
		$data['kategori'] = $this->kategori->getAllKategori();
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
			$this->load->view('master/kategori/index');
			$this->load->view('templates/footer');
		} else {
			$this->kategori->tambah_kategori();
		}
	}

	public function ubah()
	{
		$data['title'] = 'Ubah Kategori';
		$data['user'] = $this->pengguna->cekPengguna();
		$data['kategori'] = $this->kategori->getAllKategori();


		$this->form_validation->set_rules('nama_kategori', 'Kategori', 'required|trim', [
			'required'   => 'Kategori harus diisi!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/kategori/index');
			$this->load->view('templates/footer');
		} else {
			$this->kategori->ubah_kategori();
		}
	}

	public function hapus($id_kategori)
	{
		$this->kategori->hapus_kategori($id_kategori);
	}


	// kategori untuk select2 di form input produk
	public function getKategori()
	{
		$search = trim($this->input->post('search'));
		$page = $this->input->post('page');
		$resultCount = 5; //perPage
		$offset = ($page - 1) * $resultCount;

		// total data yg sudah terfilter
		$count = $this->db
			->like('nama_kategori', $search)
			->from('kategori')
			->count_all_results();

		// tampilkan data per page
		$get = $this->db
			->select('id_kategori, nama_kategori')
			->like('nama_kategori', $search)
			->get('kategori', $resultCount, $offset)
			->result_array();

		$endCount = $offset + $resultCount;

		$morePages = $endCount < $count ? true : false;

		$data = [];
		$key    = 0;
		foreach ($get as $kategori) {
			$data[$key]['id'] = $kategori['id_kategori'];
			$data[$key]['text'] = ucwords($kategori['nama_kategori']);
			$key++;
		}
		$result = [
			"results" => $data,
			"pagination" => [
				"more" => $morePages
			]
		];
		echo json_encode($result);
	}
}
