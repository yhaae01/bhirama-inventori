<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Retur</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Detail Retur</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="font-family: 'Open Sans','Montserrat', sans-serif;" class="table table-sm text-left table-hover font-weight-bold" id="detail_retur">
                            <tr class="d-print-none">
                                <td>ID Barang Masuk</td>
                                <td>:</td>
                                <td><b><?= $id_barang_masuk; ?></b></td>
                            </tr>
                            <tr>
                                <td>Dari Supplier</td>
                                <td>:</td>
                                <td><b><?= ucfirst($nama_supplier); ?></b></td>
                            </tr>
                            <tr>
                                <td>Tanggal Retur</td>
                                <td>:</td>
                                <td><?= date('d/m/Y, H:i', strtotime($tgl_retur)); ?></td>
                            </tr>
                            <tr>
                                <td>Admin</td>
                                <td>:</td>
                                <td><?= $nama_pengguna ?></td>
                            </tr>
                            <tr class="bordered">
                            </tr>
                            <tr>
                                <td>Alasan Retur</td>
                                <td>:</td>
                                <td><?= ucfirst($keterangan) ?></td>
                            </tr>
                            <tr class="bordered">
                            </tr>
                            <tr>
                                <td class="va" style="vertical-align:middle">Item(s)</td>
                                <td class="va" style="vertical-align:middle">:</td>
                                <td class="va" align="center">
                                    <table class="table table-sm text-left table-hover m-0">
                                        <?php foreach ($detail_retur_barang as $item) : ?>
                                            <tr>
                                                <td>
                                                    <?= strtoupper($item->nama_produk) . ' / ' . strtoupper($item->nama_warna) . ' / ' . strtoupper($item->nama_ukuran) . ' / ' . strtoupper($item->qty) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </td>
                            </tr>
                            <tr class="d-print-none">
                                <td>Status</td>
                                <td>:</td>
                                <td><?= $status == "0" ? '<span class="badge badge-warning status">Belum dikirim</span>' : '<span class="badge badge-success status">Sudah dikirim</span>'; ?></td>
                            </tr>
                        </table>
                        <?php if ($status == "0") : ?>
                            <form action="#" id="updateStatusRetur">
                                <input type="hidden" class="form-control" name="id_retur_barang" id="id_retur_barang" value="<?= $id_retur_barang; ?>">
                                <input type="hidden" class="form-control" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <button type="submit" class="btn btn-primary" id="prosesRetur">
                                    <i class="fas fa-check-circle"></i> Proses Retur</button>
                                <a href="<?= site_url('transaksi/ReturBarang') ?>" class=" btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                            </form>
                        <?php else : ?>
                            <a href="<?= site_url('transaksi/ReturBarang') ?>" class=" btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>