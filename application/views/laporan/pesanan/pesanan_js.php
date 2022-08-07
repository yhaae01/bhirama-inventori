<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.dateTime.min.js') ?>"></script>
<script type="text/javascript">
    // mencegah form dialog -Confirm Form Resubmission- muncul
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    $(document).ready(function() {
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
        let n_dariTgl = $('[name="dariTgl"]');
        let n_sampaiTgl = $('[name="sampaiTgl"]');
        

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


        n_dariTgl.val(skrg);
        n_sampaiTgl.val(skrg);
        // isi value hidden
        $('#dariTgl').on('change', function(e) {
            n_dariTgl.val(this.value);
        });
        $('#sampaiTgl').on('change', function(e) {
            n_sampaiTgl.val(this.value);
        });

        $('#formRangeDate').on('submit', function(e) {
            e.preventDefault();
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
                    this.submit();
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
                }
            ],
            order: [
                [0, 'desc']
            ]
        });
        // end datatables

        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");

    });
</script>