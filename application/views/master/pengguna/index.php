<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
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
                                        <?= $p['role']; ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapus<?= $p['id_pengguna']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <!-- Modal Hapus -->
                                <div class="modal fade" data-backdrop="false"  id="modalHapus<?= $p['id_pengguna']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
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
