<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
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
                                        <?= form_error('image', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="varchar">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_produk; ?>" />
                                    <?= form_error('nama_produk', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Kategori</label>
                                    <select class="form-control" name="id_kategori" id="id_kategori">
                                        <?php if ($button === "Edit") { ?>
                                            <option value="<?= $id_kategori; ?>" selected="selected"><?= $nama_kategori; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?= form_error('id_kategori', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Ukuran</label>
                                    <select class="form-control" name="id_ukuran" id="id_ukuran">
                                        <?php if ($button === "Edit") { ?>
                                            <option value="<?= $id_ukuran; ?>" selected="selected"><?= $nama_ukuran; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?= form_error('id_ukuran', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Warna</label>
                                    <select class="form-control" name="id_warna" id="id_warna">
                                        <?php if ($button === "Edit") { ?>
                                            <option value="<?= $id_warna; ?>" selected="selected"><?= $nama_warna; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?= form_error('id_warna', '<small class="text-danger">', '</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="int">Qty</label>
                                    <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty" value="<?php echo $qty; ?>" />
                                    <?= form_error('qty', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Harga</label>
                                    <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
                                    <?= form_error('harga', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" />
                                <div class="text-right">
                                    <a href="<?php echo site_url('master/Produk') ?>" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i><?php echo $button ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>