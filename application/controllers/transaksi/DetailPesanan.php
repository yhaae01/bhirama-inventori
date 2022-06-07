<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailPesanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Keranjang_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Keranjang_model->json();
    }
}
