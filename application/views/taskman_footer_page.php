<!--Core js-->

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
                    html = "<li><p class=\"\">Anda Memiliki " + jumlah_data + " Pending Task</p></li>";
                    for (var i = 0; i < jumlah_data; i++) {
                        html += "<li>" +
                                "<a href =\"<?php echo site_url(); ?>/pekerjaan/deskripsi_pekerjaan?id_detail_pkj="+json.data[i]["id_pekerjaan"]+ "\" >" +
                                "<div class = \"task-info clearfix\" >" +
                                "<div class = \"desc pull-left\" >" +
                                "<h5>"+json.data[i]["nama_pekerjaan"]+"</h5>" +
                                "<p >"+ json.data[i]["progress"] +"% , "+ json.data[i]["tgl_selesai"] +" </p>" +
                                "</div>" +
                                "<span class = \"notification-pie-chart pull-right\" data-percent = \""+ json.data[i]["progress"] +"\" >" +
                                "<span class = \"percent\" > </span>" +
                                "</span>" +
                                "</div>" +
                                "</a>" +
                                "</li>";
                    }
                    html+="<li class=\"external\"><a href=\"<?php echo site_url(); ?>/pekerjaan/karyawan\">Lihat Semua Task</a></li>";
                    $("#bagian_pending_task").html(html);
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
