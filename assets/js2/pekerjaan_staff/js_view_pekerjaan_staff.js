$(document).ready(function () {
    $('#tabel_pekerjaan_staff').dataTable();
    $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    document.title = "Daftar Pekerjaan Staff - Task Management";
    $('#submenu_pekerjaan_ul').show();
});

var list_nip = [];
var list_nama = [];
var list_departemen = [];
var list_id = [];
var sudah_diproses = false;
var tabel_list_enroll_staff = null;
function query_staff() {

    if (list_id.length === 0) {
        var jumlah_data = list_staff.length;
        for (var i = 0; i < jumlah_data; i++) {
            //var id = json.data[i]["id_akun"];
            list_nip[i] = list_staff[i]['nip'];
            list_nama[i] = list_staff[i]['nama'];
            list_departemen[i] = list_staff[i]['nama_departemen'];
            list_id[i] = list_staff[i]["id_akun"];
            var id = list_id[i];
            sudah_diproses = true;
            var cell = $('#nama_staff_' + id);
            if (cell.length > 0) {
                cell.html(list_nama[i]);
            }
        }
    }
}
var tab_aktif = '';
function tampilkan_staff_skp() {
    tab_aktif = 'skp';
    tampilkan_staff();
}
function tampilkan_staff_tugas_tambahan() {
    tab_aktif = 'tambahan';
    tampilkan_staff();
}
function tampilkan_staff_kreativitas() {
    tab_aktif = 'kreativitas';
    tampilkan_staff();
}
function tampilkan_staff() {
    var tubuh = $("#tabel_list_enroll_staff_body");
    if (sudah_diproses === false) {
        query_staff();
    }
    var jumlah_staff = list_id.length;
    if (tabel_list_enroll_staff != null) {
        tabel_list_enroll_staff.fnDestroy();
    }
    tubuh.html("");
    var crow = 0;
    for (var i = 0; i < jumlah_staff; i++) {
        if ($('#staff_' + tab_aktif + '_' + list_id[i]).length > 0)
            continue;
        var row_id = 'tabel_list_enroll_staff_row_' + list_id[i];
        var new_row = true;
        if ($('#' + row_id).length == 0) {
            tubuh.append('<tr id="' + row_id + '"></tr>');
            crow++;
        } else {
            new_row = false;
        }
        var row = $('#' + row_id);
        if (new_row) {
            row.append('<td>' + crow + '</td>');
            row.append('<td>' + list_nip[i] + '</td>');
            row.append('<td>' + list_departemen[i] + '</td>');
            row.append('<td>' + list_nama[i] + '</td>');
            row.append('<td><input type="checkbox" id="enroll_' + list_id[i] + '" name="enroll_' + list_id[i] + '"/></td>');
        }
        //row.append('<td><div class="minimal-green single-row"><div class="checkbox"><div class="icheckbox_minimal-green checked" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></input><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><label>Green</label></div></div></td>')
        $('#enroll_' + list_id[i]).attr('checked', false);
    }
    tabel_list_enroll_staff = $('#tabel_list_enroll_staff').dataTable();
}
function pilih_staff_ok() {
    var jumlah_data = list_id.length;

    for (var i = 0; i < jumlah_data; i++) {
        if ($('#enroll_' + list_id[i]).attr('checked')) {
            var enrolled_staff = $('<input></input>').attr({id: 'staff_enroll_' + tab_aktif + '_' + list_id[i], name: 'staff_enroll[]', value: list_id[i], type: 'hidden'});
            $('#tabel_assign_staff_' + tab_aktif).append('<tr id="staff_' + tab_aktif + '_' + list_id[i] + '">' +
                    '<td id="nama_staff_' + tab_aktif + '_' + list_id[i] + '">' + list_nama[i] + '</td>' +
                    '<td id="aksi_' + list_id[i] + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px" onclick="delete_enrolled_staff(' + list_id[i] + ',\''+tab_aktif+'\')">Hapus</a></td>' +
                    '</tr>');
            $('#nama_staff_' + tab_aktif + '_' + list_id[i]).append(enrolled_staff);
        }
    }
    $('#tombol_tutup').click();
}
function delete_enrolled_staff(id_staff,tab) {
    $('#staff_'+tab+'_' + id_staff).remove();
}
$('#pilih_berkas_assign').change(function () {
    var pilih_berkas = document.getElementById('pilih_berkas_assign');
    var files = pilih_berkas.files;
    populate_file('berkas_baru', files);
});
function populate_file(id_tabel, files) {
    $('#' + id_tabel).html('');
    var jumlah_file = files.length;
    for (var i = 0; i < jumlah_file; i++) {
        $('#' + id_tabel).append('<tr id="berkas_baru_' + i + '">' +
                '<td id="nama_berkas_baru_' + i + '">' + files[i].name + ' ' + format_ukuran_file(files[i].size) + '</td>' +
                '<td id="keterangan_' + i + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px">Baru</a></td>' +
                '</tr>');
    }
}
$('#button_trigger_file').click(function () {
    $('#pilih_berkas_assign').click();
});
function format_ukuran_file(s) {
    var KB = 1024;
    var spasi = ' ';
    var satuan = 'bytes';
    if (s > KB) {
        s = s / KB;
        satuan = 'KB';
    }
    if (s > KB) {
        s = s / KB;
        satuan = 'MB';
    }
    return '   [' + Math.round(s) + spasi + satuan + ']';
}
