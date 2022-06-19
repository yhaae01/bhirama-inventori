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
            templateResult: function(state, container) {
                console.log(container);
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


        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");

        // set Messages Global for jquery form validation
        $.validator.messages.required = 'Wajib di isi !';
    });
</script>