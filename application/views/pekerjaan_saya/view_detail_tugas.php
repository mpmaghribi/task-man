<?php $this->load->view("taskman_header_page") ?> 

<body>

    <section id="container" >
        <!--header start-->
        <?php $this->load->view("taskman_header2_page") ?>
        <!--header end-->
        <?php $this->load->view("taskman_sidebarleft_page") ?>

        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">

                    <div class="col-md-12" >
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#deskripsiPekerjaan">Deskripsi Pekerjaan</a>
                                    </li>
                                </ul>
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">

                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="deskripsiPekerjaan" class="tab-pane active">
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">Nama Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['nama_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Penjelasan Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['deskripsi_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Deskripsi Tugas</h4>
                                                <p style="font-size: larger"><?php echo $tugas['deskripsi']; ?></p>
                                                <h4 style="color: #1FB5AD;">Deadline</h4>
                                                <p style="font-size: larger"><?= $tugas['tanggal_mulai2'] . ' - ' . $tugas['tanggal_selesai2'] ?></p>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_file_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th style="width: 250px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_file_pekerjaan_body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung Tugas
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_file_tugas">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th style="width: 250px">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_file_tugas_body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="col-md-12" id="div_aktivitas">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Realisasi Tugas
                                                </h4>
                                                <div class="panel-body">
                                                    <div class="form-horizontal" id="form_realisasi_tugas">
                                                        <form method="post" enctype="multipart/form-data" action="<?= site_url() ?>/aktivitas_pekerjaan/add_realisasi_tugas_v2" target="my_frame">
                                                            <input type="hidden" name="id_tugas" value="<?=$tugas['id_assign_tugas']?>"/>
                                                            <input type="hidden" name="id_aktivitas" value="<?=$aktivitas_saya['id_aktivitas']?>"/>
                                                            <div class="form-group">
                                                                <label class="control-label col-lg-2">Keterangan</label>
                                                                <div class="col-lg-6">
                                                                    <input type="text" name="deskripsi" class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-lg-2">Waktu</label>
                                                                <div class="col-lg-3">
                                                                    <input type="text" name="waktu_mulai" class="form-control" id="tugas_realisasi_waktu_mulai"/>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <input type="text" name="waktu_selesai" class="form-control" id="tugas_realisasi_waktu_selesai"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label for="prioritas" class="control-label col-lg-2">File</label>
                                                                <div class="col-lg-6">
                                                                    <div id="list_file_upload_assign">
                                                                        <div id="file_baru">
                                                                            <table class="table table-hover general-table" id="berkas_baru_tugas"></table>
                                                                        </div>
                                                                    </div>
                                                                    <div style="display:none">
                                                                        <input type="file" multiple="" name="berkas[]" id="pilih_berkas_realisasi_tugas" onchange="file_changed(this, 'berkas_baru_tugas')">
                                                                    </div>
                                                                    <button class="btn btn-primary" type="button" id="button_trigger_file">Pilih File</button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-6 col-lg-offset-2">
                                                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="col-md-12" id="anggota_tim">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Anggota Tim
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="staff_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="staff_pekerjaan_body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="modal fade" id="modal_perpanjang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Permintaan Perpanjangan</h4>
                                                    </div>
                                                    <div class="form modal-body">
                                                        <div class="col-lg-12">
                                                            <textarea class="form-control" id="alasan_perpanjangan" rows="10" placeholder="Isi Alasan Perpanjangan"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" onclick="minta_perpanjang();" type="button">Kirim Permintaan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!--script for this page only-->

            </section>
        </section>
        <iframe id="my_frame" name="my_frame" style="display:none"></iframe>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
    <?php
    $this->load->view("taskman_footer_page");
    ?>
    <script>
                                                            var base_url = '<?= base_url() ?>';
                                                            var site_url = '<?= site_url() ?>';
                                                            var users = <?= json_encode($users) ?>;
                                                            var detil_pekerjaan = <?= json_encode($detil_pekerjaan) ?>;
                                                            var pekerjaan = <?= json_encode($pekerjaan) ?>;
                                                            var tugas = <?= json_encode($tugas) ?>;
                                                            var aktivitas = <?= json_encode($aktivitas) ?>;
                                                            var file_pendukung_pekerjaan = <?= json_encode($file_pendukung_pekerjaan) ?>;
                                                            var file_pendukung_tugas = <?= json_encode($file_pendukung_tugas) ?>;
                                                            $(document).ready(function () {
                                                                document.title = 'Deskripsi Tugas: ' + tugas['deskripsi'] + ' - Task Management';
                                                                init_anggota();
                                                                init_file_pekerjaan();
                                                                init_file_tugas();
                                                                $('#button_trigger_file').on('click', function () {
                                                                    $('#pilih_berkas_realisasi_tugas').click();
                                                                });
                                                                var tanggal_bawah = new Date(tugas['tanggal_mulai2']);
                                                                tanggal_bawah.setHours(0);
//                                                                console.log(tanggal_bawah);
                                                                var tanggal_atas = new Date(tugas['tanggal_selesai2']);
                                                                tanggal_atas.setHours(0);
                                                                var tanggal_mulai = $('#tugas_realisasi_waktu_mulai').datepicker({
                                                                    format: 'dd-mm-yyyy',
                                                                    onRender: function (date) {
                                                                        return  tanggal_bawah > date || date > tanggal_atas ? 'disabled' : '';
                                                                    }
                                                                }).on('changeDate', function (ev) {
                                                                    tanggal_selesai.setValue(new Date(ev.date));
                                                                    tanggal_mulai.hide();
                                                                    $('#tugas_realisasi_waktu_selesai').focus();
                                                                }).data('datepicker');
                                                                var tanggal_selesai = $('#tugas_realisasi_waktu_selesai').datepicker({
                                                                    format: 'dd-mm-yyyy',
                                                                    onRender: function (date) {
                                                                        return tanggal_bawah > date || date > tanggal_atas || tanggal_mulai.date > date ? 'disabled' : '';
                                                                    }
                                                                }).on('changeDate', function (ev) {
                                                                    tanggal_selesai.hide();
                                                                }).data('datepicker');
                                                                tanggal_mulai.setValue(tanggal_bawah);
                                                                tanggal_selesai.setValue(tanggal_atas);
                                                            });
                                                            function set_my_aktivitas(akt){
                                                                console.log(akt);
                                                            }
                                                            function file_changed(elmnt, id_tabel) {
                                                                $('#' + id_tabel).html('');
                                                                var files = elmnt.files;
                                                                var jumlah_file = files.length;
                                                                for (var i = 0; i < jumlah_file; i++) {
                                                                    $('#' + id_tabel).append('<tr id="berkas_baru_' + i + '">' +
                                                                            '<td id="nama_berkas_baru_' + i + '">' + files[i].name + ' ' + format_ukuran_file(files[i].size) + '</td>' +
                                                                            '<td id="keterangan_' + i + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px">Baru</a></td>' +
                                                                            '</tr>');
                                                                }
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
                                                            function init_file_tugas() {
                                                                var tabel = $('#tabel_file_tugas_body');
                                                                tabel.html('');
                                                                var counter = 0;
                                                                for (var i = 0, i2 = file_pendukung_tugas.length; i < i2; i++) {
                                                                    var berkas = file_pendukung_tugas[i];
                                                                    counter++;
                                                                    var html = '<tr>'
                                                                            + '<td>' + counter + '</td>'
                                                                            + '<td>' + berkas['nama_file'] + '</td>'
                                                                            + '<td><a class="btn btn-info btn-xs" href="' + site_url + '/download?id_file=' + berkas['id_file'] + '" id="" style="font-size: 10px" target="_blank">Download</a></td>'
                                                                            + '</tr>';
                                                                    tabel.append(html);
                                                                }
                                                                $('#tabel_file_tugas').dataTable();
                                                            }
                                                            function init_file_pekerjaan() {
                                                                var tabel = $('#tabel_file_pekerjaan_body');
                                                                var counter = 0;
                                                                for (var i = 0, i2 = file_pendukung_pekerjaan.length; i < i2; i++) {
                                                                    var berkas = file_pendukung_pekerjaan[i];
                                                                    counter++;
                                                                    var html = '<tr>'
                                                                            + '<td>' + counter + '</td>'
                                                                            + '<td>' + berkas['nama_file'] + '</td>'
                                                                            + '<td><a class="btn btn-info btn-xs" href="' + site_url + '/download?id_file=' + berkas['id_file'] + '" id="" style="font-size: 10px" target="_blank">Download</a></td>'
                                                                            + '</tr>';
                                                                    tabel.append(html);
                                                                }
                                                                $('#tabel_file_pekerjaan').dataTable();
                                                            }
                                                            function init_anggota() {
                                                                var list_id_anggota = JSON.parse(tugas['id_akun'].replace('{', '[').replace('}', ']'));
                                                                var tabel = $('#staff_pekerjaan_body');
                                                                tabel.html('');
                                                                counter = 0;
                                                                for (var i = 0, i2 = list_id_anggota.length; i < i2; i++) {
                                                                    var detil_pekerjaan_anggota = null;
                                                                    var id_anggota = list_id_anggota[i];
                                                                    console.log('check keanggotaan id anggota ' + id_anggota);
                                                                    for (var j = 0, j2 = detil_pekerjaan.length; j < j2; j++) {
                                                                        var dp = detil_pekerjaan[j];
                                                                        if (dp['id_akun'] == id_anggota) {
                                                                            detil_pekerjaan_anggota = dp;
                                                                            break;
                                                                        }
                                                                    }
                                                                    if (detil_pekerjaan_anggota == null) {
                                                                        console.log('id anggota ' + id_anggota + ' tidak memiliki detil pekerjaan');
                                                                        continue;
                                                                    }
                                                                    var detil_anggota = null;
                                                                    for (var j = 0, j2 = users.length; j < j2; j++) {
                                                                        var user = users[j];
                                                                        if (user['id_akun'] == id_anggota) {
                                                                            detil_anggota = user;
                                                                            break;
                                                                        }
                                                                    }
                                                                    if (detil_anggota == null) {
                                                                        console.log('id anggota ' + id_anggota + ' tidak memiliki detil user');
                                                                        continue;
                                                                    }
                                                                    counter++;
                                                                    var status = 'Belum Dikerjakan';
                                                                    for (var j = 0, j2 = aktivitas.length; j < j2; j++) {
                                                                        var akt = aktivitas[j];
                                                                        if (akt['id_detil_pekerjaan'] == detil_pekerjaan_anggota['id_detil_pekerjaan']) {
                                                                            status = 'Sudah Dikerjakan, Belum Divalidasi';
                                                                            if (akt['status_validasi'] == '1') {
                                                                                status = 'Sudah Dikerjakan, Sudah Divalidasi';
                                                                            }
                                                                        }
                                                                    }
                                                                    var html = '<tr>'
                                                                            + '<td>' + counter + '</td>'
                                                                            + '<td>' + detil_anggota['nama'] + '</td>'
                                                                            + '<td>' + status + '</td>'
                                                                            + '</tr>';
                                                                    tabel.append(html);
                                                                }
                                                            }
    </script>