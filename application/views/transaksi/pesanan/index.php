<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pesanan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pesanan</h4>
                    <?php if ($user['role'] !== 'gudang') : ?>
                        <div class="card-header-action">
                            <a href="<?= base_url('transaksi/Pesanan/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pesanan</a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Tanggal</th>
                                    <th>QTY</th>
                                    <th>Status</th>
                                    <th>Harga</th>
                                    <?php if ($user['role'] !== 'CS') : ?>
                                        <th>Action</th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Bhirama Sirwal Khaki
                                    </td>
                                    <td>
                                        2-Mei-2022
                                    </td>
                                    <td>
                                        4
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Diproses</span>
                                    </td>
                                    <td>
                                        200000
                                    </td>
                                    <td>
                                        <?php if ($user['role'] !== 'CS') : ?>
                                            <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->