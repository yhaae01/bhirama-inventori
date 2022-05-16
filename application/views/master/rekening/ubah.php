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
                            <h4>Ubah Rekening</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="id_rekening" value="<?= $rekening['id_rekening'] ?>">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama_pemilik" value="<?= $rekening['nama_pemilik'] ?>">
                                    <?= form_error('nama_pemilik', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label>Bank</label>
                                    <select class="form-control" name="bank">
                                        <option value="<?= $rekening['bank'] ?>"><?= $rekening['bank'] ?></option>
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
                                    <input type="number" class="form-control" name="nomor_rekening" value="<?= $rekening['nomor_rekening'] ?>">
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