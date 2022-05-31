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

    public function delete()
    {
        $id = $this->input->post('id', TRUE);
        $row = $this->dp->get_by_id($id);

        if ($row) {
            $this->dp->delete($id);
            $response = array(
                'status' => 'deleted',
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            echo json_encode("failed");
        }
    }

    public function create_action()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');
        $this->form_validation->set_message('greater_than_equal_to', '%s tidak boleh minus.');

        // set rules
        $this->form_validation->set_rules('id_produk', 'id_produk', 'trim|required|numeric');
        $this->form_validation->set_rules('id_warna', 'Warna', 'trim|required|numeric');
        $this->form_validation->set_rules('id_ukuran', 'Ukuran', 'trim|required|numeric');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'gagal',
                'produk' => form_error('id_produk'),
                'warna'  => form_error('id_warna'),
                'ukuran' => form_error('id_ukuran'),
                'qty'    => form_error('qty'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            $data = array(
                'id_produk' => $this->input->post('id_produk', TRUE),
                'id_warna'  => $this->input->post('id_warna', TRUE),
                'id_ukuran' => $this->input->post('id_ukuran', TRUE),
                'qty'       => $this->input->post('qty', TRUE)
            );
            $response['status'] = $this->dp->insert($data);
            $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
            echo json_encode($response);
        }
    }
}
