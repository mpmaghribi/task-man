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
                    <div class="col-md-12">
                        <header class="panel-heading" id="header_pekerjaan_staff">
                                Daftar Pekerjaan <?php echo $nama_staff ?>
                            </header>
                        <section class="panel">
                            
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px" id="kolom_nomor">No</th>
                                                <th style="width: 240px">Nama Pekerjaan</th>
                                                <th>Periode</th>
                                                <th>Assign To</th>
                                                <th style="width: 170px">Status</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_pekerjaan_staff_body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal fade" id="modalFilterPekerjaan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="tombol_tutup">&times;</button>
                                    <h4 class="modal-title">Pilih Pekerjaan</h4>
                                </div>
                                <div class="modal-body" id="tambahkan_staff_body">
                                    <table id="tabel_list_pekerjaan_enroll" class="table table-hover general-table">
                                        <thead id="tabel_list_enroll_staff_head">
                                            <tr id="tabel_list_enroll_staff_head">
                                                <th>No</th>
                                                <th>Nama Pekerjaan</th>
                                                <th>Enroll</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_list_pekerjaan_enroll_body">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                                    <button data-dismiss="modal" class="btn btn-success" type="button" onclick="pilih_pekerjaan_ok();">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="div_grafik">
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

        <!-- END JAVASCRIPTS -->

        <?php $this->load->view('taskman_rightbar_page') ?>
    </section>
    <?php $this->load->view("taskman_footer_page") ?>

    <script src="<?php echo base_url() ?>assets/js/morris-chart/raphael-min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/morris-chart/morris.js"></script>
    <script src="<?php echo base_url() ?>assets/js/highchart/js/highcharts.js"></script>
    <script src="<?php echo base_url() ?>assets/js/highchart/js/modules/exporting.js"></script>

    <script src="<?= base_url() ?>assets/js2/pekerjaan_staff/js2.js"></script>
    <script>
                                        var base_url = '<?= base_url() ?>';
                                        var site_url='<?=site_url()?>';
                                        var id_staff = '<?= $id_staff ?>';
                                        var list_staff =<?= json_encode($my_staff) ?>;
    </script>