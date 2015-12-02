$(document).ready(function () {
    $('#staff_pekerjaan').dataTable({});
    $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    $('#submenu_pekerjaan_ul').show();
    $('#waktu_mulai_baru').datepicker({format: 'dd-mm-yyyy'});
    $('#waktu_selesai_baru').datepicker({format: 'dd-mm-yyyy'});
    if (pekerjaan['kategori'] == 'rutin' || pekerjaan['kategori'] == 'project') {
        $('#tabel_progress').hide();
        $('#div_penilaian_skp').show();
        init_tabel_aktivitas();
    } else {
        $('#tabel_aktivitas').hide();

        init_tabel_progress();
    }
    init_tampilan_form_tambah_aktivitas();
    $('#file_berkas_aktivitas').on('change', function (e) {
        var tabel = $('#tabel_berkas_aktivitas');
        tabel.html('');
        console.log(this.files);
        for (var i = 0, n = this.files.length; i < n; i++) {
            var f = this.files[i];
            var html = '<tr>'
                    + '<td>' + f.name + '</td>'
                    + '</tr>';
            tabel.append(html);
        }
    });
});
function refreshAktivitas() {
    if (tabel_aktivitas != null) {
        tabel_aktivitas.fnDraw();
    }
}
function pilih_berkas_aktivitas() {
    $('#file_berkas_aktivitas').click();
    return false;
}
function init_tampilan_form_tambah_aktivitas() {
    $('#div_aktivitas_angka_kredit').hide();
    $('#div_aktivitas_kualitas_mutu').hide();
    $('#div_aktivitas_biaya').hide();
    if (pekerjaan['kategori'] == 'rutin' || pekerjaan['kategori'] == 'project') {
        $('#div_nilai_progress').hide();
    } else {
        $('#div_aktivitas_kuantitas_output').hide();
    }
}
function viewHapusProgress(id) {
    var row = $('#row_' + id);
    var nama_progress = $(row.children()[2]).html();
    if (confirm("Apakah Anda yakin menghapus porgress " + nama_progress + "?") == true) {
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
            var tgl_selesai = data[6];
            var tgl_selesai_tmzn = tgl_selesai.split('+');
            var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
            var id = data[0];
            var html = '<div class="btn-group">'
                    + '<button class="btn btn-default btn-xs dropdown-toggle btn-info" data-toggle="dropdown">Aksi <span class="caret"></span></button>'
                    + '<ul class="dropdown-menu">'
                    + '<li><a href="javascript:viewDetailProgress(' + id + ');"><i class="fa fa-eye fa-fw"></i> Detail</a></li>';
            var validated = parseInt(data[7]);
            var list_berkas = JSON.parse(data[8]);
            var list_id_berkas = JSON.parse(data[9]);
            var html_berkas = '';
            if (list_berkas != null) {
                for (var i = 0, n = list_berkas.length; i < n; i++) {
                    html_berkas += '<a href="' + site_url + '/download?id_file=' + list_id_berkas[i] + '" target="_blank" title="' + list_berkas[i] + '"><i class="fa fa-paperclip fa-fw"></i></a> ';
                }
            }
            if (validated == 0) {
                html += '<li><a href="javascript:viewEditProgress(' + id + ');"><i class="fa fa-pencil-square-o fa-fw"></i> Edit</a></li>';
                html += '<li><a href="javascript:viewHapusProgress(' + id + ');"><i class="fa fa-times fa-fw"></i> Hapus</a></li>';
            }
            html += '</ul></div>';

            $('td', row).eq(4).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);
            $('td', row).eq(0).html(html);

            $('td', row).eq(1).html(index + 1);
            $('td', row).eq(3).html(data[3] + '%');
            $('td', row).eq(5).html(html_berkas);
            $('td', row).eq(6).html('Unvalidated');
            if(validated==1){
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
        "columnDefs": [{"targets": [0], "orderable": false}],
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
            var tgl_mulai = data[6];
            var tgl_mulai_tmzn = tgl_mulai.split('+');
            var tgl_jam_mulai = tgl_mulai_tmzn[0].split(' ');
            var tgl_selesai = data[8];
            var tgl_selesai_tmzn = tgl_selesai.split('+');
            var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
            $('td', row).eq(6).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);
            $('td', row).eq(0).html('');
            $('td', row).eq(4).html(data[4] + ' ' + detil_pekerjaan['satuan_kuantitas']);
            $('td', row).eq(5).html(data[5] + '%');
//            $('td', row).eq(5).html('<a  href="' + base_url + 'pekerjaan_staff/detail?id_pekerjaan=' + data[0] + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
            $(row).attr('id', 'row_' + index)
        }
    });
}
var status_form_tambah_aktivitas = false;
function tampilkan_form_tambah_aktivitas() {
    if (status_form_tambah_aktivitas) {
        $('#div_form_tambah_aktivitas').slideUp();
        $('#button_tampilkan_form_aktivitas').html('Tambah Aktivitas');
        status_form_tambah_aktivitas = false;
    } else {
        status_form_tambah_aktivitas = true;
        $('#div_form_tambah_aktivitas').slideDown();
        $('#button_tampilkan_form_aktivitas').html('Batal');
        $('#keterangan_baru').val('');
        $('#ak_baru').val('');
        $('#biaya_baru').val('');
        $('#kuantitas_output_baru').val('');
        $('#kualitas_mutu_baru').val('');
        $('#waktu_mulai_baru').val('');
        $('#waktu_selesai_baru').val('');
    }
}
function simpan_aktivitas() {
    tampilkan_form_tambah_aktivitas();
    $('#form_tambah_aktivitas').submit();
//    $.ajax({
//        type: "POST",
//        url: base_url + "index.php/aktivitas_pekerjaan/add",
//        data: {
//            id_pekerjaan: id_pekerjaan,
//            id_akun: id_staff,
//            ak: $('#ak_baru').val(),
//            keterangan: $('#keterangan_baru').val(),
//            kuantitas_output: $('#kuantitas_output_baru').val(),
//            kualitas_mutu: $('#kualitas_mutu_baru').val(),
//            biaya: $('#biaya_baru').val(),
//            waktu_mulai: $('#waktu_mulai_baru').val(),
//            waktu_selesai: $('#waktu_selesai_baru').val()
//        },
//        success: function (data) {
//            if (data == 'ok') {
//                tampilkan_form_tambah_aktivitas();
//                tabel_aktivitas.fnDraw();
//            } else {
//                alert(data);
//            }
//            $('.snake_loader').remove();
//        },
//        error: function (xhr, ajaxOptions, thrownError) {
//            $('.snake_loader').remove();
//        }
//    });
}
