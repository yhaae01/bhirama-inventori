<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model');
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
        $data['title']          = "Supplier";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/supplier/supplier_list', $data);
        $this->load->view('templates/footer');
        $this->load->view('master/supplier/supplier_js');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Supplier_model->json();
    }

    public function read($id)
    {
        $row = $this->Supplier_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_supplier'   => $row->id_supplier,
                'nama_supplier' => $row->nama_supplier,
                'alamat'        => $row->alamat,
                'no_telp'       => $row->no_telp,
                'email'         => $row->email,
                'image'         => $row->image,
            );
            $data['user']       = $this->pengguna->cekPengguna();
            $data['title']      = "Supplier";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/supplier/supplier_read', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Supplier'));
        }
    }

    public function create()
    {
        $data = array(
            'button'        => 'Tambah',
            'action'        => site_url('master/Supplier/create_action'),
            'id_supplier'   => set_value('id_supplier'),
            'nama_supplier' => set_value('nama_supplier'),
            'alamat'        => set_value('alamat'),
            'no_telp'       => set_value('no_telp'),
            'email'         => set_value('email')
        );
        $data['user']       = $this->pengguna->cekPengguna();
        $data['title']      = "Supplier";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('master/supplier/supplier_form', $data);
        $this->load->view('templates/footer');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_supplier' => ucwords($this->input->post('nama_supplier', TRUE)),
                'alamat'        => $this->input->post('alamat', TRUE),
                'no_telp'       => $this->input->post('no_telp', TRUE),
                'email'         => $this->input->post('email', TRUE),
                'image'         => "default.png"
            );

            $this->Supplier_model->insert($data);
            $this->session->set_flashdata('message', 'dibuat.');
            redirect(site_url('master/Supplier'));
        }
    }

    public function update($id)
    {
        $row = $this->Supplier_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'        => 'Edit',
                'action'        => site_url('master/Supplier/update_action'),
                'id_supplier'   => set_value('id_supplier', $row->id_supplier),
                'nama_supplier' => set_value('nama_supplier', $row->nama_supplier),
                'alamat'        => set_value('alamat', $row->alamat),
                'no_telp'       => set_value('no_telp', $row->no_telp),
                'email'         => set_value('email', $row->email),
                'image'         => set_value('image', $row->image),
            );
            $data['user']       = $this->pengguna->cekPengguna();
            $data['title']      = "Supplier";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('master/supplier/supplier_form', $data);
            $this->load->view('templates/footer');
            $this->load->view('master/supplier/supplier_js');
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan.');
            redirect(site_url('master/Supplier'));
        }
    }

    public function update_action()
    {
        $id_supplier = $this->input->post('id_supplier', TRUE);
        // get previous email
        $original_email = $this->db->get_where('supplier', ['id_supplier' => $id_supplier])->row_array()['email'];

        if (trim($this->input->post('email')) != $original_email) {
            $is_unique =  '|is_unique[supplier.email]';
        } else {
            $is_unique =  '';
        }
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s tidak boleh huruf.');
        $this->form_validation->set_message('valid_email', 'Gunakan format Email yang valid.');
        $this->form_validation->set_message('is_unique', '%s sudah terdaftar.');

        // rules
        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim');
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'trim|numeric|min_length[9]|max_length[13]');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email' . $is_unique);
        $this->form_validation->set_rules('id_supplier', 'id_supplier', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');


        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_supplier', TRUE));
        } else {
            $data = array(
                'nama_supplier' => ucwords($this->input->post('nama_supplier', TRUE)),
                'alamat'        => $this->input->post('alamat', TRUE),
                'no_telp'       => $this->input->post('no_telp', TRUE),
                'email'         => $this->input->post('email', TRUE),
            );
            $this->Supplier_model->update($this->input->post('id_supplier', TRUE), $data);

            // cek apakah ada image
            if (file_exists($_FILES['image']['tmp_name'])) {
                // lakukan update image
                $this->ubah_image();
            }

            $this->session->set_flashdata('message', 'di Edit.');
            redirect(site_url('master/Supplier'));
        }
    }

    public function delete($id)
    {
        $row = $this->Supplier_model->get_by_id($id);

        if ($row) {
            $this->Supplier_model->delete($id);
            $this->session->set_flashdata('message', 'Dihapus.');
            redirect(site_url('master/Supplier'));
        } else {
            $this->session->set_flashdata('message', 'tidak ditemukan');
            redirect(site_url('master/Supplier'));
        }
    }

    public function ubah_image()
    {

        //name dari form edit
        $inputfile      = 'image';
        $id_supplier    = $this->input->post('id_supplier');
        $prevImage      = $this->db->get_where('supplier', ['id_supplier' => $id_supplier])->result_array()[0]['image'];


        // PATH IMAGE DISIMPAN
        $config['upload_path']      = './assets/img/supplier/';
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
                unlink(FCPATH . 'assets/img/supplier/' . $prevImage);
            }
            $namaBaru = $this->upload->data('file_name');
            // lakukan update nama file ke table supplier
            $this->db->update('supplier', ["image" => $namaBaru], ['id_supplier' => $id_supplier]);
            return $this->db->affected_rows();
        }
    }

    public function _rules()
    {
        // set messages
        $this->form_validation->set_message('required', '%s tidak boleh kosong.');
        $this->form_validation->set_message('numeric', '%s tidak boleh huruf.');
        $this->form_validation->set_message('valid_email', 'Gunakan format Email yang valid.');
        $this->form_validation->set_message('is_unique', '%s sudah terdaftar.');
        $this->form_validation->set_message('min_length', 'Minimal 9 karakter.');
        $this->form_validation->set_message('max_length', 'Maksimal 13 karakter.');

        // rules
        $this->form_validation->set_rules('nama_supplier', 'nama supplier', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim');
        $this->form_validation->set_rules('no_telp', 'no telp', 'trim|numeric|min_length[9]|max_length[13]');
        $this->form_validation->set_rules('email', 'email', 'trim|valid_email|is_unique[supplier.email]');
        $this->form_validation->set_rules('id_supplier', 'id_supplier', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    // supplier untuk select2 di form input barang masuk
    public function getSupplier()
    {
        $search = trim($this->input->post('search'));
        $page = $this->input->post('page');
        $resultCount = 5; //perPage
        $offset = ($page - 1) * $resultCount;

        // total data yg sudah terfilter
        $count = $this->db
            ->like('nama_supplier', $search)
            ->from('supplier')
            ->count_all_results();

        // tampilkan data per page
        $get = $this->db
            ->select('id_supplier, nama_supplier')
            ->like('nama_supplier', $search)
            ->get('supplier', $resultCount, $offset)
            ->result_array();

        $endCount = $offset + $resultCount;

        $morePages = $endCount < $count ? true : false;

        $data = [];
        $key    = 0;
        foreach ($get as $supplier) {
            $data[$key]['id'] = $supplier['id_supplier'];
            $data[$key]['text'] = ucwords($supplier['nama_supplier']);
            $key++;
        }
        $result = [
            "results" => $data,
            "count_filtered" => $count,
            "pagination" => [
                "more" => $morePages
            ]
        ];
        echo json_encode($result);
    }
}

/* End of file Supplier.php */