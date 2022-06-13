<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Warna extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Warna_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Warna_model->json();
    }

    public function create()
    {
        $data = array(
            'button'        => 'Tambah',
            'action'        => site_url('master/Warna/create_action'),
            'id_warna'      => set_value('id_warna'),
            'nama_warna'    => set_value('nama_warna'),
        );
        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Warna";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/varian/warna_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/varian/varian_js');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_warna' => ucwords($this->input->post('nama_warna', TRUE))
            );

            $this->Warna_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Varian'));
        }
    }

    public function update($id)
    {
        $row = $this->Warna_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Edit',
                'action'        => site_url('master/Warna/update_action'),
                'id_warna'      => set_value('id_warna', $row->id_warna),
                'nama_warna'    => set_value('nama_warna', $row->nama_warna),
            );
            $data['user']           = $this->pengguna->cekPengguna();
            $data['title']          = "Warna";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/varian/warna_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/varian/varian_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Varian'));
        }
    }

    public function update_action()
    {
        $id_warna = $this->input->post('id_warna', TRUE);

        // get previous warna
        $original_warna = $this->db->get_where('warna', ['id_warna' => $id_warna])->row_array()['nama_warna'];
        if (trim($this->input->post('nama_warna')) != $original_warna) {
            $is_unique =  '|is_unique[warna.nama_warna]';
        } else {
            $is_unique =  '';
        }

        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s harus diisi.');
        $this->form_validation->set_message('regex_match', '%s tidak boleh angka.');
        // set rules
        $this->form_validation->set_rules('nama_warna', 'Warna', 'trim|required|regex_match[/^([a-zA-Z]+\s)*[a-zA-Z]+$/]' . $is_unique);
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_warna', TRUE));
        } else {
            $data = array(
                'nama_warna' => ucwords($this->input->post('nama_warna', TRUE))
            );

            $this->Warna_model->update($this->input->post('id_warna', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Varian'));
        }
    }

    public function delete($id)
    {
        $row = $this->Warna_model->get_by_id($id);

        if ($row) {
            $this->Warna_model->delete($id);
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/Varian'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Varian'));
        }
    }

    // warna untuk select2 di form input produk
    public function getWarna()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama_warna', $search)
            ->from('warna')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_warna, nama_warna')
            ->like('nama_warna', $search)
            ->get('warna', $resultCount, $offset)
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
            "count_filtered" => $count,
            "pagination" => [
                "more" => $morePages
            ]
        ];
        echo json_encode($result);
    }

    public function _rules()
    {
        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s harus diisi.');
        $this->form_validation->set_message('regex_match', '%s tidak boleh angka.');
        // set rules
        $this->form_validation->set_rules('nama_warna', 'Nama Warna', 'trim|required|is_unique[warna.nama_warna]|regex_match[/^([a-zA-Z]+\s)*[a-zA-Z]+$/]');
        $this->form_validation->set_rules('id_warna', 'id_warna', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Warna.php */