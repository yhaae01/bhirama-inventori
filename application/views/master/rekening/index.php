<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekening</h1>
        </div>

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
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="card-header">
                            <h4>Data Rekening</h4>
                            <div class="card-header-action">
                                <a href="#" data-toggle="modal" data-target="#modalTambah" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Rekening</a>

                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($rekening as $r) :
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= $r['nama_pemilik']; ?>
                                                </td>
                                                <td>
                                                    <?= $r['bank']; ?>
                                                </td>
                                                <td>
                                                    <?= $r['nomor_rekening']; ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="modal" data-target="#modalUbah<?= $r['id_rekening']; ?>" title="Ubah">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapus<?= $r['id_rekening']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <!-- Modal tambah rekening -->
                                            <div class="modal fade" data-backdrop="false" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalTambahLabel">Tambah Rekening</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/Rekening/tambah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />

                                                            <div class="form-group">
                                                                <label>Nama</label>
                                                                <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" value=" <?= set_value('nama_pemilik') ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Bank</label>
                                                                <select class="form-control" name="bank" value="<?= set_value('bank') ?>">
                                                                    <option value="">-- Pilih Bank --</option>
                                                                    <option name="bank" value="BCA">BCA</option>
                                                                    <option name="bank" value="BNI">BNI</option>
                                                                    <option name="bank" value="BRI">BRI</option>
                                                                    <option name="bank" value="MANDIRI">MANDIRI</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Nomor Rekening</label>
                                                                <input type="number" class="form-control" name="nomor_rekening" value="<?= set_value('nomor_rekening') ?>">
                                                            </div>

                                                            <div class=" modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal ubah rekening -->
                                            <div class="modal fade" data-backdrop="false" id="modalUbah<?= $r['id_rekening']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalUbahLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalUbahLabel">Ubah Warna</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo form_open_multipart('master/Rekening/ubah'); ?>
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                                            <div class="form-group">
                                                                <input type="hidden" name="id_rekening" value="<?= $r['id_rekening'] ?>">

                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <input type="text" class="form-control" name="nama_pemilik" id="nama_pemilik" value=" <?= $r['nama_pemilik'] ?>">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="position">Bank</label>
                                                                    <select class="form-control" name="bank" value="<?= set_value('bank') ?>">
                                                                        <option value="">-- Pilih Bank --</option>
                                                                        <?php foreach ($bank as $b) : ?>
                                                                            <?php if ($b == $r['bank']) : ?>
                                                                                <option value="<?= $b; ?>" selected>
                                                                                    <?= $b; ?>
                                                                                </option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $b; ?>">
                                                                                    <?= $b; ?>
                                                                                </option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Nomor Rekening</label>
                                                                    <input type="number" class="form-control" name="nomor_rekening" value="<?= $r['nomor_rekening'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-sm btn-primary">Ubah</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Modal Hapus -->
                                            <div class="modal fade" data-backdrop="false" id="modalHapus<?= $r['id_rekening']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalHapusLabel">Hapus Rekening</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="<?= base_url('master/rekening/hapus/') . $r['id_rekening']; ?>" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />

                                                                Yakin ingin hapus rekening <strong> <?= $r['bank'] ?> - <?= $r['nomor_rekening']; ?> </strong> ?
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