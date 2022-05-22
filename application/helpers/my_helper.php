<?php
function cek_login()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        $ci->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Tidak Bisa Akses, Harus Login Dulu!! <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button></div>');
        if ($ci->session->userdata('username') == !0) {
            redirect('dashboard');
        } else {
            redirect('auth');
        }
    } else {
        $id_user    = $ci->session->userdata('id_user');
        $level       = $ci->session->userdata('id_level');
    }
}
