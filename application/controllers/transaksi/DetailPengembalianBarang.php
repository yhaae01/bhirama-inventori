<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailPengembalianBarang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Keranjang_model', 'k');
        $this->load->model('Pesanan_model', 'pesanan');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->k->json_pengembalian_barang();
    }

    public function insertKeranjang()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');
        $this->form_validation->set_message('greater_than_equal_to', '%s harus valid.');

        // set rules
        $this->form_validation->set_rules('idPesanan', 'Pesanan', 'trim|required|numeric');
        $this->form_validation->set_rules('id_detail_produk', 'Produk', 'trim|required|numeric');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required|greater_than_equal_to[1]');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status'  => 'Gagal',
                'pesanan' => form_error('idPesanan'),
                'produk'  => form_error('id_detail_produk'),
                'qty'     => form_error('qty'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            $id_detail_produk = $this->input->post('id_detail_produk', TRUE);
            $id_pengguna      = $this->session->userdata('id_pengguna');
            $qty              = $this->input->post('qty', TRUE);
            $data = array(
                'id_detail_produk' => $id_detail_produk,
                'id_pengguna'      => $id_pengguna,
                'qty'              => $qty,
                'jenis'            => 'pengembalian_barang',
                'sub_total'        => '0'
            );
            $response['status'] = $this->k->insert_pengembalian($data);
            $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
            echo json_encode($response);
        }
    }


    public function deleteKeranjang()
    {
        $id          = $this->input->post('id', TRUE);
        $id_pengguna = $this->session->userdata('id_pengguna');

        $response = array(
            'status'  => $this->k->delete($id),
            'isEmpty' => $this->k->isEmpty($id_pengguna, 'pengembalian_barang'),
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }
}
