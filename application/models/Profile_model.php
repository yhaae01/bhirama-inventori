<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    public function cekPengguna()
    {
        return $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
    }

    public function ubahPengguna()
    {
        $nama_pengguna = $this->input->post('nama_pengguna', true);
        $username      = $this->input->post('username');

        $this->db->set('nama_pengguna', $nama_pengguna);
        $this->db->where('username', $username);
        $this->db->update('pengguna');

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('Profile');
    }

    public function ubahPassword()
    {
        $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();

        $currentPassword = $this->input->post('currentpassword');
        $newPassword     = $this->input->post('newpassword1');

        if (!password_verify($currentPassword, $data['user']['password'])) {
            // Kalau password salah
            $this->session->set_flashdata(
                'message',
                'gagal.'
            );
            redirect('Profile');
        } else {
            if ($currentPassword == $newPassword) {
                // Kalau password lama dan baru sama
                $this->session->set_flashdata(
                    'message',
                    'gagal.'
                );
                redirect('Profile');
            } else {
                // Kalau berhasil
                $passwordHash   = password_hash($newPassword, PASSWORD_DEFAULT);

                $this->db->set('password', $passwordHash);
                $this->db->where('username', $this->session->userdata('username'));
                $this->db->update('pengguna');

                $this->session->set_flashdata(
                    'message',
                    'diubah.'
                );
                redirect('Profile');
            }
        }
    }
}

/* End of file Profile_model.php */
