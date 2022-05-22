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
        <h2>Produk List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id Kategori</th>
		<th>Id Ukuran</th>
		<th>Id Warna</th>
		<th>Nama Produk</th>
		<th>Image</th>
		<th>Qty</th>
		<th>Harga</th>
		<th>Tanggal</th>
		
            </tr><?php
            foreach ($produk_data as $produk)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $produk->id_kategori ?></td>
		      <td><?php echo $produk->id_ukuran ?></td>
		      <td><?php echo $produk->id_warna ?></td>
		      <td><?php echo $produk->nama_produk ?></td>
		      <td><?php echo $produk->image ?></td>
		      <td><?php echo $produk->qty ?></td>
		      <td><?php echo $produk->harga ?></td>
		      <td><?php echo $produk->tanggal ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>