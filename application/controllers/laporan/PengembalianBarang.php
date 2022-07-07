<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengembalianBarang extends CI_Controller
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
		$data['title'] = 'Laporan Pengembalian Barang';
		$data['user']  = $this->pengguna->cekPengguna();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('laporan/pengembalian-barang/pengembalian_list');
		$this->load->view('templates/footer');
		$this->load->view('laporan/pengembalian-barang/pengembalian_js');
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
		$pdf->Cell(0, 10, 'LAPORAN PENGEMBALIAN BARANG', 0, 1, 'C');
		$pdf->Cell(0, 10, $tglDari . " s/d " . $tglSampai, 0, 1, 'C');
		$pdf->Cell(10, 6, '', 0, 1, 'C');
		// -----------------------------------------------------

		// heading
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Admin', 1, 0, 'C');
		$pdf->Cell(30, 6, 'ID', 1, 0, 'C');
		$pdf->Cell(25, 6, 'Tanggal', 1, 0, 'C');
		$pdf->Cell(35, 6, 'Dari', 1, 0, 'C');
		$pdf->Cell(50, 6, 'Item(s)', 1, 0, 'C');
		$pdf->Cell(10, 6, 'Qty', 1, 1, 'C');
		// -----------------------------------------------------

		// isi
		$pdf->SetFont('Arial', '', 10);
		$pengbar = $this->db
			->where('tgl_pengembalian>=', $dari . ' 00:00:00')
			->where('tgl_pengembalian <=', $sampai . ' 23:59:59')
			->where('pengbar.status', '1')
			->from('pengembalian_barang pengbar')
			->join(
				'pengguna p',
				'p.id_pengguna = pengbar.id_pengguna'
			)
			->join(
				'pesanan pes',
				'pes.id_pesanan = pengbar.id_pesanan'
			)
			->group_by('pengbar.id_pengembalian_barang')
			->get()->result();
		$no = 0;
		foreach ($pengbar as $data) {
			$items = $this->db
				->select('
            			dpb.id_detail_produk,
            			dpb.qty,
            			produk.nama_produk,
            			warna.nama_warna,
            			ukuran.nama_ukuran,
            			pengbar.status
            	')
				->where('dpb.id_pengembalian_barang', $data->id_pengembalian_barang)
				->join(
					'detail_produk depro',
					'depro.id_detail_produk = dpb.id_detail_produk'
				)
				->join(
					'produk',
					'depro.id_produk = produk.id_produk'
				)
				->join(
					'pengembalian_barang pengbar',
					'dpb.id_pengembalian_barang = pengbar.id_pengembalian_barang'
				)
				->join(
					'ukuran',
					'depro.id_ukuran = ukuran.id_ukuran'
				)
				->join(
					'warna',
					'depro.id_warna = warna.id_warna'
				)
				->get('detail_pengembalian_barang dpb')
				->result();
			$no++;
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(30, 6, $data->nama_pengguna, 1, 0);
			$pdf->Cell(30, 6, $data->id_pengembalian_barang, 1, 0, 'C');
			$date = date_create($data->tgl_pengembalian);
			$pdf->Cell(25, 6, date_format($date, "d-m-Y"), 1, 0, 'C');
			$pdf->Cell(35, 6, $data->penerima, 1, 0);
			$i = 0;
			foreach ($items as $item) {
				$i++;
				if ($i == 1) {
					$pdf->Cell(50, 6, $item->nama_produk . '/' . $item->nama_warna . '/' . $item->nama_ukuran, 1, 0, 'L');
					$pdf->Cell(10, 6, $item->qty, 1, 1, 'R');
				} else {
					$pdf->Cell(10, 6, '', 0, 0, 'C');
					$pdf->Cell(30, 6, '', 0, 0);
					$pdf->Cell(30, 6, '', 0, 0, 'C');
					$pdf->Cell(25, 6, '', 0, 0);
					$pdf->Cell(35, 6, '', 0, 0);
					$pdf->Cell(50, 6, $item->nama_produk . '/' . $item->nama_warna . '/' . $item->nama_ukuran, 1, 0, 'L');
					$pdf->Cell(10, 6, $item->qty, 1, 1, 'R');
				}
			}
		}
		$pdf->Output('I', "$dari -" . " $sampai.pdf");
	}
}

/* End of file PengembalianBarang.php */
