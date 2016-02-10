$(document).ready(function () {
    init_assigned_staff();
    init_berkas_pekerjaan();
    ubah_view_input(pekerjaan['kategori']);
    if(input_deadline_mulai != null){
        var tanggal1 = pekerjaan['tanggal_mulai'].split('-');
        var tanggal2 = new Date(tanggal1[2], parseInt(tanggal1[1])-1, tanggal1[0], 0, 0, 0, 0);
        input_deadline_mulai.setValue(tanggal2);
    }
    if(input_deadline_selesai != null){
        var tanggal1 = pekerjaan['tanggal_selesai'].split('-');
        var tanggal2 = new Date(tanggal1[2], parseInt(tanggal1[1])-1, tanggal1[0], 0, 0, 0, 0);
        input_deadline_selesai.setValue(tanggal2);
    }
});
function init_assigned_staff() {
    var tabel = $('#tabel_assign_staff_skp');
    tab_aktif = 'skp';
    for (var i = 0, n = detil_pekerjaan.length; i < n; i++) {
        var dp = detil_pekerjaan[i];
        for (var j = 0, p = list_staff.length; j < p; j++) {
            var st = list_staff[j];
            if (dp['id_akun'] == st['id_akun']) {
                var id_akun=st['id_akun'];
                var enrolled_staff = $('<input></input>').attr({id: 'staff_enroll_' + tab_aktif + '_' + id_akun, name: 'staff_enroll[]', value: id_akun, type: 'hidden'});
                tabel.append('<tr id="staff_' + tab_aktif + '_' + id_akun + '">' +
                        '<td id="nama_staff_' + tab_aktif + '_' + id_akun + '">' + st['nama'] + '</td>' +
                        '<td id="aksi_' + id_akun + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px" onclick="delete_enrolled_staff(' + id_akun + ',\'' + tab_aktif + '\')">Hapus</a></td>' +
                        '</tr>');
                $('#nama_staff_' + tab_aktif + '_' + id_akun).append(enrolled_staff);
            }
        }
    }
}
function init_berkas_pekerjaan(){
    var tabel = $('#berkas_lama');
    for(var i=0, i2=list_berkas_pekerjaan.length; i<i2; i++){
        var berkas = list_berkas_pekerjaan[i];
        tabel.append(
                '<tr id="berkas_'+berkas['id_file']+'">'
                +'<td>'+berkas['nama_file']+'</td>'
                +'<td><a href="javascript:dialog_hapus_file('+berkas['id_file']+');" class="btn btn-danger btn-xs">Hapus</a></td>'
                +'</tr>'
                );
    }
}

function dialog_hapus_file(id_file){
    var tr = document.getElementById('berkas_'+id_file);
    if(tr == null){
        console.log('tr berkas is null');
        return;
    }
    var tds = tr.children;
    if(tds.length<1){
        console.log('tr tidak punya children');
        return;
    }
    var deskripsi = tds[0].innerHTML;
    $('#modal_any').modal('show');
    $('#modal_any_title').html('Konfirmasi Hapus Berkas Pekerjaan');
    $('#modal_any_body').html('<h5>Anda akan menghapus berkas pekerjaan <strong>'+deskripsi+'</strong>. Lanjutkan?</h5>');
    $('#modal_any_button_ok').attr({'onclick': 'hapus_file('+id_file+');', 'class':'btn btn-danger'}).html('Hapus');
    $('#modal_any_button_cancel').attr({'onclick': '', 'class':'btn btn-info'}).html('Batal');
}

function hapus_file(id_file){
    $.ajax({
        type: "get",
        url: site_url + "/pekerjaan_staff/hapus_file_json",
        data: {
            id_file: id_file
        },
        success: function (data) {
            var json = JSON.parse(data);
            if(json['status'] == 'ok'){
                $('#berkas_'+id_file).remove();
            }else{
                alert(json['reason']);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
