jQuery(document).ready(function () {
    select_periode_changed();
});
function dialog_hapus_usulan(id_pekerjaan){
    var deskripsi = $($("#pekerjaan_usulan_" + id_pekerjaan).children()[1]).html();
    $("#modal_any").modal("show");
    $("#modal_any_button_cancel").attr({class: "btn btn-success"}).html("Batal");
    $("#modal_any_button_ok").attr({class: "btn btn-danger", onclick: "hapus_usulan("+id_pekerjaan+")"}).html("Hapus");
    $("#modal_any_title").html("Konfirmasi Hapus Usulan Pekerjaan");
    $("#modal_any_body").html("<h5>Anda akan menghapus usulan pekerjaan <strong>"+deskripsi+"</strong>. Lanjutkan?</h5>");
}

function hapus_usulan(id_pekerjaan){
    $("#modal_any").modal("hide");
    $.ajax({
        type: "get",
        url: site_url + "/pekerjaan_saya/hapus_usulan_json",
        data: {
            id_pekerjaan: id_pekerjaan
        },
        success: function (data) {
            var json = JSON.parse(data);
            if(json["status"] == "ok"){
                $("#pekerjaan_usulan_" + id_pekerjaan).remove();
            }else{
                alert(json["reason"]);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}

function select_periode_changed() {
    init_tabel_skp();
    init_tabel_tugas();
    init_tabel_usulan();
}
var tabel_skp = null;
var warna_label = [];
warna_label[1] = 'label-warning';
warna_label[2] = 'label-info';
warna_label[3] = 'label-default';
warna_label[4] = 'label-success';
warna_label[5] = 'label-danger';
warna_label[10] = 'label-info';
var tabel_usulan = null;
function init_tabel_usulan() {
    $.ajax({
        type: "get",
        url: site_url + "/pekerjaan_saya/get_list_usulan",
        data: {
            periode: $('#select_periode').val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            var counter = 0;
            if (tabel_usulan != null) {
                tabel_usulan.fnDestroy();
            }
            var tabel = $('#tabel_usulan_body');
            tabel.html('');
            var list_kategori = [];
            list_kategori["rutin"] = "Pekerjaan Rutin";
            list_kategori["project"] = "Pekerjaan Project";
            list_kategori["tambahan"] = "Pekerjaan Tambahan";
            list_kategori["kreativitas"] = "Pekerjaan kreativitas";
            for (var i = 0, i2 = json.length; i < i2; i++) {
                var usulan = json[i];
                var anggota = '';
                var anggota1 = JSON.parse(usulan['id_akuns'].replace('{','[').replace('}',']'));
                var sep = '';
                for (var j = 0, j2 = anggota1.length; j < j2; j++) {
                    var id_anggota = anggota1[j];
                    for (var k = 0, k2 = list_user.length; k < k2; k++) {
                        var user1 = list_user[k];
                        if (id_anggota == user1['id_akun']) {
                            anggota += sep + user1['nama'];
                            sep = '<br/>';
                            break;
                        }
                    }
                }
                var status = 'Draft';
                var aksi = '<div class="btn-group">';
                aksi += '<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button">Aksi <span class="caret"></span></button>';
                aksi += '<ul class="dropdown-menu">';
                aksi += '<li><a href="' + site_url + '/pekerjaan_saya/detail_usulan?id_pekerjaan=' + usulan['id_pekerjaan'] + '" target="">Detail Usulan</a></li>';
                aksi += '<li><a href="' + site_url + '/pekerjaan_saya/view_edit_usulan?id_pekerjaan=' + usulan['id_pekerjaan'] + '" target="">Edit Usulan</a></li>';
                aksi += '<li><a href="javascript:dialog_hapus_usulan('+usulan["id_pekerjaan"]+')" target="">Hapus Usulan</a></li>';
                aksi += '</ul>';
                aksi += '</div>'
                counter++;
                var html = '<tr id="pekerjaan_usulan_'+usulan["id_pekerjaan"]+'">'
                        + '<td>' + counter + '</td>'
                        + '<td>' + usulan['nama_pekerjaan'] + '</td>'
                        + '<td>' + usulan['tanggal_mulai'] + ' - ' + usulan['tanggal_selesai'] + '</td>'
                        + '<td>' + anggota + '</td>'
                        + '<td>' + list_kategori[usulan["kategori"]] + '</td>'
                        + '<td>' + status + '</td>'
                        + '<td>' + aksi + '</td>'
                        + '</tr>';
                tabel.append(html);
            }
            tabel_usulan = $('#tabel_usulan').dataTable();
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
var tabel_tugas = null;
function init_tabel_tugas() {
    $.ajax({
        type: "get",
        url: site_url + "/pekerjaan_saya/get_list_tugas",
        data: {
            periode: $('#select_periode').val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            var counter = 0;
            if (tabel_tugas != null) {
                tabel_tugas.fnDestroy();
            }
            var tabel = $('#tabel_tugas_body');
            tabel.html('');
            for (var i = 0, i2 = json.length; i < i2; i++) {
                var tugas = json[i];
                var anggota = '';
                var anggota1 = JSON.parse(tugas['id_akun'].replace('}', ']').replace('{', '['));
                var sep = '';
                for (var j = 0, j2 = anggota1.length; j < j2; j++) {
                    var id_anggota = anggota1[j];
                    for (var k = 0, k2 = list_user.length; k < k2; k++) {
                        var user1 = list_user[k];
                        if (id_anggota == user1['id_akun']) {
                            anggota += sep + user1['nama'];
                            sep = '<br/>';
                            break;
                        }
                    }
                }
                var status = 'Belum Dikerjakan';
                if (tugas['id_aktivitas'] != null) {
                    status = 'Telah dikerjakan, menunggu validasi';
                    if (tugas['status_validasi_aktivitas'] != null) {
                        status = 'Telah dikerjakan';
                    }
                }
                var aksi = '<div class="btn-group">';
                aksi += '<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button">Aksi <span class="caret"></span></button>';
                aksi += '<ul class="dropdown-menu">';
                aksi += '<li><a href="' + site_url + '/pekerjaan_saya/detail_tugas?id_tugas=' + tugas['id_assign_tugas'] + '" target="">Detail Tugas</a></li>';
                aksi += '</ul>';
                aksi += '</div>'

                counter++;

                var html = '<tr>'
                        + '<td>' + counter + '</td>'
                        + '<td>' + tugas['deskripsi'] + '</td>'
                        + '<td>' + tugas['nama_pekerjaan'] + '</td>'
                        + '<td>' + tugas['tanggal_mulai2'] + ' - ' + tugas['tanggal_selesai2'] + '</td>'
                        + '<td>' + anggota + '</td>'
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
function init_tabel_skp() {
    console.log('fungsi initTablePekerjaanSaya');
    if (tabel_skp !== null) {
        tabel_skp.fnDestroy();
    }
    var body = $('#tablePekerjaanSaya_body');
    body.html('');
    $.ajax({
        type: "get",
        url: site_url + "/pekerjaan_saya/get_list_skp_saya",
        data: {
            periode: $('#select_periode').val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            for (var j = 0, m = json.length; j < m; j++) {
                console.log("iterasi ke " + j + " dari " + m);
                var p = json[j];
                var list_anggota = JSON.parse(p['id_akuns'].replace('{','[').replace('}',']'));
                console.log(list_anggota);
                var anggota = '';
                var sep = '';
                for (var i = 0, n = list_user.length; i < n; i++) {
                    var st = list_user[i];
                    //console.log("check if id "+st["id_akun"]+" is in list anggota ");
                    for (var k = 0, k2 = list_anggota.length; k < k2; k++) {
                        if (list_anggota[k] == parseInt(st["id_akun"])) {
                            //console.log("id "+st["id_akun"]+" is in list anggota ");
                            anggota += sep + st['nama'];
                            sep = '<br/>';
                        }
                    }
                    /*if (list_anggota.indexOf(st['id_akun']) >= 0) {
                     console.log("id "+st["id_akun"]+" is in list anggota ");
                     anggota += sep + st['nama'];
                     sep = '<br/>';
                     }*/
                }
                var periode = p['tanggal_mulai'] + ' - ' + p['tanggal_selesai'];
                var halaman_detail = 'detail';
//                if (p['kategori'] != 'rutin') {
//                var mulai = p['tgl_mulai'];
//                var selesai = p['tgl_selesai'];
//                var mulai2 = mulai.split('+');
//                var selesai2 = selesai.split('+');
//                var mulai3 = mulai2[0].split(' ');
//                var selesai3 = selesai2[0].split(' ');
//                periode = mulai3[0] + ' - ' + selesai3[0];
//                    if(p['kategori']=='tambahan'){
//                        halaman_detail='detail_tambahan';
//                    }else if(p['kategori']=='kreativitas'){
//                        halaman_detail='detail_kreativitas';
//                    }
//                }

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
            tabel_skp = $('#tablePekerjaanSaya').dataTable({"columnDefs": [{"targets": [5], "orderable": false}], });
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}