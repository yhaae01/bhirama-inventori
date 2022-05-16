<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Varian</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <!-- Ukuran -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <div class="card-header">
                            <h4>Data Ukuran</h4>
                            <div class="card-header-action">
                                <a href="<?= base_url('master/varian/ukuranTambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Ukuran</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                            <tr>
                                                <th>Ukuran</th>
                                                <th>Action</th>
                                            </tr>
                                    </thead>
                                    <tbody> 
                                        <?php 
                                            foreach($ukuran as $u) : 
                                        ?>                        
                                        <tr>
                                            <td>
                                                <?= $u['nama_ukuran']; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('master/Varian/ukuranUbah/') . $u['id_ukuran'] ?>" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapusU<?= $u['id_ukuran']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Modal Hapus Ukuran -->
                                        <div class="modal fade" data-backdrop="false"  id="modalHapusU<?= $u['id_ukuran']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalHapusLabel">Hapus Ukuran</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= base_url('master/Varian/ukuranHapus/') . $u['id_ukuran']; ?>" method="post">
                                                        <div class="modal-body">
                                                            Yakin ingin hapus ukuran <strong> <?= $u['nama_ukuran']; ?> </strong> ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            endforeach
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warna -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Warna</h4>
                            <div class="card-header-action">
                                <a href="<?= base_url('master/varian/warnaTambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Warna</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                            <tr>
                                                <th>Warna</th>
                                                <th>Action</th>
                                            </tr>
                                    </thead>
                                    <tbody>                         
                                    <?php 
                                            foreach($warna as $w) : 
                                        ?>                        
                                        <tr>
                                            <td>
                                                <?= $w['nama_warna']; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('master/Varian/warnaUbah/') . $w['id_warna'] ?>" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapusW<?= $w['id_warna']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Modal Hapus -->
                                        <div class="modal fade" data-backdrop="false"  id="modalHapusW<?= $w['id_warna']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalHapusLabel">Hapus Warna</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= base_url('master/Varian/warnaHapus/') . $w['id_warna']; ?>" method="post">
                                                        <div class="modal-body">
                                                            Yakin ingin hapus warna <strong> <?= $w['nama_warna']; ?> </strong> ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            endforeach
                                        ?>
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
