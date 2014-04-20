<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="images/favicon.png">
        <title>Setting Akun</title>
        <!--Core CSS -->
        <link href="<?php echo base_url() ?>/assets/bs3/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/css/clndr.css" rel="stylesheet">
        <!--clock css-->
        <link href="<?php echo base_url() ?>/assets/js/css3clock/css/style.css" rel="stylesheet">
        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?php echo base_url() ?>/assets/js/morris-chart/morris.css">
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/style-responsive.css" rel="stylesheet" />
        <link href="<?php echo base_url() ?>assets/css/notifit.css" rel="stylesheet"/>
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
                        <div class="col-lg-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Setting Akun Anda

                                </header>

                                <div class="panel-body">
                                    <form class="form-horizontal bucket-form" method="post" action="<?php echo base_url(); ?>/profil/ubah_profil" id="form_update_profil" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">NIP</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="NIP" id="NIP" readonly="true" value="<?php echo $akun->nip; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nama</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $akun->nama; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jenis Kelamin</label>
                                            <div class="col-sm-6">
                                                <select name="jenis_kelamin" class="form-control input-sm m-bot15">
                                                    <option value="L" <?php echo $akun->jenis_kelamin == 'L' ? 'selected' : ''; ?>>Laki-Laki</option>
                                                    <option value="P" <?php echo $akun->jenis_kelamin == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tempat Lahir</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="<?php echo $akun->tempat_lahir; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tanggal Lahir</label>
                                            <div class="col-sm-6">
                                                <!--input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo $akun->tgl_lahir; ?>"/-->
                                                <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="<?php echo $akun->tgl_lahir; ?>" name="tanggal_lahir" id="tanggal_lahir" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Alamat</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $akun->alamat; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Agama</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="agama" id="agama" value="<?php echo $akun->agama; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Telepon</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="telepon" id="telepon"  value="<?php echo $akun->telepon; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">HP</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="hp" id="hp" value="<?php echo $akun->hp; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="email" id="email"  value="<?php echo $akun->email; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Departemen</label>
                                            <div class="col-sm-6">
                                                <!--input type="text" class="form-control" name="departemen" id="departemen" value="<?php echo $akun->id_departemen; ?>"/-->
                                                <select name="departemen" class="form-control input-sm m-bot15">
                                                    <?php foreach ($departemen as $d) { ?>
                                                        <option value="<?php echo $d->id_departemen; ?>" <?php echo $d->id_departemen == $akun->id_departemen ? 'selected' : ''; ?>><?php echo $d->nama_departemen; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jabatan</label>
                                            <div class="col-sm-6">
                                                <!--input type="text" class="form-control" name="jabatan" id="jabatan" value="<?php echo $akun->id_jabatan; ?>"/-->
                                                <select name="jabatan" class="form-control input-sm m-bot15">
                                                    <?php foreach ($jabatan as $j) { ?>
                                                        <option value="<?php echo $j->id_jabatan; ?>" <?php echo $j->id_jabatan == $akun->id_jabatan ? 'selected' : ''; ?>><?php echo $j->nama_jabatan; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-1">
                                                <input type="submit" class="btn btn-info" value="Simpan"/>
                                                <!--a href="#modal_ubah_profil" data-toggle="modal" class="btn btn-warning" id="submit_update_profil">
                                                    Simpan
                                                </a-->
                                            </div>
                                            <div class="col-sm-1">
                                                <a href="#modal_ubah_password" data-toggle="modal" class="btn btn-warning" id="tombol_ubah_password" onclick="reset_field_password()">
                                                    Ubah Password
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_ubah_password" class="modal fade" autocomplete="off">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" id="modal_ubah_password_close" type="button">×</button>
                                                <h4 class="modal-title">Ubah Password</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" role="form" action="<?php echo site_url() . "/profil/ubah_password" ?>" id="form_ubah_password" method="post" autocomplete="off">
                                                    <div class="form-group">
                                                        <label for="inputEmail1" class="col-lg-3 col-sm-2 control-label">Password Lama</label>
                                                        <div class="col-lg-9">
                                                            <input type="password" class="form-control" id="password_lama" placeholder="Password Lama" name="password_lama">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputPassword1" class="col-lg-3 col-sm-2 control-label">Password Baru</label>
                                                        <div class="col-lg-9">
                                                            <input type="password" class="form-control" id="password_baru" placeholder="Password Baru" name="password_baru">
                                                            <label class="error" for="password_baru" style="display: none" id="password_baru_error">
                                                                Harap mengisi password baru
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputPassword2" class="col-lg-3 col-sm-2 control-label">Ulangi Password Baru</label>
                                                        <div class="col-lg-9">
                                                            <input type="password" class="form-control" id="password_baru_2" placeholder="Password Baru" name="password_baru_2">
                                                            <label class="error" for="password_baru_2" style="display: none" id="password_baru_2_error">
                                                                Harap mengisi lagi password baru
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-3 col-lg-10">
                                                            <button type="submit" class="btn btn-default" id="submit_ubah_password">Ubah</button>
                                                            <label class="error" for="submit_ubah_password" style="display: none" id="submit_ubah_password_error">
                                                                Gagal mengubah password, coba lagi
                                                            </label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_ubah_profil" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" id="modal_ubah_profil_close" type="button">×</button>
                                                <h4 class="modal-title">Ubdah Profil Berhasil</h4>
                                            </div>
                                            <div class="modal-body">

                                            </div>
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
        <script src="<?php echo base_url() ?>/assets/js/jquery-ui-1.9.2.custom.min.js"></script>
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
        <script src="<?php echo base_url() ?>/assets/js/notifit.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script>
                                                    $("#form_update_profil").submit(function() { // catch the form's submit event
                                                        //var keputusan = false;
                                                        $.ajax({// create an AJAX call...
                                                            data: $(this).serialize(), // get the form data
                                                            type: $(this).attr('method'), // GET or POST
                                                            url: $(this).attr('action'), // the file to call
                                                            success: function(response) { // on success..
                                                                var json = jQuery.parseJSON(response);
                                                                //alert(response);
                                                                if (json.status === "OK") {
                                                                    //alert("ok");
                                                                    //keputusan= true;
                                                                    window.location = "<?php echo site_url() ?>/profil";
                                                                }
                                                            }
                                                        });
                                                        return false;
                                                        //return keputusan; // cancel original event to prevent form submitting
                                                    });
                                                    $("#form_ubah_password").submit(function() { // catch the form's submit event
                                                        $('#password_baru_error').css("display", "none");
                                                        $('#password_baru_2_error').css("display", "none");
                                                        $('#submit_ubah_password_error').css("display","none");
                                                        if ($('#password_baru').val().length === 0) {
                                                            $('#password_baru_error').css("display", "block");
                                                        } else if ($('#password_baru_2').val().length === 0) {
                                                            $('#password_baru_2_error').css("display", "block");
                                                            $('#password_baru_2_error').text("harap mengisi lagi password baru")
                                                        } else if ($('#password_baru').val() !== $('#password_baru_2').val()) {
                                                            $('#password_baru_2_error').css("display", "block");
                                                            $('#password_baru_2_error').text("masukkan lagi password baru yang sama")
                                                        } else {
                                                            $.ajax({// create an AJAX call...
                                                                data: $(this).serialize(), // get the form data
                                                                type: $(this).attr('method'), // GET or POST
                                                                url: $(this).attr('action'), // the file to call
                                                                success: function(response) { // on success..
                                                                    var json = jQuery.parseJSON(response);
                                                                    //alert(response);
                                                                    if (json.status === "OK") {
                                                                        $("#modal_ubah_password_close").click();
                                                                    }else{
                                                                        $('#submit_ubah_password_error').css("display","block");
                                                                    }
                                                                }
                                                            });
                                                        }
                                                        return false; // cancel original event to prevent form submitting
                                                    });
                                                    //$("#tanggal_lahir").datepicker();
                                                    function reset_field_password() {
                                                        $('#password_lama').val('');
                                                        $('#password_baru').val('');
                                                        $('#password_baru_2').val('');
                                                        $('#password_baru_error').css("display", "none");
                                                        $('#password_baru_2_error').css("display", "none");
                                                        $('#submit_ubah_password_error').css("display","none");
                                                    }
                                                    
        </script>
    </body>
</html>
<?php
//var_dump ($departemen);
?>