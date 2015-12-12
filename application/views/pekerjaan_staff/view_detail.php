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
                                        <a data-toggle="tab" href="#deskripsiPekerjaan">Deskripsi Pekerjaan</a>
                                    </li>

                                    <!--                                    <li class="">
                                                                            <a data-toggle="tab" href="#penilaianPekerjaan">Penilaian Kerja Staff</a>
                                                                        </li>-->
                                </ul>

                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-info btn-xs" href="javascript:void(0);" id="tombol_validasi_usulan" style="font-size: 10px;display:none" onclick="validasi_usulan(<?= $pekerjaan['id_pekerjaan'] ?>);">Validasi</a>
                                    <a class="btn btn-danger btn-xs" href="<?php echo site_url(); ?>/pekerjaan_staff/edit?id_pekerjaan=<?php echo $pekerjaan['id_pekerjaan']; ?>" id="tombol_edit_usulan" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-warning btn-xs" href="javascript:batalkan_pekerjaan();" id="tombol_batalkan_usulan" style="font-size: 10px">Batalkan</a>
                                    <a class="btn btn-primary btn-xs" href="javascript:void(0);" id="tombol_perpanjang" style="font-size: 10px;display:none">Perpanjangan Telah Dikirim</a>
                                    <a class="btn btn-primary btn-xs" href="javascript:void(0);" id="setuju_perpanjang"  style="font-size: 10px;display:none">Minta Diperpanjang</a>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal_perpanjang" id="tombol_perpanjang" style="font-size: 10px;display:none">Minta Perpanjang</a>
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
                                                <h4 style="color: #1FB5AD;">
                                                    <?php
                                                    if ($pekerjaan['status_pekerjaan'] == '7') {
                                                        echo 'Pembuat Pekerjaan';
                                                    } else {
                                                        echo 'Ditujukan Kepada';
                                                    }
                                                    $list_kategori = array(
                                                        'rutin' => 'SKP Rutin',
                                                        'project' => 'SKP Project',
                                                        'tambahan' => 'Pekerjaan Tambahan',
                                                        'kreativitas' => 'Pekerjaan Kreativitas'
                                                    );
                                                    $list_tingkat_manfaat = array(
                                                        1 => 'Bermanfaat bagi Unit Kerja',
                                                        2 => 'Bermanfaat bagi Organisasi',
                                                        3 => 'Bermanfaat bagi Negara'
                                                    );
                                                    ?>
                                                </h4>
                                                <p style="font-size: larger" id="nama_penanggung_jawab"><?= $user[$pekerjaan['id_penanggung_jawab']]->nama ?></p>
                                                <h4 style="color: #1FB5AD;">Nama Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['nama_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Penjelasan Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['deskripsi_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Jenis Pekerjaan</h4>
                                                <p style="font-size: larger"><?php echo $pekerjaan['nama_sifat_pekerjaan']; ?></p>
                                                <h4 style="color: #1FB5AD;">Kategori Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $list_kategori[$pekerjaan['kategori']] ?></p>
                                                <?php
                                                if ($pekerjaan['kategori'] == 'kreativitas') {
                                                    ?>
                                                    <h4 style="color: #1FB5AD;">Tingkat Kemanfaatan</h4>
                                                    <p style="font-size: larger"><?= $list_tingkat_manfaat[$pekerjaan['level_manfaat']] ?></p>
                                                    <?php
                                                }
                                                ?>
                                                <h4 style="color: #1FB5AD;">Periode</h4>
                                                <p style="font-size: larger"><?= explode(' ', $pekerjaan['tgl_mulai'])[0] . ' - ' . explode(' ', $pekerjaan['tgl_selesai'])[0] ?></p>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_file_pendukung">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th style="width: 250px">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($list_file)) {
                                                                $i = 1;
                                                                foreach ($list_file as $berkas) {
                                                                    ?>
                                                                    <tr id="berkas_<?php echo $berkas['id_file']; ?>" title="diupload pada <?php echo date("d M Y H:i", strtotime($berkas['waktu'])); ?>">
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo $berkas['nama_file']; ?></td>
                                                                        <td style="text-align: right">
                                                                            <a class="btn btn-info btn-xs" href="<?php echo site_url() ?>/download?id_file=<?= $berkas['id_file']; ?>" id="" style="font-size: 10px" target="_blank">Download</a>
                                                                            <a class="btn btn-danger btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="hapus_file(<?php echo $berkas['id_file'] ?>, '<?php echo $berkas['nama_file']; ?>');">Hapus</a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    List File Progress
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="table_file_progress">
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
                                                                <th><?= in_array($pekerjaan['kategori'], array('rutin', 'project')) ? 'Nilai' : 'Progress' ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $counter = 0;
                                                            $pekerjaan_rutin = in_array($pekerjaan['kategori'], array('rutin', 'project'));
                                                            foreach ($detil_pekerjaan as $dp) {
                                                                if (!isset($user[$dp['id_akun']]))
                                                                    continue;
                                                                $counter++;
                                                                echo '<tr>';
                                                                echo '<td><a  href="' . site_url() . '/pekerjaan_staff/detail_aktivitas?id_pekerjaan=' . $pekerjaan['id_pekerjaan'] . '&id_staff=' . $dp['id_akun'] . '" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-eye"> Lihat Aktivitas</i></a></td>';
                                                                echo '<td>' . $user[$dp['id_akun']]->nama . '</td>';
                                                                if ($pekerjaan_rutin == true) {
                                                                    echo '<td>' . number_format(floatval($dp['skor']), 2) . '</td>';
                                                                } else {
                                                                    echo '<td><div class="progress progress-striped progress-xs">'
                                                                    . '<div style="width: ' . $dp['progress'] . '%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="' . $dp['progress'] . '" role="progressbar" class="progress-bar progress-bar-warning" title="progress ' . $dp['progress'] . '%">'
                                                                    . '<span class="sr-only">' . $dp['progress'] . '% Complete (success)</span>'
                                                                    . '</div>'
                                                                    . '</div></td>';
                                                                }
                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                            <?php
//                                            if ($terlambat > 0 && !$usulan) {
//                                                if ($ikut_serta) {
                                            ?>
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
                                            <?php
//                                                }
//                                            }
                                            ?>
                                            <div class="modal fade" id="LogProgress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" style="width: 1100px">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">History Progress</h4>
                                                        </div>

                                                        <div class="form modal-body">
                                                            <div id="history_progress"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="UbahProgress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="tombol_tutup_progress">&times;</button>
                                                            <h4 class="modal-title">Ubah Progress</h4>
                                                        </div>
                                                        <form class="cmxform form-horizontal" id="progress_form" action="#" method="POST" enctype="multipart/form-data">
                                                            <div class="form modal-body">
                                                                <input type="hidden" id="idp" name="idp" value="" />
                                                                <input type="hidden" id="id_pkj" name="id_pkj" value="<?php echo $pekerjaan['id_pekerjaan'] ?>" />
                                                                <div class="form-group ">
                                                                    <label for="progress" class="control-label col-lg-3">Progress</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="form-control" id="progress" name="progress">
                                                                            <option if value="0">
                                                                                0% Selesai
                                                                            </option>
                                                                            <option value="10">
                                                                                10% Selesai
                                                                            </option>
                                                                            <option value="20">
                                                                                20% Selesai
                                                                            </option>
                                                                            <option value="30">
                                                                                30% Selesai
                                                                            </option>
                                                                            <option value="40">
                                                                                40% Selesai
                                                                            </option>
                                                                            <option value="50">
                                                                                50% Selesai
                                                                            </option>
                                                                            <option value="60">
                                                                                60% Selesai
                                                                            </option>
                                                                            <option value="70">
                                                                                70% Selesai
                                                                            </option>
                                                                            <option value="80">
                                                                                80% Selesai
                                                                            </option>
                                                                            <option value="90">
                                                                                90% Selesai
                                                                            </option>
                                                                            <option value="100">
                                                                                100% Selesai
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group ">
                                                                    <label for="perubahan" class="control-label col-lg-3">Log Perubahan</label>
                                                                    <div class="col-lg-8">
                                                                        <textarea class="form-control" type="text" id="perubahan" name="perubahan" rows="12" value=""></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="total_progress" class="control-label col-lg-3">Total Progress</label>
                                                                    <div class="col-lg-8">
                                                                        <input readonly class="form-control" type="text" id="total_progress" name="total_progress" value="100" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="waktu_progress" class="control-label col-lg-3">Waktu Progress</label>
                                                                    <div class="col-lg-8">
                                                                        <input readonly class="form-control" type="text" id="waktu_progress" name="waktu_progress" value="<?php
                                                                        date_default_timezone_set("Asia/Jakarta");
                                                                        echo date("Y-m-d h:i:s");
                                                                        ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label for="file1" class="control-label col-lg-3">File Progress</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="file_progress" type="file" id="file1" name="file1" value="" multiple=""/>

                                                                    </div>
                                                                </div>
                                                                <div class="tampil_progress" style="display: none;">
                                                                    <div class="form-group ">
                                                                        <label for="progressBar" class="control-label col-lg-3">Total</label>
                                                                        <div class="col-lg-8">
                                                                            <progress id="progressBar" value="0" max="100" style="width:300px;"></progress> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <label for="status" class="control-label col-lg-3">Status</label>
                                                                        <div class="col-lg-8">
                                                                            <h4 id="status"></h4> <p id="loaded_n_total"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button data-dismiss="modal" class="btn btn-default" id="batal_progress" type="button">Batal</button>
                                                                <button class="btn btn-warning"  onclick="ubah_progress()" type="button"> Ubah Progress</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <form style="display:none" class="cmxform form-horizontal " id="signupForm" method="POST" action="#<?php //echo site_url()                                                                           ?>/pekerjaan/usulan_pekerjaan">
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <button id="komentar" class="btn btn-primary" type="button">Lihat Komentar</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div id="box_komentar" style="display: block">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal " id="signupForm" method="post" action="javascript:void(0)">
                                                        <input type="hidden" id="is_isi_komentar" name="is_isi_komentar" value="true"/>
                                                        <input type="hidden" id="id_detail_pkj" name="id_detail_pkj" value="<?php echo $pekerjaan['id_pekerjaan'] ?>"/>
                                                        <div class="form-group">
                                                            <div id="lihat_komen" class="col-lg-12">

                                                            </div>
                                                            <div id="tes" class="col-lg-12">

                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="col-lg-12">
                                                                <textarea class="form-control" id="komentar_pkj" name="komentar_pkj" rows="12"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <button id="save_komen" class="btn btn-primary" type="button">Tambah Komentar</button>
                                                            </div>
                                                        </div>
                                                    </form>
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
                                                                    var base_url = '<?= base_url() ?>';
                                                                    var site_url = '<?= site_url() ?>';
                                                                    var id_staff =<?= $id_staff ?>;
                                                                    $(document).ready(function () {
                                                                        document.title = 'Deskripsi Pekerjaan: <?php echo $pekerjaan['nama_pekerjaan']; ?> - Task Management';
                                                                        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + $('#id_detail_pkj').val());
                                                                        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
                                                                        $('#submenu_pekerjaan_ul').show();
                                                                        $('#staff_pekerjaan').dataTable({
                                                                            "columnDefs": [{"targets": [0], "orderable": false}],
                                                                        });
                                                                        $('#tabel_file_pendukung').dataTable({
                                                                            "columnDefs": [{"targets": [2], "orderable": false}],
                                                                        });
                                                                    });
                                                                    function batalkan_pekerjaan() {
                                                                        var teks = "Apakah Anda yakin untuk membatalkan pekerjaan ini?";
                                                                        if (confirm(teks) == true) {
                                                                            window.location = site_url + '/pekerjaan_staff/batalkan?id_pekerjaan=' + id_pekerjaan + '&id_staff=' + id_staff;
                                                                        }
                                                                    }

                                                                    function _(el) {
                                                                        return document.getElementById(el);
                                                                    }
                                                                    function progressHandler(event) {
                                                                        _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
                                                                        var percent = (event.loaded / event.total) * 100;
                                                                        _("progressBar").value = Math.round(percent);
                                                                        _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                                                                    }
                                                                    function completeHandler(event) {
                                                                        _("status").innerHTML = '';
                                                                        _("progressBar").value = 0;
                                                                    }
                                                                    function errorHandler(event) {
                                                                        _("status").innerHTML = "Upload Failed";
                                                                    }
                                                                    function abortHandler(event) {
                                                                        _("status").innerHTML = "Upload Aborted";
                                                                    }

                                                                    function uploadFile() {
                                                                        $(".tampil_progress").css("display", "block");
                                                                        var file = _("file1").files[0];
                                                                        var idp = document.getElementById("id_pkj").value;
                                                                        var nama_file = document.getElementById("nama_file").value;
                                                                        if (file.type === "application/pdf" || file.type === "application/x-download" || file.type === "application/msword")
                                                                        {
                                                                            var formdata = new FormData();
                                                                            formdata.append("file1", file);
                                                                            formdata.append("id_pekerjaan", idp);
                                                                            if (file.type === "application/x-download" || file.type === "application/pdf") {
                                                                                formdata.append("nama_file", nama_file + "_" + new Date().toDateString() + ".pdf");
                                                                            }
                                                                            else
                                                                            {
                                                                                formdata.append("nama_file", nama_file + "_" + new Date().toDateString() + ".doc");
                                                                            }
                                                                            var ajax = new XMLHttpRequest();
                                                                            ajax.upload.addEventListener("progress", progressHandler, false);
                                                                            ajax.addEventListener("load", completeHandler, false);
                                                                            ajax.addEventListener("error", errorHandler, false);
                                                                            ajax.addEventListener("abort", abortHandler, false);
                                                                            ajax.open("POST", "<?php echo site_url() ?>/file_upload_parser");
                                                                            ajax.send(formdata);
                                                                        }
                                                                        else
                                                                        {
                                                                            //alert(file.name+" | "+file.size+" | "+file.type); 

                                                                            alert("Silahkan upload hanya pdf dan ms word < 2007 saja.");
                                                                        }
                                                                        //alert(file.name+" | "+file.size+" | "+file.type); 

                                                                    }
                                                                    function hapus_file(id_file, deskripsi)
                                                                    {
                                                                        var c = confirm("Anda yakin menghapus file " + deskripsi + "?");
                                                                        if (c == true) {
                                                                            $.ajax({// create an AJAX call...
                                                                                data: {
                                                                                    id_file: id_file
                                                                                }, // get the form data
                                                                                type: "get", // GET or POST
                                                                                url: "<?php echo site_url(); ?>/pekerjaan_staff/hapus_file", // the file to call
                                                                                success: function (response) { // on success..

                                                                                    if (response === "OK") {
                                                                                        $('#berkas_' + id_file).remove();
                                                                                        //$('#tombol_validasi_usulan').remove();
                                                                                    } else {
                                                                                        alert("Gagal menghapus file, " + json.reason);
                                                                                    }
                                                                                }
                                                                            });
                                                                        }
                                                                        else {
                                                                        }
                                                                    }
                                                                    function ubah_komentar(id_komen) {
                                                                        $.ajax({// create an AJAX call...
                                                                            data: {
                                                                                id_komentar_ubah: id_komen
                                                                            },
                                                                            type: "GET", // GET or POST
                                                                            url: "<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan_by_id", // the file to call
                                                                            success: function (response) { // on success..
                                                                                var json = jQuery.parseJSON(response);
                                                                                $("#komentar_pkj_ubah").val(json.data);
                                                                            }
                                                                        });
                                                                        $('#ubah_komen').click(function (e) {
                                                                            e.preventDefault();
                                                                            var id_pkj = document.getElementById('id_detail_pkj').value;
                                                                            $.ajax({// create an AJAX call...
                                                                                data: {
                                                                                    id_komentar_ubah: id_komen,
                                                                                    isi_komentar_ubah: $('#komentar_pkj_ubah').val()
                                                                                }, // get the form data
                                                                                type: "GET", // GET or POST
                                                                                url: "<?php echo site_url(); ?>/pekerjaan/ubah_komentar_pekerjaan", // the file to call
                                                                                success: function (response) { // on success..
                                                                                    //var json = jQuery.parseJSON(response);
                                                                                    $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                                                                                }
                                                                            });
                                                                        });
                                                                    }

                                                                    function hapus(id) {
                                                                        $('#hapus_komen').click(function (e) {
                                                                            //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                                                                            e.preventDefault();
                                                                            var id_pkj = document.getElementById('id_detail_pkj').value;
                                                                            $.ajax({// create an AJAX call...
                                                                                data:
                                                                                        {
                                                                                            id_komentar: id
                                                                                        }, // get the form data                     type: "GET", // GET or POST
                                                                                url: "<?php echo site_url(); ?>/pekerjaan/hapus_komentar_pekerjaan", // the file to call
                                                                                success: function (response) { // on success..
                                                                                    $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                                                                                }
                                                                            });
                                                                        });
                                                                    }


                                                                    $('#save_komen').click(function (e) {
                                                                        //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                                                                        e.preventDefault();
                                                                        var id_pkj = document.getElementById('id_detail_pkj').value;
                                                                        $.ajax({// create an AJAX call...
                                                                            data:
                                                                                    {
                                                                                        id_detail_pkj: document.getElementById('id_detail_pkj').value, // get the form data
                                                                                        komentar_pkj: document.getElementById('komentar_pkj').value,
                                                                                        is_isi_komentar: document.getElementById('is_isi_komentar').value
                                                                                    }, // get the form data
                                                                            type: "GET", // GET or POST
                                                                            url: "<?php echo site_url(); ?>/pekerjaan/komentar_pekerjaan", // the file to call
                                                                            success: function (response) { // on success..
                                                                                $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                                                                                document.getElementById('komentar_pkj').value = '';
                                                                            }
                                                                        });
                                                                    });
    </script>