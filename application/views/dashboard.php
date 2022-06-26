  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Data Hari Ini:</h1>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <?= $this->session->flashdata('message'); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-cash-register"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Pesanan</h4>
              </div>
              <div class="card-body"><?= $total_pesanan ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-dolly"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Terjual</h4>
              </div>
              <div class="card-body"><?= $total_terjual ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-box-open"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Pengembalian</h4>
              </div>
              <div class="card-body"><?= $total_pengembalian ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-inbox"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Dikembalikan</h4>
              </div>
              <div class="card-body"><?= $total_dikembalikan ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-truck-loading"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Barang Masuk</h4>
              </div>
              <div class="card-body"><?= $total_barangmasuk ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-people-carry"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Barang Masuk</h4>
              </div>
              <div class="card-body"><?= $total_detail_barangmasuk ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-undo"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Retur Barang</h4>
              </div>
              <div class="card-body"><?= $total_retur ?></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-trash-restore"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Retur Barang</h4>
              </div>
              <div class="card-body"><?= $total_retur_barang ?></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- End Main Content -->