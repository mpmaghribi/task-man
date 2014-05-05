<?php $this->load->view("taskman_header_page") ?> 
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
                                    <span>1</span>
                                    All Tasks
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon pink"><i class="fa fa-tasks"></i></span>
                                <div class="mini-stat-info">
                                    <span>0</span>
                                    On-Going Tasks
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon green"><i class="fa fa-tasks"></i></span>
                                <div class="mini-stat-info">
                                    <span>0</span>
                                    Finished Tasks
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon orange"><i class="fa fa-tasks"></i></span>
                                <div class="mini-stat-info">
                                    <span>1</span>
                                    Not Working Yet
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--mini statistics start-->
                    <!--mini statistics end-->
                    <div class="row">
                        <div class="col-md-8">
                            <section class="panel">
                                <header class="panel-heading">
                                    List of tasks
                                </header>
                                <div class="panel-body">
                                    <table class="table  table-hover general-table">
                                                    <thead>
                                                        <tr>
                                                            <th> No</th>
                                                            <th class="hidden-phone">Pekerjaan</th>
                                                            <th>Deadline</th>
                                                            <th>Assign To</th>
                                                            <th>Status</th>
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
                                                                    <td><?php echo $data_akun['user_nama'] ?></td>
                                                                    <td><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
<!--                                                                    <td>
                                                                        <div class="progress progress-striped progress-xs">
                                                                            <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
                                                                                <span class="sr-only">0% Complete (success)</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>-->
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
                            </section>
                            <!--earning graph start-->

                            <!--earning graph end-->
                        </div>
                        <div class="col-md-4">
                            <!--widget graph start-->
<!--                            <section class="panel">
                                <div class="panel-body">
                                    <div class="monthly-stats pink">
                                        <div class="clearfix">
                                            <h4 class="pull-left"> Tasks <?php echo date("F Y"); ?></h4>
                                        </div>
                                    </div>
                                    <div class="circle-sat">
                                        <div class="sm-pie">
                                        </div>
                                    </div>
                                </div>
                            </section>-->
                            <div class="profile-nav alt">
                                <section class="panel">
                                    <div class="user-heading alt clock-row terques-bg">
                                        <h4><?php echo date("Y F l d"); ?></h4>
                                        <p class="text-left">Week <?php echo date("W"); ?></p>
                                    </div>
                                    <ul id="clock">
                                        <li id="sec"></li>
                                        <li id="hour"></li>
                                        <li id="min"></li>
                                    </ul>

                                    <!--                <ul class="clock-category">
                                                        <li>
                                                            <a href="#" class="active">
                                                                <i class="ico-clock2"></i>
                                                                <span>Clock</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="ico-alarm2 "></i>
                                                                <span>Alarm</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="ico-stopwatch"></i>
                                                                <span>Stop watch</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class=" ico-clock2 "></i>
                                                                <span>Timer</span>
                                                            </a>
                                                        </li>
                                                    </ul>-->

                                </section>

                            </div>
                        </div>
                    </div>
                </section>
            </section>
            <!--main content end-->
            <!--right sidebar start-->
            <?php $this->load->view('taskman_rightbar_page')?>
            <!--right sidebar end-->
        </section>
            <?php $this->load->view("taskman_footer_page") ?>