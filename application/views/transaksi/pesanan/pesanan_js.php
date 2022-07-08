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
        <?php if ($button != 'Read') { ?>
            // membuat sidebar jadi kecil jika lebar halaman lebih dari 1007px
            if ($(document).width() >= 1007) {
                setTimeout(function() {
                    $('[data-toggle="sidebar"]').trigger('click');

                }, 1000)
            }

        <?php } ?>
        let skrg = new Date();
        let dd = String(skrg.getDate()).padStart(2, '0');
        let mm = String(skrg.getMonth() + 1).padStart(2, '0'); //January is 0!
        let yyyy = skrg.getFullYear();
        skrg = yyyy + '-' + mm + '-' + dd;
        let bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        let hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        let dariTgl = new DateTime($('#dariTgl'), {
            format: 'YYYY-MM-DD',
            i18n: {
                months: bulan,
                weekdays: hari
            }
        }).max(skrg).val(skrg);

        let sampaiTgl = new DateTime($('#sampaiTgl'), {
            format: 'YYYY-MM-DD',
            i18n: {
                months: bulan,
                weekdays: hari
            }
        }).max(skrg).val(skrg);



        // ketika btn Print diklik
        <?php if ($button == 'Print') { ?>
            $('#updateStatus').on('submit', function(e) {
                e.preventDefault();

                // jalankan script untuk print
                printJS({
                    printable: 'detail_pesanan_form',
                    type: 'html',
                    maxWidth: 460,
                    font_size: '14pt',
                    targetStyles: ['*'],
                    css: ['<?= base_url("assets/css/bootstrap.min.css") ?>', '<?= base_url("assets/css/style.css") ?>'],
                    style: 'body{width: 100mm; height:150mm; margin-left:2%; margin-top:2%;} .va{vertical-align:middle !important}',
                    // ketika popup print telah tertutup,
                    // maka lakukan ajax req untuk update status
                    onPrintDialogClose: function() {
                        <?php if ($button == 'Print') { ?>
                            Swal.fire({
                                title: 'Apakah pesanan diproses ?',
                                icon: "question",
                                showDenyButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: 'Ya, diproses',
                                confirmButtonColor: '#47c363',
                                denyButtonText: "Belum",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Jika user klik Diproses maka lakukan ajax utk ubah status
                                    // ajax untuk update data status pesanan
                                    let dataUpdate = $('#updateStatus').serialize();
                                    $.ajax({
                                        url: "<?= base_url('transaksi/Pesanan/updateStatus') ?>",
                                        dataType: "JSON",
                                        type: "POST",
                                        data: dataUpdate,
                                        success: function(res) {
                                            if (res.status == 'success') {
                                                // refresh csrf token
                                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                                // ganti status
                                                $('.status').removeClass('badge-warning').addClass('badge-success').text('Sudah diproses');
                                                Swal.fire({
                                                    title: "Berhasil diproses",
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
                                } else if (result.isDenied) {
                                    Swal.fire('Status belum diproses.', '', 'info')
                                }
                            })
                        <?php } else if ($button == 'Read') { ?>
                            // Jika user klik Diproses maka lakukan ajax utk ubah status
                            // ajax untuk update data status pesanan
                            let idPesanan = $("#id_pesanan").val();
                            let dataUpdate = $('#updateStatus').serialize();
                            $.ajax({
                                url: "<?= base_url('transaksi/Pesanan/updateStatus') ?>",
                                dataType: "JSON",
                                type: "POST",
                                data: dataUpdate,
                                success: function(res) {
                                    if (res.status == 'success') {
                                        // refresh csrf token
                                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                        // ganti status
                                        $('.status').removeClass('badge-warning').addClass('badge-success').text('Sudah diproses');
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
                        <?php } ?>
                    }
                })
            });
        <?php } ?>
        // jika btn proses diklik
        $('#proses-dp').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah pesanan diproses ?',
                icon: "question",
                showDenyButton: true,
                allowOutsideClick: false,
                confirmButtonText: 'Ya, diproses',
                confirmButtonColor: '#47c363',
                denyButtonText: "Belum",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Diproses maka lakukan ajax utk ubah status
                    // ajax untuk update data status pesanan
                    let dataUpdate = $('#updateStatus').serialize();
                    $.ajax({
                        url: "<?= base_url('transaksi/Pesanan/updateStatus') ?>",
                        dataType: "JSON",
                        type: "POST",
                        data: dataUpdate,
                        success: function(res) {
                            if (res.status == 'success') {
                                // refresh csrf token
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                                // ganti status
                                $('.status').removeClass('badge-warning').addClass('badge-success').text('Sudah diproses');
                                Swal.fire({
                                    title: "Berhasil diproses",
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
                } else if (result.isDenied) {
                    Swal.fire('Status belum diproses.', '', 'info')
                }
            })
        });
        $('#print-dp').on('click', function(e) {
            e.preventDefault();
            // jalankan script untuk print
            printJS({
                printable: 'detail_pesanan_form',
                type: 'html',
                maxWidth: 460,
                font_size: '14pt',
                targetStyles: ['*'],
                css: ['<?= base_url("assets/css/bootstrap.min.css") ?>', '<?= base_url("assets/css/style.css") ?>'],
                style: 'body{width: 100mm; height:150mm; margin-left:2%; margin-top:2%;} .va{vertical-align:middle !important}'
            })
        });

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
                "url": "<?= base_url('transaksi/Pesanan/json') ?>",
                "type": "POST",

                // kirim parameter ke server
                "data": function(d) {
                    d.dari = $('#dariTgl').val();
                    d.sampai = $('#sampaiTgl').val();
                }
            },
            columns: [{
                    "data": "id_pesanan",
                    "className": "text-center",
                    "width": "70px",
                    "orderable": false,
                    "render": function(data) {
                        return '<b>' + data + '</b>';
                    }
                },
                {
                    "data": "tgl_pesanan",
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
                    "data": "penerima"
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
                    "data": "nama_pengguna"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, full) {
                        if (full['status'] == '0') {
                            return '<button title="Print" data-id="' + full['id_pesanan'] + '" class="btn btn-warning print-dp"><i class="fas fa-print"></i></button> ' + data;
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
            ]
        });

        $('#filterTgl').on('click', function() {
            if (!(!dariTgl.val() || !sampaiTgl.val())) {
                // jika tgl dari lebih besar dari tgl sampai
                if ((sampaiTgl.val() - dariTgl.val()) < 0) {
                    Swal.fire({
                        title: "Gagal",
                        text: "Tanggal tidak valid!",
                        icon: "error",
                        showCloseButton: true,
                    });
                } else {
                    t.fnDraw();
                }
            } else {
                Swal.fire({
                    title: "Gagal",
                    text: "Lengkapi tanggal!",
                    icon: "error",
                    showCloseButton: true,
                });
            }
        });
        // end datatables


        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");


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
                    beforeSend: function() {
                        $('.qtyLoad').html('');
                        $('.hargaLoad').html('');
                    },
                    success: function(res) {
                        // refresh csrf token
                        $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        $("#id_warna").select2({
                            minimumResultsForSearch: -1,
                            'data': res.warna
                        })
                        $('#id_warna').trigger('select2:select');
                    }
                });
            });
            // end req warna yg tersedia

            // kosongkan select2 warna dan ukuran saat produk berganti,
            // serta set kembali placeholder
            $('#id_produk').on("change", function(e) {
                $(".error_produk").html('');
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

            // ketika produk di clear
            $('#id_produk').on("select2:clear", function() {
                $('.qtyLoad').html('');
                $('.hargaLoad').html('');
            });

            // jika warna sudah dipilih, maka req ukuran yg tersedia
            $('#id_warna').on("select2:select", function(e) {
                let idProduk = $("#id_produk").val();
                let idWarna = $("#id_warna").val();
                let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
                $(".error_warna").html('');
                $(".error_ukuran").html('');
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
                        // trigger agar langsung menjalankan pemilihan ukuran
                        $("#id_ukuran").trigger("select2:select");
                    }
                });
            });
            // end req ukuran yg tersedia

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
            $('#id_ukuran').on("select2:select", function() {
                let idProduk = $("#id_produk").val();
                let idWarna = $("#id_warna").val();
                let idUkuran = $(this).val();
                let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
                let nilaiQty = $('#qty').val();
                // jika value produk dan warna memiliki nilai
                if (idProduk != "" && idWarna != "") {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: '<?= base_url("master/DetailProduk/getQtyHarga") ?>',
                        data: {
                            'id_produk': idProduk,
                            'id_warna': idWarna,
                            'id_ukuran': idUkuran,
                            '<?= $this->security->get_csrf_token_name() ?>': token_hash
                        },
                        beforeSend: function() {
                            $('.qtyLoad').html('Tersedia: ...');
                            $(".error_qty").html('');
                            $(".error_harga").html('');
                        },
                        success: function(res) {
                            if (res.status != 'Gagal') {
                                $('.qtyLoad').html('Tersedia: <b>' + res.qty.qty + '</b>');
                                $('.hargaLoad').html('Harga: <b>' + res.qty.harga + '</b>/pc');
                                // atur atribut max pada qty
                                $('#qty').attr('max', res.qty.qty);
                                // jika qty tersisa 0 maka matikan input QTY
                                if (res.qty.qty == 0) {
                                    $('#qty').attr('disabled', "disabled");
                                } else {
                                    $('#qty').prop('disabled', false);
                                }
                                if (parseInt(nilaiQty) > res.qty.qty) {
                                    $('#qty').val('');
                                }
                                // refresh csrf
                                $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            }
                        }
                    });
                }
            });
            // end setiap perubahan pada ukuran


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

            //  handle input ke keranjang / calon detail pesanan
            $('#inputKeranjang').submit(function(e) {
                e.preventDefault();
                let insertAction = '<?= base_url('transaksi/DetailPesanan/insertKeranjang') ?>'
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
                            // reload dt
                            $('#detail_pesanan').DataTable().ajax.reload(null, false);
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            clear();
                        } else if (res.status == "Gagal") {
                            $(".error_produk").html(res.produk);
                            $(".error_warna").html(res.warna);
                            $(".error_ukuran").html(res.ukuran);
                            $(".error_qty").html(res.qty);
                            $(".error_harga").html(res.harga);
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        }
                    }
                });
            });
            // end of handle input variasi
            //------------------------------


            function clear() {
                $("#id_produk").select2("val", " ");
                $("#id_warna").select2("val", " ");
                $("#id_ukuran").select2("val", " ");
                $('#qty').val("");
                $('#harga').val("");
                $('.error_produk').html("");
                $('.error_ukuran').html("");
                $('.error_warna').html("");
                $('.error_qty').html("");
                $('.error_harga').html("");
                $('.qtyLoad').html("");
                $('.hargaLoad').html("");
            }

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
                        let bonus = '';
                        if (full['sub_total'] == '0') {
                            bonus = '(BONUS)';
                        }
                        return full['nama_produk'] + ' / ' + full['nama_warna'] + ' / ' + full['nama_ukuran'] + ' ' + bonus;
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
            $('#detail_pesanan').on('click', '.hapusDetailPesanan', function(e) {
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
                                $('#detail_pesanan').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
            // end handle delete detail produk
        <?php }; ?>

        // select2 Pengirim
        $('#pengirim').select2({
            placeholder: 'Pilih Pengirim',
            minimumResultsForSearch: -1,
            language: {
                "noResults": function() {
                    return "Pengirim tidak ditemukan ! Silahkan tambahkan dahulu.";
                }
            },

            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('master/Pengirim/getPengirim') ?>",
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term || "",
                        page: params.page || 1
                    }
                }
            }
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end select2 Pengirim

        // select2 Kurir
        $('#kurir').select2({
            placeholder: 'Pilih Kurir',
            minimumResultsForSearch: -1,
            language: {
                "noResults": function() {
                    return "Kurir tidak ditemukan ! Silahkan tambahkan dahulu.";
                }
            },

            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('master/Kurir/getKurir') ?>",
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term || "",
                        page: params.page || 1
                    }
                }
            }
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end select2 Kurir


        // select2 Provinsi
        $('#provinsi').select2({
            placeholder: 'Pilih Provinsi',
            language: {
                "noResults": function() {
                    return "Provinsi tidak ditemukan !";
                }
            },

            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('transaksi/DetailPesanan/getProvinsi') ?>",
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term || "",
                        page: params.page || 1
                    }
                }
            }
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end select2 Provinsi


        // kosongkan select2 kab/kota, kec, kel saat provinsi berganti,
        // serta set kembali placeholder
        $('#provinsi').on("change", function(e) {
            $(".error_produk").html('');
            $("#kab").empty();
            $("#kec").empty();
            $("#kel").empty();
            $("#kab").select2({
                placeholder: 'Pilih Kota / Kabupaten'
            });
            $("#kec").select2({
                placeholder: 'Pilih Kecamatan'
            });
            $("#kel").select2({
                placeholder: 'Pilih Kelurahan'
            });
        });
        // ----------------------------

        // jika Kabupaten diganti maka kosongkan kec dan kel
        $('#kab').on("change", function(e) {
            $("#kec").empty();
            $("#kel").empty();
            $("#kec").select2({
                placeholder: 'Pilih Kecamatan'
            });
            $("#kel").select2({
                placeholder: 'Pilih Kelurahan'
            });
        });
        // ---------------------------------

        // jika Kecamatan diganti maka kosongkan kel
        $('#kec').on("change", function(e) {
            $("#kel").empty();
            $("#kel").select2({
                placeholder: 'Pilih Kelurahan'
            });
        });
        // ---------------------------------

        // jika provinsi sudah dipilih, maka req kab/kota yg tersedia
        $('#provinsi').on("select2:select", function(e) {
            let idProv = $("#provinsi").val();
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();
            // log(token_hash)

            // ajax req utk minta data kota/kab ke tabel kabupatenhh
            $.ajax({
                url: "<?= base_url('transaksi/DetailPesanan/getKab') ?>",
                dataType: "JSON",
                type: "POST",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                    'id_prov': idProv
                },
                success: function(res) {
                    // refresh csrf token
                    $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    $("#kab").select2({
                        minimumResultsForSearch: 0,
                        'data': res.kab
                    })
                    $('#kab').trigger('select2:select');
                }
            });
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end get Provinsi




        // jika Kab sudah dipilih, maka req kecamatan yg tersedia
        $('#kab').on("select2:select", function(e) {
            let idKab = $("#kab").val();
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();

            // ajax req utk minta data kota/kab ke tabel kabupatenhh
            $.ajax({
                url: "<?= base_url('transaksi/DetailPesanan/getKec') ?>",
                dataType: "JSON",
                type: "POST",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                    'id_kab': idKab
                },
                success: function(res) {
                    // refresh csrf token
                    $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    $("#kec").select2({
                        'data': res.kec
                    })
                    $('#kec').trigger('select2:select');
                }
            });
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end get Kab


        // jika Kecamatan sudah dipilih, maka req kelurahan yg tersedia
        $('#kec').on("select2:select", function(e) {
            let idKec = $("#kec").val();
            let token_hash = $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val();

            // ajax req utk minta data kota/kab ke tabel kabupatenhh
            $.ajax({
                url: "<?= base_url('transaksi/DetailPesanan/getKel') ?>",
                dataType: "JSON",
                type: "POST",
                data: {
                    '<?= $this->security->get_csrf_token_name() ?>': token_hash,
                    'id_kec': idKec
                },
                success: function(res) {
                    // refresh csrf token
                    $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                    $("#kel").select2({
                        minimumResultsForSearch: -1,
                        'data': res.kel
                    })
                    $('#kel').trigger('select2:select');
                }
            });
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end get kecamatan

        // inisialisasi select2 kab, kec, kel
        $('#kab').select2({
            placeholder: 'Pilih Kota / Kabupaten'
        });
        $('#kec').select2({
            placeholder: 'Pilih Kecamatan'
        });
        $('#kel').select2({
            placeholder: 'Pilih Kelurahan'
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end select2 kel


        // select2 metode pembayaran
        $('#mp').select2({
            placeholder: 'Pilih Metode Pembayaran',
            minimumResultsForSearch: -1,
            language: {
                "noResults": function() {
                    return "Metode Pembayaran tidak ditemukan ! Silahkan tambahkan dahulu.";
                }
            },

            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('master/MetodePembayaran/getMP') ?>",
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term || "",
                        page: params.page || 1
                    }
                }
            }
        }).on('select2:select', function() {
            $(this).valid();
        });
        // end select2 metode pembayaran

        // handle insert Detail Pelanggan
        $('#insertPesanan').validate({
            errorClass: 'text-danger',
            errorElement: 'span',
            rules: {
                pengirim: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                penerima: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                provinsi: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                kab: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                kec: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                kel: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                alamat: {
                    required: true,
                    minlength: 20
                },
                kodepos: {
                    minlength: 5,
                    maxlength: 5
                },
                no_telp: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    minlength: 9,
                    maxlength: 13
                },
                mp: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                kurir: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
                ongkir: {
                    required: {
                        depends: function() {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    }
                },
            },
            errorPlacement: function(error, element) {
                if (element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.next('.input-group-prepend').length) {
                    error.insertAfter(element.next('.input-group-prepend').parent());

                } else {
                    error.insertAfter(element);
                }
            },
            // lakukan ajax req untuk insert
            submitHandler: function(form) {
                let insertAction = '<?= base_url('transaksi/DetailPesanan/create_action') ?>'
                let datafull = $('#insertPesanan').serialize();
                // ajax 
                $.ajax({
                    url: insertAction,
                    dataType: "json",
                    data: datafull,
                    type: "post",
                    success: function(res) {
                        if (res.status == 'success') {
                            // redirect ke pesanan
                            window.location.href = "<?= base_url('transaksi/Pesanan') ?>";
                        } else if (res.status == 'empty') {
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                            Swal.fire({
                                html: "Detail pesanan kosong. <br> <b>Silahkan tambahkan !</b>",
                                icon: "warning",
                                timer: 1500
                            });
                        } else {
                            $(".error_pengirim").html(res.pengirim);
                            $(".error_penerima").html(res.penerima);
                            $(".error_provinsi").html(res.provinsi);
                            $(".error_kab").html(res.kab);
                            $(".error_kec").html(res.kec);
                            $(".error_kel").html(res.kel);
                            $(".error_alamat").html(res.alamat);
                            $(".error_kodepos").html(res.kodepos);
                            $(".error_no_telp").html(res.no_telp);
                            $(".error_mp").html(res.mp);
                            $(".error_kurir").html(res.kurir);
                            $(".error_ongkir").html(res.ongkir);
                            // refresh csrf
                            $('input[name=<?= $this->security->get_csrf_token_name() ?>]').val(res.<?= $this->security->get_csrf_token_name() ?>);
                        }
                    }
                });
            }
        });
        // End insert Detail Pelanggan

        // handle delete pesanan
        $('#mytable').on('click', '.hapusPesanan', function(e) {
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
                        'id_pesanan': id
                    },
                    success: function(res) {
                        if (res.status == 'deleted') {
                            // reload dt
                            $('#mytable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: "Data pesanan berhasil dihapus",
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
        // end handle delete pesanan


        // handle btn Print
        $('#mytable').on('click', '.print-dp', function(e) {
            let id = $(this).data('id');
            location.href = '<?= base_url("transaksi/Pesanan/prints/") ?>' + id;
        });
        // end handle btn Print

        // jika posisi di halaman print
        <?php if ($button == 'Print') { ?>
            $('#updateStatus').trigger('submit');
        <?php } ?>

        // set Messages Global for jquery form validation
        $.validator.messages.required = 'Wajib di isi !';
    });
</script>