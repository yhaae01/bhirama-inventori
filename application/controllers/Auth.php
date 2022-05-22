<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index()
  {
    // Jika pengguna sudah masuk maka tidak bisa kembali ke halaman login lewat Url
    if ($this->session->userdata('username')) {
      redirect('dashboard');
    }

    $this->form_validation->set_rules('username', 'Username', 'required|trim', [
      'required' => 'Username Harus Diisi!!',
    ]);

    $this->form_validation->set_rules('password', 'Password', 'required|trim', [
      'required' => 'Password Harus Diisi!!'
    ]);

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('auth/login');
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    $this->load->model('Pengguna_model', 'pengguna');

    $pengguna =  $this->pengguna->cekPenggunaLogin();

    $password = $this->input->post('password');

    if ($pengguna) {

      if (password_verify($password, $pengguna['password'])) {
        $data = [
          'username' => $pengguna['username'],
          'id_user' => $pengguna['id_user'],
          'role' => $pengguna['role']
        ];
        $this->session->set_userdata($data);

        if ($pengguna['role'] == 'admin') {
          redirect('dashboard');
          // echo 'Login Berhasil';
        } else {
          redirect('dashboard');
        }
      } else {
        //Pesan jika password salah
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Password Salah!! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div>');
        redirect('auth');
      }
    } else {
      //Pesan jika username belum ada
      $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Username Belum Ada!! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div>');
      //dikembalikan kehalaman login
      redirect('auth');
    }
  }

  // Fungsi Logout
  public function logout()
  {
    //Unset data user yang diambil berdasarkan username dan id_level
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('role');
    //Pesan logout berhasil dan akan dikembalikan kehalaman auth/login
    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Anda Telah Logout!! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button></div>');
    redirect('auth');
  }
}

/* End of file Auth.php */
