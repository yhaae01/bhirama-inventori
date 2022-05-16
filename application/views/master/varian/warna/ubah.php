<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Warna</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Ubah Warna</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="id_warna" value="<?= $warna['id_warna'] ?>">
                                <div class="form-group">
                                    <label>Warna</label>
                                    <input type="text" class="form-control" name="nama_warna" value="<?= $warna['nama_warna'] ?>">
                                    <?= form_error('nama_warna', '<small class="text-danger">', '</small>') ?>
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
