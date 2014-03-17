
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Task Management</title>
    <!--Core CSS -->
    <link href="<?php echo base_url()?>/assets/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets/css/clndr.css" rel="stylesheet">
    <!--clock css-->
    <link href="<?php echo base_url()?>/assets/js/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/js/morris-chart/morris.css">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url()?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url()?>/assets/css/style-responsive.css" rel="stylesheet"/>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section id="container">
<!--header start-->
<?php $this->load->view("taskman_header2_page")?>
<!--header end-->
<!--sidebar start-->
<?php $this->load->view("taskman_sidebarleft_page")?>
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
                Jumlah Pekerjaan
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon pink"><i class="fa fa-tasks"></i></span>
            <div class="mini-stat-info">
                <span>22,450</span>
                Yang Sedang Dikerjakan 
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon green"><i class="fa fa-tasks"></i></span>
            <div class="mini-stat-info">
                <span>34,320</span>
                Pekerjaan Selesai
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-tasks"></i></span>
            <div class="mini-stat-info">
                <span>32720</span>
                Belum Dikerjakan
            </div>
        </div>
    </div>
</div>
<!--mini statistics start-->
<div class="row">
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
                <div class="top-stats-panel">
                    <div class="gauge-canvas">
                        <h4 class="widget-h">Monthly Expense</h4>
                        <canvas width=160 height=100 id="gauge"></canvas>
                    </div>
                    <ul class="gauge-meta clearfix">
                        <li id="gauge-textfield" class="pull-left gauge-value"></li>
                        <li class="pull-right gauge-title">Safe</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
                <div class="top-stats-panel">
                    <div class="daily-visit">
                        <h4 class="widget-h">Daily Visitors</h4>
                        <div id="daily-visit-chart" style="width:100%; height: 100px; display: block">

                        </div>
                        <ul class="chart-meta clearfix">
                            <li class="pull-left visit-chart-value">3233</li>
                            <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 15%</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
                <div class="top-stats-panel">
                    <h4 class="widget-h">Top Advertise</h4>
                    <div class="sm-pie">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
                <div class="top-stats-panel">
                    <h4 class="widget-h">Daily Sales</h4>
                    <div class="bar-stats">
                        <ul class="progress-stat-bar clearfix">
                            <li data-percent="50%"><span class="progress-stat-percent pink"></span></li>
                            <li data-percent="90%"><span class="progress-stat-percent"></span></li>
                            <li data-percent="70%"><span class="progress-stat-percent yellow-b"></span></li>
                        </ul>
                        <ul class="bar-legend">
                            <li><span class="bar-legend-pointer pink"></span> New York</li>
                            <li><span class="bar-legend-pointer green"></span> Los Angels</li>
                            <li><span class="bar-legend-pointer yellow-b"></span> Dallas</li>
                        </ul>
                        <div class="daily-sales-info">
                            <span class="sales-count">1200 </span> <span class="sales-label">Products Sold</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!--mini statistics end-->
<div class="row">
    <div class="col-md-8">
        <section class="panel">
                    <header class="panel-heading">
                        Daftar Pekerjaan Yang Sedang Berlangsung
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

                            </tbody>
                        </table>
                    </div>
                </section>
        <!--earning graph start-->
        <section class="panel">
            <header class="panel-heading">
                Earning Graph <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down"></a>
            <a href="javascript:;" class="fa fa-cog"></a>
            <a href="javascript:;" class="fa fa-times"></a>
            </span>
            </header>
            <div class="panel-body">

                <div id="graph-area" class="main-chart">
                </div>
                <div class="region-stats">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="region-earning-stats">
                                This year total earning <span>$68,4545,454</span>
                            </div>
                            <ul class="clearfix location-earning-stats">
                                <li class="stat-divider">
                                    <span class="first-city">$734503</span>
                                    Rocky Mt,NC </li>
                                <li class="stat-divider">
                                    <span class="second-city">$734503</span>
                                    Dallas/FW,TX </li>
                                <li>
                                    <span class="third-city">$734503</span>
                                    Millville,NJ </li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <div id="world-map" class="vector-stat">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--earning graph end-->
    </div>
    <div class="col-md-4">
        <!--widget graph start-->
        <section class="panel">
            <div class="panel-body">
                <div class="monthly-stats pink">
                    <div class="clearfix">
                        <h4 class="pull-left"> Pekerjaan Bulan January 2013</h4>
                    </div>
                </div>
                <div class="circle-sat">
                    <div class="sm-pie">
                    </div>
                </div>
            </div>
        </section>
        <!--widget graph end-->
        <!--widget graph start-->
        <section class="panel">
            <div class="panel-body">
                <ul class="clearfix prospective-spark-bar">
                    <li class="pull-left spark-bar-label">
                        <span class="bar-label-value"> $18887</span>
                        <span>Prospective Label</span>
                    </li>
                    <li class="pull-right">
                        <div class="sparkline" data-type="bar" data-resize="true" data-height="40" data-width="90%" data-bar-color="#f6b0ae" data-bar-width="5" data-data="[300,200,500,700,654,987,457,300,876,454,788,300,200,500,700,654,987,457,300,876,454,788]"></div>
                    </li>
                </ul>
            </div>
        </section>
        <!--widget graph end-->
        <!--widget weather start-->
        <section class="weather-widget clearfix">
            <div class="pull-left weather-icon">
                <canvas id="icon1" width="60" height="60"></canvas>
            </div>
            <div>
                <ul class="weather-info">
                    <li class="weather-city">New York <i class="ico-location"></i></li>
                    <li class="weather-cent"><span>18</span></li>
                    <li class="weather-status">Rainy Day</li>
                </ul>
            </div>
        </section>
        <!--widget weather end-->
    </div>
</div>
<!--mini statistics start-->

<!--mini statistics end-->


<div class="row">
    <div class="col-md-8">
        <div class="event-calendar clearfix">
            <div class="col-lg-7 calendar-block">
                <div class="cal1 ">
                </div>
            </div>
            <div class="col-lg-5 event-list-block">
                <div class="cal-day">
                    <span>Today</span>
                    Friday
                </div>
                <ul class="event-list">
                    <li>Lunch with jhon @ 3:30 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>
                    <li>Coffee meeting with Lisa @ 4:30 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>
                    <li>Skypee conf with patrick @ 5:45 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>
                    <li>Gym @ 7:00 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>
                    <li>Dinner with daniel @ 9:30 <a href="#" class="event-close"><i class="ico-close2"></i></a></li>

                </ul>
                <input type="text" class="form-control evnt-input" placeholder="NOTES">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <!--chat start-->
        <section class="panel">
            <header class="panel-heading">
                Chat <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down"></a>
            <a href="javascript:;" class="fa fa-cog"></a>
            <a href="javascript:;" class="fa fa-times"></a>
            </span>
            </header>
            <div class="panel-body">
                <div class="chat-conversation">
                    <ul class="conversation-list">
                        <li class="clearfix">
                            <div class="chat-avatar">
                                <img src="images/chat-user-thumb.png" alt="male">
                                <i>10:00</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>John Carry</i>
                                    <p>
                                        Hello!
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="clearfix odd">
                            <div class="chat-avatar">
                                <img src="images/chat-user-thumb-f.png" alt="female">
                                <i>10:00</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>Lisa Peterson</i>
                                    <p>
                                        Hi, How are you? What about our next meeting?
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="clearfix">
                            <div class="chat-avatar">
                                <img src="images/chat-user-thumb.png" alt="male">
                                <i>10:00</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>John Carry</i>
                                    <p>
                                        Yeah everything is fine
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="clearfix odd">
                            <div class="chat-avatar">
                                <img src="images/chat-user-thumb-f.png" alt="female">
                                <i>10:00</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>Lisa Peterson</i>
                                    <p>
                                        Wow that's great
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-xs-9">
                            <input type="text" class="form-control chat-input" placeholder="Enter your text">
                        </div>
                        <div class="col-xs-3 chat-send">
                            <button type="submit" class="btn btn-default">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--chat end-->
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <section class="panel">
            <div class="wdgt-row">
                <img src="images/weather_image.jpg" height="243" alt="">
                <div class="wdt-head">
                    weather forecast
                </div>
                <div class="country-select">
                    <select class="styled">
                        <option>New York </option>
                        <option>London </option>
                        <option>Australia </option>
                        <option>China </option>
                        <option>Canada </option>
                    </select>
                </div>
            </div>

            <div class="panel-body">
                <div class="row weather-full-info">
                    <div class="col-md-3 today-status">
                        <h1>Today</h1>
                        <i class=" ico-cloudy "></i>
                        <div class="degree">37</div>
                    </div>
                    <div class="col-md-9">
                        <ul>
                            <li>
                                <h2>Tomorrow</h2>
                                <i class=" ico-cloudy text-primary"></i>
                                <div class="statistics">32</div>
                            </li>
                            <li>
                                <h2>Mon</h2>
                                <i class=" ico-rainy2 text-danger"></i>
                                <div class="statistics">40</div>
                            </li>
                            <li>
                                <h2>Tue</h2>
                                <i class=" ico-lightning3 text-info"></i>
                                <div class="statistics">25</div>
                            </li>
                            <li>
                                <h2>Wed</h2>
                                <i class=" ico-sun3 text-success"></i>
                                <div class="statistics">37</div>
                            </li>
                            <li>
                                <h2>Thu</h2>
                                <i class=" ico-snowy3 text-warning"></i>
                                <div class="statistics">15</div>
                            </li>
                            <li>
                                <h2>Fri</h2>
                                <i class=" ico-cloudy "></i>
                                <div class="statistics">21</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <div class="col-md-4">
        <div class="profile-nav alt">
            <section class="panel">
                <div class="user-heading alt clock-row terques-bg">
                    <h1>December 14</h1>
                    <p class="text-left">2014, Friday</p>
                    <p class="text-left">7:53 PM</p>
                </div>
                <ul id="clock">
                    <li id="sec"></li>
                    <li id="hour"></li>
                    <li id="min"></li>
                </ul>

                <ul class="clock-category">
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
                </ul>

            </section>

        </div>
    </div>
</div>
<div class="row">
<div class="col-md-6">
    <!--notification start-->
    <section class="panel">
        <header class="panel-heading">
            Notification <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down"></a>
            <a href="javascript:;" class="fa fa-cog"></a>
            <a href="javascript:;" class="fa fa-times"></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="alert alert-info clearfix">
                <span class="alert-icon"><i class="fa fa-envelope-o"></i></span>
                <div class="notification-info">
                    <ul class="clearfix notification-meta">
                        <li class="pull-left notification-sender"><span><a href="#">Jonathan Smith</a></span> send you a mail </li>
                        <li class="pull-right notification-time">1 min ago</li>
                    </ul>
                    <p>
                        Urgent meeting for next proposal
                    </p>
                </div>
            </div>
            <div class="alert alert-danger">
                <span class="alert-icon"><i class="fa fa-facebook"></i></span>
                <div class="notification-info">
                    <ul class="clearfix notification-meta">
                        <li class="pull-left notification-sender"><span><a href="#">Jonathan Smith</a></span> mentioned you in a post </li>
                        <li class="pull-right notification-time">7 Hours Ago</li>
                    </ul>
                    <p>
                        Very cool photo jack
                    </p>
                </div>
            </div>
            <div class="alert alert-success ">
                <span class="alert-icon"><i class="fa fa-comments-o"></i></span>
                <div class="notification-info">
                    <ul class="clearfix notification-meta">
                        <li class="pull-left notification-sender">You have 5 message unread</li>
                        <li class="pull-right notification-time">1 min ago</li>
                    </ul>
                    <p>
                        <a href="#">Anjelina Mewlo, Jack Flip</a> and <a href="#">3 others</a>
                    </p>
                </div>
            </div>
            <div class="alert alert-warning ">
                <span class="alert-icon"><i class="fa fa-bell-o"></i></span>
                <div class="notification-info">
                    <ul class="clearfix notification-meta">
                        <li class="pull-left notification-sender">Domain Renew Deadline 7 days ahead</li>
                        <li class="pull-right notification-time">5 Days Ago</li>
                    </ul>
                    <p>
                        Next 5 July Thursday is the last day
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--notification end-->
</div>
<div class="col-md-6">
    <!--todolist start-->
    <section class="panel">
        <header class="panel-heading">
            To Do List <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down"></a>
            <a href="javascript:;" class="fa fa-cog"></a>
            <a href="javascript:;" class="fa fa-times"></a>
            </span>
        </header>
        <div class="panel-body">
            <ul class="to-do-list" id="sortable-todo">
                <li class="clearfix">
                    <span class="drag-marker">
                    <i></i>
                    </span>
                    <div class="todo-check pull-left">
                        <input type="checkbox" value="None" id="todo-check"/>
                        <label for="todo-check"></label>
                    </div>
                    <p class="todo-title">
                        Donec quam libero, rutrum non gravida ut
                    </p>
                    <div class="todo-actionlist pull-right clearfix">
                        <a href="#" class="todo-done"><i class="fa fa-check"></i></a>
                        <a href="#" class="todo-edit"><i class="ico-pencil"></i></a>
                        <a href="#" class="todo-remove"><i class="ico-close"></i></a>
                    </div>
                </li>
                <li class="clearfix">
                    <span class="drag-marker">
                    <i></i>
                    </span>
                    <div class="todo-check pull-left">
                        <input type="checkbox" value="None" id="todo-check1"/>
                        <label for="todo-check1"></label>
                    </div>
                    <p class="todo-title">
                        Donec quam libero, rutrum non gravida
                    </p>
                    <div class="todo-actionlist pull-right clearfix">
                        <a href="#" class="todo-done"><i class="fa fa-check"></i></a>
                        <a href="#" class="todo-edit"><i class="ico-pencil"></i></a>
                        <a href="#" class="todo-remove"><i class="ico-close"></i></a>
                    </div>
                </li>
                <li class="clearfix">
                    <span class="drag-marker">
                    <i></i>
                    </span>
                    <div class="todo-check pull-left">
                        <input type="checkbox" value="None" id="todo-check2"/>
                        <label for="todo-check2"></label>
                    </div>
                    <p class="todo-title">
                        Donec quam libero, rutrum non gravida ut
                    </p>
                    <div class="todo-actionlist pull-right clearfix">
                        <a href="#" class="todo-done"><i class="fa fa-check"></i></a>
                        <a href="#" class="todo-edit"><i class="ico-pencil"></i></a>
                        <a href="#" class="todo-remove"><i class="ico-close"></i></a>
                    </div>
                </li>
                <li class="clearfix">
                    <span class="drag-marker">
                    <i></i>
                    </span>
                    <div class="todo-check pull-left">
                        <input type="checkbox" value="None" id="todo-check3"/>
                        <label for="todo-check3"></label>
                    </div>
                    <p class="todo-title">
                        Donec quam libero, rutrum non gravida ut
                    </p>
                    <div class="todo-actionlist pull-right clearfix">
                        <a href="#" class="todo-done"><i class="fa fa-check"></i></a>
                        <a href="#" class="todo-edit"><i class="ico-pencil"></i></a>
                        <a href="#" class="todo-remove"><i class="ico-close"></i></a>
                    </div>
                </li>
                <li class="clearfix">
                    <span class="drag-marker">
                    <i></i>
                    </span>
                    <div class="todo-check pull-left">
                        <input type="checkbox" value="None" id="todo-check4" />
                        <label for="todo-check4"></label>
                    </div>
                    <p class="todo-title">
                        Donec quam libero, rutrum non gravida ut
                    </p>
                    <div class="todo-actionlist pull-right clearfix">
                        <a href="#" class="todo-done"><i class="fa fa-check"></i></a>
                        <a href="#" class="todo-edit"><i class="ico-pencil"></i></a>
                        <a href="#" class="todo-remove"><i class="ico-close"></i></a>
                    </div>
                </li>
                <li class="clearfix">
                    <span class="drag-marker">
                    <i></i>
                    </span>
                    <div class="todo-check pull-left">
                        <input type="checkbox" value="None" id="todo-check5"/>
                        <label for="todo-check5"></label>
                    </div>
                    <p class="todo-title">
                        Donec quam libero, rutrum non gravida ut
                    </p>
                    <div class="todo-actionlist pull-right clearfix">
                        <a href="#" class="todo-done"><i class="fa fa-check"></i></a>
                        <a href="#" class="todo-edit"><i class="ico-pencil"></i></a>
                        <a href="#" class="todo-remove"><i class="ico-close"></i></a>
                    </div>
                </li>
                <li class="clearfix">
                    <span class="drag-marker">
                    <i></i>
                    </span>
                    <div class="todo-check pull-left">
                        <input type="checkbox" value="None" id="todo-check6" />
                        <label for="todo-check6"></label>
                    </div>
                    <p class="todo-title">
                        Donec quam libero, rutrum non gravida ut
                    </p>
                    <div class="todo-actionlist pull-right clearfix">
                        <a href="#" class="todo-done"><i class="fa fa-check"></i></a>
                        <a href="#" class="todo-edit"><i class="ico-pencil"></i></a>
                        <a href="#" class="todo-remove"><i class="ico-close"></i></a>
                    </div>
                </li>
            </ul>
            <div class="todo-action-bar">
                <div class="row">
                    <div class="col-xs-4 btn-todo-select">
                        <button type="submit" class="btn btn-default"><i class="fa fa-check"></i> Select All</button>
                    </div>
                    <div class="col-xs-4 todo-search-wrap">
                        <input type="text" class="form-control search todo-search pull-right" placeholder=" Search">
                    </div>
                    <div class="col-xs-4 btn-add-task">
                        <button type="submit" class="btn btn-default btn-primary"><i class="fa fa-plus"></i> Add Task</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--todolist end-->
</div>
</div>
</section>
</section>
<!--main content end-->
<!--right sidebar start-->
<div class="right-sidebar">
<div class="search-row">
    <input type="text" placeholder="Search" class="form-control">
</div>
<div class="right-stat-bar">
<ul class="right-side-accordion">
<li class="widget-collapsible">
    <a href="#" class="head widget-head red-bg active clearfix">
        <span class="pull-left">work progress (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row side-mini-stat clearfix">
                <div class="side-graph-info">
                    <h4>Target sell</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="target-sell">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>product delivery</h4>
                    <p>
                        55%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-delivery">
                        <div class="sparkline" data-type="bar" data-resize="true" data-height="30" data-width="90%" data-bar-color="#39b7ab" data-bar-width="5" data-data="[200,135,667,333,526,996,564,123,890,564,455]">
                        </div>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info payment-info">
                    <h4>payment collection</h4>
                    <p>
                        25%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="p-collection">
						<span class="pc-epie-chart" data-percent="45">
						<span class="percent"></span>
						</span>
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="side-graph-info">
                    <h4>delivery pending</h4>
                    <p>
                        44%, Deadline 12 june 13
                    </p>
                </div>
                <div class="side-mini-graph">
                    <div class="d-pending">
                    </div>
                </div>
            </div>
            <div class="prog-row side-mini-stat">
                <div class="col-md-12">
                    <h4>total progress</h4>
                    <p>
                        50%, Deadline 12 june 13
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                            <span class="sr-only">50% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head terques-bg active clearfix">
        <span class="pull-left">contact online (5)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Jonathan Smith</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Anjelina Joe</a></h4>
                    <p>
                        Available
                    </p>
                </div>
                <div class="user-status text-success">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/chat-avatar2.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">John Doe</a></h4>
                    <p>
                        Away from Desk
                    </p>
                </div>
                <div class="user-status text-warning">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="images/avatar1_small.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Mark Henry</a></h4>
                    <p>
                        working
                    </p>
                </div>
                <div class="user-status text-info">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb">
                    <a href="#"><img src="<?php echo base_url()?>/assets/images/avatar1.jpg" alt=""></a>
                </div>
                <div class="user-details">
                    <h4><a href="#">Shila Jones</a></h4>
                    <p>
                        Work for fun
                    </p>
                </div>
                <div class="user-status text-danger">
                    <i class="fa fa-comments-o"></i>
                </div>
            </div>
            <p class="text-center">
                <a href="#" class="view-btn">View all Contacts</a>
            </p>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head purple-bg active">
        <span class="pull-left"> recent activity (3)</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        just now
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        2 min ago
                    </p>
                    <p>
                        <a href="#">Jane Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
            <div class="prog-row">
                <div class="user-thumb rsn-activity">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="rsn-details ">
                    <p class="text-muted">
                        1 day ago
                    </p>
                    <p>
                        <a href="#">Jim Doe </a>Purchased new equipments for zonal office setup
                    </p>
                </div>
            </div>
        </li>
    </ul>
</li>
<li class="widget-collapsible">
    <a href="#" class="head widget-head yellow-bg active">
        <span class="pull-left"> shipment status</span>
        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
    </a>
    <ul class="widget-container">
        <li>
            <div class="col-md-12">
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="prog-row">
                    <p>
                        Full sleeve baby wear (SL: 17665)
                    </p>
                    <div class="progress progress-xs mtop10">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                            <span class="sr-only">70% Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
</ul>

</div>

</div>
<!--right sidebar end-->
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src="<?php echo base_url()?>/assets/js/jquery.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="<?php echo base_url()?>/assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php echo base_url()?>/assets/js/skycons/skycons.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.scrollTo/jquery.scrollTo.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/calendar/clndr.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="<?php echo base_url()?>/assets/js/calendar/moment-2.2.1.js"></script>
<script src="<?php echo base_url()?>/assets/js/evnt.calendar.init.js"></script>
<script src="<?php echo base_url()?>/assets/js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="<?php echo base_url()?>/assets/js/gauge/gauge.js"></script>
<!--clock init-->
<script src="<?php echo base_url()?>/assets/js/css3clock/js/css3clock.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo base_url()?>/assets/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo base_url()?>/assets/js/sparkline/jquery.sparkline.js"></script>
<!--Morris Chart-->
<script src="<?php echo base_url()?>/assets/js/morris-chart/morris.js"></script>
<script src="<?php echo base_url()?>/assets/js/morris-chart/raphael-min.js"></script>
<!--jQuery Flot Chart-->
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.animator.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.growraf.js"></script>
<script src="<?php echo base_url()?>/assets/js/dashboard.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.customSelect.min.js" ></script>
<!--common script init for all pages-->
<script src="<?php echo base_url()?>/assets/js/scripts.js"></script>
<!--script for this page-->
</body>
</html>