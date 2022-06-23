<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Retur Barang</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <!-- Retur Form -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Retur Barang</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" id="inputKeranjang">
                                <input type="hidden" class="form-control" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <input type="hidden" class="form-control" name="idBarangMasuk" id="idBarangMasuk" value="" />
                                <div class="form-group">
                                    <label>Barang Masuk</label>
                                    <select class="form-control" id="id_barangmasuk">
                                        <option></option>
                                    </select>
                                    <span class="text-danger error_barang_masuk"></span>
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <select class="form-control" name="id_detail_produk" id="id_detail_produk">
                                        <option></option>
                                    </select>
                                    <span class="text-danger error_produk"></span>
                                </div>
                                <div class="form-group">
                                    <label>QTY</label>
                                    <input type="number" name="qty" id="qty" min="0" class="form-control">
                                    <span class="text-primary qtyLoad"></span>
                                    <span class="text-danger error_qty"></span>
                                </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- Detail -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Retur</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="detail_returbarang">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th colspan="3">Produk</th>
                                            <th>Qty</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group mt-4">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control"></textarea>
                                <span class="text-danger error_ket"></span>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" id="simpanRetur" type="submit"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->