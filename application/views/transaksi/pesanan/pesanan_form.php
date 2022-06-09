<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pesanan</h1>
            <input type="text" class="form-control" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
        </div>
        <div class="section-body">
            <!-- Baris 1 -->
            <div class="row">
                <!-- Pesanan -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Pesanan</h4>
                        </div>
                        <div class="card-body">
                            <form id="inputKeranjang" method="post">
                                <input type="text" class="form-control" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <select class="form-control" name="id_produk" id="id_produk">
                                        <option></option>
                                    </select>
                                    <span class="text-danger error_produk"></span>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Warna</label>
                                            <select class="form-control" name="id_warna" id="id_warna">
                                                <option></option>
                                            </select>
                                            <span class="text-danger error_warna"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Ukuran</label>
                                            <select class="form-control" name="id_ukuran" id="id_ukuran">
                                            </select>
                                            <span class="text-danger error_ukuran"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>QTY</label>
                                            <input type="number" name="qty" id="qty" min="0" class="form-control">
                                            <span class="text-primary qtyLoad"></span>
                                            <span class="text-danger error_qty"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="number" name="harga" id="harga" class="form-control">
                                            <span class="text-primary hargaLoad"></span>
                                            <span class="text-danger error_harga"></span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- Detail -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Pesanan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="detail_pesanan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th colspan="3">Produk</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
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

            <!-- Detail Pelanggan -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Pengirim</label>
                                            <select class="form-control" name="pengirim" id="pengirim">
                                            </select>
                                        </div>
                                        <span class="text-danger error_pengirim"></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Penerima</label>
                                            <input type="text" class="form-control" name="penerima" id="penerima">
                                        </div>
                                        <span class="text-danger error_penerima"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <select name="provinsi" id="provinsi" class="form-control">
                                            </select>
                                        </div>
                                        <span class="text-danger error_provinsi"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Kota / Kabupaten</label>
                                            <select name="kab" id="kab" class="form-control">
                                            </select>
                                        </div>
                                        <span class="text-danger error_kab"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Kecamatan</label>
                                            <select name="kec" id="kec" class="form-control">
                                            </select>
                                        </div>
                                        <span class="text-danger error_kec"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Kelurahan</label>
                                            <select name="kel" id="kel" class="form-control">
                                            </select>
                                            <span class="text-danger error_kec"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        <span class="text-danger error_alamat"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Kode Pos</label>
                                            <input type="number" name="kodepos" id="kodepos" class="form-control">
                                        </div>
                                        <span class="text-danger error_kodepos"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>No. Handphone</label>
                                            <input type="number" name="no_telp" id="no_telp" class="form-control">
                                        </div>
                                        <span class="text-danger error_no_telp"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Metode Pembayaran</label>
                                            <select name="mp" id="mp" class="form-control">
                                            </select>
                                            <span class="text-danger error_mp"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Kurir</label>
                                            <select name="kurir" id="kurir" class="form-control">
                                            </select>
                                        </div>
                                        <span class="text-danger error_kurir"></span>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Ongkir</label>
                                            <input type="number" min="0" class="form-control" name="ongkir" id="ongkir">
                                        </div>
                                        <span class="text-danger error_ongkir"></span>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea name="ket" class="form-control" id="ket" cols="30" rows="10"></textarea>
                                        </div>
                                        <span class="text-danger error_ket"></span>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            <!-- <button class="btn btn-secondary" type="reset"><i class="fas fa-undo"></i> Reset</button> -->
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Detail Pelanggan -->
        </div>
    </section>
</div>
<!-- End Main Content -->

<!-- Float Button -->
<a href="#ongkir" title="Cek Ongkir" data-target="#ongkir" data-toggle="modal" class="float">
    <i class="fa fa-search my-float"></i>
</a>

<!-- Modal Cek Ongkir -->
<div class="modal fade" id="ongkir" tabindex="-1" role="dialog" aria-labelledby="ongkirLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ongkirLabel">Periksa Ongkir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div data-theme="light" id="rajaongkir-widget"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Daerah Indonesia -->

<!-- Widget Ongkir -->
<script src="<?= base_url('assets') ?>/js/widgetongkir.js"></script>