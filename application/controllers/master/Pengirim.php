<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengirim extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengirim_model');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Pengirim";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/pengirim/pengirim_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/pengirim/pengirim_js');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Pengirim_model->json();
    }

    public function create()
    {
        $data = array(
            'button'        => 'Tambah',
            'action'        => site_url('master/Pengirim/create_action'),
            'id_pengirim'   => set_value('id_pengirim'),
            'nama_pengirim' => set_value('nama_pengirim'),
        );
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Pengirim";
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/pengirim/pengirim_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/pengirim/pengirim_js');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_pengirim' => ucwords($this->input->post('nama_pengirim', TRUE)),
            );

            $this->Pengirim_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/pengirim'));
        }
    }

    public function update($id)
    {
        $row = $this->Pengirim_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Edit',
                'action'        => site_url('master/Pengirim/update_action'),
                'id_pengirim'   => set_value('id_pengirim', $row->id_pengirim),
                'nama_pengirim' => set_value('nama_pengirim', $row->nama_pengirim),
            );
            $data['user']  = $this->pengguna->cekPengguna();
            $data['title'] = "Pengirim";

            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/pengirim/pengirim_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/pengirim/pengirim_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/pengirim'));
        }
    }

    public function update_action()
    {
        $id_pengirim = $this->input->post('id_pengirim', TRUE);

        // get previous pengirim
        $original_pengirim = $this->db->get_where('pengirim', ['id_pengirim' => $id_pengirim])->row_array()['nama_pengirim'];

        if (trim($this->input->post('nama_pengirim')) != $original_pengirim) {
            $is_unique =  '|is_unique[pengirim.nama_pengirim]';
        } else {
            $is_unique =  '';
        }

        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s sudah ada.');
        // set rules
        $this->form_validation->set_rules('nama_pengirim', 'pengirim', 'trim|required' . $is_unique);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pengirim', TRUE));
        } else {
            $data = array(
                'nama_pengirim' => ucwords($this->input->post('nama_pengirim', TRUE)),
            );

            $this->Pengirim_model->update($this->input->post('id_pengirim', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/pengirim'));
        }
    }

    public function delete($id)
    {
        $row = $this->Pengirim_model->get_by_id($id);

        if ($row) {
            $this->Pengirim_model->delete($id);
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/pengirim'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/pengirim'));
        }
    }

    public function _rules()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('is_unique', '%s sudah ada.');

        // set rules
        $this->form_validation->set_rules('nama_pengirim', 'Nama Pengirim', 'trim|required|is_unique[pengirim.nama_pengirim]');
        $this->form_validation->set_rules('id_pengirim', 'id_pengirim', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
