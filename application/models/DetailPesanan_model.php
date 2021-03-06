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
    function get_qty_by_id_pesanan_id_detail_produk($id_pesanan, $id_detail_produk)
    {
        return $this->db
            ->select('qty')
            ->where('id_pesanan', $id_pesanan)
            ->where('id_detail_produk', $id_detail_produk)
            ->get('detail_pesanan')->row()->qty;
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

    // get total Qty untuk dashboard
    public function getTotalQty()
    {
        // set timezone
        date_default_timezone_set("Asia/Bangkok");

        $today = date('Y-m-d');
        // ambil id_pesanan hari ini
        $id_pesanan = $this->db
            ->select('id_pesanan')
            ->where('tgl_pesanan>=', $today . ' 00:00:00')
            ->where('tgl_pesanan <=', $today . ' 23:59:59')
            ->where('status', '1')
            ->get('pesanan')
            ->result();

        // inisialisasi awal
        $qty = 0;
        $detail_pesanan = array();

        // looping detail pesanan by id_pesanan
        foreach ($id_pesanan as $row) {
            $detail_pesanan[] = $this->db->select_sum('qty')
                ->where('id_pesanan', $row->id_pesanan)
                ->get('detail_pesanan')
                ->row();
        }
        foreach ($detail_pesanan as $totalQty) {
            $qty = $qty + $totalQty->qty;
        }
        return $qty;
    }
}

/* End of file DetailPesanan_model.php */