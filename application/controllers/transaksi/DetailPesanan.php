<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailPesanan extends CI_Controller
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
            $id_produk   = $this->input->post('id_produk', TRUE);
            $id_warna    = $this->input->post('id_warna', TRUE);
            $id_ukuran   = $this->input->post('id_ukuran', TRUE);
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

    public function deleteKeranjang()
    {
        $id = $this->input->post('id', TRUE);
        $response = array(
            'status' => $this->k->delete($id),
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }


    // provinsi untuk select2 di form detail pesanan
    public function getProvinsi()
    {
        $search         = trim($this->input->post('search'));
        $page           = $this->input->post('page');
        $resultCount    = 5; //perPage
        $offset         = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama', $search)
            ->from('provinsi')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_prov, nama')
            ->like('nama', $search)
            ->get('provinsi', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $provinsi) {
            $data[$key]['id'] = $provinsi['id_prov'];
            $data[$key]['text'] = strtoupper($provinsi['nama']);
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
    // end get provinsi

    // kota/kab untuk select2 di form detail pesanan
    public function getKab()
    {
        $id_prov = $this->input->post('id_prov', TRUE);
        $kab     = $this->db
            ->select('id_kab as id, nama as text')
            ->from('kabupaten')
            ->where('id_prov', $id_prov)
            ->get()
            ->result();
        $response  = array(
            'kab'     => $kab,
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }
    // end get kota/kab


    // kota/kab untuk select2 di form detail pesanan
    public function getKec()
    {
        $id_kab = $this->input->post('id_kab', TRUE);
        $kec    = $this->db
            ->select('id_kec as id, nama as text')
            ->from('kecamatan')
            ->where('id_kab', $id_kab)
            ->get()
            ->result();

        $response = array(
            'kec'     => $kec,
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }
    // end get kota/kab

    // kec untuk select2 di form detail pesanan
    public function getKel()
    {
        $id_kec = $this->input->post('id_kec', TRUE);
        $kel    = $this->db
            ->select('id_kel as id, nama as text')
            ->from('kelurahan')
            ->where('id_kec', $id_kec)
            ->get()
            ->result();

        $response = array(
            'kel'     => $kel,
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }
    // end get kel

    public function create_action()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s harus valid.');
        $this->form_validation->set_message('greater_than_equal_to', '%s tidak boleh minus.');
        $this->form_validation->set_message('max_length', '%s terlalu panjang.');
        $this->form_validation->set_message('min_length', '%s terlalu pendek.');

        // set rules
        $this->form_validation->set_rules('pengirim', 'Pengirim', 'trim|required|numeric');
        $this->form_validation->set_rules('penerima', 'Penerima', 'trim|required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required|numeric');
        $this->form_validation->set_rules('kab', 'Kabupaten', 'trim|required|numeric');
        $this->form_validation->set_rules('kec', 'Kecamatan', 'trim|required|numeric');
        $this->form_validation->set_rules('kel', 'Kelurahan', 'trim|required|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('kodepos', 'Kode Pos', 'trim|required|max_length[5]|numeric');
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'trim|required|max_length[14]|min_length[9]|numeric');
        $this->form_validation->set_rules('mp', 'Metode Pembayaran', 'trim|required|numeric');
        $this->form_validation->set_rules('kurir', 'Kurir', 'trim|required|numeric');
        $this->form_validation->set_rules('ongkir', 'Ongkir', 'trim|required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status'   => 'Gagal',
                'pengirim' => form_error('pengirim'),
                'penerima' => form_error('penerima'),
                'provinsi' => form_error('provinsi'),
                'kab'      => form_error('kab'),
                'kec'      => form_error('kec'),
                'kel'      => form_error('kel'),
                'alamat'   => form_error('alamat'),
                'kodepos'  => form_error('kodepos'),
                'no_telp'  => form_error('no_telp'),
                'mp'       => form_error('mp'),
                'kurir'    => form_error('kurir'),
                'ongkir'   => form_error('ongkir'),
                $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            );
            echo json_encode($response);
        } else {
            $provinsi    = $this->db->where('id_prov', $this->input->post('provinsi', TRUE))->get('provinsi')->row()->nama;
            $kab         = $this->db->where('id_kab', $this->input->post('kab', TRUE))->get('kabupaten')->row()->nama;
            $kec         = $this->db->where('id_kec', $this->input->post('kec', TRUE))->get('kecamatan')->row()->nama;
            $kel         = $this->db->where('id_kel', $this->input->post('kel', TRUE))->get('kelurahan')->row()->nama;
            $kodepos     = $this->input->post('kodepos', TRUE);
            $alamat      = $this->input->post('alamat', TRUE);
            $id_pengguna = $this->session->userdata('id_pengguna');
            $alamatLengkap = $alamat . ', ' . $kel . ', ' . $kec . ', ' . $kab . ', ' . $provinsi . ', ' . $kodepos;

            // tampung data ke array
            $data = array(
                'status'              => 'success',
                'id_pengirim'         => $this->input->post('pengirim', TRUE),
                'id_kurir'            => $this->input->post('kurir', TRUE),
                'id_metodePembayaran' => $this->input->post('mp', TRUE),
                'id_pengguna'         => $id_pengguna,
                'penerima'            => $this->input->post('penerima', TRUE),
                'alamat'              => $alamatLengkap,
                'no_telp'             => $this->input->post('no_telp', TRUE),
                'ongkir'              => $this->input->post('ongkir', TRUE),
                'keterangan'          => $this->input->post('ket', TRUE),
                'status'              => "0",
                'tgl_pesanan'         => date('Y-m-d H:i:s')
            );

            $response['status'] = $this->pesanan->insert($data);
            $response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
            echo json_encode($response);
        }
    }

    public function lastId()
    {
        $a = $this->db
            ->where('id_prov', 32)
            ->get('provinsi')->row()->nama;

        // foreach($a as k)

        print_r($a->nama);
    }
}
