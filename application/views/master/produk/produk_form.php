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
                                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                <a href="<?php echo site_url('master/Produk') ?>" class="btn btn-default">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->