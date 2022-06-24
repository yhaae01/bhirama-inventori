<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Retur Barang</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                <div class="card-header">
                    <h4>Data Retur Barang</h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('transaksi/ReturBarang/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Barang Masuk | Supplier</th>
                                    <th>Tanggal Retur</th>
                                    <th>Status</th>
                                    <th>Admin</th>
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