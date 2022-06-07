<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailPesanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Keranjang_model', 'k');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->k->json();
    }

    public function insertKeranjang()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');
        $this->form_validation->set_message('greater_than_equal_to', '%s tidak boleh minus.');

        // set rules
        $this->form_validation->set_rules('id_produk', 'Produk', 'trim|required|numeric');
        $this->form_validation->set_rules('id_warna', 'Warna', 'trim|required|numeric');
        $this->form_validation->set_rules('id_ukuran', 'Ukuran', 'trim|required|numeric');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'Gagal',
                'produk' => form_error('id_produk'),
                'warna'  => form_error('id_warna'),
                'ukuran' => form_error('id_ukuran'),
                'qty'    => form_error('qty'),
                'harga'  => form_error('harga'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            $id_produk = $this->input->post('id_produk', TRUE);
            $id_warna  = $this->input->post('id_warna', TRUE);
            $id_ukuran = $this->input->post('id_ukuran', TRUE);
            $id_pengguna = $this->session->userdata('id_pengguna');

            $id_detail_produk = $this->k->get_id_detail_produk($id_produk, $id_warna, $id_ukuran);
            $data = array(
                'id_detail_produk' => $id_detail_produk,
                'id_pengguna'      => $id_pengguna,
                'qty'              => $this->input->post('qty', TRUE),
                'sub_total'        => $this->input->post('harga', TRUE)
            );
            $response['status'] = $this->k->insert($data);
            $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
            echo json_encode($response);
        }
    }
}
