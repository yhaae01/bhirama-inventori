<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangMasuk extends CI_Controller 
{
    public function index()
    {
        $this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('transaksi/barang-masuk/index');
		$this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('transaksi/barang-masuk/tambah');
		$this->load->view('templates/footer');
    }

}

/* End of file BarangMasuk.php */

?>