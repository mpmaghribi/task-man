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
                                        <a data-toggle="tab" href="#div_view_draft">Daftar Draft Pekerjaan</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#div_create_draft">Membuat Draft Pekerjaan</a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <?php 
                                    
                                    //echo $draft_create_submit;
                                    $this->load->view('draft/draft_view');
                                    $this->load->view('draft/draft_create');
                                    ?>
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
        
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script type="text/javascript"> 
        document.title = "Draft Pekerjaan - Task Management";
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        $('#div_view_draft').attr('class','tab-pane active');
    </script>