<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <?= form_error('nama_pengguna', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                <?= form_error('username', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                <?= form_error('role', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                <div class="card-header">
                    <h4>Data Pengguna</h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('master/Pengguna/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pengguna</a>
                    </div>
                </div>
                <div class="card-body p-0">

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Foto</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pengguna as $p) : ?>
                                    <tr>
                                        <td>
                                            <?= ucwords($p['nama_pengguna']); ?>
                                        </td>
                                        <td>
                                            <?= $p['username']; ?>
                                        </td>
                                        <td>
                                            <img src="<?= base_url('assets/img/profile/') . $p['image']; ?>" alt="avatar" width="30" class="rounded-circle mr-1">
                                        </td>
                                        <td>
                                            <?= strtoupper($p['role']); ?>
                                        </td>
                                        <td>
                                            <!-- <a href="<?= base_url('master/pengguna/ubah/') . $p['id_pengguna'] ?>" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a> -->
                                            <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="modal" data-target="#modalUbah<?= $p['id_pengguna']; ?>" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapus<?= $p['id_pengguna']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" data-backdrop="false" id="modalHapus<?= $p['id_pengguna']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalHapusLabel">Hapus Pengguna</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('master/Pengguna/hapus/') . $p['id_pengguna']; ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                        Yakin ingin hapus pengguna <strong> <?= $p['username'] ?> - <?= $p['nama_pengguna']; ?> </strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Ubah -->
                                    <div class="modal fade" data-backdrop="false" id="modalUbah<?= $p['id_pengguna']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalUbahLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalUbahLabel">Ubah User</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo form_open_multipart('master/Pengguna/ubah'); ?>
                                                    <input type="hidden" name="id_pengguna" value="<?= $p['id_pengguna']; ?>">
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="text" class="form-control" name="nama_pengguna" value="<?= $p['nama_pengguna']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Username</label>
                                                        <input type="text" class="form-control" name="username" value="<?= $p['username']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Password</label>
                                                        <input type="password" class="form-control" name="password" value="<?= $p['password']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Foto</label><br>
                                                        <img class="mb-3" src="<?= base_url('assets/img/profile/') . $p['image']; ?>" height="100">
                                                        <div class="custom-file mb-2">
                                                            <input type="file" name="image" class="custom-file-input">
                                                            <label class="custom-file-label">Pilih foto...</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="position">Role</label>
                                                        <select class="form-control" name="role" value="<?= set_value('role') ?>">
                                                            <option value="<?= strtoupper($p['role']); ?>"><?= strtoupper($p['role']); ?></option>
                                                            <option value="">-- Pilih Role --</option>
                                                            <?php foreach ($role as $r) : ?>
                                                                <?php if ($r == $pengguna['role']) : ?>
                                                                    <option value="<?= strtoupper($r); ?>" selected>
                                                                        <?= strtoupper($r); ?>
                                                                    </option>
                                                                <?php else : ?>
                                                                    <option value="<?= strtoupper($r); ?>">
                                                                        <?= strtoupper($r); ?>
                                                                    </option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-edit mr-1"></i>Ubah</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->