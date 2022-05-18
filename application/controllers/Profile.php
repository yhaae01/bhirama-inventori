<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->pengguna->cekPengguna();
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

        $this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'required|trim', [
            'required'  => 'Nama Pengguna harus diisi!',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('profile/index', $data);
            $this->load->view('templates/footer');
        } else {
            $upload_gambar = $_FILES['image']['name'];

            //Cek requirement gambarnya
            if ($upload_gambar) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/profile';

                $this->load->library('upload', $config);

                // jika berhasil
                if ($this->upload->do_upload('image')) {
                    $gambar_lama = $data['pengguna']['image'];
                    if ($gambar_lama != 'default.png') {
                        unlink(FCPATH . 'assets/img/profile/' . $gambar_lama);
                    }

                    $gambar_baru = $this->upload->data('file_name');

                    $this->db->set('image', $gambar_baru);
                } else {
                    // jika gagal
                    echo $this->upload->display_errors();
                }
            }
            $this->pengguna->ubahPengguna();
            redirect('profile');
        }
    }
}

/* End of file Profile.php */
