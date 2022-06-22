<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailBarangMasuk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Keranjang_model', 'k');
        $this->load->model('Pesanan_model', 'pesanan');
        $this->load->model('DetailProduk_model', 'detail_produk');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_gudang();
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->k->json_barang_masuk();
    }

    public function insertKeranjang()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');
        $this->form_validation->set_message('greater_than_equal_to', '%s harus valid.');

        // set rules
        $this->form_validation->set_rules('idSupplier', 'Supplier', 'trim|required|numeric');
        $this->form_validation->set_rules('id_produk', 'Produk', 'trim|required|numeric');
        $this->form_validation->set_rules('id_warna', 'Warna', 'trim|required');
        $this->form_validation->set_rules('id_ukuran', 'Ukuran', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required|greater_than_equal_to[1]');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required|greater_than_equal_to[1]');
        $this->form_validation->set_rules('berat', 'Berat', 'trim|required|numeric|greater_than_equal_to[1]');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status'   => 'Gagal',
                'supplier' => form_error('idSupplier'),
                'produk'   => form_error('id_produk'),
                'warna'    => form_error('id_warna'),
                'ukuran'   => form_error('id_ukuran'),
                'harga'    => form_error('harga'),
                'qty'      => form_error('qty'),
                'berat'    => form_error('berat'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {

            $idProduk              = $this->input->post('id_produk', TRUE);
            $idWarna               = $this->input->post('id_warna', TRUE);
            $idUkuran              = $this->input->post('id_ukuran', TRUE);
            $last_insert_id_warna  = $idWarna;
            $last_insert_id_ukuran = $idUkuran;
            $id_pengguna           = $this->session->userdata('id_pengguna');
            $qty                   = $this->input->post('qty', TRUE);
            $harga                 = $this->input->post('harga', TRUE);
            $berat                 = $this->input->post('berat', TRUE);
            $id_detailProduk       = $this->detail_produk->get_id_from_varian(
                $idProduk,
                $last_insert_id_warna,
                $last_insert_id_ukuran
            );
            $last_insert_id_detail_produk = $id_detailProduk;

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

            // cek ketersediaan detail_produk
            if (empty($id_detailProduk)) {
                // lakukan insert dahulu ke detail_produk
                $data_detail_produk = array(
                    'id_produk' => $idProduk,
                    'id_warna'  => $last_insert_id_warna,
                    'id_ukuran' => $last_insert_id_ukuran,
                    'harga'     => $harga,
                    'berat'     => $berat,
                    'qty'       => 0
                );

                $last_insert_id_detail_produk = $this->detail_produk->insert_from_barang_masuk($data_detail_produk);
                if ($last_insert_id_detail_produk != FALSE) {
                    $data = array(
                        'id_detail_produk' => $last_insert_id_detail_produk,
                        'id_pengguna'      => $id_pengguna,
                        'qty'              => $qty,
                        'berat'            => $berat,
                        'sub_total'        => $harga,
                        'jenis'            => 'barang_masuk'
                    );
                    $response['status'] = $this->k->insert_barang_masuk($data);
                    $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                    echo json_encode($response);
                }
            } else {
                $data = array(
                    'id_detail_produk' => $last_insert_id_detail_produk,
                    'id_pengguna'      => $id_pengguna,
                    'qty'              => $qty,
                    'berat'            => $berat,
                    'sub_total'        => $harga,
                    'jenis'            => 'barang_masuk'
                );
                $response['status'] = $this->k->insert_barang_masuk($data);
                $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                echo json_encode($response);
            }
        }
    }


    public function deleteKeranjang()
    {
        $id          = $this->input->post('id', TRUE);
        $id_pengguna = $this->session->userdata('id_pengguna');

        $response = array(
            'status' => $this->k->delete($id),
            'isEmpty' => $this->k->isEmptyBarangMasuk($id_pengguna),
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }
}
