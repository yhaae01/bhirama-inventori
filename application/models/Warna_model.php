<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Warna_model extends CI_Model
{

    public $table = 'warna';
    public $id = 'id_warna';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('id_warna,nama_warna');
        $this->datatables->from('warna');
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('master/Warna/update/$1') .
                form_button(['type' => 'submit', 'title' => 'Edit', 'class' => 'btn btn-warning', 'content' => '<i class="fas fa-pencil-alt"> </i>']) .
                form_close() . "&nbsp;" .
                form_open('master/Warna/delete/$1') .
                form_button(['type' => 'submit', 'title' => 'Hapus', 'class' => 'btn btn-danger'], '<i class="fas fa-trash-alt"> </i>', 'onclick="javascript: return confirm(\'Yakin ingin hapus ?\')"') .
                form_close() . '</div>',
            'id_warna'
        );
        return $this->datatables->generate();
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
    // get data by nama_warna
    function get_by_nama_warna($nama_warna)
    {
        $this->db->where('nama_warna', $nama_warna);
        return $this->db->get($this->table)->result_object()[0];
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_warna', $q);
        $this->db->or_like('nama_warna', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_warna', $q);
        $this->db->or_like('nama_warna', $q);
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

/* End of file Warna_model.php */