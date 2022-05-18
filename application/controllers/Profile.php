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

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');
    }

    public function ubahPengguna()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->pengguna->cekPengguna();

        $this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'trim|required', [
            'required' => 'Nama Pengguna harus diisi!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('profile/index', $data);
            $this->load->view('templates/footer');
        } else {
            // jika ada gambar yang di upload
            $uploadImage = $_FILES['image']['name'];

            if ($uploadImage) {
                $config['upload_path']   = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) { // ngambil dari name img
                    $oldImage = $data['user']['image']; // ngambil dari data diatas, tabel user field image
                    if ($oldImage != 'default.png') {
                        unlink(FCPATH . 'assets/img/profile/' . $oldImage);
                    }
                    $newImage = $this->upload->data('file_name');
                    $this->db->set('image', $newImage);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            // hanya ubah nama
            $this->pengguna->ubahPengguna();
        }
    }

    public function ubahPassword()
    {
        $data['title'] = 'My Profile';
        $data['user']  = $this->pengguna->cekPengguna();

        $this->form_validation->set_rules('currentpassword', 'Password Lama', 'trim|required', [
            'required' => 'Password Lama harus diisi!'
        ]);
        $this->form_validation->set_rules('newpassword1', 'New Password', 'trim|required|min_length[8]|matches[newpassword2]', [
            'required'   => 'Password Baru harus diisi!',
            'min_length' => 'Minimal 8 karakter!',
            'matches'    => 'Password Baru tidak sama!'
        ]);
        $this->form_validation->set_rules('newpassword2', 'New Password', 'trim|required|min_length[8]|matches[newpassword1]',[
            'required'   => 'Password Baru harus diisi!',
            'min_length' => 'Minimal 8 karakter!',
            'matches'    => 'Password Baru tidak sama!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('profile/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->pengguna->ubahPassword();
        }
    }
}

/* End of file Profile.php */
