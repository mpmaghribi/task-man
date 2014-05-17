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
                            <a href="#" onclick="window.print()">Print</a>
                            <a href="#" onclick="window.open('<?= site_url('laporan/exportToPDF') ?>', '_blank')">Lihat sebagai PDF</a>

                            <div class="form">
                                <table class="table table-hover general-table">
                                    <thead>
                                        <tr>
                                            <th> No</th>
                                            <th class="hidden-phone">Pekerjaan</th>
                                            <th>Deadline</th>
                                            <th>Assign To</th>
                                            <th>Status</th>
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
                                                <?php if ($value->flag_usulan == 2) { ?>
                                                    <tr>
                                                        <td>
                                                            <a href="#">
                                                                <?php echo $i; ?>
                                                            </a>
                                                        </td>
                                                        <td class="hidden-phone"><?php echo $value->nama_pekerjaan ?></td>
                                                        <td> <?php echo date("d M Y", strtotime($value->tgl_mulai)) ?> - <?php echo date("d M Y", strtotime($value->tgl_selesai)) ?></td>
                                                        <td id="pekerjaan_nama_staff_<?php echo $value->id_pekerjaan; ?>"></td>
                                                        <td><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>

                                                        <td>
                                                            <form method="get" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                <input type="hidden" name="id_detail_pkj" value="<?php echo $value->id_pekerjaan ?>"/>
                                                                <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
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
            EditableTableProgress.init();
        });
    </script>
    <?php if ($temp['jmlstaff'] > 0) { ?>
        <script>
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

            $('#pilih_berkas_assign').change(function() {
                var pilih_berkas = document.getElementById('pilih_berkas_assign');
                var files = pilih_berkas.files;
                populate_file('list_file_upload_assign', files);
            });
            function populate_file(div_id, files) {
                $('#' + div_id).html('');
                var jumlah_file = files.length;
                for (var i = 0; i < jumlah_file; i++) {
                    $('#' + div_id).append(files[i].name + "<br/>");
                }
            }
            document.title = "Task Management - Edit Pekerjaan";
            var mulai = new Date('<?php echo $pekerjaan[0]->tgl_mulai; ?>');
            var akhir = new Date('<?php echo $pekerjaan[0]->tgl_selesai; ?>');
            //alert (mulai);
            //alert(akhir);
            $('.dpd1').val(mulai.getDate() + '-' + (mulai.getMonth() + 1) + '-' + mulai.getFullYear());
            $('.dpd2').val(akhir.getDate() + '-' + (akhir.getMonth() + 1) + '-' + akhir.getFullYear());
        </script>
    <?php } ?>
    <script>
        var my_staff = jQuery.parseJSON('<?php echo $my_staff; ?>');
        var detil_pekerjaan = jQuery.parseJSON('<?php echo $detil_pekerjaan; ?>');
        var jumlah_staff = my_staff.length;
        var jumlah_detil_pekerjaan = detil_pekerjaan.length;
        for (var i = 0; i < jumlah_detil_pekerjaan; i++) {
            var cell = $("#pekerjaan_nama_staff_" + detil_pekerjaan[i]["id_pekerjaan"]);
            if (cell === null)
                continue;
            var id_akun = detil_pekerjaan[i]["id_akun"];
            var nama_staff = "";
            if (id_akun === '<?php echo $temp["user_id"]; ?>') {
                nama_staff = '<?php echo $temp["nama"]; ?>';
            } else {
                for (var j = 0; j < jumlah_staff; j++) {
                    if (my_staff[j]["id_akun"] === id_akun) {
                        nama_staff = my_staff[j]["nama"];
                        break;
                    }
                }
            }
            //var isi_html = cell.html();
            //console.log(cell);
            if (cell.length > 0 && cell.html().trim().length === 0) {
                cell.html(nama_staff);
            } else if (cell.length > 0) {
                cell.html(cell.html() + ", " + nama_staff);
            }
        }
        $('#pilih_berkas_usul').change(function() {
            var pilih_berkas = document.getElementById('pilih_berkas_usul');
            var files = pilih_berkas.files;
            populate_file('list_file_upload_usul', files);
        });

        function populate_file(div_id, files) {
            $('#' + div_id).html('');
            var jumlah_file = files.length;
            for (var i = 0; i < jumlah_file; i++) {
                //$('#'+div_id).append('<div id="' + div_id + '_file_' + i + '"><span><a class="btn btn-primary btn-xs" href="#" onclick="return hapus_file(\'pilih_berkas_assign\',\'' + div_id + '_file_' + i + '\',\'' + files[i].name + '\');">Hapus</a></span><span style="margin-left: 5px">' + files[i].name + '</span></div>');
                $('#' + div_id).append(files[i].name + "<br/>");
            }
        }
        function hapus_file(file_input_id, div_id, value) {
            var element = document.getElementById(file_input_id);
            //var files = element.files;
            for (var i = element.files.length - 1; i >= 0; i--) {
                if (element.files[i].name === value) {
                    alert('mencoba mengahpus ' + value);
                    element.files.splice(i, 1);
                    console.log(element.files);
                    alert('mengahpus ' + value);
                    populate_file(div_id, element.files)
                    break;
                }
            }
            return false;
        }
        document.title = "Pekerjaan Saya - Task Management";
    </script>