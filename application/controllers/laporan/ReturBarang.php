<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class ReturBarang extends CI_Controller 
{
    public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('laporan/retur-barang');
		$this->load->view('templates/footer');
	}
}

/* End of file ReturBarang.php */

?>