        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-left">
                Copyright © <?= date('Y') ?>
                <div class="bullet"></div>
                Bhirama Inventori
            </div>
            <div class="footer-right">ahsuka</div>
        </footer>
      </div>
    </div>

    <script src="<?= base_url('assets') ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/popper.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/jquery.nicescroll.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/stisla.js"></script>

    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('keterangan');
    </script>
    <script>
        CKEDITOR.replace('alamat');
    </script>
    
    <script src="<?= base_url('assets') ?>/js/scripts.js"></script>
    <script src="<?= base_url('assets') ?>/js/custom.js"></script>

    <!-- Sweetalert2 -->
    <script src="<?= base_url('assets') ?>/vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('assets') ?>/js/mysweet.js"></script>
  </body>
</html>
<!-- End Footer -->