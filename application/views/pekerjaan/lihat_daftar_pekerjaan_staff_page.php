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
                                        <a data-toggle="tab" href="#PekerjaanStaff">Pekerjaan Staff</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#assignPekerjaan">Assign Pekerjaan</a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="modal fade" id="modalTambahStaff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="width: 1000px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="tombol_tutup">&times;</button>
                                                    <h4 class="modal-title">Tambahkan Staff</h4>
                                                </div>
                                                <div class="modal-body" id="tambahkan_staff_body">
                                                    <table id="tabel_list_enroll_staff" class="table table-hover general-table">
                                                        <thead id="tabel_list_enroll_staff_head">
                                                            <tr id="tabel_list_enroll_staff_head">
                                                                <th>No</th>
                                                                <th>NIP</th>
                                                                <th>Departemen</th>
                                                                <th>Nama</th>
                                                                <th>Enroll</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_list_enroll_staff_body">                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                    <button class="btn btn-success" type="button" onclick="pilih_staff_ok();">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="assignPekerjaan" class="tab-pane">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo base_url() ?>pekerjaan/usulan_pekerjaan2" enctype="multipart/form-data">
                                                <input type="hidden" name="jenis_usulan" value="usulan"/>
                                                <div class="form-group ">
                                                    <label for="staff" class="control-label col-lg-3">Staff</label>
                                                    <div class="col-lg-6">
                                                        <div id="span_list_assign_staff">
                                                            <table id="tabel_assign_staff" class="table table-hover general-table">

                                                            </table>
                                                        </div>
                                                        <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff();">Tambah Staff</a>
                                                        <input type="hidden" value="::" name="staff" id="staff"/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="sifat_pkj" class="form-control m-bot15">
                                                            <option value="1" >Personal</option>
                                                            <option value="2" >Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="kategori" class="control-label col-lg-3">Kategori</label>
                                                    <div class="col-lg-6">
                                                        <select name="kategori" class="form-control m-bot15">
                                                            <option value="rutin">Rutin</option>
                                                            <option value="project">Project</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="firstname" name="nama_pkj" type="text" value=""/>
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
                                                            <option value="1" >Urgent</option>
                                                            <option value="2" >Tinggi</option>
                                                            <option value="3" >Sedang</option>
                                                            <option value="4" >Rendah</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">File</label>
                                                    <div class="col-lg-6">
                                                        <div id="list_file_upload_assign">
                                                            <div id="file_baru">
                                                                <table  class="table table-hover general-table" id="berkas_baru"></table>
                                                            </div>
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
                                    <div id="PekerjaanStaff" class="tab-pane active">
                                        <section class="panel">
                                            <header class="panel-heading">
                                                Daftar Staff
                                            </header>
                                            <div class="panel-body">
                                                <div class="form">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                                                        <thead>
                                                            <tr>
                                                                <th style="min-width: 45px">No</th>
                                                                <th class="hidden-phone" style="min-width: 80px">NIP Staff</th>
                                                                <th class="hidden-phone">Nama Staff</th>
                                                                <th class="hidden-phone">Jabatan Staff</th>
                                                                <th class="hidden-phone" style="min-width: 100px; width: 150px">Departemen</th>
                                                                <th class="hidden-phone">Email Staff</th>
                                                                <th style="text-align: right;width: 80px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($my_staff)) {
                                                                $has_listed = array();
                                                                //var_dump($my_staff);
                                                                $counter = 0;
                                                                foreach ($my_staff as $staff) {
                                                                    if (in_array($staff->id_akun, $has_listed))
                                                                        continue;
                                                                    $has_listed[] = $staff->id_akun;
                                                                    $counter++;
                                                                    ?>
                                                                    <tr>
                                                                        <td style="text-align: right"><?= $counter ?></td>
                                                                        <td><?= $staff->nip ?></td>
                                                                        <td><?= $staff->nama ?></td>
                                                                        <td><?= $staff->nama_jabatan ?></td>
                                                                        <td><?= $staff->nama_departemen ?></td>
                                                                        <td><?= $staff->email ?></td>
                                                                        <td><a class="btn btn-success btn-xs" href="<?= base_url() ?>pekerjaan/pekerjaan_per_staff?id_akun=<?= $staff->id_akun ?>"/><i class="fa fa-eye"></i>View</a></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
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
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

        <!-- END JAVASCRIPTS -->
        <?php $this->load->view('taskman_rightbar_page'); ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page"); ?>
    <script type="text/javascript">
                                                            $(function () {
                                                                var nowTemp = new Date();
                                                                var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
                                                                var checkin = $('.dpd1').datepicker({
                                                                    format: 'dd-mm-yyyy',
                                                                    onRender: function (date) {
                                                                        return date.valueOf() < now.valueOf() ? 'disabled' : '';
                                                                    }
                                                                }).on('changeDate', function (ev) {
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
                                                                    onRender: function (date) {
                                                                        return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                                                                    }
                                                                }).on('changeDate', function (ev) {
                                                                    checkout.hide();
                                                                }).data('datepicker');
                                                                $('#tabel_pekerjaan_staff').dataTable({
                                                                    "iDisplayLength": 5,
                                                                    "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                                                                });
                                                            });
                                                            function validasi(id_pekerjaan) {
                                                                //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                                                                $.ajax({// create an AJAX call...
                                                                    data: "id_pekerjaan=" + id_pekerjaan, // get the form data
                                                                    type: "POST", // GET or POST
                                                                    url: "<?php echo site_url(); ?>/pekerjaan/validasi_usulan", // the file to call
                                                                    success: function (response) { // on success..
                                                                        var json = jQuery.parseJSON(response);
                                                                        //alert(response);
                                                                        if (json.status === "OK") {
                                                                            $("#validasi" + id_pekerjaan).css("display", "none");
                                                                            $('#td_tabel_pekerjaan_staff_status_' + id_pekerjaan).html("<span class=\"label label-success label-mini\">Aprroved</span>");
                                                                        } else {
                                                                            alert("validasi gagal, " + json.reason);
                                                                        }
                                                                    }
                                                                });
                                                            }

                                                            document.title = "Daftar Pekerjaan Staff - Task Management";
                                                            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
                                                            var list_nip = [];
                                                            var list_nama = [];
                                                            var list_departemen = [];
                                                            var list_id = [];
                                                            var sudah_diproses = false;
                                                            function query_staff() {
                                                                if (list_id.length === 0) {
//                $.ajax({// create an AJAX call...
//                    data: "", // get the form data
//                    type: "GET", // GET or POST
//                    url: "<?php echo site_url(); ?>/user/my_staff", // the file to call
//                    success: function(response) { // on success..
//                        var json = jQuery.parseJSON(response);
                                                                    var json = jQuery.parseJSON('<?php echo json_encode($my_staff); ?>');
                                                                    //alert(response);
                                                                    //if (json.status === "OK") {
                                                                    var jumlah_data = json.length;
                                                                    for (var i = 0; i < jumlah_data; i++) {
                                                                        //var id = json.data[i]["id_akun"];
                                                                        list_nip[i] = json[i]['nip'];
                                                                        list_nama[i] = json[i]['nama'];
                                                                        list_departemen[i] = json[i]['nama_departemen'];
                                                                        list_id[i] = json[i]["id_akun"];
                                                                        var id = list_id[i];
                                                                        sudah_diproses = true;
                                                                        var cell = $('#nama_staff_' + id);
                                                                        if (cell.length > 0) {
                                                                            cell.html(list_nama[i]);
                                                                        }
                                                                    }
                                                                    //} 
                                                                    //else {
//                        }
//                    }
//                });
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

                                                                    var row_id = 'tabel_list_enroll_staff_row_' + list_id[i];
                                                                    var new_row = true;
                                                                    if ($('#' + row_id).length == 0) {
                                                                        tubuh.append('<tr id="' + row_id + '"></tr>');
                                                                        crow++;
                                                                    } else {
                                                                        new_row = false;
                                                                    }
                                                                    var row = $('#' + row_id);
                                                                    if (new_row) {
                                                                        row.append('<td>' + crow + '</td>');
                                                                        row.append('<td>' + list_nip[i] + '</td>');
                                                                        row.append('<td>' + list_departemen[i] + '</td>');
                                                                        row.append('<td>' + list_nama[i] + '</td>');
                                                                        row.append('<td><input type="checkbox" id="enroll_' + list_id[i] + '" name="enroll_' + list_id[i] + '"/></td>');
                                                                    }
                                                                    //row.append('<td><div class="minimal-green single-row"><div class="checkbox"><div class="icheckbox_minimal-green checked" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></input><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><label>Green</label></div></div></td>')
                                                                    $('#enroll_' + list_id[i]).attr('checked', false);
                                                                }

                                                            }
                                                            function pilih_staff_ok() {
                                                                var jumlah_data = list_id.length;
                                                                var staf = $('#staff');
                                                                //staf.val('::');
                                                                //$('#span_list_assign_staff').html('');
                                                                for (var i = 0; i < jumlah_data; i++) {
                                                                    if ($('#enroll_' + list_id[i]).attr('checked')) {
                                                                        staf.val(staf.val() + list_id[i] + '::');
                                                                        $('#tabel_assign_staff').append('<tr id="staff_' + list_id[i] + '">' +
                                                                                '<td id="nama_staff_' + i + '">' + list_nama[i] + '</td>' +
                                                                                '<td id="aksi_' + list_id[i] + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px" onclick="hapus_staff(' + list_id[i] + ')">Hapus</a></td>' +
                                                                                '</tr>');
                                                                    }
                                                                }
                                                                $('#tombol_tutup').click();
                                                            }
                                                            function hapus_staff(id_staff) {
                                                                $('#staff_' + id_staff).remove();
                                                                $('#staff').val($('#staff').val().replace('::' + id_staff, ''));
                                                            }

                                                            $('#pilih_berkas_assign').change(function () {
                                                                var pilih_berkas = document.getElementById('pilih_berkas_assign');
                                                                var files = pilih_berkas.files;
                                                                populate_file('berkas_baru', files);
                                                            });
                                                            function populate_file(id_tabel, files) {
                                                                $('#' + id_tabel).html('');
                                                                var jumlah_file = files.length;
                                                                for (var i = 0; i < jumlah_file; i++) {
                                                                    $('#' + id_tabel).append('<tr id="berkas_baru_' + i + '">' +
                                                                            '<td id="nama_berkas_baru_' + i + '">' + files[i].name + ' ' + format_ukuran_file(files[i].size) + '</td>' +
                                                                            '<td id="keterangan_' + i + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px">Baru</a></td>' +
                                                                            '</tr>');
                                                                }
                                                            }
                                                            $('#button_trigger_file').click(function () {
                                                                $('#pilih_berkas_assign').click();
                                                            });
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
                                                            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
    </script>