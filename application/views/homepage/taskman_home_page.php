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
                                    Pekerjaan Saya Bulan Ini
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
                    if (in_array(1, $data_akun['idmodul'])) {
                        ?>
                        <div class="col-md-12" id="PekerjaanSaya" >
                            <section class="panel">
                                <header class="panel-heading  ">
                                    Pekerjaan Saya
                                </header>
                                <div class="panel-body">
                                    <div class="form">
                                        <table class="table table-striped table-hover table-condensed" id="tabel_home">
                                            <thead>
                                                <tr>
                                                    <th> No</th>
                                                    <th class="hidden-phone">Pekerjaan</th>
                                                    <th>Deadline</th>
                                                    <th>Assign To</th>
                                                    <th style="min-width: 150px">Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($pkj_karyawan)) { ?>
                                                    <?php
                                                    $i = 1;
                                                    $list_id_pekerjaan = array();
                                                    $list_status = array(1 => 'Not Approved', 2 => 'Approved', 9 => 'Perpanjang', 't' => 'Terlambat');
                                                    $label_status = array(1 => 'label-danger', 2 => 'label-success', 9 => "label-inverse", 't' => 'label-info');
                                                    foreach ($pkj_karyawan as $value) {
                                                        if (in_array($value->id_pekerjaan, $list_id_pekerjaan))
                                                            continue;
                                                        $list_id_pekerjaan[] = $value->id_pekerjaan;
                                                        ?>
                                                        <tr>
                                                            <td style="vertical-align: middle">
                                                                <a href="#">
                                                                    <?php echo $i; ?>
                                                                </a>
                                                            </td>
                                                            <td style="vertical-align: middle" class="hidden-phone"><?php echo $value->nama_pekerjaan ?></td>
                                                            <td style="vertical-align: middle"> <?php echo $value->tanggal_mulai ?> - <?php echo $value->tanggal_selesai ?></td>
                                                            <td style="vertical-align: middle" id="assign_to_<?php //echo $value->id_pekerjaan;                                ?>"><?php foreach ($users as $value2) { ?>
                                                                    <?php if ($value->id_akun == $value2->id_akun) { ?><?php echo $value2->nama ?><?php } ?>
                                                                <?php } ?></td>
                                                            <td style="vertical-align: middle" id="pekerjaan_saya_status_<?php echo $value->id_pekerjaan; ?>"><span class="label <?= $label_status[$value->flag_usulan] ?> label-mini"><?= $list_status[$value->flag_usulan] ?></span></td>
                                                            <td style="vertical-align: middle">

                                                                <a href="<?php echo base_url(); ?>pekerjaan/deskripsi_pekerjaan?id_detail_pkj=<?php echo $value->id_pekerjaan ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View</a>

                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                <?php } ?>
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
                        <?php
                    }
                    if (in_array(5, $data_akun['idmodul'])) {
                        $this->load->view('pekerjaan/karyawan/pekerjaan_staff_view');
                    }
                    if (in_array(3, $data_akun['idmodul'])) {
                        $this->load->view('pekerjaan/draft/draft_view');
                    }
                    ?>


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
    <script>
        var detil_pekerjaan_saya = jQuery.parseJSON('<?php if (isset($detil_pekerjaan_saya)) echo json_encode($detil_pekerjaan_saya); ?>');
        var tgl_selesai_pekerjaan_saya = [];
        var tgl_mulai_pekerjaan_saya = [];
        var flag_usulan_pekerjaan_saya = [];
<?php foreach ($pkj_karyawan as $pekerjaan_saya) { ?>
            tgl_selesai_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->tgl_selesai; ?>';
            flag_usulan_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->flag_usulan; ?>';
            tgl_mulai_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->tgl_mulai; ?>';<?php }
?>

        document.title = "DashBoard - Task Management";
        var jumlah_detil_saya = 0

        if (detil_pekerjaan_saya != null)
            jumlah_detil_saya = detil_pekerjaan_saya.length;

        for (var i = 0; i < jumlah_detil_saya; i++) {
            var detil = detil_pekerjaan_saya[i];
            if (detil['id_akun'] == '<?php echo $data_akun['id_akun']; ?>') {
                ubah_status_pekerjaan('pekerjaan_saya_status_' + detil['id_pekerjaan'], flag_usulan_pekerjaan_saya[detil['id_pekerjaan']], detil['sekarang'], tgl_mulai_pekerjaan_saya[detil['id_pekerjaan']], tgl_selesai_pekerjaan_saya[detil['id_pekerjaan']], detil['tgl_read'], detil['status'], detil['progress']);
            }
        }
    </script>

    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

    <script>
        var tabel_pekerjaan_saya = null;
        var site_url = "<?php echo site_url() ?>";
        jQuery(document).ready(function () {
            $('#tabel_home').dataTable({});
            if (tabel_pekerjaan_saya != null) {
                tabel_pekerjaan_saya.fnDestroy();
                console.log('tabel pekerjaan saya is destroyed');
            }
            tabel_pekerjaan_saya = $('#tabel_pekerjaan_saya').dataTable({
                bServerSide: true,
                sServerMethod: 'post',
                sAjaxSource: site_url + 'pekerjaan/get_pekerjaan_saya_datatable',
                bProcessing: true,
                fnCreatedRow: function (row, data, index) {
                    console.log(row);
                    console.log(data);
                    console.log(index);
                },
                fnServerParams: function (aoData) {
                    aoData.push({"name": "more_data", "value": "my_value"});
                }
            });
        });
    </script>
    <style>
        table thead tr th{
            vertical-align: middle;
            //text-align: center;
        }
    </style>