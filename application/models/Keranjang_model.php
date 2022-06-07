<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Keranjang_model extends CI_Model
{

    public $table = 'keranjang';
    public $id    = 'id';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select(
            '
            id,
            nama_pengguna,
            sub_total,
            k.qty,
            produk.nama_produk,
            w.nama_warna,
            u.nama_ukuran,
            '
        );
        $this->datatables->from('keranjang k');
        //this line for join
        $this->datatables->join('detail_produk dp', 'k.id_detail_produk = dp.id_detail_produk');
        $this->datatables->join('pengguna p', 'k.id_pengguna = p.id_pengguna');
        $this->datatables->join('produk', 'dp.id_produk = produk.id_produk');
        $this->datatables->join('warna w', 'dp.id_warna = w.id_warna');
        $this->datatables->join('ukuran u', 'dp.id_ukuran = u.id_ukuran');
        // action
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('master/Keranjang/delete') .
                form_button(['type' => 'submit', 'data-id' => '$1', 'title' => 'Hapus', 'class' => 'btn btn-danger hapusDP'], '<i class="fas fa-trash-alt"> </i>') .
                form_close() . '</div>',
            'id'
        );


        return $this->datatables->generate();
    }

    // get produk dengan id_detail_produk, id_pengguna dan harga yg sama
    function get_same_varian($idDetailProduk, $idPengguna, $harga)
    {
        return $this->db
            ->where("id_detail_produk", $idDetailProduk)
            ->where("id_pengguna", $idPengguna)
            ->where("sub_total", $harga)
            ->count_all_results($this->table);
    }

    function get_id_detail_produk($idProduk, $idWarna, $idUkuran)
    {
        $this->load->model('DetailProduk_model', 'DetailProduk');
        return $this->DetailProduk->get_id_from_varian($idProduk, $idWarna, $idUkuran);
    }

    function get_id_keranjang($id_detail_produk, $id_pengguna)
    {
        return $this->db
            ->select('id')
            ->where('id_detail_produk', $id_detail_produk)
            ->where('id_pengguna', $id_pengguna)
            ->get($this->table)
            ->row_array()['id'];
    }

    // insert data
    function insert($data)
    {
        $id_detail_produk = $data['id_detail_produk'];
        $id_pengguna      = $data['id_pengguna'];
        $qty              = $data['qty'];
        $sub_total        = $data['sub_total'];

        // start transaction
        $this->db->trans_start();
        // ambil id_detail_produk
        // jika sudah ada id_detail_produk, id_pengguna dan harga yg sama
        if ($this->get_same_varian($id_detail_produk, $id_pengguna, $sub_total) == 1) {

            // ambil id dari tabel keranjang
            $id = $this->get_id_keranjang($id_detail_produk, $id_pengguna);
            // tambah qty dan tambah harga
            $this->db
                ->set('sub_total', "sub_total+$sub_total", FALSE)
                ->set('qty', "qty+$qty", FALSE)
                ->where($this->id, $id)
                ->update($this->table);
        } else {
            $this->db->insert($this->table, $data);
        }


        // end transaction
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            // Something went wrong
            $this->db->trans_rollback(); //rollback
            return FALSE;
        } else {
            // Committing data to the database.
            $this->db->trans_commit();
            return "TRUE";
        }
    }
}
