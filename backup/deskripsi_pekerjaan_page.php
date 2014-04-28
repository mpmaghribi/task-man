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
                    <div class="col-md-6">
                         <section class="panel">
                        <header class="panel-heading">
                            <?php if (isset($deskripsi_pekerjaan)) { ?>
                                    <?php
                                    foreach ($deskripsi_pekerjaan as $value) {
                                        echo $value->nama_pekerjaan;
                                    }
                                    ?>
                                <?php } ?> 
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <table class="table table-striped table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Pekerjaan</th>
                                    <th>Deadline</th>
                                    <th>File Pendukung</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($deskripsi_pekerjaan)) { ?>
                                                    <?php $i = 1;
                                                    foreach ($deskripsi_pekerjaan as $value) {?>
                                                        <tr>
                                                            <td><?php echo $i;?></td>
                                                            <td><?php echo $value->nama_sifat_pekerjaan;?></td>
                                                            <td><?php echo date("d M Y", strtotime($value->tgl_mulai)); echo " - ";echo date("d M Y", strtotime($value->tgl_selesai));?></td>
                                                            
                                                            <td>file</td>
                                                        </tr>
                                                    <?php $i++;}
                                                    ?>
                                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    </div>
                    <div class="col-md-6">
                        <section class="panel">
                        <header class="panel-heading">
                            Anggota Tim
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <table class="table table-striped table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Progress</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($listassign_pekerjaan)) { ?>
                                                    <?php $i = 1;
                                                    foreach ($listassign_pekerjaan as $value) {?>
                                                        <tr>
                                                            <td><?php echo $i;?></td>
                                                            <td><?php echo $value->nama;?></td>
                                                            <td><?php echo $value->progress;?></td>
                                                        </tr>
                                                    <?php $i++; }
                                                    ?>
                                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Pekerjaan: <?php if (isset($deskripsi_pekerjaan)) { ?>
                                    <?php
                                    foreach ($deskripsi_pekerjaan as $value) {
                                        echo $value->nama_pekerjaan;
                                    }
                                    ?>
                                <?php } ?> 
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <form class="cmxform form-horizontal " id="signupForm" method="POST" action="<?php echo site_url() ?>/pekerjaan/usulan_pekerjaan">
                                        <div class="form-group ">
                                            <?php if($this->session->userdata("user_jabatan")=="manager"){?>
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
                                                        
                                                    </tbody>
                                            </table>
                                            <?php } ?>
                                            <label for="komentar_pkj" class="control-label col-lg-3"></label>
                                            <div class="col-lg-6">
                                                <?php if (isset($deskripsi_pekerjaan)) { ?>
                                                    <?php
                                                    foreach ($deskripsi_pekerjaan as $value) {?>
                                                       <h3><?php echo $value->deskripsi_pekerjaan;?></h3> 
                                                    <?php }
                                                    ?>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-offset-3 col-lg-6">
                                                <button id="komentar" class="btn btn-primary" type="submit">Lihat Komentar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="box_komentar" style="display: <?php echo $display ?>;">
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="get" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                            <input type="hidden" name="is_isi_komentar" value="true"/>
                                            <input type="hidden" name="id_detail_pkj" value="<?php echo $id_pkj ?>"/>
                                            <div class="form-group">
                                                <label class="control-label col-lg-3"></label>

                                                <div class="col-lg-6">

                                                    <?php foreach ($lihat_komentar_pekerjaan as $value) { ?>
                                                        <div class="well">
                                                            <h4><?php echo $value->nama; ?></h4>
                                                            <?php echo $value->isi_komentar; ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label for="komentar_pkj" class="control-label col-lg-3">Berikan Komentar</label>
                                                <div class="col-lg-6">
                                                    <textarea class="form-control" name="komentar_pkj" rows="12"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-lg-6">
                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <script>
                    $(function() {
                        $('#komentar').click(function(e) {
                            e.preventDefault();
                            $('#box_komentar').show();
                            //$('#deskripsi_pkj2').load('<?php echo site_url() ?>pekerjaan/deskripsi_pekerjaan');
                        });
                    });
                </script>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <script type="text/javascript">
        $(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            var checkin = $('.dpd1').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
            var checkout = $('.dpd2').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                checkout.hide();
            }).data('datepicker');
        });
    </script>
    <?php $this->load->view("taskman_footer_page") ?>
