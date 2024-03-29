<?php $this->load->view("taskman_header_page") ?> 
<style>
    .modal-dialog{
        overflow: visible;
    }
    .modal-body{
        overflow-y: visible;
        overflow-x: visible;
    }
</style>
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


                <section class="panel">
                    <div class="row">
                        <div class="col-lg-12">


                            <header class="panel-heading">
                                Daftar Pengaduan Helpdesk
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table table-striped table-hover table-condensed" id="tabel_pengaduan">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>No</th>
                                                <th>Kode Pengaduan</th>
                                                <th>Topik Pengaduan</th>
                                                <th class="hidden-phone">Isi Pengaduan</th>
                                                <th>Tanggal Pengaduan</th>
                                                <th>Nama Pengadu</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 0;
                                            if (isset($pengaduan)) {
                                                foreach ($pengaduan as $value) {
                                                    $counter++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">Pilihan <span class="caret"></span></button>
                                                                <ul role="menu" class="dropdown-menu">
                                                                    <!--<li><a href="#" id="selesai_pengaduan" onclick="selesai_pengaduan(<?php //echo $value->id_pengaduan ?>)" >Selesai</a></li>-->
                                                                    <li><a href="#div_form_tambah_aktivitas" onclick="tampilkan_form_tambah_aktivitas('<?php echo $value->id_pengaduan ?>','<?php echo $value->kode_pengaduan; ?>')"  >Selesai / Tambah Sebagai Aktifitas</a></li> 
                                                                    <li><a href="#tolak_pengaduan" data-toggle="modal" onclick="tolak_pengaduan(<?php echo $value->id_pengaduan ?>)" >Tolak</a></li>

                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $value->kode_pengaduan; ?></td>
                                                        <td><?php
                                                            if (isset($value->topik))
                                                                echo $value->topik;
                                                            else
                                                                echo "-";
                                                            ?></td>
                                                        <td><?php echo $value->konten; ?></td>
                                                        <td><?php
                                                            date_default_timezone_set("Asia/Jakarta");
                                                            echo date("d M Y", strtotime($value->tanggal));
                                                            ?></td>
                                                        <td><?php echo $value->nama_pengadu; ?></td>
                                                        <td>
                                                            <?php if ($value->id_status_pengaduan == 3) { ?>
                                                                <div class="btn-group btn-group-sm btn-xs" width="10">


                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($value->id_status_pengaduan == 0) { ?><span class="label label-danger label-mini">Ditolak</span><?php ?>
                                                            <?php } else if ($value->id_status_pengaduan == 1) { ?><span class="label label-warning label-mini">Diterima</span><?php ?>
                                                            <?php } else if ($value->id_status_pengaduan == 4) { ?><span class="label label-success label-mini">Selesai</span><?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
//                                            if ($counter == -1) {
//                                                
                                            ?>
<!--                                                <tr>
    <td colspan="7" style="text-align: center">Tidak ada pekerjaan yang diusulkan</td>
</tr>-->
                                            <?php
//                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </section>
                <section class="panel">
                    <header class="panel-heading">
                        Form Pengaduan Sebagai Aktifitas Pekerjaan
                    </header>
                    <div class="panel-body" style="display:none" id="div_form_tambah_aktivitas">
                        <div class="row form-group">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8" >
                                <form method="post" id="formpengaduanaktifitas" action="<?= site_url() ?>/aktivitas_pekerjaan/addFromPengaduan" enctype="multipart/form-data" id="form_tambah_aktivitas" >
                                    <div class="row form-group">
                                        <label class="col-lg-4 control-label">Pekerjaan Saya</label>
                                        <div class="col-lg-8">
                                            <select name="id_pekerjaan" class="form-control m-bot15">
                                                <?php foreach ($pekerjaansaya as $value) {
                                                    echo '<option value=' . $value['id_pekerjaan'] . '>' . $value['nama_pekerjaan'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-lg-4 control-label">Kode Pengaduan</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="kodepengaduan" id="kodepengaduan" value=""/>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-lg-4 control-label">Keterangan</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="keterangan_baru" name="keterangan"/>
                                        </div>
                                    </div>
                                    <div class="row form-group" id="div_aktivitas_waktu">
                                        <label class="col-lg-4 control-label">Waktu</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="waktu_mulai_baru" name="waktu_mulai"/>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="waktu_selesai_baru" name="waktu_selesai"/>
                                            <!--<input type="text" class="form-control time " id="jam_selesai_baru" name="jam_selesai"/>-->
                                        </div>
                                    </div>
                                    <div class="row form-group" id="div_file_aktivitas">
                                        <label class="col-lg-4 control-label">File Lampiran</label>
                                        <div class="col-lg-8">
                                            <table class="table" id="tabel_berkas_aktivitas"></table>
                                            <button class="btn btn-info" id="button_pilih_berkas_aktivitas" onclick="return pilih_berkas_aktivitas();
                                                    return false;">Pilih Berkas</button>
                                            <div style="display:none">
                                                <input type="file" id="file_berkas_aktivitas" name="berkas_aktivitas[]" multiple=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-lg-4 control-label"></label>
                                        <div class="col-lg-8">
                                            <!--<input type="submit" class="btn btn-warning" value="Tambahkan Sebagai Aktifitas" >-->
                                            <button class="btn btn-warning" onclick="selesai_pengaduan()" type="button">Tambahkan Sebagai Aktifitas</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_akun" value="<?php echo $this->session->userdata['logged_in']["user_id"] ?>"/>
                                </form>
                            </div>
                            <div class="col-lg-2"></div>
                            <input type="hidden" name="idpengaduan" id="idpengaduan" value=""/>
                        </div>

                    </div>

                </section>





                <!-- page end-->
            </section>
        </section>
        <div class="modal fade" id="tolak_pengaduan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Peringatan !!!</h4>
                    </div>
                    <div class="modal-body">
                        Anda yakin ingin menolak permohonan pengaduan ini ?
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                        <button class="btn btn-warning" data-dismiss="modal" id="tolak_button" type="button"> Ya</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="pengaduan_pkj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        Tambahkan Sebagai Aktifitas Pekerjaan
                        <!--<h4 class="modal-title">Delegasi Pekerjaan dari Pengaduan</h4>-->
                    </div>

<!--                                    <form class="cmxform form-horizontal " id="signupForm" action="<?php echo site_url() ?>/pekerjaan/tambah_pengaduan" method="POST">
    <div class="modal-body">
        <input type="hidden" name="respon_pengaduan" value="1"/>
        <div class="form-group ">
            <label for="staff_rsud" class="control-label col-lg-3">Staff</label>
            <div class="col-lg-8">
                <select multiple name="staff_rsud[]" id="e9" style="width:300px" class="populate">
                    <?php foreach ($departemen as $value2) { ?>                        
                        <optgroup label="<?php echo $value2->nama_departemen ?>">
                        <?php foreach ($pegawai as $value) { ?>             
                            <?php if ($value2->id_departemen == $value->id_departemen) { ?>
                                        <option value="<?php echo $value->id_akun ?>">
                                <?php echo $value->nama ?> - <?php echo $value->nama_jabatan ?>
                                        </option>
                            <?php } ?>
                        <?php } ?>
                        </optgroup>
<?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group ">
            <label for="topik_pengaduan" class="control-label col-lg-3">Topik Pekerjaan</label>
            <div class="col-lg-8">
                <input class=" form-control" id="topik_pengaduan" name="topik_pengaduan" type="text" />
            </div>
        </div>
        <div class="form-group ">
            <label for="isi_pengaduan" class="control-label col-lg-3">Deskripsi Pekerjaan</label>
            <div class="col-lg-8">
                <textarea class=" form-control" id="isi_pengaduan" name="isi_pengaduan" rows="12">
                </textarea>
            </div>
        </div>
        <div class="form-group ">
            <label for="tgl_pengaduan" class="control-label col-lg-3">Tanggal Pengaduan</label>
            <div class="col-lg-8">
                <input readonly="true" class="form-control " id="tgl_pengaduan" name="tgl_pengaduan" type="text" value="" />
            </div>
        </div>
        <div class="form-group ">
            <label for="deadline" class="control-label col-lg-3">Deadline Pekerjaan</label>
            <div class="col-lg-8 ">
                <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                    <input id="d" readonly type="text" class="form-control dpd1_pengaduan" value="<?php
                    date_default_timezone_set('Asia/Jakarta');
                    echo date("Y-m-d H:i:s")
                    ?>" name="tgl_mulai_pengaduan">
                    <span class="input-group-addon">Sampai</span>
                    <input readonly type="text" class="form-control dpd2_pengaduan" value="<?php
                    date_default_timezone_set('Asia/Jakarta');
                    echo date("Y-m-d H:i:s", strtotime("+7 days"))
                    ?>" name="tgl_selesai_pengaduan">
                </div>
            </div>
        </div>
        <div class="form-group ">
            <label for="urgensitas" class="control-label col-lg-3">Rekomendasi Urgensitas</label>
            <div class="col-lg-8">
                <select name="urgensitas" class="form-control m-bot15">
                    <option value="">--Prioritas--</option>    
                            <option value="1">Urgent</option>
                            <option value="2">Tinggi</option>
                            <option value="3">Sedang</option>
                            <option value="4">Rendah</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
        <button class="btn btn-warning" id="simpan_pkj" type="submit"> Simpan</button>
    </div>
</form>-->
                </div>
            </div>
        </div>
        <!--main content end-->
        <!--right sidebar start-->
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

        <!-- END JAVASCRIPTS -->
        <script>
                                                jQuery(document).ready(function () {
                                                    EditableTableProgress.init();
                                                });
        </script>
<?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
<?php $this->load->view("taskman_footer_page") ?>
    <script>
        var status_form_tambah_aktivitas = false;
        function tampilkan_form_tambah_aktivitas(idpengaduan,kodepengaduan) {
//            if (status_form_tambah_aktivitas) {
//        $('#div_form_tambah_aktivitas').slideUp();
//        status_form_tambah_aktivitas = false;
//        } else {
            if(status_form_tambah_aktivitas === false)
            {$('#div_form_tambah_aktivitas').slideDown();}
            $('#kodepengaduan').val(kodepengaduan);
            $('#idpengaduan').val(idpengaduan);
//        }
    }
        function pilih_berkas_aktivitas() {
            //memicu event click pada input file, pada saat akan membuat aktivitas atau progress
            $('#file_berkas_aktivitas').click();
            return false;
        }
        function terima_pengaduan(idp)
        {
            
//            $("#topik_pengaduan").val(topik_pengaduan);
//            $("#isi_pengaduan").val(isi_pengaduan);
//            $("#tgl_pengaduan").val(tgl_pengaduan);
            $.ajax({// create an AJAX call...
                data: {
                    id_pengaduan: idp
                }, // get the form data
                type: "post", // GET or POST
                url: "<?php echo site_url() ?>/pekerjaan/get_pengaduan", // the file to call
                success: function (response) { // on success..
                    var json = jQuery.parseJSON(response);
                    if (json.status === "OK") {
                        $("#topik_pengaduan").val(json.data["topik"]);
                        $("#isi_pengaduan").val(json.data["konten"]);
                        $("#tgl_pengaduan").val(json.data["tanggal"]);
                    } else {
                        alert("HTTP 404. Not Found, ");
                    }
                }
            });
        }
//            $("#simpan_pkj").click(function(e){
//                e.preventDefault();
//                $.ajax({// create an AJAX call...
//                            data: {
//                                    id_pengaduan: idp,
//                                    id_status: 1,
//                                    komentar: "Pengaduan anda sudah kami terima dan telah di follow up ke task management. Terima kasih."
//                                }, // get the form data
//                            type: "POST", // GET or POST
//                            url: "<?php echo site_url(); ?>/pekerjaan/get_pengaduan", // the file to call
//                            success: function(response) { // on success..
//                                //window.location.href= "";
//                            }
//                        });
//            });
        function tolak_pengaduan(idp)
        {
            $("#tolak_button").click(function (e) {
                e.preventDefault();
                $.ajax({// create an AJAX call...
                    data: {
                        id_pengaduan: idp,
                        id_status: 0,
                        komentar: "Pengaduan tidak bisa kami teruskan ke task management. Terima kasih."
                    }, // get the form data
                    type: "POST", // GET or POST
                    url: "<?php echo str_replace('taskmanagement', 'integrarsud/helpdesk', str_replace('://', '://hello:world@', base_url())) . "index.php/pengaduan/updateStatus"; ?>", // the file to call
                    success: function (response) { // on success..
                        window.location.href = "";
                    }
                });
            });
        }


        function selesai_pengaduan(idp)
        {
            idp = $('#idpengaduan').val();
            
//                $("#selesai_pengaduan").click(function(e){
//                    e.preventDefault();
            $.ajax({// create an AJAX call...
                data: {
                    id_pengaduan: idp,
                    id_status: 4,
                    komentar: "Pengaduan anda telah selesai kami tangani. Terima kasih."
                }, // get the form data
                type: "POST", // GET or POST
                url: "<?php echo str_replace('taskmanagement', 'integrarsud/helpdesk', str_replace('://', '://hello:world@', base_url())) . "index.php/pengaduan/updateStatus"; ?>", // the file to call
                success: function (response) { // on success..
                    document.forms["formpengaduanaktifitas"].submit();
//                    window.location.href = "";
                }
            });
            // });
        }
        $(document).ready(function () {

            var date_min = new Date(new Date().getFullYear(), 0, 1);

            var date_max = new Date(new Date().getFullYear(), 11, 31)

            var waktu_mulai_baru = $('#waktu_mulai_baru').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function (date) {
                    return date < date_min || date > date_max ? 'disabled' : '';
                }
            }).on('changeDate', function (ev) {
                waktu_selesai_baru.setValue(new Date(ev.date));
                waktu_mulai_baru.hide();
                $('#waktu_selesai_baru').focus();
            }).data('datepicker');
            var waktu_selesai_baru = $('#waktu_selesai_baru').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function (date) {
                    return date < date_min || date > date_max || waktu_mulai_baru.date > date ? 'disabled' : '';
                }
            }).data('datepicker');

        });
    </script>
<?php if ($this->session->flashdata("notif_sukses") != NULL && $this->session->flashdata("notif_sukses") == "sukses") { ?>
        <script>
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Penambahan pekerjaan berhasil',
                // (string | mandatory) the text inside the notification
                text: 'Staff akan menerima notifikasi dari anda'
            });
        </script>
<?php
}?>