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
                "url": "<?= base_url('master/Produk/json') ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id_produk",
                    "orderable": false
                },
                {
                    "data": "nama_produk"
                },
                {
                    "data": "id_kategori"
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
                    "data": "qty"
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

        // set theme select2 to bootstrap 3
        $.fn.select2.defaults.set("theme", "bootstrap");

        // select2 kategori
        $('#id_kategori').select2({
            allowClear: true,
            placeholder: 'Pilih Kategori',
            language: {
                "noResults": function() {
                    return "Kategori tidak ditemukan ! Silahkan tambahkan dahulu.";
                }
            },
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('master/Kategori/getKategori') ?>",
                delay: 800,

                data: function(params) {
                    return {
                        search: params.term || "",
                        page: params.page || 1
                    }
                }
            }
        });


        // select2 kategori
        $('#id_ukuran').select2({
            allowClear: true,
            placeholder: 'Pilih Ukuran',
            language: {
                "noResults": function() {
                    return "Ukuran tidak ditemukan ! Silahkan tambahkan dahulu.";
                }
            },
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('master/Varian/getUkuran') ?>",
                delay: 800,

                data: function(params) {
                    return {
                        search: params.term || "",
                        page: params.page || 1
                    }
                }
            }
        });


        // select2 warna
        $('#id_warna').select2({
            allowClear: true,
            placeholder: 'Pilih Warna',
            language: {
                "noResults": function() {
                    return "Warna tidak ditemukan ! Silahkan tambahkan dahulu.";
                }
            },
            ajax: {
                dataType: "json",
                type: "post",
                url: "<?= base_url('master/Varian/getWarna') ?>",
                delay: 800,

                data: function(params) {
                    return {
                        search: params.term || "",
                        page: params.page || 1
                    }
                }
            }
        });
    });
</script>