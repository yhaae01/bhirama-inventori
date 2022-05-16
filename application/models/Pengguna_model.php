<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model 
{
    public function getAllPengguna()
    {
        return $this->db->get('pengguna')->result_array();
    }

    public function getPenggunaById($id_pengguna)
    {
        return $this->db->get_where('pengguna', ['id_pengguna' => $id_pengguna])->row_array();
    }

    public function tambah_pengguna()
    {
        $data = [
            'username'      => htmlspecialchars($this->input->post('username', true)),
            'password'      => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'nama_pengguna' => htmlspecialchars($this->input->post('nama_pengguna', true)),
            'image'         => 'default.png',
            'role'          => htmlspecialchars($this->input->post('role', true)),
        ];

        $this->db->insert('pengguna', $data);
        
        $this->session->set_flashdata(
            'message', 
            'ditambah.'
        );
        redirect('master/Pengguna');
    }

    public function ubah_pengguna()
    {
        $id_pengguna = $this->input->post('id_pengguna', true);
        $data = [
            'nama_pengguna' => $this->input->post('nama_pengguna', true),
            'password'      => $this->input->post('password', true),
            'role'          => $this->input->post('role', true),
        ];

        $this->db->where('id_pengguna', $id_pengguna);
        $this->db->update('pengguna', $data);

        $this->session->set_flashdata(
            'message',
            'diubah.'
        );
        redirect('master/Pengguna');
    }

    public function hapus_pengguna($id_pengguna)
    {
        $this->db->delete('pengguna', ['id_pengguna' => $id_pengguna]);
        $this->session->set_flashdata(
            'message',
            'dihapus.'
        );
        
        $prevImage  = $this->db->get_where('pengguna', ['id_pengguna' => $id_pengguna])->row_array()['image'];
        if ($prevImage != 'default.png') {
			unlink(FCPATH . 'assets/img/profile/' . $prevImage);
		}

        redirect('master/Pengguna');
    }

}

/* End of file pengguna_model.php */

?>