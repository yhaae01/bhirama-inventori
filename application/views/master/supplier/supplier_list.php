<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Supplier</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                <div class="card-header">
                    <h4>Data Supplier</h4>
                    <div class="card-header-action">
                        <?php echo anchor(site_url('master/Supplier/create'), '<i class="fas fa-plus"></i> Tambah Supplier', 'class="btn btn-primary"'); ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <input class="form-control" type="text" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <table class="table table-hover table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th colspan="3">Action</th>
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