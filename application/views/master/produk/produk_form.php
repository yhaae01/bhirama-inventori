<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <!-- Edit Produk -->
                <div class="col-lg-6">
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
                                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_produk; ?>" />
                                    <?php echo form_error('nama_produk') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Kategori</label>
                                    <select class="form-control" name="id_kategori" id="id_kategori">
                                        <?php if ($button === "Edit") { ?>
                                            <option value="<?= $id_kategori; ?>" selected="selected"><?= $nama_kategori; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('id_kategori') ?>
                                </div>
                                <?php if ($button === "Edit") { ?>
                                    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" />
                                <?php } ?>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                    <a href="<?php echo site_url('master/Produk') ?>" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Edit Produk -->

                <!-- Varian -->
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Ukuran</label>
                                                    <select name="" id="" class="form-control">
                                                        <option value="">L</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Warna</label>
                                                    <select name="" id="" class="form-control">
                                                        <option value="">Merah</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">QTY</label>
                                                    <input type="number" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Ukuran</th>
                                                <th>Warna</th>
                                                <th>QTY</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>L</td>
                                                <td>Merah</td>
                                                <td>2</td>
                                                <td>
                                                    <a href="" class="btn btn-danger" title="Hapus"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Varian -->
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->