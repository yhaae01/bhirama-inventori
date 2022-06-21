<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Pengembalian Barang</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pilih Tanggal</h4>
                            <div class="card-header-action">
                                <a href="<?= base_url('') ?>" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                            </div>
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
                                    <input type="submit" value="Cari" id="filterTgl" class="btn btn-info form-control" style="width: 60px; height: 43px ;margin-top: 29px; margin-left: -5px">
                                </div>
                            </div>
                            
                            <!-- Tabel -->
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-hover mt-4" id="mytable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>ID Pesanan | Penerima</th>
                                                    <th>Tanggal Pesanan</th>
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
        </div>
    </section>
</div>
<!-- End Main Content -->
