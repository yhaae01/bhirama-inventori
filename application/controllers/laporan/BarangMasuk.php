<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasuk extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pengguna_model', 'pengguna');
		cek_login();
		cek_gudang();
		cek_cs();
	}

	public function index()
	{
		$data['title'] = 'Laporan Barang Masuk';
		$data['user'] = $this->pengguna->cekPengguna();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('laporan/barang-masuk/barangmasuk_list');
		$this->load->view('templates/footer');
		$this->load->view('laporan/barang-masuk/barangmasuk_js');
	}

	public function exportPDF()
	{
		// load library FPDF yang diwakili oleh class Pdf
		$this->load->library('Pdf');
		$dari      = $this->input->post('dariTgl', TRUE);
		$sampai    = $this->input->post('sampaiTgl', TRUE);
		$tglDari   = date_format(date_create($dari), "d-m-Y");
		$tglSampai = date_format(date_create($sampai), "d-m-Y");


		$pdf = new FPDF();
		$pdf->AddPage();
		// Judul
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(0, 10, 'LAPORAN BARANG MASUK', 0, 1, 'C');
		$pdf->Cell(0, 10, $tglDari . " s/d " . $tglSampai, 0, 1, 'C');
		$pdf->Cell(10, 6, '', 0, 1, 'C');
		// -----------------------------------------------------

		// heading
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Admin', 1, 0, 'C');
		$pdf->Cell(30, 6, 'ID', 1, 0, 'C');
		$pdf->Cell(25, 6, 'Tanggal', 1, 0, 'C');
		$pdf->Cell(35, 6, 'Supplier', 1, 0, 'C');
		$pdf->Cell(45, 6, 'Item(s)', 1, 0, 'C');
		$pdf->Cell(15, 6, 'Qty', 1, 1, 'C');
		// -----------------------------------------------------

		// isi
		$pdf->SetFont('Arial', '', 10);
		$barang_masuk = $this->db
			->where('tgl_barang_masuk>=', $dari . ' 00:00:00')
			->where('tgl_barang_masuk <=', $sampai . ' 23:59:59')
			->from('barang_masuk bm')
			->join(
				'pengguna p',
				'p.id_pengguna = bm.id_pengguna'
			)
			->join(
				'supplier s',
				's.id_supplier = bm.id_supplier'
			)
			->group_by('bm.id_barang_masuk')
			->get()->result();
		$no = 0;
		foreach ($barang_masuk as $data) {
			$items = $this->db
				->select('
            			dbm.id_detail_produk,
            			produk.nama_produk,
            			warna.nama_warna,
            			ukuran.nama_ukuran,
            			dbm.qty
            	')
				->where('dbm.id_barang_masuk', $data->id_barang_masuk)
				->join(
					'detail_produk',
					'detail_produk.id_detail_produk = dbm.id_detail_produk'
				)
				->join(
					'produk',
					'detail_produk.id_produk = produk.id_produk'
				)
				->join(
					'barang_masuk bm',
					'dbm.id_barang_masuk = bm.id_barang_masuk'
				)
				->join(
					'ukuran',
					'detail_produk.id_ukuran = ukuran.id_ukuran'
				)
				->join(
					'warna',
					'detail_produk.id_warna = warna.id_warna'
				)
				->get('detail_barang_masuk dbm')
				->result();
			$no++;
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(30, 6, $data->nama_pengguna, 1, 0);
			$pdf->Cell(30, 6, $data->id_barang_masuk, 1, 0, 'C');
			$date = date_create($data->tgl_barang_masuk);
			$pdf->Cell(25, 6, date_format($date, "d-m-Y"), 1, 0, 'C');
			$pdf->Cell(35, 6, ucfirst($data->nama_supplier), 1, 0);
			$i = 0;
			foreach ($items as $item) {
				$i++;
				if ($i == 1) {
					$pdf->Cell(45, 6, $item->nama_produk . '/' . $item->nama_warna . '/' . $item->nama_ukuran, 1, 0, 'L');
					$pdf->Cell(15, 6, $item->qty, 1, 1, 'R');
				} else {
					$pdf->Cell(10, 6, '', 0, 0, 'C');
					$pdf->Cell(30, 6, '', 0, 0);
					$pdf->Cell(30, 6, '', 0, 0, 'C');
					$pdf->Cell(25, 6, '', 0, 0);
					$pdf->Cell(35, 6, '', 0, 0);
					$pdf->Cell(45, 6, $item->nama_produk . '/' . $item->nama_warna . '/' . $item->nama_ukuran, 1, 0, 'L');
					$pdf->Cell(15, 6, $item->qty, 1, 1, 'R');
				}
			}
		}
		$pdf->Output('I', "$dari -" . " $sampai.pdf");
	}
}

/* End of file BarangMasuk.php */
