<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailProduk_model extends CI_Model
{

    public $table = 'detail_produk';
    public $id = 'id_detail_produk';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($id)
    {
        $this->datatables->where("p.id_produk", $id);
        $this->datatables->select(
            '
            dp.id_detail_produk,
            dp.qty,
            w.nama_warna,
            u.nama_ukuran,
            '
        );
        $this->datatables->from('detail_produk dp');
        //this line for join
        $this->datatables->join('produk p', 'dp.id_produk = p.id_produk');
        $this->datatables->join('warna w', 'dp.id_warna = w.id_warna');
        $this->datatables->join('ukuran u', 'dp.id_ukuran = u.id_ukuran');
        // action
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('master/DetailProduk/delete/$1') .
                form_button(['type' => 'submit', 'title' => 'Hapus', 'class' => 'btn btn-danger hapusDP'], '<i class="fas fa-trash-alt"> </i>') .
                form_close() . '</div>',
            'id_detail_produk'
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

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_produk', $q);
        $this->db->or_like('id_kategori', $q);
        $this->db->or_like('nama_produk', $q);
        $this->db->or_like('image', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_produk', $q);
        $this->db->or_like('id_kategori', $q);
        $this->db->or_like('nama_produk', $q);
        $this->db->or_like('image', $q);
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

/* End of file Produk_model.php */