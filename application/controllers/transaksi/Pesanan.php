<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pesanan_model');
        $this->load->model('DetailPesanan_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_gudang();
    }

    public function index()
    {
        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Pesanan";
        $data['button']         = "Index";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pesanan/pesanan_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('transaksi/pesanan/pesanan_js', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Pesanan_model->json();
    }

    public function read()
    {
        $id             = $this->input->post('id_pesanan', TRUE);
        $row            = $this->Pesanan_model->get_by_id($id);
        $detail_pesanan = $this->DetailPesanan_model->get_by_id_pesanan($id);

        if ($row) {
            $data = array(
                'button'                => 'Read',
                'id_pesanan'            => $row->id_pesanan,
                'nama_pengirim'         => $row->nama_pengirim,
                'nama_kurir'            => $row->nama_kurir,
                'nama_pengguna'         => $row->nama_pengguna,
                'nama_metodePembayaran' => $row->nama_metodePembayaran,
                'status'                => $row->status,
                'penerima'              => $row->penerima,
                'alamat'                => $row->alamat,
                'no_telp'               => $row->no_telp,
                'tgl_pesanan'           => $row->tgl_pesanan,
                'ongkir'                => $row->ongkir,
                'keterangan'            => $row->keterangan,
                'detail_pesanan'        => $detail_pesanan
            );
            $data['user']  = $this->pengguna->cekPengguna();
            $data['title'] = "Pesanan";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('transaksi/pesanan/pesanan_read', $data);
            $this->load->view('templates/footer');
            $this->load->view('transaksi/pesanan/pesanan_js', $data);
        } else {
            redirect(site_url('transaksi/Pesanan'));
        }
    }

    public function print($idPesanan)
    {
        $row            = $this->Pesanan_model->get_by_id($idPesanan);
        $detail_pesanan = $this->DetailPesanan_model->get_by_id_pesanan($idPesanan);

        if ($row) {
            $data = array(
                'button'                => 'Print',
                'id_pesanan'            => $row->id_pesanan,
                'nama_pengirim'         => $row->nama_pengirim,
                'nama_kurir'            => $row->nama_kurir,
                'nama_pengguna'         => $row->nama_pengguna,
                'nama_metodePembayaran' => $row->nama_metodePembayaran,
                'status'                => $row->status,
                'penerima'              => $row->penerima,
                'alamat'                => $row->alamat,
                'no_telp'               => $row->no_telp,
                'tgl_pesanan'           => $row->tgl_pesanan,
                'ongkir'                => $row->ongkir,
                'keterangan'            => $row->keterangan,
                'detail_pesanan'        => $detail_pesanan
            );
            $data['user']  = $this->pengguna->cekPengguna();
            $data['title'] = "Pesanan";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('transaksi/pesanan/pesanan_read', $data);
            $this->load->view('templates/footer');
            $this->load->view('transaksi/pesanan/pesanan_js', $data);
        } else {
            redirect(site_url('transaksi/Pesanan'));
        }
    }

    public function create()
    {
        $data = array(
            'button'              => 'Tambah'
        );
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Pesanan";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pesanan/pesanan_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('transaksi/pesanan/pesanan_js', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id_pengirim'         => $this->input->post('id_pengirim', TRUE),
                'id_kurir'            => $this->input->post('id_kurir', TRUE),
                'id_metodePembayaran' => $this->input->post('id_metodePembayaran', TRUE),
                'status'              => '0',
                'penerima'            => $this->input->post('penerima', TRUE),
                'alamat'              => $this->input->post('alamat', TRUE),
                'no_telp'             => $this->input->post('no_telp', TRUE),
                'tgl_pesanan'         => date('d-m-Y H:i:s'),
                'keterangan'          => $this->input->post('keterangan', TRUE),
            );

            $this->Pesanan_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('transaksi/Pesanan'));
        }
    }

    public function updateStatus()
    {
        $id_pesanan = $this->input->post('id_pesanan', TRUE);

        if ($this->Pesanan_model->updateStatus($id_pesanan)) {
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
        $id_pesanan  = $this->input->post('id_pesanan', TRUE);

        if ($this->DetailPesanan_model->delete_by_id_pesanan($id_pesanan)) {
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

    public function _rules()
    {
        $this->form_validation->set_rules('id_pengirim', 'Pengirim', 'trim|required|numeric');
        $this->form_validation->set_rules('id_kurir', 'Kurir', 'trim|required|numeric');
        $this->form_validation->set_rules('id_metodePembayaran', 'Metode Pembayaran', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('penerima', 'Penerima', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'trim|required|numeric|min_length[9]|max_length[15]');
        $this->form_validation->set_rules('tgl_pesanan', 'Tanggal Pesanan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');

        $this->form_validation->set_rules('id_pesanan', 'id_pesanan', 'trim|numeric');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "pesanan.xls";
        $judul = "pesanan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Pengirim");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Kurir");
        xlsWriteLabel($tablehead, $kolomhead++, "Id MetodePembayaran");
        xlsWriteLabel($tablehead, $kolomhead++, "Status");
        xlsWriteLabel($tablehead, $kolomhead++, "Penerima");
        xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
        xlsWriteLabel($tablehead, $kolomhead++, "No Telp");
        xlsWriteLabel($tablehead, $kolomhead++, "Tgl Pesanan");
        xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

        foreach ($this->Pesanan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_pengirim);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_kurir);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_metodePembayaran);
            xlsWriteLabel($tablebody, $kolombody++, $data->status);
            xlsWriteLabel($tablebody, $kolombody++, $data->penerima);
            xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
            xlsWriteLabel($tablebody, $kolombody++, $data->no_telp);
            xlsWriteLabel($tablebody, $kolombody++, $data->tgl_pesanan);
            xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pesanan.doc");

        $data = array(
            'pesanan_data' => $this->Pesanan_model->get_all(),
            'start' => 0
        );

        $this->load->view('pesanan/pesanan_doc', $data);
    }


    // produk untuk select2 di form input pesanan
    // hanya produk yg sudah mempunyai stok
    public function getProdukPesanan()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('p.nama_produk', $search)
            ->select('p.id_produk, p.nama_produk')
            ->from('detail_produk dp')
            ->join('produk p', 'p.id_produk = dp.id_produk') //cek apakah ada di tabel produk
            ->group_by('dp.id_produk')
            ->count_all_results();


        // tampilkan data per page
        $get = $this->db
            ->select('p.id_produk, p.nama_produk')
            ->like('p.nama_produk', $search)
            ->join('produk p', 'p.id_produk = dp.id_produk')
            ->group_by('dp.id_produk')
            ->get('detail_produk dp', $resultCount, $offset)
            ->result_array();



        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $produk) {
            $data[$key]['id'] = $produk['id_produk'];
            $data[$key]['text'] = ucwords($produk['nama_produk']);
            $key++;
        }
        $result = [
            "results" => $data,
            "pagination" => [
                "more" => $morePages
            ]
        ];
        echo json_encode($result);
    }

    // warna untuk select2 di form input pesanan
    public function getWarnaPesanan()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('w.nama_warna', $search)
            ->from('detail_produk dp')
            ->join('warna w', 'dp.id_warna = w.id_warna')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('dp.id_detail_produk, w.nama_warna')
            ->like('w.nama_warna', $search)
            ->join('warna w', 'dp.id_warna = w.id_warna')
            ->get('detail_produk dp', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $warna) {
            $data[$key]['id'] = $warna['id_warna'];
            $data[$key]['text'] = ucwords($warna['nama_warna']);
            $key++;
        }
        $result = [
            "results" => $data,
            "pagination" => [
                "more" => $morePages
            ]
        ];
        echo json_encode($result);
    }

    // Pesanan untuk select2 di form input pengembalian
    public function getAllPesanan()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('id_pesanan', $search)
            ->or_like('penerima', $search)
            ->or_like('tgl_pesanan', $search)
            ->from('pesanan')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_pesanan, penerima, tgl_pesanan')
            ->like('id_pesanan', $search)
            ->or_like('penerima', $search)
            ->or_like('tgl_pesanan', $search)
            ->get('pesanan', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $pesanan) {
            $data[$key]['id'] = $pesanan['id_pesanan'];
            $data[$key]['text'] = ucwords($pesanan['penerima']);
            $date = date_create($pesanan['tgl_pesanan']);
            $data[$key]['tgl_pesanan'] = date_format($date, "d-m-Y");
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

    // end getAllPesanan


}

/* End of file Pesanan.php */