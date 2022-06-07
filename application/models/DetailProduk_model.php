<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailProduk_model extends CI_Model
{

    public $table = 'detail_produk';
    public $id    = 'id_detail_produk';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($id)
    {
        $this->datatables->where("p.id_produk", $id);
        $this->datatables->select(
            '
            dp.id_detail_produk,
            dp.qty,
            dp.harga,
            w.nama_warna,
            u.nama_ukuran
            '
        );
        $this->datatables->from('detail_produk dp');
        //this line for join
        $this->datatables->join('produk p', 'dp.id_produk = p.id_produk');
        $this->datatables->join('warna w', 'dp.id_warna = w.id_warna');
        $this->datatables->join('ukuran u', 'dp.id_ukuran = u.id_ukuran');
        // action
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('master/DetailProduk/delete') .
                form_button(['type' => 'submit', 'data-id' => '$1', 'title' => 'Hapus', 'class' => 'btn btn-danger hapusDP'], '<i class="fas fa-trash-alt"> </i>') .
                form_close() . '</div>',
            'id_detail_produk'
        );


        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        return $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get produk by id
    function get_produk_by_id($id)
    {
        return $this->db->where("id_produk", $id)->count_all_results($this->table);
    }

    // get produk dengan id_produk, id_warna, id_ukuran yg sama
    function get_same_varian($idProduk, $idWarna, $idUkuran)
    {
        return $this->db
            ->where("id_produk", $idProduk)
            ->where("id_warna", $idWarna)
            ->where("id_ukuran", $idUkuran)
            ->count_all_results($this->table);
    }

    function get_id_from_varian($idProduk, $idWarna, $idUkuran)
    {
        return $this->db
            ->select('id_detail_produk')
            ->where('id_produk', $idProduk)
            ->where('id_warna', $idWarna)
            ->where('id_ukuran', $idUkuran)
            ->get($this->table)
            ->row_array()['id_detail_produk'];
    }


    // insert data
    function insert($data)
    {
        $id_produk = $data['id_produk'];
        $id_warna  = $data['id_warna'];
        $id_ukuran = $data['id_ukuran'];
        $qty       = $data['qty'];
        $harga     = $data['harga'];

        // start transaction
        $this->db->trans_start();
        // jika sudah ada warna dan ukuran yg sama
        // maka tambah qty nya saja
        if ($this->get_same_varian($id_produk, $id_warna, $id_ukuran) == 1) {

            // ambil id_detail_produk
            $id_detail_produk = $this->get_id_from_varian($id_produk, $id_warna, $id_ukuran);

            // tambah qty dan update harga
            $this->db
                ->set('harga', $harga, FALSE)
                ->set('qty', "qty+$qty", FALSE)
                ->where($this->id, $id_detail_produk)
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
            return "success";
        }
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // tambah qty
    function tambahQty($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // get qty dan harga tersedia berdasarkan id_produk, id_warna dan id_ukuran
    function getQtyHarga($id_produk, $id_warna, $id_ukuran)
    {
        return $this->db
            ->select("$this->table.qty, $this->table.harga")
            ->where('id_produk', $id_produk)
            ->where('id_warna', $id_warna)
            ->where('id_ukuran', $id_ukuran)
            ->get($this->table)
            ->first_row();
    }

    // get Warna berdasarkan produk
    function getWarna($id_produk)
    {
        return $this->db
            ->select('w.id_warna as id, w.nama_warna as text')
            ->from('detail_produk dp')
            ->join('warna w', 'dp.id_warna = w.id_warna')
            ->where('dp.id_produk', $id_produk)
            ->group_by('w.id_warna')
            ->get()
            ->result();
    }

    // get Ukuran berdasarkan produk dan warna
    function getUkuran($id_produk, $id_warna)
    {
        return $this->db
            ->select('u.id_ukuran as id, u.nama_ukuran as text')
            ->from('detail_produk dp')
            ->join('ukuran u', 'dp.id_ukuran = u.id_ukuran')
            ->where('dp.id_produk', $id_produk)
            ->where('dp.id_warna', $id_warna)
            ->group_by('u.id_ukuran')
            ->get()
            ->result();
    }


    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file Produk_model.php */