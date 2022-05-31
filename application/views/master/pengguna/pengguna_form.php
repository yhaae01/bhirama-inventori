<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="bold"><?php echo $button ?> Data Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <?php if ($button === "Edit") { ?>
                                    <div class="form-group">
                                        <label for="varchar">Image</label>
                                        <input type="file" name="image" class="dropify" data-default-file='<?= base_url("assets/img/pengguna/") . $image ?>' id="image" data-allowed-file-extensions="jpg jpeg png" data-max-file-size="1M" data-max-file-size-preview="1M" data-max-width="1000" data-max-height="1000" />
                                        <small class="text-danger">* Max 1 MB</small>
                                        <?= form_error('image', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="varchar">Nama Pengguna</label>
                                    <input type="text" class="form-control" name="nama_pengguna" id="nama_pengguna" placeholder="Nama Pengguna" value="<?php echo $nama_pengguna; ?>" />
                                    <?php echo form_error('nama_pengguna') ?>
                                </div>
                                <div class="form-group">
                                    <label for="varchar">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
                                    <?php echo form_error('username') ?>
                                </div>
                                <div class="form-group">
                                    <label for="varchar"><?= $button === "Edit" ? "Ganti" : "" ?> Password <?= $button === "Edit" ? "(Optional)" : "" ?></label>
                                    <input type="password" class="form-control" name="password" id="password" />
                                    <?php echo form_error('password') ?>
                                </div>
                                <?php if ($button === "Edit") { ?>
                                    <div class="form-group">
                                        <label for="varchar">Konfirmasi Ganti Password</label>
                                        <input type="password" class="form-control" name="konfirmasi_ganti_password" />
                                        <?php echo form_error('konfirmasi_ganti_password') ?>
                                    </div>
                                <?php } ?>
                                <?php if ($button === "Edit") { ?>
                                    <div class="form-group">
                                        <label for="varchar">Role</label>
                                        <select class="form-control" name="role" id="role">
                                            <option></option>
                                            <option value="admin" <?= $role == 'admin' ? "selected" : "" ?>>Admin</option>
                                            <option value="gudang" <?= $role == 'gudang' ? "selected" : "" ?>>Gudang</option>
                                            <option value="pemilik" <?= $role == 'pemilik' ? "selected" : "" ?>>Pemilik</option>
                                            <option value="cs" <?= $role == 'cs' ? "selected" : "" ?>>CS</option>
                                        </select>
                                        <?php echo form_error('role') ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group">
                                        <label for="varchar">Role</label>
                                        <select class="form-control" name="role" id="role">
                                            <option></option>
                                            <option value="admin">Admin</option>
                                            <option value="gudang">Gudang</option>
                                            <option value="pemilik">Pemilik</option>
                                            <option value="cs">CS</option>
                                        </select>
                                        <?php echo form_error('role') ?>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="id_pengguna" value="<?php echo $id_pengguna; ?>" />
                                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                                <a href="<?php echo site_url('master/Pengguna') ?>" class="btn btn-default">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>