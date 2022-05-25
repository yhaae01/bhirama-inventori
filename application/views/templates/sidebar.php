<!-- Sidebar -->
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url('dashboard') ?>">Bhirama Inventori</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url('dashboard') ?>">BI</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Role: <?= strtoupper($user['role']); ?></li>
            <li class="<?= (strpos(current_url(), "dashboard") !== false) ? "active" : ""; ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <?php $level = $this->session->userdata('role'); ?>
            <?php if ($user['role'] == 'admin' or $user['role'] == 'CS') : ?>
                <li class="dropdown <?= (strpos(current_url(), "master") !== false) ? "active" : ""; ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Master</span></a>
                    <ul class="dropdown-menu">
                        <?php if ($user['role'] != 'CS') : ?>
                            <li class="<?= (strpos(current_url(), "Pengguna") !== false) ? "active" : ""; ?>">
                                <a class="nav-link" href="<?= base_url('master/Pengguna') ?>"><span>Pengguna</span></a>
                            </li>
                        <?php endif; ?>

                        <li class="<?= (strpos(current_url(), "Produk") !== false) ? "active" : ""; ?>">
                            <a class="nav-link" href="<?= base_url('master/Produk') ?>"><span>Produk</span></a>
                        </li>

                        <?php if ($user['role'] != 'CS') : ?>
                            <li class="<?= (strpos(current_url(), "Supplier") !== false) ? "active" : ""; ?>">
                                <a class="nav-link" href="<?= base_url('master/Supplier') ?>"><span>Supplier</span></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($user['role'] != 'CS') : ?>
                            <li class="<?= (strpos(current_url(), "Kategori") !== false) ? "active" : ""; ?>">
                                <a class="nav-link" href="<?= base_url('master/Kategori') ?>"><span>Kategori</span></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($user['role'] != 'CS') : ?>
                            <li class="<?= (strpos(current_url(), "Varian") !== false) ? "active" : ""; ?>">
                                <a class="nav-link" href="<?= base_url('master/Varian') ?>"><span>Varian</span></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($user['role'] != 'CS') : ?>
                            <li class="<?= (strpos(current_url(), "Rekening") !== false) ? "active" : ""; ?>">
                                <a class="nav-link" href="<?= base_url('master/Rekening') ?>"><span>Rekening</span></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($user['role'] != 'CS') : ?>
                            <li class="<?= (strpos(current_url(), "Pengirim") !== false) ? "active" : ""; ?>">
                                <a class="nav-link" href="<?= base_url('master/Pengirim') ?>"><span>Pengirim</span></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <li class="dropdown <?= (strpos(current_url(), "transaksi") !== false) ? "active" : ""; ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-boxes"></i> <span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    <?php if ($user['role'] != 'CS') : ?>
                        <li class="<?= (strpos(current_url(), "BarangMasuk") !== false) ? "active" : ""; ?>">
                            <a class="nav-link" href="<?= base_url('transaksi/BarangMasuk') ?>"><span>Barang Masuk</span></a>
                        </li>
                    <?php endif ?>

                    <li class="<?= (strpos(current_url(), "Pesanan") !== false) ? "active" : ""; ?>">
                        <a class="nav-link" href="<?= base_url('transaksi/Pesanan') ?>"><span>Pesanan</span></a>
                    </li>


                    <?php if ($user['role'] != 'CS') : ?>
                        <li class="<?= (strpos(current_url(), "ReturBarang") !== false) ? "active" : ""; ?>">
                            <a class="nav-link" href="<?= base_url('transaksi/ReturBarang') ?>"><span>Retur Barang</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>

            <?php if ($user['role'] != 'gudang' and $user['role'] != 'CS') : ?>
                <li class="dropdown class=<?= (strpos(current_url(), "laporan") !== false) ? "active" : ""; ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-print"></i> <span>Laporan</span></a>
                    <ul class="dropdown-menu">
                        <li class="<?= (strpos(current_url(), "laporan/BarangMasuk") !== false) ? "active" : ""; ?>">
                            <a class="nav-link" href="<?= base_url('laporan/BarangMasuk') ?>"><span>Barang Masuk</span></a>
                        </li>
                        <li class="<?= (strpos(current_url(), "laporan/Pesanan") !== false) ? "active" : ""; ?>">
                            <a class="nav-link" href="<?= base_url('laporan/Pesanan') ?>"> <span>Pesanan</span></a>
                        </li>
                        <li class="<?= (strpos(current_url(), "laporan/ReturBarang") !== false) ? "active" : ""; ?>">
                            <a class="nav-link" href="<?= base_url('laporan/ReturBarang') ?>"> <span>Retur Barang</span></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </aside>
</div>
<!-- End Sidebar -->