<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekening</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="bold"><?php echo $button ?> Data Rekening</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action; ?>" method="post">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <div class="form-group">
                                    <label for="varchar">Nama Pemilik</label>
                                    <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" placeholder="Nama Pemilik" value="<?php echo $nama_pemilik; ?>" />
                                    <?php echo form_error('nama_pemilik') ?>
                                </div>
                                <?php if ($button === "Edit") { ?>
                                    <div class="form-group">
                                        <label for="varchar">Bank</label>
                                        <select class="form-control" name="bank" id="bank">
                                            <option value="">-- Pilih Bank --</option>
                                            <option value="BCA" <?= $bank == 'BCA' ? "selected" : "" ?>>BCA</option>
                                            <option value="MANDIRI" <?= $bank == 'MANDIRI' ? "selected" : "" ?>>MANDIRI</option>
                                            <option value="BRI" <?= $bank == 'BRI' ? "selected" : "" ?>>BRI</option>
                                            <option value="BNI" <?= $bank == 'BNI' ? "selected" : "" ?>>BNI</option>
                                        </select>
                                        <?php echo form_error('bank') ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group">
                                        <label for="varchar">Bank</label>
                                        <select class="form-control" name="bank" id="bank">
                                            <option value="">-- Pilih Bank --</option>
                                            <option value="BCA">BCA</option>
                                            <option value="MANDIRI">MANDIRI</option>
                                            <option value="BRI">BRI</option>
                                            <option value="BNI">BNI</option>
                                        </select>
                                        <?php echo form_error('bank') ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="varchar">Nomor Rekening</label>
                                    <input type="number" class="form-control" name="nomor_rekening" id="nomor_rekening" placeholder="Nomor Rekening" value="<?php echo $nomor_rekening; ?>" />
                                    <?php echo form_error('nomor_rekening') ?>
                                </div>
                                <input type="hidden" name="id_rekening" value="<?php echo $id_rekening; ?>" />
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> <?php echo $button ?></button>
                                    <a href="<?php echo site_url('master/rekening') ?>" class="btn btn-secondary"><i class="fas fa-undo"></i> Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>