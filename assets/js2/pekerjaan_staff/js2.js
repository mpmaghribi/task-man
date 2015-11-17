$(document).ready(function () {
    $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    document.title = "Daftar Pekerjaan Staff - Task Management";
    $('#submenu_pekerjaan_ul').show();
    init_tabel_pekerjaan_staff();
});
var tabel_pekerjaan_staff = null;
function init_tabel_pekerjaan_staff() {
    if (tabel_pekerjaan_staff != null) {
        tabel_pekerjaan_staff.fnDestroy();
    }
    tabel_pekerjaan_staff = $('#tabel_pekerjaan_staff').dataTable({
        order: [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            'method': 'post',
            'data': {
                id_staff:id_staff
            },
            "url": base_url + "/pekerjaan_staff/get_list_pekerjaan",
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