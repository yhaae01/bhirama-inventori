<script src="<?= base_url('assets/js/ajax_daerah.js') ?>"></script>
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
                "url": "<?= base_url('transaksi/Pesanan/json') ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id_pesanan",
                    "orderable": false,
                    "width": "10px"
                },
                {
                    "data": "nama_penerima"
                },
                {
                    "data": "status"
                },
                {
                    "data": "tgl_pesanan"
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

        // munculkan select2 produk selain di page read
        <?php if ($button != 'Read') { ?>
            // select2 produk
            $('#id_produk').select2({
                allowClear: true,
                placeholder: 'Pilih Produk',
                language: {
                    "noResults": function() {
                        return "Produk tidak ditemukan ! Silahkan tambahkan stoknya dahulu.";
                    }
                },
                ajax: {
                    dataType: "json",
                    type: "post",
                    url: "<?= base_url('transaksi/Pesanan/getProdukPesanan') ?>",
                    delay: 1000,

                    data: function(params) {
                        return {
                            search: params.term || "",
                            page: params.page || 1
                        }
                    }
                }
            });
            // end select2 produk

            // jika produk sudah dipilih, maka req warna yg tersedia
            $('#id_produk').on("select2:select", function(e) {
                let idProduk = $("#id_produk").val();
                let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
                // ajax req utk minta data warna ke tabel detail_produk
                $.ajax({
                    url: "<?= base_url('master/DetailProduk/getWarna') ?>",
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                        'id_produk': idProduk
                    },
                    success: function(res) {
                        // refresh csrf token
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        $("#id_warna").select2({
                            minimumResultsForSearch: -1,
                            'data': res.warna
                        })
                        // trigger agar langsung menjalankan pemilihan warna
                        $("#id_warna").trigger("select2:select");
                        $('.qtyLoad').html('');
                    }
                });
            });
            // end req warna yg tersedia

            // ketika produk di clear
            $('#id_produk').on("select2:clear", function() {
                $('.qtyLoad').html('');
            });

            // jika warna sudah dipilih, maka req ukuran yg tersedia
            $('#id_warna').on("select2:select", function(e) {
                let idProduk = $("#id_produk").val();
                let idWarna = $("#id_warna").val();
                let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
                // ajax req utk minta data warna ke tabel detail_produk
                $.ajax({
                    url: "<?= base_url('master/DetailProduk/getUkuran') ?>",
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                        'id_produk': idProduk,
                        'id_warna': idWarna
                    },
                    success: function(res) {
                        // refresh csrf token
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        $("#id_ukuran").select2({
                            minimumResultsForSearch: -1,
                            'data': res.ukuran
                        })
                    }
                });
            });
            // end req ukuran yg tersedia

            // kosongkan select2 warna dan ukuran saat produk berganti,
            // serta set kembali placeholder
            $('#id_produk').on("change", function(e) {
                $("#id_warna").empty();
                $("#id_ukuran").empty();
                $("#id_warna").select2({
                    placeholder: 'Pilih Warna'
                });
                $("#id_ukuran").select2({
                    placeholder: 'Pilih Ukuran'
                });
            });
            // ----------------------------

            // kosongkan select2 ukuran saat warna berganti,
            // serta set kembali placeholder
            $('#id_warna').on("change", function(e) {
                $("#id_ukuran").empty();
                $("#id_ukuran").select2({
                    placeholder: 'Pilih Ukuran'
                });
            });
            // ----------------------------


            // setiap ada perubahan nilai pada ukuran
            $('#id_ukuran').change(function() {
                let idProduk = $("#id_produk").val();
                let idWarna = $("#id_warna").val();
                let idUkuran = $(this).val();
                let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
                // jika value produk dan warna memiliki nilai
                if (idProduk != "" && idWarna != "") {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: '<?= base_url("master/DetailProduk/getQty") ?>',
                        data: {
                            'id_produk': idProduk,
                            'id_warna': idWarna,
                            'id_ukuran': idUkuran,
                            '<?= $this->security->get_csrf_token_name() ?>': token_hash
                        },
                        beforeSend: function() {
                            $('.qtyLoad').html('Tersedia: ...')
                        },
                        success: function(res) {
                            if (res.status != 'Gagal') {
                                $('.qtyLoad').html('Tersedia: <b>' + res.qty.qty + '</b>');
                                // atur atribut max pada qty
                                $('#qty').attr('max', res.qty.qty);
                                $('#qty').attr('value', 0);
                                // refresh csrf
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            }
                        }
                    });
                }
            });
            // end setiap perubahan pada ukuran

            // ketika cursor fokus ke QTY
            $('#qty').focus(function() {
                let idProduk = $("#id_produk").val();
                let idWarna = $("#id_warna").val();
                let idUkuran = $("#id_ukuran").val();
                let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
                // jika value produk dan warna memiliki nilai
                if (idProduk != "" && idWarna != "" && idUkuran != "") {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: '<?= base_url("master/DetailProduk/getQty") ?>',
                        data: {
                            'id_produk': idProduk,
                            'id_warna': idWarna,
                            'id_ukuran': idUkuran,
                            '<?= $this->security->get_csrf_token_name() ?>': token_hash
                        },
                        beforeSend: function() {
                            $('.qtyLoad').html('Tersedia: ...')
                        },
                        success: function(res) {
                            if (res.status != 'Gagal') {
                                $('.qtyLoad').html('Tersedia: <b>' + res.qty.qty + '</b>');
                                // atur atribut max pada qty
                                $('#qty').attr('max', res.qty.qty);
                                $('#qty').attr('value', "");
                                // refresh csrf
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            }
                        }
                    });
                }
            });
            // end focus qty

            // select2 Warna
            let warna = $('#id_warna').select2({
                minimumResultsForSearch: -1,
                allowClear: true,
                placeholder: 'Pilih Warna'
            });
            // end select2 Warna


            // select2 Ukuran
            $('#id_ukuran').select2({
                minimumResultsForSearch: -1,
                allowClear: true,
                placeholder: 'Pilih Ukuran'
            });
            // end select2 Ukuran

            // // handle input variasi
            // $('#inputVariasi').submit(function(e) {
            //     e.preventDefault();
            //     let insertAction = '<?= base_url('master/DetailProduk/create_action') ?>'
            //     let datafull = $('#inputVariasi').serialize();
            //     let token_name = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').attr('name');
            //     let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
            //     let id_warna = $('#id_warna').val();
            //     let id_ukuran = $('#id_ukuran').val();
            //     let qty = $('#qty').val();

            //     // ajax 
            //     $.ajax({
            //         url: insertAction,
            //         dataType: "json",
            //         data: datafull,
            //         type: "post",

            //         success: function(res) {
            //             if (res.status == 'success') {

            //                 // reload dt
            //                 $('#tbl_detail_produk').DataTable().ajax.reload(null, false);
            //                 // refresh csrf
            //                 $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
            //                 clear();
            //             } else {
            //                 $(".error_warna").html(res.warna);
            //                 $(".error_ukuran").html(res.ukuran);
            //                 $(".error_qty").html(res.qty);
            //                 // reload dt
            //                 $('#tbl_detail_produk').DataTable().ajax.reload(null, false);
            //                 // refresh csrf
            //                 $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
            //             }

            //         }
            //     });
            // });
            // // end of handle input variasi

            // // button reset
            // $('.btnReset').on('click', function() {
            //     clear();
            // });

            // function clear() {
            //     $("#id_warna").select2("val", " ");
            //     $("#id_ukuran").select2("val", " ");
            //     $('#qty').val("");
            //     $('.error_ukuran').html("");
            //     $('.error_warna').html("");
            //     $('.error_qty').html("");
            // }

            function log(a) {
                console.log(a);
            }
        <?php }; ?>

        // dt detail pesanan
        var tbl_detail_pesanan = $("#detail_pesanan").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#detail_pesanan_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            bFilter: false,
            info: false,
            paging: false,
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            bAutoWidth: false,
            bLengthChange: false,
            ajax: {
                "url": "<?= base_url('transaksi/DetailPesanan/json') ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false,
                    "width": "10px",
                    "className": "text-center"
                },
                {
                    "data": "nama_produk",
                    "orderable": false,
                    "className": "text-left",
                    "render": function(data, type, full) {
                        return full['nama_produk'] + ' / ' + full['nama_warna'] + ' / ' + full['nama_ukuran'];
                    }
                },
                {
                    "data": "nama_warna",
                    "orderable": false,
                    "visible": false
                },
                {
                    "data": "nama_ukuran",
                    "orderable": false,
                    "visible": false
                },
                {
                    "data": "qty",
                    "className": "text-center",
                    "orderable": false,
                },
                {
                    "data": "sub_total",
                    "className": "text-right",
                    "orderable": false
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
        // end dt detail pesanan

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