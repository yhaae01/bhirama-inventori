<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengirim_model extends CI_Model
{
    public function getAllPengirim()
    {
        return $this->db->get('pengirim')->result_array();
    }

    public function tambah_pengirim()
    {
        $data = [
            'nama_pengirim' => htmlspecialchars($this->input->post('nama_pengirim', true)),
        ];

        $this->db->insert('pengirim', $data);

        $this->session->set_flashdata(
            'message',
            'ditambah.'
        );
        redirect('master/Pengirim');
    }

    public function ubah_pengirim()
    {
        $id_pengirim = $this->input->post('id_pengirim', true);
        $data = [
            'nama_pengirim'          => $this->input->post('nama_pengirim', true),
        ];

        $this->db->where('id_pengirim', $id_pengirim);
        $this->db->update('pengirim', $data);

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('master/Pengirim');
    }

    public function hapus_pengirim($id_pengirim)
    {
        $this->db->delete('pengirim', ['id_pengirim' => $id_pengirim]);
        $this->session->set_flashdata(
            'message',
            'dihapus.'
        );
        redirect('master/Pengirim');
    }
}
