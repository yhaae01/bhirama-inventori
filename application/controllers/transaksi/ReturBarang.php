<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReturBarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('ReturBarang_model', 'retur_barang');
        $this->load->model('DetailReturBarang_model', 'detail_retur');
        $this->load->library('datatables');
        cek_login();
        cek_cs();
    }

    public function index()
    {
        $data['title'] = 'Retur Barang';
        $data['user'] = $this->pengguna->cekPengguna();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/retur-barang/retur_list');
        $this->load->view('templates/footer');
        $this->load->view('transaksi/retur-barang/retur_js', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->retur_barang->json();
    }

    public function create()
    {
        $id_pengguna   = $this->session->userdata('id_pengguna');
        // hapus data yg ada pada keranjang where jenis = retur_barang
        $this->db
            ->where('id_pengguna', $id_pengguna)
            ->where('jenis', 'retur_barang')
            ->delete('keranjang');

        $data = array(
            'button' => 'Tambah',
        );
        $data['title'] = 'Tambah Retur Barang';
        $data['user'] = $this->pengguna->cekPengguna();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/retur-barang/retur_form');
        $this->load->view('templates/footer');
        $this->load->view('transaksi/retur-barang/retur_js', $data);
    }

    public function create_action()
    {
        // set timezone
        date_default_timezone_set("Asia/Bangkok");
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');


        // set rules
        $this->form_validation->set_rules('id_barang_masuk', 'Barang masuk', 'trim|required|numeric');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status'       => 'Gagal',
                'barang_masuk' => form_error('id_barang_masuk'),
                'keterangan'   => form_error('keterangan'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {

            $id_pengguna   = $this->session->userdata('id_pengguna');
            // tampung data ke array
            $data = array(
                'id_barang_masuk' => $this->input->post('id_barang_masuk', TRUE),
                'id_pengguna'     => $id_pengguna,
                'tgl_retur'       => date('Y-m-d H:i:s'),
                'status'          => "0",
                'keterangan'      => $this->input->post('keterangan', TRUE),
            );

            $rows = $this->db
                ->where('id_pengguna', $id_pengguna)
                ->where('jenis', 'retur_barang')
                ->get('keranjang')->result_object();

            // jika tidak ada pada keranjang
            if (empty($rows)) {
                $response['status'] = 'empty';
                $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                echo json_encode($response);
            } else {
                $response['status'] = $this->retur_barang->insert($data);
                // set flashdata
                $this->session->set_flashdata('message', 'dibuat.');
                $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                echo json_encode($response);
            }
        }
    }
}

/* End of file ReturBarang.php */
