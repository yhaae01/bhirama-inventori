<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekening</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Rekening</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('master/Rekening/tambah'); ?>" method="post">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama_pemilik" value="<?= set_value('nama_pemilik') ?>">
                                    <?= form_error('nama_pemilik', '<small class="text-danger">', '</small>') ?>
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
                                    <?= form_error('bank', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <input type="number" class="form-control" name="nomor_rekening" value="<?= set_value('nomor_rekening') ?>">
                                    <?= form_error('nomor_rekening', '<small class="text-danger">', '</small>') ?>
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