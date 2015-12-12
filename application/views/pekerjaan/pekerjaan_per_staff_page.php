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
                        <section class="panel">
                            <header class="panel-heading" id="header_pekerjaan_staff">
                                Daftar Pekerjaan <?php echo $nama_staff ?>
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px" id="kolom_nomor">No</th>
                                                <th style="width: 240px">Nama Pekerjaan</th>
                                                <th style="width: 180px">Deadline</th>
                                                <th>Assign To</th>
                                                <th style="width: 170px">Status</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 0;
                                            $list_id_pekerjaan = array();
                                            $list_status = array(1 => 'Not Approved', 2 => 'Approved', 9 => 'Perpanjang', 't' => 'Terlambat');
                                            $label_status = array(1 => 'label-danger', 2 => 'label-success', 9 => "label-inverse", 't' => 'label-info');
                                            foreach ($pekerjaan_staff as $pekerjaan) {
                                                if (in_array($pekerjaan->id_pekerjaan, $list_id_pekerjaan))
                                                    continue;
                                                $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
                                                $counter++;
                                                ?><tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $pekerjaan->nama_pekerjaan; ?></td>
                                                    <td><?php echo substr($pekerjaan->tgl_mulai, 0, 10) . ' - ' . substr($pekerjaan->tgl_selesai, 0, 10); ?></td>
                                                    <td id="assigh_to_<?php echo $pekerjaan->id_pekerjaan; ?>"></td>
                                                    <td id="status_<?php echo $pekerjaan->id_pekerjaan; ?>" style=""><span class="label <?= $label_status[$pekerjaan->flag_usulan] ?> label-mini"><?= $list_status[$pekerjaan->flag_usulan] ?></span></td>
                                                    <td><a  href="<?php echo base_url(); ?>pekerjaan/deskripsi_pekerjaan?id_detail_pkj=<?php echo $pekerjaan->id_pekerjaan; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a></td>
                                                </tr><?php
                                            }
                                            ?>
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
    
    <script id="list_variabel">
        document.title = "Daftar Pekerjaan <?php echo $nama_staff; ?> - Task Management";
        var my_staff = jQuery.parseJSON('<?php echo json_encode($my_staff); ?>');
        var detil_pekerjaan = jQuery.parseJSON('<?php echo $detil_pekerjaan; ?>');
        var detil_progress = [];
		
<?php
//var_dump($detil_progress);
foreach ($detil_progress as $progress) {
    ?>
            var progress = {
                id_detil_progress:<?= $progress->id_detil_progress; ?>,
                id_detil_pekerjaan:<?= $progress->id_detil_pekerjaan; ?>,
                deskripsi: '<?php echo str_replace("\n", "<br>", $progress->deksripsi); ?>',
                progress:<?= $progress->progress; ?>,
                waktu: '<?= $progress->waktu; ?>',
                id_pekerjaan:<?= $progress->id_pekerjaan; ?>
            };
            detil_progress.push(progress);
    <?php
}
?>
        var pekerjaan_flag = [];
        var pekerjaan_id = [];
        var pekerjaan_tanggal_selesai = [];
        var pekerjaan_tanggal_mulai = [];
        var pekerjaan_nama = [];

<?php foreach ($pekerjaan_staff as $pekerjaan) { ?>
            pekerjaan_id.push('<?php echo $pekerjaan->id_pekerjaan ?>');
            pekerjaan_nama[<?php echo $pekerjaan->id_pekerjaan ?>] = '<?php echo $pekerjaan->nama_pekerjaan; ?>';
            pekerjaan_flag.push('<?php echo $pekerjaan->flag_usulan; ?>');
            pekerjaan_tanggal_selesai.push('<?php echo date('Y-m-d', strtotime($pekerjaan->tgl_selesai)); ?>');
            pekerjaan_tanggal_mulai.push('<?php echo date('Y-m-d', strtotime($pekerjaan->tgl_mulai)); ?>');

<?php } ?>
        console.log("pekerjaan_nama");
        console.log(pekerjaan_nama);
		var batas_tanggal_bawah='';
		var batas_tanggal_atas='';
		</script>
		<script>
        function get_flag(id_pekerjaan) {
            var jumlah_pekerjaan = pekerjaan_id.length;
            for (var i = 0; i < jumlah_pekerjaan; i++) {
                if (pekerjaan_id[i] == id_pekerjaan)
                    return pekerjaan_flag[i];
            }
            return 1;
        }
		</script>
		<script>
        function get_tanggal_selesai(id_pekerjaan) {
            var jumlah_pekerjaan = pekerjaan_id.length;
            for (var i = 0; i < jumlah_pekerjaan; i++) {
                if (pekerjaan_id[i] == id_pekerjaan)
                    return pekerjaan_tanggal_selesai[i];
            }
        }
		</script>
		<script>
        function get_tanggal_mulai(id_pekerjaan) {
            var jumlah_pekerjaan = pekerjaan_id.length;
            for (var i = 0; i < jumlah_pekerjaan; i++) {
                if (pekerjaan_id[i] == id_pekerjaan)
                    return pekerjaan_tanggal_mulai[i];
            }
        }
		</script>
		<script>
        function fill_tabel_pekerjaan() {
            var jumlah_detil = detil_pekerjaan.length;
            console.log('jumlah detil = ' + jumlah_detil);
            var jumlah_staff = my_staff.length;
            for (var i = 0; i < jumlah_detil; i++) {
                var cell_to_process = 'assigh_to_' + detil_pekerjaan[i]['id_pekerjaan'];
                //console.log('cell to process = ' + cell_to_process);
                var cell = $('#' + cell_to_process);
                if (cell.length > 0) {
                    var nama_staff = '';
                    for (var j = 0; j < jumlah_staff; j++) {
                        if (my_staff[j]['id_akun'] == detil_pekerjaan[i]['id_akun'])
                        {
                            nama_staff = my_staff[j]['nama'];
                            break;
                        }
                    }
                    if (cell.html().length > 0) {
                        cell.html(cell.html() + '<br>' + nama_staff);
                    } else {
                        cell.html(nama_staff);
                    }
                    var flag = get_flag(detil_pekerjaan[i]['id_pekerjaan']);
                    ubah_status_pekerjaan('status_' + detil_pekerjaan[i]['id_pekerjaan'], get_flag(detil_pekerjaan[i]['id_pekerjaan']), detil_pekerjaan[i]['sekarang'], get_tanggal_mulai(detil_pekerjaan[i]['id_pekerjaan']), get_tanggal_selesai(detil_pekerjaan[i]['id_pekerjaan']), detil_pekerjaan[i]['tgl_read'], detil_pekerjaan[i]['status'], detil_pekerjaan[i]['progress']);
                }
            }
        }
		</script>
		<script>
        function morris_bar() {
            //sudut pandang => pekerjaan terhadap tanggal
            var jumlah_detil_progress = detil_progress.length;
            var data_graph = [];
            var jumlah_pekerjaan = pekerjaan_id.length;
            console.log("mengolah detil progress");
            var prev_progress = [];
            for (var i = 0; i < jumlah_detil_progress; i++) {
                var tanggal = detil_progress[i].waktu.substring(0, 19);
                console.log(tanggal);
                if (!data_graph[tanggal]) {
                    data_graph[tanggal] = [];
                    for (var j = 0; j < jumlah_detil_progress; j++) {
                        if (!data_graph[tanggal][detil_progress[j].id_pekerjaan]) {
                            if (!prev_progress[detil_progress[j].id_pekerjaan]) {
                                prev_progress[detil_progress[j].id_pekerjaan] = 0;
                            }
                            data_graph[tanggal][detil_progress[j].id_pekerjaan] = prev_progress[detil_progress[j].id_pekerjaan];
                        }
                        /*if(!data_graph[tanggal][pekerjaan_nama[pekerjaan_id[j]]]){
                         data_graph[tanggal][pekerjaan_nama[pekerjaan_id[j]]]=0;
                         }*/
                    }
                }
                //data_graph[tanggal][pekerjaan_nama[detil_progress[i].id_pekerjaan]]=detil_progress[i].progress;
                data_graph[tanggal][detil_progress[i].id_pekerjaan] = detil_progress[i].progress;
                prev_progress[detil_progress[i].id_pekerjaan] = detil_progress[i].progress;
            }
            console.log("jumlah_pekerjaan " + jumlah_pekerjaan);
            console.log("data_graph");
            console.log(data_graph);
            var y_key = [];
            var y_label = [];
            var data_graph_text = "";
            var sep1 = '';
            for (var i in data_graph) {
                if (data_graph.hasOwnProperty(i)) {
                    var tanggal = i;
                    data_graph_text += sep1 + '{"x":"' + tanggal + '",';
                    var isi = data_graph[i];
                    var sep2 = '';
                    for (var j in isi) {
                        if (isi.hasOwnProperty(j)) {
                            data_graph_text += sep2 + '"' + j + '":' + isi[j];
                            sep2 = ',';
                            if (y_key.indexOf(j) == -1) {
                                y_key.push(j);
                                y_label.push(pekerjaan_nama[j]);
                            }
                        }
                    }
                    data_graph_text += '}';
                    sep1 = ',';
                }
            }
            console.log(data_graph_text);
            var myJsonString = JSON.stringify(data_graph);
            console.log(myJsonString);
            console.log(y_key);
            console.log(y_label);
            console.log('json');
            var data_graph = jQuery.parseJSON('[' + data_graph_text + ']');
            console.log(data_graph);


            if ($('#grafik_morris').length == 0) {
                $('#div_grafik').append('<div id="grafik_morris"></div>');
            }
            Morris.Bar({
                element: 'grafik_morris',
                behaveLikeLine: true,
                gridEnabled: false,
                gridLineColor: '#dddddd',
                axes: true,
                fillOpacity: .7,
                data: data_graph,
                //lineColors:['#E67A77','#D9DD81','#79D1CF'],
                xkey: 'x',
                ykeys: y_key,
                labels: y_label,
                pointSize: 0,
                lineWidth: 0,
                hideHover: 'auto'

            });
        }
		</script>
		<script>
        function duadigit(v) {
            if (v >= 0 && v <= 9) {
                return '0' + v;
            }
            return v;
        }
		</script>
		<script id="buat_filter_grafik">
		function buat_filter_graph(list_date){
			if(list_date.length==0)
			return 0;
			
			if ($('#grafik_morris').length == 0) {
                $('#div_grafik').append('<div class="cmxform form-horizontal"><div id="grafik_filter" class="form-group"></div></div>');
            }
			var filter_div = $('#grafik_filter');
			filter_div.append('<label class="control-label col-lg-3">Filter Tanggal</label>'+
                              '<div class="col-lg-4">'+
                              '<div class="input-group input-large" data-date-format="dd-mm-yyyy">'+
                              '<input id="graf_tanggal_mulai" readonly type="text" class="form-control " value="" name="">'+
                              '<span class="input-group-addon">Sampai</span>'+
                              '<input id="graf_tanggal_akhir" readonly type="text" class="form-control " value="" name="">'+
                              '</div>'+
							  '<input type="button" class="btn btn-success" value="Tampilkan" style="display:none">'+
                              '</div>'+
							  '<a class="btn btn-success" data-toggle="modal" href="#modalFilterPekerjaan" onclick="filter_pekerjaan();">Filter Pekerjaan</a>'
							  
							  );
			//var graf_tanggal_mulai=$('#graf_tanggal_mulai');
			//var graf_tanggal_akhir=$('#graf_tanggal_akhir');
			var tanggal_mulai = list_date[0];
			var tanggal_akhir = list_date[list_date.length-1];
			var tanggal_akhir2=tanggal_akhir;
			var tanggal_mulai2=tanggal_mulai;
			var check_awal = $('#graf_tanggal_mulai').datepicker({
				format: 'dd-mm-yyyy',
				onRender:function(date){
					return date.valueOf() < tanggal_mulai.valueOf() || date.valueOf() > tanggal_akhir.valueOf()  ? 'disabled':'';
				}
			}).on('changeDate', function(ev) {
				console.log(check_awal.date);
				tanggal_mulai2=check_awal.date;
				batas_tanggal_bawah=tanggal_mulai2.getFullYear()+'-'+duadigit(tanggal_mulai2.getMonth()+1)+'-'+duadigit(tanggal_mulai2.getDate());
				highchart_bar_process();
				check_awal.hide();
                //$('#graf_tanggal_akhir').focus();
            }).data('datepicker');
			var check_akhir = $('#graf_tanggal_akhir').datepicker({
				format: 'dd-mm-yyyy',
				onRender: function(date){
					return date.valueOf() < tanggal_mulai.valueOf() || date.valueOf() > tanggal_akhir.valueOf() ? 'disabled':'';
				}
			}).on('changeDate', function(ev) {
				console.log(check_akhir.date);
				tanggal_akhir2=check_akhir.date;
				batas_tanggal_atas=tanggal_akhir2.getFullYear()+'-'+duadigit(tanggal_akhir2.getMonth()+1)+'-'+duadigit(tanggal_akhir2.getDate());
				highchart_bar_process();
                check_akhir.hide();
            }).data('datepicker');
			//check_awal.date=tanggal_mulai;
			//check_akhir.date=tanggal_akhir;
			//graf_tanggal_mulai.val(duadigit(tanggal_mulai.getDate()) + '-' +duadigit(tanggal_mulai.getMonth()+1)+'-'+duadigit(tanggal_mulai.getFullYear()));
			tanggal_akhir.setDate(tanggal_akhir.getDate()+1);
			if(tanggal_akhir.getHours()>0||tanggal_akhir.getMinutes()>0||tanggal_akhir.getSeconds()>0){
				tanggal_akhir.setHours(0);
				tanggal_akhir.setMinutes(0);
				tanggal_akhir.setSeconds(0);
			}
			tanggal_mulai.setHours(0);
			tanggal_mulai.setMinutes(0);
			tanggal_mulai.setSeconds(0);
			check_awal.setValue(tanggal_mulai);
			check_akhir.setValue(tanggal_akhir);
			//console.log(check_awal);
			//console.log(check_akhir);
			batas_tanggal_atas=tanggal_akhir.getFullYear()+'-'+duadigit(tanggal_akhir.getMonth()+1)+'-'+duadigit(tanggal_akhir.getDate());
			batas_tanggal_bawah=tanggal_mulai.getFullYear()+'-'+duadigit(tanggal_mulai.getMonth()+1)+'-'+duadigit(tanggal_mulai.getDate());
			console.log('script filter grafik');
			return 1;
		}
		</script>
		<script id="list_variabel2">
			var list_tanggal = [];
            var list_date = [];
            //var list_nama_pekerjaan = [];
            var series_name = [];
            var series_data = [];
            var series_data2 = [];
		</script>		
		<script>
        function highchart_bar_init() {
//sudut pandang => tanggal terhadap pekerjaan
            list_tanggal = [];
            list_date = [];
            //list_nama_pekerjaan = [];
            

            var jumlah_detil_progress = detil_progress.length;
            for (var i = 0; i < jumlah_detil_progress; i++) {
                var tanggal = detil_progress[i].waktu.substring(0, 19);
                if (list_tanggal.indexOf(tanggal) == -1) {
                    list_tanggal.push(tanggal);
                    //console.log('tanggal '+tanggal)
                    var dddd = new Date(tanggal.substring(0, 10));
                    //console.log('jam '+tanggal.substring(11,13));
                    dddd.setHours(tanggal.substring(11, 13));
                    //console.log('menit '+tanggal.substring(14,16));
                    dddd.setMinutes(tanggal.substring(14, 16));
                    //console.log('detik '+tanggal.substring(17,19));
                    dddd.setSeconds(tanggal.substring(17, 19));
                    dddd.setMilliseconds(0);
                    list_date.push(dddd);
                }
            }
			buat_filter_graph(list_date);
			
			highchart_bar_process();

        }
		function highchart_bar_process(){
			console.log('PROCESSING DATA FOR HIGHCHART');
			var jumlah_detil_progress = detil_progress.length;
			series_name = [];
            series_data = [];
            series_data2 = [];
            for (var i = 0; i < jumlah_detil_progress; i++) {
				var tanggal = detil_progress[i].waktu.substring(0,10);
				if(tanggal<=batas_tanggal_atas && tanggal>=batas_tanggal_bawah){
					if (series_name.indexOf(pekerjaan_nama[detil_progress[i].id_pekerjaan]) == -1) {
						//apakah suatu pekerjaan ikut ditampilkan dalam graf
						var id_pekerjaan = detil_progress[i].id_pekerjaan;
						if(list_pekerjaan_graf_ditampilkan_init==false && list_id_pekerjaan_ditampilkan_status[id_pekerjaan]==true){
							console.log('pekerjaan filter telah diinisialisasi');
							series_name.push(pekerjaan_nama[detil_progress[i].id_pekerjaan]);
							//series_data[pekerjaan_nama[detil_progress[i].id_pekerjaan]]=[];
							series_data2[pekerjaan_nama[detil_progress[i].id_pekerjaan]] = [];
						}else if(list_pekerjaan_graf_ditampilkan_init){
							console.log('pekerjaan filter belum diinisialisasi');
							series_name.push(pekerjaan_nama[detil_progress[i].id_pekerjaan]);
							//series_data[pekerjaan_nama[detil_progress[i].id_pekerjaan]]=[];
							series_data2[pekerjaan_nama[detil_progress[i].id_pekerjaan]] = [];
						}
					}
				}
			}
			
			//mencari selisih tampilan graph
			var jumlah_detil_progress = detil_progress.length;
            var jumlah_tanggal = list_date.length;
			
            if (jumlah_tanggal > 0) {
				var batas_atas = new Date(batas_tanggal_atas);
				var batas_bawah = new Date(batas_tanggal_bawah);
				var index_atas = jumlah_tanggal-1;
				var index_bawah = 0;
				var index_atas_init=false;
				var index_bawah_init=false;
				for(var i=0;i<jumlah_tanggal;i++){
					if(!index_atas_init){
						if(list_date[jumlah_tanggal-i-1]<=batas_atas){
							index_atas=jumlah_tanggal-i-1;
							index_atas_init=true;
						}
					}
					if(!index_bawah_init){
						if(list_date[i]>=batas_bawah){
							index_bawah=i;
							index_bawah_init=true;
						}
					}
				}
				
                var area = 1;
				var pakai_jam = true;
                console.log('jumlah tanggal = ' + jumlah_tanggal);
                var selisih = list_date[index_atas] - list_date[index_bawah];
                var r_ = [];
                console.log('selisih = ' + selisih);

                r_['milisecond'] = selisih / jumlah_tanggal;
                console.log('selisih mili = ' + selisih + ' milisecond');

                var second = selisih / 1000;
                r_['second'] = second / jumlah_tanggal;
                console.log('selisih detik = ' + second + ' second');

                var menit = second / 60;
                r_['menit'] = menit / jumlah_tanggal;
                console.log('selisih menit = ' + menit + ' menit');
                if (menit >= 1){
                    area = Math.ceil(menit);
					if(area>10) area=10;
				}

                var jam = menit / 60;
                r_['jam'] = jam / jumlah_tanggal;
                console.log('selisih jam = ' + jam + ' jam');
                if (jam >= 1){
                    area = Math.ceil(jam);
					if(area>10) area=10;
				}

                var hari = jam / 24;
                r_['hari'] = hari / jumlah_tanggal;
                console.log('selisih hari = ' + hari + ' hari');
                if (hari >= 1){
                    area = Math.ceil(hari);
					if(area<5)area=5;
					else pakai_jam=false;
				}

                var minggu = hari / 7;
                r_['minggu'] = minggu / jumlah_tanggal;
                console.log('selisih minggu = ' + minggu + ' minggu');
                if (minggu >= 1){
					pakai_jam=false;
                    area = Math.ceil(minggu);
					if(area<7)area=7;
				}

                var bulan = hari / 30;
                r_['bulan'] = bulan / jumlah_tanggal;
                console.log('selisih bulan = ' + bulan + ' bulan');
                if (bulan >= 1){
                    area = Math.ceil(bulan);
					if(area<4)area=4;
				}

                var r_index = ["milisecond", 'second', 'menit', 'jam', 'hari', 'minggu', 'bulan'];

                console.log('jumlah data tanggal = ' + jumlah_tanggal);

                console.log(r_index);
                var n_r_index = r_index.length;
                for (var i = 0; i < n_r_index; i++) {
                    console.log(r_index[i] + '=' + r_[r_index[i]]);
                }
				
                console.log('area = ' + area);
				
				//membagi ke dalam beberapa daerah, ambil batas maksimal tiap daerah
                var area2 = [];
                var pecahan = selisih / area;
                //var pecahan0 = 0;
                var pecahan1 = pecahan;
                var awal = list_date[index_bawah].getTime();
                for (var i = 0; i < area; i++) {
                    var akhir = awal + pecahan1;
                    var m_d = new Date(awal);
                    var a_d = new Date(akhir)
                    area2.push(
                            {
                                mulai: awal,
                                akhir: akhir,
                                m_d: m_d.getFullYear() + '-' + duadigit(m_d.getMonth() + 1) + '-' + duadigit(m_d.getDate()) + ' ' + duadigit(m_d.getHours()) + ':' + duadigit(m_d.getMinutes()) + ':' + duadigit(m_d.getSeconds()),
                                a_d: a_d.getFullYear() + '-' + duadigit(a_d.getMonth() + 1) + '-' + duadigit(a_d.getDate()) + ' ' + duadigit(a_d.getHours()) + ':' + duadigit(a_d.getMinutes()) + ':' + duadigit(a_d.getSeconds()),
                                series: ''
                            }
                    );
                    //pecahan0 = pecahan1;
                    awal += pecahan;
                    //pecahan1 += pecahan;
                }
                console.log('area2');
                console.log(area2);
            }
            var t = list_tanggal.length;
            var p = series_name.length;
            for (var i = 0; i < t; i++) {
                var tanggal = list_tanggal[i];
				if(tanggal<=batas_tanggal_atas && tanggal>=batas_tanggal_bawah){
					for (var j = 0; j < p; j++) {
						var nama = series_name[j];
						//console.log(j+nama + ' => ' + i+tanggal);
						series_data2[nama][tanggal] = -1;
					}
				}
            }
            for (var i = 0; i < jumlah_detil_progress; i++) {
                var tanggal = detil_progress[i].waktu.substring(0, 19);
				if(tanggal<=batas_tanggal_atas && tanggal>=batas_tanggal_bawah){
					if(series_data2[pekerjaan_nama[detil_progress[i].id_pekerjaan]])
						series_data2[pekerjaan_nama[detil_progress[i].id_pekerjaan]][tanggal] = detil_progress[i].progress;
				}
            }
            var area2_p = area2.length;
            for (var i in series_data2) {
                var prev = 0;
                //console.log(i);
                if (series_data2.hasOwnProperty(i)) {
                    for (var j in series_data2[i]) {
                        if (series_data2[i].hasOwnProperty(j)) {
                            //console.log(series_data2[i][j]);
                            for (var t = 0; t < area2_p; t++) {
                                //console.log(j + ' lebih  dari area2 ' + t + area2[t].m_d + ' ?');
                                if (j >= area2[t].m_d) {
                                    //console.log(j + ' kurang dari area2 ' + t + area2[t].a_d + ' ?');
                                    if (j <= area2[t].a_d) {
                                        //console.log(j + ' lebih dari series area2 ' + t + area2[t].series + ' ?');
                                        if (j >= area2[t].series) {
                                            area2[t].series = j;
                                            //console.log('set area2 series to ' + j);
                                        }
                                    }
                                }
                            }
                            if (series_data2[i][j] == -1) {
                                series_data2[i][j] = prev;
                            } else {
                                prev = series_data2[i][j];
                            }
                        }
                    }
                }
            }
            var series_data = [];
            for (var j = 0; j < series_name.length; j++) {
                var nama = series_name[j];
                //console.log(nama);
                //console.log(area2[i].series );
                if (!series_data[nama])
                    series_data[nama] = [];
            }
            for (var i = 0; i < area2_p; i++) {
                if (area2[i].series.length < 2)
                    area2[i].series = area2[i].a_d;
                for (var j = 0; j < series_name.length; j++) {
                    var nama = series_name[j];
                    //console.log(nama);
                    //console.log(area2[i].series );
                    series_data[nama][area2[i].series] = -1;
                }
            }
            for (var i in series_data2) {
                if (series_data2.hasOwnProperty(i)) {
                    for (var j in series_data2[i]) {
                        if (series_data2[i].hasOwnProperty(j)) {
                            for (var t = 0; t < area2_p; t++) {
                                if (area2[t].series.length > 0 && area2[t].series==j) {
                                    console.log('area2 ' + t + ' set series for  ' + i + ' ' + area2[t].series + ' with  ' + j)
                                    series_data[i][area2[t].series] = series_data2[i][j];
                                }
                            }
                        }
                    }
                }
            }
            for (var i in series_data) {
                var prev=0;
                if (series_data.hasOwnProperty(i)) {
                    for (var j in series_data[i]) {
                        if (series_data[i].hasOwnProperty(j)) {
                           if(series_data[i][j]==-1) {
                               series_data[i][j]=prev;
                           }else{
                               prev=series_data[i][j];
                           }
                        }
                    }
                }
            }

            console.log('area_last');
            console.log(area2);
            console.log('highchart log');
            //console.log(list_tanggal);
            //console.log(list_date);
            console.log('series_name');
            console.log(series_name);
            console.log('series_data');
            console.log(series_data);
            console.log(series_data2);

			//mengubah ke format series dan category untuk highchart
            var jumlah_tanggal = list_date.length;
            console.log('jumlah_tanggal = ' + jumlah_tanggal);
			
            if (jumlah_tanggal > 0) {

                var kategori = [];
                for(var i=0;i<area2.length;i++){
					if(pakai_jam) kategori.push(area2[i].series);
					else kategori.push(area2[i].series.substring(0,10));
                }
                
                var series1 = [];
                for (var i in series_data) {
                    if (series_data.hasOwnProperty(i)) {
                        var new_data = [];
                        for (var j in series_data[i]) {
                            if (series_data[i].hasOwnProperty(j)) {
                                new_data.push(parseInt(series_data[i][j]));
                            }
                        }
                        var new_series = {name: i, data: new_data};
                        series1.push(new_series);
                    }
                }
                highchart_bar1(kategori, series1);
            }
		}
		</script>
		<script>
        function highchart_bar1(kategori, series) {
            //kategori = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            //series = [{name: 'Tokyo', data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]}, {name: 'New York', data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]}, {name: 'London', data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]}, {name: 'Berlin', data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]}];


            //console.log('kategori ');
            //console.log(kategori);
            console.log('series');
            console.log(series);
            if ($('#grafik_highchart1').length == 0) {
                $('#div_grafik').append('<div id="grafik_highchart1"></div>');
            }

            var highchart = {
                chart: {
                    type: 'column'
                },
                title: {
                    text: '<?php echo $nama_staff ?>'
                },
                subtitle: {
                    text: 'Perkembangan Progress Pekerjaan'
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: 'Progress (%)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                xAxis: {
                    categories: kategori
                },
                series: series,
                credits: {
                    text: '',
                    href: ''
                }
            };
            //console.log('highchart');
            //console.log(highchart);
            $('#grafik_highchart1').highcharts(highchart);
        }
        jQuery(document).ready(function() {
            fill_tabel_pekerjaan();
            highchart_bar_init();
			highchart_bar_process();
            //morris_bar();
            $('#tabel_pekerjaan_staff').dataTable({});
            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
            $('#submenu_pekerjaan_ul').attr('style', 'display:block');
        });
    </script>
	<script>
	var list_pekerjaan_graf_ditampilkan_init=true;
	var list_id_pekerjaan_ditampilkan=[];
	var list_id_pekerjaan_ditampilkan_status=[];
	function pilih_pekerjaan_ok(){
		var jumlah_data_ditampilkan=list_id_pekerjaan_ditampilkan.length;
		for(var i=0;i<jumlah_data_ditampilkan;i++){
			if(list_id_pekerjaan_ditampilkan[i]){
				var id_pekerjaan  = list_id_pekerjaan_ditampilkan[i];
				var id_element='pekerjaan_ditampilkan_'+id_pekerjaan;
				console.log('processing element '+id_element);
				var element = $('#'+id_element);
				if(element.length>0){
					console.log(element);
					console.log(id_element+' set to '+element[0].checked);
					if(element[0].checked)
					list_id_pekerjaan_ditampilkan_status[id_pekerjaan]=true;
					else list_id_pekerjaan_ditampilkan_status[id_pekerjaan]=false;
				}else{
					console.log(id_element+' does not exists');
				}
			}
		}
		highchart_bar_process();
	}
	function filter_pekerjaan(){
		if(list_pekerjaan_graf_ditampilkan_init){
			list_pekerjaan_graf_ditampilkan_init=false;
			var jumlah_data_ditampilkan = detil_progress.length;
			for(var i=0;i<jumlah_data_ditampilkan;i++){
				var detil_prog = detil_progress[i];
				if(list_id_pekerjaan_ditampilkan.indexOf(detil_prog.id_pekerjaan)==-1){
					list_id_pekerjaan_ditampilkan.push(detil_prog.id_pekerjaan);
					list_id_pekerjaan_ditampilkan_status[detil_prog.id_pekerjaan]=true;
				}
			}
		}
		var tabel_body = $('#tabel_list_pekerjaan_enroll_body');
		tabel_body.html('');
		var jumlah_data_ditampilkan = list_id_pekerjaan_ditampilkan.length;
		for(var i=0;i<jumlah_data_ditampilkan;i++){
			var id_pekerjaan = list_id_pekerjaan_ditampilkan[i];
			var nama_pekerjaan = pekerjaan_nama[id_pekerjaan];
			tabel_body.append(
				'<tr>'+
				'<td>'+(i+1)+'</td>'+
				'<td>'+nama_pekerjaan+'</td>'+
				'<td><input type="checkbox" id="pekerjaan_ditampilkan_'+id_pekerjaan+'" '+(list_id_pekerjaan_ditampilkan_status[id_pekerjaan]?'checked':'')+' />'+
				'</tr>'
			);
		}
	}
	</script>