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
                                Edit Draft
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -5px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-info btn-xs" href="<?php echo site_url(); ?>draft/assign?id_draft=<?php echo $draft['id_pekerjaan']; ?>" style="font-size: 10px">Assign</a>
                                    <a class="btn btn-warning btn-xs" href="<?php echo site_url(); ?>draft/edit?id_draft=<?php echo $draft['id_pekerjaan']; ?>" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-success btn-xs" href="<?php echo site_url(); ?>draft/view?id_draft=<?php echo $draft['id_pekerjaan']; ?>"  style="font-size: 10px">View</a>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="dialog_batalkan_draft();" style="font-size: 10px">Batalkan</button>
                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <?php 
                                    //echo $draft_create_submit;
                                    $this->load->view('draft/draft_edit');
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
        <div class="modal fade" id="modal_any" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modal_any_title">Modal Title</h4>
                    </div>
                    <div class="form modal-body" id="modal_any_body">
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button" id="modal_any_button_cancel">Cancel</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button" id="modal_any_button_ok">OK</button>
                    </div>
                </div>
            </div>
	</div>
        <!--main content end-->
        <!--right sidebar start-->
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script type="text/javascript">
        var site_url = '<?= site_url() ?>';
        var pekerjaan = <?= json_encode($draft); ?>;
        jQuery(document).ready(function() {
            document.title = "Edit Draft Pekerjaan - Task Management";
            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        });
        function dialog_batalkan_draft() {
            $('#modal_any').modal('show');
            $('#modal_any_title').html('Konfirmasi Pembatalan Draft Pekerjaan');
            $('#modal_any_body').html('<h5>Anda akan membatalkan draft pekerjaan <strong>' + pekerjaan['nama_pekerjaan'] + '</strong>. Lanjutkan?</h5>');
            $('#modal_any_button_cancel').attr({'class': 'btn btn-warning'}).html('Tutup');
            $('#modal_any_button_ok').attr({'class': 'btn btn-danger', 'onclick': 'batalkan_draft()'}).html('Batalkan');
        }
        function batalkan_draft() {
            var form = $('<form></form>').attr({
                'method': 'get',
                'action': site_url + '/draft/batalkan'
            });
            var id_draft = $('<input></input>').attr({'name': 'id_draft', 'value': pekerjaan['id_pekerjaan']});
            form.append(id_draft);
            $('body').append(form);
            form.submit();
        }
    </script>