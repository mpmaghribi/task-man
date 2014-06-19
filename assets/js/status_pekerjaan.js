var status_nama = ["Not Approved", "Belum Dibaca", "Sudah Dibaca", "Dikerjakan", "Selesai", "Terlambat","Request Perpanjang"];
var status_label = ["danger", "primary", "info", "success", "inverse", "default","default"];
//console.log(status_nama);
//console.log(status_label);
var min_element_status = [];
var total_progress = [];
var jumlah_data_progress = [];
var satu_hari = 1000 * 60 * 60 * 24;
function subah_status_pekerjaan(id, flag, sekarang, tgl_mulai, tgl_selesai, tgl_read, status_, progress) {
    if (!min_element_status[id]) {
        min_element_status[id] = 5;
        total_progress[id] = 0;
        jumlah_data_progress[id] = 0;
        console.log("register new index status");
    }
    //console.log('mulai    = ' + tgl_mulai + ' sekarang = ' + sekarang + ' deadline = ' + tgl_selesai);
    //console.log('sekarang = ' + sekarang);
    //console.log('deadline = ' + tgl_selesai);

    if (sekarang.substring(0, 10) <= tgl_selesai.substring(0, 10)) {
        //console.log(id + " masih bisa dikerjakan");
    }
    else {
        //console.log(id + " terlambat");
    }
    //console.log(tgl_selesai-sekarang);
    jumlah_data_progress[id]++;
    var status_id = min_element_status[id];
    if (flag == 1) {//masih usulan, belum di-acc
        status_id = 0;
        min_element_status[id] = 0;
    } else if (flag == 2) {//sudah di-acc
        if (sekarang.substring(0, 10) <= tgl_selesai.substring(0, 10)) {
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
                    total_progress[id] += 100;
                } else {
                    if (min_element_status[id] > 3) {
                        status_id = 3;
                        min_element_status[id] = 3;
                        
                    }
                    total_progress[id] += progress;
                }
            }
        } else {
            status_id = 5;
        }
    }else if(flag==9){
        status_id=6;
    }
    var new_label = '';
    //console.log("total progress = " + total_progress[id]);
    if (total_progress[id] > 0) {
        var nilai_progress = total_progress[id] / jumlah_data_progress[id];
        nilai_progress = (new Number(nilai_progress)).toPrecision(4);
        var tanggal_mulai = new Date(tgl_mulai.substring(0, 10));
        var tanggal_sekarang = new Date(sekarang.substring(0, 10));
        var tanggal_selesai = new Date(tgl_selesai.substring(0, 10));
        var sisa_hari = (tanggal_selesai - tanggal_sekarang) / satu_hari;
        var jumlah_hari = (tanggal_selesai - tanggal_mulai) / satu_hari;

        //console.log('sisa hari = '+sisa_hari);
        //console.log('lama hari = ' + jumlah_hari);

        var persentase = sisa_hari / jumlah_hari;

        //console.log('persen hari = ' + persentase);
        var progress_warna = 0;
        if (persentase > 0.5) {
            progress_warna = 3;
        } else if (persentase > 0.4) {
            progress_warna = 2;
        } else if (persentase > 0.35) {
            progress_warna = 1;
        } else {
            progress_warna = 0;
        }
        new_label = '<div class="progress progress-striped active progress-sm" style="margin:0px;" title="' + nilai_progress + '% Complete, ' + sisa_hari + ' hari lagi">'
                + '<div  class="progress-bar progress-bar-' + status_label[progress_warna] + '"  role="progressbar" aria-valuenow="' + nilai_progress
                + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + nilai_progress + '%">'
                + '<span class="sr-only">' + nilai_progress + '% Complete</span>'
                + '</div>'
                + '</div>';
        //console.log('status adalah progress bar');
    }
    else {
        new_label = '<span class="label label-' + status_label[status_id] + ' label-mini">' + status_nama[status_id] + '</span>';
        //console.log('status adalah label');
    }
    //console.log('set ' + id + ' to id status ' + status_id + ' => ' + status_nama[status_id] + '  |||||  ' + min_element_status[id]);
    $('#' + id).html(new_label);
}