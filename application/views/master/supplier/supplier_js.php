<script src="<?= base_url('assets/js/dropify.js') ?>"></script>
<script type="text/javascript">
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
                url: "<?= base_url('master/Supplier/json') ?>",
                type: "POST",
                data: function(d) {
                    console.log(d);
                }
                // dataSrc: function(a) {
                //     console.log(a.data[0].<?= $this->security->get_csrf_token_name() ?>);
                // }
                // success: function(res) {
                //     console.log(token);
                // }
            },
            columns: [{
                    "data": "id_supplier",
                    "orderable": false
                }, {
                    "data": "nama_supplier"
                }, {
                    "data": "alamat"
                }, {
                    "data": "no_telp"
                }, {
                    "data": "email"
                }, {
                    "data": "image",
                    "className": "text-center",
                    "render": function(dataImage) {
                        if (dataImage == 'default.png') {
                            return '<img class="avatar" src="<?= base_url("assets/img/") ?>' + dataImage + '"height="75">'
                        } else {
                            return '<img class="avatar" src="<?= base_url("assets/img/supplier/") ?>' + dataImage + '"height="75">'
                        }

                    }
                },
                {
                    "data": "detail",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "edit",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "hapus",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "<?= $this->security->get_csrf_token_name(); ?>",
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
    });
</script>