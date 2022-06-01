<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengirim</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="bold"><?php echo $button ?> Data Pengirim</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action; ?>" method="post">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <div class="form-group">
                                    <label for="varchar">Nama Pengirim</label>
                                    <input type="text" class="form-control" name="nama_pengirim" id="nama_pengirim" placeholder="Nama pengirim" value="<?php echo $nama_pengirim; ?>" />
                                    <?php echo form_error('nama_pengirim') ?>
                                </div>
                                <input type="hidden" name="id_pengirim" value="<?php echo $id_pengirim; ?>" />
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> <?php echo $button ?></button>
                                    <a href="<?php echo site_url('master/pengirim') ?>" class="btn btn-secondary"><i class="fas fa-undo"></i> Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>