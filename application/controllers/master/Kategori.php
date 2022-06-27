<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {
        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Kategori";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/kategori/kategori_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/kategori/kategori_js');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Kategori_model->json();
    }


    public function create()
    {
        $data = array(
            'button'        => 'Tambah',
            'action'        => site_url('master/Kategori/create_action'),
            'id_kategori'   => set_value('id_kategori'),
            'nama_kategori' => set_value('nama_kategori'),
        );
        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Kategori";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/kategori/kategori_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/kategori/kategori_js');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_kategori' => ucwords($this->input->post('nama_kategori', TRUE)),
            );

            $this->Kategori_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Kategori'));
        }
    }

    public function update($id)
    {
        $row = $this->Kategori_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Edit',
                'action'        => site_url('master/Kategori/update_action'),
                'id_kategori'   => set_value('id_kategori', $row->id_kategori),
                'nama_kategori' => set_value('nama_kategori', $row->nama_kategori),
            );
            $data['user']       = $this->pengguna->cekPengguna();
            $data['title']      = "Kategori";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/kategori/kategori_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/kategori/kategori_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Kategori'));
        }
    }

    public function update_action()
    {
        $id_kategori = $this->input->post('id_kategori', TRUE);

        // get previous kategori
        $original_kategori = $this->db->get_where('kategori', ['id_kategori' => $id_kategori])->row_array()['nama_kategori'];

        if (trim($this->input->post('nama_kategori')) != $original_kategori) {
            $is_unique =  '|is_unique[kategori.nama_kategori]';
        } else {
            $is_unique =  '';
        }

        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s sudah ada.');
        // set rules
        $this->form_validation->set_rules('nama_kategori', 'Kategori', 'trim|required' . $is_unique);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kategori', TRUE));
        } else {
            $data = array(
                'nama_kategori' => ucwords($this->input->post('nama_kategori', TRUE)),
            );

            $this->Kategori_model->update($this->input->post('id_kategori', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Kategori'));
        }
    }

    public function delete($id)
    {
        cek_cs();

        if ($this->Kategori_model->delete($id)) {
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/Kategori'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Kategori'));
        }
    }

    public function _rules()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('is_unique', '%s sudah ada.');

        // set rules
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required|is_unique[kategori.nama_kategori]');
        $this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    // kategori untuk select2 di form edit produk
    public function getKategori()
    {
        $search         = trim($this->input->post('search'));
        $page           = $this->input->post('page');
        $resultCount    = 5; //perPage
        $offset         = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama_kategori', $search)
            ->from('kategori')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_kategori, nama_kategori')
            ->like('nama_kategori', $search)
            ->get('kategori', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $kategori) {
            $data[$key]['id']   = $kategori['id_kategori'];
            $data[$key]['text'] = ucwords($kategori['nama_kategori']);
            $key++;
        }
        $result = [
            "results"        => $data,
            "count_filtered" => $count,
            "pagination"     => [
                "more" => $morePages
            ]
        ];
        echo json_encode($result);
    }
}

/* End of file Kategori.php */