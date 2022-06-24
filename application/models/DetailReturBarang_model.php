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
}

/* End of file DetailReturBarang_model.php */