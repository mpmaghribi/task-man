
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="images/favicon.png">

        <title>Tambah Pekerjaan</title>

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
                                        <div class="panel-body">
                                            <form action="<?php echo site_url() ?>pekerjaan/tambah_pekerjaan_db">
                                                <table class="table general-table">
                                                    <tr>
                                                        <td>Nama Pekerjaan</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input name="nama_pkj" class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Deskripsi Pekerjaan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
<!--                                                            <input class="form-control" type="text"/>-->
                                                            <textarea name="deskripsi_pkj" class="form-control"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Deadline</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input name="tgl_selesai_pkj" class="form-control" type="text"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Penerima Pekerjaan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select id="departemen" name="jabatan" class="form-control m-bot15">
                                                                <option value="">Pilih Departemen</option>    
                                                                <option value="1">Teknologi Informasi</option>
                                                                <option value="2">Departemen A</option>
                                                            </select>
                                                        </td>
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
            <?php $this->load->view('taskman_rightbar_page')?>
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
