<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Varian_model extends CI_Model 
{
    public function getAllWarna()
    {
        return $this->db->get('warna')->result_array();
    }

    public function getAllUkuran()
    {
        return $this->db->get('ukuran')->result_array();
    }

    public function getUkuranById($id_ukuran)
    {
        return $this->db->get_where('ukuran', ['id_ukuran' => $id_ukuran])->row_array();
    }

    public function getWarnaById($id_warna)
    {
        return $this->db->get_where('warna', ['id_warna' => $id_warna])->row_array();
    }

    public function tambah_warna()
    {
        $data = [
            'nama_warna' => htmlspecialchars($this->input->post('nama_warna', true)),
        ];

        $this->db->insert('warna', $data);
        
        $this->session->set_flashdata(
            'message', 
            'ditambah.'
        );
        redirect('master/Varian');
    }

    public function ubah_warna()
    {
        $id_warna = $this->input->post('id_warna', true);
        $data = [
            'nama_warna' => $this->input->post('nama_warna', true),
        ];

        $this->db->where('id_warna', $id_warna);
        $this->db->update('warna', $data);

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('master/Varian');
    }

    public function hapus_warna($id_warna)
    {
        $this->db->delete('warna', ['id_warna' => $id_warna]);
        $this->session->set_flashdata(
            'message',
            'dihapus.'
        );
        redirect('master/Varian');
    }

    public function tambah_ukuran()
    {
        $data = [
            'nama_ukuran' => htmlspecialchars($this->input->post('nama_ukuran', true)),
        ];

        $this->db->insert('ukuran', $data);
        
        $this->session->set_flashdata(
            'message', 
            'ditambah.'
        );
        redirect('master/Varian');
    }

    public function ubah_ukuran()
    {
        $id_ukuran = $this->input->post('id_ukuran', true);
        $data = [
            'nama_ukuran' => $this->input->post('nama_ukuran', true),
        ];

        $this->db->where('id_ukuran', $id_ukuran);
        $this->db->update('ukuran', $data);

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('master/Varian');
    }

    public function hapus_ukuran($id_ukuran)
    {
        $this->db->delete('ukuran', ['id_ukuran' => $id_ukuran]);
        $this->session->set_flashdata(
            'message',
            'dihapus.'
        );
        redirect('master/Varian');
    }

}

/* End of file Varian_model.php */

?>