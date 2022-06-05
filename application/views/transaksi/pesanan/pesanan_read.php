<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Pesanan Read</h2>
        <table class="table">
	    <tr><td>Id Pengirim</td><td><?php echo $id_pengirim; ?></td></tr>
	    <tr><td>Id Kurir</td><td><?php echo $id_kurir; ?></td></tr>
	    <tr><td>Id MetodePembayaran</td><td><?php echo $id_metodePembayaran; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td>Penerima</td><td><?php echo $penerima; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>No Telp</td><td><?php echo $no_telp; ?></td></tr>
	    <tr><td>Tgl Pesanan</td><td><?php echo $tgl_pesanan; ?></td></tr>
	    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('pesanan') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>