<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="images/favicon.png">

        <title>Dashboard</title>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.min.js"></script>
<!--        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.0.3.min.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>

        <link href="<?php echo base_url() ?>/assets/bs3/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/css/clndr.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/js/bootstrap-datepicker/css/datepicker.css" />
        <link href="<?php echo base_url()?>/assets/css/simplePagination.css" rel="stylesheet"/>
        
        <!--icheck-->
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/minimal/red.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/minimal/green.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/minimal/blue.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/minimal/yellow.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/minimal/purple.css" rel="stylesheet">

        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/square/square.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/square/red.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/square/green.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/square/blue.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/square/yellow.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/square/purple.css" rel="stylesheet">

        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/flat/grey.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/flat/red.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/flat/green.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/flat/blue.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/flat/yellow.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/iCheck/skins/flat/purple.css" rel="stylesheet">

        <!--clock css-->
        <link href="<?php echo base_url() ?>/assets/js/css3clock/css/style.css" rel="stylesheet">
        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?php echo base_url() ?>/assets/js/morris-chart/morris.css">
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url() ?>/assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/css/style-responsive.css" rel="stylesheet"/>

        <!--Notification style-->
        <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/notification.css">
        <!--End of notification style-->
    <!--    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/bootstrap-switch.css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/js/jquery-multi-select/css/multi-select.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/js/jquery-tags-input/jquery.tagsinput.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/js/select2/select2.css" />
        
        <link href="<?php echo base_url() ?>/assets/js/advanced-datatable/css/demo_page.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/js/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/js/data-tables/DT_bootstrap.css" />
    </head>

<body>

    <section id="container" >
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->


                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <div class="form">
                                <table class="table table-hover general-table">
                                    <thead>
                                        <tr>
                                            <th> No</th>
                                            <th class="hidden-phone">Pekerjaan</th>
                                            <th>Deadline</th>
                                            <th>Assign To</th>
                                            <th>Status</th>
                                            <th></th>
<!--                                                            <th>Progress</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($pkj_karyawan)) { ?>
                                            <?php
                                            $i = 1;
                                            foreach ($pkj_karyawan as $value) {
                                                ?>
                                                <?php if ($value->flag_usulan == 2) { ?>
                                                    <tr>
                                                        <td>
                                                            <a href="#">
                                                                <?php echo $i; ?>
                                                            </a>
                                                        </td>
                                                        <td class="hidden-phone"><?php echo $value->nama_pekerjaan ?></td>
                                                        <td> <?php echo date("d M Y", strtotime($value->tgl_mulai)) ?> - <?php echo date("d M Y", strtotime($value->tgl_selesai)) ?></td>
                                                        <td id="pekerjaan_nama_staff_<?php echo $value->id_pekerjaan; ?>"></td>
                                                        <td><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>

                                                        <td>
                                                            <form method="get" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                <input type="hidden" name="id_detail_pkj" value="<?php echo $value->id_pekerjaan ?>"/>
                                                                <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>

                        </section>
                    </div>
                </div>


                <script>
                    $(function() {
                        $('#nama_pkj').click(function(e) {
                            e.preventDefault();
                            $('#deskripsi_pkj').show();
                            $('#deskripsi_pkj2').load('<?php echo site_url() ?>pekerjaan/deskripsi_pekerjaan');
                        });
                    });
                </script>
                <!-- page end-->
            </section>
        </section>
    </section>
<!--Core js-->
<script src="<?php echo base_url()?>/assets/js/jquery.simplePagination.js"></script>
<!--Notification script-->
    <script src="<?php echo base_url()?>/assets/js/miniNotification.js"></script>
    <script>
      $(function() {
        $('#mini-notification').miniNotification();
      });
    </script>
    <!--End of notification script-->
<script src="<?php echo base_url()?>/assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="<?php echo base_url()?>/assets/bs3/js/bootstrap.min.js"></script>
<script class="include" src="<?php echo base_url()?>/assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php echo base_url()?>/assets/js/skycons/skycons.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.scrollTo/jquery.scrollTo.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/calendar/clndr.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="<?php echo base_url()?>/assets/js/calendar/moment-2.2.1.js"></script>
<script src="<?php echo base_url()?>/assets/js/evnt.calendar.init.js"></script>
<script src="<?php echo base_url()?>/assets/js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="<?php echo base_url()?>/assets/js/gauge/gauge.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!--clock init-->
<script src="<?php echo base_url()?>/assets/js/css3clock/js/css3clock.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo base_url()?>/assets/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo base_url()?>/assets/js/sparkline/jquery.sparkline.js"></script>
<!--Morris Chart-->
<script src="<?php echo base_url()?>/assets/js/morris-chart/morris.js"></script>
<script src="<?php echo base_url()?>/assets/js/morris-chart/raphael-min.js"></script>

<script src="<?php echo base_url()?>/assets/js/dashboard.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.customSelect.min.js" ></script>

<script type="text/javascript" src="<?php echo base_url()?>/assets/js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="<?php echo base_url()?>assets/js/select2/select2.js"></script>
<script src="<?php echo base_url()?>assets/js/select-init.js"></script>
<script src="<?php echo base_url()?>assets/js/iCheck/jquery.icheck.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<!--common script init for all pages-->
<script src="<?php echo base_url()?>assets/js/scripts.js"></script>
<script src="<?php echo base_url()?>assets/js/advanced-form.js"></script>
<script src="<?php echo base_url()?>assets/js/validation-init.js"></script>
<!--icheck init -->
<script src="<?php echo base_url()?>assets/js/icheck-init.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url()?>assets/js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/data-tables/DT_bootstrap.js"></script>

<script src="<?php echo base_url()?>assets/js/dynamic_table_init.js"></script>


<script>
    function req_notifikasi() {

    }
    function req_pending_task() {
        $.ajax({// create an AJAX call...
            data: "", // get the form data
            type: "GET", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/req_pending_task", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                //alert(response);
                if (json.status === "OK") {
                    //alert("ok1");
                    var html = "";
                    var jumlah_data = json.data.length;
                    //id="bagian_pending_task">
                    html = "<li><p class=\"\">Anda Memiliki " + jumlah_data + " Pemberitahuan</p></li>";
                    for (var i = 0; i < jumlah_data; i++) {
                        html += "<li>" +
                                "<a href =\"<?php echo site_url(); ?>/pekerjaan/deskripsi_pekerjaan?id_detail_pkj="+json.data[i]["id_pekerjaan"]+ "&sumber=notifikasi\">" +
                                "<div class = \"task-info clearfix\" >" +
                                "<div class = \"desc pull-left\" >" +
                                "<p><strong>"+json.data[i]["nama_pekerjaan"].substring(0,30)+"...</strong></p>" +
                                "<p >"+ json.data[i]["progress"] +"% , "+ json.data[i]["tgl_selesai"] +" </p>" +
                                "</div>" +
//                                "<span class = \"notification-pie-chart pull-right\" data-percent = \""+ json.data[i]["progress"] +"\" >" +
//                                "<span class = \"percent\" ></span>" +
                                "</span>" +
                                "</div>" +
                                "</a>" +
                                "</li>";
                    }
                    html+="<li class=\"external\"><a href=\"<?php echo site_url(); ?>/pekerjaan/karyawan\">Lihat Semua Task</a></li>";
                    $("#bagian_pending_task").html(html);
                    if(jumlah_data==0)
                        jumlah_data="";
                    $("#jumlah_pending_task").html(jumlah_data);
                    //alert("ok");
                } else {
                    //alert("failed, " + json.reason);
                }
            }
        });
    }
    req_pending_task();
</script>
</body>
</html>

    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

    <!-- END JAVASCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            EditableTableProgress.init();
        });
    </script>
