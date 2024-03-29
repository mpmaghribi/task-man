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
                                    if ($atasan && $deskripsi_pekerjaan[0]->flag_usulan == '2' && in_array(6, $data_akun['idmodul'])) {
                                        ?>
                                        <li class="">
                                            <a data-toggle="tab" href="#penilaianPekerjaan">Penilaian Kerja Staff</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <?php
                                $pengusul = $usulan && $ikut_serta;
                                //echo "pengusul = $pengusul";
                                ?>
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <?php if ($bisa_validasi) { ?><a class="btn btn-info btn-xs" href="javascript:void(0);" id="tombol_validasi_usulan" style="font-size: 10px" onclick="validasi_usulan(<?php echo $deskripsi_pekerjaan[0]->id_pekerjaan; ?>);">Validasi</a><?php } ?>
                                    <?php if ($bisa_edit) { ?><a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>pekerjaan/edit?id_pekerjaan=<?php echo $deskripsi_pekerjaan[0]->id_pekerjaan; ?>" id="tombol_edit_usulan" style="font-size: 10px">Edit</a><?php } ?>
                                    <?php if ($bisa_batalkan) { ?><a class="btn btn-warning btn-xs" href="javascript:void(0);" id="tombol_batalkan_usulan" style="font-size: 10px">Batalkan</a><?php } ?>
                                    <?php
                                    if ($terlambat > 0 && !$usulan) {
                                        if ($perpanjang) {
                                            if ($ikut_serta) {
                                                ?><a class="btn btn-primary btn-xs" href="javascript:void(0);" id="tombol_perpanjang" style="font-size: 10px">Perpanjangan Telah Dikirim</a><?php
                                            } else if ($bisa_edit) {
                                                $alamat = base_url() . "pekerjaan/edit?id_pekerjaan=" . $deskripsi_pekerjaan[0]->id_pekerjaan . "#deskripsi";
                                                ?><a class="btn btn-primary btn-xs" href="javascript:void(0);" id="setuju_perpanjang"  style="font-size: 10px">Minta Diperpanjang</a><?php
                                            }
                                        } else if ($ikut_serta) {
                                            ?><a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal_perpanjang" id="tombol_perpanjang" style="font-size: 10px">Minta Perpanjang</a><?php
                                        }
                                    }
                                    ?>
                                </div>
                                <script>
                                    $('#tombol_batalkan_usulan').click(function (e) {
                                        var c = confirm('Anda yakin ingin membatalkan pekerjaan "<?php echo $deskripsi_pekerjaan[0]->nama_pekerjaan; ?>"?');
                                        if (c === false) {
                                            e.preventDefault();
                                        } else {
                                            $.ajax({// create an AJAX call...
                                                data: "id_pekerjaan=::" + '<?php echo $deskripsi_pekerjaan[0]->id_pekerjaan; ?>', // get the form data
                                                type: "get", // GET or POST
                                                url: "<?php echo site_url(); ?>/pekerjaan/batalkan_pekerjaan", // the file to call
                                                success: function (response) { // on success..
                                                    var json = jQuery.parseJSON(response);
                                                    if (json.status === "OK") {
<?php
$lempar_url = 'pekerjaan/karyawan';
if ($this->session->userdata('prev') != null) {
    $lempar_url = $this->session->userdata('prev');
}
?>
                                                        window.location = '<?php echo site_url() . '/' . $lempar_url; ?>';
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
                                                    <?php if ($deskripsi_pekerjaan[0]->flag_usulan == '2') { ?>
                                                        Pembuat Pekerjaan
                                                    <?php } else if ($deskripsi_pekerjaan[0]->flag_usulan == '1' || $deskripsi_pekerjaan[0]->flag_usulan == '9') { ?>
                                                        Ditujukan Kepada
                                                    <?php } ?>
                                                </h4>
                                                <p style="font-size: larger" id="nama_penanggung_jawab">
                                                    <?php if (isset($deskripsi_pekerjaan) && count($deskripsi_pekerjaan) > 0 && $deskripsi_pekerjaan[0]->id_penanggung_jawab != null) echo isset($user[$deskripsi_pekerjaan[0]->id_penanggung_jawab]) ? $user[$deskripsi_pekerjaan[0]->id_penanggung_jawab] : 'kesalahan'; ?>
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
                                                    Kategori Pekerjaan
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php echo $deskripsi_pekerjaan[0]->kategori; ?>
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Deadline
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php
                                                    echo date("d M Y", strtotime(substr($deskripsi_pekerjaan[0]->tgl_mulai, 0, 19)));
                                                    echo " - ";
                                                    echo date("d M Y", strtotime(substr($deskripsi_pekerjaan[0]->tgl_selesai, 0, 19)));
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
                                                    <table class="table table-striped table-hover table-condensed" id="table_list_file">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th style="width: 250px"></th>
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
                                                                            <a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="window.open('<?php echo base_url() ?>download?id_file=<?= $berkas->id_file; ?>');">Download</a>
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
                                                            <?php
                                                            if (isset($file_progress)) {
                                                                $i = 1;
                                                                foreach ($file_progress as $berkas) {
                                                                    ?>
                                                                    <tr id="berkas_<?php echo $berkas->id_file; ?>" title="diupload pada <?php echo date("d M Y H:i", strtotime($berkas->waktu)); ?>">
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo basename($berkas->nama_file); ?></td>
                                                                        <td style="text-align: right">
                                                                            <a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="window.open('<?php echo base_url() ?>download?id_file=<?= $berkas->id_file; ?>');">Download</a>
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
                                        <div class="col-md-12" id="anggota_tim">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Anggota Tim
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="staff_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">id</th>
                                                                <th>#</th>
                                                                <th>Nama</th>
                                                                <th style="width: 300px">Progress</th>
                                                                <th style="width: 250px"></th>
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
                                                                                if ($value->id_akun == $value2->id_akun ) {
                                                                                    ?><a target="_blank" href="<?php echo base_url(); ?>pekerjaan/pekerjaan_per_staff?id_akun=<?php echo $value2->id_akun; ?>"><?php echo $value2->nama; ?></a><?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <div id="progress_html">
                                                                                <div class="progress progress-striped progress-xs">
                                                                                    <div style="width: <?php echo $value->progress; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $value->progress; ?>" role="progressbar" class="progress-bar progress-bar-warning">
                                                                                        <span class="sr-only"><?php echo $value->progress; ?>% Complete (success)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($value->id_akun == $data_akun['user_id'] && $value->flag_usulan == 2 || $atasan || true) {
                                                                                //if(($ikut_serta&&!$usulan)||$atasan){
                                                                                if (($terlambat <= 0 && !$atasan) || true) {
                                                                                    ?>
                                                                                    <a class=" btn btn-primary btn-xs" href="#UbahProgress" data-toggle="modal" onclick="show_progress('<?php echo $value->id_detil_pekerjaan ?>', '<?php echo $value->id_akun ?>')">Ubah Progress</a>
                                                                                <?php } ?>
                                                                                <a class=" btn btn-primary btn-xs" href="#LogProgress" data-toggle="modal" onclick="history_progress('<?php echo $value->id_detil_pekerjaan ?>', '<?php echo $value->id_akun ?>')">History Progress</a>
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
                                            <?php
                                            if ($terlambat > 0 && !$usulan) {
                                                if ($ikut_serta) {
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
                                                }
                                            }
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
                                                                <input type="hidden" id="id_pkj" name="id_pkj" value="<?php echo $id_pkj ?>" />
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
<!--                                                                        <input class="form-control" placeholder="Masukkan nama file anda" title="Format: nama file_nama anda" type="text" id="nama_file" name="nama_file" value="" />-->
<!--                                                                        <small>Format: nama file_nama anda</small><br>-->
                                                                        <!--                                                                        <button class="btn btn-warning btn-xs" onclick="uploadFile()" type="button"> Upload File</button>-->

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
                                        <script>


                                        </script>






                                        <div class="panel-body">
                                            <form style="display:none" class="cmxform form-horizontal " id="signupForm" method="POST" action="#<?php //echo site_url()                                                         ?>/pekerjaan/usulan_pekerjaan">
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
                                    <?php if (in_array(6, $data_akun['idmodul'])) { ?>
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
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>

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
                                                        success: function (response) { // on success..
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
                                                    success: function (response) { // on success..
                                                        var json = jQuery.parseJSON(response);
                                                        //alert(json.data);
                                                        $("#komentar_pkj_ubah").val(json.data);
                                                    }
                                                });
                                                $('#ubah_komen').click(function (e) {
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
    <?php
    $this->load->view("taskman_footer_page");
    ?>
    <script>
        function validasi_usulan(id_pekerjaan) {
            //alert("pekerjaan yg divalidasi " + id_pekerjaan);
            $.ajax({// create an AJAX call...
                data: "id_pekerjaan=" + id_pekerjaan, // get the form data
                type: "POST", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/validasi_usulan", // the file to call
                success: function (response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        console.log('validasi pekerjaan berhasil');
                        $('#tombol_validasi_usulan').remove();
                    } else {
                        alert(json.reason);
                        console.log('validasi pekerjaan gagal');
                    }
                }
            });
        }
        function minta_perpanjang() {
            $.ajax({// create an AJAX call...
                data: {
                    id_pekerjaan: <?php echo $id_pkj; ?>, // get the form data
                    alasan: $('#alasan_perpanjangan').val()
                },
                type: "POST", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/req_perpanjangan", // the file to call
                success: function (response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        //$('#div_acc_edit_cancel_usulan_pekerjaan').remove();
                        $('#tombol_perpanjang').attr('href', 'javascript:void(0);');
                        $('#tombol_perpanjang').html('Perpanjangan Telah Dikirim');
                        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + document.getElementById('id_detail_pkj').value);
                        window.location.hash = '#anggota_tim';
                    } else {
                        alert("Permintaan perpanjangan gagal, " + json.keterangan);
                    }
                }
            });
        }
        $(document).ready(function () {
            document.title = 'Deskripsi Pekerjaan: <?php echo $nama_pekerjaan; ?> - Task Management';
            //$('#komentar').trigger();
            $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + document.getElementById('id_detail_pkj').value);
            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
            //$('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        });


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
                success: function (response) { // on success..
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
                success: function (response) { // on success..
                    var json = jQuery.parseJSON(response);
                    if (json.status === "OK") {
                        var count = 1;
                        var html = "";
                        html += "<table id='table_log_progress' class='table table-bordered'><thead><tr><th>No</th><th>Nama Pekerjaan</th><th style='width: 50%;'>Log Perubahan</th><th> Progress</th><th> Tanggal</tr></thead>";
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
                            tgl = tgl.replace(/-/gi, "/");
                            tgl = tgl.substring(19, 0);
                            tgl = Date.parse(tgl);
                            tgl = new Date(tgl);
                            //var tgl2 = new Date(tgl.getFullYear(), tgl.getMonth(), tgl.getDay(), tgl.getHours(), tgl.getMinutes(), 0, 0);
                            html += "<tr>";
                            html += "<td>" + count + "";
                            html += "</td>";
                            html += "<td>" + json.data[i].nama_pekerjaan + "";
                            html += "</td>";
                            html += "<td>" + json.data[i].deksripsi + "";
                            html += "</td>";
                            html += "<td>" + json.data[i].progress + "% Selesai";
                            html += "</td>";
                            html += "<td>" + tgl.toLocaleString() + "";
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
        $(function () {
            $('#table_list_file').dataTable();
            $('#staff_pekerjaan').dataTable({"aaSorting": [[1, 'asc']]});
            var now = new Date();
            now = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 0, 0, 0, 0);
            console.log(now);
            var tanggal = $('#tanggal_baru').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function (date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function (ev) {
                tanggal.hide();
            }).data('datepicker');
        });

        $('#setuju_perpanjang').click(function () {
            $('#div_tanggap_perpanjang').show();
            document.getElementById('tanggal_baru').value = '';
            document.getElementById('komentar_perpanjang').value = '';
        });
        $('#tombol_batal_perpanjang').click(function () {
            $('#div_tanggap_perpanjang').hide();
        });
        $('#tombol_simpan_perpanjang').click(function () {
            $('#div_tanggap_perpanjang').hide();
            $.ajax({// create an AJAX call...
                data: {
                    id_pekerjaan: document.getElementById('id_detail_pkj').value,
                    tanggal_baru: document.getElementById('tanggal_baru').value,
                    komentar_perpanjang: document.getElementById('komentar_perpanjang').value
                },
                type: "POST", // GET or POST
                url: "<?php echo site_url() ?>/pekerjaan/perpanjang",
                cache: false,
                success: function (response) { // on success..
                    var json = jQuery.parseJSON(response);
                    if (json.status === "OK") {
                        $('#setuju_perpanjang').remove();
                        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + document.getElementById('id_detail_pkj').value);
                    } else {
                        alert("Perpanjangan Deadline Pekerjaan Gagal dilakukan");
                    }
                }
            });
        });
        $("#batal_progress").click(function (e) {
            $(".tampil_progress").css("display", "none");
        });
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
        function ubah_progress()
        {

            var data_progress = document.getElementById("progress").value;
            var idp = document.getElementById("idp").value;
            var log_perubahan = document.getElementById("perubahan").value;
//            /var nama_file = document.getElementById("nama_file").value;
            var file = document.getElementById("file1").value;
//            if (log_perubahan === "" || nama_file === "" || data_progress === "" || file === "")
//            {
//                alert("Silahkan lengkapi terlebih dahulu.");
//                exit();
//            }
            // else{
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
                success: function (response) { // on success..
                    var json = jQuery.parseJSON(response);

                    if (json.status === "OK") {
                        var id_progress = json.id_progress;
                        $(".tampil_progress").css("display", "block");
                        var ajax = new XMLHttpRequest();
                        ajax.upload.addEventListener("progress", progressHandler, false);
                        ajax.addEventListener("load", completeHandler, false);
                        ajax.addEventListener("error", errorHandler, false);
                        ajax.addEventListener("abort", abortHandler, false);
                        ajax.open("POST", "<?php echo site_url() ?>/pekerjaan/upload_file_progress");
                        var formdata = new FormData();
                        var berkas = _("file1").files;
                        var p = berkas.length;
                        for (var i = 0; i < p; i++) {
                            formdata.append("berkas[]", berkas[i]);
                        }
                        formdata.append("id_progress", id_progress);
                        ajax.send(formdata);



                        //alert("Progress berhasil diupdate!. Pastikan anda sudah melakukan upload file terlebih dahulu.");
                        var html = "";
                        html += '<div class="progress progress-striped progress-xs">' +
                                '<div style="width:' + data_progress + '%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="' + data_progress + '" role="progressbar" class="progress-bar progress-bar-warning">' +
                                '<span class="sr-only">' + data_progress + '% Complete (success)</span>' +
                                '</div>' +
                                '</div>';
                        $("#progress_html").html(html);
                        //window.location.href = "";
                        $('#tombol_tutup_progress').trigger('click');
                    } else {
                        alert("Data gagal di update");
                    }
                }
            });
            // }
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
    </script>