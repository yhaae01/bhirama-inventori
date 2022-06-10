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
                    <div class="table-responsive d-flex justify-content-center">
                        <table class="table table-striped">
                            <tr>
                                <td>Id Pengirim</td>
                                <td><?php echo $id_pengirim; ?></td>
                            </tr>
                            <tr>
                                <td>Id Kurir</td>
                                <td><?php echo $id_kurir; ?></td>
                            </tr>
                            <tr>
                                <td>Id MetodePembayaran</td>
                                <td><?php echo $id_metodePembayaran; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo $status; ?></td>
                            </tr>
                            <tr>
                                <td>Penerima</td>
                                <td><?php echo $penerima; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><?php echo $alamat; ?></td>
                            </tr>
                            <tr>
                                <td>No Telp</td>
                                <td><?php echo $no_telp; ?></td>
                            </tr>
                            <tr>
                                <td>Tgl Pesanan</td>
                                <td><?php echo $tgl_pesanan; ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td><?php echo $keterangan; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <a href="" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
                                    <a href="<?php echo site_url('transaksi/Pesanan') ?>" class="btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
    