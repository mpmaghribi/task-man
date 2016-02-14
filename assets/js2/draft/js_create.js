jQuery(document).ready(function () {
    init_input_deadline();
    periode_changed();
    kategori_changed();
});

function change_input_deadline(periode) {
    draft_date_min = new Date(periode, 0, 1, 0, 0, 0);
    draft_date_max = new Date(periode, 11, 31, 23, 59, 59);
    waktu_mulai_baru.setValue(draft_date_min);
    waktu_selesai_baru.setValue(draft_date_max);
}
function draft_file_changed() {
    var input_file = document.getElementById("pilih_berkas_draft");
    var files = input_file.files;
    console.log(input_file);
    console.log(files);
    populate_file("berkas_baru", files);
}
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
function dialog_hapus_file(id){
    var tr = $('#berkas_'+id);
    console.log(tr);
    var tds = tr.children();
    console.log(tds);
    if(tds.length == 0){
        return;
    }
    var deskripsi = tds[1].innerHTML;
    $('#modal_any').modal('show');
    $('#modal_any_title').html('Konfirmasi Hapus Berkas Draft');
    $('#modal_any_body').html('<h5>Anda akan menghapus berkas <strong>'+deskripsi+'</strong>. Lanjutkan?</h5>');
    $('#modal_any_button_cancel').attr({'class':'btn btn-success'}).html('Batal');
    $('#modal_any_button_ok').attr({'class':'btn btn-danger', 'onclick':'hapus_file('+id+')'}).html('Hapus Berkas');
}
function hapus_file(id) {
    $.ajax({
        data: {
            id_file: id
        },
        type: "get", 
        url: site_url + "/draft/hapus_file_json",
        success: function (response) { 
            var json = jQuery.parseJSON(response);
            if (json.status === "ok") {
                $('#berkas_' + id).remove();
            } else {
                alert("Gagal menghapus file, " + json.reason);
            }
        }
    });
}
var draft_date_min = new Date();
var draft_date_max = new Date();
var waktu_mulai_baru = null;
var waktu_selesai_baru = null;
function init_input_deadline() {
//    draft_date_min = new Date(periode, 0, 1, 0, 0, 0);
//    draft_date_max = new Date(periode, 11, 31, 23, 59, 59);
    console.log(draft_date_min);
    console.log(draft_date_max);
    waktu_mulai_baru = $('#waktu_mulai_baru').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date < draft_date_min || date > draft_date_max ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        //waktu_selesai_baru.setValue(new Date(ev.date));
        waktu_mulai_baru.hide();
        $('#waktu_selesai_baru').focus();
    }).data('datepicker');
    waktu_selesai_baru = $('#waktu_selesai_baru').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date < draft_date_min || date > draft_date_max || waktu_mulai_baru.date > date ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        waktu_selesai_baru.hide();
    }).data('datepicker');
    waktu_mulai_baru.setValue(draft_date_min);
    waktu_selesai_baru.setValue(draft_date_max);
}
function kategori_changed() {
    var kategori = $('#select_kategori').val();
    if (kategori == 'rutin' || kategori == 'project') {
        $('#div_angka_kredit').show('fast');
        $('#div_kuantitas').show('fast');
        $('#div_kualitas').show('fast');
        $('#div_biaya').show('fast');
        $('#div_manfaat').hide('fast');
    } else {
        $('#div_angka_kredit').hide('fast');
        $('#div_kuantitas').hide('fast');
        $('#div_kualitas').hide('fast');
        $('#div_biaya').hide('fast');
        if (kategori == 'tambahan') {
            $('#div_manfaat').hide('fast');
        } else if (kategori == 'kreativitas') {
            $('#div_manfaat').show('fast');
        }
    }
}
function periode_changed() {
    var periode = parseInt($('#select_periode').val());
    if (isNaN(periode)) {
        var t = new Date();
        periode = t.getFullYear();
    }
    periode = Math.max(1945, Math.abs(periode));
    $('#select_periode').val(periode);
    change_input_deadline(periode);
}
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

function trigger_pilih_file() {
    $("#pilih_berkas_draft").trigger("click");
}