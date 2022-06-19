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
    function json_pesanan()
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
        $this->datatables->where('jenis', 'pesanan');
        // action
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('transaksi/DetailPesanan/deleteKeranjang') .
                form_button(['type' => 'submit', 'data-id' => '$1', 'title' => 'Hapus', 'class' => 'btn btn-danger hapusDetailPesanan'], '<i class="fas fa-trash-alt"> </i>') .
                form_close() . '</div>',
            'id'
        );


        return $this->datatables->generate();
    }
    // datatables
    function json_pengembalian_barang()
    {
        $this->datatables->select(
            '
            id,
            nama_pengguna,
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
        $this->datatables->where('jenis', 'pengembalian_barang');
        // action
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('transaksi/DetailPengembalianBarang/deleteKeranjang') .
                form_button(['type' => 'submit', 'data-id' => '$1', 'title' => 'Hapus', 'class' => 'btn btn-danger hapusDetailPengembalian'], '<i class="fas fa-trash-alt"> </i>') .
                form_close() . '</div>',
            'id'
        );
        return $this->datatables->generate();
    }

    // get produk dengan id_detail_produk, id_pengguna dan harga yg sama
    function get_same_varian($idDetailProduk, $idPengguna, $jenis)
    {
        return $this->db
            ->where("id_detail_produk", $idDetailProduk)
            ->where("id_pengguna", $idPengguna)
            ->where("sub_total >", "0")
            ->where('jenis', $jenis)
            ->order_by('id', 'ASC')
            ->count_all_results($this->table);
    }
    // get produk dengan id_detail_produk, id_pengguna dan harga yg sama
    function get_same_varian_pengembalian($idDetailProduk, $idPengguna, $jenis)
    {
        return $this->db
            ->where("id_detail_produk", $idDetailProduk)
            ->where("id_pengguna", $idPengguna)
            ->where('jenis', $jenis)
            ->order_by('id', 'ASC')
            ->count_all_results($this->table);
    }

    function get_id_keranjang_pengembalian($id_detail_produk, $id_pengguna, $jenis)
    {
        return $this->db
            ->select('id')
            ->where('id_detail_produk', $id_detail_produk)
            ->where('id_pengguna', $id_pengguna)
            ->where('jenis', $jenis)
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->row_array()['id'];
    }

    // get produk dengan id_detail_produk, id_pengguna dan harga yg sama [BONUS]
    function get_same_varian_bonus($idDetailProduk, $idPengguna, $jenis)
    {
        return $this->db
            ->where("id_detail_produk", $idDetailProduk)
            ->where("id_pengguna", $idPengguna)
            ->where("sub_total", "0")
            ->where('jenis', $jenis)
            ->order_by('id', 'ASC')
            ->count_all_results($this->table);
    }

    function get_id_detail_produk($idProduk, $idWarna, $idUkuran)
    {
        $this->load->model('DetailProduk_model', 'DetailProduk');
        return $this->DetailProduk->get_id_from_varian($idProduk, $idWarna, $idUkuran);
    }

    function get_id_keranjang($id_detail_produk, $id_pengguna, $jenis)
    {
        return $this->db
            ->select('id')
            ->where('id_detail_produk', $id_detail_produk)
            ->where('id_pengguna', $id_pengguna)
            ->where('sub_total >', '0')
            ->where('jenis', $jenis)
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->row_array()['id'];
    }

    function get_id_keranjang_bonus($id_detail_produk, $id_pengguna, $jenis)
    {
        return $this->db
            ->select('id')
            ->where('id_detail_produk', $id_detail_produk)
            ->where('id_pengguna', $id_pengguna)
            ->where('sub_total', '0')
            ->where('jenis', $jenis)
            ->order_by('id', 'ASC')
            ->get($this->table)
            ->row_array()['id'];
    }

    // get total qty tersedia berdasarkan id__detail_produk
    function getQty($id_detail_produk, $jenis)
    {
        $qty = $this->db
            ->select('sum(qty) as qty')
            ->where('id_detail_produk', $id_detail_produk)
            ->where('jenis', $jenis)
            ->get($this->table)
            ->row_array()['qty'];

        if (empty($qty)) {
            return 0;
        } else {
            return $qty;
        }
    }

    // insert data calon pesanan
    function insert_pesanan($data)
    {
        $id_detail_produk = $data['id_detail_produk'];
        $id_pengguna      = $data['id_pengguna'];
        $qty              = $data['qty'];
        $sub_total        = $data['sub_total'];
        $jenis            = $data['jenis'];

        // start transaction
        $this->db->trans_start();
        // jika harga nol maka buat insert baru
        if ($sub_total == 0) {
            // cek apakah sebelumnya ada varian bonus yg sama
            // jika ada, cukup update qty saja
            if ($this->get_same_varian_bonus($id_detail_produk, $id_pengguna, $jenis) > 0) {
                $id = $this->get_id_keranjang_bonus($id_detail_produk, $id_pengguna, $jenis);
                // tambah qty
                $this->db
                    ->set('qty', "qty+$qty", FALSE)
                    ->where($this->id, $id)
                    ->where('jenis', $jenis)
                    ->update($this->table);
            } else {
                // jika tidak, maka insert saja
                $this->db->insert($this->table, $data);
            }
        } else if ($this->get_same_varian($id_detail_produk, $id_pengguna, $jenis) > 0 && $sub_total > 0) {

            // ambil id dari tabel keranjang
            $id = $this->get_id_keranjang($id_detail_produk, $id_pengguna, $jenis);
            // tambah qty dan tambah harga
            $this->db
                ->set('sub_total', "sub_total+$sub_total", FALSE)
                ->set('qty', "qty+$qty", FALSE)
                ->where($this->id, $id)
                ->where('jenis', $jenis)
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
    // insert data calon pesanan
    function insert_pengembalian($data)
    {
        $id_detail_produk = $data['id_detail_produk'];
        $id_pengguna      = $data['id_pengguna'];
        $qty              = $data['qty'];
        $jenis            = $data['jenis'];
        $sub_total        = $data['sub_total'];

        // start transaction
        $this->db->trans_start();
        if ($this->get_same_varian_pengembalian($id_detail_produk, $id_pengguna, $jenis) > 0) {

            // ambil id dari tabel keranjang
            $id = $this->get_id_keranjang_pengembalian($id_detail_produk, $id_pengguna, $jenis);
            // tambah qty dan tambah harga
            $this->db
                ->set('qty', "qty+$qty", FALSE)
                ->where($this->id, $id)
                ->where('jenis', $jenis)
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


    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        return "TRUE";
    }
}
