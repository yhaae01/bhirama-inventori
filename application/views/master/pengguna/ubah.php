<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Ubah Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama_pengguna" value="<?= $pengguna['nama_pengguna'] ?>">
                                    <?= form_error('nama_pengguna', '<small class="text-danger">', '</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="<?= $pengguna['username'] ?>" name="username">
                                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password1">
                                    <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role" value="<?= set_value('role') ?>">
                                        <option value="">-- Pilih Role --</option>
                                        <?php foreach ($role as $r) : ?>
                                            <?php if ($r == $pengguna['role']) : ?>
                                                <option value="<?= $r; ?>" selected>
                                                    <?= $r; ?>
                                                </option>
                                            <?php else : ?>
                                                <option value="<?= $r; ?>">
                                                    <?= $r; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('role', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="image">Foto</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Pilih foto</label>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            <button class="btn btn-secondary" type="reset"><i class="fas fa-undo"></i> Reset</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
<!-- End Main Content -->