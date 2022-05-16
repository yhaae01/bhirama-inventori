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
                            <div class="card-header-action">
                                <a href="<?= base_url('master/Rekening/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Rekening</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($rekening as $r) : 
                                        ?> 
                                        <tr>
                                            <td>
                                                <?= $r['nama_pemilik']; ?>
                                            </td>
                                            <td>
                                                <?= $r['bank']; ?>
                                            </td>
                                            <td>
                                                <?= $r['nomor_rekening']; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('master/Rekening/ubah/') . $r['id_rekening'] ?>" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#modalHapus<?= $r['id_rekening']; ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Modal Hapus -->
                                        <div class="modal fade" data-backdrop="false"  id="modalHapus<?= $r['id_rekening']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalHapusLabel">Hapus Rekening</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?= base_url('master/rekening/hapus/') . $r['id_rekening']; ?>" method="post">
                                                    <div class="modal-body">
                                                        Yakin ingin hapus rekening <strong> <?= $r['bank'] ?> - <?= $r['nomor_rekening']; ?> </strong> ?
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