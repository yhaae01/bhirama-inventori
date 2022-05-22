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
                                    <input type="text" class="form-control" name="id_kategori" id="id_kategori" placeholder="Id Kategori" value="<?php echo $id_kategori; ?>" />
                                    <?= form_error('id_kategori', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Ukuran <?php echo form_error('id_ukuran') ?></label>
                                    <input type="text" class="form-control" name="id_ukuran" id="id_ukuran" placeholder="Id Ukuran" value="<?php echo $id_ukuran; ?>" />
                                    <?= form_error('id_ukuran', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Warna <?php echo form_error('id_warna') ?></label>
                                    <input type="text" class="form-control" name="id_warna" id="id_warna" placeholder="Id Warna" value="<?php echo $id_warna; ?>" />
                                    <?= form_error('id_warna', '<small class="text-danger">', '</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="int">Qty <?php echo form_error('qty') ?></label>
                                    <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty" value="<?php echo $qty; ?>" />
                                    <?= form_error('qty', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="int">Harga <?php echo form_error('harga') ?></label>
                                    <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
                                    <?= form_error('harga', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="date">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" />
                                </div>
                                <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" />
                                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                <a href="<?php echo site_url('produk') ?>" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>