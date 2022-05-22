<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ukuran</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Ukuran</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('master/Varian/ukuranTambah'); ?>" method="post">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <div class="form-group">
                                    <label>Ukuran</label>
                                    <input type="text" class="form-control" name="nama_ukuran" value="<?= set_value('nama_ukuran') ?>">
                                    <?= form_error('nama_ukuran', '<small class="text-danger">', '</small>') ?>
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