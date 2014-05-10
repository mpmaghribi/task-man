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
                    
                        <div class="col-md-12" >
                            <section class="panel">
                                <header class="panel-heading tab-bg-dark-navy-blue ">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a data-toggle="tab" href="#deskripsiPekerjaan">Deskripsi Pekerjaan</a>
                                        </li>
                                        <?php if (true) { ?>
                                            <li class="">
                                                <a data-toggle="tab" href="#penilaianPekerjaan">Penilaian Kerja Staff</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </header>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div id="deskripsiPekerjaan" class="tab-pane active">
                                            <section class="panel" >
                                                <header class="panel-heading" id="header_aksi" style="display:none">tindakan
                                                    <span class="tools pull-right">
                                                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                                                    </span>
                                                </header>
                                                <div class="panel-body" id="div_acc_edit_cancel_usulan_pekerjaan" style="display:none">
                                                    <div class="btn-group btn-group-lg">
                                                        <a class="btn btn-success" href="#" id="tombol_validasi_usulan">Validasi</a>
                                                        <a class="btn btn-info" href="#" id="tombol_edit_usulan">Edit</a>
                                                        <a class="btn btn-danger" href="#" id="tombol_batalkan_usulan">Batalkan</a>
                                                    </div>
                                                </div>
                                            </section>
                                            <div class="col-md-6">
                                                <section class="panel">
                                                    <header class="panel-heading">
                                                        <?php if (isset($deskripsi_pekerjaan)) { $nama_pekerjaan="";?>
                                                            <?php
                                                            foreach ($deskripsi_pekerjaan as $value) {
                                                                echo $value->nama_pekerjaan;
                                                                $nama_pekerjaan=$value->nama_pekerjaan;
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
                                                                <?php
                                                                if (isset($deskripsi_pekerjaan)) {
                                                                    $i = 1;
                                                                    foreach ($deskripsi_pekerjaan as $value) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $i; ?></td>
                                                                            <td><?php echo $value->nama_sifat_pekerjaan; ?></td>
                                                                            <td><?php
                                                                                echo date("d M Y", strtotime($value->tgl_mulai));
                                                                                echo " - ";
                                                                                echo date("d M Y", strtotime($value->tgl_selesai));
                                                                                ?></td>

                                                                            <td>file</td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
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
                                                        <table class="table table-striped table-hover table-condensed" id="editable-sample">
                                                            <thead>
                                                                <tr>
                                                                    <th style="display: none">id</th>
                                                                    <th>#</th>
                                                                    <th>Nama</th>
                                                                    <th>Progress</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($listassign_pekerjaan)) {
                                                                    $i = 1;
                                                                    foreach ($listassign_pekerjaan as $value) {
                                                                        ?>
                                                                        <tr>
                                                                            <td style="display: none"><?php echo $value->id_detil_pekerjaan ?></td>
                                                                            <td><?php echo $i; ?></td>
                                                                            <td id="nama_staff_<?php echo $value->id_akun; ?>"></td>
                                                                            <td>
                                                                                <div class="progress progress-striped progress-xs">
                                                                                    <div style="width: <?php echo $value->progress; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $value->progress; ?>" role="progressbar" class="progress-bar progress-bar-warning">
                                                                                        <span class="sr-only"><?php echo $value->progress; ?>% Complete (success)</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <?php if ($value->id_akun == $this->session->userdata('user_id') && $value->flag_usulan == 2) { ?>
                                                                                    <a class="edit" href="javascript:;">Progress</a>
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <?php if ($temp['jmlstaff'] > 0) { ?>
                                            <div id="penilaianPekerjaan" class="tab-pane">

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </section>
                        </div>
                    

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading">

                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <form class="cmxform form-horizontal " id="signupForm" method="POST" action="<?php echo site_url() ?>/pekerjaan/usulan_pekerjaan">
                                        <div class="form-group ">

                                            <label for="komentar_pkj" class="control-label col-lg-3"></label>
                                            <div class="col-lg-6">
                                                <?php if (isset($deskripsi_pekerjaan)) { ?>
                                                    <?php foreach ($deskripsi_pekerjaan as $value) { ?>
                                                        <h3><?php echo $value->deskripsi_pekerjaan; ?></h3> 
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-offset-3 col-lg-6">
                                                <button id="komentar" class="btn btn-primary" type="submit">Lihat Komentar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="box_komentar" style="display: <?php echo $display ?>">
                                    <div class="form">
                                        <form class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                            <input type="hidden" name="is_isi_komentar" value="true"/>
                                            <input type="hidden" name="id_detail_pkj" value="<?php echo $id_pkj ?>"/>
                                            <div class="form-group">
                                                <label class="control-label col-lg-3"></label>
                                                <div class="col-lg-6">
                                                    <?php foreach ($lihat_komentar_pekerjaan as $value) { ?>
                                                        <div class="well">
                                                            <h4 id="komentar_nama_<?php echo $value->id_akun; ?>">Nama Disembunyikan</h4>
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
                <!--script for this page only-->
                <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

                <!-- END JAVASCRIPTS -->
                <script>
                    jQuery(document).ready(function() {
                        EditableTableProgress.init();
                    });
                </script>
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
    <?php
    $this->load->view("taskman_footer_page");

    if ($data_akun['jmlstaff'] > 0) {
        ?>
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
                            $('#div_acc_edit_cancel_usulan_pekerjaan').remove();
                            $('#header_aksi').remove();
                        } else {
                            alert("validasi gagal, " + json.reason);
                        }
                    }
                });
            }
            function get_status_usulan(id_pekerjaan) {
                $.ajax({// create an AJAX call...
                    data: "id_pekerjaan=" + id_pekerjaan, // get the form data
                    type: "GET", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/get_status_usulan", // the file to call
                    success: function(response) { // on success..
                        var json = jQuery.parseJSON(response);
                        //alert(response);
                        if (json.status === "OK") {
                            if (json.data === "1") {
                                $('#div_acc_edit_cancel_usulan_pekerjaan').css("display", "block");
                                $('#header_aksi').css("display", "block");
                                $('#tombol_edit_usulan').attr("href", '<?php echo base_url(); ?>pekerjaan/edit?id_pekerjaan=' + id_pekerjaan);
                                $('#tombol_validasi_usulan').attr("onclick", 'validasi(' + id_pekerjaan + ');');
                                $('#tombol_batalkan_usulan').attr("onclick", '');
                            }
                        } else {
                            $('#div_acc_edit_cancel_usulan_pekerjaan').remove();
                            $('#header_aksi').remove();
                        }
                    }
                });
            }
            $('#tombol_validasi_usulan').click(function(event) {
                event.preventDefault();
            });
            $('#tombol_batalkan_usulan').click(function(event) {
                event.preventDefault();
            });
            get_status_usulan(<?php if (isset($id_pkj)) echo $id_pkj; ?>);
            var my_staff = jQuery.parseJSON('<?php echo $my_staff; ?>');
            console.log(my_staff);
            var jumlah_staff = my_staff.length;
            var list_id_akun_detil_pekerjaan = [];
    <?php foreach ($listassign_pekerjaan as $detil) { ?>list_id_akun_detil_pekerjaan.push('<?php echo $detil->id_akun; ?>');<?php } ?>
            var jumlah_id_akun_detil_pekerjaan = list_id_akun_detil_pekerjaan.length;
            for (var i = 0; i < jumlah_id_akun_detil_pekerjaan; i++) {
                var nama = "";
                var id_akun = list_id_akun_detil_pekerjaan[i];
                //alert('id akun = ' + id_akun);
                if (id_akun === '<?php echo $temp["user_id"]; ?>') {
                    nama = '<?php echo $temp["nama"]; ?>';
                } else {
                    for (var j = 0; j < jumlah_staff; j++) {
                        //alert('id staff = ' + my_staff[j]["id_akun"]);
                        if (id_akun === my_staff[j]["id_akun"]) {
                            nama = my_staff[j]["nama"];
                            break;
                        }
                    }
                }
                $('#nama_staff_' + id_akun).html(nama);
                $('#komentar_nama_'+id_akun).html(nama);
            }
            document.title='Deskripsi Pekerjaan: <?php echo $nama_pekerjaan; ?> - Task Management';
        </script>
        <?php
    }
    ?>
