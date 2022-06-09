<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MetodePembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->library('form_validation');
        $this->load->model('MetodePembayaran_model');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Metode Pembayaran";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/metode-pembayaran/metodepembayaran_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/metode-pembayaran/metodepembayaran_js');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->MetodePembayaran_model->json();
    }


    public function create()
    {
        $data = array(
            'button'                => 'Tambah',
            'action'                => site_url('master/MetodePembayaran/create_action'),
            'id_metodePembayaran'   => set_value('id_metodePembayaran'),
            'nama_metodePembayaran' => set_value('nama_metodePembayaran'),
        );
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Metode Pembayaran";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/metode-pembayaran/MetodePembayaran_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/metode-pembayaran/MetodePembayaran_js');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_metodePembayaran' => ucwords($this->input->post('nama_metodePembayaran', TRUE)),
            );

            $this->MetodePembayaran_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/MetodePembayaran'));
        }
    }

    public function update($id)
    {
        $row = $this->MetodePembayaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'                => 'Edit',
                'action'                => site_url('master/MetodePembayaran/update_action'),
                'id_metodePembayaran'   => set_value('id_metodePembayaran', $row->id_metodePembayaran),
                'nama_metodePembayaran' => set_value('nama_metodePembayaran', $row->nama_metodePembayaran),
            );
            $data['user']  = $this->pengguna->cekPengguna();
            $data['title'] = "Metode Pembayaran";

            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/metode-pembayaran/metodepembayaran_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/metode-pembayaran/metodepembayaran_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/MetodePembayaran'));
        }
    }

    public function update_action()
    {
        $id_metodePembayaran = $this->input->post('id_metodePembayaran', TRUE);

        // get previous MetodePembayaran
        $original_MetodePembayaran = $this->db->get_where('metodepembayaran', ['id_metodePembayaran' => $id_metodePembayaran])->row_array()['nama_metodePembayaran'];

        if (trim($this->input->post('nama_metodePembayaran')) != $original_MetodePembayaran) {
            $is_unique =  '|is_unique[metodepembayaran.nama_metodePembayaran]';
        } else {
            $is_unique =  '';
        }

        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s sudah ada.');
        // set rules
        $this->form_validation->set_rules('nama_metodePembayaran', 'Metode Pembayaran', 'trim|required' . $is_unique);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_metodePembayaran', TRUE));
        } else {
            $data = array(
                'nama_metodePembayaran' => ucwords($this->input->post('nama_metodePembayaran', TRUE)),
            );

            $this->MetodePembayaran_model->update($this->input->post('id_metodePembayaran', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/MetodePembayaran'));
        }
    }

    public function delete($id)
    {
        $row = $this->MetodePembayaran_model->get_by_id($id);

        if ($row) {
            $this->MetodePembayaran_model->delete($id);
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/MetodePembayaran'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/MetodePembayaran'));
        }
    }

    public function _rules()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('is_unique', '%s sudah ada.');

        // set rules
        $this->form_validation->set_rules('nama_metodePembayaran', 'Nama Metode Pembayaran', 'trim|required|is_unique[metodepembayaran.nama_metodePembayaran]');
        $this->form_validation->set_rules('id_metodePembayaran', 'id_metodePembayaran', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    // metode pembayaran untuk select2 di form input pesanan
    public function getMP()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama_metodePembayaran', $search)
            ->from('metodepembayaran')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_metodePembayaran, nama_metodePembayaran')
            ->like('nama_metodePembayaran', $search)
            ->get('metodepembayaran', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $metodePembayaran) {
            $data[$key]['id'] = $metodePembayaran['id_metodePembayaran'];
            $data[$key]['text'] = ucwords($metodePembayaran['nama_metodePembayaran']);
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
