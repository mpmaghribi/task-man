jQuery(document).ready(function () {
            //$('#tabel_pkj_saya').dataTable();
            //$('#tabel_pkj_saya2').dataTable();
            initTablePekerjaanSaya();
        });
        var tablePekerjaanSaya = null;
        function initTablePekerjaanSaya() {
            console.log('fungsi initTablePekerjaanSaya');
            if (tablePekerjaanSaya !== null) {
                tablePekerjaanSaya.fnDestroy();
            }
            tablePekerjaanSaya = $("#tablePekerjaanSaya").dataTable({
                order: [[0, "desc"]],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'method': 'post',
                    'data': {
                    },
                    "url": site_url+"/pekerjaan_saya/get_list_pekerjaan_saya_datatable",
                    "dataSrc": function (json) {
                        var jsonData = json.data;
                        return jsonData;
                    }
                },
                "createdRow": function (row, data, index) {
//                    $('td', row).eq(6).html(html);
                    $(row).attr('id', 'row_' + index)
                }
            });
        }