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
}

/* End of file DetailPesanan_model.php */