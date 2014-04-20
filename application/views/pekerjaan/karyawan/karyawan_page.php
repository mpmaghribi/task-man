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
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#ListPekerjaan">List Pekerjaan</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#TambahPekerjaan">Tambah Pekerjaan</a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="ListPekerjaan" class="tab-pane active">
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
                                                                    <td><?php echo $this->session->userdata('user_nama') ?></td>
                                                                    <td><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
                                                                    <td>
                                                                        <div class="progress progress-striped progress-xs">
                                                                            <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
                                                                                <span class="sr-only">0% Complete (success)</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <form method="POST" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                            <input type="hidden" name="id_detail_pkj" value="<?php echo $value->id_pekerjaan ?>"/>
                                                                            <button type="submit" class="btn btn-success"><i class="fa fa-eye"></i> View </button>
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
                                    </div>
                                    <div id="TambahPekerjaan" class="tab-pane">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="signupForm" method="POST" action="<?php echo site_url() ?>/pekerjaan/usulan_pekerjaan">
                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="sifat_pkj" class="form-control m-bot15">
                                                            <option value="">--Pekerjaan--</option>    
                                                            <option value="1">Personal</option>
                                                            <option value="2">Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="firstname" name="nama_pkj" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pkj" rows="12"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deadline" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6 ">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input id="d" readonly type="text" class="form-control dpd1" value="" name="tgl_mulai_pkj">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input readonly type="text" class="form-control dpd2" value="" name="tgl_selesai_pkj">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                                                    <div class="col-lg-6">
                                                        <select name="prioritas" class="form-control m-bot15">
                                                            <option value="">--Prioritas--</option>    
                                                            <option value="1">Urgent</option>
                                                            <option value="2">Tinggi</option>
                                                            <option value="3">Sedang</option>
                                                            <option value="4">Rendah</option>
                                                        </select>
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
                            </div>
                        </section>
                    </div>
                </div>
                <script>
                    $(function() {
                        $('#nama_pkj').click(function(e) {
                            e.preventDefault();
                            $('#deskripsi_pkj').show();
                            $('#deskripsi_pkj2').load('<?php echo site_url() ?>pekerjaan/deskripsi_pekerjaan');
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