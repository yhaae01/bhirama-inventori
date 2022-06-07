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
}
