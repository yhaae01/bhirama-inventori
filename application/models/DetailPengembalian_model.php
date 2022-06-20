<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailPengembalian_model extends CI_Model
{

    public $table = 'detail_pengembalian';
    public $id = 'id_detail_pengembalian';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
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
