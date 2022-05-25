<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MetodePembayaran_model extends CI_Model
{
    public function getAllMetodePembayaran()
    {
        return $this->db->get('metodepembayaran')->result_array();
    }

    public function tambah_metodePembayaran()
    {
        $data = [
            'nama_metodePembayaran' => htmlspecialchars($this->input->post('nama_metodePembayaran', true)),
        ];

        $this->db->insert('metodePembayaran', $data);

        $this->session->set_flashdata(
            'message',
            'ditambah.'
        );
        redirect('master/MetodePembayaran');
    }

    public function ubah_metodePembayaran()
    {
        $id_metodePembayaran = $this->input->post('id_metodePembayaran', true);
        $data = [
            'nama_metodePembayaran' => $this->input->post('nama_metodePembayaran', true),
        ];

        $this->db->where('id_metodePembayaran', $id_metodePembayaran);
        $this->db->update('metodepembayaran', $data);

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('master/MetodePembayaran');
    }

    public function hapus_metodePembayaran($id_metodePembayaran)
    {
        $this->db->delete('metodepembayaran', ['id_metodePembayaran' => $id_metodePembayaran]);
        $this->session->set_flashdata(
            'message',
            'dihapus.'
        );
        redirect('master/MetodePembayaran');
    }
}
