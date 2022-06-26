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
          'username'    => $pengguna['username'],
          'id_pengguna' => $pengguna['id_pengguna'],
          'role'        => $pengguna['role']
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
        $this->session->set_flashdata(
          'message',
          '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Oops! Password salah.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
        <span aria-hidden="true">&times;</span></button></div>'
        );

        $this->load->view('auth/login');
      }
    } else {
      //Pesan jika username belum ada
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Oops! Username belum terdaftar.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
      <span aria-hidden="true">&times;</span></button></div>'
      );

      $this->load->view('auth/login');
    }
  }

  // Fungsi Logout
  public function logout()
  {
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('id_pengguna');
    $this->session->unset_userdata('role');
    //Pesan logout berhasil dan akan dikembalikan kehalaman auth/login
    $this->session->set_flashdata(
      'message',
      '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Berhasil logout. 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
    <span aria-hidden="true">&times;</span></button></div>'
    );

    redirect('auth');
  }
}

/* End of file Auth.php */
