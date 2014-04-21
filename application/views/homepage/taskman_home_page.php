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
                                    <span>320</span>
                                    All Tasks
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon pink"><i class="fa fa-tasks"></i></span>
                                <div class="mini-stat-info">
                                    <span>22,450</span>
                                    On-Going Tasks
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon green"><i class="fa fa-tasks"></i></span>
                                <div class="mini-stat-info">
                                    <span>34,320</span>
                                    Finished Tasks
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon orange"><i class="fa fa-tasks"></i></span>
                                <div class="mini-stat-info">
                                    <span>32720</span>
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
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="#">1</a></td>
                                                <td class="hidden-phone">Melakukan rekap daftar pasien yang pindah kamar.</td>
                                                <td>1320.00$ </td>
                                                <td>Mohammad Oktri Raditya </td>
                                                <td><span class="label label-info label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        2
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Mendata pasien yang telah meninggal dunia</td>
                                                <td> 5 mei 2014</td>
                                                <td>Andre Rizqon Maulana </td>
                                                <td><span class="label label-warning label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 70%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">70% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        3
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Mendata pasien yang mengikuti program askes</td>
                                                <td>4 Juni 2014 </td>
                                                <td> Misbachul Huda </td>
                                                <td><span class="label label-success label-mini">Paid</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 55%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
                                                            <span class="sr-only">55% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        4
                                                    </a>
                                                </td>
                                                <td class="hidden-phone"> Mendata pasien yang berada dikamar VIP</td>
                                                <td> 4 April 2014 </td>
                                                <td> Muhammad Najib </td>
                                                <td><span class="label label-danger label-mini">Paid</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-info">
                                                            <span class="sr-only">90% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">5</a></td>
                                                <td class="hidden-phone">Mendata pasien yang tidak mampu</td>
                                                <td> 31 Maret 2014 </td>
                                                <td> Sindung Anggar Kusuma</td>
                                                <td><span class="label label-primary label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
                                                            <span class="sr-only">60% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        6
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Melakukan rekap pendaftaran pasien</td>
                                                <td> 24 April 2014 </td>
                                                <td>Mohammad Zarkasi</td>
                                                <td><span class="label label-warning label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        7
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Tugas 3</td>
                                                <td> 24 April 2014 </td>
                                                <td>Mohammad Zarkasi</td>
                                                <td><span class="label label-warning label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        8
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Tugas 4</td>
                                                <td> 24 April 2014 </td>
                                                <td>Mohammad Zarkasi</td>
                                                <td><span class="label label-warning label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        9
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Tugas 3</td>
                                                <td> 24 April 2014 </td>
                                                <td>Mohammad Zarkasi</td>
                                                <td><span class="label label-warning label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        10
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Tugas 2</td>
                                                <td> 24 April 2014 </td>
                                                <td>Mohammad Zarkasi</td>
                                                <td><span class="label label-warning label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#">
                                                        11
                                                    </a>
                                                </td>
                                                <td class="hidden-phone">Tugas 1</td>
                                                <td> 24 April 2015 </td>
                                                <td>Mohammad Zarkasi</td>
                                                <td><span class="label label-warning label-mini">Due</span></td>
                                                <td>
                                                    <div class="progress progress-striped progress-xs">
                                                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">40% Complete (success)</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <!--earning graph start-->

                            <!--earning graph end-->
                        </div>
                        <div class="col-md-4">
                            <!--widget graph start-->
                            <section class="panel">
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
                            </section>
                            <div class="profile-nav alt">
                                <section class="panel">
                                    <div class="user-heading alt clock-row terques-bg">
                                        <h1><?php echo date("F"); ?></h1>
                                        <p class="text-left"><?php echo date("Y l"); ?></p>
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
                            <section class="panel">
                                <header class="panel-heading">
                                    Recent Activity <span class="tools pull-right">

                                    </span>
                                </header>
                                <div class="panel-body">
                                    <div class="alert alert-info clearfix">
                                        <span class="alert-icon"><i class="fa fa-tasks"></i></span>
                                        <div class="notification-info">
                                            <ul class="clearfix notification-meta">
                                                <li class="pull-left notification-sender"><span><a href="#">Mohammad Oktri Raditya</a></span> Finished his task </li>
                                                <li class="pull-right notification-time">1 min ago</li>
                                            </ul>
                                            <p>
                                                Task 1 has been completed.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="alert alert-danger">
                                        <span class="alert-icon"><i class="fa fa-key"></i></span>
                                        <div class="notification-info">
                                            <ul class="clearfix notification-meta">
                                                <li class="pull-left notification-sender"><span><a href="#">Mohammad Zarkasi</a></span> just login into system </li>
                                                <li class="pull-right notification-time">7 Hours Ago</li>
                                            </ul>
                                            <p>
                                                login into system
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </section>
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