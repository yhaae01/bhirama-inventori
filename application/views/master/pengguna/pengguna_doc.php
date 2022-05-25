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
        <h2>Pengguna List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Username</th>
		<th>Password</th>
		<th>Nama Pengguna</th>
		<th>Image</th>
		<th>Role</th>
		
            </tr><?php
            foreach ($pengguna_data as $pengguna)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $pengguna->username ?></td>
		      <td><?php echo $pengguna->password ?></td>
		      <td><?php echo $pengguna->nama_pengguna ?></td>
		      <td><?php echo $pengguna->image ?></td>
		      <td><?php echo $pengguna->role ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>