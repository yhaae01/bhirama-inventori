<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Varian</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <!-- Ukuran -->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="card-header">
                            <h4>Data Ukuran</h4>
                            <div class="card-header-action">
                                <?php echo anchor(site_url('master/Ukuran/create'), '<i class="fas fa-plus"></i> Tambah Ukuran', 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="mytable_ukuran">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Ukuran</th>
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
                <!-- End Ukuran -->


                <!-- Warna -->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Warna</h4>
                            <div class="card-header-action">
                                <?php echo anchor(site_url('master/Warna/create'), '<i class="fas fa-plus"></i> Tambah Warna', 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="mytable_warna">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Warna</th>
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
                <!-- End Warna -->

            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->