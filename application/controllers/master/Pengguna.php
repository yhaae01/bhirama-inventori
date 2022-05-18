<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('pengguna_model', 'pengguna');
	}

	public function index()
	{
		$data['title'] = 'Pengguna';
		// $data['pengguna'] = $this->db->get_where('pengguna', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();
		$data['pengguna'] = $this->pengguna->getAllPengguna();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('master/pengguna/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambah()
	{
		$data['title'] = 'Tambah Pengguna';
		// $data['user'] = $this->db->get_where('user', [
		//     'username' => $this->session->userdata('username')
		// ])->row_array();

		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[pengguna.username]', [
			'required'  => 'Username harus diisi!',
			'is_unique' => 'Username sudah terdaftar!'
		]);

		$this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'required|trim', [
			'required'  => 'Nama Pengguna harus diisi!',
		]);

		$this->form_validation->set_rules('role', 'Role', 'required|trim', [
			'required'  => 'Role harus dipilih!',
		]);

		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
			'matches'    => 'Password tidak sama!',
			'min_length' => 'Minimal 8 karakter!',
			'required'   => 'Password harus diisi!'
		]);

		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/pengguna/tambah');
			$this->load->view('templates/footer');
		} else {
			$this->pengguna->tambah_pengguna();
		}
	}

	public function ubah($id_pengguna)
	{
		$data['title'] = 'Ubah Pengguna';
		$data['pengguna'] = $this->pengguna->getPenggunaById($id_pengguna);
		$data['role'] = ['admin', 'gudang', 'pemilik'];

		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[pengguna.username]', [
			'required'  => 'Username harus diisi!',
			'is_unique' => 'Username sudah terdaftar!'
		]);

		$this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'required|trim', [
			'required'  => 'Nama Pengguna harus diisi!',
		]);

		$this->form_validation->set_rules('role', 'Role', 'required|trim', [
			'required'  => 'Role harus dipilih!',
		]);

		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]', [
			'matches'    => 'Password tidak sama!',
			'min_length' => 'Minimal 8 karakter!',
			'required'   => 'Password harus diisi!'
		]);
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/pengguna/ubah');
			$this->load->view('templates/footer');
		} else {
			$upload_gambar = $_FILES['image']['name'];

			if ($upload_gambar) {
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']     = '2048';
				$config['upload_path'] = '../assets/img/profile';
				$this->load->library('upload', $config);

				// jika berhasil
				if ($this->upload->do_upload('image')) {
					$gambar_lama = $data['pengguna']['image'];
					if ($gambar_lama != 'default.png') {
						unlink(FCPATH . 'assets/img/profile/' . $gambar_lama);
					}
					$gambar_baru = $this->upload->data('file_name');
					$this->db->set('image', $gambar_baru);
				} else {
					echo $this->upload->display_errors();
				}
			}

			$this->pengguna->ubah_pengguna(['id_pengguna' => $id_pengguna]);
		}
	}

	public function hapus($id_pengguna)
	{
		$this->pengguna->hapus_pengguna($id_pengguna);
	}
}
