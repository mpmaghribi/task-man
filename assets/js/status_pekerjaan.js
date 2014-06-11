var status_nama = ["Not Approved", "Belum Dibaca", "Sudah Dibaca", "Dikerjakan", "Selesai", "Terlambat"];
var status_label = ["danger", "primary", "info", "success", "inverse", "default"];
console.log(status_nama);
console.log(status_label);
var min_element_status = [];
function ubah_status_pekerjaan(id, flag, sekarang, tgl_selesai, tgl_read, status_, progress) {
    //console.log('update status  ' + id + ' ' + flag + ' ' + sekarang + ' ' + tgl_selesai + ' ' + tgl_read + ' ' + status_ + ' ' + progress);
    
    //console.log(min_element_status[id]);
    if (!min_element_status[id])
        min_element_status[id] = 5;
    var status_id = min_element_status[id];
    if (flag == 1) {
        status_id = 0;
        min_element_status[id] = 0;
    } else if (flag == 2) {
        if (sekarang <= tgl_selesai) {
            if (tgl_read == null || tgl_read.length == 0) {
                status_id = 1;
                min_element_status[id] = 1;
            }
            else {
                if (progress == 0) {
                    if (min_element_status[id] > 2) {
                        status_id = 2;
                        min_element_status[id] = 2;
                    }
                } else if (progress == 100) {
                    if (min_element_status[id] > 4) {
                        status_id = 4;
                        min_element_status[id] = 4;
                    }
                } else {
                    if (min_element_status[id] > 3) {
                        status_id = 3;
                        min_element_status[id] = 3;
                    }
                }
            }
        } else {
            status_id = 5;
        }
    }
    var new_label = '<span class="label label-' + status_label[status_id] + ' label-mini">' + status_nama[status_id] + '</span>';
    console.log('set ' + id + ' to id status ' + status_id + ' => ' + status_nama[status_id] + '  |||||  ' + min_element_status[id]);
    $('#' + id).html(new_label);
}