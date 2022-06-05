<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pesanan_model extends CI_Model
{

    public $table = 'pesanan';
    public $id = 'id_pesanan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_pesanan,id_pengirim,id_kurir,id_metodePembayaran,status,penerima,alamat,no_telp,tgl_pesanan,keterangan');
        $this->datatables->from('pesanan');
        //add this line for join
        //$this->datatables->join('table2', 'pesanan.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('pesanan/read/$1'),'Read')." | ".anchor(site_url('pesanan/update/$1'),'Update')." | ".anchor(site_url('pesanan/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_pesanan');
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
    function total_rows($q = NULL) {
        $this->db->like('id_pesanan', $q);
	$this->db->or_like('id_pengirim', $q);
	$this->db->or_like('id_kurir', $q);
	$this->db->or_like('id_metodePembayaran', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('penerima', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('no_telp', $q);
	$this->db->or_like('tgl_pesanan', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_pesanan', $q);
	$this->db->or_like('id_pengirim', $q);
	$this->db->or_like('id_kurir', $q);
	$this->db->or_like('id_metodePembayaran', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('penerima', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('no_telp', $q);
	$this->db->or_like('tgl_pesanan', $q);
	$this->db->or_like('keterangan', $q);
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

/* End of file Pesanan_model.php */
/* Location: ./application/models/Pesanan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-06-04 08:48:01 */
/* http://harviacode.com */