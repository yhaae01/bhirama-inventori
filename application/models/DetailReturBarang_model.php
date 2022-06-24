<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailReturBarang_model extends CI_Model
{

    public $table = 'detail_retur_barang';
    public $id    = 'id_detail_retur_barang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // delete by id_barang_masuk
    function delete_by_id_retur_barang($id_retur_barang)
    {
        // cek apakah STATUS pesanan sudah diproses
        $status_retur_barang = $this->db
            ->select('status')
            ->where('id_retur_barang', $id_retur_barang)
            ->get('retur_barang')->row()->status;

        // jika sudah diproses maka return FALSE
        // agar tidak bisa dihapus
        if ($status_retur_barang == 1) {
            return FALSE;
        }

        // start transaction
        $this->db->trans_start();

        // delete detail_retur_barang dahulu
        $this->db
            ->where('id_retur_barang', $id_retur_barang)
            ->delete($this->table);

        // kemudian delete retur_barang
        $this->db
            ->where('id_retur_barang', $id_retur_barang)
            ->delete('retur_barang');

        // end transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Something went wrong
            $this->db->trans_rollback(); //rollback
            return FALSE;
        } else {
            // Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // get data by id_pengembalian
    function get_by_id_retur_barang($id_retur)
    {
        return $this->db
            ->select('
        p.nama_produk,
        w.nama_warna,
        u.nama_ukuran,
        drb.qty,
        ')
            ->from($this->table . ' drb')
            ->where('drb.id_retur_barang', $id_retur)
            ->join(
                'detail_produk dp',
                'dp.id_detail_produk = drb.id_detail_produk'
            )
            ->join(
                'produk p',
                'p.id_produk = dp.id_produk'
            )
            ->join(
                'ukuran u',
                'u.id_ukuran = dp.id_ukuran'
            )
            ->join(
                'warna w',
                'w.id_warna = dp.id_warna'
            )
            ->join(
                'retur_barang rb',
                'rb.id_retur_barang = drb.id_retur_barang'
            )
            ->get()->result_object();
    }
}

/* End of file DetailReturBarang_model.php */