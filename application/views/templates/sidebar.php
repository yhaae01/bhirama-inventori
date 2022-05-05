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
            <li class="menu-header">Role</li>
            <li class="active">
                <a class="nav-link" href="<?= base_url('dashboard') ?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <li class="dropdown active">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="<?= base_url('master/user') ?>"><span>Pengguna</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url('master/produk') ?>"><span>Produk</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url('master/supplier') ?>"><span>Supplier</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url() ?>"><span>Kategori</span></a>
                    </li>
                </ul>
            </li>
            <li class="dropdown active">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-boxes"></i> <span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="<?= base_url('transaksi/PurchaseOrder') ?>"><span>Purchase Order</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url() ?>"><span>Barang Keluar</span></a>
                    </li>
                </ul>
            </li>
            <!-- <li>
                <a class="nav-link" href="#"><i class="fas fa-list-check"></i><span>Purchase Order</span></a>
            </li>
            <li>
                <a class="nav-link" href="#"><i class="fas fa-hand-holding-usd"></i><span>Pengelolaan Pesanan</span></a>
            </li>
            <li>
                <a class="nav-link" href="#"><i class="fas fa-box"></i> <span>Retur Barang</span></a>
            </li> -->
            <li class="dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-print"></i> <span>Laporan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="<?= base_url('laporan/PurchaseOrder') ?>"><span>Purchase Order</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url('laporan/Pesanan') ?>"> <span>Pesanan</span></a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url('laporan/ReturBarang') ?>"> <span>Retur Barang</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
<!-- End Sidebar -->