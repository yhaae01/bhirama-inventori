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
                tags: true,
                placeholder: 'Pilih Kategori',
                templateSelection: function(state) {
                    if (!state.id) {
                        return state.text;
                    }
                    let text = state.text.replace('Tambah kategori: ', '');
                    return text;
                },
                createTag: function(params) {
                    if (params.result.length == 0) {
                        console.log(params.result)
                        if (params.term === '') {
                            return null;
                        }
                        let term = $.trim(params.term).replace(/\b[a-z]/g, function(l) {
                            return l.toUpperCase();
                        });
                        return {
                            id: term,
                            text: 'Tambah kategori: ' + term
                        }
                    }
                },
                language: {
                    searching: function() {
                        return "Tunggu...";
                    },
                    noResults: function() {
                        return "Kategori tidak ditemukan !";
                    }
                },
                ajax: {
                    dataType: "json",
                    type: "post",
                    url: "<?= base_url('master/Kategori/getKategori') ?>",
                    delay: 1000,

                    data: function(params) {
                        return {
                            search: params.term || "",
                            page: params.page || 1
                        }
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        params.result = data.results;
                        return {
                            results: data.results,
                            pagination: {
                                "more": (params.page * 5) < data.count_filtered
                            }
                        };
                    }
                }
            });
            $('#id_kategori').on("select2:clear", function() {
                $('#id_kategori').empty();
            });
            // end select2 kategori



            // select2 Warna
            $('#id_warna').select2({
                allowClear: true,
                tags: true,
                placeholder: 'Pilih Warna',
                templateSelection: function(state) {
                    if (!state.id) {
                        return state.text;
                    }
                    let text = state.text.replace('Tambah warna: ', '');
                    return text;
                },
                createTag: function(params) {
                    if (params.result.length == 0) {
                        if (params.term === '') {
                            return null;
                        }
                        let term = $.trim(params.term).replace(/\b[a-z]/g, function(l) {
                            return l.toUpperCase();
                        });
                        return {
                            id: term,
                            text: 'Tambah warna: ' + term
                        }
                    }
                },
                language: {
                    searching: function() {
                        return "Tunggu...";
                    },
                    noResults: function() {
                        return "Warna tidak ditemukan !";
                    }
                },
                ajax: {
                    dataType: "json",
                    type: "post",
                    url: "<?= base_url('master/Warna/getWarna') ?>",
                    delay: 1000,
                    data: function(params) {
                        return {
                            search: params.term || "",
                            page: params.page || 1
                        }
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        params.result = data.results;
                        return {
                            results: data.results,
                            pagination: {
                                "more": (params.page * 5) < data.count_filtered
                            }
                        };
                    }
                }
            });
            $('#id_warna').on("select2:clear", function() {
                $('#id_warna').empty();
            });
            // end select2 Warna


            // select2 Ukuran
            $('#id_ukuran').select2({
                allowClear: true,
                tags: true,
                placeholder: 'Pilih Ukuran',
                templateSelection: function(state) {
                    if (!state.id) {
                        return state.text;
                    }
                    let text = state.text.replace('Tambah ukuran: ', '');
                    return text;
                },
                createTag: function(params) {
                    if (params.result.length == 0) {
                        if (params.term === '') {
                            return null;
                        }
                        let term = $.trim(params.term).toUpperCase();
                        return {
                            id: term,
                            text: 'Tambah ukuran: ' + term
                        }
                    }
                },
                language: {
                    searching: function() {
                        return "Tunggu...";
                    },
                    noResults: function() {
                        return "Ukuran tidak ditemukan !";
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
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        params.result = data.results;
                        return {
                            results: data.results,
                            pagination: {
                                "more": (params.page * 5) < data.count_filtered
                            }
                        };
                    }
                }
            });
            $('#id_ukuran').on("select2:clear", function() {
                $('#id_ukuran').empty();
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
                let berat = $('#berat').val();
                let harga = $('#harga').val();

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
                            $(".error_harga").html(res.harga);
                            $(".error_berat").html(res.berat);
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
                $('#harga').val("");
                $('#berat').val("");
                $('.error_ukuran').html("");
                $('.error_warna').html("");
                $('.error_qty').html("");
                $('.error_harga').html("");
                $('.error_berat').html("");
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
                    "data": "harga"
                },
                {
                    "data": "qty",
                    "className": "text-right"
                },
                {
                    "data": "berat",
                    "className": "text-right"
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

                if (confirm('Yakin akan hapus data ini')) {
                    // ajax request for delete detail produk
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
                                Swal.fire({
                                    title: "Berhasil dihapus",
                                    icon: "info",
                                    type: "info",
                                    timer: 1000
                                });
                            } else {
                                // refresh csrf
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                // reload dt
                                $('#tbl_detail_produk').DataTable().ajax.reload(null, false);
                                Swal.fire({
                                    title: "Gagal",
                                    html: '<span>Data tidak boleh dihapus karna sudah ada pada <br> <b>detail pesanan</b>.</span>',
                                    icon: "error",
                                    type: "danger",
                                    showCloseButton: true,
                                });
                            }
                        }
                    });
                }
            });
            // end handle delete detail produk
        <?php }; ?>
    });
</script>