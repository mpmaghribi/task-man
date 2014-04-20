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
                                <div class="panel-body profile-information">
                                    <div class="col-lg-6">
                                        <h3>Daftar Karyawan</h3>
                                        <div class="panel-body">

                                            <table class="table general-table table-hover">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Daftar Pekerjaan</th>
                                                    <th>Deadline</th>
                                                    <th>Progress</th>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Bagus</td>
                                                    <td>Perawat</td>
                                                    <td>Pekerjaan 1</td>
                                                    <td>12-05-2014</td>
                                                    <td>
                                                        <div class="progress progress-striped progress-xs">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                                <span class="sr-only">
                                                                    40% Complete (success)
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Cahya</td>
                                                    <td>Perawat</td>
                                                    <td>Pekerjaan 1</td>
                                                    <td>12-05-2014</td>
                                                    <td>
                                                        <div class="progress progress-striped progress-xs">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                                <span class="sr-only">
                                                                    60% Complete (success)
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Sukma</td>
                                                    <td>Perawat</td>
                                                    <td>Pekerjaan 1</td>
                                                    <td>12-05-2014</td>
                                                    <td>
                                                        <div class="progress progress-striped progress-xs">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                                                                <span class="sr-only">
                                                                    10% Complete (success)
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Agus</td>
                                                    <td>Perawat</td>
                                                    <td>Pekerjaan 1</td>
                                                    <td>12-05-2014</td>
                                                    <td>
                                                        <div class="progress progress-striped progress-xs">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                                <span class="sr-only">
                                                                    40% Complete (success)
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Iqbal</td>
                                                    <td>Perawat</td>
                                                    <td>Pekerjaan 1</td>
                                                    <td>12-05-2014</td>
                                                    <td>
                                                        <div class="progress progress-striped progress-xs">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                                <span class="sr-only">
                                                                    80% Complete (success)
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

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

        <?php $this->load->view("taskman_footer_page") ?>