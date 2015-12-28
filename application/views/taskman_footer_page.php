
<!--Core js-->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<!--<script src="<?php echo base_url() ?>assets/js/jquery.simplePagination.js"></script>-->

<script src="<?php echo base_url() ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="<?php echo base_url() ?>assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url() ?>assets/js/gritter/js/jquery.gritter.js"></script>
<script src="<?php echo base_url() ?>assets/js/gritter.js" type="text/javascript"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php echo base_url() ?>assets/js/skycons/skycons.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.scrollTo/jquery.scrollTo.js"></script>
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/calendar/clndr.js"></script>
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/calendar/moment-2.2.1.js"></script>
<script src="<?php echo base_url() ?>assets/js/evnt.calendar.init.js"></script>
<script src="<?php echo base_url() ?>assets/js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="<?php echo base_url() ?>assets/js/gauge/gauge.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.timepicker.min.js"></script>


<!--clock init-->
<script src="<?php echo base_url() ?>assets/js/css3clock/js/css3clock.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo base_url() ?>assets/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo base_url() ?>assets/js/sparkline/jquery.sparkline.js"></script>
<!--Morris Chart-->

<script src="<?php echo base_url() ?>assets/js/morris-chart/morris.js"></script>
<script src="<?php echo base_url() ?>assets/js/morris-chart/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/morris.init.js"></script>

<script src="<?php echo base_url() ?>assets/js/dashboard.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.customSelect.min.js" ></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-tags-input/jquery.tagsinput.js"></script>

<script src="<?php echo base_url() ?>assets/js/select2/select2.js"></script>
<script src="<?php echo base_url() ?>assets/js/select-init.js"></script>
<script src="<?php echo base_url() ?>assets/js/iCheck/jquery.icheck.js"></script>
<script src="<?php echo base_url() ?>assets/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<!--common script init for all pages-->
<script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
<script src="<?php echo base_url() ?>assets/js/advanced-form.js"></script>
<script src="<?php echo base_url() ?>assets/js/validation-init.js"></script>
<!--icheck init -->
<script src="<?php echo base_url() ?>assets/js/icheck-init.js"></script>

<!--<script src="<?php echo base_url() ?>assets/js/advanced-datatable/js/jquery.dataTables.js"></script>-->
<script src="<?php echo base_url() ?>assets/datatables-1.10.7/media/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/js/data-tables/DT_bootstrap.js"></script>

<script src="<?php echo base_url() ?>assets/js/dynamic_table_init.js"></script>
<script>
    var data_akun=<?=json_encode($data_akun)?>;
    var satuhari = 1000*60*60*24;
    function req_notifikasi() {

    }
    function req_pending_task() {
        //console.log('req_pending_task');
        var bulan = ["Januari", "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $.ajax({// create an AJAX call...
            type: "GET", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/req_pending_task", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                //alert(response);
                if (json.status === "OK") {
                    var html = "";
                    var sekarang = new Date(json.sekarang);
                    sekarang.setHours(0);
                    sekarang.setMinutes(0);
                    sekarang.setSeconds(0);
                    sekarang.setMilliseconds(0);
                    var list_id_pekerjaan = [];
                    var list_id_pekerjaan_staff = [];
                    var list_pekerjaan_nama = [];
                    var list_pekerjaan_deadline = [];
                    var list_pekerjaan_progress = [];
                    var list_pekerjaan_mulai = [];
                    var list_jumlah_pekerja = [];
                    var jumlah_data = json.pekerjaan_saya.length;
                    var pekerjaan_saya = json.pekerjaan_saya;
                    for (var i = 0; i < jumlah_data; i++) {
                        var id_pekerjaan = parseInt(pekerjaan_saya[i].id_pekerjaan);
                        if (list_id_pekerjaan.indexOf(id_pekerjaan) == -1) {
                            list_id_pekerjaan.push(id_pekerjaan);
                            //console.log('insert ' + id_pekerjaan);
                        }
                        list_pekerjaan_nama[id_pekerjaan] = pekerjaan_saya[i].nama_pekerjaan;
                        var tanggal = new Date(pekerjaan_saya[i].tgl_selesai.substring(0, 10));
                        tanggal.setHours(0);
                        tanggal.setMinutes(0);
                        tanggal.setSeconds(0);
                        tanggal.setMilliseconds(0);
                        list_pekerjaan_deadline[id_pekerjaan] = tanggal;
                        tanggal = new Date(pekerjaan_saya[i].tgl_mulai.substring(0, 10));
                        tanggal.setHours(0);
                        tanggal.setMinutes(0);
                        tanggal.setSeconds(0);
                        tanggal.setMilliseconds(0);
                        list_pekerjaan_mulai[id_pekerjaan] = tanggal;
                        list_pekerjaan_progress[id_pekerjaan] = parseInt(pekerjaan_saya[i].progress);
                        list_jumlah_pekerja[id_pekerjaan] = 1;
                    }
                    jumlah_data = json.pekerjaan_staff.length;
                    var pekerjaan = json.pekerjaan_staff;
                    for (var i = 0; i < jumlah_data; i++) {
                        var id_pekerjaan = parseInt(pekerjaan[i].id_pekerjaan);
                        var id_pekerjaan_sudah_ada = list_id_pekerjaan.indexOf(id_pekerjaan);
                        //console.log('id pekerjaan ' + id_pekerjaan + ' staff sudah ada = ' + id_pekerjaan_sudah_ada);
                        if (id_pekerjaan_sudah_ada == -1) {
                            list_id_pekerjaan.push(id_pekerjaan);
                            list_id_pekerjaan_staff.push(id_pekerjaan);
                            list_jumlah_pekerja[id_pekerjaan] = 0;
                            list_pekerjaan_progress[id_pekerjaan] = 0;
                            //console.log('insert ' + id_pekerjaan);
                        }
                        list_pekerjaan_nama[id_pekerjaan] = pekerjaan[i].nama_pekerjaan;
                        var tanggal = new Date(pekerjaan[i].tgl_selesai.substring(0, 10));
                        tanggal.setHours(0);
                        tanggal.setMinutes(0);
                        tanggal.setSeconds(0);
                        tanggal.setMilliseconds(0);
                        list_pekerjaan_deadline[id_pekerjaan] = tanggal;
                        tanggal = new Date(pekerjaan[i].tgl_mulai.substring(0, 10));
                        tanggal.setHours(0);
                        tanggal.setMinutes(0);
                        tanggal.setSeconds(0);
                        tanggal.setMilliseconds(0);
                        list_pekerjaan_mulai[id_pekerjaan] = tanggal;
                        list_pekerjaan_progress[id_pekerjaan] = list_pekerjaan_progress[id_pekerjaan] + parseInt(pekerjaan[i].progress);
                        list_jumlah_pekerja[id_pekerjaan]++;
                    }
                    jumlah_data = list_id_pekerjaan.length;
                    for (var i = 0; i < jumlah_data; i++) {
                        var id1 = list_id_pekerjaan[i];
                        for (var j = i + 1; j < jumlah_data; j++) {
                            var id2 = list_id_pekerjaan[j];
                            if (list_pekerjaan_deadline[id1] > list_pekerjaan_deadline[id2]) {
                                list_id_pekerjaan[i] = id2;
                                list_id_pekerjaan[j] = id1;
                                id1 = id2;
                            }
                        }
                    }
                    //console.log('json pending task');
                    //console.log(json);
                    //console.log('list_id_pekerjaan');
                    //console.log(list_id_pekerjaan);
                    //console.log('list_pekerjaan_nama');
                    //console.log(list_pekerjaan_nama);
                    //console.log('list_pekerjaan_mulai');
                    //console.log(list_pekerjaan_mulai);
                    //console.log('list_pekerjaan_deadline');
                    //console.log(list_pekerjaan_deadline);
                    //console.log('list_pekerjaan_progress');
                    //console.log(list_pekerjaan_progress);
                    //console.log('list_jumlah_pekerja');
                    //console.log(list_jumlah_pekerja);
                    //console.log('sekarang');
                    //console.log(sekarang);
                    jumlah_data = list_id_pekerjaan.length;
                    var jumlah_notif = 0;
                    for (var i = 0; i < jumlah_data; i++) {
                        var style = '';
                        var text_style='';
                        var id = list_id_pekerjaan[i];
                        var progress = (list_pekerjaan_progress[id] / list_jumlah_pekerja[id]);
                        if (list_id_pekerjaan_staff.indexOf(id) >= 0) {//pekerjaan staff
                            style = 'style="background:#F1F2D7"';
                            //console.log('pekerjaan staff ' + id);
                            var jumlah_hari_kerja = list_pekerjaan_deadline[id] - list_pekerjaan_mulai[id];
                            var jumlah_hari_lewat = sekarang - list_pekerjaan_mulai[id];
                            jumlah_hari_kerja = jumlah_hari_kerja / satuhari;
                            jumlah_hari_lewat = jumlah_hari_lewat / satuhari;
                            //console.log('perbedaaan hari ' + id)
                            //console.log('jumlah hari kerja = ' + jumlah_hari_kerja);
                            //console.log('jumlah hari lewat = ' + jumlah_hari_lewat);
                            if (jumlah_hari_lewat > 0) {//jika masuk pada waktu pengerjaan pekerjaan staff
                                if (jumlah_hari_lewat >= jumlah_hari_kerja) {//jika telat
                                    //console.log('telat');
                                    style = 'style="background:#FF6C60;"';
                                    text_style='color:white !important;';
                                } else{
                                    var rasio= jumlah_hari_lewat/jumlah_hari_kerja;
                                    //console.log('rasio = '+rasio);
                                    if(rasio<0.2){
                                        style = 'style="background:#A1A1A1;"';
                                        text_style='color:white !important;';
                                    }
                                    
                                }
                            } else {//jika hari ini belum hari pekerjaan dimulai
                                continue;
                            }
                        } else {//pekerjaan ku
                            //console.log('pekerjaan ku ' + id);
                        }
                        var dead = list_pekerjaan_deadline[id];
                        var deadline = dead.getDate() + ' ' + bulan[dead.getMonth()] + ' ' + dead.getFullYear();
                        var nama_pekerjaan = list_pekerjaan_nama[id];
                        if (nama_pekerjaan.length > 35)
                        {
                            nama_pekerjaan = nama_pekerjaan.substring(0, 35) + '...';
                        }
                        html += '<li>' +
                                '<a href="<?= base_url() ?>pekerjaan/deskripsi_pekerjaan?id_detail_pkj=' + id + '&sumber=notifikasi" ' + style + '>' +
                                '<div class="task-info clearfix">' +
                                '<div class="desc pull-left" >' +
                                '<h5 style="text-transform:none;'+text_style+'">' + nama_pekerjaan + '</h5>' +
                                '<p style="'+text_style+'">' + progress + '%, ' + deadline + '</p>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</li>';
                        jumlah_notif++;
                    }
                    html = '<li><p class="">Anda memiliki ' + jumlah_notif + ' Pemberitahuan</p></li>' + html;
                    html += '<li class="external"><a href="<?php echo base_url(); ?>pekerjaan/karyawan">Lihat Semua Task</a></li>';



                    $("#bagian_pending_task").html(html);
                    if (jumlah_notif == 0)
                        jumlah_notif = "";
                    $("#jumlah_pending_task").html(jumlah_notif);
                    //alert("ok");
                } else {
                    //alert("failed, " + json.reason);
                }
            }
        });
    }
	var site_url= '<?= site_url() ?>';
	function req_pending_task2() {
        //console.log('req_pending_task');
        var bulan = ["Januari", "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $.ajax({// create an AJAX call...
            type: "GET", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/req_pending_task", // the file to call
            success: function(response) { // on success..
                var json = JSON.parse(response);
				var sekarang_arr = json['sekarang'].split('-');
				var html='';
				var jumlah_notif=0;
				console.log(sekarang_arr);
				var pekerjaan=json['pekerjaan_saya'];
				for(var i=0,i2=pekerjaan.length;i<i2;i++){
					var p=pekerjaan[i];
					var style='';
					var text_style='';
					var deadline1 = p['tanggal_selesai'].split('-');
					var deadline = deadline1[2]+' '+ bulan[parseInt(deadline1[1])-1]+' '+deadline1[0];
					var nama_pekerjaan=p['nama_pekerjaan'];
					if(nama_pekerjaan.length>35){
						nama_pekerjaan=nama_pekerjaan.substring(0,35)+'...';
					}
					html += '<li>' +
							'<a href="'+site_url+'/pekerjaan_saya/detail?id_pekerjaan=' + p['id_pekerjaan'] + '&sumber=notifikasi" ' + style + '>' +
							'<div class="task-info clearfix">' +
							'<div class="desc pull-left" >' +
							'<h5 style="text-transform:none;'+text_style+'">' + nama_pekerjaan + '</h5>' +
							'<p style="'+text_style+'">' + deadline + '</p>' +
							'</div>' +
							'</div>' +
							'</a>' +
							'</li>';
					jumlah_notif++;
				}
				var pekerjaan=json['pekerjaan_staff'];
				for(var i=0,i2=pekerjaan.length;i<i2;i++){
					var p=pekerjaan[i];
					var style='';
					var text_style='';
					var deadline1 = p['tanggal_selesai'].split('-');
					var deadline = deadline1[2]+' '+ bulan[parseInt(deadline1[1])-1]+' '+deadline1[0];
					var nama_pekerjaan=p['nama_pekerjaan'];
					if(nama_pekerjaan.length>35){
						nama_pekerjaan=nama_pekerjaan.substring(0,35)+'...';
					}
					html += '<li>' +
							'<a href="'+site_url+'/pekerjaan_staff/detail?id_pekerjaan=' + p['id_pekerjaan'] + '&sumber=notifikasi" ' + style + '>' +
							'<div class="task-info clearfix">' +
							'<div class="desc pull-left" >' +
							'<h5 style="text-transform:none;'+text_style+'">' + nama_pekerjaan + '</h5>' +
							'<p style="'+text_style+'">' + deadline + '</p>' +
							'</div>' +
							'</div>' +
							'</a>' +
							'</li>';
					jumlah_notif++;
				}
				$("#bagian_pending_task").html(html);
				if (jumlah_notif == 0)
					jumlah_notif = "";
				$("#jumlah_pending_task").html(jumlah_notif);
            }
        });
    }
	var req_pending_task_interval_id='';
    jQuery(document).ready(function() {
        req_pending_task2();
		req_pending_task_interval_id=setInterval(function(){
			req_pending_task2();
		},60000);
		console.log('id interval = '+req_pending_task_interval_id);
    });

    var tinggi = $(window).height();
    var lebar = $(window).width();
    var tinggi_pending = Math.round(tinggi * 0.7);
    var lebar_pending = Math.round(lebar * 0.35);
    lebar_pending = 320;
    $('#bagian_pending_task').attr('style', 'overflow: scroll; max-height: ' + tinggi_pending + 'px;min-width:' + lebar_pending + 'px !important;overflow-x: hidden;max-width:0px !important;width:' + lebar_pending + 'px !important');
    function format_ukuran_file(s) {
            var KB = 1024;
            var spasi = ' ';
            var satuan = 'bytes';
            if (s > KB) {
                s = s / KB;
                satuan = 'KB';
            }
            if (s > KB) {
                s = s / KB;
                satuan = 'MB';
            }
            return '   [' + Math.round(s) + spasi + satuan + ']';
        }
</script>
</body>
</html>
