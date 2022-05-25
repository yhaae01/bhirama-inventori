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
                url: "<?= base_url('master/Pengguna/json') ?>",
                type: "POST",
                data: function(d) {
                    console.log(d);
                }
            },
            columns: [{
                    "data": "id_pengguna",
                    "orderable": false
                },
                {
                    "data": "image",
                    "className": "text-center",
                    "orderable": false,
                    "render": function(dataImage) {
                        if (dataImage == 'default.png') {
                            return '<img class="avatar" src="<?= base_url("assets/img/") ?>' + dataImage + '"height="75">'
                        } else {
                            return '<img class="avatar" src="<?= base_url("assets/img/pengguna/") ?>' + dataImage + '"height="75">'
                        }
                    }
                },
                {
                    "data": "nama_pengguna"
                },
                {
                    "data": "username"
                },
                {
                    "data": "role"
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

        $('#role').select2({
            minimumResultsForSearch: -1,
            placeholder: "Pilih Role"
        });
    });
</script>