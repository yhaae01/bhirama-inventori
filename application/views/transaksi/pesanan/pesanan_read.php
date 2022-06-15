<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pesanan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Detail Pesanan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="font-family: 'Open Sans', sans-serif;" class="table table-sm text-left table-hover font-weight-bold" id="detail_pesanan_form">
                            <tr>
                                <td width="30%">No. Pesanan</td>
                                <td>:</td>
                                <td><b><?= $id_pesanan; ?></b></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><?= date('d/m/Y', strtotime($tgl_pesanan)); ?></td>
                            </tr>
                            <tr>
                                <td>Pengirim</td>
                                <td>:</td>
                                <td><?= $nama_pengirim; ?></td>
                            </tr>
                            <tr>
                                <td>Admin</td>
                                <td>:</td>
                                <td><?= $nama_pengguna ?></td>
                            </tr>
                            <tr class="bordered">
                                <!-- <td colspan="3">
                                    <hr style="margin:0px; border-top:1px solid">
                                </td> -->
                            </tr>
                            <tr>
                                <td>Penerima</td>
                                <td>:</td>
                                <td><?= $penerima; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?= $alamat; ?></td>
                            </tr>
                            <tr>
                                <td>No Hp</td>
                                <td>:</td>
                                <td><?= $no_telp; ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?= $keterangan == "" ? '-' : $keterangan; ?></td>
                            </tr>
                            <tr class="bordered">
                                <!-- <td width="100%" colspan="3">
                                    <hr style="margin:0px; border-top:1px solid; width:100%">
                                </td> -->
                            </tr>
                            <tr>
                                <td style="vertical-align:middle">Item(s)</td>
                                <td style="vertical-align:middle">:</td>
                                <td align="center">
                                    <table class="table table-sm text-left table-hover m-0 tblDP">
                                        <?php foreach ($detail_pesanan as $item) : ?>
                                            <?php
                                            // jika sub_total 0 tambahkan note BONUS
                                            if ($item->sub_total == "0") {
                                                $item->sub_total = ' (BONUS)';
                                            } else {
                                                $item->sub_total = '';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= strtoupper($item->nama_produk) . ' / ' . strtoupper($item->nama_warna) . ' / ' . strtoupper($item->nama_ukuran) . ' / ' . strtoupper($item->qty) . $item->sub_total ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </td>
                            </tr>
                            <tr class="bordered">
                                <!-- <td colspan="3">
                                    <hr style="margin:0px; border-top:1px solid">
                                </td> -->
                            </tr>
                            <tr>
                                <td>Kurir</td>
                                <td>:</td>
                                <td><?= $nama_kurir; ?></td>
                            </tr>
                            <tr class="d-print-none">
                                <td>Ongkos Kirim</td>
                                <td>:</td>
                                <td><?= $ongkir; ?></td>
                            </tr>
                            <tr class="d-print-none">
                                <td>Metode Pembayaran</td>
                                <td>:</td>
                                <td><?= $nama_metodePembayaran; ?></td>
                            </tr>
                            <tr class="d-print-none">
                                <td>Status</td>
                                <td>:</td>
                                <td><?= $status == "0" ? '<span class="badge badge-warning">Belum diproses</span>' : '<span class="badge badge-success">Sudah diproses</span>'; ?></td>
                            </tr>
                        </table>
                        <?php if ($user['role'] != "pemilik") : ?>
                            <a href="#" class="btn btn-primary" id="print-dp">
                                <i class="fas fa-print"></i> Print</a>
                        <?php endif ?>
                        <a href="<?= site_url('transaksi/Pesanan') ?>" class=" btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>