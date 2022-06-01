<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Warna</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="bold"><?php echo $button ?> Data Warna</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action; ?>" method="post">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <div class="form-group">
                                    <label for="varchar">Nama Warna</label>
                                    <input type="text" class="form-control" name="nama_warna" id="nama_warna" placeholder="Nama Warna" value="<?php echo $nama_warna; ?>" />
                                    <?php echo form_error('nama_warna') ?>
                                </div>
                                <input type="hidden" name="id_warna" value="<?php echo $id_warna; ?>" />
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> <?php echo $button ?></button>
                                    <a href="<?php echo site_url('master/Varian') ?>" class="btn btn-secondary"><i class="fas fa-undo"></i> Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>