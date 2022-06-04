<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_model extends CI_Model
{

    public $table = 'produk';
    public $id = 'id_produk';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select(
            '
            p.id_produk,
            p.nama_produk,
            p.image,
            k.nama_kategori,
            SUM(dp.qty) as stok
            '
        );
        $this->datatables->from('produk p');
        //this line for join
        $this->datatables->join('kategori k', 'p.id_kategori = k.id_kategori');
        $this->datatables->join('detail_produk dp', 'p.id_produk = dp.id_produk', 'left');
        $this->datatables->group_by('p.id_produk');
        // row action

        // jika role cs maka btn edit dan hapus dihilangkan
        if ($this->session->userdata('role') == 'cs') {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('master/Produk/read/$1') .
                    form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . '</div>',
                'id_produk'
            );
        } else {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('master/Produk/update/$1') .
                    form_button(['type' => 'submit', 'title' => 'Edit', 'class' => 'btn btn-warning', 'content' => '<i class="fas fa-pencil-alt"> </i>']) .
                    form_close() . "&nbsp;" .
                    form_open('master/Produk/delete/$1') .
                    form_button(['type' => 'submit', 'title' => 'Hapus', 'class' => 'btn btn-danger'], '<i class="fas fa-trash-alt"> </i>', 'onclick="javascript: return confirm(\'Are You Sure ?\')"') .
                    form_close() . '</div>',
                'id_produk'
            );
        }

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
        $this->db->join('kategori', 'produk.id_kategori = kategori.id_kategori');
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
        // jika ada produk pada tabel detail_produk maka tidak bisa dihapus. 
        if (!$this->db->where($this->id, $id)->from('detail_produk')->count_all_results() > 0) {
            $this->db->where($this->id, $id);
            $this->db->delete($this->table);
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* End of file Produk_model.php */