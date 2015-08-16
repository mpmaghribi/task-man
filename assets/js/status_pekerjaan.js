var status_nama = ["Usulan", "Belum Dibaca", "Sudah Dibaca", "Dikerjakan", "Selesai", "Terlambat", "Request Perpanjang"];
var status_label = ["danger", "primary", "info", "success", "inverse", "default", "default"];
//console.log(status_nama);
//console.log(status_label);
var min_element_status = [];
var total_progress = [];
var jumlah_data_progress = [];
var satu_hari = 1000 * 60 * 60 * 24;
var pp = [];

function ubah_status_pekerjaan(id, flag, sekarang, tgl_mulai, tgl_selesai, tgl_read, status_, progress) {
    if (!min_element_status[id]) {
        min_element_status[id] = 4;
        //total_progress[id] = 0;
        //jumlah_data_progress[id] = 0;
        console.log("\n\nregister new index status => " + id);
        pp[id] = {
            id_element: id,
            status_pekerjaan: flag,
            waktu_sekarang: sekarang,
            tgl_mulai: tgl_mulai,
            tgl_selesai: tgl_selesai,
            tgl_read: tgl_read,
            nilai_progress: progress,
            jumlah_pegawai: 1,
            status_kode: 0,
            kode_html: ''
        };
    } else {
        console.log("index status already exist => " + id);
        pp[id].jumlah_pegawai++;
        pp[id].nilai_progress = (pp[id].nilai_progress + progress);
        if (pp[id].tgl_read.length == 0) {
            pp[id].tgl_read = tgl_read;
        }
    }
///var status_nama = ["Usulan", "Belum Dibaca", "Sudah Dibaca", "Dikerjakan", "Selesai", "Terlambat", "Request Perpanjang"];
    var ppp = pp[id];
    if (ppp.status_pekerjaan == 1) {
        //pekerjaan masih berupa usulan
        ppp.status_kode = 0;
    } else if (ppp.status_pekerjaan == 2) {
        //pekerjaan berada dalam status sudah di-acc oleh penanggung jawab
        if (ppp.tgl_read.length == 0) {
            //pekerjaan tersebut belum dilihat secara detil oleh pegawai
            //sehingga berstatus Belum dibaca
            ppp.status_kode = 1;
        } else {
            //pekerjaan tersebut telah dilihat secara detil oleh pegawai
            //sehingga berstatus sudah dibaca
            ppp.status_kode = 2;
            if (ppp.tgl_mulai.substring(0, 10) <= ppp.waktu_sekarang.substring(0, 10)) {
                //jika waktu sekarang berada di sebelah kanan waktu mulai pekerjaan
                var nilai_progress = ppp.nilai_progress / ppp.jumlah_pegawai;
                if (ppp.tgl_selesai.substring(0, 10) >= ppp.waktu_sekarang.substring(0, 10)) {
                    //jika waktu sekarang ada di sebelah kiri waktu selesai pekerjaan
                    //pekerjaan berada di dalam masa pengerjaan
                    ppp.kode_html = '<div class="progress progress-striped active progress-sm" style="margin:0px;" title="' + nilai_progress + '% Complete">'
                            + '<div class="progress-bar progress-bar-' + status_label[ppp.status_kode] + '"  role="progressbar" aria-valuenow="' + nilai_progress
                            + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + nilai_progress + '%">'
                            + '<span class="sr-only">' + nilai_progress + '% Complete</span>'
                            + '</div>'
                            + '</div>';
                    if (nilai_progress > 0)
                        ppp.status_kode = 3;
                } else {
                    //waktu sekarang berada di sebelah kanan waktu selesai pekerjaan
                    //pekerjaan tidak berada di dalam masa pengerjaan

                    if (parseInt(nilai_progress) == 100) {
                        //jika progress rata2 dari pegawai dalam pekerjaan tersebut
                        //telah mencapai 100%, maka pekerjaan selesai
                        ppp.status_kode = 4;
                    } else {
                        //pekerjaan belum selesai 100% hingga waktu terakhir pekerjaan
                        ppp.status_kode = 5;
                    }
                }
            }
        }
    } else if (ppp.status_pekerjaan == 9) {
        //pekerjaan dalam status minta diperpanjang, karena pekerjaan belum selesai namun
        //waktu pengerjaan sudah habis
        ppp.status_kode = 6;
    }
    if (ppp.status_kode != 3) {
        ppp.kode_html = '<span class="label label-' + status_label[ppp.status_kode] + ' label-mini">' + status_nama[ppp.status_kode] + '</span>';
    }
    $('#' + ppp.id_element).html(ppp.kode_html);
    //console.log([6, 2, 3, 4].indexOf(1));
    //console.log(progress_pekerjaan[id]);
    //console.log('sekarang = ' + sekarang);
    //console.log('deadline = ' + tgl_selesai);

//    if (sekarang.substring(0, 10) <= tgl_selesai.substring(0, 10)) {
//        //console.log(id + " masih bisa dikerjakan");
//    }
//    else {
//        //console.log(id + " terlambat");
//    }
//    //console.log(tgl_selesai-sekarang);
//    jumlah_data_progress[id]++;
//    var status_id = min_element_status[id];
//    if (flag == 1) {//masih usulan, belum di-acc
//        status_id = 0;//status=usulan
//        min_element_status[id] = 0;
//    } else if (flag == 2) {//sudah di-acc
//        if (sekarang.substring(0, 10) <= tgl_selesai.substring(0, 10)) {
//            if (tgl_read == null || tgl_read.length == 0) {
//                status_id = 1;//status=belum dibaca
//                min_element_status[id] = 1;
//            }
//            else {
//                status_id = 2;//status=sudah dibaca
//                total_progress[id] += parseInt(progress);
//                /*if (progress == 0) {
//                 if (min_element_status[id] > 2) {
//                 status_id = 2;
//                 min_element_status[id] = 2;
//                 }
//                 } else if (progress == 100) {
//                 if (min_element_status[id] > 4) {
//                 status_id = 4;
//                 min_element_status[id] = 4;
//                 }
//                 total_progress[id] += 100;
//                 } else {
//                 if (min_element_status[id] > 3) {
//                 status_id = 3;
//                 min_element_status[id] = 3;
//                 }
//                 total_progress[id] += progress;
//                 }*/
//            }
//        } else if (progress < 100) {
//
//            status_id = 5;//status=terlambat
//        }
//    } else if (flag == 9) {
//        status_id = 6;//status=request perpanjang
//    }
//    var new_label = '';
//    //console.log("total progress = " + total_progress[id]);
//    if (total_progress[id] > 0) {
//        var nilai_progress = total_progress[id] / jumlah_data_progress[id];
//        nilai_progress = (new Number(nilai_progress)).toPrecision(4);
//        var tanggal_mulai = new Date(tgl_mulai.substring(0, 10));
//        var tanggal_sekarang = new Date(sekarang.substring(0, 10));
//        var tanggal_selesai = new Date(tgl_selesai.substring(0, 10));
//        var sisa_hari = (tanggal_selesai - tanggal_sekarang) / satu_hari;
//        var jumlah_hari = (tanggal_selesai - tanggal_mulai) / satu_hari;
//        if (nilai_progress < 100) {
//
//            //console.log('sisa hari = '+sisa_hari);
//            //console.log('lama hari = ' + jumlah_hari);
//
//            var persentase = sisa_hari / jumlah_hari;
//
//            console.log('persen hari = ' + persentase);
//            var progress_warna = 0;
//            if (persentase > 0.5) {
//                progress_warna = 3;
//            } else if (persentase > 0.4) {
//                progress_warna = 2;
//            } else if (persentase > 0.3) {
//                progress_warna = 1;
//            } else {
//                progress_warna = 0;
//            }
//            new_label = '<div class="progress progress-striped active progress-sm" style="margin:0px;" title="' + nilai_progress + '% Complete, ' + sisa_hari + ' hari lagi">'
//                    + '<div class="progress-bar progress-bar-' + status_label[progress_warna] + '"  role="progressbar" aria-valuenow="' + nilai_progress
//                    + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + nilai_progress + '%">'
//                    + '<span class="sr-only">' + nilai_progress + '% Complete</span>'
//                    + '</div>'
//                    + '</div>';
//            //console.log('status adalah progress bar');
//        } else {
//            status_id = 4;//status=selesai
//            new_label = '<span class="label label-' + status_label[status_id] + ' label-mini">' + status_nama[status_id] + '</span>';
//        }
//    }
//    else {
//        new_label = '<span class="label label-' + status_label[status_id] + ' label-mini">' + status_nama[status_id] + '</span>';
//        //console.log('status adalah label');
//    }
//    //console.log('set ' + id + ' to id status ' + status_id + ' => ' + status_nama[status_id] + '  |||||  ' + min_element_status[id]);
//    $('#' + id).html(new_label);
    //console.log('id = '+id+' mulai = ' + tgl_mulai + ' sekarang = ' + sekarang + ' deadline = ' + tgl_selesai+' progress = '+progress+' totalprogress = '+total_progress[id]);
}