<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Pesanan</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="mb-2 mt-0">
                                    <tr>
                                        <td>Dari</td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id="dariTgl" class="form-control">
                                        </td>
                                        <td></td>
                                        <td>Sampai</td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" id="sampaiTgl" class="form-control">
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <input type="submit" value="Ok" id="filterTgl" class="btn btn-primary">
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <form action="<?= base_url('laporan/Pesanan/exportPDF') ?>" method="post" id="formRangeDate">
                                                <input type="hidden" name="dariTgl" class="form-control">
                                                <input type="hidden" name="sampaiTgl" class="form-control">
                                                <button type="submit" id="exportPdf" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-hover" id="mytable">
                                    <thead>
                                        <tr>
                                            <th>ID Pesanan</th>
                                            <th>Tanggal Pesanan</th>
                                            <th>Penerima</th>
                                            <th>Status</th>
                                            <th>Admin</th>
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