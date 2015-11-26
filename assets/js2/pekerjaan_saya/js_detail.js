$(document).ready(function () {
    $('#staff_pekerjaan').dataTable({        
    });
    init_tabel_aktivitas();
    $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    $('#submenu_pekerjaan_ul').show();
    $('#waktu_mulai_baru').datepicker({format: 'dd-mm-yyyy'});
    $('#waktu_selesai_baru').datepicker({format: 'dd-mm-yyyy'});
});
var tabel_aktivitas = null;
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
                id_staff: id_staff,
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
            $('td', row).eq(4).html(data[4]+' '+detil_pekerjaan['satuan_kuantitas']);
            $('td', row).eq(5).html(data[5]+'%');
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
    $.ajax({
        type: "POST",
        url: base_url + "index.php/aktivitas_pekerjaan/add",
        data: {
            id_pekerjaan:id_pekerjaan,
            id_akun:id_staff,
            ak:$('#ak_baru').val(),
            keterangan:$('#keterangan_baru').val(),
            kuantitas_output:$('#kuantitas_output_baru').val(),
            kualitas_mutu:$('#kualitas_mutu_baru').val(),
            biaya:$('#biaya_baru').val(),
            waktu_mulai:$('#waktu_mulai_baru').val(),
            waktu_selesai:$('#waktu_selesai_baru').val()
        },
        success: function (data) {
            if(data=='ok'){
                tampilkan_form_tambah_aktivitas();
                tabel_aktivitas.fnDraw();
            }else{
                alert(data);
            }
            $('.snake_loader').remove();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('.snake_loader').remove();
        }
    });
}
