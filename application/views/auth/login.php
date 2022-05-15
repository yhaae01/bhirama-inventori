<!-- Header -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets') ?>/vendor/fontawesome/css/all.min.css" />

    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/style.css" />
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/components.css" />
    <title>Dashboard</title>
  </head>
  <!-- End Header -->
  <body>
    <div id="app">
      <section class="section">
        <div class="container mt-5">
          <div class="row">
            <div
              class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4"
            >
              <div class="login-brand">
                <img
                  src="<?= base_url('assets') ?>/img/Bhirama1.png"
                  alt="logo"
                  width="300"
                />
              </div>

              <div class="card card-primary">
                <div class="card-header"><h4>Login</h4></div>

                <div class="card-body">
                  <form
                    method="POST"
                    action="#"
                    class="needs-validation"
                    novalidate=""
                  >
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input
                        id="username"
                        type="text"
                        class="form-control"
                        name="username"
                        tabindex="1"
                        required
                        autofocus
                      />
                    </div>

                    <div class="form-group">
                      <div class="d-block">
                        <label for="password" class="control-label"
                          >Password</label
                        >
                      </div>
                      <input
                        id="password"
                        type="password"
                        class="form-control"
                        name="password"
                        tabindex="2"
                        required
                      />
                    </div>

                    <div class="form-group">
                      <button
                        type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        tabindex="4"
                      >
                        Login
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="simple-footer">
                Copyright &copy; <?= date('Y') ?>
                <div class="bullet"></div>
                Bhirama Inventori
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <script src="<?= base_url('assets') ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/popper.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/jquery.nicescroll.min.js"></script>

    <script src="<?= base_url('assets') ?>/js/stisla.js"></script>
    <script src="<?= base_url('assets') ?>/js/scripts.js"></script>
    <script src="<?= base_url('assets') ?>/js/custom.js"></script>
  </body>
</html>
<!-- End Footer -->
