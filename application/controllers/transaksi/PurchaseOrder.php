<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseOrder extends CI_Controller 
{
    public function index()
    {
        $this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('transaksi/purchase-order/index');
		$this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->load->view('templates/header');
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('transaksi/purchase-order/tambah');
		$this->load->view('templates/footer');
    }

}

/* End of file PurchaseOrder.php */

?>