<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Barang Masuk</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Detail Barang Masuk</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="font-family: 'Open Sans','Montserrat', sans-serif;" class="table table-sm text-left table-hover font-weight-bold">
                            <tr>
                                <td width="30%">No. Barang Masuk</td>
                                <td>:</td>
                                <td><b><?= $id_barang_masuk; ?></b></td>
                            </tr>
                            <tr>
                                <td>Tanggal Barang Masuk</td>
                                <td>:</td>
                                <td><?= $tgl_barang_masuk; ?></td>
                            </tr>
                            <tr>
                                <td>Dari Supplier</td>
                                <td>:</td>
                                <td><?= ucfirst($nama_supplier); ?></td>
                            </tr>
                            <tr>
                                <td>Admin</td>
                                <td>:</td>
                                <td><?= $nama_pengguna; ?></td>
                            </tr>
                            <tr class="bordered">
                            </tr>
                            <tr>
                                <td class="va" style="vertical-align:middle">Item(s)</td>
                                <td class="va" style="vertical-align:middle">:</td>
                                <td class="va" align="center">
                                    <table class="table table-sm text-left table-hover m-0 p-0">
                                        <?php foreach ($detail_barang_masuk as $item) : ?>
                                            <tr>
                                                <td>
                                                    <?= strtoupper($item->nama_produk) . ' / ' . strtoupper($item->nama_warna) . ' / ' . strtoupper($item->nama_ukuran) . ' / ' . strtoupper($item->qty) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <a href="<?= site_url('transaksi/BarangMasuk') ?>" class=" btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>