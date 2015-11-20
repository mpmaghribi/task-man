$(document).ready(function () {
    $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    document.title = "Daftar Pekerjaan Staff - Task Management";
    $('#submenu_pekerjaan_ul').show();
    init_tabel_pekerjaan_staff();
});
var tabel_pekerjaan_staff = null;
function init_tabel_pekerjaan_staff() {
    if (tabel_pekerjaan_staff != null) {
        tabel_pekerjaan_staff.fnDestroy();
    }
    var warna_label=[];
    warna_label[1]='label-warning';
    warna_label[2]='label-info';
    warna_label[3]='label-default';
    warna_label[4]='label-success';
    warna_label[5]='label-danger';
    warna_label[10]='label-info';
    tabel_pekerjaan_staff = $('#tabel_pekerjaan_staff').dataTable({
        order: [[0, "desc"]],
        "columnDefs": [{"targets": [5], "orderable": false}],
        "processing": true,
        "serverSide": true,
        "ajax": {
            'method': 'post',
            'data': {
                id_staff: id_staff
            },
            "url": site_url + "/pekerjaan_staff/get_list_skp",
            "dataSrc": function (json) {
                var jsonData = json.data;
                return jsonData;
            }
        },
        "createdRow": function (row, data, index) {
            var tgl_mulai = data[2];
            var tgl_selesai = data[8];
            var tgl_mulai_arr = tgl_mulai.split(' ');
            var tgl_selesai_arr = tgl_selesai.split(' ');
            $('td', row).eq(2).html(tgl_mulai_arr[0] + ' - ' + tgl_selesai_arr[0]);
            var sasaran_jumlah = parseFloat(data[4]) || 0;
            var sasaran_waktu = parseFloat(data[5]) || 0;
            var realisasi_jumlah = parseFloat(data[6]) || 0;
            var realisasi_waktu = parseFloat(data[7]) || 0;
            var selisih_jumlah = realisasi_jumlah - sasaran_jumlah;
            var sekarang = data[9];
//            console.log(selisih_jumlah);
            var list_anggota = data[3].replace('}', '').replace('{', '').split(',');
            var anggota = '';
            var sep = '';
            for (var i = 0, n = list_staff.length; i < n; i++) {
                var st = list_staff[i];
                if (list_anggota.indexOf(st['id_akun']) >= 0) {
                    anggota += sep + st['nama'];
                    sep = '<br/>';
                }
            }
//            console.log(list_anggota);
            $('td', row).eq(3).html(anggota);
//            $('td', row).eq(4).html(data[10]);
            var status_pekerjaan_arr = data[10].split(',');
            
            var html = '<span class="label '+warna_label[status_pekerjaan_arr[0]]+' label-mini">' + status_pekerjaan_arr[1] + '</span>';
            $('td', row).eq(4).html(html);
            $('td',row).eq(5).html('<a  href="'+site_url+'/pekerjaan_staff/detail_skp?id_pekerjaan='+data[0]+'" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
            $(row).attr('id', 'row_' + index)
        }
    });
}