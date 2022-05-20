<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-header justify-content-center">
                    <h4 class="bold"><?php echo $button ?> Data Supplier</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo $action; ?>" method="post" enctype='multipart/form-data'>
                        <?php if ($button === "Edit") { ?>
                            <div class="form-group">
                                <label for="varchar">Image <?php echo form_error('image') ?></label>
                                <input type="file" name="image" class="dropify" data-default-file='<?= base_url("assets/img/supplier/") . $image ?>' id="image" data-allowed-file-extensions="jpg jpeg png" data-max-file-size="1M" data-max-file-size-preview="1M" data-max-width="1000" data-max-height="1000" />
                            </div>
                        <?php } ?>
                        <div class=" form-group">
                            <label for="varchar">Nama Supplier <?php echo form_error('nama_supplier') ?></label>
                            <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" placeholder="Nama Supplier" value="<?php echo $nama_supplier; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat <?php echo form_error('alamat') ?></label>
                            <textarea class="form-control" style="height:100%;" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="varchar">No Telp <?php echo form_error('no_telp') ?></label>
                            <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telp" value="<?php echo $no_telp; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="varchar">Email <?php echo form_error('email') ?></label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                        </div>
                        <input type="hidden" name="id_supplier" value="<?php echo $id_supplier; ?>" />
                        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                        <a href="<?php echo site_url('master/Supplier') ?>" class="btn btn-default">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->