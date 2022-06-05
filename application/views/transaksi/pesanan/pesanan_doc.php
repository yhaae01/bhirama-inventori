<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Pesanan List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id Pengirim</th>
		<th>Id Kurir</th>
		<th>Id MetodePembayaran</th>
		<th>Status</th>
		<th>Penerima</th>
		<th>Alamat</th>
		<th>No Telp</th>
		<th>Tgl Pesanan</th>
		<th>Keterangan</th>
		
            </tr><?php
            foreach ($pesanan_data as $pesanan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $pesanan->id_pengirim ?></td>
		      <td><?php echo $pesanan->id_kurir ?></td>
		      <td><?php echo $pesanan->id_metodePembayaran ?></td>
		      <td><?php echo $pesanan->status ?></td>
		      <td><?php echo $pesanan->penerima ?></td>
		      <td><?php echo $pesanan->alamat ?></td>
		      <td><?php echo $pesanan->no_telp ?></td>
		      <td><?php echo $pesanan->tgl_pesanan ?></td>
		      <td><?php echo $pesanan->keterangan ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>