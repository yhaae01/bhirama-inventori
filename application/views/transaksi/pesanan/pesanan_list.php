<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pesanan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                <div class="card-header">
                    <h4>Data Pesanan</h4>
                    <div class="card-header-action">
                        <?php echo anchor(site_url('transaksi/Pesanan/create'), '<i class="fas fa-plus"></i> Tambah Pesanan', 'class="btn btn-primary"'); ?>
                        <?php if ($user['role'] != 'cs') : ?>
                            <?php echo anchor(site_url('transaksi/Pesanan/word'), '<i class="fas fa-file-word"></i> Word', 'class="btn btn-info"'); ?>
                            <?php echo anchor(site_url('transaksi/Pesanan/excel'), '<i class="fas fa-file-excel"></i> Excel', 'class="btn btn-success"'); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pesanan</th>
                                    <th>Penerima</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->