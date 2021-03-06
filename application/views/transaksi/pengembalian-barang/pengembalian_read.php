<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pengembalian</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Detail Pengembalian</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="font-family: 'Open Sans','Montserrat', sans-serif;" class="table table-sm text-left table-hover font-weight-bold" id="detail_pesanan_form">
                            <tr>
                                <td width="30%">No. Pesanan</td>
                                <td>:</td>
                                <td><b><?= $id_pesanan; ?></b></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengajuan</td>
                                <td>:</td>
                                <td><?= date('d/m/Y, h:i', strtotime($tgl_pengembalian)); ?></td>
                            </tr>
                            <tr>
                                <td>Admin</td>
                                <td>:</td>
                                <td><?= $nama_pengguna ?></td>
                            </tr>
                            <tr class="bordered">
                            </tr>
                            <tr>
                                <td>Pembeli</td>
                                <td>:</td>
                                <td><?= $penerima; ?></td>
                            </tr>
                            <tr>
                                <td>Alasan Pengembalian</td>
                                <td>:</td>
                                <td><?= $keterangan == "" ? '-' : ucfirst($keterangan); ?></td>
                            </tr>
                            <tr class="bordered">
                            </tr>
                            <tr>
                                <td class="va" style="vertical-align:middle">Item(s) Pengembalian</td>
                                <td class="va" style="vertical-align:middle">:</td>
                                <td class="va" align="center">
                                    <table class="table table-sm text-left table-hover m-0 tblDP">
                                        <?php foreach ($detail_pengembalian as $item) : ?>
                                            <tr>
                                                <td>
                                                    <?= strtoupper($item->nama_produk) . ' / ' . strtoupper($item->nama_warna) . ' / ' . strtoupper($item->nama_ukuran) . ' / ' . strtoupper($item->qty) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td><?= $status == "0" ? '<span class="badge badge-warning status">Belum diproses</span>' : '<span class="badge badge-success status">Sudah diproses</span>'; ?></td>
                            </tr>
                        </table>
                        <?php if ($status == "0") : ?>
                            <form action="#" id="updateStatusPengembalian">
                                <input type="hidden" class="form-control" name="id_pengembalian" id="id_pengembalian" value="<?= $id_pengembalian; ?>">
                                <input type="hidden" class="form-control" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <button type="submit" class="btn btn-primary" id="prosesPengembalian">
                                    <i class="fas fa-check-circle"></i> Proses</button>
                                <a href="<?= site_url('transaksi/PengembalianBarang') ?>" class=" btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                            </form>
                        <?php else : ?>
                            <a href="<?= site_url('transaksi/PengembalianBarang') ?>" class=" btn btn-secondary"><i class="fas fa-angle-left"></i> Kembali</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>