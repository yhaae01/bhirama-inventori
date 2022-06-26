<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
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
		$data['title'] = 'Laporan Pesanan';
		$data['user'] = $this->pengguna->cekPengguna();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('laporan/pesanan/pesanan_list');
		$this->load->view('templates/footer');
		$this->load->view('laporan/pesanan/pesanan_js');
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
		$pdf->Cell(0, 10, 'LAPORAN PESANAN', 0, 1, 'C');
		$pdf->Cell(0, 10, $tglDari . " s/d " . $tglSampai, 0, 1, 'C');
		$pdf->Cell(10, 6, '', 0, 1, 'C');
		// -----------------------------------------------------

		// heading
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(10, 6, 'No', 1, 0, 'C');
		$pdf->Cell(30, 6, 'Admin', 1, 0, 'C');
		$pdf->Cell(30, 6, 'ID Pesanan', 1, 0, 'C');
		$pdf->Cell(25, 6, 'Tanggal', 1, 0, 'C');
		$pdf->Cell(35, 6, 'Penerima', 1, 0, 'C');
		$pdf->Cell(45, 6, 'Item(s)', 1, 0, 'C');
		$pdf->Cell(15, 6, 'Qty', 1, 1, 'C');
		// -----------------------------------------------------

		// isi
		$pdf->SetFont('Arial', '', 10);
		$pesanan = $this->db
			->where('tgl_pesanan>=', $dari . ' 00:00:00')
			->where('tgl_pesanan <=', $sampai . ' 23:59:59')
			->where('pes.status', '1')
			->from('pesanan pes')
			->join(
				'pengguna p',
				'p.id_pengguna = pes.id_pengguna'
			)
			->join(
				'detail_pesanan depe',
				'depe.id_pesanan = pes.id_pesanan'
			)
			->group_by('pes.id_pesanan')
			->get()->result();
		$no = 0;
		foreach ($pesanan as $data) {
			$items = $this->db
				->select('
            			detail_pesanan.id_detail_produk,
            			produk.nama_produk,
            			warna.nama_warna,
            			ukuran.nama_ukuran,
            			detail_pesanan.qty,
            			pesanan.status
            	')
				->where('detail_pesanan.id_pesanan', $data->id_pesanan)
				->join(
					'detail_produk',
					'detail_produk.id_detail_produk = detail_pesanan.id_detail_produk'
				)
				->join(
					'produk',
					'detail_produk.id_produk = produk.id_produk'
				)
				->join(
					'pesanan',
					'detail_pesanan.id_pesanan = pesanan.id_pesanan'
				)
				->join(
					'ukuran',
					'detail_produk.id_ukuran = ukuran.id_ukuran'
				)
				->join(
					'warna',
					'detail_produk.id_warna = warna.id_warna'
				)
				->get('detail_pesanan')
				->result();
			$no++;
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(30, 6, $data->nama_pengguna, 1, 0);
			$pdf->Cell(30, 6, $data->id_pesanan, 1, 0, 'C');
			$date = date_create($data->tgl_pesanan);
			$pdf->Cell(25, 6, date_format($date, "d-m-Y"), 1, 0, 'C');
			$pdf->Cell(35, 6, $data->penerima, 1, 0);
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

/* End of file Pesanan.php */
