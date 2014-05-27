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
                            <header class="panel-heading  ">
                                Assign Draft
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -5px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-info btn-xs" href="<?php echo base_url() . 'draft/edit?id_draft=' . $id_draft; ?>" id="tombol_edit_draft" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-danger btn-xs" href="#" id="tombol_batalkan_batalkan" style="font-size: 10px">Batalkan</a>
                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="" class="tab-pane active">
                                        <section class="panel" >
                                        </section>
                                        <div class="col-md-12">
                                            <section class="panel">

                                                <h4 style="color: #1FB5AD;">
                                                    Tambahkan Staff
                                                </h4>
                                                <div id="div_staff_">

                                                </div>
                                                <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff();">Tambah Staff</a>
                                                <input type="hidden" value="::" name="staff" id="staff"/>


                                            </section>
                                        </div>
                                    </div>
                                    <?php $this->load->view('pekerjaan/draft/detail_view'); ?>
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
        <script>
                                                    jQuery(document).ready(function() {
                                                        EditableTableProgress.init();
                                                    });
        </script>
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script type="text/javascript">



        document.title = "Edit Draft Pekerjaan - Task Management";
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');



    </script>