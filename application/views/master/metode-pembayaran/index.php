<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Metode Pembayaran</h1>
        </div>

        <!-- Pesan Eror -->
        <div class="row">
            <div class="col-lg-6">
                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?= validation_errors(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="card-header">
                            <h4>Data Metode Pembayaran</h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"><i class="fas fa-plus"></i> Tambah Metode Pembayaran</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Metode Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($metodePembayaran as $mp) :
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $mp['nama_metodePembayaran']; ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="modal" data-target="#modalUbah<?= $mp['id_metodePembayaran']; ?>" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" data-toggle="modal" data-target="#modalHapus<?= $mp['id_metodePembayaran']; ?>" class="btn btn-danger btn-action" title="Hapus"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <!-- Modal tambah metode pembayaran -->
                                            <div class="modal fade" data-backdrop="false" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalTambahLabel">Tambah Metode Pembayaran</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/MetodePembayaran/tambah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                            <div class="form-group">
                                                                <label>Metode Pembayaran</label>
                                                                <input type="text" class="form-control" name="nama_metodePembayaran" id="nama_metodePembayaran">
                                                            </div>
                                                        </div>
                                                        <div class=" modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal ubah metode pembayaran -->
                                            <div class="modal fade" data-backdrop="false" id="modalUbah<?= $mp['id_metodePembayaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalUbahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalUbahLabel">Ubah Metode Pembayaran</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/MetodePembayaran/ubah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                            <div class="form-group">
                                                                <input type="hidden" name="id_metodePembayaran" value="<?= $mp['id_metodePembayaran'] ?>">
                                                                <label>Metode Pembayaran</label>

                                                                <input type="text" class="form-control" name="nama_metodePembayaran" id="nama_metodePembayaran" value="<?= $mp['nama_metodePembayaran'] ?>">
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

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" data-backdrop="false" id="modalHapus<?= $mp['id_metodePembayaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalHapusLabel">Hapus Metode Pembayaran</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="<?= base_url('master/MetodePembayaran/hapus/') . $mp['id_metodePembayaran']; ?>" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                                Yakin ingin hapus Metode Pembayaran <strong> <?= $mp['nama_metodePembayaran']; ?> </strong> ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endforeach
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->