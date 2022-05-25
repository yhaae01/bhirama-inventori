<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengirim extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengirim_model', 'pengirim');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {
        $data['title'] = 'Pengirim';
        $data['user'] = $this->pengguna->cekPengguna();
        $data['pengirim'] = $this->pengirim->getAllPengirim();
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/pengirim/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Pengirim';
        $data['user'] = $this->pengguna->cekPengguna();
        $data['pengirim'] = $this->pengirim->getAllPengirim();
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

        $this->form_validation->set_rules('nama_pengirim', 'Pengirim', 'required|trim|is_unique[pengirim.nama_pengirim]', [
            'required'  => 'Pengirim harus diisi!',
            'is_unique' => 'Pengirim sudah ada!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('master/pengirim/index');
            $this->load->view('templates/footer');
        } else {
            $this->pengirim->tambah_pengirim();
        }
    }

    public function ubah()
    {
        $data['title'] = 'Ubah Pengirim';
        $data['user'] = $this->pengguna->cekPengguna();
        $data['pengirim'] = $this->pengirim->getAllPengirim();
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

        $this->form_validation->set_rules('nama_pengirim', 'Pengirim', 'required|trim|is_unique[pengirim.nama_pengirim]', [
            'required'   => 'Pengirim harus diisi!',
            'is_unique' => 'Pengirim Sudah Ada'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('master/pengirim/index');
            $this->load->view('templates/footer');
        } else {
            $this->pengirim->ubah_pengirim();
        }
    }

    public function hapus($id_pengirim)
    {
        $this->pengirim->hapus_pengirim($id_pengirim);
    }
}
