<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">                     
                        <img alt="image" src="<?= base_url('assets/img/default.png') ?>" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">Nama</div>
                                <div class="profile-widget-item-label">Username</div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">Role <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> Admin</div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <form method="post" action="">
                        <div class="card-header">
                            <h4>Ubah Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">                               
                                <div class="form-group col-md-6 col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="">Foto</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Pilih foto</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 col-12">
                                    <label>Password Lama</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-12 col-12">
                                    <label>Password Baru</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-12 col-12">
                                    <label>Ulangi Password</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
