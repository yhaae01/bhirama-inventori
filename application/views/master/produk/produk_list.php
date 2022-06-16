p<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                <div class="card-header">
                    <h4>Data Produk</h4>
                    <?php if ($user['role'] != 'cs') : ?>
                        <div class="card-header-action">
                            <?php echo anchor(site_url('master/Produk/create'), '<i class="fas fa-plus"></i> Tambah Produk', 'class="btn btn-primary"'); ?>
                            <?php echo anchor(site_url('master/Produk/excel'), '<i class="fas fa-file-excel"></i> Excel', 'class="btn btn-success"'); ?>
                            <?php echo anchor(site_url('master/Produk/word'), '<i class="fas fa-file-word"></i> Word', 'class="btn btn-info"'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Stok Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->