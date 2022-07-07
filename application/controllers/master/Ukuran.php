<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ukuran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ukuran_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Ukuran_model->json();
    }

    public function create()
    {
        cek_pengguna();
        cek_cs();
        $data = array(
            'button'        => 'Tambah',
            'action'        => site_url('master/Ukuran/create_action'),
            'id_ukuran'     => set_value('id_ukuran'),
            'nama_ukuran'   => set_value('nama_ukuran'),
        );
        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Ukuran";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/varian/ukuran_form', $data);
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
                'nama_ukuran' => ucwords($this->input->post('nama_ukuran', TRUE))
            );

            $this->Ukuran_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Varian'));
        }
    }

    public function update($id)
    {
        cek_pengguna();
        cek_cs();
        $row = $this->Ukuran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Edit',
                'action'        => site_url('master/Ukuran/update_action'),
                'id_ukuran'     => set_value('id_ukuran', $row->id_ukuran),
                'nama_ukuran'   => set_value('nama_ukuran', $row->nama_ukuran),
            );
            $data['user']           = $this->pengguna->cekPengguna();
            $data['title']          = "Ukuran";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/varian/ukuran_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/varian/varian_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Varian'));
        }
    }

    public function update_action()
    {

        $id_ukuran = $this->input->post('id_ukuran', TRUE);

        // get previous ukuran
        $original_ukuran = $this->db->get_where('ukuran', ['id_ukuran' => $id_ukuran])->row_array()['nama_ukuran'];

        if (trim($this->input->post('nama_ukuran')) != $original_ukuran) {
            $is_unique =  '|is_unique[ukuran.nama_ukuran]';
        } else {
            $is_unique =  '';
        }

        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s harus diisi.');
        // set rules
        $this->form_validation->set_rules('nama_ukuran', 'Ukuran', 'trim|required' . $is_unique);
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_ukuran', TRUE));
        } else {
            $data = array(
                'nama_ukuran' => ucwords($this->input->post('nama_ukuran', TRUE))
            );

            $this->Ukuran_model->update($this->input->post('id_ukuran', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Varian'));
        }
    }

    public function delete($id)
    {
        $row = $this->Ukuran_model->get_by_id($id);

        if ($row) {
            $this->Ukuran_model->delete($id);
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/Varian'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Varian'));
        }
    }

    // ukuran untuk select2 di form input produk
    public function getUkuran()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama_ukuran', $search)
            ->from('ukuran')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_ukuran, nama_ukuran')
            ->like('nama_ukuran', $search)
            ->get('ukuran', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $ukuran) {
            $data[$key]['id'] = $ukuran['id_ukuran'];
            $data[$key]['text'] = ucwords($ukuran['nama_ukuran']);
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
        $this->form_validation->set_message('alpha_numeric', '%s hanya bisa menggunakan huruf dan angka.');

        // set rules
        $this->form_validation->set_rules('nama_ukuran', 'Nama Ukuran', 'trim|required|is_unique[ukuran.nama_ukuran]|alpha_numeric');

        $this->form_validation->set_rules('id_ukuran', 'id_ukuran', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Ukuran.php */