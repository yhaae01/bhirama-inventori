<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
    }

    public function index()
    {
        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Produk";
        $data['button']         = "Index";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/produk/produk_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/produk/produk_js', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Produk_model->json();
    }

    public function read($id)
    {
        $row = $this->Produk_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button'        => 'Read',
                'id_produk'     => $row->id_produk,
                'id_kategori'   => $row->id_kategori,
                'nama_kategori' => $row->nama_kategori,
                'nama_produk'   => $row->nama_produk,
                'image'         => $row->image,
            );
            $data['user']           = $this->pengguna->cekPengguna();
            $data['title']          = "Produk";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/produk/produk_read', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/produk/produk_js', $data);
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Produk'));
        }
    }

    public function create()
    {
        cek_cs();
        $data = array(
            'button'        => 'Tambah',
            'action'        => site_url('master/Produk/create_action'),
            'id_produk'     => set_value('id_produk'),
            'id_kategori'   => set_value('id_kategori'),
            'nama_produk'   => set_value('nama_produk'),
            'image'         => set_value('image'),
        );
        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Produk";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/produk/produk_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/produk/produk_js');
    }

    public function create_action()
    {
        cek_cs();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id_kategori'   => $this->input->post('id_kategori', TRUE),
                'nama_produk'   => $this->input->post('nama_produk', TRUE),
                'image'         => "default.png"
            );

            $this->Produk_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Produk'));
        }
    }

    public function update($id)
    {
        cek_cs();
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Edit',
                'action'        => site_url('master/Produk/update_action'),
                'id_produk'     => set_value('id_produk', $row->id_produk),
                'id_kategori'   => set_value('id_kategori', $row->id_kategori),
                'nama_kategori' => set_value('nama_kategori', $row->nama_kategori),
                'nama_produk'   => set_value('nama_produk', $row->nama_produk),
                'image'         => set_value('image', $row->image),
            );
            $data['user']       = $this->pengguna->cekPengguna();
            $data['title']      = "Produk";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/produk/produk_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/produk/produk_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Produk'));
        }
    }

    public function update_action()
    {
        cek_cs();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_produk', TRUE));
        } else {
            $data = array(
                'id_kategori'   => $this->input->post('id_kategori', TRUE),
                'nama_produk'   => $this->input->post('nama_produk', TRUE)
            );

            $this->Produk_model->update($this->input->post('id_produk', TRUE), $data);

            // cek apakah ada image
            if (file_exists($_FILES['image']['tmp_name'])) {
                // lakukan update image
                $this->ubah_image();
            }

            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Produk'));
        }
    }

    public function delete($id)
    {
        cek_cs();
        $row = $this->Produk_model->get_by_id($id);

        if ($this->Produk_model->delete($id)) {;
            $this->session->set_flashdata('message', 'Dihapus.');
            redirect(site_url('master/Produk'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Produk'));
        }
    }

    public function ubah_image()
    {
        cek_cs();

        //name dari form edit
        $inputfile      = 'image';
        $id_produk    = $this->input->post('id_produk');
        $prevImage      = $this->db->get_where('produk', ['id_produk' => $id_produk])->result_array()[0]['image'];


        // PATH IMAGE DISIMPAN
        $config['upload_path']      = './assets/img/produk/';
        $config['file_ext_tolower'] = TRUE;
        $config['overwrite']        = TRUE;
        $config['encrypt_name']     = TRUE;
        $config['allowed_types']    = 'jpg|jpeg|png|PNG|JPG|JPEG';
        $config['max_size']         = '1024';
        $config['max_width']        = '1024';
        $config['max_height']       = '1024';

        $this->load->library('upload', $config);

        $this->upload->initialize($config);


        // jika upload gagal
        if (!$this->upload->do_upload($inputfile)) {
            return $this->upload->display_errors();
        } else {
            // delete previous image
            if ($prevImage != 'default.png') {
                unlink(FCPATH . 'assets/img/produk/' . $prevImage);
            }
            $namaBaru = $this->upload->data('file_name');
            // lakukan update nama file ke table produk
            $this->db->update('produk', ["image" => $namaBaru], ['id_produk' => $id_produk]);
            return $this->db->affected_rows();
        }
    }

    public function _rules()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');

        // set rules
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required');

        $this->form_validation->set_rules('id_produk', 'id_produk', 'trim|numeric');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    // produk untuk select2 di form input pesanan
    public function getProduk()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama_produk', $search)
            ->from('produk')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_produk, nama_produk')
            ->like('nama_produk', $search)
            ->get('produk', $resultCount, $offset)
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
}

/* End of file Produk.php */
