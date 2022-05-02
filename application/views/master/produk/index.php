<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data Produk</h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('master/Produk/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Foto</th>
                                        <th>QTY</th>
                                        <th>Harga</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                            </thead>
                            <tbody>                         
                                <tr>
                                    <td>
                                        Bhirama Sirwal
                                    </td>
                                    <td>
                                        <img src="<?= base_url('assets/img/default.png') ?>" alt="avatar" width="30" class="rounded-circle mr-1">
                                    </td>
                                    <td>
                                        100
                                    </td>
                                    <td>
                                        200.000
                                    </td>
                                    <td>
                                        Celana
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
