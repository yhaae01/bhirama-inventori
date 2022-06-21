<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengembalianBarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('PengembalianBarang_model', 'pengembalian_barang');
        $this->load->model('DetailPengembalian_model', 'detail_pengembalian');
        $this->load->library('datatables');
        $this->load->model('pengembalianBarang_model', 'pengembalianBarang');
        cek_login();
        cek_cs();
    }

    public function index()
    {
        $data['title'] = 'Pengembalian Barang';
        $data['user'] = $this->pengguna->cekPengguna();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_list');
        $this->load->view('templates/footer');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_js', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->pengembalian_barang->json();
    }

    public function create()
    {
        $id_pengguna   = $this->session->userdata('id_pengguna');
        // hapus data yg ada pada keranjang where jenis = pengembalian_barang
        $this->db
            ->where('id_pengguna', $id_pengguna)
            ->where('jenis', 'pengembalian_barang')
            ->delete('keranjang');

        $data = array(
            'button' => 'Tambah',
        );
        $data['title'] = 'Tambah Pengembalian Barang';
        $data['user'] = $this->pengguna->cekPengguna();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_form');
        $this->load->view('templates/footer');
        $this->load->view('transaksi/pengembalian-barang/pengembalian_js', $data);
    }

    public function create_action()
    {
        // set timezone
        date_default_timezone_set("Asia/Bangkok");
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');


        // set rules
        $this->form_validation->set_rules('id_pesanan', 'Pesanan', 'trim|required|numeric');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status'     => 'Gagal',
                'id_pesanan' => form_error('id_pesanan'),
                'keterangan' => form_error('keterangan'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {

            $id_pengguna   = $this->session->userdata('id_pengguna');
            // tampung data ke array
            $data = array(
                'id_pesanan'       => $this->input->post('id_pesanan', TRUE),
                'id_pengguna'      => $id_pengguna,
                'tgl_pengembalian' => date('Y-m-d H:i:s'),
                'status'           => "0",
                'keterangan'       => $this->input->post('keterangan', TRUE),
            );

            $rows = $this->db
                ->where('id_pengguna', $id_pengguna)
                ->where('jenis', 'pengembalian_barang')
                ->get('keranjang')->result_object();

            // jika tidak ada pada keranjang
            if (empty($rows)) {
                $response['status'] = 'empty';
                $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                // set flashdata
                echo json_encode($response);
            } else {
                $response['status'] = $this->pengembalian_barang->insert($data);
                // set flashdata
                $this->session->set_flashdata('message', 'dibuat.');
                $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
                echo json_encode($response);
            }
        }
    }

    public function read()
    {
        $id                  = $this->input->post('id_pengembalian_barang', TRUE);
        $row                 = $this->pengembalian_barang->get_by_id($id);
        $detail_pengembalian = $this->detail_pengembalian->get_by_id_pengembalian($id);

        if ($row) {
            $data = array(
                'button'              => 'Read',
                'id_pesanan'          => $row->id_pesanan,
                'id_pengembalian'     => $row->id_pengembalian_barang,
                'nama_pengguna'       => $row->nama_pengguna,
                'keterangan'          => $row->keterangan,
                'status'              => $row->status,
                'penerima'            => $row->penerima,
                'tgl_pengembalian'    => $row->tgl_pengembalian,
                'detail_pengembalian' => $detail_pengembalian
            );
            $data['user']  = $this->pengguna->cekPengguna();
            $data['title'] = "Pesanan";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('transaksi/pengembalian-barang/pengembalian_read', $data);
            $this->load->view('templates/footer');
            $this->load->view('transaksi/pengembalian-barang/pengembalian_js', $data);
        } else {
            redirect(site_url('transaksi/PengembalianBarang'));
        }
    }

    public function updateStatusPengembalian()
    {
        $id_pengembalian = $this->input->post('id_pengembalian', TRUE);

        if ($this->pengembalian_barang->updateStatus($id_pengembalian)) {
            $response = array(
                'status' => 'success',
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

    public function delete()
    {
        $id_pengembalian_barang  = $this->input->post('id_pengembalian_barang', TRUE);

        // cek apakah ada detail pengembalian

        if ($this->detail_pengembalian->delete_by_id_pengembalian($id_pengembalian_barang)) {
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
}

/* End of file PengembalianBarang.php */
