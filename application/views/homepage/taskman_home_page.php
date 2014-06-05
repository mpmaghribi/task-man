<?php $this->load->view("taskman_header_page") ?> 
<script>
    var status_nama = ["Not Approved", "Belum Dibaca", "Sudah Dibaca", "Selesai", "Dikerjakan", "Terlambat"];
    var status_label = ["danger", "primary", "info", "success", "inverse", "default"];
    console.log(status_nama);
    console.log(status_label);
    function ubah_status_pekerjaan(id, flag, sekarang, tgl_selesai, tgl_read, status_, progress) {
        console.log('update status  ' + id + ' ' + flag + ' ' + sekarang + ' ' + tgl_selesai + ' ' + tgl_read + ' ' + status_ + ' ' + progress);
        var status_id = 0;
        if (flag == 1) {

        } else if (flag == 2) {
            if (sekarang <= tgl_selesai) {
                if (tgl_read == null || tgl_read.length==0) {
                    status_id = 1;
                }
                else {
                    if (progress == 0) {
                        status_id = 2;
                    } else if (progress == 100) {
                        status_id = 3;
                    } else {
                        status_id = 4;
                    }
                }
            } else {
                status_id = 5;
            }
        }
        var new_label = '<span class="label label-' + status_label[status_id] + ' label-mini">' + status_nama[status_id] + '</span>';
        //console.log(new_label);
        $('#' + id).html(new_label);
    }
</script>
<body>
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
                <!--mini statistics start-->
                <!--mini statistics end-->
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#PekerjaanSaya">Pekerjaan Saya</a>
                                    </li>
                                    <?php if (count($my_staff) > 0) { ?>
                                        <li class="">
                                            <a data-toggle="tab" href="#PekerjaanStaff">Pekerjaan Staff</a>
                                        </li>
                                        <li class="">
                                            <a data-toggle="tab" href="#div_view_draft">Draft Pekerjaan</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </header>
                            <div class="panel-body">

                                <div class="tab-content">
                                    <div id="PekerjaanSaya" class="tab-pane active">


                                        <div class="form">
                                            <table class="table table-striped table-hover table-condensed" id="tabel_home">
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
                                                            <tr>
                                                                <td>
                                                                    <a href="#">
                                                                        <?php echo $i; ?>
                                                                    </a>
                                                                </td>
                                                                <td class="hidden-phone"><?php echo $value->nama_pekerjaan ?></td>
                                                                <td> <?php echo date("d M Y", strtotime($value->tgl_mulai)) ?> - <?php echo date("d M Y", strtotime($value->tgl_selesai)) ?></td>
                                                                <td id="assign_to_<?php //echo $value->id_pekerjaan;          ?>"><?php foreach ($users as $value2) { ?>
                                                                        <?php if ($value->id_akun == $value2->id_akun) { ?><?php echo $value2->nama ?><?php } ?>
                                                                    <?php } ?></td>
                                                                <td id="pekerjaan_saya_status_<?php echo $value->id_pekerjaan; ?>"><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
                                                                <td>
                                                                    <form method="get" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                        <input type="hidden" name="id_detail_pkj" value="<?php echo $value->id_pekerjaan ?>"/>
                                                                        <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </button>
                                                                    </form>
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
                                    <?php $this->load->view('pekerjaan/karyawan/pekerjaan_staff_view'); ?>
                                    <?php $this->load->view('pekerjaan/draft/draft_view'); ?>
                                </div>
                            </div>
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
    <script>
        var detil_pekerjaan_saya = jQuery.parseJSON('<?php if (isset($detil_pekerjaan_saya)) echo json_encode($detil_pekerjaan_saya); ?>');
        var tgl_selesai_pekerjaan_saya = [];
        var flag_usulan_pekerjaan_saya = [];
<?php
foreach ($pkj_karyawan as $pekerjaan_saya) {
    ?>tgl_selesai_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->tgl_selesai; ?>';
            flag_usulan_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->flag_usulan; ?>';<?php
}
?>
        console.log(tgl_selesai_pekerjaan_saya);
        console.log(flag_usulan_pekerjaan_saya);
        document.title = "DashBoard - Task Management";

        var jumlah_detil_saya = detil_pekerjaan_saya.length;
        for (var i = 0; i < jumlah_detil_saya; i++) {
            var detil = detil_pekerjaan_saya[i];
            ubah_status_pekerjaan('pekerjaan_saya_status_' + detil['id_pekerjaan'], flag_usulan_pekerjaan_saya[detil['id_pekerjaan']], detil['sekarang'], tgl_selesai_pekerjaan_saya[detil['id_pekerjaan']], detil['tgl_read'], detil['status'], detil['progress']);
        }
    </script>
    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

    <!-- END JAVASCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            EditableTableProgress.init();
        });
    </script>