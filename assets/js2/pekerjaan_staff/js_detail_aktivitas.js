/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    document.title = 'Detail Aktivitas Pekerjaan: ' + pekerjaan['nama_pekerjaan'] + ' - Task Management';
    $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    $('#submenu_pekerjaan_ul').show();
    $('#staff_pekerjaan').dataTable({
        columnDefs: [{targets: [0], orderable: false}],
        order: [[1, "asc"]]
    });
    if (pekerjaan['kategori'] == 'rutin' || pekerjaan['kategori'] == 'project') {
        init_tabel_aktivitas();
        $('#tabel_progress').hide();
        $('#div_penilaian_skp').show();
        $('#button_lock_nilai_progress').hide();
    } else {
        init_tabel_progress();
        $('#tabel_aktivitas').hide();
    }
    sembunyikan_form_penilaian();
    if (detil_pekerjaan['locked'] == '1') {
        $('#button_lock_nilai').html('Locked');
        $('#button_lock_nilai_progress').html('Locked');
        $('#button_validasi_semua').html('Locked');
        $('#button_tampilkan_form_penilaian').hide();
    }
});
function validasi_semua_aktivitas() {
    if (detil_pekerjaan['locked'] == '1') {
        return;
    }
    if (confirm('Anda akan memvalidasi semua aktivitas. Lanjutkan?') == false) {
        return;
    }
    var fungsi_validasi = 'validasi_semua_aktivitas';
    if (pekerjaan['kategori'] == 'tambahan' || pekerjaan['kategori'] == 'kreativitas') {
        fungsi_validasi = 'validasi_semua_progress';
    }
    $.ajax({
        type: "POST",
        url: site_url + "/aktivitas_pekerjaan/" + fungsi_validasi,
        data: {
            id_detil_pekerjaan: detil_pekerjaan['id_detil_pekerjaan'],
        },
        success: function (data) {
            if (data == 'ok') {
                tabel_aktivitas.fnDraw();
            } else {
                alert(data);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
function lock_nilai() {
    if (detil_pekerjaan['locked'] == '1') {
        return;
    }
    if (confirm('Anda akan mengunci penilaian. Lanjutkan?') == false) {
        return;
    }
    $.ajax({
        type: "POST",
        url: site_url + "/pekerjaan_staff/lock_nilai",
        data: {
            id_detil_pekerjaan: detil_pekerjaan['id_detil_pekerjaan'],
        },
        success: function (data) {
            if (data == 'ok') {
                $('#button_lock_nilai').html('Locked');
                $('#button_lock_nilai_progress').html('Locked');
                detil_pekerjaan['locked'] = '1';
            } else {
                alert(data);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
function sembunyikan_form_penilaian() {
    $('.td_edit_nilai').hide();
    $('.td_view_nilai').show();
    $('#button_simpan_penilaian').hide();
    $('#button_batal_penilaian').hide();
    $('#button_tampilkan_form_penilaian').show();
}
var form_penilaian_showed = false;
function tampilkan_form_penilaian() {
    if (detil_pekerjaan['locked'] == '1') {
        return;
    }
    $('#button_form_penilaian').html("Simpan Penilaian");
    $('.td_edit_nilai').show();
    $('.td_view_nilai').hide();
    $('#button_simpan_penilaian').show();
    $('#button_batal_penilaian').show();
    $('#button_tampilkan_form_penilaian').hide();
}

function simpan_penilaian() {
    $.ajax({
        type: "POST",
        url: site_url + "/pekerjaan_staff/ubah_nilai",
        data: {
            id_detil_pekerjaan: detil_pekerjaan['id_detil_pekerjaan'],
            target_ak: $('#input_target_ak').val(),
            target_output: $('#input_target_output').val(),
            target_mutu: $('#input_target_mutu').val(),
            satuan_kuantitas: $('#input_satuan_kuantitas').val(),
            target_biaya: $('#input_target_biaya').val(),
            realisasi_ak: $('#input_realisasi_ak').val(),
            realisasi_mutu: $('#input_realisasi_mutu').val(),
            realisasi_biaya: $('#input_realisasi_biaya').val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            if (json.status == 'ok') {
                $('#input_target_ak').val(json.sasaran_angka_kredit);
                $('#input_target_output').val(json.sasaran_kuantitas_output);
                $('#input_target_mutu').val(json.sasaran_kualitas_mutu);
                $('#input_satuan_kuantitas').val(json.satuan_kuantitas);
                $('#input_target_biaya').val(parseInt(json.pakai_biaya) == 1 ? json.sasaran_biaya : '-');
                $('#input_realisasi_ak').val(json.realisasi_angka_kredit);
                $('#input_realisasi_mutu').val(json.realisasi_kualitas_mutu);
                $('#input_realisasi_biaya').val(parseInt(json.pakai_biaya) == 1 ? json.realisasi_biaya : '-');

                $('#td_target_ak').html(json.sasaran_angka_kredit);
                $('#td_target_out').html(json.sasaran_kuantitas_output + ' ' + json.satuan_kuantitas);
                $('#td_target_mutu').html(json.sasaran_kualitas_mutu + '%');
//                                                                $('#input_satuan_kuantitas').val(json.satuan_kuantitas);
                $('#td_target_biaya').html(parseInt(json.pakai_biaya) == 1 ? json.sasaran_biaya : '-');
                $('#td_real_ak').html(json.realisasi_angka_kredit);
                $('#td_real_out').html(json.realisasi_kuantitas_output + ' ' + json.satuan_kuantitas);
                $('#td_real_mutu').html(json.realisasi_kualitas_mutu + '%');
                $('#td_real_biaya').html(parseInt(json.pakai_biaya) == 1 ? json.realisasi_biaya : '-');
                $('#nilai_penghitungan').html(parseFloat(json.progress).toFixed(2));
                $('#skor_skp').html(parseFloat(json.skor).toFixed(2));
                form_penilaian_showed = false;
                $('#button_form_penilaian').html("Ubah Penilaian");
                sembunyikan_form_penilaian();
            } else {
                alert(json.reason);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
var tabel_aktivitas = null;
function init_tabel_progress() {
    if (tabel_aktivitas != null) {
        tabel_aktivitas.fnDestroy();
    }
    tabel_aktivitas = $('#tabel_progress').dataTable({
        order: [[1, "asc"]],
        "columnDefs": [{"targets": [0], "orderable": false}],
        "processing": true,
        "serverSide": true,
        "ajax": {
            'method': 'post',
            'data': {
                id_detil_pekerjaan: detil_pekerjaan['id_detil_pekerjaan'],
                id_pekerjaan: id_pekerjaan
            },
            "url": site_url + "/aktivitas_pekerjaan/get_list_progress_pekerjaan_datatable",
            "dataSrc": function (json) {
                var jsonData = json.data;
                return jsonData;
            }
        },
        "createdRow": function (row, data, index) {
            var tgl_mulai = data[4];
            var tgl_mulai_tmzn = tgl_mulai.split('+');
            var tgl_jam_mulai = tgl_mulai_tmzn[0].split(' ');
            var tgl_selesai = data[8];
            var tgl_selesai_tmzn = tgl_selesai.split('+');
            var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
            var id = data[1];

            var validated = parseInt(data[6]);
            var list_berkas = JSON.parse(data[9]);
            var list_id_berkas = JSON.parse(data[5]);
            var html_berkas = '';
            if (list_berkas != null) {
                for (var i = 0, n = list_berkas.length; i < n; i++) {
                    html_berkas += '<a href="' + site_url + '/download?id_file=' + list_id_berkas[i] + '" target="_blank" title="' + list_berkas[i] + '"><i class="fa fa-paperclip fa-fw"></i></a> ';
                }
            }
            var html = '<div class="btn-group">'
                    + '<button class="btn btn-default btn-xs dropdown-toggle btn-info" data-toggle="dropdown">Aksi <span class="caret"></span></button>'
                    + '<ul class="dropdown-menu">';
            if (validated == 0) {
                html += '<li><a href="javascript:viewValidateProgress(' + id + ');"><i class="fa fa-check fa-fw"></i> Validasi</a></li>';
            }
            html += '<li><a href="javascript:viewHapusProgress(' + id + ');"><i class="fa fa-times fa-fw"></i> Hapus</a></li>';
            html += '</ul></div>';

            $('td', row).eq(4).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);
            $('td', row).eq(0).html(html);

            $('td', row).eq(1).html(index + 1);
            $('td', row).eq(3).html(data[3] + '%');
            $('td', row).eq(5).html(html_berkas);
            $('td', row).eq(6).html('Unvalidated');
            if (validated == 1) {
                $('td', row).eq(6).html('Validated');
            }

            $(row).attr('id', 'row_' + id)
        }
    });
}
function init_tabel_aktivitas() {
    if (tabel_aktivitas != null) {
        tabel_aktivitas.fnDestroy();
    }
    tabel_aktivitas = $('#tabel_aktivitas').dataTable({
        order: [[1, "asc"]],
        "columnDefs": [{"targets": [0, 5], "orderable": false}],
        "processing": true,
        "serverSide": true,
        "ajax": {
            'method': 'post',
            'data': {
                id_detil_pekerjaan: detil_pekerjaan['id_detil_pekerjaan'],
                id_pekerjaan: id_pekerjaan
            },
            "url": site_url + "/aktivitas_pekerjaan/get_list_aktivitas_pekerjaan",
            "dataSrc": function (json) {
                var jsonData = json.data;
                return jsonData;
            }
        },
        "createdRow": function (row, data, index) {
            var id = data[1];
            var tgl_mulai = data[3];
            var tgl_mulai_tmzn = tgl_mulai.split('+');
            var tgl_jam_mulai = tgl_mulai_tmzn[0].split(' ');
            var tgl_selesai = data[10];
            var tgl_selesai_tmzn = tgl_selesai.split('+');
            var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
            var status_validasi = parseInt(data[5]);
            var html = '<div class="btn-group">'
                    + '<button class="btn btn-default btn-xs dropdown-toggle btn-info" data-toggle="dropdown">Aksi <span class="caret"></span></button>'
                    + '<ul class="dropdown-menu">';
            if (status_validasi == 0) {
                html += '<li><a href="javascript:viewValidasiAktivitas(' + id + ');"><i class="fa fa-check fa-fw"></i> Validasi</a></li>';
            }
            html += '<li><a href="javascript:viewHapusAktivitas(' + id + ');"><i class="fa fa-times fa-fw"></i> Hapus</a></li>';
            html += '</ul></div>';
            var list_id_berkas_json = JSON.parse(data[4]);
            var list_berkas = JSON.parse(data[12]);
            var html_berkas = '';
            if (list_id_berkas_json != null) {
				var sep='';
                for (var i = 0, n = list_id_berkas_json.length; i < n; i++) {
                    html_berkas += sep+'<a href="' + site_url + '/download?id_file=' + list_id_berkas_json[i] + '" target="_blank" title="' + list_berkas[i] + '"><i class="fa fa-paperclip fa-fw"></i>'+list_berkas[i]+'</a> ';
					sep='<br/>';
                }
            }
            $('td', row).eq(0).html(html);
            $('td', row).eq(1).html(index + 1);

//            $('td', row).eq(3).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);
            $('td', row).eq(3).html(data[13] + ' - ' + data[14]);
            $('td', row).eq(4).html(html_berkas);

            if (status_validasi == 1) {
                $('td', row).eq(5).html('Validated');
            } else {
                $('td', row).eq(5).html('Unvalidated');
            }
            $(row).attr('id', 'row_' + id)
        }
    });
}
function viewValidateProgress(id) {
    var row = $('#row_' + id);
    var deskripsi = $(row.children()[2]).html();
    if (confirm('Anda akan memvalidasi progress ' + deskripsi + '?') == true) {
        $.ajax({
            type: "POST",
            url: site_url + "/aktivitas_pekerjaan/validate_progress",
            data: {
                id_progress: id
            },
            success: function (data) {
                if (data == 'ok') {
                    tabel_aktivitas.fnDraw();
                } else {
                    alert(data);
                }
                $('.snake_loader').remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.snake_loader').remove();
            }
        });
    }
}
function viewValidasiAktivitas(id) {
    var row = $('#row_' + id);
    var deskripsi = $(row.children()[2]).html();
    if (confirm('Anda akan memvalidasi aktivitas ' + deskripsi + '?') == true) {
        $.ajax({
            type: "POST",
            url: site_url + "/aktivitas_pekerjaan/validate_aktivitas",
            data: {
                id_aktivitas: id
            },
            success: function (data) {
                if (data == 'ok') {
                    tabel_aktivitas.fnDraw();
                } else {
                    alert(data);
                }
                $('.snake_loader').remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.snake_loader').remove();
            }
        });
    }
}
function viewHapusProgress(id) {
    var row = $('#row_' + id);
    var deskripsi = $(row.children()[2]).html();
    if (confirm('Anda akan menghapus progress ' + deskripsi + '?') == true) {
        $.ajax({
            type: "POST",
            url: site_url + "/aktivitas_pekerjaan/hapus_progress",
            data: {
                id_progress: id
            },
            success: function (data) {
                if (data == 'ok') {
                    tabel_aktivitas.fnDraw();
                } else {
                    alert(data);
                }
                $('.snake_loader').remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.snake_loader').remove();
            }
        });
    }
}
function viewHapusAktivitas(id) {
    var row = $('#row_' + id);
    var deskripsi = $(row.children()[2]).html();
    if (confirm('Anda akan menghapus aktivitas ' + deskripsi + '?') == true) {
        $.ajax({
            type: "POST",
            url: site_url + "/aktivitas_pekerjaan/hapus_aktivitas",
            data: {
                id_aktivitas: id
            },
            success: function (data) {
                if (data == 'ok') {
                    tabel_aktivitas.fnDraw();
                } else {
                    alert(data);
                }
                $('.snake_loader').remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.snake_loader').remove();
            }
        });
    }
}