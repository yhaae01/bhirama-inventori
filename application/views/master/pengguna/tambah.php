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
                            <h4>Tambah Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('master/Pengguna/tambah'); ?>" method="post">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama_pengguna" value="<?= set_value('nama_pengguna') ?>">
                                    <?= form_error('nama_pengguna', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="<?= set_value('username') ?>">
                                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password1">
                                    <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Ulangi Password</label>
                                    <input type="password" class="form-control" name="password2">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role" value="<?= set_value('bank') ?>">
                                        <option value="">-- Pilih Role --</option>
                                        <option name="role" value="admin">Admin</option>
                                        <option name="role" value="gudang">Gudang</option>
                                        <option name="role" value="pemilik">Pemilik</option>
                                    </select>
                                    <?= form_error('role', '<small class="text-danger">', '</small>') ?>
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
