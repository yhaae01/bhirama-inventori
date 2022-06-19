<script src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.dateTime.min.js') ?>"></script>
<?php if (isset($button)) { ?>
    <?php if ($button == 'Read' || $button == 'Print') { ?>
        <script src="<?= base_url('assets/js/print.min.js') ?>"></script>
    <?php } ?>
<?php } ?>
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
                "url": "<?= base_url('transaksi/PengembalianBarang/json') ?>",
                "type": "POST",

                // kirim parameter ke server
                "data": function(d) {
                    d.dari = $('#dariTgl').val();
                    d.sampai = $('#sampaiTgl').val();
                }
            },
            columns: [{
                    "data": "id_pengembalian_barang",
                    "orderable": false,
                    "width": "10px"
                },
                {
                    "data": "id_pesanan",
                },
                {
                    "data": "tgl_pengembalian",
                    "render": function(date) {
                        let bulan;
                        let created_at = new Date(date);
                        if (created_at.getMonth() < 9) {
                            bulan = '0' + String(created_at.getMonth() + 1);
                        } else {
                            bulan = String(created_at.getMonth() + 1);
                        }
                        let YmdHis = created_at.getDate() + '-' + bulan + '-' + created_at.getFullYear();
                        // beri note untuk record yang dibuat 12 jam terakhir
                        if ((today - created_at) <= 43200000) {
                            return YmdHis + ' <i class="far fa-clock"></i> ' + created_at.getHours() + ':' + created_at.getMinutes()
                        } else {
                            return YmdHis;
                        }
                    }
                },
                {
                    "data": "status",
                    "searchable": false,
                    "render": function(data) {
                        if (data == "0") {
                            return '<span class="badge badge-warning">Belum diproses</span>';
                        } else {
                            return '<span class="badge badge-success">Sudah diproses</span>';
                        }
                    }
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
        // end datatables


        // select2 Pesanan
        $('#id_pesanan').select2({
            placeholder: 'Pilih pesanan',
            minimumResultsForSearch: 0,
            templateSelection: function(state) {
                if (!state.id) {
                    return state.text;
                }
                let text = state.tgl_pesanan + ' | ' + state.text;
                return text;
            },
            templateResult: function(state, container) {
                if (!state.id) {
                    return state.text;
                }
                let $text = $(container).append('<b>' + state.tgl_pesanan + '</b> | ID Pesanan: <b>' + state.id + '</b> | Penerima: <b>' + state.text + '</b>')
                return $text;
            },
            language: {
                searching: function() {
                    return "Tunggu...";
                },
                noResults: function() {
                    return "Pesanan tidak ditemukan !";
                }
            },
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('transaksi/Pesanan/getAllPesanan') ?>",
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
        // end select2 pesanan

        // jika pesanan sudah dipilih, maka req detail produk yg tersedia
        $('#id_pesanan').on("select2:select", function(e) {
            let idPesanan = $("#id_pesanan").val();
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
            // // ajax req utk minta data kota/kab ke tabel kabupatenhh
            $.ajax({
                url: "<?= base_url('transaksi/DetailPesanan/get_produk_by_id_pesanan') ?>",
                dataType: "JSON",
                type: "POST",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                    'id_pesanan': idPesanan
                },
                success: function(res) {
                    // refresh csrf token
                    $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    $("#id_detail_produk").select2({
                        minimumResultsForSearch: -1,
                        templateSelection: function(state) {
                            if (!state.id) {
                                return state.text;
                            }
                            let text = state.text + ' / ' + state.nama_warna + ' / ' + state.nama_ukuran + ' / ' + state.qty;
                            return text;
                        },
                        templateResult: function(state, container) {
                            if (!state.id) {
                                return state.text;
                            }
                            let $text = $(container).append(state.text + ' / ' + state.nama_warna + ' / ' + state.nama_ukuran + ' / ' + state.qty)
                            return $text;
                        },
                        'data': res.produk
                    })
                    $('#id_detail_produk').trigger('select2:select');
                }
            });
        });
        // end get detail produk

        // set max qty ketika id_produk dipilih
        $('#id_detail_produk').on('select2:select', function() {
            let id_detail_produk = $('#id_detail_produk').val()
            let id_pesanan = $('#id_pesanan').val()
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();

            // $('#id_pesanan').prop('disabled', "true")

            $.ajax({
                url: "<?= base_url('transaksi/DetailPesanan/getQtyByIdPesanan') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                    'id_pesanan': id_pesanan,
                    'id_detail_produk': id_detail_produk
                },
                success: function(res) {
                    // refresh csrf token
                    $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    $('#qty').attr('max', res.qty);
                }
            });
            // end ajax untuk req qty pada detail_pesanan

        });
        // end set max qty ketika id_produk dipilih


        // ========================================
        // datatable detail_pengembalianbarang
        $("#detail_pengembalianbarang").dataTable({
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
                "url": "<?= base_url('transaksi/DetailPengembalianBarang/json') ?>",
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
                    "data": "qty",
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
        // end datatable detail_pengembalianbarang

        // menambahkan value ke input hidden sbg pengacu id_pesanan
        $('#id_pesanan').on('select2:select', function() {
            $('#idPesanan').val($('#id_pesanan').val());
        });
        // end menambahkan value ke input hidden sbg pengacu id_pesanan


        //  handle input ke keranjang / calon detail pengembalian
        $('#inputKeranjang').submit(function(e) {
            e.preventDefault();
            let insertAction = '<?= base_url('transaksi/DetailPengembalianBarang/insertKeranjang') ?>'
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
                        $("#id_pesanan").prop('disabled', true);

                        // reload dt
                        $('#detail_pengembalianbarang').DataTable().ajax.reload(null, false);
                        // refresh csrf
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        // clear();
                    } else if (res.status == "Gagal") {
                        $(".error_pesanan").html(res.pesanan);
                        $(".error_produk").html(res.produk);
                        $(".error_qty").html(res.qty);
                        // refresh csrf
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    }
                }
            });
        });
        //  end handle input ke keranjang / calon detail pengembalian
        //------------------------------
        function clear() {
            $("#id_detail_produk").select2("val", " ");
            $('#qty').val("");
            $('.error_produk').html("");
            $('.error_qty').html("");
        }

        // handle delete detail pengembalian
        $('#detail_pengembalianbarang').on('click', '.hapusDetailPengembalian', function(e) {
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
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            // reload dt
                            $('#detail_pengembalianbarang').DataTable().ajax.reload(null, false);
                        }
                    }
                });
            }
        });
        // end handle delete detail pengembalian



        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");

        // set Messages Global for jquery form validation
        $.validator.messages.required = 'Wajib di isi !';
    });
</script>