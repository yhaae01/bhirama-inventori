<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ReturBarang_model extends CI_Model
{

    public $table = 'retur_barang';
    public $id    = 'id_retur_barang';
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
            rb.id_retur_barang,
            rb.status,
            DATE_FORMAT(rb.tgl_retur,"%d-%m-%Y, %H:%i") as tgl_retur,
            rb.keterangan,
            s.nama_supplier,
            bm.id_barang_masuk,
            peng.nama_pengguna
            '
        );

        $this->datatables->from('retur_barang rb');
        //add this line for join
        $this->datatables->join(
            'barang_masuk bm',
            'bm.id_barang_masuk = rb.id_barang_masuk'
        );
        $this->datatables->join(
            'supplier s',
            's.id_supplier = bm.id_supplier'
        );
        $this->datatables->join(
            'pengguna peng',
            'peng.id_pengguna = rb.id_pengguna'
        );
        // jika ada tanggal dari dan sampai
        $dari   = $this->input->post('dari', TRUE);
        $sampai = $this->input->post('sampai', TRUE);
        // jika ada kiriman parameter
        if (isset($dari) && isset($sampai)) {
            $this->datatables->where('tgl_retur>=', $dari . ' 00:00:00');
            $this->datatables->where('tgl_retur <=', $sampai . ' 23:59:59');
        }
        // jika role cs 
        if ($this->session->userdata('role') == 'cs') {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/ReturBarang/read', '', array('id_retur_barang' => '$1')) .
                    form_button(['type' => 'submit', 'data-id' => '$1', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . '</div>',
                'id_retur_barang'
            );
        } else {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/ReturBarang/read', '', array('id_retur_barang' => '$1')) .
                    form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . "&nbsp;" .
                    form_open('transaksi/ReturBarang/delete', array('class' => 'formHapus')) .
                    form_button(['type' => 'submit', 'title' => 'Hapus', 'data-id' => '$1', 'class' => 'btn btn-danger hapusRetur'], '<i class="fas fa-trash-alt"> </i>') .
                    form_close() . '</div>',
                'id_retur_barang'
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

        // 1. insert ke retur_barang
        $this->db->insert($this->table, $data);

        // 2. get id retur_barang yang baru di insert
        $last_id_retur_barang = $this->db->insert_id();

        // get semua data berdasarkan pengguna dan jenis pada keranjang
        $rows = $this->db
            ->where('id_pengguna', $data['id_pengguna'])
            ->where('jenis', 'retur_barang')
            ->get('keranjang')->result_object();

        // 3. insert ke detail_retur_barang dengan isi id_retur_barang yg baru di insert
        // looping insert detail_retur_barang
        foreach ($rows as $row) {
            $this->db->insert('detail_retur_barang', [
                'id_retur_barang' => $last_id_retur_barang,
                'id_detail_produk'       => $row->id_detail_produk,
                'qty'                    => $row->qty
            ]);
        }
        // end looping

        // 4. delete keranjang berdasarkan id_pengguna
        $this->db
            ->where('id_pengguna', $data['id_pengguna'])
            ->where('jenis', 'retur_barang')
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

    function get_by_id($id)
    {
        return $this->db
            ->select('
            rb.id_retur_barang,
            rb.id_barang_masuk,
            rb.tgl_retur,
            rb.status,
            rb.keterangan,
            s.nama_supplier,
            p.nama_pengguna
        ')
            ->from($this->table . ' rb')
            ->join(
                'barang_masuk bm',
                'bm.id_barang_masuk = rb.id_barang_masuk'
            )
            ->join(
                'supplier s',
                's.id_supplier = bm.id_supplier'
            )
            ->join(
                'pengguna p',
                'p.id_pengguna = rb.id_pengguna'
            )
            ->where($this->id, $id)
            ->get()
            ->row();
    }

    function updateStatus($id_retur)
    {
        // start transaction
        $this->db->trans_start();

        $items = $this->db
            ->where('id_retur_barang', $id_retur)
            ->get('detail_retur_barang')->result_object();

        // kembalikan qty pada detail_produk
        foreach ($items as $item) {
            $this->db->set('qty', "qty-$item->qty", FALSE)
                ->where('id_detail_produk', $item->id_detail_produk)
                ->update('detail_produk');
        }

        // ubah status
        $this->db->set('status', '1')
            ->where($this->id, $id_retur)
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


    // get total retur untuk dashboard
    public function getTotalRetur()
    {
        // set timezone
        date_default_timezone_set("Asia/Bangkok");

        $today = date('Y-m-d');

        // ambil id_retur hari ini
        $total_retur = $this->db
            ->select('count(id_retur_barang) as retur')
            ->where('tgl_retur>=', $today . ' 00:00:00')
            ->where('tgl_retur <=', $today . ' 23:59:59')
            ->where('status', '1')
            ->get('retur_barang')
            ->row()->retur;

        return $total_retur;
    }
}

/* End of file ReturBarang_model.php */