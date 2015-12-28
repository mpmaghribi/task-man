var warna_label = [];
warna_label[1] = 'label-warning';
warna_label[2] = 'label-info';
warna_label[3] = 'label-default';
warna_label[4] = 'label-success';
warna_label[5] = 'label-danger';
warna_label[10] = 'label-info';
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
    if (tabel_pekerjaan_draft != null) {
        tabel_pekerjaan_draft.fnDestroy();
    }
    $.ajax({
        type: "post",
        url: site_url + "/pekerjaan_saya/get_list_draft",
        data: {
            periode: $('#dashboard_select_periode').val()
        },
        success: function (data) { // on success..
            var body = $('#dashboard_tabel_pekerjaan_draft_body');
            body.html('');
            var json = JSON.parse(data);
            for (var j = 0, m = json.length; j < m; j++) {
                var p = json[j];
                
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
                        + '<td id="pekerjaan_draft_no_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_draft_nama_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_draft_periode_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_draft_anggota_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_draft_kategori_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_draft_status_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_draft_view_' + p['id_pekerjaan'] + '"></td>'
                        + '</tr>';
                body.append(html);
                $('#pekerjaan_draft_no_' + p['id_pekerjaan']).html(j + 1);
                $('#pekerjaan_draft_nama_' + p['id_pekerjaan']).html(p['nama_pekerjaan']);
                $('#pekerjaan_draft_periode_' + p['id_pekerjaan']).html(periode);
//                $('#pekerjaan_draft_anggota_' + p['id_pekerjaan']).html(anggota);
                $('#pekerjaan_draft_kategori_' + p['id_pekerjaan']).html(kategori_pekerjaan);
                $('#pekerjaan_draft_status_' + p['id_pekerjaan']).html(status_pekerjaan);
                $('#pekerjaan_draft_view_' + p['id_pekerjaan']).html('<a  href="' + site_url + '/pekerjaan_staff/' + halaman_detail + '?id_pekerjaan=' + p['id_pekerjaan'] + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
            }
            tabel_pekerjaan_draft = $('#dashboard_tabel_pekerjaan_draft').dataTable({"columnDefs": [{"targets": [5], "orderable": false}]});
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