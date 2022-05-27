<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                <div class="card-header">
                    <h4>Data Pengguna</h4>
                    <?php if ($user['role'] != 'CS') : ?>
                        <div class="card-header-action">
                            <?php echo anchor(site_url('master/Pengguna/create'), '<i class="fas fa-plus"></i> Tambah Pengguna', 'class="btn btn-primary"'); ?>
                            <?php echo anchor(site_url('master/Pengguna/excel'), '<i class="fas fa-file-excel"></i> Excel', 'class="btn btn-success"'); ?>
                            <?php echo anchor(site_url('master/Pengguna/word'), '<i class="fas fa-file-word"></i> Word', 'class="btn btn-info"'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->