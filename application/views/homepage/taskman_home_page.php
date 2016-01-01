<?php $this->load->view("taskman_header_page") ?> 
<!--calendar css-->
<link href="<?php echo base_url(); ?>assets/js/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />

<body>
    <script src="<?php echo base_url() ?>assets/js/status_pekerjaan.js"></script>
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
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon tar"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($alltask) && $alltask > 0)
                                        echo $alltask;
                                    else
                                        echo '0';
                                    ?></span>
                                All Tasks
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon pink"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($ongoingtask) && $ongoingtask > 0)
                                        echo $ongoingtask;
                                    else
                                        echo '0';
                                    ?></span>
                                On-Going Tasks
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon green"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($finishtask) && $finishtask > 0)
                                        echo $finishtask;
                                    else
                                        echo '0';
                                    ?></span>
                                Finished Tasks
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon orange"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($notworkingtask) && $notworkingtask > 0)
                                        echo $notworkingtask;
                                    else
                                        echo '0';
                                    ?></span>
                                Not Working Yet
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-lg-12 calendar-blocks">
                            <section class="panel">
                                <div class="panel-heading">
                                    Aktifitas Pekerjaan Bulan <?php echo date('F Y'); ?>
                                </div>
                                <div class="panel-body">
                                    <!-- page start-->
                                    <div class="row">
                                        <aside class="col-lg-1">

                                            <div id="external-events">
                                            </div>
                                        </aside>
                                        <aside class="col-lg-10 center">
                                            <div id="calendar" class="has-toolbar fc"></div>
                                        </aside>
                                        <aside class="col-lg-1">

                                            <div id="external-events">
                                            </div>
                                        </aside>
                                    </div>
                                    <!-- page end-->
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <!--mini statistics start-->
                <!--mini statistics end-->
                <div class="row">
                    <?php
                    //jika user berhak mengakses halaman yang berisi pekerjaannya
                    ?>
                    <div class="col-md-12" id="div_Pekerjaan" >
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Periode</label>
                                <div class="col-lg-3">
                                    <select class="form-control" id="dashboard_select_periode" onchange="ubah_periode_pekerjaan()">
                                        <?php
                                        $tahun_max = intval($tahun_max);
                                        $tahun_min = intval($tahun_min);
                                        for ($tahun = $tahun_max; $tahun >= $tahun_min; $tahun--) {
                                            echo '<option value="' . $tahun . '">' . $tahun . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <section class="panel">
                            <header class="panel-heading  ">
                                Pekerjaan Saya
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table table-striped table-hover table-condensed" id="dashboard_tabel_pekerjaan_saya">
                                        <thead>
                                            <tr>
                                                <th> No</th>
                                                <th>Nama Pekerjaan</th>
                                                <th>Periode</th>
                                                <th>Assign To</th>
                                                <th>Kategori Pekerjaan</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dashboard_tabel_pekerjaan_saya_body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <header class="panel-heading  ">
                                Pekerjaan Staff
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table table-striped table-hover table-condensed" id="dashboard_tabel_pekerjaan_staff">
                                        <thead>
                                            <tr>
                                                <th> No</th>
                                                <th>Nama Pekerjaan</th>
                                                <th>Periode</th>
                                                <th>Assign To</th>
                                                <th>Kategori Pekerjaan</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dashboard_tabel_pekerjaan_staff_body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <header class="panel-heading  ">
                                Draft Pekerjaan
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table table-striped table-hover table-condensed" id="dashboard_tabel_pekerjaan_draft">
                                        <thead>
                                            <tr>
                                                <th> No</th>
                                                <th>Nama Pekerjaan</th>
                                                <th>Periode</th>
                                                <th>Kategori Pekerjaan</th>
                                                <th>Prioritas</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dashboard_tabel_pekerjaan_draft_body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--<div class="panel-body">
                                <div class="form">
                                    <table id="tabel_pekerjaan_saya" class="table table-striped table-hover table-condensed" >
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No.</th>
                                                <th rowspan="2">Pekerjaan</th>
                                                <th rowspan="2">AK</th>
                                                <th colspan="4">Target</th>
                                                <th rowspan="2">AK</th>
                                                <th colspan="4">Realisasi</th>
                                            </tr>
                                            <tr>
                                                <th>Kuantitas</th>
                                                <th>Kualitas</th>
                                                <th>Waktu</th>
                                                <th>Biaya</th>
                                                <th>Kuantitas</th>
                                                <th>Kualitas</th>
                                                <th>Waktu</th>
                                                <th>Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>-->
                        </section>
                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script src="<?php echo base_url(); ?>assets/js/fullcalendar/fullcalendar.min.js"></script>
    <!--script for this page only-->
    <script src="<?php echo base_url(); ?>assets/js/external-dragging-calendar.js"></script>  
    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
    <script src="<?php echo base_url() ?>assets/js2/dashboard/js_dashboard.js"></script>
    <script>
                                        var tabel_pekerjaan_saya = null;
                                        var site_url = "<?php echo site_url() ?>";
                                        var list_user = <?= json_encode($users) ?>;

    </script>
    <style>
        table thead tr th{
            vertical-align: middle;
            //text-align: center;
        }

    </style>