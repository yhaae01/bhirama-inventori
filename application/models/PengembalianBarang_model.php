<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PengembalianBarang_model extends CI_Model
{

    public $table = 'pengembalian_barang';
    public $id    = 'id_pengembalian_barang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select(
            '
            pengbar.id_pengembalian_barang,
            pengbar.status,
            pengbar.tgl_pengembalian,
            pengbar.keterangan,
            pes.penerima,
            pes.id_pesanan,
            peng.nama_pengguna
            '
        );

        $this->datatables->from('pengembalian_barang pengbar');
        //add this line for join
        $this->datatables->join('pesanan pes', 'pes.id_pesanan = pengbar.id_pesanan');
        $this->datatables->join('pengguna peng', 'peng.id_pengguna = pengbar.id_pengguna');
        // jika ada tanggal dari dan sampai
        $dari   = $this->input->post('dari', TRUE);
        $sampai = $this->input->post('sampai', TRUE);
        // jika ada kiriman parameter
        if (isset($dari) && isset($sampai)) {
            $this->datatables->where('tgl_pengembalian>=', $dari . ' 00:00:00');
            $this->datatables->where('tgl_pengembalian <=', $sampai . ' 23:59:59');
        }
        // jika role cs maka btn edit dan hapus dihilangkan
        if ($this->session->userdata('role') == 'cs') {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/Pesanan/read', '', array('id_pengembalian_barang' => '$1')) .
                    form_button(['type' => 'submit', 'data-id' => '$1', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . '</div>',
                'id_pengembalian_barang'
            );
        } else {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/Pesanan/read', '', array('id_pengembalian_barang' => '$1')) .
                    form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . "&nbsp;" .
                    form_open('transaksi/Pesanan/delete', array('class' => 'formHapus')) .
                    form_button(['type' => 'submit', 'title' => 'Hapus', 'data-id' => '$1', 'class' => 'btn btn-danger hapusPesanan'], '<i class="fas fa-trash-alt"> </i>') .
                    form_close() . '</div>',
                'id_pengembalian_barang'
            );
        }
        return $this->datatables->generate();
    }


    // insert data
    function insert($data)
    {
        // start transaction
        $this->db->trans_start();
        // $this->db->insert($this->table, $data);

        // 1. insert ke pengembalian_barang
        $this->db->insert($this->table, $data);

        // 2. get id pengembalian_barang yang baru di insert
        $last_id_pengembalian_barang = $this->db->insert_id();

        // get semua data berdasarkan pengguna dan jenis pada keranjang
        $rows = $this->db
            ->where('id_pengguna', $data['id_pengguna'])
            ->where('jenis', 'pengembalian_barang')
            ->get('keranjang')->result_object();

        // 3. insert ke detail_pesanan dengan isi id_pesanan yg baru di insert
        // looping insert detail_pesanan dan update qty detail_produk
        foreach ($rows as $row) {
            $this->db->insert('detail_pengembalian_barang', [
                'id_pengembalian_barang' => $last_id_pengembalian_barang,
                'id_detail_produk'       => $row->id_detail_produk,
                'qty'                    => $row->qty
            ]);
        }
        // end looping

        // 4. delete keranjang berdasarkan id_pengguna
        $this->db
            ->where('id_pengguna', $data['id_pengguna'])
            ->where('jenis', 'pengembalian_barang')
            ->delete('keranjang');



        // end transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Something went wrong
            $this->db->trans_rollback(); //rollback
        } else {
            // Committing data to the database.
            $this->db->trans_commit();
            return "success";
        }
    }
}

/* End of file Pesanan_model.php */