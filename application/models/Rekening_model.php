<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Rekening_model extends CI_Model 
{
    public function getAllRekening()
    {
        return $this->db->get('rekening')->result_array();
    }

    public function getRekeningById($id_rekening)
    {
        return $this->db->get_where('rekening', ['id_rekening' => $id_rekening])->row_array();
    }

    public function tambah_rekening()
    {
        $data = [
            'nama_pemilik'   => htmlspecialchars($this->input->post('nama_pemilik', true)),
            'bank'           => htmlspecialchars($this->input->post('bank', true)),
            'nomor_rekening' => htmlspecialchars($this->input->post('nomor_rekening', true)),
        ];

        $this->db->insert('rekening', $data);
        
        $this->session->set_flashdata(
            'message', 
            'ditambah.'
        );
        redirect('master/rekening');
    }

    public function ubah_rekening()
    {
        $id_rekening = $this->input->post('id_rekening', true);
        $data = [
            'nama_pemilik'   => $this->input->post('nama_pemilik', true),
            'bank'           => $this->input->post('bank', true),
            'nomor_rekening' => $this->input->post('nomor_rekening', true),
        ];

        $this->db->where('id_rekening', $id_rekening);
        $this->db->update('rekening', $data);

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('master/rekening');
    }

    public function hapus_rekening($id_rekening)
    {
        $this->db->delete('rekening', ['id_rekening' => $id_rekening]);
        $this->session->set_flashdata(
            'message',
            'dihapus.'
        );
        redirect('master/rekening');
    }

}

/* End of file rekening_model.php */

?>