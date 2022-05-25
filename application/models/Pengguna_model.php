<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengguna_model extends CI_Model
{

    public $table = 'pengguna';
    public $id = 'id_pengguna';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('id_pengguna, username, password, nama_pengguna, image, role');
        $this->datatables->from('pengguna');
        //add this line for join
        //$this->datatables->join('table2', 'pengguna.field = table2.field');
        // $this->datatables->add_column('action', anchor(site_url('pengguna/read/$1'), 'Read') . " | " . anchor(site_url('pengguna/update/$1'), 'Update') . " | " . anchor(site_url('pengguna/delete/$1'), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_pengguna');
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('master/Pengguna/read/$1') .
                form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                form_close() . "&nbsp;" .
                form_open('master/Pengguna/update/$1') .
                form_button(['type' => 'submit', 'title' => 'Edit', 'class' => 'btn btn-warning', 'content' => '<i class="fas fa-pencil-alt"> </i>']) .
                form_close() . "&nbsp;" .
                form_open('master/Pengguna/delete/$1') .
                form_button(['type' => 'submit', 'title' => 'Hapus', 'class' => 'btn btn-danger'], '<i class="fas fa-trash-alt"> </i>', 'onclick="javascript: return confirm(\'Are You Sure ?\')"') .
                form_close() . '</div>',
            'id_pengguna'
        );
        return $this->datatables->generate();
    }

    public function cekPenggunaLogin()
    {
        $username = $this->input->post('username');
        return $this->db->get_where('pengguna',  ['username' => $username])->row_array();
    }

    public function cekPengguna()
    {
        return $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_pengguna', $q);
        $this->db->or_like('username', $q);
        $this->db->or_like('password', $q);
        $this->db->or_like('nama_pengguna', $q);
        $this->db->or_like('image', $q);
        $this->db->or_like('role', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_pengguna', $q);
        $this->db->or_like('username', $q);
        $this->db->or_like('password', $q);
        $this->db->or_like('nama_pengguna', $q);
        $this->db->or_like('image', $q);
        $this->db->or_like('role', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file Pengguna_model.php */