
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="images/favicon.png">

        <title>Daftar Akun Baru</title>

        <!--Core CSS -->
        <link href="<?php echo base_url() ?>assets/bs3/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/style-responsive.css" rel="stylesheet" />

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
                                <div class="panel-body profile-information">
                                    <div class="col-lg-6">
                                        <h1>Daftar Akun Baru</h1>
                                        <div class="panel-body">
                                            <form>
                                                <table class="table general-table">
                                                    <tr>
                                                        <td>NIP</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kelamin</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tempat Tanggal Lahir</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Agama</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Telepon</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>HP</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Departemen</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jabatan</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="form-control" type="text"/></td>
                                                    </tr>
                                                </table>
                                                <input type="submit" class="btn btn-lg btn-login btn-block" value="Submit"/>
                                            </form>
                                        </div>
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
                                            <a href="#"><img src="images/avatar1.jpg" alt=""></a>
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
        <script src="<?php echo base_url() ?>/assets/js/jquery.js"></script>
        <script src="<?php echo base_url() ?>/assets/bs3/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="<?php echo base_url() ?>/assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url() ?>/assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url() ?>/assets/js/jquery.nicescroll.js"></script>
        <!--Easy Pie Chart-->
        <script src="<?php echo base_url() ?>/assets/js/easypiechart/jquery.easypiechart.js"></script>
        <!--Sparkline Chart-->
        <script src="<?php echo base_url() ?>/assets/js/sparkline/jquery.sparkline.js"></script>
        <!--jQuery Flot Chart-->
        <script src="<?php echo base_url() ?>/assets/js/flot-chart/jquery.flot.js"></script>
        <script src="<?php echo base_url() ?>/assets/js/flot-chart/jquery.flot.tooltip.min.js"></script>
        <script src="<?php echo base_url() ?>/assets/js/flot-chart/jquery.flot.resize.js"></script>
        <script src="<?php echo base_url() ?>/assets/js/flot-chart/jquery.flot.pie.resize.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&AMP;sensor=false"></script>

        <!--common script init for all pages-->
        <script src="<?php echo base_url() ?>/assets/js/scripts.js"></script>
        <script>

            //google map
            function initialize() {
                var myLatlng = new google.maps.LatLng(-37.815207, 144.963937);
                var mapOptions = {
                    zoom: 15,
                    scrollwheel: false,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: 'Hello World!'
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);

            $('.contact-map').click(function() {

                //google map in tab click initialize
                function initialize() {
                    var myLatlng = new google.maps.LatLng(-37.815207, 144.963937);
                    var mapOptions = {
                        zoom: 15,
                        scrollwheel: false,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }
                    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: 'Hello World!'
                    });
                }
                google.maps.event.addDomListener(window, 'click', initialize);
            });
        </script>
    </body>
</html>
