<!--Core js-->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<!--<script src="<?php echo base_url() ?>/assets/js/jquery.simplePagination.js"></script>-->

<script src="<?php echo base_url() ?>/assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="<?php echo base_url() ?>/assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.dcjqaccordion.2.7.js"></script>
<!--<script src="<?php echo base_url() ?>/assets/js/jquery.scrollTo.min.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>-->
<script src="<?php echo base_url() ?>/assets/js/jquery.nicescroll.js"></script>
<!--<script src="<?php echo base_url() ?>/assets/js/gritter/js/jquery.gritter.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/gritter.js" type="text/javascript"></script>-->
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<!--<script src="<?php echo base_url() ?>/assets/js/skycons/skycons.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/jquery.scrollTo/jquery.scrollTo.js"></script>-->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/calendar/clndr.js"></script>-->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/calendar/moment-2.2.1.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/evnt.calendar.init.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/gauge/gauge.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!--clock init-->
<!--<script src="<?php echo base_url() ?>/assets/js/css3clock/js/css3clock.js"></script>-->
<!--Easy Pie Chart-->
<!--<script src="<?php echo base_url() ?>/assets/js/easypiechart/jquery.easypiechart.js"></script>-->
<!--Sparkline Chart-->
<!--<script src="<?php echo base_url() ?>/assets/js/sparkline/jquery.sparkline.js"></script>-->
<!--Morris Chart-->
<!--<script src="<?php echo base_url() ?>/assets/js/morris-chart/morris.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/morris-chart/raphael-min.js"></script>-->

<!--<script src="<?php echo base_url() ?>/assets/js/dashboard.js"></script>-->
<!--<script src="<?php echo base_url() ?>/assets/js/jquery.customSelect.min.js" ></script>-->

<!--<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/fuelux/js/spinner.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery-multi-select/js/jquery.multi-select.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery-multi-select/js/jquery.quicksearch.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/jquery-tags-input/jquery.tagsinput.js"></script>

<!--<script src="<?php echo base_url() ?>assets/js/select2/select2.js"></script>-->
<!--<script src="<?php echo base_url() ?>assets/js/select-init.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/iCheck/jquery.icheck.js"></script>
<script src="<?php echo base_url() ?>assets/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<!--common script init for all pages-->
<script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
<script src="<?php echo base_url() ?>assets/js/advanced-form.js"></script>
<script src="<?php echo base_url() ?>assets/js/validation-init.js"></script>
<!--icheck init -->
<!--<script src="<?php echo base_url() ?>assets/js/icheck-init.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/advanced-datatable/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/js/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url() ?>assets/js/dynamic_table_init.js"></script>
<script>
    function req_notifikasi() {

    }
    function req_pending_task() {
        var bulan = ["Januari", "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
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
                        var deadline = new Date(json.data[i]["tgl_selesai"].substring(0, 19));
                        //console.log("deadline "+json.data[i]["tgl_selesai"]);
                        var Deadline = deadline.getDate() + " " + bulan[deadline.getMonth()] + " " + deadline.getFullYear();
                        var nama_pekerjaan = json.data[i]["nama_pekerjaan"];
                        if (nama_pekerjaan.length > 40)
                            nama_pekerjaan = nama_pekerjaan.substring(0, 40) + " ...";
                        html += "<li>" +
                                "<a href =\"<?php echo base_url(); ?>pekerjaan/deskripsi_pekerjaan?id_detail_pkj=" + json.data[i]["id_pekerjaan"] + "&sumber=notifikasi\">" +
                                "<div class = \"task-info clearfix\" >" +
                                "<div class = \"desc pull-left\" >" +
                                "<p><strong>" + nama_pekerjaan + "</strong></p>" +
                                "<p >" + json.data[i]["progress"] + "% , " + Deadline + " </p>" +
                                "</div>" +
//                                "<span class = \"notification-pie-chart pull-right\" data-percent = \""+ json.data[i]["progress"] +"\" >" +
//                                "<span class = \"percent\" ></span>" +
                                "</span>" +
                                "</div>" +
                                "</a>" +
                                "</li>";
                    }
                    console.log('json pending task');
                    console.log(json);

                    var list_pekerjaan_staff = [];
                    var list_id_pekerjaan = [];
                    var list_pekerjaan_staff_deadline = [];
                    var list_progress_pekerjaan = [];
                    var list_jumlah_pekerja = [];
                    var p = json.pekerjaan_staff.length;
                    var sekarang = '';
                    for (var i = 0; i < p; i++) {
                        list_pekerjaan_staff[json.pekerjaan_staff[i].id_pekerjaan] = json.pekerjaan_staff[i].nama_pekerjaan;
                        //console.log('ivalid date? '+json.pekerjaan_staff[i].tgl_selesai.substring(0, 19));
                        list_pekerjaan_staff_deadline[json.pekerjaan_staff[i].id_pekerjaan] = new Date(json.pekerjaan_staff[i].tgl_selesai.substring(0, 10));
                        list_progress_pekerjaan[json.pekerjaan_staff[i].id_pekerjaan] = 0;
                        list_jumlah_pekerja[json.pekerjaan_staff[i].id_pekerjaan] = 0;
                        if (list_id_pekerjaan.indexOf(json.pekerjaan_staff[i].id_pekerjaan) == -1)
                            list_id_pekerjaan.push(json.pekerjaan_staff[i].id_pekerjaan);
                        sekarang = new Date(json.pekerjaan_staff[i].sekarang.substring(0, 19));
                    }
                    console.log('list_pekerjaan_staff');
                    console.log(list_pekerjaan_staff);
                    console.log('list_id_pekerjaan');
                    console.log(list_id_pekerjaan);
                    console.log('list_pekerjaan_staff_deadline');
                    console.log(list_pekerjaan_staff_deadline);
                    p = json.progress_staff.length;
                    for (var i = 0; i < p; i++) {
                        list_progress_pekerjaan[json.progress_staff[i].id_pekerjaan] += parseInt(json.progress_staff[i].progress);
                        list_jumlah_pekerja[json.progress_staff[i].id_pekerjaan]++;
                    }
                    console.log('list_progress_pekerjaan');
                    console.log(list_progress_pekerjaan);
                    console.log('list_jumlah_pekerja');
                    console.log(list_jumlah_pekerja);
                    p = list_id_pekerjaan.length;
                    for (var i = 0; i < p; i++) {
                        var id_pekerjaan = list_id_pekerjaan[i];
                        if (list_jumlah_pekerja[id_pekerjaan] > 0) {
                            console.log(i);
                            var deadline = list_pekerjaan_staff_deadline[id_pekerjaan];
                            //console.log("deadline "+json.data[i]["tgl_selesai"]);
                            var Deadline = deadline.getDate() + " " + bulan[deadline.getMonth()] + " " + deadline.getFullYear();
                            var nama_pekerjaan = list_pekerjaan_staff[id_pekerjaan];
                            if (nama_pekerjaan.length > 40)
                                nama_pekerjaan = nama_pekerjaan.substring(0, 40) + " ...";
                            html += "<li>" +
                                    '<a href ="<?php echo site_url(); ?>/pekerjaan/deskripsi_pekerjaan?id_detail_pkj=' + list_id_pekerjaan[i] + '&sumber=notifikasi" style="background:#57c8f1">' +
                                    '<div class = "task-info clearfix" >' +
                                    "<div class = \"desc pull-left\" >" +
                                    "<p><strong>" + nama_pekerjaan + "</strong></p>" +
                                    "<p >" + (list_progress_pekerjaan[id_pekerjaan] / list_jumlah_pekerja[id_pekerjaan]) + "% , " + Deadline + " </p>" +
                                    "</div>" +
                                    "</span>" +
                                    "</div>" +
                                    "</a>" +
                                    "</li>";
                            jumlah_data++;
                        }
                    }
                    html += "<li class=\"external\"><a href=\"<?php echo base_url(); ?>pekerjaan/karyawan\">Lihat Semua Task</a></li>";


                    $("#bagian_pending_task").html(html);
                    if (jumlah_data == 0)
                        jumlah_data = "";
                    $("#jumlah_pending_task").html(jumlah_data);
                    //alert("ok");
                } else {
                    //alert("failed, " + json.reason);
                }
            }
        });
    }
    jQuery(document).ready(function() {
        req_pending_task();
    });

    var tinggi = $(window).height();
    var lebar = $(window).width();
    console.log('tinggi = ' + tinggi);
    var tinggi_pending = Math.round(tinggi * 0.7);
    var lebar_pending = Math.round(lebar * 0.35);
    $('#bagian_pending_task').attr('style', 'overflow: scroll; max-height: ' + tinggi_pending + 'px;min-width:' + lebar_pending + 'px !important;overflow-x: hidden;max-width:0px !important;width:'+lebar_pending+'px !important');
</script>
</body>
</html>
