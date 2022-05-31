<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Rekening</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="card-header">
                            <h4>Data Rekening</h4>
                            <?php if ($user['role'] != 'CS') : ?>
                                <div class="card-header-action">
                                    <?php echo anchor(site_url('master/Rekening/create'), '<i class="fas fa-plus"></i> Tambah Rekening', 'class="btn btn-primary"'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="mytable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pemilik</th>
                                            <th>Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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