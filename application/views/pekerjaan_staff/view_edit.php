<?php
$this->load->view("taskman_header_page");
$dp = array();
if (count($detil_pekerjaan) > 0) {
    $dp = $detil_pekerjaan[0];
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
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">

                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="modal fade" id="modalTambahStaff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="width: 1000px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="tombol_tutup">&times;</button>
                                                    <h4 class="modal-title">Tambahkan Staff</h4>
                                                </div>
                                                <div class="modal-body" id="tambahkan_staff_body">
                                                    <table id="tabel_list_enroll_staff" class="table table-hover general-table">
                                                        <thead id="tabel_list_enroll_staff_head">
                                                            <tr id="tabel_list_enroll_staff_head">
                                                                <th>No</th>
                                                                <th>NIP</th>
                                                                <th>Departemen</th>
                                                                <th>Nama</th>
                                                                <th>Enroll</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_list_enroll_staff_body">                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
                                                    <button class="btn btn-success" type="button" onclick="pilih_staff_ok();">Pilih Staff</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div_skp" class="tab-pane active">
                                        <?php 
                                        //print_r($pekerjaan); 
                                        ?>
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo site_url() ?>/pekerjaan_staff/update" enctype="multipart/form-data">
                                                <input type="hidden" name="jenis_usulan" value="usulan"/>
                                                <input type="hidden" name="id_pekerjaan" value="<?=$pekerjaan['id_pekerjaan']?>"/>
                                                <div class="form-group ">
                                                    <label for="staff" class="control-label col-lg-3">Staff</label>
                                                    <div class="col-lg-6">
                                                        <div id="span_list_assign_staff">
                                                            <table id="tabel_assign_staff_skp" class="table table-hover general-table">
                                                            </table>
                                                        </div>
                                                        <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff_skp();">Tambah Staff</a>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="sifat_pkj" class="form-control m-bot15">
                                                            <option value="1">Personal</option>
                                                            <option value="2" <?= $pekerjaan['id_sifat_pekerjaan'] == '2' ? 'selected=""' : '' ?>>Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Ketegroi Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="kategori_pekerjaan" class="form-control m-bot15" id="select_kategori_pekerjaan">
                                                            <option value="rutin" >Rutin</option>
                                                            <option value="project" <?= $pekerjaan['kategori'] == 'project' ? 'selected=""' : '' ?>>Project</option>
                                                            <option value="tambahan" <?= $pekerjaan['kategori'] == 'tambahan' ? 'selected=""' : '' ?>>Tambahan</option>
                                                            <option value="kreativitas" <?= $pekerjaan['kategori'] == 'kreativitas' ? 'selected=""' : '' ?>>Kreativitas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="firstname" name="nama_pkj" type="text" value="<?= $pekerjaan['nama_pekerjaan'] ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pkj" rows="12"><?= $pekerjaan['deskripsi_pekerjaan'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_angka_kredit">
                                                    <label for="prioritas" class="control-label col-lg-3">Angka Kredit</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="angka_kredit" name="angka_kredit" value="<?= $dp['sasaran_angka_kredit'] ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_kuantitas">
                                                    <label for="prioritas" class="control-label col-lg-3">Kuantitas Output</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="kuantitas_output" name="kuantitas_output" value="<?= $dp['sasaran_kuantitas_output'] ?>"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" id="satuan_kuantitas" name="satuan_kuantitas" value="item" placeholder="satuan kuanttias" value="<?= $dp['satuan_kuantitas'] ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="div_kualitas">
                                                    <label for="prioritas" class="control-label col-lg-3">Kualitas Mutu</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="kualitas_mutu" name="kualitas_mutu" value="<?= $dp['sasaran_kualitas_mutu'] ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Periode</label>
                                                    <div class="col-lg-6" id="">
                                                        <input type="text" class="form-control" id="periode" name="periode" value="<?= intval($pekerjaan['periode']) > 0 ? $pekerjaan['periode'] : date('Y') ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6" id="div_periode_tanggal">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input readonly type="text" class="form-control dpd1" value="<?= $pekerjaan['tanggal_mulai'] ?>" name="tgl_mulai">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input readonly type="text" class="form-control dpd2" value="<?= $pekerjaan['tanggal_selesai'] ?>" name="tgl_selesai">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_pakai_biaya">
                                                    <label for="prioritas" class="control-label col-lg-3">Pakai Biaya</label>
                                                    <div class="col-lg-6">
                                                        <select name="pakai_biaya" id="pakai_biaya" class="form-control">
                                                            <option value="0">Tanpa Biaya</option>
                                                            <option value="1" <?= $dp['pakai_biaya'] == '1' ? 'selected=""' : '' ?>>Biaya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_biaya">
                                                    <label for="prioritas" class="control-label col-lg-3">Biaya</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="biaya" name="biaya" value="<?= $dp['pakai_biaya']=='1'?$dp['sasaran_biaya']:'-' ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_manfaat">
                                                    <label for="prioritas" class="control-label col-lg-3">Tingkat Kemanfaatan</label>
                                                    <div class="col-lg-6">
                                                        <select name="select_kemanfaatan" class="form-control">
                                                            <option value="1">Bermanfaat bagi unit kerjanya</option>
                                                            <option value="2" <?= $pekerjaan['level_manfaat'] == '2' ? 'selected=""' : '' ?>>Bermanfaat bagi oragnisasinya</option>
                                                            <option value="3" <?= $pekerjaan['level_manfaat'] == '3' ? 'selected=""' : '' ?>>Bermanfaat bagi negara</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                                                    <div class="col-lg-6">
                                                        <select name="prioritas" class="form-control m-bot15">
                                                            <option value="1" >Urgent</option>
                                                            <option value="2" <?= $pekerjaan['level_prioritas'] == '2' ? 'selected=""' : '' ?>>Tinggi</option>
                                                            <option value="3" <?= $pekerjaan['level_prioritas'] == '3' ? 'selected=""' : '' ?>>Sedang</option>
                                                            <option value="4" <?= $pekerjaan['level_prioritas'] == '4' ? 'selected=""' : '' ?>>Rendah</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">File</label>
                                                    <div class="col-lg-6">
                                                        <div id="list_file_upload_assign">
                                                            <div id="file_baru">
                                                                <table  class="table table-hover general-table" id="berkas_baru"></table>
                                                            </div>
                                                        </div>
                                                        <div style="display:none">
                                                            <input type="file" multiple="" name="berkas[]" id="pilih_berkas_assign"/>
                                                        </div>
                                                        <button class="btn btn-primary" type="button" id="button_trigger_file">Pilih File</button>
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
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

        <!-- END JAVASCRIPTS -->
        <?php $this->load->view('taskman_rightbar_page'); ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page"); ?>
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/date_picker_init.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/pekerjaan_staff/js_view_pekerjaan_staff.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/pekerjaan_staff/js_edit.js"></script>
    <script >
                                                            var list_staff = <?php echo json_encode($list_staff); ?>;
                                                            var pekerjaan =<?= json_encode($pekerjaan) ?>;
                                                            var detil_pekerjaan =<?= json_encode($detil_pekerjaan) ?>;
                                                            var site_url='<?=site_url()?>';
    </script>