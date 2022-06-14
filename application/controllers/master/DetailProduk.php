<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailProduk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('DetailProduk_model', 'dp');
        $this->load->model('Keranjang_model', 'k');
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
        $id  = $this->input->post('id', TRUE);
        $row = $this->dp->get_by_id($id);

        if ($this->dp->delete($id)) {
            $response = array(
                'status' => 'deleted',
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 'failed',
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
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
        $this->form_validation->set_rules('id_warna', 'Warna', 'trim|required');
        $this->form_validation->set_rules('id_ukuran', 'Ukuran', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_rules('berat', 'Berat', 'trim|required|greater_than_equal_to[0]');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'gagal',
                'produk' => form_error('id_produk'),
                'warna'  => form_error('id_warna'),
                'ukuran' => form_error('id_ukuran'),
                'qty'    => form_error('qty'),
                'harga'  => form_error('harga'),
                'berat'  => form_error('berat'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            $idWarna               = $this->input->post('id_warna', TRUE);
            $idUkuran              = $this->input->post('id_ukuran', TRUE);
            $last_insert_id_warna  = $idWarna;
            $last_insert_id_ukuran = $idUkuran;

            // validasi warna, jika tidak ada, maka insert baru
            $this->load->model('Warna_model', 'wm');
            if (empty($this->wm->get_by_id($idWarna))) {
                $this->wm->insert(['nama_warna' => $idWarna]);
                $last_insert_id_warna = $this->db->insert_id();
            }

            // validasi ukuran, jika tidak ada, maka buat baru
            $this->load->model('Ukuran_model', 'um');
            if (empty($this->um->get_by_id($idUkuran))) {
                $this->um->insert(['nama_ukuran' => $idUkuran]);
                $last_insert_id_ukuran = $this->db->insert_id();
            }


            $data = array(
                'id_produk' => $this->input->post('id_produk', TRUE),
                'id_warna'  => $last_insert_id_warna,
                'id_ukuran' => $last_insert_id_ukuran,
                'qty'       => $this->input->post('qty', TRUE),
                'harga'     => $this->input->post('harga', TRUE),
                'berat'     => $this->input->post('berat', TRUE)
            );
            $response['status'] = $this->dp->insert($data);
            $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
            echo json_encode($response);
        }
    }

    public function getWarna()
    {
        $id_produk = $this->input->post('id_produk', TRUE);
        $warna     = $this->dp->getWarna($id_produk);
        $response  = array(
            'warna'     => $warna,
            'id_produk' => $id_produk,
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }

    public function getUkuran()
    {
        $id_produk = $this->input->post('id_produk', TRUE);
        $id_warna  = $this->input->post('id_warna', TRUE);
        $ukuran    = $this->dp->getUkuran($id_produk, $id_warna);
        $response  = array(
            'ukuran'     => $ukuran,
            'id_produk' => $id_produk,
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }

    public function getQtyHarga()
    {

        // set rules
        $this->form_validation->set_rules('id_produk', 'Produk', 'trim|required|numeric');
        $this->form_validation->set_rules('id_warna', 'Warna', 'trim|required|numeric');
        $this->form_validation->set_rules('id_ukuran', 'Ukuran', 'trim|required|numeric');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'Gagal',
                'produk' => form_error('id_produk'),
                'warna'  => form_error('id_warna'),
                'ukuran' => form_error('id_ukuran'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            $id_produk        = $this->input->post('id_produk', TRUE);
            $id_warna         = $this->input->post('id_warna', TRUE);
            $id_ukuran        = $this->input->post('id_ukuran', TRUE);
            $qty              = $this->dp->getQtyHarga($id_produk, $id_warna, $id_ukuran);
            $id_detail_produk = $this->dp->get_id_from_varian($id_produk, $id_warna, $id_ukuran);
            $qty_k            = $this->k->getQty($id_detail_produk);
            // ambil qty keranjang, untuk mengurangi stok yg belum masuk keranjang
            $qty->qty         = $qty->qty - $qty_k;
            $response  = [
                'qty' => $qty,
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            ];
            echo json_encode($response);
        }
    }
}
