<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailProduk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('DetailProduk_model', 'dp');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
    }

    public function json($id_produk)
    {
        header('Content-Type: application/json');
        echo $this->dp->json($id_produk);
    }

    public function delete($id)
    {
        $row = $this->dp->get_by_id($id);

        if ($row) {
            $this->dp->delete($id);
            echo json_encode("deleted");
        } else {
            echo json_encode("failed");
        }
    }
}
