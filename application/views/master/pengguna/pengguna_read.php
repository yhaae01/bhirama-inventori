<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-header justify-content-center">
                    <h4 class="bold">Data Pengguna</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive d-flex justify-content-center">
                        <table style="width:50%;" class="table table-striped">
                            <tr align="center">
                                <td colspan="3">
                                    <img class="rounded" height="200" src="<?= base_url('assets/img/pengguna/') . $image; ?>" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td><?php echo $username; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Pengguna</td>
                                <td><?php echo $nama_pengguna; ?></td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td><?php echo $role; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center"><a href="<?php echo site_url('master/Pengguna') ?>" style="width: 50%;" class="btn btn-primary">OK</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>