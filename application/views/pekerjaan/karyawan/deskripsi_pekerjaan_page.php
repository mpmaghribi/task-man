<?php $this->load->view("taskman_header_page") ?> 
<?php
$user = array();
foreach ($users as $u) {
    $user[$u->id_akun] = $u->nama;
}
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
                                    <?php
                                    //print_r($deskripsi_pekerjaan[0]);
                                    //print_r($data_akun);
                                    if ($atasan && $deskripsi_pekerjaan[0]->flag_usulan == '2') {
                                        ?>
                                        <li class="">
                                            <a data-toggle="tab" href="#penilaianPekerjaan">Penilaian Kerja Staff</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <?php
                                $pengusul = $deskripsi_pekerjaan[0]->flag_usulan == '1' && $ikut_serta;
                                //echo "pengusul = $pengusul";
                                ?>
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <?php if ($bisa_validasi) { ?><a class="btn btn-success btn-xs" href="javascript:void(0);" id="tombol_validasi_usulan" style="font-size: 10px" onclick="validasi(<?php echo $deskripsi_pekerjaan[0]->id_pekerjaan; ?>);">Validasi</a><?php } ?>
                                    <?php if ($bisa_edit) { ?><a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>pekerjaan/edit?id_pekerjaan=<?php echo $deskripsi_pekerjaan[0]->id_pekerjaan; ?>" id="tombol_edit_usulan" style="font-size: 10px">Edit</a><?php } ?>
                                    <?php if ($bisa_batalkan) { ?><a class="btn btn-danger btn-xs" href="javascript:void(0);" id="tombol_batalkan_usulan" style="font-size: 10px">Batalkan</a><?php } ?>
                                    <?php
                                    if ($terlambat > 0 && $ikut_serta) {
                                        if ($perpanjang) {
                                            ?><a class="btn btn-primary btn-xs" href="javascript:void(0);" id="tombol_perpanjang" style="font-size: 10px">Perpanjangan Telah Dikirim</a><?php
                                        } else {
                                            ?><a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal_perpanjang" id="tombol_perpanjang" style="font-size: 10px">Minta Perpanjang</a><?php
                                        }
                                        ?><?php } ?>
                                </div>
                                <script>
                                    $('#tombol_batalkan_usulan').click(function(e) {
                                        var c = confirm('Anda yakin ingin membatalkan pekerjaan "<?php echo $deskripsi_pekerjaan[0]->nama_pekerjaan; ?>"?');
                                        if (c === false) {
                                            e.preventDefault();
                                        } else {
                                            $.ajax({// create an AJAX call...
                                                data: "id_pekerjaan=::" + '<?php echo $deskripsi_pekerjaan[0]->id_pekerjaan; ?>', // get the form data
                                                type: "get", // GET or POST
                                                url: "<?php echo site_url(); ?>/pekerjaan/batalkan_pekerjaan", // the file to call
                                                success: function(response) { // on success..
                                                    var json = jQuery.parseJSON(response);
                                                    if (json.status === "OK") {
<?php
$lempar_url = 'karyawan';
if ($this->session->userdata('prev') != null) {
    $lempar_url = $this->session->userdata('prev');
}
?>
                                                        window.location = '<?php echo base_url() . 'pekerjaan/' . $lempar_url; ?>';
                                                    } else {
                                                        alert("Gagal membatalkan pekerjaan, " + json.reason);
                                                    }
                                                }
                                            });
                                        }
                                    });
                                </script>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="deskripsiPekerjaan" class="tab-pane active">
                                        <section class="panel" >
                                        </section>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Penanggung Jawab
                                                </h4>
                                                <p style="font-size: larger" id="nama_penanggung_jawab">
                                                    <?php if ($deskripsi_pekerjaan[0]->id_penanggung_jawab != null) echo $user[$deskripsi_pekerjaan[0]->id_penanggung_jawab]; ?>
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Nama Pekerjaan
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php
                                                    if (isset($deskripsi_pekerjaan)) {
                                                        $nama_pekerjaan = "";
                                                        ?>
                                                        <?php
                                                        foreach ($deskripsi_pekerjaan as $value) {
                                                            echo $value->nama_pekerjaan;
                                                            $nama_pekerjaan = $value->nama_pekerjaan;
                                                        }
                                                        ?>
                                                    <?php } ?> 
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Penjelasan Pekerjaan
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php if (isset($deskripsi_pekerjaan)) { ?>
                                                        <?php foreach ($deskripsi_pekerjaan as $value) { ?>
                                                            <?php echo $value->deskripsi_pekerjaan; ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Jenis Pekerjaan
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php echo $deskripsi_pekerjaan[0]->nama_sifat_pekerjaan; ?>
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Deadline
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php
                                                    echo date("d M Y", strtotime(substr($deskripsi_pekerjaan[0]->tgl_mulai,0,19)));
                                                    echo " - ";
                                                    echo date("d M Y", strtotime(substr($deskripsi_pekerjaan[0]->tgl_selesai,0,19)));
                                                    ?>
                                                </p>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="table_deskripsi">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama File</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($list_berkas)) {
                                                                $i = 1;
                                                                foreach ($list_berkas as $berkas) {
                                                                    ?>
                                                                    <tr id="berkas_<?php echo $berkas->id_file; ?>" title="diupload pada <?php echo date("d M Y H:i", strtotime($berkas->waktu)); ?>">
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo basename($berkas->nama_file); ?></td>
                                                                        <td style="text-align: right">
                                                                            <a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="window.open('<?php echo base_url() . $berkas->nama_file ?>');">Download</a>
                                                                            <?php if ($atasan || $pengusul) { ?>
                                                                                <a class="btn btn-danger btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="hapus_file(<?php echo $berkas->id_file ?>, '<?php echo basename($berkas->nama_file); ?>');">Hapus</a>
                                                                            <?php } ?>
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
                                                    Anggota Tim
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">id</th>
                                                                <th>#</th>
                                                                <th>Nama</th>
                                                                <th>Progress</th>
                                                                <th></th>
                                                                <th></th>
<!--                                                                <th></th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($listassign_pekerjaan)) {
                                                                $i = 1;
                                                                foreach ($listassign_pekerjaan as $value) {
                                                                    ?>
                                                                    <tr>
                                                                        <td style="display: none"><?php echo $value->id_detil_pekerjaan ?></td>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td id="nama_staff_"><?php foreach ($users as $value2) { ?>
                                                                                <?php
                                                                                if ($value->id_akun == $value2->id_akun) {
                                                                                    echo $value2->nama;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <div class="progress progress-striped progress-xs">
                                                                                <div style="width: <?php echo $value->progress; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $value->progress; ?>" role="progressbar" class="progress-bar progress-bar-warning">
                                                                                    <span class="sr-only"><?php echo $value->progress; ?>% Complete (success)</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <?php if ($value->id_akun == $temp['user_id'] && $value->flag_usulan == 2) { ?>
                                                                            <td>
                                                                                <a class=" btn btn-primary btn-xs" href="#UbahProgress" data-toggle="modal" onclick="show_progress('<?php echo $value->id_detil_pekerjaan ?>', '<?php echo $value->id_akun ?>')">Ubah Progress</a>
                                                                                <a class=" btn btn-primary btn-xs" href="#LogProgress" data-toggle="modal" onclick="history_progress('<?php echo $value->id_detil_pekerjaan ?>', '<?php echo $value->id_akun ?>')">History Progress</a>

                                                                            </td>
                                                                        <?php } ?>

                                                                        <td></td>
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
                                            <script>
                                                function ubah_progress()
                                                {
                                                    var data_progress = document.getElementById("progress").value;
                                                    var idp = document.getElementById("idp").value;
                                                    var log_perubahan = document.getElementById("perubahan").value;

                                                    $.ajax({// create an AJAX call...
                                                        data:
                                                                {
                                                                    id_detail_pkj: idp,
                                                                    data_progress: data_progress,
                                                                    perubahan: log_perubahan
                                                                }, // get the form data
                                                        type: "POST", // GET or POST
                                                        url: "<?php echo site_url() ?>/pekerjaan/update_progress", // the file to call
                                                        cache: false,
                                                        success: function(response) { // on success..
                                                            var json = jQuery.parseJSON(response);

                                                            if (json.status === "OK") {
                                                                alert("Progress berhasil diupdate!");
                                                                window.location.href = "";
                                                            } else {
                                                                alert("Data gagal di update");
                                                            }
                                                        }
                                                    });
                                                }
                                                function show_progress(id_detail_pkj, id_user)
                                                {

                                                    $.ajax({// create an AJAX call...
                                                        data:
                                                                {
                                                                    user_id: id_user,
                                                                    id_detail_pkj: id_detail_pkj
                                                                }, // get the form data
                                                        type: "POST", // GET or POST
                                                        url: "<?php echo site_url() ?>/pekerjaan/show_progress", // the file to call
                                                        cache: false,
                                                        success: function(response) { // on success..
                                                            var json = jQuery.parseJSON(response);

                                                            if (json.status === "OK") {
                                                                $("#progress").val(json.data[0].progress);
                                                                $("#idp").val(id_detail_pkj);
                                                            } else {
                                                                alert("Data gagal di update");
                                                            }
                                                        }
                                                    });
                                                }
                                                function history_progress(id_detail_pkj, id_user)
                                                {
                                                    $.ajax({// create an AJAX call...
                                                        data:
                                                                {
                                                                    user_id: id_user,
                                                                    id_detail_pkj: id_detail_pkj
                                                                }, // get the form data
                                                        type: "POST", // GET or POST
                                                        url: "<?php echo site_url(); ?>/pekerjaan/show_log_progress", // the file to call
                                                        cache: false,
                                                        success: function(response) { // on success..
                                                            var json = jQuery.parseJSON(response);
                                                            if (json.status === "OK") {
                                                                var count = 1;
                                                                var html = "";
                                                                html += "<table id='table_log_progress' class='table table-bordered'><thead><tr><th>No</th><th>Nama Pekerjaan</th><th>Log Perubahan</th><th> Progress</th><th> Tanggal</tr></thead>";
                                                                html += "<tbody>";
                                                                var jml = "";
                                                                if (json.data.length > 5)
                                                                {
                                                                    jml = 5;
                                                                } else {
                                                                    jml = json.data.length;
                                                                }
                                                                for (var i = 0; i < jml; i++)
                                                                {
                                                                    var tgl = json.data[i].waktu;
                                                                    //tgl = tgl.replace(/-/gi,"/");
                                                                    tgl = tgl.substring(19, 0);
                                                                    html += "<tr>";
                                                                    html += "<td>" + count + "";
                                                                    html += "</td>";
                                                                    html += "<td>" + json.data[i].nama_pekerjaan + "";
                                                                    html += "</td>";
                                                                    html += "<td>" + json.data[i].deksripsi + "";
                                                                    html += "</td>";
                                                                    html += "<td>" + json.data[i].progress + "% Selesai";
                                                                    html += "</td>";
                                                                    html += "<td>" + tgl + "";
                                                                    html += "</td>";
                                                                    html += "</tr>";

                                                                    count++;
                                                                    //                                                                    $("#log_progress").val(json.data[i].progress);
                                                                    //                                                                    $("#tanggal").val(json.data[i].tanggal);
                                                                    //                                                                    $("#nama_pkj").val(json.data[i].nama_pekerjaan);
                                                                }
                                                                html += "</tbody></table>";
                                                                $("#history_progress").html(html);
                                                                //window.location.href = "";
                                                            } else {
                                                                alert("Data gagal di update");
                                                            }
                                                        }
                                                    });
                                                }
                                            </script>
                                            <div class="modal fade" id="modal_perpanjang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Permintaan Perpanjangan</h4>
                                                        </div>
                                                        <div class="form modal-body">
                                                            <!--                                                            <h5>Isi alasan perpanjangan</h5>-->
                                                            <!--                                                            <textarea id="alasan_perpanjangan" placeholder="Isi Alasan Perpanjangan"></textarea>-->
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
                                            <div class="modal fade" id="LogProgress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
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
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Ubah Progress</h4>
                                                        </div>
                                                        <form class="cmxform form-horizontal" id="signupForm" action="#" method="POST">
                                                            <div class="form modal-body">
                                                                <input type="hidden" id="idp" name="idp" value="" />
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
                                                                        <textarea class="form-control" type="text" id="perubahan" name="perubahan" rows="12" value="">
                                                                        </textarea>
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
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                                                                <button class="btn btn-warning" data-dismiss="modal" onclick="ubah_progress()" type="button"> Ubah Progress</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>







                                        <div class="panel-body">
                                            <form style="display:none" class="cmxform form-horizontal " id="signupForm" method="POST" action="#<?php //echo site_url()                     ?>/pekerjaan/usulan_pekerjaan">
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
                                                        <input type="hidden" id="id_detail_pkj" name="id_detail_pkj" value="<?php echo $id_pkj ?>"/>
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
                                    <?php if (count($my_staff) > 0) { ?>
                                        <div id="penilaianPekerjaan" class="tab-pane">
                                            <?php $this->load->view('pekerjaan/penilaian'); ?>
                                        </div>
                                    <?php } ?>



















                                </div>
                            </div>

                        </section>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">

                        </section>
                    </div>
                </div>
                <!--script for this page only-->
                <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

                <!-- END JAVASCRIPTS -->
                <script>
                                                                    jQuery(document).ready(function() {
                                                                        EditableTableProgress.init();
                                                                    });
                </script>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <script type="text/javascript">
        $(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            var checkin = $('.dpd1').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
            var checkout = $('.dpd2').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                checkout.hide();
            }).data('datepicker');
        });
    </script>
    <script>
        function hapus_file(id_file, deskripsi)
        {
            var c = confirm("Anda yakin menghapus file " + deskripsi + "?");
            if (c == true) {
                $.ajax({// create an AJAX call...
                    data: {id_file: id_file,
                        id_pekerjaan: <?php echo $id_pkj; ?>
                    }, // get the form data
                    type: "get", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/hapus_file", // the file to call
                    success: function(response) { // on success..
                        var json = jQuery.parseJSON(response);
                        //alert(response);
                        if (json.status === "OK") {
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
            //alert(id_komen);
            $.ajax({// create an AJAX call...
                data:
                        {
                            id_komentar_ubah: id_komen
                        }, // get the form data
                type: "GET", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan_by_id", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(json.data);
                    $("#komentar_pkj_ubah").val(json.data);
                }
            });
            $('#ubah_komen').click(function(e) {
                //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                e.preventDefault();
                //alert(document.getElementById('komentar_pkj_ubah').value);
                var id_pkj = document.getElementById('id_detail_pkj').value;
                $.ajax({// create an AJAX call...
                    data:
                            {
                                id_komentar_ubah: id_komen,
                                isi_komentar_ubah: document.getElementById('komentar_pkj_ubah').value
                            }, // get the form data
                    type: "GET", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/ubah_komentar_pekerjaan", // the file to call
                    success: function(response) { // on success..
                        //var json = jQuery.parseJSON(response);
                        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                    }
                });
            });
        }
    </script>
    <script>
        function hapus(id) {
            $('#hapus_komen').click(function(e) {
                //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                e.preventDefault();
                var id_pkj = document.getElementById('id_detail_pkj').value;
                $.ajax({// create an AJAX call...
                    data:
                            {
                                id_komentar: id
                            }, // get the form data
                    type: "GET", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/hapus_komentar_pekerjaan", // the file to call
                    success: function(response) { // on success..
                        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                    }
                });
            });
        }
    </script>

    <script>

        $('#save_komen').click(function(e) {
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
                success: function(response) { // on success..
                    $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                    document.getElementById('komentar_pkj').value = '';
                }
            });
        });

    </script>
    <?php
    $this->load->view("taskman_footer_page");
    ?>
    <script>
        function validasi(id_pekerjaan) {
            //alert("pekerjaan yg divalidasi " + id_pekerjaan);
            $.ajax({// create an AJAX call...
                data: "id_pekerjaan=" + id_pekerjaan, // get the form data
                type: "POST", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/validasi_usulan", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        //$('#div_acc_edit_cancel_usulan_pekerjaan').remove();
                        $('#tombol_validasi_usulan').remove();
                    } else {
                        alert("validasi gagal, " + json.reason);
                    }
                }
            });
        }
        function minta_perpanjang() {
            $.ajax({// create an AJAX call...
                data: {
                    id_pekerjaan : <?php echo $id_pkj; ?>, // get the form data
                    alasan: $('#alasan_perpanjangan').html()
                },
                type: "POST", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/req_perpanjangan", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        //$('#div_acc_edit_cancel_usulan_pekerjaan').remove();
                        $('#tombol_perpanjang').remove();
                    } else {
                        alert("Permintaan perpanjangan gagal, " + json.keterangan);
                    }
                }
            });
        }
        document.title = 'Deskripsi Pekerjaan: <?php echo $nama_pekerjaan; ?> - Task Management';
        //$('#komentar').trigger();
        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + document.getElementById('id_detail_pkj').value);
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    </script>