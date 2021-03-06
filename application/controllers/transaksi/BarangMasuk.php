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
        $this->load->model('DetailBarangMasuk_model', 'detail_barang_masuk');
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

    public function read()
    {
        $id                  = $this->input->post('id_barang_masuk', TRUE);
        $row                 = $this->barang_masuk->get_by_id($id);
        $detail_barang_masuk = $this->detail_barang_masuk->get_by_id_barang_masuk($id);

        if ($row) {
            $data = array(
                'button'              => 'Read',
                'id_barang_masuk'     => $row->id_barang_masuk,
                'nama_pengguna'       => $row->nama_pengguna,
                'nama_supplier'       => $row->nama_supplier,
                'no_telp_supplier'    => $row->no_telp,
                'tgl_barang_masuk'    => $row->tgl_barang_masuk,
                'detail_barang_masuk' => $detail_barang_masuk
            );
            $data['user']  = $this->pengguna->cekPengguna();
            $data['title'] = "Barang Masuk";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('transaksi/barang-masuk/barang_masuk_read', $data);
            $this->load->view('templates/footer');
            $this->load->view('transaksi/barang-masuk/barang_masuk_js', $data);
        } else {
            redirect(site_url('transaksi/BarangMasuk'));
        }
    }

    // BarangMasuk untuk select2 di form input retur
    public function getAllBarangMasuk()
    {
        $search = trim($this->input->post('search'));

        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        if (!empty($search)) {
            // total data yg sudah terfilter
            $count = $this->db
                ->like('id_barang_masuk', $search)
                ->order_by('tgl_barang_masuk', 'DESC')
                ->from('barang_masuk')
                ->join('supplier s', 's.id_supplier = barang_masuk.id_supplier')
                ->or_like('nama_supplier', $search)
                ->count_all_results();


            // tampilkan data per page
            $get = $this->db
                ->select('id_barang_masuk, s.nama_supplier, tgl_barang_masuk')
                ->join('supplier s', 's.id_supplier = barang_masuk.id_supplier')
                ->like('id_barang_masuk', $search)
                ->or_like('nama_supplier', $search)
                ->order_by('tgl_barang_masuk', 'DESC')
                ->get('barang_masuk', $resultCount, $offset)
                ->result_array();
        } else {
            $count = $this->db
                ->order_by('tgl_barang_masuk', 'DESC')
                ->from('barang_masuk')
                ->join('supplier s', 's.id_supplier = barang_masuk.id_supplier')
                ->count_all_results();

            // tampilkan data per page
            $get = $this->db
                ->select('id_barang_masuk, s.nama_supplier, tgl_barang_masuk')
                ->order_by('tgl_barang_masuk', 'DESC')
                ->join('supplier s', 's.id_supplier = barang_masuk.id_supplier')
                ->get('barang_masuk', $resultCount, $offset)
                ->result_array();
        }


        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $barang_masuk) {
            $data[$key]['id'] = $barang_masuk['id_barang_masuk'];
            $data[$key]['text'] = ucwords($barang_masuk['nama_supplier']);
            $date = date_create($barang_masuk['tgl_barang_masuk']);
            $data[$key]['tgl_barang_masuk'] = date_format($date, "d-m-Y");
            $key++;
        }
        $result = [
            "results" => $data,
            "count_filtered" => $count,
            "pagination" => [
                "more" => $morePages
            ]
        ];
        echo json_encode($result);
    }
    // end getAllBarangMasuk
}
