<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <!-- Data Produk -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="bold">Data Produk</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="varchar">Image</label>
                                <input type="file" title=" " name="image" class="dropify" disabled="disabled" data-default-file='<?= base_url("assets/img/produk/") . $image ?>' id="image" data-allowed-file-extensions="jpg jpeg png" data-max-file-size="1M" data-max-file-size-preview="1M" data-max-width="1000" data-max-height="1000" />
                            </div>
                            <div class="form-group">
                                <label for="varchar">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="<?php echo $nama_produk; ?>" readonly />
                            </div>
                            <div class="form-group">
                                <label for="int">Kategori</label>
                                <select class="form-control" name="id_kategori" id="id_kategori" disabled>
                                    <option value="<?= $id_kategori; ?>" selected="selected"><?= $nama_kategori; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Data Produk -->
                <!-- Varian -->
                <div class="col-lg-6">
                    <!-- List Detail Produk -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="bold">Data Variasi</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover" id="tbl_detail_produk">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Warna</th>
                                                <th>Ukuran</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of List Detail Produk -->
                </div>
                <!-- End of Varian -->
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->