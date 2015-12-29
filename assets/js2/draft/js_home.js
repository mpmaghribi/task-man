$(document).ready(function () {
    get_list_draft();
});
function draft_ubah_periode() {
    get_list_draft();
}
var tabel_draft = null;
var list_prioritas=[];
list_prioritas[1]='Urgent';
list_prioritas[2]='Tinggi';
list_prioritas[3]='Sedang';
list_prioritas[4]='Rendah';
function get_list_draft() {
    $.ajax({
        type: "get",
        url: site_url + "/draft/get_list_draft",
        data: {
            periode: $('#draft_select_periode').val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            var counter = 0;
            if (tabel_draft != null) {
                tabel_draft.fnDestroy();
            }
            var tabel = $('#tabel_draft_body');
            tabel.html('');
            for (var i = 0, i2 = json.length; i < i2; i++) {
                var p = json[i];
                var id = p['id_pekerjaan'];
                var html = '<tr>'
                        + '<td>' + (i + 1) + '</td>'
                        + '<td id="draft_nama_' + id + '"></td>'
                        + '<td id="draft_waktu_' + id + '"></td>'
                        + '<td id="draft_prioritas_' + id + '"></td>'
                        + '<td id="draft_aksi_' + id + '"></td>'
                        + '</tr>';
                tabel.append(html);
                $('#draft_nama_'+id).html(p['nama_pekerjaan']);
                $('#draft_waktu_'+id).html(p['tanggal_mulai']+' - '+p['tanggal_selesai']);
                $('#draft_prioritas_'+id).html(list_prioritas[p['level_prioritas']]);
                $('#draft_aksi_'+id).html('');
            }
            tabel_draft = $('#tabel_draft').dataTable();
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}