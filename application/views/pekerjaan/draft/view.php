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
                                <?php echo $draft[0]->nama_pekerjaan; ?>
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -5px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>draft/assign?id_draft=<?php echo $draft[0]->id_pekerjaan; ?>" id="" style="font-size: 10px">Assign</a>
                                    <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>draft/edit?id_draft=<?php echo $draft[0]->id_pekerjaan; ?>" id="" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>draft/view?id_draft=<?php echo $draft[0]->id_pekerjaan; ?>" id="" style="font-size: 10px">View</a>
                                    <a class="btn btn-warning btn-xs" href="javascript:void(0);" id="" onclick="confirm_batal(<?php echo $draft[0]->id_pekerjaan?>,'<?php echo $draft[0]->nama_pekerjaan; ?>');" style="font-size: 10px">Batalkan</a>
                                    <script>
                                        var url_hapus= '<?php echo base_url(); ?>draft/batalkan?id_draft=';
                                        function confirm_batal(id_draft, judul){
                                            var myurl = url_hapus+id_draft;
                                            var c = confirm('apakah anda yakin menghapus draft "' + judul + '"?');
                                            if(c===true){
                                                window.location=myurl;
                                            }
                                        }
                                        </script>
                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
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
            });</script>
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script type="text/javascript">
        document.title = "Draft Pekerjaan - Task Management";
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    </script>