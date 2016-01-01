var warna_label = [];
warna_label[1] = 'label-warning';
warna_label[2] = 'label-info';
warna_label[3] = 'label-default';
warna_label[4] = 'label-success';
warna_label[5] = 'label-danger';
warna_label[10] = 'label-info';
var tabel_draft = null;
var list_prioritas = [];
list_prioritas[1] = 'Urgent';
list_prioritas[2] = 'Tinggi';
list_prioritas[3] = 'Sedang';
list_prioritas[4] = 'Rendah';
jQuery(document).ready(function () {
    ubah_periode_pekerjaan();
});
function ubah_periode_pekerjaan() {
    get_list_pekerjaan_saya();
    get_list_pekerjaan_staff();
    get_list_pekerjaan_draft();
}
var tabel_pekerjaan_draft=null;
function get_list_pekerjaan_draft(){
    $.ajax({
        type: "get",
        url: site_url + "/draft/get_list_draft",
        data: {
            periode: $('#dashboard_select_periode').val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            var counter = 0;
            if (tabel_pekerjaan_draft != null) {
                tabel_pekerjaan_draft.fnDestroy();
            }
            var tabel = $('#dashboard_tabel_pekerjaan_draft_body');
            tabel.html('');
            for (var i = 0, i2 = json.length; i < i2; i++) {
                var p = json[i];
                var id = p['id_pekerjaan'];
                var html = '<tr>'
                        + '<td>' + (i + 1) + '</td>'
                        + '<td id="draft_nama_' + id + '"></td>'
                        + '<td id="draft_waktu_' + id + '"></td>'
                + '<td id="draft_kategori_' + id + '"></td>'
                        + '<td id="draft_prioritas_' + id + '"></td>'
                        + '<td id="draft_aksi_' + id + '"></td>'
                        + '</tr>';
                tabel.append(html);
                $('#draft_nama_' + id).html(p['nama_pekerjaan']);
                $('#draft_kategori_' + id).html(p['kategori']);
                $('#draft_waktu_' + id).html(p['tanggal_mulai'] + ' - ' + p['tanggal_selesai']);
                $('#draft_prioritas_' + id).html(list_prioritas[p['level_prioritas']]);
                $('#draft_aksi_' + id).html(
                        '<div class="btn-group">'
                        + '<button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button">Aksi<span class="caret"></span></button>'
                        + '<ul class="dropdown-menu">'
                        + '<li><a href="'+site_url+'/draft/view?id_draft='+id+'" target="">Detail Draft</a></li>'
                        + '<li><a href="'+site_url+'/draft/edit?id_draft='+id+'" target="">Edit Darft</a></li>'
                        + '<li><a href="javascript:dialog_hapus_draft('+id+')" target="">Hapus Draft</a></li>'
                        + '</ul>'
                        + '</div>'
                        );
            }
            tabel_pekerjaan_draft = $('#dashboard_tabel_pekerjaan_draft').dataTable();
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
var tabel_pekerjaan_staff = null;
function get_list_pekerjaan_staff() {
    if (tabel_pekerjaan_staff != null) {
        tabel_pekerjaan_staff.fnDestroy();
    }
    $.ajax({
        type: "post",
        url: site_url + "/pekerjaan_staff/get_list_skp_bawahan",
        data: {
            periode: $('#dashboard_select_periode').val()
        },
        success: function (data) { // on success..
            var body = $('#dashboard_tabel_pekerjaan_staff_body');
            body.html('');
            var json = JSON.parse(data);
            for (var j = 0, m = json.length; j < m; j++) {
                // console.log("iterasi ke " + j + " dari " + m);
                var p = json[j];
                var list_anggota = p['id_akuns'].replace('}', '').replace('{', '').split(',');
                var anggota = '';
                var sep = '';
                for (var i = 0, n = list_user.length; i < n; i++) {
                    var st = list_user[i];
                    if (list_anggota.indexOf(st['id_akun']) >= 0) {
                        anggota += sep + st['nama'];
                        sep = '<br/>';
                    }
                }
                var periode = p['tanggal_mulai'] + ' - ' + p['tanggal_selesai'];
                var halaman_detail = 'detail';
                var status_pekerjaan_arr = p['status_pekerjaan2'].split(',');
                var status_pekerjaan = '<span class="label ' + warna_label[status_pekerjaan_arr[0]] + ' label-mini">' + status_pekerjaan_arr[1] + '</span>';
                var kategori_pekerjaan = 'Rutin';
                if (p['kategori'] == 'project') {
                    kategori_pekerjaan = 'Project';
                } else if (p['kategori'] == 'tambahan') {
                    kategori_pekerjaan = 'Pekerjaan Tambahan';
                } else if (p['kategori'] == 'kreativitas') {
                    kategori_pekerjaan = 'Pekerjaan Kreativitas';
                }
                var html = '<tr>'
                        + '<td id="pekerjaan_staff_no_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_staff_nama_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_staff_periode_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_staff_anggota_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_staff_kategori_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_staff_status_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_staff_view_' + p['id_pekerjaan'] + '"></td>'
                        + '</tr>';
                body.append(html);
                $('#pekerjaan_staff_no_' + p['id_pekerjaan']).html(j + 1);
                $('#pekerjaan_staff_nama_' + p['id_pekerjaan']).html(p['nama_pekerjaan']);
                $('#pekerjaan_staff_periode_' + p['id_pekerjaan']).html(periode);
                $('#pekerjaan_staff_anggota_' + p['id_pekerjaan']).html(anggota);
                $('#pekerjaan_staff_kategori_' + p['id_pekerjaan']).html(kategori_pekerjaan);
                $('#pekerjaan_staff_status_' + p['id_pekerjaan']).html(status_pekerjaan);
                $('#pekerjaan_staff_view_' + p['id_pekerjaan']).html('<a  href="' + site_url + '/pekerjaan_staff/' + halaman_detail + '?id_pekerjaan=' + p['id_pekerjaan'] + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
            }
            tabel_pekerjaan_staff = $('#dashboard_tabel_pekerjaan_staff').dataTable({"columnDefs": [{"targets": [5], "orderable": false}]});
        }
    });
}
var tabel_pekerjaan_saya = null;
function get_list_pekerjaan_saya() {
    if (tabel_pekerjaan_saya != null) {
        tabel_pekerjaan_saya.fnDestroy();
    }
    $.ajax({// create an AJAX call...
        type: "post", // GET or POST
        url: site_url + "/pekerjaan_saya/get_list_skp_saya", // the file to call
        data: {
            periode: $('#dashboard_select_periode').val()
        },
        success: function (data) { // on success..
            var body = $('#dashboard_tabel_pekerjaan_saya_body');
            body.html('');
            var json = JSON.parse(data);
            for (var j = 0, m = json.length; j < m; j++) {
                console.log("iterasi ke " + j + " dari " + m);
                var p = json[j];
                var list_anggota = p['id_akuns'].replace('}', '').replace('{', '').split(',');
                var anggota = '';
                var sep = '';
                for (var i = 0, n = list_user.length; i < n; i++) {
                    var st = list_user[i];
                    if (list_anggota.indexOf(st['id_akun']) >= 0) {
                        anggota += sep + st['nama'];
                        sep = '<br/>';
                    }
                }
                var periode = p['tanggal_mulai'] + ' - ' + p['tanggal_selesai'];
                var halaman_detail = 'detail';
                var status_pekerjaan_arr = p['status_pekerjaan2'].split(',');
                var status_pekerjaan = '<span class="label ' + warna_label[status_pekerjaan_arr[0]] + ' label-mini">' + status_pekerjaan_arr[1] + '</span>';
                var kategori_pekerjaan = 'Rutin';
                if (p['kategori'] == 'project') {
                    kategori_pekerjaan = 'Project';
                } else if (p['kategori'] == 'tambahan') {
                    kategori_pekerjaan = 'Pekerjaan Tambahan';
                } else if (p['kategori'] == 'kreativitas') {
                    kategori_pekerjaan = 'Pekerjaan Kreativitas';
                }
                var html = '<tr>'
                        + '<td id="pekerjaan_no_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_nama_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_periode_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_anggota_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_kategori_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_status_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_view_' + p['id_pekerjaan'] + '"></td>'
                        + '</tr>';
                body.append(html);
                $('#pekerjaan_no_' + p['id_pekerjaan']).html(j + 1);
                $('#pekerjaan_nama_' + p['id_pekerjaan']).html(p['nama_pekerjaan']);
                $('#pekerjaan_periode_' + p['id_pekerjaan']).html(periode);
                $('#pekerjaan_anggota_' + p['id_pekerjaan']).html(anggota);
                $('#pekerjaan_kategori_' + p['id_pekerjaan']).html(kategori_pekerjaan);
                $('#pekerjaan_status_' + p['id_pekerjaan']).html(status_pekerjaan);
                $('#pekerjaan_view_' + p['id_pekerjaan']).html('<a  href="' + site_url + '/pekerjaan_saya/' + halaman_detail + '?id_pekerjaan=' + p['id_pekerjaan'] + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
            }
            tabel_pekerjaan_saya = $('#dashboard_tabel_pekerjaan_saya').dataTable({"columnDefs": [{"targets": [5], "orderable": false}], });
        }
    });
}