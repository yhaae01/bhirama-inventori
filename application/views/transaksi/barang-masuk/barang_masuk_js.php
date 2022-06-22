<script src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.dateTime.min.js') ?>"></script>
<script type="text/javascript">
    // mencegah form dialog -Confirm Form Resubmission- muncul
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
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

        let today = new Date();

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
                "url": "<?= base_url('transaksi/BarangMasuk/json') ?>",
                "type": "POST",

                // kirim parameter ke server
                "data": function(d) {
                    d.dari = $('#dariTgl').val();
                    d.sampai = $('#sampaiTgl').val();
                }
            },
            columns: [{
                    "data": "id_barang_masuk",
                    "orderable": false,
                    "width": "10px"
                },
                {
                    "data": "tgl_barang_masuk"
                },
                {
                    "data": "nama_supplier",
                    "render": function(data) {
                        // capital each word
                        let str = data.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                            return letter.toUpperCase();
                        });
                        return str;
                    }
                },
                {
                    "data": "nama_pengguna",
                    "searchable": false,
                },

                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center",
                    // "render": function(data, type, full) {
                    //     if (full['status'] == '0') {
                    //         return data;
                    //     } else if (full['status'] == '1') {
                    //         let p = $(data).find('.formHapus').remove().end().html().replace('&nbsp;', '');
                    //         let a = $('<div class="btn-group"></div>').append(p);
                    //         return a.html();
                    //     }
                    // }
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


        // select2 Supplier
        $('#id_supplier').select2({
            placeholder: 'Pilih Supplier',
            minimumResultsForSearch: 0,
            language: {
                searching: function() {
                    return "Tunggu...";
                },
                noResults: function() {
                    return "Supplier tidak ditemukan !";
                }
            },
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('master/Supplier/getSupplier') ?>",
                delay: 1500,
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
        // menambahkan value ke input hidden sbg pengacu id_supplier
        $('#id_supplier').on('select2:select', function() {
            $('#idSupplier').val($('#id_supplier').val());
        });
        // end menambahkan value ke input hidden sbg pengacu id_supplier
        // end select2 supplier

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
                url: "<?= base_url('master/Produk/getProduk') ?>",
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


        // kosongkan select2 warna dan ukuran saat produk berganti,
        // serta set kembali placeholder
        $('#id_produk').on("change", function(e) {
            $(".error_produk").html('');
            $("#id_warna").empty();
            $("#id_ukuran").empty();
        });
        // ----------------------------

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

        //  handle input ke keranjang / calon barang masuk
        $('#inputKeranjang').submit(function(e) {
            e.preventDefault();
            let insertAction = '<?= base_url('transaksi/DetailBarangMasuk/insertKeranjang') ?>'
            let datafull = $('#inputKeranjang').serialize();
            // ajax 
            $.ajax({
                url: insertAction,
                dataType: "json",
                data: datafull,
                type: "post",
                success: function(res) {
                    $("#qty").blur();
                    if (res.status == "TRUE") {
                        $("#id_supplier").prop('disabled', true);
                        // reload dt
                        $('#detail_barangmasuk').DataTable().ajax.reload(null, false);
                        // refresh csrf
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        clear();
                    } else if (res.status == "Gagal") {
                        $(".error_supplier").html(res.supplier);
                        $(".error_produk").html(res.produk);
                        $(".error_warna").html(res.warna);
                        $(".error_ukuran").html(res.ukuran);
                        $(".error_qty").html(res.qty);
                        $(".error_harga").html(res.harga);
                        $(".error_berat").html(res.berat);
                        // refresh csrf
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    }
                }
            });
        });
        // end of handle input variasi
        //------------------------------


        // ========================================
        // datatable detail_barangmasuk
        $("#detail_barangmasuk").dataTable({
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            bAutoWidth: false,
            bFilter: false,
            info: false,
            paging: false,
            ajax: {
                "url": "<?= base_url('transaksi/DetailBarangMasuk/json') ?>",
                "type": "POST",
            },
            columns: [{
                    "data": "id",
                    "orderable": false,
                    "width": "10px"
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
                    "data": "sub_total",
                    "orderable": false
                },
                {
                    "data": "qty",
                    "orderable": false
                },
                {
                    "data": "berat",
                    "orderable": false
                },
                {
                    "data": "action",
                    "orderable": false,
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
        // end datatable detail_barangmasuk

        //  end handle input ke keranjang / calon detail pengembalian
        //------------------------------
        function clear() {
            $("#id_produk").select2("val", " ");
            $("#id_warna").select2("val", " ");
            $("#id_ukuran").select2("val", " ");
            $('#qty').val("");
            $('#berat').val("");
            $('#harga').val("");
            $('.error_supplier').html("");
            $('.error_produk').html("");
            $('.error_warna').html("");
            $('.error_ukuran').html("");
            $('.error_harga').html("");
            $('.error_qty').html("");
            $('.error_berat').html("");
        }

        // handle delete detail barang masuk
        $('#detail_barangmasuk').on('click', '.hapusDetailBarangMasuk', function(e) {
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
                        if (res.status == "TRUE") {
                            // jika keranjang kosong maka bisa pilih kembali pesanan
                            if (res.isEmpty) {
                                $("#id_supplier").prop('disabled', false);
                            }
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            // reload dt
                            $('#detail_barangmasuk').DataTable().ajax.reload(null, false);
                        }
                    }
                });
            }
        });
        // end handle delete detail pengembalian


        // handle insert pengembalian
        $('#simpanBarangMasuk').on('click', function() {
            let insertAction = '<?= base_url('transaksi/BarangMasuk/create_action') ?>'
            let idSupplier = $('#idSupplier').val()
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
            if (idSupplier != '') {
                Swal.fire({
                    title: 'Apakah data sudah sesuai ?',
                    icon: "question",
                    showDenyButton: true,
                    allowOutsideClick: false,
                    confirmButtonText: 'Ya, proses',
                    confirmButtonColor: '#47c363',
                    denyButtonText: "Belum, saya akan cek lagi",
                }).then((res) => {
                    if (res.isConfirmed) {
                        $.ajax({
                            url: insertAction,
                            dataType: "JSON",
                            type: "POST",
                            data: {
                                '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                                'id_supplier': idSupplier
                            },
                            success: function(res) {
                                // refresh csrf token
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                if (res.status == 'success') {
                                    // redirect ke barang masuk barang
                                    window.location.href = "<?= base_url('transaksi/BarangMasuk') ?>";
                                } else if (res.status == 'empty') {
                                    Swal.fire({
                                        html: "Detail barang masuk kosong. <br> <b>Silahkan tambahkan !</b>",
                                        icon: "warning",
                                        timer: 1500
                                    });
                                } else {
                                    $(".error_supplier").html(res.id_pesanan);
                                }
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    html: "Supplier belum diisi. <br> <b>Silahkan tambahkan !</b>",
                    icon: "warning",
                    timer: 1500
                });
            }
        });
        // end handle insert pengembalian

        // handle delete pengembalian
        $('#mytable').on('click', '.hapusPengembalian', function(e) {
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
                        'id_pengembalian_barang': id
                    },
                    success: function(res) {
                        if (res.status == 'deleted') {
                            // reload dt
                            $('#mytable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: "Data pengembalian berhasil dihapus",
                                icon: "info",
                                timer: 1500
                            });
                        } else {
                            $('#mytable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: "Gagal",
                                html: '<span>Data tidak bisa dihapus karna sudah <br> <b>Diproses</b>.</span>',
                                icon: "error",
                                showCloseButton: true,
                            });
                        }
                    }
                });
            }
        });
        // end handle delete pengembalian



        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");

        // set Messages Global for jquery form validation
        $.validator.messages.required = 'Wajib di isi !';
    });
</script>