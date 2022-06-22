<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('BarangMasuk_model', 'barang_masuk');
        $this->load->library('datatables');
        cek_login();
        cek_cs();
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->barang_masuk->json();
    }

    public function index()
    {
        $data['title'] = 'Barang Masuk';
        $data['user']  = $this->pengguna->cekPengguna();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/barang-masuk/barang_masuk_list');
        $this->load->view('templates/footer');
        $this->load->view('transaksi/barang-masuk/barang_masuk_js', $data);
    }

    public function create()
    {
        $id_pengguna   = $this->session->userdata('id_pengguna');
        // hapus data yg ada pada keranjang where jenis = pengembalian_barang
        $this->db
            ->where('id_pengguna', $id_pengguna)
            ->where('jenis', 'barang_masuk')
            ->delete('keranjang');

        $data['title'] = 'Tambah Barang Masuk';
        $data['user']  = $this->pengguna->cekPengguna();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/barang-masuk/barang_masuk_form');
        $this->load->view('templates/footer');
        $this->load->view('transaksi/barang-masuk/barang_masuk_js', $data);
    }

    public function create_action()
    {
        // set timezone
        date_default_timezone_set("Asia/Bangkok");
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');


        // set rules
        $this->form_validation->set_rules('id_supplier', 'Supplier', 'trim|required|numeric');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status'     => 'Gagal',
                'supplier' => form_error('id_supplier'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {

            $id_pengguna   = $this->session->userdata('id_pengguna');
            // tampung data ke array
            $data = array(
                'id_supplier'      => $this->input->post('id_supplier', TRUE),
                'id_pengguna'      => $id_pengguna,
                'tgl_barang_masuk' => date('Y-m-d H:i:s'),
            );

            $rows = $this->db
                ->where('id_pengguna', $id_pengguna)
                ->where('jenis', 'barang_masuk')
                ->get('keranjang')->result_object();

            // jika tidak ada pada keranjang
            if (empty($rows)) {
                $response['status'] = 'empty';
                $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                echo json_encode($response);
            } else {
                $response['status'] = $this->barang_masuk->insert($data);
                // set flashdata
                $this->session->set_flashdata('message', 'dibuat.');
                $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                echo json_encode($response);
            }
        }
    }
}
