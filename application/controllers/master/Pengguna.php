<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Pengguna_model', 'pengguna');
        cek_login();
        cek_pengguna();
        cek_cs();
    }

    public function index()
    {

        $data['user']           = $this->pengguna->cekPengguna();
        $data['title']          = "Pengguna";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/pengguna/pengguna_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/pengguna/pengguna_js');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->pengguna->json();
    }

    public function read($id)
    {
        $row = $this->pengguna->get_by_id($id);
        if ($row) {
            $data = array(
                'id_pengguna'   => $row->id_pengguna,
                'username'      => $row->username,
                'password'      => $row->password,
                'nama_pengguna' => $row->nama_pengguna,
                'image'         => $row->image,
                'role'          => $row->role,
            );
            $data['user']       = $this->pengguna->cekPengguna();
            $data['title']      = "Pengguna";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/pengguna/pengguna_read', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('master/Pengguna'));
        }
    }

    public function create()
    {
        $data = array(
            'button'        => 'Tambah',
            'action'        => site_url('master/Pengguna/create_action'),
            'id_pengguna'   => set_value('id_pengguna'),
            'username'      => set_value('username'),
            'password'      => set_value('password'),
            'nama_pengguna' => set_value('nama_pengguna'),
            'image'         => set_value('image'),
            'role'          => set_value('role'),
        );
        $data['user']       = $this->pengguna->cekPengguna();
        $data['title']      = "Pengguna";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/pengguna/pengguna_form', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/pengguna/pengguna_js', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'username'      => htmlspecialchars($this->input->post('username', TRUE)),
                'password'      => password_hash(htmlspecialchars($this->input->post('password', TRUE)), PASSWORD_DEFAULT),
                'nama_pengguna' => htmlspecialchars($this->input->post('nama_pengguna', TRUE)),
                'role'          => htmlspecialchars($this->input->post('role', TRUE)),
                'image'         => 'default.png'
            );

            $this->pengguna->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Pengguna'));
        }
    }

    public function update($id)
    {
        $row = $this->pengguna->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Edit',
                'action'        => site_url('master/Pengguna/update_action'),
                'id_pengguna'   => $row->id_pengguna,
                'username'      => $row->username,
                'password'      => $row->password,
                'nama_pengguna' => $row->nama_pengguna,
                'image'         => $row->image,
                'role'          => $row->role
            );
            $data['user']       = $this->pengguna->cekPengguna();
            $data['title']      = "Pengguna";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/pengguna/pengguna_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/pengguna/pengguna_js', $data);
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('master/Pengguna'));
        }
    }

    public function update_action()
    {

        $pw = $this->input->post('password', TRUE);
        $id_pengguna = $this->input->post('id_pengguna', TRUE);

        // get previous username
        $original_username = $this->db->get_where('pengguna', ['id_pengguna' => $id_pengguna])->row_array()['username'];

        if (trim($this->input->post('username')) != $original_username) {
            $is_unique =  '|is_unique[pengguna.username]';
        } else {
            $is_unique =  '';
        }

        // set rules jika ganti password diisi
        if (!empty($pw)) {
            $this->form_validation->set_rules('konfirmasi_ganti_password', 'Konfirmasi Ganti Password', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|matches[konfirmasi_ganti_password]');
        }
        // set rules
        $this->form_validation->set_rules('username', 'Username', 'trim' . $is_unique);
        $this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'trim|required');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');
        $this->form_validation->set_rules('id_pengguna', 'id_pengguna', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('is_unique', '%s sudah digunakan!');
        $this->form_validation->set_message('min_length', '%s minimal 8 karakter!');
        $this->form_validation->set_message('matches', '%s harus sama!');

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pengguna', TRUE));
        } else {
            // jika password tidak diganti
            if (empty($pw)) {
                $data = array(
                    'username'      => htmlspecialchars($this->input->post('username', TRUE)),
                    'nama_pengguna' => htmlspecialchars($this->input->post('nama_pengguna', TRUE)),
                    'role'          => htmlspecialchars($this->input->post('role', TRUE))
                );
            } else {
                $data = array(
                    'username'      => htmlspecialchars($this->input->post('username', TRUE)),
                    'password'      => password_hash(htmlspecialchars($this->input->post('password', TRUE)), PASSWORD_DEFAULT),
                    'nama_pengguna' => htmlspecialchars($this->input->post('nama_pengguna', TRUE)),
                    'role'          => htmlspecialchars($this->input->post('role', TRUE))
                );
            }

            // cek apakah ada image
            if (file_exists($_FILES['image']['tmp_name'])) {
                // lakukan update image
                $this->ubah_image();
            }

            $this->pengguna->update($this->input->post('id_pengguna', TRUE), $data);
            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Pengguna'));
        }
    }

    public function ubah_image()
    {

        //name dari form edit
        $inputfile      = 'image';
        $id_pengguna    = $this->input->post('id_pengguna');
        $prevImage      = $this->db->get_where('pengguna', ['id_pengguna' => $id_pengguna])->result_array()[0]['image'];


        // PATH IMAGE DISIMPAN
        $config['upload_path']      = './assets/img/pengguna/';
        $config['file_ext_tolower'] = TRUE;
        $config['overwrite']        = TRUE;
        $config['encrypt_name']     = TRUE;
        $config['allowed_types']    = 'jpg|jpeg|png|PNG|JPG|JPEG';
        $config['max_size']         = '1024';
        $config['max_width']        = '1024';
        $config['max_height']       = '1024';

        $this->load->library('upload', $config);

        $this->upload->initialize($config);


        // jika upload gagal
        if (!$this->upload->do_upload($inputfile)) {
            return $this->upload->display_errors();
        } else {
            // delete previous image
            if ($prevImage != 'default.png') {
                unlink(FCPATH . 'assets/img/pengguna/' . $prevImage);
            }
            $namaBaru = $this->upload->data('file_name');
            // lakukan update nama file ke table pengguna
            $this->db->update('pengguna', ["image" => $namaBaru], ['id_pengguna' => $id_pengguna]);
            return $this->db->affected_rows();
        }
    }

    public function delete($id)
    {
        $row = $this->pengguna->get_by_id($id);

        if ($row) {
            $this->pengguna->delete($id);
            $this->session->set_flashdata('message', 'dihapus.');
            redirect(site_url('master/Pengguna'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan.');
            redirect(site_url('master/Pengguna'));
        }
    }

    public function _rules()
    {

        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s tidak boleh huruf.');
        $this->form_validation->set_message('max_length', 'Mahal beut harganya.');
        $this->form_validation->set_message('greater_than_equal_to', 'Harus angka dan tidak boleh minus.');

        // set rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'trim|required');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');
        $this->form_validation->set_rules('id_pengguna', 'id_pengguna', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "pengguna.xls";
        $judul = "pengguna";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Username");
        xlsWriteLabel($tablehead, $kolomhead++, "Password");
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Pengguna");
        xlsWriteLabel($tablehead, $kolomhead++, "Image");
        xlsWriteLabel($tablehead, $kolomhead++, "Role");

        foreach ($this->pengguna->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->username);
            xlsWriteLabel($tablebody, $kolombody++, $data->password);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_pengguna);
            xlsWriteLabel($tablebody, $kolombody++, $data->image);
            xlsWriteLabel($tablebody, $kolombody++, $data->role);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pengguna.doc");

        $data = array(
            'pengguna_data' => $this->pengguna->get_all(),
            'start' => 0
        );

        $this->load->view('master/pengguna/pengguna_doc', $data);
    }
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-05-25 09:58:40 */
/* http://harviacode.com */