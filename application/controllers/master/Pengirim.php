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
}
