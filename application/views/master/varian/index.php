<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Varian</h1>
        </div>

        <!-- Pesan Eror -->
        <div class="row">
            <div class="col-lg-6">
                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                        <?= validation_errors(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <!-- Ukuran -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="card-header">
                            <h4>Data Ukuran</h4>
                            <div class="card-header-action">
                                <a href="#" data-toggle="modal" data-target="#modalTambahU" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Ukuran
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Ukuran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($ukuran as $u) :
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $u['nama_ukuran']; ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="modal" data-target="#modalUbahU<?= $u['id_ukuran']; ?>" title="Ubah">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapusU<?= $u['id_ukuran']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <!-- Modal Tambah ukuran -->
                                            <div class="modal fade" data-backdrop="false" id="modalTambahU" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalTambahLabel">Tambah Ukuran</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/Varian/ukuranTambah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                            <div class="form-group">
                                                                <label>Ukuran</label>
                                                                <input type="text" class="form-control" name="nama_ukuran" id="nama_ukuran" value=" <?= set_value('nama_ukuran') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal ubah ukuran -->
                                            <div class="modal fade" data-backdrop="false" id="modalUbahU<?= $u['id_ukuran']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalUbahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalUbahLabel">Ubah Ukuran</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/Varian/ukuranUbah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                            <div class="form-group">
                                                                <input type="hidden" name="id_ukuran" value="<?= $u['id_ukuran'] ?>">
                                                                <label>Ukuran</label>

                                                                <input type="text" class="form-control" name="nama_ukuran" id="nama_ukuran" value="<?= $u['nama_ukuran'] ?>">
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

                                            <!-- Modal Hapus Ukuran -->
                                            <div class="modal fade" data-backdrop="false" id="modalHapusU<?= $u['id_ukuran']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalHapusLabel">Hapus Ukuran</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="<?= base_url('master/Varian/ukuranHapus/') . $u['id_ukuran']; ?>" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                                Yakin ingin hapus ukuran <strong> <?= $u['nama_ukuran']; ?> </strong> ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
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

                <!-- Warna -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Warna</h4>
                            <div class="card-header-action">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahW"><i class="fas fa-plus"></i> Tambah Warna</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Warna</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($warna as $w) :
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $w['nama_warna']; ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="modal" data-target="#modalUbahW<?= $w['id_warna']; ?>" title="Ubah">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapusW<?= $w['id_warna']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <!-- Modal tambah warna -->
                                            <div class="modal fade" data-backdrop="false" id="modalTambahW" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalTambahLabel">Tambah Warna</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/Varian/warnaTambah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                            <div class="form-group">
                                                                <label>Warna</label>
                                                                <input type="text" class="form-control" name="nama_warna" id="nama_warna" value=" <?= set_value('nama_warna') ?>">
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

                                            <!-- Modal ubah warna -->
                                            <div class="modal fade" data-backdrop="false" id="modalUbahW<?= $w['id_warna']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalUbahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalUbahLabel">Ubah Warna</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/Varian/warnaUbah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                            <div class="form-group">
                                                                <input type="hidden" name="id_warna" value="<?= $w['id_warna'] ?>">
                                                                <label>Warna</label>

                                                                <input type="text" class="form-control" name="nama_warna" id="nama_warna" value="<?= $w['nama_warna'] ?>">
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

                                            <!-- Modal Hapus Warna -->
                                            <div class="modal fade" data-backdrop="false" id="modalHapusW<?= $w['id_warna']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalHapusLabel">Hapus Warna</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="<?= base_url('master/Varian/warnaHapus/') . $w['id_warna']; ?>" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                                Yakin ingin hapus warna <strong> <?= $w['nama_warna']; ?> </strong> ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
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