<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Rekening_model', 'rekening');
	}

    public function index()
    {
        $data['title'] = 'Rekening';
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();
        $data['rekening'] = $this->rekening->getAllRekening();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/rekening/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Rekening';
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

		$this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required|trim',[
            'required'  => 'Nama Pemilik harus diisi!'
        ]);

		$this->form_validation->set_rules('bank', 'Bank', 'required|trim',[
            'required'  => 'Bank harus dipilih!'
        ]);

		$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'numeric|required|trim|is_unique[rekening.nomor_rekening]',[
            'required'  => 'Nomor Rekening harus diisi!',
            'is_unique' => 'Nomor Rekening sudah terdaftar!',
            'numeric'   => 'Nomor Rekening harus berupa angka!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/rekening/tambah');
			$this->load->view('templates/footer');
        } else {
            $this->rekening->tambah_rekening();
        }
    }

    public function ubah($id_rekening)
	{
		$data['title'] = 'Ubah rekening';
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();
        $data['rekening'] = $this->rekening->getRekeningById($id_rekening);

		$this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required|trim',[
            'required'  => 'Nama Pemilik harus diisi!'
        ]);

		$this->form_validation->set_rules('bank', 'Bank', 'required|trim',[
            'required'  => 'Bank harus dipilih!'
        ]);

		$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'numeric|required|trim|is_unique[rekening.nomor_rekening]',[
            'required'  => 'Nomor Rekening harus diisi!',
            'is_unique' => 'Nomor Rekening sudah terdaftar!',
            'numeric'   => 'Nomor Rekening harus berupa angka!'
        ]);

		if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('master/rekening/ubah');
			$this->load->view('templates/footer');
        } else {
            $this->rekening->ubah_rekening();
        }
	}

	public function hapus($id_rekening)
    {
        $this->rekening->hapus_rekening($id_rekening);
    }
}
