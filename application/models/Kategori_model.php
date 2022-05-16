<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model 
{
    public function getAllKategori()
    {
        return $this->db->get('kategori')->result_array();
    }

    public function getKategoriById($id_kategori)
    {
        return $this->db->get_where('kategori', ['id_kategori' => $id_kategori])->row_array();
    }

    public function tambah_kategori()
    {
        $data = [
            'nama_kategori' => htmlspecialchars($this->input->post('nama_kategori', true)),
        ];

        $this->db->insert('kategori', $data);
        
        $this->session->set_flashdata(
            'message', 
            'ditambah.'
        );
        redirect('master/Kategori');
    }

    public function ubah_kategori()
    {
        $id_kategori = $this->input->post('id_kategori', true);
        $data = [
            'nama_kategori'          => $this->input->post('nama_kategori', true),
        ];

        $this->db->where('id_kategori', $id_kategori);
        $this->db->update('kategori', $data);

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('master/Kategori');
    }

    public function hapus_kategori($id_kategori)
    {
        $this->db->delete('kategori', ['id_kategori' => $id_kategori]);
        $this->session->set_flashdata(
            'message',
            'dihapus.'
        );
        redirect('master/Kategori');
    }

}

/* End of file Kategori_model.php */

?>