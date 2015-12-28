var warna_label = [];
var tabel_pekerjaan_staff = null;
var tabel_tambahan_staff = null;
var tabel_kreativitas_staff = null;
$(document).ready(function () {
    warna_label[1] = 'label-warning';
    warna_label[2] = 'label-info';
    warna_label[3] = 'label-default';
    warna_label[4] = 'label-success';
    warna_label[5] = 'label-danger';
    warna_label[10] = 'label-info';
    $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    document.title = "Daftar Pekerjaan Staff - Task Management";
    $('#submenu_pekerjaan_ul').show();
    init_tabel_skp_staff();
    init_tabel_tugas();
//    init_tabel_tambahan_staff();
//    init_tabel_kreativitas();
});
function ubah_periode() {
    init_tabel_skp_staff();
    init_tabel_tugas();
}
var tabel_tugas = null;
var list_tugas_staff = [];
function init_tabel_tugas() {
    if (tabel_tugas != null) {
        tabel_tugas.fnDestroy();
    }
    var tabel = $('#tabel_tugas_body');

    $.ajax({
        type: "POST",
        url: site_url + "/pekerjaan_staff/get_list_tugas",
        data: {
            periode: $('#select_periode').val(),
            id_staff: id_staff
        },
        success: function (data) {
            tabel.html('');
            var json = JSON.parse(data);
            var list_tugas = json['tugas'];
            var counter = 0;
            for (var i = 0, i2 = list_tugas.length; i < i2; i++) {
                counter++;
                var tugas = list_tugas[i];
                list_tugas_staff[tugas['id_assign_tugas']] = tugas;
                var anggota1 = tugas['id_akun'].replace('{', '[').replace('}', ']');
                var anggota2 = JSON.parse(anggota1);
                var anggota3 = '';
                var sep = '';
                for (var j = 0, j2 = anggota2.length; j < j2; j++) {
                    var id_anggota = anggota2[j];
                    for (var k = 0, k2 = users.length; k < k2; k++) {
                        var staff = users[k];
                        if (staff['id_akun'] == id_anggota) {
                            anggota3 += sep + staff['nama'];
                            sep = '<br/>';
                            break;
                        }
                    }
                }
                var status = 'Belum Dikerjakan';
                if (tugas['id_aktivitas'] != null) {
                    status = 'Sudah Dikerjakan, Belum Divalidasi';
                    if (parseInt(tugas['status_validasi']) == 1) {
                        status = 'Sudah Dikerjakan, Sudah Divalidasi';
                    }
                }
                var aksi = '<div class="btn-group">';
                aksi += '<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button">Aksi <span class="caret"></span></button>';
                aksi += '<ul class="dropdown-menu">';
                aksi += '<li><a href="' + site_url + '/pekerjaan_staff/detail_tugas?id_tugas=' + tugas['id_assign_tugas'] + '" target="">Detail Tugas</a></li>';
                aksi += '<li><a href="' + site_url + '/pekerjaan_staff/edit_tugas?id_tugas=' + tugas['id_assign_tugas'] + '" target="">Edit Tugas</a></li>';
                aksi += '<li><a href="javascript:dialog_hapus_tugas(' + tugas['id_assign_tugas'] + ')" target="">Hapus Tugas</a></li>';
                aksi += '</ul>';
                aksi += '</div>'
                var html = '<tr>'
                        + '<td>' + counter + '</td>'
                        + '<td>' + tugas['deskripsi'] + '</td>'
                        + '<td>' + tugas['nama_pekerjaan'] + '</td>'
                        + '<td>' + tugas['tanggal_mulai2'] + ' - ' + tugas['tanggal_selesai2'] + '</td>'
                        + '<td>' + anggota3 + '</td>'
                        + '<td>' + status + '</td>'
                        + '<td>' + aksi + '</td>'
                        + '</tr>';
                tabel.append(html);
            }
            tabel_tugas = $('#tabel_tugas').dataTable();
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });

}
var list_pekerjaan_staff = [];
function init_tabel_skp_staff() {
    if (tabel_pekerjaan_staff != null) {
        tabel_pekerjaan_staff.fnDestroy();
    }
    var body = $('#tabel_pekerjaan_staff_body');

    $.ajax({
        type: "POST",
        url: site_url + "/pekerjaan_staff/get_list_skp",
        data: {
            periode: $('#select_periode').val(),
            id_staff: id_staff
        },
        success: function (data) {
            body.html('');
            var json = JSON.parse(data);
            for (var j = 0, m = json.length; j < m; j++) {
                console.log("iterasi ke " + j + " dari " + m);
                var p = json[j];
                list_pekerjaan_staff[p['id_pekerjaan']] = p;
                var list_anggota = p['id_akuns'].replace('}', '').replace('{', '').split(',');
                var anggota = '';
                var sep = '';
                for (var i = 0, n = list_staff.length; i < n; i++) {
                    var st = list_staff[i];
                    if (list_anggota.indexOf(st['id_akun']) >= 0) {
                        anggota += sep + st['nama'];
                        sep = '<br/>';
                    }
                }
                var periode = p['periode'];
                var halaman_detail = 'detail';
//                if (p['kategori'] != 'rutin') {
                var mulai = p['tgl_mulai'];
                var selesai = p['tgl_selesai'];
                var mulai2 = mulai.split('+');
                var selesai2 = selesai.split('+');
                var mulai3 = mulai2[0].split(' ');
                var selesai3 = selesai2[0].split(' ');
                periode = mulai3[0] + ' - ' + selesai3[0];
//                    if (p['kategori'] == 'tambahan') {
//                        halaman_detail = 'detail_tambahan';
//                    } else if (p['kategori'] == 'kreativitas') {
//                        halaman_detail = 'detail_kreativitas';
//                    }
//                }
                var kategori_pekerjaan = 'Rutin';
                if (p['kategori'] == 'project') {
                    kategori_pekerjaan = 'Project';
                } else if (p['kategori'] == 'tambahan') {
                    kategori_pekerjaan = 'Pekerjaan Tambahan';
                } else if (p['kategori'] == 'kreativitas') {
                    kategori_pekerjaan = 'Pekerjaan Kreativitas';
                }
                var status_pekerjaan_arr = p['status_pekerjaan2'].split(',');
                var status_pekerjaan = '<span class="label ' + warna_label[status_pekerjaan_arr[0]] + ' label-mini">' + status_pekerjaan_arr[1] + '</span>';
                var html = '<tr>'
                        + '<td id="pekerjaan_no_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_nama_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_periode_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_anggota_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_kategori_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_status_' + p['id_pekerjaan'] + '"></td>'
                        + '<td id="pekerjaan_view_' + p['id_pekerjaan'] + '"></td>'
                        + '</tr>';
                var aksi = '<div class="btn-group">';
                aksi += '<button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button">Aksi <span class="caret"></span></button>';
                aksi += '<ul class="dropdown-menu">';
                aksi += '<li><a href="' + site_url + '/pekerjaan_staff/detail?id_staff=' + id_staff + '&id_pekerjaan=' + p['id_pekerjaan'] + '" target="">Detail Pekerjaan</a></li>';
                aksi += '<li><a href="' + site_url + '/pekerjaan_staff/edit?id_pekerjaan=' + p['id_pekerjaan'] + '" target="">Edit Pekerjaan</a></li>';
                aksi += '<li><a href="javascript:dialog_hapus_pekerjaan(' + p['id_pekerjaan'] + ')" target="">Hapus Pekerjaan</a></li>';
                aksi += '</ul>';
                aksi += '</div>'
                body.append(html);
                $('#pekerjaan_no_' + p['id_pekerjaan']).html(j + 1);
                $('#pekerjaan_nama_' + p['id_pekerjaan']).html(p['nama_pekerjaan']);
                $('#pekerjaan_periode_' + p['id_pekerjaan']).html(periode);
                $('#pekerjaan_anggota_' + p['id_pekerjaan']).html(anggota);
                $('#pekerjaan_kategori_' + p['id_pekerjaan']).html(kategori_pekerjaan);
                $('#pekerjaan_status_' + p['id_pekerjaan']).html(status_pekerjaan);
//                $('#pekerjaan_view_' + p['id_pekerjaan']).html('<a  href="' + site_url + '/pekerjaan_staff/' + halaman_detail + '?id_pekerjaan=' + p['id_pekerjaan'] + '&id_staff=' + id_staff + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
                $('#pekerjaan_view_' + p['id_pekerjaan']).html(aksi);
            }
            tabel_pekerjaan_staff = $('#tabel_pekerjaan_staff').dataTable({"columnDefs": [{"targets": [6], "orderable": false}], });
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
function dialog_hapus_tugas(id) {
    var tugas = list_tugas_staff[id];
    if (confirm('Anda akan menghapus tugas "' + tugas['deskripsi'] + '". Lanjutkan?') == false) {
        return;
    }
    $.ajax({
        type: "get",
        url: site_url + "/pekerjaan_staff/hapus_tugas",
        data: {
            id_tugas: id
        },
        success: function (data) {
            if (data == 'ok') {
                init_tabel_tugas();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
function dialog_hapus_pekerjaan(id) {
    var pekerjaan = list_pekerjaan_staff[id];
    if (confirm('Anda akan menghapus pekerjaan "' + pekerjaan['nama_pekerjaan'] + '". Lanjutkan?') == false) {
        return;
    }
    $.ajax({
        type: "get",
        url: site_url + "/pekerjaan_staff/batalkan_v2",
        data: {
            id_pekerjaan: id
        },
        success: function (data) {
            if (data == 'ok') {
                init_tabel_skp_staff();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
//function init_tabel_kreativitas() {
//    if (tabel_kreativitas_staff != null) {
//        tabel_kreativitas_staff.fnDestroy();
//    }
//    var body = $('#tabel_tugas_kreativitas_body');
//    body.html('');
//    $.ajax({
//        type: "POST",
//        url: site_url + "/pekerjaan_staff/get_list_tugas_kreativitas",
//        data: {
//            periode: $('#select_periode').val(),
//            id_staff: id_staff
//        },
//        success: function (data) {
//            var json = JSON.parse(data);
//            for (var j = 0, m = json.length; j < m; j++) {
//                console.log("iterasi ke " + j + " dari " + m);
//                var p = json[j];
//                var list_anggota = p['id_akuns'].replace('}', '').replace('{', '').split(',');
//                var anggota = '';
//                var sep = '';
//                for (var i = 0, n = list_staff.length; i < n; i++) {
//                    var st = list_staff[i];
//                    if (list_anggota.indexOf(st['id_akun']) >= 0) {
//                        anggota += sep + st['nama'];
//                        sep = '<br/>';
//                    }
//                }
//                var periode = p['periode'];
//                if (p['kategori'] != 'skp') {
//                    var mulai = p['tgl_mulai'];
//                    var selesai = p['tgl_selesai'];
//                    var mulai2 = mulai.split('+');
//                    var selesai2 = selesai.split('+');
//                    var mulai3 = mulai2.split(' ');
//                    var selesai3 = selesai2.split(' ');
//                    periode = mulai3[0] + ' - ' + selesai3[0];
//                }
//                var status_pekerjaan_arr = p['status_pekerjaan2'].split(',');
//                var status_pekerjaan = '<span class="label ' + warna_label[status_pekerjaan_arr[0]] + ' label-mini">' + status_pekerjaan_arr[1] + '</span>';
//                var html = '<tr>'
//                        + '<td id="pekerjaan_no_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_nama_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_periode_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_anggota_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_status_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_view_' + p['id_pekerjaan'] + '"></td>'
//                        + '</tr>';
//                body.append(html);
//                $('#pekerjaan_no_' + p['id_pekerjaan']).html(j + 1);
//                $('#pekerjaan_nama_' + p['id_pekerjaan']).html(p['nama_pekerjaan']);
//                $('#pekerjaan_periode_' + p['id_pekerjaan']).html(periode);
//                $('#pekerjaan_anggota_' + p['id_pekerjaan']).html(anggota);
//                $('#pekerjaan_status_' + p['id_pekerjaan']).html(status_pekerjaan);
//                $('#pekerjaan_view_' + p['id_pekerjaan']).html('<a  href="' + site_url + '/pekerjaan_staff/detail_skp?id_pekerjaan=' + p['id_pekerjaan'] + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
//            }
//            tabel_kreativitas_staff = $('#tabel_tugas_kreativitas').dataTable({"columnDefs": [{"targets": [5], "orderable": false}], });
//        },
//        error: function (xhr, ajaxOptions, thrownError) {
//
//        }
//    });
//}
//function init_tabel_tambahan_staff() {
//    if (tabel_tambahan_staff != null) {
//        tabel_tambahan_staff.fnDestroy();
//    }
//    var body = $('#tabel_tugas_tambahan_body');
//    body.html('');
//    $.ajax({
//        type: "POST",
//        url: site_url + "/pekerjaan_staff/get_list_tugas_tambahan",
//        data: {
//            periode: $('#select_periode').val(),
//            id_staff: id_staff
//        },
//        success: function (data) {
//            var json = JSON.parse(data);
//            for (var j = 0, m = json.length; j < m; j++) {
//                console.log("iterasi ke " + j + " dari " + m);
//                var p = json[j];
//                var list_anggota = p['id_akuns'].replace('}', '').replace('{', '').split(',');
//                var anggota = '';
//                var sep = '';
//                for (var i = 0, n = list_staff.length; i < n; i++) {
//                    var st = list_staff[i];
//                    if (list_anggota.indexOf(st['id_akun']) >= 0) {
//                        anggota += sep + st['nama'];
//                        sep = '<br/>';
//                    }
//                }
//                var status_pekerjaan_arr = p['status_pekerjaan2'].split(',');
//                var status_pekerjaan = '<span class="label ' + warna_label[status_pekerjaan_arr[0]] + ' label-mini">' + status_pekerjaan_arr[1] + '</span>';
//                var html = '<tr>'
//                        + '<td id="pekerjaan_no_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_nama_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_periode_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_anggota_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_status_' + p['id_pekerjaan'] + '"></td>'
//                        + '<td id="pekerjaan_view_' + p['id_pekerjaan'] + '"></td>'
//                        + '</tr>';
//                body.append(html);
//                $('#pekerjaan_no_' + p['id_pekerjaan']).html(j + 1);
//                $('#pekerjaan_nama_' + p['id_pekerjaan']).html(p['nama_pekerjaan']);
//                $('#pekerjaan_periode_' + p['id_pekerjaan']).html(p['periode']);
//                $('#pekerjaan_anggota_' + p['id_pekerjaan']).html(anggota);
//                $('#pekerjaan_status_' + p['id_pekerjaan']).html(status_pekerjaan);
//                $('#pekerjaan_view_' + p['id_pekerjaan']).html('<a  href="' + site_url + '/pekerjaan_staff/detail_skp?id_pekerjaan=' + p['id_pekerjaan'] + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
//            }
//            tabel_tambahan_staff = $('#tabel_tugas_tambahan').dataTable({"columnDefs": [{"targets": [5], "orderable": false}], });
//        },
//        error: function (xhr, ajaxOptions, thrownError) {
//
//        }
//    });
//}


//    tabel_pekerjaan_staff = $('#tabel_pekerjaan_staff').dataTable({
//        order: [[0, "desc"]],
//        "columnDefs": [{"targets": [5], "orderable": false}],
//        "processing": true,
//        "serverSide": true,
//        "ajax": {
//            'method': 'post',
//            'data': {
//                id_staff: id_staff
//            },
//            "url": site_url + "/pekerjaan_staff/get_list_skp",
//            "dataSrc": function (json) {
//                var jsonData = json.data;
//                return jsonData;
//            }
//        },
//        "createdRow": function (row, data, index) {
////            var tgl_mulai = data[2];
////            var tgl_selesai = data[8];
////            var tgl_mulai_arr = tgl_mulai.split(' ');
////            var tgl_selesai_arr = tgl_selesai.split(' ');
////            $('td', row).eq(2).html(tgl_mulai_arr[0] + ' - ' + tgl_selesai_arr[0]);
//            var sasaran_jumlah = parseFloat(data[4]) || 0;
//            var sasaran_waktu = parseFloat(data[5]) || 0;
//            var realisasi_jumlah = parseFloat(data[6]) || 0;
//            var realisasi_waktu = parseFloat(data[7]) || 0;
//            var selisih_jumlah = realisasi_jumlah - sasaran_jumlah;
//            var sekarang = data[9];
////            console.log(selisih_jumlah);
//            var list_anggota = data[3].replace('}', '').replace('{', '').split(',');
//            var anggota = '';
//            var sep = '';
//            for (var i = 0, n = list_staff.length; i < n; i++) {
//                var st = list_staff[i];
//                if (list_anggota.indexOf(st['id_akun']) >= 0) {
//                    anggota += sep + st['nama'];
//                    sep = '<br/>';
//                }
//            }
////            console.log(list_anggota);
//            $('td', row).eq(3).html(anggota);
////            $('td', row).eq(4).html(data[10]);
//            var status_pekerjaan_arr = data[9].split(',');
//            
//            var html = '<span class="label '+warna_label[status_pekerjaan_arr[0]]+' label-mini">' + status_pekerjaan_arr[1] + '</span>';
//            $('td', row).eq(4).html(html);
//            $('td',row).eq(5).html('<a  href="'+site_url+'/pekerjaan_staff/detail_skp?id_pekerjaan='+data[0]+'" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
//            $(row).attr('id', 'row_' + index)
//        }
//    });
//}