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
                                                <th>No</th>
                                                <th>Nama Pekerjaan</th>
                                                <th>Deadline</th>
                                                <th>Assign To</th>
                                                <th>Status</th>
                                                <th></th>
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
                                                    <td><?php echo date("d M Y", strtotime($pekerjaan->tgl_mulai)) . ' - ' . date("d M Y", strtotime($pekerjaan->tgl_selesai)); ?></td>
                                                    <td id="assigh_to_<?php echo $pekerjaan->id_pekerjaan; ?>"></td>
                                                    <td id="status_<?php echo $pekerjaan->id_pekerjaan; ?>">status</td>
                                                    <td><form method="get" action="<?php echo base_url(); ?>pekerjaan/deskripsi_pekerjaan"><input type="hidden" name="id_detail_pkj" value="<?php echo $pekerjaan->id_pekerjaan; ?>"/><button type="submit" class="btn btn-success btn-xs" style="float:right;"><i class="fa fa-eye"></i>View</button></form></td>
                                                </tr><?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
            });
        </script>
        <?php $this->load->view('taskman_rightbar_page') ?>
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script>
        document.title = "Daftar Pekerjaan <?php echo $nama_staff; ?> - Task Management";

        var my_staff = jQuery.parseJSON('<?php echo $my_staff; ?>');
        var detil_pekerjaan = jQuery.parseJSON('<?php echo $detil_pekerjaan; ?>');
        var pekerjaan_flag = [];
        var pekerjaan_id = [];
        var pekerjaan_tanggal_selesai = [];
<?php foreach ($pekerjaan_staff as $pekerjaan) { ?>
            pekerjaan_id.push('<?php echo $pekerjaan->id_pekerjaan ?>');
            pekerjaan_flag.push('<?php echo $pekerjaan->flag_usulan; ?>');
            pekerjaan_tanggal_selesai.push('<?php echo date('Y-m-d',strtotime($pekerjaan->tgl_selesai));?>')
<?php } ?>
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
        var jumlah_detil = detil_pekerjaan.length;
        console.log('jumlah detil = ' + jumlah_detil);
        var jumlah_staff = my_staff.length;
        for (var i = 0; i < jumlah_detil; i++) {
            var cell_to_process='assigh_to_' + detil_pekerjaan[i]['id_pekerjaan'];
            console.log('cell to process = ' + cell_to_process);
            var cell = $('#'+cell_to_process);
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
                    cell.html(cell.html() + ', ' + nama_staff);
                } else {
                    cell.html(nama_staff);
                }
                var flag = get_flag(detil_pekerjaan[i]['id_pekerjaan']);
                ubah_status_pekerjaan('status_' + detil_pekerjaan[i]['id_pekerjaan'], get_flag(detil_pekerjaan[i]['id_pekerjaan']), detil_pekerjaan[i]['sekarang'], get_tanggal_selesai(detil_pekerjaan[i]['id_pekerjaan']), detil_pekerjaan[i]['tgl_read'], detil_pekerjaan[i]['status'], detil_pekerjaan[i]['progress']);
            }
        }
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    </script>