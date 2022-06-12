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
                        <table class="table table-sm text-left table-hover">
                            <tr>
                                <td>No. Pesanan</td>
                                <td>:</td>
                                <td><b><?= $id_pesanan; ?></b></td>
                                <td width="1%">Tanggal</td>
                                <td width="1%">:</td>
                                <td width="15%"><?= date('d/m/Y', strtotime($tgl_pesanan)); ?></td>
                            </tr>
                            <tr>
                                <td>Pengirim</td>
                                <td>:</td>
                                <td><?= $nama_pengirim; ?></td>
                                <td>Admin</td>
                                <td>:</td>
                                <td><?= $nama_pengguna ?></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <hr style="margin:0px; border-top:1px solid">
                                </td>
                            </tr>
                            <tr>
                                <td>Penerima</td>
                                <td>:</td>
                                <td colspan="4"><?= $penerima; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td colspan="4"><?= $alamat; ?></td>
                            </tr>
                            <tr>
                                <td>No Hp</td>
                                <td>:</td>
                                <td colspan="4"><?= $no_telp; ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td colspan="4"><?= $keterangan == "" ? '-' : $keterangan; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <hr style="margin:0px; border-top:1px solid">
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle">Item(s)</td>
                                <td style="vertical-align:middle">:</td>
                                <td colspan="4" align="center">
                                    <table class="table table-sm text-left table-hover m-0">
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
                                                <td><?= '<b>' . strtoupper($item->nama_produk) . ' / ' . strtoupper($item->nama_warna) . ' / ' . strtoupper($item->nama_ukuran) . ' / ' . strtoupper($item->qty) . $item->sub_total . '</b>' ?></td>
                                            </tr>
                                        <?php endforeach ?>

                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <hr style="margin:0px; border-top:1px solid">
                                </td>
                            </tr>
                            <tr>
                                <td>Kurir</td>
                                <td>:</td>
                                <td colspan="4"><?= $nama_kurir; ?></td>
                            </tr>
                            <tr>
                                <td>Metode Pembayaran</td>
                                <td>:</td>
                                <td colspan="4"><?= $nama_metodePembayaran; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td colspan="4"><?= $status == "0" ? '<span class="badge badge-warning">Belum diproses</span>' : '<span class="badge badge-success">Sudah diproses</span>'; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6" align="center">
                                    <a href="" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
                                    <a href="<?= site_url('transaksi/Pesanan') ?>" class="btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>