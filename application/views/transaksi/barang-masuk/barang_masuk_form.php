<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Barang Masuk</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <!-- Pruchase Order -->
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Barang Masuk</h4>
                        </div>
                        <form action="" method="post" id="inputKeranjang">
                            <div class="card-body">
                                <input type="hidden" class="form-control" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <input type="hidden" class="form-control" name="idSupplier" id="idSupplier" value="" />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <select class="form-control" id="id_supplier">
                                            </select>
                                            <span class="text-danger error_supplier"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nama Produk</label>
                                            <select class="form-control" name="id_produk" id="id_produk">
                                            </select>
                                            <span class="text-danger error_produk"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Warna</label>
                                            <select class="form-control" name="id_warna" id="id_warna">
                                            </select>
                                            <span class="text-danger error_warna"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Ukuran</label>
                                            <select class="form-control" name="id_ukuran" id="id_ukuran">
                                            </select>
                                            <span class="text-danger error_ukuran"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="number" class="form-control" name="harga" id="harga">
                                            <span class="text-danger error_harga"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Qty</label>
                                            <input type="number" class="form-control" name="qty" id="qty">
                                            <span class="text-danger error_qty"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Berat (g) / pc</label>
                                            <input type="number" class="form-control" name="berat" id="berat">
                                            <span class="text-danger error_berat"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i> Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Detail -->
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Barang Masuk</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="detail_barangmasuk">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Warna</th>
                                            <th>Ukuran</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Berat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" id="simpanBarangMasuk" type="submit"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->