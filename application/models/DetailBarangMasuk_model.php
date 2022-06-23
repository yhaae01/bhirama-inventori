<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailBarangMasuk_model extends CI_Model
{

    public $table = 'detail_barang_masuk';
    public $id    = 'id_detail_barang_masuk';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get data by id_barang_masuk
    function get_by_id_barang_masuk($id_barang_masuk)
    {
        return $this->db
            ->select('
            dbm.id_detail_barang_masuk,
            dbm.id_barang_masuk,
            dbm.id_detail_produk,
            dbm.qty,
            p.nama_produk,
            w.nama_warna,
            u.nama_ukuran,
        ')
            ->from($this->table . ' dbm')
            ->join(
                'detail_produk dp',
                'dbm.id_detail_produk = dp.id_detail_produk'
            )
            ->join(
                'produk p',
                'dp.id_produk = p.id_produk'
            )
            ->join(
                'warna w',
                'dp.id_warna = w.id_warna'
            )
            ->join(
                'ukuran u',
                'dp.id_ukuran = u.id_ukuran'
            )
            ->where('id_barang_masuk', $id_barang_masuk)
            ->get()
            ->result_object();
    }

    // get qty by id_barang_masuk
    function get_qty_by_id_barangmasuk_id_detail_produk($id_barang_masuk, $id_detail_produk)
    {
        return $this->db
            ->select('qty')
            ->where('id_barang_masuk', $id_barang_masuk)
            ->where('id_detail_produk', $id_detail_produk)
            ->get('detail_barang_masuk')->row()->qty;
    }
}

/* End of file DetailBarangMasuk_model.php */