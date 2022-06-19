<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailPesanan_model extends CI_Model
{

    public $table = 'detail_pesanan';
    public $id = 'id_detail_pesanan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get data by id_pesanan
    function get_by_id_pesanan($id_pesanan)
    {
        return $this->db
            ->select('
        produk.nama_produk,
        warna.nama_warna,
        ukuran.nama_ukuran,
        detail_pesanan.qty,
        detail_pesanan.sub_total
        ')
            ->from('detail_pesanan')
            ->where('detail_pesanan.id_pesanan', $id_pesanan)
            ->join('detail_produk', 'detail_produk.id_detail_produk = detail_pesanan.id_detail_produk')
            ->join('produk', 'detail_produk.id_produk = produk.id_produk')
            ->join('pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan')
            ->join('ukuran', 'detail_produk.id_ukuran = ukuran.id_ukuran')
            ->join('warna', 'detail_produk.id_warna = warna.id_warna')
            ->get()->result_object();
    }
    // get qty by id_pesanan
    function get_by_id_pesanan_id_detail_produk($id_pesanan, $id_detail_produk)
    {
        return $this->db
            ->select('
        detail_pesanan.qty
        ')
            ->from('detail_pesanan')
            ->where('detail_pesanan.id_pesanan', $id_pesanan)
            ->where('detail_produk.id_detail_produk', $id_detail_produk)
            ->join('detail_produk', 'detail_produk.id_detail_produk = detail_pesanan.id_detail_produk')
            ->join('produk', 'detail_produk.id_produk = produk.id_produk')
            ->join('pesanan', 'detail_pesanan.id_pesanan = pesanan.id_pesanan')
            ->join('ukuran', 'detail_produk.id_ukuran = ukuran.id_ukuran')
            ->join('warna', 'detail_produk.id_warna = warna.id_warna')
            ->get()->row()->qty;
    }


    // delete by id_pesanan
    function delete_by_id_pesanan($id_pesanan)
    {
        // cek apakah STATUS pesanan sudah diproses
        $status_pesanan = $this->db
            ->select('status')
            ->where('id_pesanan', $id_pesanan)
            ->get('pesanan')->row()->status;

        // jika sudah diproses maka return FALSE
        // agar tidak bisa dihapus
        if ($status_pesanan == 1) {
            return FALSE;
        }

        // start transaction
        $this->db->trans_start();

        // get semua data detail pesanan berdasarkan id_pesanan
        $rows = $this->db
            ->where('id_pesanan', $id_pesanan)
            ->get('detail_pesanan')->result_object();

        // qty detail_produk di kembalikan
        foreach ($rows as $row) {
            // tambah/update qty pada detail_produk
            $this->db
                ->set('qty', "qty+$row->qty", FALSE)
                ->where('id_detail_produk', $row->id_detail_produk)
                ->update('detail_produk');
        }

        // delete detail_pesanan dahulu
        $this->db
            ->where('id_pesanan', $id_pesanan)
            ->delete($this->table);

        // kemudian delete pesanan
        $this->db
            ->where('id_pesanan', $id_pesanan)
            ->delete('pesanan');



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

/* End of file DetailPesanan_model.php */