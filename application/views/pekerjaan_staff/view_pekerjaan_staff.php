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
                                        <a data-toggle="tab" href="#assignPekerjaan">Assign Pekerjaan</a>
                                    </li>
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
                                    <div id="assignPekerjaan" class="tab-pane">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo base_url() ?>pekerjaan_staff/add" enctype="multipart/form-data">
                                                <input type="hidden" name="jenis_usulan" value="usulan"/>
                                                <div class="form-group ">
                                                    <label for="staff" class="control-label col-lg-3">Staff</label>
                                                    <div class="col-lg-6">
                                                        <div id="span_list_assign_staff">
                                                            <table id="tabel_assign_staff" class="table table-hover general-table">
                                                            </table>
                                                        </div>
                                                        <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff();">Tambah Staff</a>
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
                                                    <label for="kategori" class="control-label col-lg-3">Kategori</label>
                                                    <div class="col-lg-6">
                                                        <select name="kategori" class="form-control m-bot15">
                                                            <option value="rutin">Rutin</option>
                                                            <option value="project">Project</option>
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
                                                <div class="form-group ">
                                                    <label for="deadline" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6 ">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input id="d" readonly type="text" class="form-control dpd1" value="" name="tgl_mulai_pkj">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input readonly type="text" class="form-control dpd2" value="" name="tgl_selesai_pkj">
                                                        </div>
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
                                                                        <td><a class="btn btn-success btn-xs" href="<?= base_url() ?>pekerjaan_staff/staff?id_staff=<?= $staff->id_akun ?>"/><i class="fa fa-eye"></i>View</a></td>
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
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/date_picker_init.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/pekerjaan_staff/js1.js"></script>
    <script >
                                                            var list_staff = <?php echo json_encode($my_staff); ?>;
    </script>