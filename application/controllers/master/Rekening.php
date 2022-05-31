<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->library('form_validation');
        $this->load->model('Rekening_model', 'rekening');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Rekening";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/rekening/rekening_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/rekening/rekening_js');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->rekening->json();
    }

    public function create()
    {
        $data = array(
            'button'         => 'Tambah',
            'action'         => site_url('master/rekening/create_action'),
            'id_rekening'    => set_value('id_rekening'),
            'nama_pemilik'   => set_value('nama_pemilik'),
            'bank'           => set_value('bank'),
            'nomor_rekening' => set_value('nomor_rekening'),
        );
        $data['user']  = $this->pengguna->cekPengguna();
        $data['title'] = "Rekening";
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/rekening/rekening_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/rekening/rekening_js');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_pemilik'   => ucwords($this->input->post('nama_pemilik', TRUE)),
                'bank'           => strtoupper($this->input->post('bank', TRUE)),
                'nomor_rekening' => $this->input->post('nomor_rekening', TRUE),
            );

            $this->rekening->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Rekening'));
        }
    }

    public function update($id)
    {
        $row = $this->rekening->get_by_id($id);

        if ($row) {
            $data = array(
                'button'         => 'Edit',
                'action'         => site_url('master/rekening/update_action'),
                'id_rekening'    => set_value('id_rekening', $row->id_rekening),
                'nama_pemilik'   => set_value('nama_pemilik', $row->nama_pemilik),
                'bank'           => set_value('bank', $row->bank),
                'nomor_rekening' => set_value('nomor_rekening', $row->nomor_rekening),
            );
            $data['user']  = $this->pengguna->cekPengguna();
            $data['title'] = "Rekening";

            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/rekening/rekening_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/rekening/rekening_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Rekening'));
        }
    }

    public function update_action()
    {
        $id_rekening = $this->input->post('id_rekening', TRUE);

        // get previous rekening
        $original_rekening = $this->db->get_where('rekening', ['id_rekening' => $id_rekening])->row_array()['nama_pemilik'];

        if (trim($this->input->post('nomor_rekening')) != $original_rekening) {
            $is_unique =  '|is_unique[rekening.nomor_rekening]';
        } else {
            $is_unique =  '';
        }

        // set messages 
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('required', '%s sudah ada.');
        $this->form_validation->set_message('numeric', '%s harus berupa angka.');
        // set rules
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'trim|required');
        $this->form_validation->set_rules('bank', 'Bank', 'trim|required');
        $this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'trim|required|numeric|is_unique[rekening.nomor_rekening]' . $is_unique);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_rekening', TRUE));
        } else {
            $data = array(
                'nama_pemilik'   => ucwords($this->input->post('nama_pemilik', TRUE)),
                'bank'           => strtoupper($this->input->post('bank', TRUE)),
                'nomor_rekening' => $this->input->post('nomor_rekening', TRUE),
            );

            $this->rekening->update($this->input->post('id_rekening', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Rekening'));
        }
    }

    public function delete($id)
    {
        $row = $this->rekening->get_by_id($id);

        if ($row) {
            $this->rekening->delete($id);
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/Rekening'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Rekening'));
        }
    }

    public function _rules()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('is_unique', '%s sudah ada.');
        $this->form_validation->set_message('numeric', '%s Harus berupa angka.');

        // set rules
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'trim|required');
        $this->form_validation->set_rules('bank', 'Bank', 'trim|required');
        $this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'trim|required|numeric|is_unique[rekening.nomor_rekening]');
        $this->form_validation->set_rules('id_rekening', 'id_rekening', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
