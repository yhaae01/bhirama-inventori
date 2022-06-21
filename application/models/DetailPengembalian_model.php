<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailPengembalian_model extends CI_Model
{

    public $table = 'detail_pengembalian_barang';
    public $id    = 'id_detail_pengembalian_barang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get data by id_pengembalian
    function get_by_id_pengembalian($id_pengembalian)
    {
        return $this->db
            ->select('
        p.nama_produk,
        w.nama_warna,
        u.nama_ukuran,
        pes.penerima,
        dpb.qty,
        ')
            ->from($this->table . ' dpb')
            ->where('dpb.id_pengembalian_barang', $id_pengembalian)
            ->join(
                'detail_produk dp',
                'dp.id_detail_produk = dpb.id_detail_produk'
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
                'pengembalian_barang pb',
                'pb.id_pengembalian_barang = dpb.id_pengembalian_barang'
            )
            ->join(
                'pesanan pes',
                'pes.id_pesanan = pb.id_pesanan'
            )
            ->get()->result_object();
    }

    // delete by id_pengembalian
    function delete_by_id_pengembalian($id_pengembalian_barang)
    {
        // cek apakah STATUS pengembalian sudah diproses
        $status_pengembalian = $this->db
            ->select('status')
            ->where('id_pengembalian_barang', $id_pengembalian_barang)
            ->get('pengembalian_barang')->row()->status;

        // jika sudah diproses maka return FALSE
        // agar tidak bisa dihapus
        if ($status_pengembalian == 1) {
            return FALSE;
        }

        // start transaction
        $this->db->trans_start();

        // delete detail_pengembalian_barang dahulu
        $this->db
            ->where('id_pengembalian_barang', $id_pengembalian_barang)
            ->delete('detail_pengembalian_barang');

        // kemudian delete pengembalian_barang
        $this->db
            ->where('id_pengembalian_barang', $id_pengembalian_barang)
            ->delete('pengembalian_barang');

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
}
