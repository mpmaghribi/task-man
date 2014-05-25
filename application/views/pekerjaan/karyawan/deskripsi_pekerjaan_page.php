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
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;display: none;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-success btn-xs" href="#" id="tombol_validasi_usulan" style="font-size: 10px">Validasi</a>
                                    <a class="btn btn-info btn-xs" href="#" id="tombol_edit_usulan" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-danger btn-xs" href="#" id="tombol_batalkan_usulan" style="font-size: 10px">Batalkan</a>
                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="deskripsiPekerjaan" class="tab-pane active">
                                        <section class="panel" >
                                        </section>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Nama Pekerjaan
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php
                                                    if (isset($deskripsi_pekerjaan)) {
                                                        $nama_pekerjaan = "";
                                                        ?>
                                                        <?php
                                                        foreach ($deskripsi_pekerjaan as $value) {
                                                            echo $value->nama_pekerjaan;
                                                            $nama_pekerjaan = $value->nama_pekerjaan;
                                                        }
                                                        ?>
                                                    <?php } ?> 
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Penjelasan Pekerjaan
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php if (isset($deskripsi_pekerjaan)) { ?>
                                                        <?php foreach ($deskripsi_pekerjaan as $value) { ?>
                                                            <?php echo $value->deskripsi_pekerjaan; ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Jenis Pekerjaan
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php echo $deskripsi_pekerjaan[0]->nama_sifat_pekerjaan; ?>
                                                </p>
                                                <h4 style="color: #1FB5AD;">
                                                    Deadline
                                                </h4>
                                                <p style="font-size: larger">
                                                    <?php
                                                    echo date("d M Y", strtotime($deskripsi_pekerjaan[0]->tgl_mulai));
                                                    echo " - ";
                                                    echo date("d M Y", strtotime($deskripsi_pekerjaan[0]->tgl_selesai));
                                                    ?>
                                                </p>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="table_deskripsi">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama File</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($list_berkas)) {
                                                                $i = 1;
                                                                foreach ($list_berkas as $berkas) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo basename($berkas->nama_file); ?></td>
                                                                        <td style="text-align: right">download hapus</td>
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
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Anggota Tim
                                                </h4>
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
                                                                        <td id="nama_staff_<?php //echo $value->id_akun;   ?>"><?php //echo $value->id_akun;   ?><?php foreach ($users as $value2) { ?>
                                                                                <?php if ($value->id_akun == $value2->id_akun) { ?><?php echo $value2->nama ?><?php } ?>
                                                                            <?php } ?></td>
                                                                        <td>
                                                                            <div class="progress progress-striped progress-xs">
                                                                                <div style="width: <?php echo $value->progress; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $value->progress; ?>" role="progressbar" class="progress-bar progress-bar-warning">
                                                                                    <span class="sr-only"><?php echo $value->progress; ?>% Complete (success)</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php if ($value->id_akun == $temp['user_id'] && $value->flag_usulan == 2) { ?>
                                                                                <a class="edit btn btn-primary btn-xs" href="javascript:;">Ubah Progress</a>
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
                                    <div class="panel-body">
                                        <form class="cmxform form-horizontal " id="signupForm" method="POST" action="#<?php //echo site_url()   ?>/pekerjaan/usulan_pekerjaan">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <button id="komentar" class="btn btn-primary" type="button">Lihat Komentar</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="box_komentar" style="display: <?php echo $display ?>">
                                            <div class="form">

                                                <form class="cmxform form-horizontal " id="signupForm" method="post" action="#<?php //echo $_SERVER['REQUEST_URI'];   ?>">
                                                    <?php //echo $_SERVER['REQUEST_URI']; ?>
                                                    <input type="hidden" id="is_isi_komentar" name="is_isi_komentar" value="true"/>
                                                    <input type="hidden" id="id_detail_pkj" name="id_detail_pkj" value="<?php echo $id_pkj ?>"/>
                                                    <div class="form-group">
                                                        <div id="lihat_komen" class="col-lg-12">

                                                        </div>
                                                        <div id="tes" class="col-lg-12">

                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="col-lg-12">
                                                            <textarea class="form-control" id="komentar_pkj" name="komentar_pkj" rows="12"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-lg-12">
                                                            <button id="save_komen" class="btn btn-primary" type="button">Save</button>
                                                        </div>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">

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
                            var id_pkj = document.getElementById('id_detail_pkj').value;
                            $('#box_komentar').show();
                            $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
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
    <script>
        function ubah_komentar(id_komen) {
            //alert(id_komen);
            $.ajax({// create an AJAX call...
                data:
                        {
                            id_komentar_ubah: id_komen
                        }, // get the form data
                type: "GET", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan_by_id", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(json.data);
                    $("#komentar_pkj_ubah").val(json.data);
                }
            });
            $('#ubah_komen').click(function(e) {
                //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                e.preventDefault();
                //alert(document.getElementById('komentar_pkj_ubah').value);
                var id_pkj = document.getElementById('id_detail_pkj').value;
                $.ajax({// create an AJAX call...
                    data:
                            {
                                id_komentar_ubah: id_komen,
                                isi_komentar_ubah: document.getElementById('komentar_pkj_ubah').value
                            }, // get the form data
                    type: "GET", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/ubah_komentar_pekerjaan", // the file to call
                    success: function(response) { // on success..
                        //var json = jQuery.parseJSON(response);
                        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                    }
                });
            });
        }
    </script>
    <script>
        function hapus(id) {
            $('#hapus_komen').click(function(e) {
                //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                e.preventDefault();
                var id_pkj = document.getElementById('id_detail_pkj').value;
                $.ajax({// create an AJAX call...
                    data:
                            {
                                id_komentar: id
                            }, // get the form data
                    type: "GET", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/hapus_komentar_pekerjaan", // the file to call
                    success: function(response) { // on success..
                        $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                    }
                });
            });
        }
    </script>

    <script>

        $('#save_komen').click(function(e) {
            //alert("pekerjaan yg divalidasi " + id_pekerjaan);
            e.preventDefault();
            var id_pkj = document.getElementById('id_detail_pkj').value;
            $.ajax({// create an AJAX call...
                data:
                        {
                            id_detail_pkj: document.getElementById('id_detail_pkj').value, // get the form data
                            komentar_pkj: document.getElementById('komentar_pkj').value,
                            is_isi_komentar: document.getElementById('is_isi_komentar').value
                        }, // get the form data
                type: "GET", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/komentar_pekerjaan", // the file to call
                success: function(response) { // on success..
                    $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                }
            });
        });
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
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
                            //$('#div_acc_edit_cancel_usulan_pekerjaan').remove();
                            $('#tombol_validasi_usulan').remove();
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
                            $('#div_acc_edit_cancel_usulan_pekerjaan').css("display", "block");
                            if (json.data === "1") {
                                $('#tombol_validasi_usulan').css('display','block');
                                $('#tombol_validasi_usulan').attr("onclick", 'validasi(' + id_pekerjaan + ');');
                            } else if (json.data === "2") {
                                $('#tombol_validasi_usulan').remove();
                            }
                            $('#tombol_batalkan_usulan').attr("onclick", '');
                            $('#tombol_edit_usulan').attr("href", '<?php echo base_url(); ?>pekerjaan/edit?id_pekerjaan=' + id_pekerjaan);
                        } else {
                            $('#div_acc_edit_cancel_usulan_pekerjaan').remove();
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
                $('#komentar_nama_' + id_akun).html(nama);
            }
            document.title = 'Deskripsi Pekerjaan: <?php echo $nama_pekerjaan; ?> - Task Management';
        </script>
        <?php
    }
    ?>
