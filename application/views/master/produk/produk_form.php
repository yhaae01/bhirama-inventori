<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <!-- Edit Produk -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="bold"><?php echo $button ?> Data Produk</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data'>
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <?php if ($button === "Edit") { ?>
                                    <div class="form-group">
                                        <label for="varchar">Image</label>
                                        <input type="file" name="image" class="dropify" data-default-file='<?= base_url("assets/img/produk/") . $image ?>' id="image" data-allowed-file-extensions="jpg jpeg png" data-max-file-size="1M" data-max-file-size-preview="1M" data-max-width="1000" data-max-height="1000" />
                                        <small class="text-danger">* Max 1 MB</small>
                                        <?= form_error('image', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="varchar">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="<?php echo $nama_produk; ?>" />
                                    <?php echo form_error('nama_produk') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Kategori</label>
                                    <select class="form-control" name="id_kategori" id="id_kategori">
                                        <?php if ($button === "Edit") { ?>
                                            <option value="<?= $id_kategori; ?>" selected="selected"><?= $nama_kategori; ?></option>
                                        <?php } else { ?>
                                            <option></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('id_kategori') ?>
                                </div>
                                <?php if ($button === "Edit") { ?>
                                    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" />
                                <?php } ?>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-<?= $button == "Tambah" ? "plus" : "pencil-alt" ?>"></i> <?php echo $button ?></button>
                                    <a href="<?php echo site_url('master/Produk') ?>" class="btn btn-secondary"><i class="fas fa-undo"></i> Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Edit Produk -->
                <?php if ($button === "Edit") { ?>
                    <!-- Varian -->
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="bold">Variasi Produk</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="inputVariasi" action="">
                                            <input type="hidden" class="form-control" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                            <input type="hidden" class="form-control" name="id_produk" value="<?php echo $id_produk; ?>" />
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Warna</label>
                                                        <select name="id_warna" id="id_warna" class="form-control">
                                                            <option></option>
                                                        </select>
                                                        <span class="text-danger error_warna"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Qty</label>
                                                        <input type="number" id="qty" name="qty" min="0" class="form-control">
                                                        <span class="text-danger error_qty"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Ukuran</label>
                                                        <select name="id_ukuran" id="id_ukuran" class="form-control">
                                                            <option></option>
                                                        </select>
                                                        <span class="text-danger error_ukuran"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Berat (g) / pc</label>
                                                        <input type="number" id="berat" name="berat" min="0" class="form-control">
                                                        <span class="text-danger error_berat"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="">Harga</label>
                                                        <input type="number" id="harga" name="harga" min="0" class="form-control">
                                                        <span class="text-danger error_harga"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                                                <button type="button" class="btn btn-secondary btnReset">Reset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- List Detail Produk -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tbl_detail_produk">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Warna</th>
                                                        <th>Ukuran</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Berat (g)</th>
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
                        </div>
                        <!-- End of List Detail Produk -->
                    </div>
                <?php } ?>
                <!-- End of Varian -->
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->