<?php $this->load->view("taskman_header_page") ?> 
<?php
$user = array();
foreach ($users as $u) {
    $user[$u->id_akun] = $u;
}
//var_dump($user);
?>
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
                                        <a data-toggle="tab" href="#deskripsiPekerjaan">Deskripsi Tugas</a>
                                    </li>
                                </ul>
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-danger btn-xs" href="<?php echo site_url(); ?>/pekerjaan_staff/edit_tugas?id_tugas=<?php echo $tugas['id_assign_tugas']; ?>" id="tombol_edit_usulan" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-warning btn-xs" href="javascript:batalkan_tugas();" id="tombol_batalkan_usulan" style="font-size: 10px">Hapus</a>
                                </div>

                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="deskripsiPekerjaan" class="tab-pane active">
                                        <section class="panel" >
                                        </section>
                                        <div class="col-md-12 cmxform form-horizontal"  id="div_tanggap_perpanjang" style="display: none">
                                            <h4>Ubah Deadline Pekerjaan</h4>
                                            <div class="form-group ">
                                                <label for="tanggal_baru" class="control-label col-lg-3">Tanggal Baru</label>
                                                <div class="col-lg-6">
                                                    <input class=" form-control" id="tanggal_baru" name="tanggal_baru" type="text" readonly="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="komentar_perpanjang" class="control-label col-lg-3">Tambahkan Komentar</label>
                                                <div class="col-lg-6">
                                                    <textarea class="form-control" rows="10" name="komentar_perpanjang" id="komentar_perpanjang"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-lg-6">
                                                    <input class="btn btn-success" type="button" id="tombol_simpan_perpanjang" value="Simpan"/>
                                                    <input class="btn btn-primary" type="button" id="tombol_batal_perpanjang" value="Batal"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">

                                                <h4 style="color: #1FB5AD;">Nama Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['nama_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Penjelasan Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['deskripsi_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Deskrispi Tugas</h4>
                                                <p style="font-size: larger"><?php echo $tugas['deskripsi']; ?></p>
                                                <h4 style="color: #1FB5AD;">Deadline</h4>
                                                <p style="font-size: larger"><?= $tugas['tanggal_mulai2'] . ' - ' . $tugas['tanggal_selesai2'] ?></p>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung Pekerjaan
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_file_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th style="width: 250px">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

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
                                                                <th style="width: 250px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
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
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="panel-body">
                                            <form style="display:none" class="cmxform form-horizontal " id="signupForm" method="POST" action="#<?php //echo site_url()                                                                                            ?>/pekerjaan/usulan_pekerjaan">
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <button id="komentar" class="btn btn-primary" type="button">Lihat Komentar</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </section>
                    </div>


                </div>

                <!--script for this page only-->
                <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <?php
    $this->load->view("taskman_footer_page");
    ?>
    <script>
        var id_pekerjaan = <?= $pekerjaan['id_pekerjaan'] ?>;
        var pekerjaan =<?= json_encode($pekerjaan) ?>;
        var detil_pekerjaan =<?= json_encode($detil_pekerjaan) ?>;
        var users =<?= json_encode($users) ?>;
        var tugas =<?= json_encode($tugas) ?>;
        var aktivitas =<?= json_encode($list_aktivitas) ?>;
        var base_url = '<?= base_url() ?>';
        var site_url = '<?= site_url() ?>';
        var list_id_staff = <?= json_encode($list_id_staff) ?>;
        var file_pekerjaan = <?= json_encode($file_pekerjaan) ?>;
        var file_tugas = <?= json_encode($file_tugas) ?>;
        $(document).ready(function () {
            document.title = 'Deskripsi Pekerjaan: ' + pekerjaan['nama_pekerjaan'] + ' - Task Management';
            var tab = $($('.sidebar-menu').children()[2]).children();
            $(tab[0]).attr('class', 'dcjq-parent active');
            $(tab[1]).show();
            init_anggota_tugas();
            init_file_pekerjaan();
            init_file_tugas();
        });
        function init_file_pekerjaan() {
            var tabel=$('#tabel_file_pekerjaan ');
            for (var i = 0, i2 = file_pekerjaan.length; i < i2; i++) {
                var html = '<tr>'
                        + '<td>' + (i + 1) + '</td>'
                        + '<td>' + file_pekerjaan[i]['nama_file'] + '</td>'
                        + '<td><a class="btn btn-info btn-xs" href="' + site_url + '/download?id_file=' + file_pekerjaan[i]['id_file'] + '" id="" style="font-size: 10px" target="_blank">Download</a><a class="btn btn-danger btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="hapus_file('+file_pekerjaan[i]['id_file']+', \''+file_pekerjaan[i]['nama_file']+'\');">Hapus</a></td>'
                        + '</tr>';
                tabel.append(html);
            }
            $('#tabel_file_pekerjaan').dataTable();
        }
        function init_file_tugas() {
            var tabel=$('#tabel_file_tugas ');
            for (var i = 0, i2 = file_tugas.length; i < i2; i++) {
                var html = '<tr>'
                        + '<td>' + (i + 1) + '</td>'
                        + '<td>' + file_tugas[i]['nama_file'] + '</td>'
                        + '<td><a class="btn btn-info btn-xs" href="' + site_url + '/download?id_file=' + file_tugas[i]['id_file'] + '" id="" style="font-size: 10px" target="_blank">Download</a><a class="btn btn-danger btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="hapus_file('+file_tugas[i]['id_file']+', \''+file_tugas[i]['nama_file']+'\');">Hapus</a></td>'
                        + '</tr>';
                tabel.append(html);
            }
            $('#tabel_file_tugas').dataTable();
        }
        function init_anggota_tugas() {
            var tabel = $('#staff_pekerjaan');
//            var arr_id_akun = tugas['id_akun'];
//            arr_id_akun = arr_id_akun.replace('{', '').replace('}', '');
//            var list_id_akun = arr_id_akun.split(',');
            var list_id_akun = list_id_staff;
            console.log('list id akun ');
            console.log(list_id_akun);
            var counter = 0;
            for (var i = 0, i2 = list_id_akun.length; i < i2; i++) {
                var id_akun = list_id_akun[i];
                var dp_terlibat = null;
                //check apakah id akun ada di dalam detil pekerjaan
                for (var j = 0, j2 = detil_pekerjaan.length; j < j2; j++) {
                    var dp = detil_pekerjaan[j];
                    if (parseInt(dp['id_akun']) == id_akun) {
                        dp_terlibat = dp;
                        break;
                    }
                }
                if (dp_terlibat == null) {
                    continue;
                }
                var user_terlibat = null;
                for (var j = 0, j2 = users.length; j < j2; j++) {
                    var user = users[j];
                    if (user['id_akun'] == id_akun) {
                        user_terlibat = user;
                        break;
                    }
                }
                if (user_terlibat == null) {
                    continue;
                }
                var status_tugas = 'Belum Dikerjakan';
                for (var j = 0, j2 = aktivitas.length; j < j2; j++) {
					if(aktivitas[j]['id_detil_pekerjaan']==dp_terlibat['id_detil_pekerjaan']){
						status_tugas='Telah Dikerjakan, Belum Divalidasi';
						if(aktivitas[j]['status_validasi']=='1'){
							status_tugas='Telah Dikerjakan, Telah Divalidasi';
						}
					}
                }
                counter++;
                var html = '<tr>'
                        + '<td>' + counter + '</td>'
                        + '<td>' + user_terlibat['nama'] + '</td>'
                        + '<td>' + status_tugas + '</td>'
                        + '</tr>';
                tabel.append(html);
            }
            $('#staff_pekerjaan').dataTable({
                "columnDefs": [{"targets": [0, 2], "orderable": false}]
            });
        }
    </script>