<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pesanan_model extends CI_Model
{

    public $table = 'pesanan';
    public $id = 'id_pesanan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function jsoan()
    {
        $this->datatables->select(
            '
            p.id_produk,
            p.nama_produk,
            p.image,
            k.nama_kategori,
            SUM(dp.qty) as stok
            '
        );
        $this->datatables->from('produk p');
        //this line for join
        $this->datatables->join('kategori k', 'p.id_kategori = k.id_kategori');
        $this->datatables->join('detail_produk dp', 'p.id_produk = dp.id_produk', 'left');
        $this->datatables->group_by('p.id_produk');
        // row action

        // jika role cs maka btn edit dan hapus dihilangkan
        if ($this->session->userdata('role') == 'cs') {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('master/Produk/read/$1') .
                    form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . '</div>',
                'id_produk'
            );
        } else {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('master/Produk/update/$1') .
                    form_button(['type' => 'submit', 'title' => 'Edit', 'class' => 'btn btn-warning', 'content' => '<i class="fas fa-pencil-alt"> </i>']) .
                    form_close() . "&nbsp;" .
                    form_open('master/Produk/delete/$1') .
                    form_button(['type' => 'submit', 'title' => 'Hapus', 'class' => 'btn btn-danger'], '<i class="fas fa-trash-alt"> </i>', 'onclick="javascript: return confirm(\'Yakin ingin hapus ?\')"') .
                    form_close() . '</div>',
                'id_produk'
            );
        }

        return $this->datatables->generate();
    }

    // datatables
    function json()
    {
        $this->datatables->select(
            '
            id_pesanan,
            p.nama_pengirim,
            k.nama_kurir,
            mp.nama_metodePembayaran,
            status,
            penerima,
            alamat,
            no_telp,
            tgl_pesanan,
            keterangan
            '
        );

        $this->datatables->from('pesanan pes');
        //add this line for join
        $this->datatables->join('pengirim p', 'pes.id_pengirim = p.id_pengirim');
        $this->datatables->join('kurir k', 'pes.id_kurir = k.id_kurir');
        $this->datatables->join('metodepembayaran mp', 'pes.id_metodePembayaran = mp.id_metodePembayaran');
        // jika ada tanggal dari dan sampai
        $dari = $this->input->post('dari', TRUE);
        $sampai = $this->input->post('sampai', TRUE);
        // jika ada kiriman parameter
        if (isset($dari) && isset($sampai)) {
            $this->datatables->where('tgl_pesanan>=', $dari . ' 00:00:00');
            $this->datatables->where('tgl_pesanan <=', $sampai . ' 23:59:59');
        }
        // jika role cs maka btn edit dan hapus dihilangkan
        if ($this->session->userdata('role') == 'cs') {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/Pesanan/read', '', array('id_pesanan' => '$1')) .
                    form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . '</div>',
                'id_pesanan'
            );
        } else {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/Pesanan/read', '', array('id_pesanan' => '$1')) .
                    form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . "&nbsp;" .
                    form_open('transaksi/Pesanan/delete') .
                    form_button(['type' => 'submit', 'title' => 'Hapus', 'data-id' => '$1', 'class' => 'btn btn-danger hapusPesanan'], '<i class="fas fa-trash-alt"> </i>') .
                    form_close() . '</div>',
                'id_pesanan'
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

        // 1. insert ke pesanan
        $this->db->insert($this->table, $data);

        // 2. get id pesanan yang baru di insert
        $last_id_pesanan = $this->db->insert_id();

        // get semua data berdasarkan pengguna pada keranjang
        $rows = $this->db
            ->where('id_pengguna', $data['id_pengguna'])
            ->get('keranjang')->result_object();

        // 3. insert ke detail_pesanan dengan isi id_pesanan yg baru di insert
        // looping insert detail_pesanan dan update qty detail_produk
        foreach ($rows as $row) {
            $this->db->insert('detail_pesanan', [
                'id_pesanan'       => $last_id_pesanan,
                'id_detail_produk' => $row->id_detail_produk,
                'qty'              => $row->qty,
                'sub_total'        => $row->sub_total
            ]);

            // update qty pada detail_produk
            $this->db
                ->set('qty', "qty-$row->qty", FALSE)
                ->where('id_detail_produk', $row->id_detail_produk)
                ->update('detail_produk');
        }
        // end looping

        // 4. delete keranjang berdasarkan id_pengguna
        $this->db
            ->where('id_pengguna', $data['id_pengguna'])
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

    // get data by id
    function get_by_id($id)
    {
        return $this->db
            ->select('
            id_pesanan,
            p.nama_pengirim,
            k.nama_kurir,
            pengguna.nama_pengguna,
            mp.nama_metodePembayaran,
            status,
            penerima,
            alamat,
            no_telp,
            tgl_pesanan,
            ongkir,
            keterangan
        ')
            ->from($this->table . ' pes')
            ->join('pengirim p', 'pes.id_pengirim = p.id_pengirim')
            ->join('kurir k', 'pes.id_kurir = k.id_kurir')
            ->join('metodepembayaran mp', 'pes.id_metodePembayaran = mp.id_metodePembayaran')
            ->join('pengguna', 'pes.id_pengguna = pengguna.id_pengguna')
            ->where($this->id, $id)
            ->get()
            ->row();
    }

    function updateStatus($id_pesanan)
    {
        // start transaction
        $this->db->trans_start();
        $this->db->set('status', 1)
            ->where($this->id, $id_pesanan)
            ->update($this->table);
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


    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file Pesanan_model.php */