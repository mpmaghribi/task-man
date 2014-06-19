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
                                                    <td id="status_<?php echo $pekerjaan->id_pekerjaan; ?>" style="">status</td>
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
                    <div class="col-md-12" id="div_grafik">
                        <div id="grafik_highchart"></div>
                        <div id="grafik_morris"></div>
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
    <script src="<?php echo base_url() ?>assets/js/morris-chart/morris.js"></script>
    <script src="<?php echo base_url() ?>assets/js/highchart/js/highcharts.js"></script>
    <script src="<?php echo base_url() ?>assets/js/highchart/js/modules/exporting.js"></script>
    <script>

        document.title = "Daftar Pekerjaan <?php echo $nama_staff; ?> - Task Management";

        var my_staff = jQuery.parseJSON('<?php echo json_encode($my_staff); ?>');
        var detil_pekerjaan = jQuery.parseJSON('<?php echo $detil_pekerjaan; ?>');
        var detil_progress = jQuery.parseJSON('<?php echo json_encode($detil_progress); ?>');
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
        function get_flag(id_pekerjaan) {
            var jumlah_pekerjaan = pekerjaan_id.length;
            for (var i = 0; i < jumlah_pekerjaan; i++) {
                if (pekerjaan_id[i] == id_pekerjaan)
                    return pekerjaan_flag[i];
            }
            return 1;
        }
        function get_tanggal_selesai(id_pekerjaan) {
            var jumlah_pekerjaan = pekerjaan_id.length;
            for (var i = 0; i < jumlah_pekerjaan; i++) {
                if (pekerjaan_id[i] == id_pekerjaan)
                    return pekerjaan_tanggal_selesai[i];
            }
        }
        function get_tanggal_mulai(id_pekerjaan) {
            var jumlah_pekerjaan = pekerjaan_id.length;
            for (var i = 0; i < jumlah_pekerjaan; i++) {
                if (pekerjaan_id[i] == id_pekerjaan)
                    return pekerjaan_tanggal_mulai[i];
            }
        }
        function fill_tabel_pekerjaan() {
            var jumlah_detil = detil_pekerjaan.length;
            console.log('jumlah detil = ' + jumlah_detil);
            var jumlah_staff = my_staff.length;
            for (var i = 0; i < jumlah_detil; i++) {
                var cell_to_process = 'assigh_to_' + detil_pekerjaan[i]['id_pekerjaan'];
                console.log('cell to process = ' + cell_to_process);
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

        function morris_bar() {
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
        function highchart_bar() {

            var list_tanggal = [];
            var list_date = [];
            var list_nama_pekerjaan = [];

            var jumlah_detil_progress = detil_progress.length;
            for (var i = 0; i < jumlah_detil_progress; i++) {
                var tanggal = detil_progress[i].waktu.substring(0, 19);
                if (list_tanggal.indexOf(tanggal) == -1) {
                    list_tanggal.push(tanggal);
                    list_date.push(new Date(tanggal));
                }
            }
            console.log('highchart log');
            console.log(list_tanggal);
            console.log(list_date);

            var jumlah_tanggal = list_date.length;
            var selisih = list_date[jumlah_tanggal - 1] - list_date[0];
            var r_ = [];

            r_['milisecond'] = selisih / jumlah_tanggal;
            console.log('selisih tanggal = ' + selisih + ' milisecond');

            var second = selisih / 1000;
            r_['second'] = second / jumlah_tanggal;
            console.log('selisih tanggal = ' + second + ' second');

            var menit = second / 60;
            r_['menit'] = menit / jumlah_tanggal;
            console.log('selisih tanggal = ' + menit + ' menit');

            var jam = menit / 60;
            r_['jam'] = jam / jumlah_tanggal;
            console.log('selisih tanggal = ' + jam + ' jam');

            var hari = jam / 24;
            r_['hari'] = hari / jumlah_tanggal;
            console.log('selisih tanggal = ' + hari + ' hari');

            var minggu = hari / 7;
            r_['minggu'] = minggu / jumlah_tanggal;
            console.log('selisih tanggal = ' + minggu + ' minggu');

            var bulan = hari / 30;
            r_['bulan'] = bulan / jumlah_tanggal;
            console.log('selisih tanggal = ' + bulan + ' bulan');

            var r_index = ["milisecond", 'second', 'menit', 'jam', 'hari', 'minggu', 'bulan'];

            console.log('jumlah data tanggal = ' + jumlah_tanggal);

            console.log(r_index);
            var n_r_index = r_index.length;
            for (var i = 0; i < n_r_index; i++) {
                console.log(r_index[i] + '=' + r_[r_index[i]]);
            }
            var kategori = [];
            var series = [];


            $('#grafik_highchart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Monthly Average Rainfall'
                },
                subtitle: {
                    text: 'Perkembangan progress'
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: 'progress (%)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                }
            });
        }
        jQuery(document).ready(function() {
            EditableTableProgress.init();
            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
            morris_bar();
            fill_tabel_pekerjaan();
            highchart_bar();

        });
    </script>