<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Retur Barang</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pilih Tanggal</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter -->
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label for="">Dari</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label for="">Sampai</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label for="">&nbsp;</label>
                                    <input type="submit" value="Cari" id="filterTgl" class="btn btn-info form-control text-center" style="width: 60px; height: 43px ;margin-top: 29px; margin-left: -5px">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">&nbsp;</label>
                                    <?php echo anchor(site_url(''), '<i class="fas fa-file-excel"></i> Excel', 'class="btn btn-success form-control"'); ?>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">&nbsp;</label>
                                    <?php echo anchor(site_url(''), '<i class="fas fa-file-word"></i> Word', 'class="btn btn-primary form-control"'); ?>
                                </div>
                            </div>
                            
                            <!-- Tabel -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-hover mt-4" id="mytable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pesanan</th>
                                                <th>Penerima</th>
                                                <th>Produk</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
