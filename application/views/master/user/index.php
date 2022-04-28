<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>User</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Data User</h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('master/user/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Foto</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                            </thead>
                            <tbody>                         
                                <tr>
                                    <td>
                                        Surya Intan Permana
                                    </td>
                                    <td>surya123</td>
                                    <td>
                                        <img src="<?= base_url('assets/img/default.png') ?>" alt="avatar" width="30" class="rounded-circle mr-1">
                                    </td>
                                    <td>
                                        Admin
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="#" class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
