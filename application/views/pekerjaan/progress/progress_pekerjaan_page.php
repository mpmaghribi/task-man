<?php $this->load->view("taskman_header_page") ?> 
    <body>
        <section id="container">
            <!--header start-->
            <?php $this->load->view("taskman_header2_page") ?>
            <!--header end-->
            <!--sidebar start-->
            <?php $this->load->view("taskman_sidebarleft_page") ?>
            <!--sidebar end-->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    List of tasks
                                </header>
                                <div class="panel-body">
                                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                <tr>
                                    <th>Nama Pegawai</th>
                                    <th>Pekerjaan</th>
                                    <th>Deadline</th>
                                    <th>Progress</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($progress_pekerjaan)) { ?>
                                                    <?php $i = 1;
                                                    foreach ($progress_pekerjaan as $value) {?>
                                                        <tr class="">
                                    <td><?php echo $value->nama?></td>
                                    <td><?php echo $value->nama_pekerjaan?></td>
                                    <td class="center"><?php echo date("d M Y", strtotime($value->tgl_mulai)) ?> - <?php echo date("d M Y", strtotime($value->tgl_selesai)) ?></td>
                                    <td class="center"><?php echo $value->progress?></td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                                    <?php $i++;}
                                                    ?>
                                                <?php } ?>
                                
                              
                                </tbody>
                            </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
            <!--script for this page only-->
<script src="<?php echo base_url()?>assets/js/table-editable.js"></script>

<!-- END JAVASCRIPTS -->
<script>
    jQuery(document).ready(function() {
        EditableTable.init();
    });
</script>
            <!--main content end-->
            <!--right sidebar start-->
            <?php $this->load->view('taskman_rightbar_page')?>
            <!--right sidebar end-->
        </section>
            <?php $this->load->view("taskman_footer_page") ?>