<?php $this->load->view("taskman_header_page") ?> 
<script src="<?php echo base_url() ?>/assets/js/status_pekerjaan.js"></script>
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
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Chart Aktifitas Pekerjaan Bulan <?php echo date('F Y'); ?>
                            </header>
                            <div class="panel-body">

                                <div class="row">

                                    <?php
                                    $jml = count($aktivitas);
                                    $tengah = ceil($jml / 2);
                                    if ($jml > 6) {
                                        ?>
                                        <div class="col-lg-6">
                                            <?php
                                            for ($a = 0; $a < $tengah; $a++) {
                                                echo '<li>P' . ($a + 1) . ' : ' . $aktivitas[$a]['nama_pekerjaan'] . '</li>';
                                            }
                                            ?>
                                        </div>
                                        <div class="col-lg-6">

                                            <?php
                                            for ($a = $tengah; $a < $jml; $a++) {
                                                echo '<li>P' . ($a) . ' : ' . $aktivitas[$a]['nama_pekerjaan'] . '</li>';
                                            }
                                            ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-lg-12">
                                            <ol>
                                                <?php
                                                $r = 1;
                                                foreach ($aktivitas as $v) {
                                                    echo '<li>P' . $r . ' : ' . $v->nama_pekerjaan . '</li>';
                                                    $r++;
                                                }
                                                ?>

                                            </ol>
                                        </div>
<?php } ?>
                                    <div class="col-lg-12">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="graph-line"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="#myModal" data-toggle="modal" class="btn btn-success">
                                            Print Log Aktifitas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#ListPekerjaan">List Pekerjaan</a>
                                    </li>
<?php if (in_array(2, $data_akun['idmodul']) ) { ?>
                                        <li class="">
                                            <a data-toggle="tab" href="#TambahPekerjaan">Usulkan Pekerjaan</a>
                                        </li>
<?php } ?>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="ListPekerjaan" class="tab-pane active">
                                        <section class="panel">
                                            <div class="panel-body">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-1">Periode</label>
                                                        <div class="col-lg-3">
                                                            <select class="form-control" id="select_periode" onchange="select_periode_changed()">
                                                                <?php
                                                                for ($i = $tahun_max; $i >= $tahun_min; $i--) {
                                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<header class="panel-heading">
                                                Daftar Pekerjaan yang Saya Kerjakan
                                            </header>
                                            <div class="panel-body">
                                                <div class="form">
                                                    <table class="table table-striped table-hover table-condensed" id="tablePekerjaanSaya">
                                                        <thead>
                                                            <tr>
                                                                <th> No</th>
                                                                <th class="hidden-phone">Pekerjaan</th>
                                                                <th>Periode</th>
                                                                <th>Assign To</th>
                                                                <th>Kategori</th>
                                                                <th style="min-width: 150px">Status</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tablePekerjaanSaya_body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>


                                        <section class="panel">
                                            <div class="panel-body">

                                                <header class="panel-heading">
                                                    Daftar Usulan Pekerjaan Saya
                                                </header>
                                                <div class="form">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_usulan">
                                                        <thead>
                                                            <tr>
                                                                <th> No</th>
                                                                <th class="hidden-phone">Pekerjaan</th>
                                                                <th>Deadline</th>
                                                                <th>Assign To</th>
                                                                <th>Kategori</th>
                                                                <th style="min-width: 150px">Status</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_usulan_body">
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="panel-body">
                                                <header class="panel-heading" id="">
                                                    Tugas
                                                </header>
                                                <div class="form">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_tugas">
                                                        <thead>
                                                            <tr>
                                                                <th style="" id="kolom_nomor">No</th>
                                                                <th style="">Deskripsi Tugas</th>
                                                                <th>Pekerjaan</th>
                                                                <th>Deadline</th>
                                                                <th>Assign To</th>
                                                                <th style="">Status</th>
                                                                <th style="">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_tugas_body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <div id="TambahPekerjaan" class="tab-pane">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan" method="POST" action="<?php echo site_url() ?>/pekerjaan_saya/create_usulan" enctype="multipart/form-data">
												<div class="form-group ">
													<label for="atasan" class="control-label col-lg-3">Atasan</label>
													<div class="col-lg-6">
														<select name="atasan" class="form-control m-bot15">
															<?php foreach ($atasan as $value) { ?>              
																<option value="<?php echo $value->id_akun ?>"><?php echo $value->nama ?> - <?php echo $value->nama_jabatan ?></option>  
															<?php } ?>
														</select>
													</div>
												</div>
                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="sifat" class="form-control m-bot15">
                                                            <option value="1">Personal</option>
                                                            <option value="2">Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="kategori" class="control-label col-lg-3">Kategori Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="kategori" class="form-control m-bot15" onchange="usulan_kategori_changed()" id="select_usulan_kategori">
                                                            <option value="rutin">Rutin</option>
															<option value="project">Project</option>
															<option value="tambahan">Tambahan</option>
															<option value="kreativitas">Kreativitas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="usulan_nama_pekerjaan" name="nama_pekerjaan" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pekerjaan" rows="12"></textarea>
                                                    </div>
                                                </div>
												<div class="form-group" id="div_ak">
                                                    <label class="control-label col-lg-3">Angka Kredit</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="usulan_ak" name="angka_kredit" type="text" placeholder="Angka Kredit" value="1"/>
                                                    </div>
                                                </div>
												<div class="form-group" id="div_kuantitas">
                                                    <label class="control-label col-lg-3">Kuantitas Output</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control" id="usulan_kuantitas" name="kuantitas" type="text" placeholder="Kuantitas Outout" value="1"/>
                                                    </div>
													<div class="col-lg-2">
                                                        <input class="form-control" id="usulan_satuan_kuantitas" name="satuan_kuantitas" type="text" value="item" placeholder="Satuan Kuantitas Output"/>
                                                    </div>
                                                </div>
												<div class="form-group" id="div_kualitas">
                                                    <label class="control-label col-lg-3">Kualitas Mutu</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="usulan_kualitas" name="kualitas" type="text" placeholder="Kualitas Mutu" value="100"/>
                                                    </div>
                                                </div>
												<div class="form-group" id="div_periode">
                                                    <label class="control-label col-lg-3">Periode</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="usulan_periode" name="periode" type="text" placeholder="Tahun Periode" value="<?= date('Y') ?>" onchange="periode_changed()"/>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="div_deadlie">
                                                    <label for="deadline" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6 ">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input id="usulan_tanggal_mulai" readonly type="text" class="form-control" value="" name="tgl_mulai">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input id="usulan_tanggal_selesai" readonly type="text" class="form-control" value="" name="tgl_selesai">
                                                        </div>
                                                    </div>
                                                </div>
												<div class="form-group" id="div_biaya">
                                                    <label class="control-label col-lg-3">Biaya</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" id="usulan_biaya" name="biaya" type="text" placeholder="Biaya" value="-"/>
                                                    </div>
                                                </div>
												<div class="form-group" id="div_manfaat">
                                                    <label class="control-label col-lg-3">Kemanfaatan</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" id="usulan_manfaat" name="manfaat">
															<option value="1">Bermanfaat bagi unit kerjanya</option>
															<option value="2">Bermanfaat bagi Organisasi</option>
															<option value="3">Bermanfaat bagi Negara</option>
														</select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                                                    <div class="col-lg-6">
                                                        <select name="prioritas" class="form-control m-bot15" id="select_prioritas">
                                                            <option value="1">Urgent</option>
                                                            <option value="2">Tinggi</option>
                                                            <option value="3">Sedang</option>
                                                            <option value="4">Rendah</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">File</label>
                                                    <div class="col-lg-6">
                                                        <div id="file_baru">
                                                            <table  class="table table-hover general-table" id="berkas_usulan"></table>
                                                        </div>
                                                        <div style="display:none">
                                                            <input type="file" multiple="" name="berkas[]" id="pilih_berkas_usulan" onchange="berkas_usulan_changed()"/>
                                                        </div>
                                                        <button class="btn btn-primary" type="button" id="button_pilih_berkas_usulan" onclick="click_pilih_berkas_usulan()">Pilih File</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <button class="btn btn-primary" type="submit">Save</button>
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
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
	<?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Form Tittle</h4>
                </div>
                <div class="modal-body">

                    <form role="form" method="post" action="<?php echo base_url().'index.php/laporan/cetak_logaktifitas'; ?>" target="_blank">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" class="form-control m-bot15">
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select name="bulan" class="form-control m-bot15">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
    <script src="<?= base_url() ?>assets/js2/date_picker_init.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/js2/pekerjaan_saya/js_view_pekerjaan_saya.js" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js2/pekerjaan_saya/js_usulan.js" type="text/javascript"></script>
	<?php $this->load->view("taskman_footer_page") ?>
    <script>
        var site_url = '<?= site_url() ?>';
        var list_user = <?= json_encode($users) ?>;
        var base_url = '<?= base_url() ?>';
        document.title = "Pekerjaan Saya - Task Management";
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    </script>
