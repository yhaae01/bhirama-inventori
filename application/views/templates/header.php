<!-- Header -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="<?= base_url('assets') ?>/img/bhirama-logo.png" type="image/icon type">
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets') ?>/vendor/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/style.css" />
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/mystyle.css" />
  <link rel="stylesheet" href="<?= base_url('assets/datatables') ?>/dataTables.bootstrap4.css" />
  <link rel="stylesheet" href="<?= base_url('assets/datatables') ?>/dataTables.dateTime.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/components.css" />
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/dropify.css" />
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/select2.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/select2.bootstrap.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@800&display=swap" rel="stylesheet">

  <?php if (isset($button)) { ?>
    <?php if ($button == 'Read' || $button == 'Print') { ?>
      <link rel="stylesheet" href="<?= base_url('assets') ?>/css/print.min.css" />
      <style>
        tr.bordered {
          border-bottom: 1px solid #000;
        }

        @media print {

          .noprint {
            display: none;
          }
        }

        @page {
          size: 100mm 150mm;
          margin: 0;
        }
      </style>
    <?php } ?>
  <?php } ?>
  <title><?= $title; ?></title>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <!-- End Header -->