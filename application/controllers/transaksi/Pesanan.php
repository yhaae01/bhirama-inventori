<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model', 'pengguna');
        $this->load->model('Pesanan_model', 'pesanan');
        cek_login();
    }

    public function index()
    {
        $data['title'] = 'Pesanan';
        $data['user']  = $this->pengguna->cekPengguna();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/pesanan/index');
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title']    = 'Tambah Pesanan';
        $data['user']     = $this->pengguna->cekPengguna();
        $data['provinsi'] = $this->pesanan->getProv();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('transaksi/pesanan/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function getKab($id_prov)
	{
        $kab = $this->pesanan->getKab($id_prov);
        echo"<option value=''>Pilih Kota/Kab</option>";
        foreach($kab as $k){
            echo "<option value='{$k->id_kab}'>{$k->nama}</option>";
        }
	}
	
	public function getKec($id_kab)
	{
        $kec = $this->pesanan->getKec($id_kab);
        echo"<option value=''>Pilih Kecamatan</option>";
        foreach($kec as $k){
            echo "<option value='{$k->id_kec}'>{$k->nama}</option>";
        }
    }

    public function getKel($id_kec)
	{
        $kel = $this->pesanan->getKel($id_kec);
        echo"<option value=''>Pilih Kelurahan/Desa</option>";
        foreach($kel as $k){
            echo "<option value='{$k->id_kel}'>{$k->nama}</option>";
        }
	}	
}

/* End of file Pesanan.php */
