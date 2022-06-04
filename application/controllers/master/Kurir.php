<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kurir extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kurir_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Kurir";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/kurir/kurir_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/kurir/kurir_js');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Kurir_model->json();
    }


    public function create()
    {
        $data = array(
            'button'     => 'Tambah',
            'action'     => site_url('master/kurir/create_action'),
            'id_kurir'   => set_value('id_kurir'),
            'nama_kurir' => set_value('nama_kurir'),
        );
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Kurir";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/kurir/kurir_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/kurir/kurir_js');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_kurir' => strtoupper($this->input->post('nama_kurir', TRUE)),
            );

            $this->Kurir_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Kurir'));
        }
    }

    public function update($id)
    {
        $row = $this->Kurir_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'     => 'Edit',
                'action'     => site_url('master/kurir/update_action'),
                'id_kurir'   => set_value('id_kurir', $row->id_kurir),
                'nama_kurir' => set_value('nama_kurir', $row->nama_kurir),
            );
            $data['user']       = $this->pengguna->cekPengguna();
            $data['title']      = "Kurir";

            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/kurir/kurir_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/kurir/kurir_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Kurir'));
        }
    }

    public function update_action()
    {
        $id_kurir = $this->input->post('id_kurir', TRUE);

        // get previous Kurir
        $original_Kurir = $this->db->get_where('kurir', ['id_kurir' => $id_kurir])->row_array()['nama_kurir'];

        if (trim($this->input->post('nama_kurir')) != $original_Kurir) {
            $is_unique =  '|is_unique[kurir.nama_kurir]';
        } else {
            $is_unique =  '';
        }

        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s sudah ada.');
        // set rules
        $this->form_validation->set_rules('nama_kurir', 'Kurir', 'trim|required' . $is_unique);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kurir', TRUE));
        } else {
            $data = array(
                'nama_kurir' => strtoupper($this->input->post('nama_kurir', TRUE)),
            );

            $this->Kurir_model->update($this->input->post('id_kurir', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Kurir'));
        }
    }

    public function delete($id)
    {
        $row = $this->Kurir_model->get_by_id($id);

        if ($row) {
            $this->Kurir_model->delete($id);
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/Kurir'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Kurir'));
        }
    }

    public function _rules()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('is_unique', '%s sudah ada.');

        // set rules
        $this->form_validation->set_rules('nama_kurir', 'Nama Kurir', 'trim|required|is_unique[kurir.nama_kurir]');
        $this->form_validation->set_rules('id_Kurir', 'id_Kurir', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    // Kurir untuk select2 di form edit produk
    public function getKurir()
    {
        $search         = trim($this->input->post('search'));
        $page           = $this->input->post('page');
        $resultCount    = 5; //perPage
        $offset         = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama_kurir', $search)
            ->from('kurir')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_kurir, nama_kurir')
            ->like('nama_kurir', $search)
            ->get('kurir', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $Kurir) {
            $data[$key]['id'] = $Kurir['id_kurir'];
            $data[$key]['text'] = ucwords($Kurir['nama_kurir']);
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

/* End of file Kurir.php */