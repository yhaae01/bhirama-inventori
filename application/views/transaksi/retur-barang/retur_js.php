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
                "url": "<?= base_url('transaksi/ReturBarang/json') ?>",
                "type": "POST",

                // kirim parameter ke server
                "data": function(d) {
                    d.dari = $('#dariTgl').val();
                    d.sampai = $('#sampaiTgl').val();
                }
            },
            columns: [{
                    "data": "id_retur_barang",
                    "orderable": false,
                    "width": "10px"
                },
                {
                    "data": "id_barang_masuk",
                    "render": function(data, type, full) {
                        return full['id_barang_masuk'] + ' | ' + full['nama_supplier']
                    }
                },
                {
                    "data": "tgl_retur"
                },
                {
                    "data": "status",
                    "searchable": false,
                    "render": function(data) {
                        if (data == "0") {
                            return '<span class="badge badge-warning">Belum dikirim</span>';
                        } else {
                            return '<span class="badge badge-success">Sudah dikirim</span>';
                        }
                    }
                },
                {
                    "data": "nama_pengguna"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, full) {
                        if (full['status'] == '0') {
                            return data;
                        } else if (full['status'] == '1') {
                            let p = $(data).find('.formHapus').remove().end().html().replace('&nbsp;', '');
                            let a = $('<div class="btn-group"></div>').append(p);
                            return a.html();
                        }
                    }
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

        // select2 barang masuk
        $('#id_barangmasuk').select2({
            placeholder: 'Pilih barang masuk',
            minimumResultsForSearch: 0,
            templateSelection: function(state) {
                if (!state.id) {
                    return state.text;
                }
                let text = state.tgl_barang_masuk + ' | ' + state.text;
                return text;
            },
            templateResult: function(state, container) {
                if (!state.id) {
                    return state.text;
                }
                let $text = $(container).append('<b>' + state.tgl_barang_masuk + '</b> | ID Barang Masuk: <b>' + state.id + '</b> | Supplier: <b>' + state.text + '</b>')
                return $text;
            },
            language: {
                searching: function() {
                    return "Tunggu...";
                },
                noResults: function() {
                    return "Data barang masuk tidak ditemukan !";
                }
            },
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('transaksi/BarangMasuk/getAllBarangMasuk') ?>",
                delay: 1200,
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
        // end select2 barang masuk

        // jika barang masuk sudah dipilih, maka req detail produk yg tersedia
        $('#id_barangmasuk').on("select2:select", function(e) {
            let idBarangMasuk = $("#id_barangmasuk").val();
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
            // // ajax req utk minta data kota/kab ke tabel kabupatenhh
            $.ajax({
                url: "<?= base_url('transaksi/DetailBarangMasuk/get_produk_by_id_barang_masuk') ?>",
                dataType: "JSON",
                type: "POST",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                    'id_barangmasuk': idBarangMasuk
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
            let id_barangmasuk = $('#id_barangmasuk').val()
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
            let nilaiQty = $('#qty').val();

            $.ajax({
                url: "<?= base_url('transaksi/DetailBarangMasuk/getQtyByIdBarangMasuk') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                    'id_barangmasuk': id_barangmasuk,
                    'id_detail_produk': id_detail_produk
                },
                success: function(res) {
                    // refresh csrf token
                    $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    $('#qty').attr('max', res.qty);
                    if (res.qty == 0) {
                        $('#qty').attr('disabled', "disabled");
                    } else {
                        $('#qty').prop('disabled', false);
                    }
                }
            });
            // end ajax untuk req qty pada detail_pesanan
        });
        // end set max qty ketika id_produk dipilih


        // ========================================
        // datatable detail_pengembalianbarang
        $("#detail_returbarang").dataTable({
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
                "url": "<?= base_url('transaksi/DetailReturBarang/json') ?>",
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
        $('#id_barangmasuk').on('select2:select', function() {
            $('#idBarangMasuk').val($('#id_barangmasuk').val());
        });
        // end menambahkan value ke input hidden sbg pengacu id_pesanan

        // clear list pada produk ketika pesanan diganti
        $('#id_barangmasuk').on('change', function() {
            $('#id_detail_produk').empty();
            $("#id_detail_produk").select2({
                placeholder: 'Pilih Produk'
            });
        });


        //  handle input ke keranjang / calon detail pengembalian
        $('#inputKeranjang').submit(function(e) {
            e.preventDefault();
            let insertAction = '<?= base_url('transaksi/DetailReturBarang/insertKeranjang') ?>'
            let datafull = $('#inputKeranjang').serialize();
            console.log(datafull)
            // ajax 
            $.ajax({
                url: insertAction,
                dataType: "json",
                data: datafull,
                type: "post",
                success: function(res) {
                    $("#qty").blur();
                    if (res.status == "TRUE") {
                        $("#id_barangmasuk").prop('disabled', true);

                        // reload dt
                        $('#detail_returbarang').DataTable().ajax.reload(null, false);
                        // refresh csrf
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        clear();
                    } else if (res.status == "Gagal") {
                        $(".error_barang_masuk").html(res.barang_masuk);
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
            $('.error_pesanan').html("");
            $('.error_keterangan').html("");
            $('.error_produk').html("");
            $('.error_qty').html("");
        }

        // handle delete detail pengembalian
        $('#detail_returbarang').on('click', '.hapusDetailReturBarang', function(e) {
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
                                $("#id_barangmasuk").prop('disabled', false);
                            }
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            // reload dt
                            $('#detail_returbarang').DataTable().ajax.reload(null, false);
                        }
                    }
                });
            }
        });
        // end handle delete detail retur


        // handle insert retur
        $('#simpanRetur').on('click', function() {
            let insertAction = '<?= base_url('transaksi/ReturBarang/create_action') ?>'
            let id_barang_masuk = $('#idBarangMasuk').val()
            let keterangan = $('#keterangan').val();
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
            if (id_barang_masuk != '' && keterangan != '') {
                $.ajax({
                    url: insertAction,
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                        'id_barang_masuk': id_barang_masuk,
                        'keterangan': keterangan
                    },
                    success: function(res) {
                        // refresh csrf token
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        if (res.status == 'success') {
                            // redirect ke pengembalian barang
                            window.location.href = "<?= base_url('transaksi/ReturBarang') ?>";
                        } else if (res.status == 'empty') {
                            Swal.fire({
                                html: "Detail retur kosong. <br> <b>Silahkan tambahkan !</b>",
                                icon: "warning",
                                timer: 1500
                            });
                        } else {
                            $(".error_barang_masuk").html(res.barang_masuk);
                            $(".error_ket").html(res.keterangan);
                        }
                    }

                });
            } else {
                Swal.fire({
                    html: "Detail retur atau keterangan kosong. <br> <b>Silahkan lengkapi !</b>",
                    icon: "warning",
                    timer: 1500
                });
            }

        });
        // end handle insert pengembalian


        // handle delete pengembalian
        $('#mytable').on('click', '.hapusRetur', function(e) {
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
                        'id_retur_barang': id
                    },
                    success: function(res) {
                        if (res.status == 'deleted') {
                            // reload dt
                            $('#mytable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: "Data retur barang berhasil dihapus",
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


        // btn proses retur
        $('#updateStatusRetur').on('submit', function(e) {
            e.preventDefault();
            let dataUpdate = $('#updateStatusRetur').serialize();

            Swal.fire({
                text: 'Apakah item(s) sudah benar ?',
                icon: "question",
                showDenyButton: true,
                allowOutsideClick: false,
                confirmButtonText: 'Ya, Proses',
                confirmButtonColor: '#47c363',
                denyButtonText: "Belum",
            }).then((result) => {
                if (result.isConfirmed) {

                    // ajax req utk ubah status
                    $.ajax({
                        url: "<?= base_url('transaksi/ReturBarang/updateStatusRetur') ?>",
                        dataType: "JSON",
                        type: "POST",
                        data: dataUpdate,
                        success: function(res) {
                            if (res.status == 'success') {
                                $('#prosesRetur').hide();
                                // refresh csrf token
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                // ganti status
                                $('.status').removeClass('badge-warning').addClass('badge-success').text('Sudah dikirim');
                                Swal.fire({
                                    title: "Berhasil dikirim",
                                    icon: "success",
                                    type: "success",
                                    timer: 1000
                                });
                            } else {
                                // refresh csrf token
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                Swal.fire({
                                    title: "Gagal",
                                    icon: "info",
                                    type: "info",
                                    timer: 1000
                                });
                            }
                        }
                    });
                }
            });
        });
        // end btn proses retur

        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");

        // set Messages Global for jquery form validation
        $.validator.messages.required = 'Wajib di isi !';
    });
</script>