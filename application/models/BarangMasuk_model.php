<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BarangMasuk_model extends CI_Model
{

    public $table = 'barang_masuk';
    public $id    = 'id_barang_masuk';
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
            id_barang_masuk,
            DATE_FORMAT(tgl_barang_masuk,"%d-%m-%Y, %H:%i") as tgl_barang_masuk,
            s.nama_supplier,
            peng.nama_pengguna
            '
        );

        $this->datatables->from('barang_masuk bm');
        //add this line for join
        $this->datatables->join('supplier s', 'bm.id_supplier = s.id_supplier');
        $this->datatables->join('pengguna peng', 'bm.id_pengguna = peng.id_pengguna');
        // jika ada tanggal dari dan sampai
        $dari   = $this->input->post('dari', TRUE);
        $sampai = $this->input->post('sampai', TRUE);
        // jika ada kiriman parameter
        if (isset($dari) && isset($sampai)) {
            $this->datatables->where('tgl_barang_masuk >=', $dari . ' 00:00:00');
            $this->datatables->where('tgl_barang_masuk <=', $sampai . ' 23:59:59');
        }
        // jika role cs maka btn edit dan hapus dihilangkan
        if ($this->session->userdata('role') == 'cs') {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/BarangMasuk/read', '', array('id_barang_masuk' => '$1')) .
                    form_button(['type' => 'submit', 'data-id' => '$1', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close() . '</div>',
                'id_barang_masuk'
            );
        } else {
            $this->datatables->add_column(
                'action',
                '<div class="btn-group">' .
                    form_open('transaksi/BarangMasuk/read', '', array('id_barang_masuk' => '$1')) .
                    form_button(['type' => 'submit', 'title' => 'Detail', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-info-circle"> </i>']) .
                    form_close()  . '</div>',
                'id_barang_masuk'
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

        // 1. insert ke barang_masuk
        $this->db->insert($this->table, $data);

        // 2. get id barang_masuk yang baru di insert
        $last_id_barang_masuk = $this->db->insert_id();

        // get semua data berdasarkan pengguna pada keranjang
        $rows = $this->db
            ->where('id_pengguna', $data['id_pengguna'])
            ->where('jenis', 'barang_masuk')
            ->get('keranjang')->result_object();

        // 3. insert ke detail_barang_masuk dengan isi id_barang_masuk yg baru di insert
        // looping insert detail_barang_masuk dan update qty detail_produk
        foreach ($rows as $row) {
            $this->db->insert('detail_barang_masuk', [
                'id_barang_masuk'  => $last_id_barang_masuk,
                'id_detail_produk' => $row->id_detail_produk,
                'qty'              => $row->qty,
            ]);

            // update qty pada detail_produk
            $this->db
                ->set('qty', "qty+$row->qty", FALSE)
                ->set('harga', "$row->sub_total", FALSE)
                ->set('berat', "$row->berat", FALSE)
                ->where('id_detail_produk', $row->id_detail_produk)
                ->update('detail_produk');
        }
        // end looping

        // 4. delete keranjang berdasarkan id_pengguna dan jenis = barang_masuk
        $this->db
            ->where('id_pengguna', $data['id_pengguna'])
            ->where('jenis', 'barang_masuk')
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
            bm.id_barang_masuk,
            DATE_FORMAT(tgl_barang_masuk,"%d-%m-%Y, %H:%i") as tgl_barang_masuk,
            s.nama_supplier,
            s.no_telp,
            p.nama_pengguna
        ')
            ->from($this->table . ' bm')
            ->join(
                'supplier s',
                'bm.id_supplier = s.id_supplier'
            )
            ->join(
                'pengguna p',
                'bm.id_pengguna = p.id_pengguna'
            )
            ->where($this->id, $id)
            ->get()
            ->row();
    }

    // get total barang_masuk untuk dashboard
    public function getTotalBarangMasuk()
    {
        // set timezone
        date_default_timezone_set("Asia/Bangkok");

        $today = date('Y-m-d');
        // ambil id_barang_masuk hari ini
        $total_barang_masuk = $this->db
            ->select('count(id_barang_masuk) as barang_masuk')
            ->where('tgl_barang_masuk>=', $today . ' 00:00:00')
            ->where('tgl_barang_masuk <=', $today . ' 23:59:59')
            ->get('barang_masuk')
            ->row()->barang_masuk;

        return $total_barang_masuk;
    }
}

/* End of file BarangMasuk_model.php */