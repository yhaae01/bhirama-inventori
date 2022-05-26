<?php
function cek_login()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Tidak Bisa Akses, Harus Login Dulu!! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button></div>');
        // Jika username ada isinya
        if ($ci->session->userdata('username') == !0) {
            redirect('dashboard');
        } else {
            // Jika tidak
            redirect('auth');
        }
    } else {
        // $id_pengguna = $ci->session->userdata('id_pengguna');
        // $role = $ci->session->userdata('role');
    }
}

function cek_pengguna()
{
    $ci = get_instance();
    $role = $ci->session->userdata('role');
    // Jika role bukan admin maka tidak bisa akses
    if ($role != 'admin' and $role != 'CS') {
        $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Maaf, tidak bisa akses!!</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('dashboard');
    }
}

function cek_gudang()
{
    $ci = get_instance();
    $role = $ci->session->userdata('role');
    // Jika role gudang maka tidak bisa akses
    if ($role == 'gudang' || $role == 'GUDANG') {
        $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Maaf, tidak bisa akses!!</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('dashboard');
    }
}

function cek_cs()
{
    $ci = get_instance();
    $role = $ci->session->userdata('role');
    // Jika role gudang maka tidak bisa akses
    if ($role == 'CS' || $role == 'cs') {
        $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Maaf, tidak bisa akses!!</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('dashboard');
    }
}
