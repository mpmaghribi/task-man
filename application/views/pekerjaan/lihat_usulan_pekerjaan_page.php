<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php $this->load->view("taskman_header_page") ?> 
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
                            <header class="panel-heading">
                                Usulan Pekerjaan
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table  table-hover general-table">
                                        <thead>
                                            <tr>
                                                <th> No</th>
                                                <th class="hidden-phone">Pekerjaan</th>
                                                <th>Deadline</th>
                                                <th>Assign To</th>
                                                <th>Status</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 0;
                                            if (isset($list_usulan)) {
                                                foreach ($list_usulan as $usulan) {
                                                    $counter++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $usulan->nama_pekerjaan; ?></td>
                                                        <td><?php echo $usulan->tgl_mulai . " - " . $usulan->tgl_selesai; ?></td>
                                                        <td><?php echo $usulan->nama; ?></td>
                                                        <td id="td_flag_<?php echo $usulan->id_pekerjaan; ?>"><?php if ($usulan->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($usulan->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
                                                        <td>
                                                            <form method="POST" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                <input type="hidden" name="id_detail_pkj" value="<?php echo $usulan->id_pekerjaan ?>"/>
                                                                <button type="submit" class="btn btn-success"><i class="fa fa-eye"></i> View </button>
                                                            </form>
                                                        </td>
                                                        <td id="td<?php echo $usulan->id_pekerjaan; ?>">
                                                            <button id="validasi<?php echo $usulan->id_pekerjaan; ?>" type="button" class="btn btn-default" onclick="validasi(<?php echo $usulan->id_pekerjaan; ?>);"><i class="fa fa-eye"> OK</i> </button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            if ($counter == 0) {
                                                ?>
                                                    <tr>
                                                        <td colspan="7" style="text-align: center">Tidak ada pekerjaan yang diusulkan</td>
                                                    </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <script>
                    function validasi(id_pekerjaan) {
                        //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                        $.ajax({// create an AJAX call...
                            data: "id_pekerjaan=" + id_pekerjaan, // get the form data
                            type: "POST", // GET or POST
                            url: "<?php echo site_url(); ?>/pekerjaan/validasi_usulan", // the file to call
                            success: function(response) { // on success..
                                var json = jQuery.parseJSON(response);
                                //alert(response);
                                if (json.status === "OK") {
                                    $("#validasi" + id_pekerjaan).css("display", "none");
                                    $('#td_flag_' + id_pekerjaan).html("<span class=\"label label-success label-mini\">Aprroved</span>");
                                } else {
                                    alert("validasi gagal, " + json.reason);
                                }
                            }
                        });
                    }
                </script>
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
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1_small.jpg" alt=""></a>
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
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1.jpg" alt=""></a>
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
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/chat-avatar2.jpg" alt=""></a>
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
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1_small.jpg" alt=""></a>
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
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1.jpg" alt=""></a>
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
    <script type="text/javascript">

    </script>
    <?php $this->load->view("taskman_footer_page") ?>
