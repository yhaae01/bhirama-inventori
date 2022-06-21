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
                        <?php echo anchor(site_url('transaksi/Pesanan/create'), '<i class="fas fa-plus"></i> Tambah', 'class="btn btn-primary"'); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="mb-2 mt-0">
                            <tr>
                                <td>Dari</td>
                                <td>:</td>
                                <td><input type="text" id="dariTgl" class="form-control"></td>
                                <td></td>
                                <td>Sampai</td>
                                <td>:</td>
                                <td><input type="text" id="sampaiTgl" class="form-control"></td>
                                <td></td>
                                <td><input type="submit" value="Ok" id="filterTgl" class="btn btn-primary"></td>
                            </tr>
                        </table>
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