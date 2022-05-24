<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Supplier</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Supplier</h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('transaksi/PurchaseOrder/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Supplier</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Tanggal</th>
                                    <th>QTY</th>
                                    <th>Nama Supplier</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Bhirama Sirwal
                                    </td>
                                    <td>
                                        2-Mei-2022
                                    </td>
                                    <td>
                                        100
                                    </td>
                                    <td>
                                        Sirwal Bandung
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="#" class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></a>
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