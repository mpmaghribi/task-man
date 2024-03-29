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
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#PekerjaanStaff">Pekerjaan Staff</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#div_skp">Assign Pekerjaan</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#div_tugas">Assign Tugas</a>
                                    </li>
                                    <!--                                    <li class="">
                                                                            <a data-toggle="tab" href="#div_tambahan">Tugas Tambahan</a>
                                                                        </li>
                                                                        <li class="">
                                                                            <a data-toggle="tab" href="#div_kreativitas">Kreativitas</a>
                                                                        </li>-->
                                </ul>
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
                                    <div id="div_skp" class="tab-pane">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo site_url() ?>/pekerjaan_staff/add" enctype="multipart/form-data">
                                                <input type="hidden" name="jenis_usulan" value="usulan"/>
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
                                                            <option value="1" >Personal</option>
                                                            <option value="2" >Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Ketegroi Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="kategori_pekerjaan" class="form-control m-bot15" id="select_kategori_pekerjaan">
                                                            <option value="rutin" >Rutin</option>
                                                            <option value="project" >Project</option>
                                                            <option value="tambahan" >Tambahan</option>
                                                            <option value="kreativitas" >Kretivitas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="firstname" name="nama_pkj" type="text" value=""/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pkj" rows="12"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_angka_kredit">
                                                    <label for="prioritas" class="control-label col-lg-3">Angka Kredit</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="angka_kredit" name="angka_kredit"/>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_kuantitas">
                                                    <label for="prioritas" class="control-label col-lg-3">Kuantitas Output</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="kuantitas_output" name="kuantitas_output"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" id="satuan_kuantitas" name="satuan_kuantitas" value="item" placeholder="satuan kuanttias"/>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="div_kualitas">
                                                    <label for="prioritas" class="control-label col-lg-3">Kualitas Mutu</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="kualitas_mutu" name="kualitas_mutu"/>
                                                    </div>
                                                </div>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Periode</label>
                                                    <div class="col-lg-6" id="">
                                                        <input type="text" class="form-control" id="input_assign_periode" name="periode" value="<?= date('Y') ?>" onchange="assign_periode_changed()"/>
                                                    </div>
                                                </div>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6" id="div_periode_tanggal">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input id="assign_input_tanggal_mulai" readonly type="text" class="form-control" value="" name="tgl_mulai">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input id="assign_input_tanggal_selesai" readonly type="text" class="form-control" value="" name="tgl_selesai">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group " id="div_biaya">
                                                    <label for="prioritas" class="control-label col-lg-3">Biaya</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="biaya" name="biaya" value="-"/>
                                                    </div>
                                                </div>
                                                <div class="form-group " id="div_manfaat">
                                                    <label for="prioritas" class="control-label col-lg-3">Tingkat Kemanfaatan</label>
                                                    <div class="col-lg-6">
                                                        <select name="select_kemanfaatan" class="form-control">
                                                            <option value="1">Bermanfaat bagi unit kerjanya</option>
                                                            <option value="2">Bermanfaat bagi oragnisasinya</option>
                                                            <option value="3">Bermanfaat bagi negara</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                                                    <div class="col-lg-6">
                                                        <select name="prioritas" class="form-control m-bot15">
                                                            <option value="1" >Urgent</option>
                                                            <option value="2" >Tinggi</option>
                                                            <option value="3" >Sedang</option>
                                                            <option value="4" >Rendah</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">File</label>
                                                    <div class="col-lg-6">
                                                        <div id="list_file_upload_assign">
                                                            <div id="file_baru">
                                                                <table  class="table table-hover general-table" id="berkas_assign"></table>
                                                            </div>
                                                        </div>
                                                        <div style="display:none">
                                                            <input type="file" multiple="" name="berkas[]" id="pilih_berkas_assign" onchange="pilih_berkas_assign_changed()"/>
                                                        </div>
                                                        <button class="btn btn-info" type="button" id="button_pilih_berkas_assign" onclick="click_pilih_berkas_assign()"><i class="fa fa-files-o"></i> Pilih File</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-3 col-lg-6">
                                                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>                                            
                                    </div>
                                    <div id="div_tugas" class="tab-pane">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo site_url() ?>/pekerjaan_staff/add_tugas" enctype="multipart/form-data">
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Periode</label>
                                                    <div class="col-lg-6" id="">
                                                        <select class="form-control" id="tugas_select_periode" name="periode">
                                                            <?php
                                                            for ($i = $tahun_max; $i >= $tahun_min; $i--) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Pekerjaan</label>
                                                    <div class="col-lg-6" id="">
                                                        <select class="form-control" id="tugas_select_pekerjaan" name="id_pekerjaan">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="staff" class="control-label col-lg-3">Staff</label>
                                                    <div class="col-lg-6">
                                                        <div id="span_list_assign_staff">
                                                            <table id="tabel_assign_staff_tugas" class="table table-hover general-table">
                                                            </table>
                                                        </div>
                                                        <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff_tugas();" id="button_tampilkan_staff_tugas">Tambah Staff</a>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pkj" rows="12"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6" id="div_periode_tanggal">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input readonly type="text" class="form-control" value="" name="tgl_mulai" id="tugas_tanggal_mulai">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input readonly type="text" class="form-control" value="" name="tgl_selesai" id="tugas_tanggal_selesai">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">File</label>
                                                    <div class="col-lg-6">
                                                        <div id="list_file_upload_assign">
                                                            <div id="file_baru">
                                                                <table  class="table table-hover general-table" id="berkas_tugas"></table>
                                                            </div>
                                                        </div>
                                                        <div style="display:none">
                                                            <input type="file" multiple="" name="berkas[]" id="pilih_berkas_tugas" onchange="pilih_berkas_tugas_changed()"/>
                                                        </div>
                                                        <button class="btn btn-info" type="button" id="button_pilih_berkas_tugas" onclick="click_pilih_berkas_tugas()"><i class="fa fa-archive"></i> Pilih File</button>
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
                                    <div id="PekerjaanStaff" class="tab-pane active">
                                        <section class="panel">
                                            <header class="panel-heading">
                                                Daftar Staff
                                            </header>
                                            <div class="panel-body">
                                                <div class="form">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                                                        <thead>
                                                            <tr>
                                                                <th style="min-width: 45px">No</th>
                                                                <th class="hidden-phone" style="min-width: 80px">NIP Staff</th>
                                                                <th class="hidden-phone">Nama Staff</th>
                                                                <th class="hidden-phone">Jabatan Staff</th>
                                                                <th class="hidden-phone" style="min-width: 100px; width: 150px">Departemen</th>
                                                                <th class="hidden-phone">Email Staff</th>
                                                                <th style="text-align: right;width: 80px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($my_staff)) {
                                                                $has_listed = array();
                                                                //var_dump($my_staff);
                                                                $counter = 0;
                                                                foreach ($my_staff as $staff) {
                                                                    if (in_array($staff->id_akun, $has_listed))
                                                                        continue;
                                                                    $has_listed[] = $staff->id_akun;
                                                                    $counter++;
                                                                    ?>
                                                                    <tr>
                                                                        <td style="text-align: right"><?= $counter ?></td>
                                                                        <td><?= $staff->nip ?></td>
                                                                        <td><?= $staff->nama ?></td>
                                                                        <td><?= $staff->nama_jabatan ?></td>
                                                                        <td><?= $staff->nama_departemen ?></td>
                                                                        <td><?= $staff->email ?></td>
                                                                        <td><a class="btn btn-success btn-xs" href="<?= site_url() ?>/pekerjaan_staff/staff?id_staff=<?= $staff->id_akun ?>"/><i class="fa fa-eye"></i>View</a></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
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
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/pekerjaan_staff/js_view_pekerjaan_staff.js"></script>
    <script>
        var list_staff = <?php echo json_encode($my_staff); ?>;
        var site_url = '<?= site_url(); ?>';
        var pekerjaan = null;
    </script>