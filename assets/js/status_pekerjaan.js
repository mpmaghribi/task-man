var status_nama = ["Not Approved", "Belum Dibaca", "Sudah Dibaca", "Dikerjakan", "Selesai", "Terlambat"];
var status_label = ["danger", "primary", "info", "success", "inverse", "default"];
console.log(status_nama);
console.log(status_label);
var min_element_status = [];
var total_progress = [];
var jumlah_data_progress = [];
function ubah_status_pekerjaan(id, flag, sekarang, tgl_selesai, tgl_read, status_, progress) {
    if (!min_element_status[id]) {
        min_element_status[id] = 5;
        total_progress[id] = 0;
        jumlah_data_progress[id] = 0;
    }
    jumlah_data_progress[id]++;
    var status_id = min_element_status[id];
    if (flag == 1) {//masih usulan, belum di-acc
        status_id = 0;
        min_element_status[id] = 0;
    } else if (flag == 2) {//sudah di-acc
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
                        total_progress[id] += 100;
                    }
                } else {
                    if (min_element_status[id] > 3) {
                        status_id = 3;
                        min_element_status[id] = 3;
                        total_progress[id] += progress;
                    }
                }
            }
        } else {
            status_id = 5;
        }
    }
    var new_label = '';
    if (total_progress[id]>0) {
        var nilai_progress = total_progress[id] / jumlah_data_progress[id];
        new_label = '<div class="progress progress-striped active progress-sm" style="margin:0px;">'
                + '<div  class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="' + nilai_progress
                + '" aria-valuemin="0" aria-valuemax="100" style="width: '+nilai_progress+'%">'
                + '<span class="sr-only">'+nilai_progress+'% Complete</span>'
                + '</div>'
                + '</div>';
        console.log('status adalah progress bar');
    }
    else {
        new_label = '<span class="label label-' + status_label[status_id] + ' label-mini">' + status_nama[status_id] + '</span>';
        console.log('status adalah label');
    }
    console.log('set ' + id + ' to id status ' + status_id + ' => ' + status_nama[status_id] + '  |||||  ' + min_element_status[id]);
    $('#' + id).html(new_label);
}