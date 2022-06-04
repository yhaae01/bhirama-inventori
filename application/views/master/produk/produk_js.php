<script src="<?= base_url('assets/js/dropify.js') ?>"></script>
<script type="text/javascript">
    // mencegah form dialog -Confirm Form Resubmission- muncul
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    $('.dropify').dropify(); //inisialisasi dropify
    $(document).ready(function() {
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            bAutoWidth: false,
            ajax: {
                "url": "<?= base_url('master/Produk/json') ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id_produk",
                    "orderable": false,
                    "width": "10px"
                },
                {
                    "data": "image",
                    "orderable": false,
                    "className": "text-center",
                    "render": function(dataImage) {
                        if (dataImage == 'default.png') {
                            return '<img class="avatar" src="<?= base_url("assets/img/") ?>' + dataImage + '"height="75">'
                        } else {
                            return '<img class="avatar" src="<?= base_url("assets/img/produk/") ?>' + dataImage + '"height="75">'
                        }
                    }
                },
                {
                    "data": "nama_produk"
                },
                {
                    "data": "nama_kategori"
                },
                {
                    "data": "stok",
                    "class": "text-center",
                    "render": function(t) {
                        if (t == null) {
                            return '<b style="font-size:15px">0</b>'
                        } else {
                            return '<b style="font-size:15px">' + t + '</b>'
                        }
                    }
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        // end datatables


        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");


        <?php if ($button == 'Read') { ?>
            $('.dropify-filename-inner').html(''); //hilangkan namafile
        <?php }; ?>

        // munculkan select2 kategori selain di page read
        <?php if ($button != 'Read') { ?>
            // select2 kategori
            $('#id_kategori').select2({
                allowClear: true,
                placeholder: 'Pilih Kategori',
                language: {
                    "noResults": function() {
                        return "Kategori tidak ditemukan ! Silahkan tambahkan dahulu.";
                    }
                },
                ajax: {
                    dataType: "json",
                    type: "post",
                    url: "<?= base_url('master/Kategori/getKategori') ?>",
                    delay: 800,

                    data: function(params) {
                        return {
                            search: params.term || "",
                            page: params.page || 1
                        }
                    }
                }
            });
            // end select2 kategori


            // select2 Warna
            $('#id_warna').select2({
                allowClear: true,
                placeholder: 'Pilih Warna',
                language: {
                    "noResults": function() {
                        return "Warna tidak ditemukan ! Silahkan tambahkan dahulu.";
                    }
                },
                ajax: {
                    dataType: "json",
                    type: "post",
                    url: "<?= base_url('master/Warna/getWarna') ?>",
                    delay: 800,

                    data: function(params) {
                        return {
                            search: params.term || "",
                            page: params.page || 1
                        }
                    }
                }
            });
            // end select2 Warna


            // select2 Ukuran
            $('#id_ukuran').select2({
                allowClear: true,
                placeholder: 'Pilih Ukuran',
                language: {
                    "noResults": function() {
                        return "Ukuran tidak ditemukan ! Silahkan tambahkan dahulu.";
                    }
                },
                ajax: {
                    dataType: "json",
                    type: "post",
                    url: "<?= base_url('master/Ukuran/getUkuran') ?>",
                    delay: 800,

                    data: function(params) {
                        return {
                            search: params.term || "",
                            page: params.page || 1
                        }
                    }
                }
            });
            // end select2 Ukuran

            // handle input variasi
            $('#inputVariasi').submit(function(e) {
                e.preventDefault();
                let insertAction = '<?= base_url('master/DetailProduk/create_action') ?>'
                let datafull = $('#inputVariasi').serialize();
                let token_name = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').attr('name');
                let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
                let id_warna = $('#id_warna').val();
                let id_ukuran = $('#id_ukuran').val();
                let qty = $('#qty').val();

                // ajax 
                $.ajax({
                    url: insertAction,
                    dataType: "json",
                    data: datafull,
                    type: "post",

                    success: function(res) {
                        if (res.status == 'success') {

                            // reload dt
                            $('#tbl_detail_produk').DataTable().ajax.reload(null, false);
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            clear();
                        } else {
                            $(".error_warna").html(res.warna);
                            $(".error_ukuran").html(res.ukuran);
                            $(".error_qty").html(res.qty);
                            // reload dt
                            $('#tbl_detail_produk').DataTable().ajax.reload(null, false);
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        }

                    }
                });
            });
            // end of handle input variasi

            // button reset
            $('.btnReset').on('click', function() {
                clear();
            });

            function clear() {
                $("#id_warna").select2("val", " ");
                $("#id_ukuran").select2("val", " ");
                $('#qty').val("");
                $('.error_ukuran').html("");
                $('.error_warna').html("");
                $('.error_qty').html("");
            }

            function log(a) {
                console.log(a);
            }
        <?php }; ?>

        // dt detail produk
        var tbl_detail_produk = $("#tbl_detail_produk").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tbl_detail_produk_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            bFilter: false,
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            bAutoWidth: false,
            ajax: {
                "url": "<?= base_url('master/DetailProduk/json/') . $this->uri->segment(4) ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id_detail_produk",
                    "orderable": false,
                    "width": "10px"
                },
                {
                    "data": "nama_warna"
                },
                {
                    "data": "nama_ukuran"
                },
                {
                    "data": "qty"
                }
                // munculkan action selain di page read
                <?php if ($button != 'Read') { ?>,
                    {
                        "data": "action",
                        "orderable": false,
                        "className": "text-center"
                    }
                <?php }; ?>
            ],
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        // end dt detail produk

        <?php if ($button != 'Read') { ?>
            // handle delete detail produk
            $('#tbl_detail_produk').on('click', '.hapusDP', function(e) {
                e.preventDefault();
                // ambil url dari form action
                let deleteAction = $(this).parent().attr('action');
                let id = $(this).data('id');
                // ambil nama dan value csrf dari input hidden
                let token_name = $(this).siblings().attr('name');
                let token_hash = $(this).siblings().attr('value');

                // console.log($(this).siblings().attr('name'))

                if (confirm('Yakin akan hapus data ini')) {
                    // ajax request for delete detail produk
                    log(token_hash);
                    $.ajax({
                        url: deleteAction,
                        dataType: "JSON",
                        type: "POST",
                        data: {
                            '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                            'id': id
                        },
                        success: function(res) {
                            if (res.status == 'deleted') {
                                // refresh csrf
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                // reload dt
                                $('#tbl_detail_produk').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
            // end handle delete detail produk
        <?php }; ?>


    });
</script>