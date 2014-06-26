<?php $this->load->view("taskman_header_page") ?> 
<script src="<?php echo base_url() ?>/assets/js/status_pekerjaan.js"></script>
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
<?php if(in_array(2,$data_akun['idmodul'])){?>
                                    <li class="">
                                        <a data-toggle="tab" href="#TambahPekerjaan">Usulkan Pekerjaan</a>
                                    </li>
<?php } ?>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="ListPekerjaan" class="tab-pane active">
                                        <section class="panel">
                                            <header class="panel-heading">
                                                Daftar Pekerjaan yang Saya Kerjakan
                                            </header>
                                            <div class="panel-body">
                                                <div class="form">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_pkj_saya">
                                                        <thead>
                                                            <tr>
                                                                <th> No</th>
                                                                <th class="hidden-phone">Pekerjaan</th>
                                                                <th>Deadline</th>
                                                                <th>Assign To</th>
                                                                <th style="min-width: 150px">Status</th>
                                                                <th></th>
    <!--                                                            <th>Progress</th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($pkj_karyawan)) {
                                                                $sekarang = date('Y-m-d');
                                                                $i = 0;
                                                                foreach ($pkj_karyawan as $value) {
                                                                    ?>
                                                                    <?php
                                                                    if ($value->flag_usulan == 2) {
                                                                        $i++;
                                                                        ?>
                                                                        <tr>
                                                                            <td>
            <?php echo $i; ?>
                                                                            </td>
                                                                            <td class="hidden-phone"><?php echo $value->nama_pekerjaan ?></td>
                                                                            <td> <?php echo date("d M Y", strtotime($value->tgl_mulai)) ?> - <?php echo date("d M Y", strtotime($value->tgl_selesai)) ?></td>
                                                                            <td id="pekerjaan_nama_staff_<?php echo $value->id_pekerjaan; ?>"></td>
                                                                            <td id="pekerjaan_saya_status_<?php echo $value->id_pekerjaan; ?>"><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
                                                                            <td>
                                                                                <a href="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan?id_detail_pkj=<?php echo $value->id_pekerjaan ?>">
                                                                                    <span class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </span>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    <script>
                                                                        ubah_status_pekerjaan('pekerjaan_saya_status_<?php echo $value->id_pekerjaan; ?>', <?php echo $value->flag_usulan; ?>, '<?php echo $sekarang; ?>', '<?php echo $value->tgl_mulai; ?>', '<?php echo $value->tgl_selesai; ?>', '<?php echo $value->tgl_read; ?>', '<?php echo $value->status; ?>', <?php echo $value->progress; ?>);
                                                                    </script>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
<?php } ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                        <?php if(in_array(2,$data_akun['idmodul'])){?>
                                        <section class="panel">
                                            <header class="panel-heading">
                                                Daftar Usulan Pekerjaan Saya
                                            </header>
                                            <div class="panel-body">
                                                <div class="form">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_pkj_saya2">
                                                        <thead>
                                                            <tr>
                                                                <th> No</th>
                                                                <th class="hidden-phone">Pekerjaan</th>
                                                                <th>Deadline</th>
                                                                <th>Assign To</th>
                                                                <th style="min-width: 150px">Status</th>
                                                                <th></th>
    <!--                                                            <th>Progress</th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (isset($pkj_karyawan)) { ?>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($pkj_karyawan as $value) {
                                                                    ?>
        <?php if ($value->flag_usulan == 1) { ?>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#">
                                                                                    <?php
                                                                                    echo $i;
                                                                                    $i++;
                                                                                    ?>
                                                                                </a>
                                                                            </td>
                                                                            <td class="hidden-phone"><?php echo $value->nama_pekerjaan ?></td>
                                                                            <td> <?php echo date("d M Y", strtotime($value->tgl_mulai)) ?> - <?php echo date("d M Y", strtotime($value->tgl_selesai)) ?></td>
                                                                            <td id="pekerjaan_nama_staff_<?php echo $value->id_pekerjaan; ?>"></td>
                                                                            <td id="pekerjaan_saya_status_<?php echo $value->id_pekerjaan; ?>"><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>

                                                                            <td>
                                                                                <form method="get" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                                    <input type="hidden" name="id_detail_pkj" value="<?php echo $value->id_pekerjaan ?>"/>
                                                                                    <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </button>
                                                                                </form>
                                                                            </td>
                                                                        </tr>
                                                                    <script>
                                                                        ubah_status_pekerjaan('pekerjaan_saya_status_<?php echo $value->id_pekerjaan; ?>', <?php echo $value->flag_usulan; ?>, '<?php echo $sekarang; ?>', '<?php echo $value->tgl_mulai; ?>', '<?php echo $value->tgl_selesai; ?>', '<?php echo $value->tgl_read; ?>', '<?php echo $value->status; ?>', <?php echo $value->progress; ?>);
                                                                    </script>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                        <?php } ?>
                                    </div>
<?php if(in_array(2,$data_akun['idmodul'])){?>
                                    <div id="TambahPekerjaan" class="tab-pane">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan" method="POST" action="<?php echo site_url() ?>/pekerjaan/usulan_pekerjaan" enctype="multipart/form-data">
<?php if ($atasan != null || isset($atasan)) { ?>
                                                    <div class="form-group ">
                                                        <label for="atasan" class="control-label col-lg-3">Atasan</label>
                                                        <div class="col-lg-6">

                                                            <select name="atasan" class="form-control m-bot15">

                                                                <?php foreach ($atasan as $value) { ?>              
                                                                    <option value="<?php echo $value->id_akun ?>"><?php echo $value->nama ?> - <?php echo $value->nama_jabatan ?></option>  
    <?php } ?>

                                                            </select>
                                                        </div>
                                                    </div>
<?php } ?>
                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="sifat_pkj2" class="form-control m-bot15">
                                                            <option value="">--Pekerjaan--</option>    
                                                            <option value="1">Personal</option>
                                                            <option value="2">Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="kategori" class="control-label col-lg-3">Kategori Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="kategori" class="form-control m-bot15">
                                                            <option value="project">Project</option>
                                                            <option value="rutin">Rutin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="nama_pkj2" name="nama_pkj2" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pkj2" rows="12"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deadline" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6 ">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input id="dd" readonly type="text" class="form-control dpd3" value="" name="tgl_mulai_pkj2">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input readonly type="text" class="form-control dpd4" value="" name="tgl_selesai_pkj2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                                                    <div class="col-lg-6">
                                                        <select name="prioritas2" class="form-control m-bot15">
                                                            <option value="">--Prioritas--</option>    
                                                            <option value="1">Urgent</option>
                                                            <option value="2">Tinggi</option>
                                                            <option value="3">Sedang</option>
                                                            <option value="4">Rendah</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">File</label>
                                                    <div class="col-lg-6">
                                                        <div id="file_baru">
                                                            <table  class="table table-hover general-table" id="berkas_baru"></table>
                                                        </div>
                                                        <div style="display:none">
                                                            <input type="file" multiple="" name="berkas[]" id="pilih_berkas_assign"/>
                                                        </div>
                                                        <button class="btn btn-primary" type="button" id="button_trigger_file">Pilih File</button>
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
<?php } ?>
                                    
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

            var checkin2 = $('.dpd3').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout2.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout2.setValue(newDate);
                }
                checkin2.hide();
                $('.dpd4')[0].focus();
            }).data('datepicker');
            var checkout2 = $('.dpd4').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() <= checkin2.date.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                checkout2.hide();
            }).data('datepicker');
        });
    </script>

<?php $this->load->view("taskman_footer_page") ?>
    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

    <!-- END JAVASCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            $('#tabel_pkj_saya').dataTable();
            $('#tabel_pkj_saya2').dataTable();
        });
    
<?php if (count($my_staff) > 0) { ?>
    
            var list_nip = [];
            var list_nama = [];
            var list_departemen = [];
            var list_id = [];
            var sudah_diproses = false;
            function query_staff() {
                //var tubuh = $("#tabel_list_enroll_staff_body");

                if (list_id.length === 0) {
                    $.ajax({// create an AJAX call...
                        data: "", // get the form data
                        type: "GET", // GET or POST
                        url: "<?php echo site_url(); ?>/user/my_staff", // the file to call
                        success: function(response) { // on success..
                            var json = jQuery.parseJSON(response);
                            //alert(response);
                            if (json.status === "OK") {
                                var jumlah_data = json.data.length;
                                for (var i = 0; i < jumlah_data; i++) {
                                    //var id = json.data[i]["id_akun"];
                                    list_nip[i] = json.data[i]['nip'];
                                    list_nama[i] = json.data[i]['nama'];
                                    list_departemen[i] = json.data[i]['nama_departemen'];
                                    list_id[i] = json.data[i]["id_akun"];
                                    var id = list_id[i];
                                    sudah_diproses = true;
                                    var cell = $('#nama_staff_' + id);
                                    if (cell.length > 0) {
                                        cell.html(list_nama[i]);
                                    }
                                }
                            } else {
                            }
                        }
                    });
                }
            }
            query_staff();
            var tubuh = $("#tabel_list_enroll_staff_body");
            function tampilkan_staff() {
                if (sudah_diproses === false)
                    query_staff();
                var jumlah_staff = list_id.length;
                //alert("jumlah data" + jumlah_staff)
                tubuh.html("");
                var assigned = $('#staff').val();
                var crow = 0;
                for (var i = 0; i < jumlah_staff; i++) {
                    if (assigned.indexOf('::' + list_id[i] + '::') >= 0)
                        continue;
                    crow++;
                    tubuh.append('<tr id="tabel_list_enroll_staff_row_' + list_id[i] + '"></tr>');
                    var row = $('#tabel_list_enroll_staff_row_' + list_id[i]);
                    row.append('<td>' + crow + '</td>');
                    row.append('<td>' + list_nip[i] + '</td>');
                    row.append('<td>' + list_departemen[i] + '</td>');
                    row.append('<td>' + list_nama[i] + '</td>');
                    //row.append('<td>0</td>');
                    row.append('<td><input type="checkbox" id="enroll_' + list_id[i] + '" name="enroll_' + list_id[i] + '"/></td>');
                    //row.append('<td><div class="minimal-green single-row"><div class="checkbox"><div class="icheckbox_minimal-green checked" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></input><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><label>Green</label></div></div></td>')
                    $('#enroll_' + list_id[i]).attr('checked', false);
                }
                var assigned = $('#staff').val().split('::');
            }
            function pilih_staff_ok() {
                var jumlah_data = list_id.length;
                var staf = $('#staff');
                //staf.val('::');
                //$('#span_list_assign_staff').html('');
                for (var i = 0; i < jumlah_data; i++) {
                    if ($('#enroll_' + list_id[i]).attr('checked')) {
                        staf.val(staf.val() + list_id[i] + '::');
                        $('#span_list_assign_staff').append('<div id="div_staff_' + list_id[i] + '"><span><a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="hapus_staff(' + list_id[i] + ');">Hapus</a></span><span style="margin-left: 5px">' + list_nama[i] + '</span></div>');
                    }
                }
                $('#tombol_tutup').click();
            }
            function hapus_staff(id_staff) {
                $('#div_staff_' + id_staff).remove();
                $('#staff').val($('#staff').val().replace('::' + id_staff, ''));
            }



            document.title = "Task Management - Edit Pekerjaan";

        </script>
<?php } ?>
    <script>
        function pekerjaan_saya_set_nama(id, isi) {
            var sep = '';
            var element = $('#' + id);
            if (element.length > 0) {
                if (element.html().length > 0)
                    sep = ", ";
                element.html(element.html() + sep + isi);
            }
        }
<?php
if (isset($users)) {
    $id_nama_user = array();
    foreach ($users as $user) {
        $id_nama_user[$user->id_akun] = $user->nama;
    }
    if (isset($detil_pekerjaan)) {
        foreach ($detil_pekerjaan as $detil) {
            ?>pekerjaan_saya_set_nama("pekerjaan_nama_staff_<?php echo $detil->id_pekerjaan; ?>", '<?php if (isset($id_nama_user[$detil->id_akun])) echo $id_nama_user[$detil->id_akun]; ?>');
            <?php
        }
    }
}
?>
        $('#button_trigger_file').click(function() {
            console.log('button trigger file click');
            $('#pilih_berkas_assign').click();
        });
        $('#pilih_berkas_assign').change(function() {
            console.log('pilih berkas assign click');
            var pilih_berkas = document.getElementById('pilih_berkas_assign');
            var files = pilih_berkas.files;
            populate_file('berkas_baru', files);
        });
        function populate_file(id_tabel, files) {
            console.log('populating files');
            $('#' + id_tabel).html('');
            var jumlah_file = files.length;
            for (var i = 0; i < jumlah_file; i++) {
                $('#' + id_tabel).append('<tr id="berkas_baru_' + i + '">' +
                        '<td id="nama_berkas_baru_' + i + '">' + files[i].name + ' ' + format_ukuran_file(files[i].size) + '</td>' +
                        '<td id="keterangan_' + i + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px">Baru</a></td>' +
                        '</tr>');
            }
        }
        function format_ukuran_file(s) {
            var KB = 1024;
            var spasi = ' ';
            var satuan = 'bytes';
            if (s > KB) {
                s = s / KB;
                satuan = 'KB';
            }
            if (s > KB) {
                s = s / KB;
                satuan = 'MB';
            }
            return '   [' + Math.round(s) + spasi + satuan + ']';
        }


        document.title = "Pekerjaan Saya - Task Management";
        //$('#submenu_pekerjaan_li').click();
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        //$('#submenu_pekerjaan_ul').css('display','block');
    </script>
