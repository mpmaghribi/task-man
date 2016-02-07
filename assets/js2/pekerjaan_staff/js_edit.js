$(document).ready(function () {
    init_assigned_staff();
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