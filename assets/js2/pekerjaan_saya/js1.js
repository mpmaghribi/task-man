jQuery(document).ready(function () {
    initTablePekerjaanSaya();
});
var tablePekerjaanSaya = null;
var warna_label=[];
    warna_label[1]='label-warning';
    warna_label[2]='label-info';
    warna_label[3]='label-default';
    warna_label[4]='label-success';
    warna_label[5]='label-danger';
    warna_label[10]='label-info';
function initTablePekerjaanSaya() {
    console.log('fungsi initTablePekerjaanSaya');
    if (tablePekerjaanSaya !== null) {
        tablePekerjaanSaya.fnDestroy();
    }
    tablePekerjaanSaya = $("#tablePekerjaanSaya").dataTable({
        order: [[0, "desc"]],
        "columnDefs": [{"targets": [5], "orderable": false}],
        "processing": true,
        "serverSide": true,
        "ajax": {
            'method': 'post',
            'data': {
            },
            "url": site_url + "/pekerjaan_saya/get_list_pekerjaan_saya_datatable",
            "dataSrc": function (json) {
                var jsonData = json.data;
                return jsonData;
            }
        },
        "createdRow": function (row, data, index) {
            var tgl_mulai = data[2];
            var tgl_mulai_tmzn = tgl_mulai.split('+');
            var tgl_jam_mulai = tgl_mulai_tmzn[0].split(' ');
            var tgl_selesai = data[2];
            var tgl_selesai_tmzn = tgl_selesai.split('+');
            var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
            $('td', row).eq(2).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);
            var list_anggota = data[3].replace('}', '').replace('{', '').split(',');
            var anggota = '';
            var sep = '';
            for (var i = 0, n = list_user.length; i < n; i++) {
                var st = list_user[i];
                if (list_anggota.indexOf(st['id_akun']) >= 0) {
                    anggota += sep + st['nama'];
                    sep = '<br/>';
                }
            }
            $('td', row).eq(3).html(anggota);
            var status_pekerjaan_arr = data[4].split(',');
            var html = '<span class="label '+warna_label[status_pekerjaan_arr[0]]+' label-mini">' + status_pekerjaan_arr[1] + '</span>';
            $('td', row).eq(4).html(html);
            $('td',row).eq(5).html('<a  href="'+base_url+'pekerjaan_saya/detail?id_pekerjaan='+data[0]+'" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
            $(row).attr('id', 'row_' + index)
        }
    });
}