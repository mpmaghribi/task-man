jQuery(document).ready(function () {
    init_tabel_skp();
    init_tabel_tugas();
    $('#select_periode').on('change', function () {
        init_tabel_skp();
        init_tabel_tugas();
    });
});

var tabel_skp = null;
var warna_label = [];
warna_label[1] = 'label-warning';
warna_label[2] = 'label-info';
warna_label[3] = 'label-default';
warna_label[4] = 'label-success';
warna_label[5] = 'label-danger';
warna_label[10] = 'label-info';
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
                var status = 'Belum Dibaca';
                if(tugas['id_aktivitas']!=null){
                    status='Telah dikerjakan, menunggu validasi';
                    if(tugas['status_validasi_aktivitas']!=null){
                        status='Telah dikerjakan';
                    }
                }
                var aksi = '';

                counter++;

                var html = '<tr>'
                        + '<td>' + counter + '</td>'
                        + '<td>' + tugas['deskripsi'] + '</td>'
                        + '<td>' + tugas['nama_pekerjaan'] + '</td>'
                        + '<td>' + tugas['tanggal_mulai2'] + '</td>'
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
        type: "POST",
        url: site_url + "/pekerjaan_saya/get_list_skp_saya",
        data: {
            periode: $('#select_periode').val()
        },
        success: function (data) {
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