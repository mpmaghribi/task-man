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
                            <header class="panel-heading ">
                                Edit <?php
                                if ($pekerjaan[0]->flag_usulan == '1') {
                                    ?>Usulan<?php } ?> Pekerjaan
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="assignPekerjaan" class="tab-pane active">
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo base_url() ?>pekerjaan/do_edit" enctype="multipart/form-data">
                                                <input type="hidden" name="id_pekerjaan" id="id_pekerjaan" value="<?php echo $pekerjaan[0]->id_pekerjaan; ?>"/>
                                                <?php if ($atasan) { ?><div class="form-group ">
                                                        <label for="staff" class="control-label col-lg-3">Staff</label>
                                                        <div class="col-lg-6">
                                                            <div id="span_list_assign_staff">
                                                                <table id="tabel_assign_staff" class="table table-hover general-table">
                                                                    <?php
                                                                    $list_staff_sudah_ditampilkan = array();
                                                                    foreach ($detail_pekerjaan as $d) {
                                                                        if (in_array($d->id_akun, $list_staff_sudah_ditampilkan))
                                                                            continue;
                                                                        $list_staff_sudah_ditampilkan[] = $d->id_akun;
                                                                        ?>
                                                                        <tr id="staff_<?php echo $d->id_akun; ?>">
                                                                            <td id="nama_staff_<?php echo $d->id_akun; ?>"><div id="nama_<?php echo $d->id_akun; ?>"></div></td> 
                                                                            <td id="aksi_" style="width:10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px" onclick="hapus_staff(<?php echo $d->id_akun; ?>)">Hapus</a></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </table>
                                                            </div>
                                                            <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff();">Tambah Staff</a>
                                                            <input type="hidden" value="::<?php
                                                            $list_staff_sudah_ditampilkan = array();
                                                            foreach ($detail_pekerjaan as $d) {
                                                                if (in_array($d->id_akun, $list_staff_sudah_ditampilkan))
                                                                    continue;
                                                                $list_staff_sudah_ditampilkan[] = $d->id_akun;
                                                                echo $d->id_akun . '::';
                                                            }
                                                            ?>" name="staff" id="staff"/>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="form-group ">
                                                    <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <select name="sifat_pkj" class="form-control m-bot15">
                                                            <option value="1" <?php if ($pekerjaan[0]->id_sifat_pekerjaan == '1') echo 'selected'; ?>>Personal</option>
                                                            <option value="2" <?php if ($pekerjaan[0]->id_sifat_pekerjaan == '2') echo 'selected'; ?>>Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="kategori" class="control-label col-lg-3">Kategori</label>
                                                    <div class="col-lg-6">
                                                        <select name="kategori" id="kategori" class="form-control m-bot15">
                                                            <option value="rutin" <?php echo $pekerjaan[0]->kategori == 'rutin' ? 'selected' : ''; ?>>Rutin</option>
                                                            <option value="project" <?php echo $pekerjaan[0]->kategori == 'project' ? 'selected' : ''; ?>>Project</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                                                    <div class="col-lg-6">
                                                        <input class=" form-control" id="firstname" name="nama_pkj" type="text" value="<?php echo $pekerjaan[0]->nama_pekerjaan; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pkj" rows="12"><?php echo $pekerjaan[0]->deskripsi_pekerjaan; ?></textarea>
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
                                                            <option value="1" <?php if ($pekerjaan[0]->level_prioritas == '1') echo "selected"; ?>>Urgent</option>
                                                            <option value="2" <?php if ($pekerjaan[0]->level_prioritas == '2') echo "selected"; ?>>Tinggi</option>
                                                            <option value="3" <?php if ($pekerjaan[0]->level_prioritas == '3') echo "selected"; ?>>Sedang</option>
                                                            <option value="4" <?php if ($pekerjaan[0]->level_prioritas == '4') echo "selected"; ?>>Rendah</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="prioritas" class="control-label col-lg-3">File</label>
                                                    <div class="col-lg-6">
                                                        <div id="list_file_upload_assign">
                                                            <div id="file_lama">
                                                                <table  class="table table-hover general-table">
                                                                    <?php
                                                                    if (isset($list_berkas)) {
                                                                        foreach ($list_berkas as $berkas) {
                                                                            ?>
                                                                            <tr id="berkas_<?php echo $berkas->id_file; ?>" title="diupload pada <?php echo date("d M Y H:i", strtotime(substr($berkas->waktu,0,19))); ?>">
                                                                                <td id="nama_file_<?php echo $berkas->id_file; ?>"><?php echo basename($berkas->nama_file); ?></td>
                                                                                <td id="aksi_<?php echo $berkas->id_file; ?>" style="width: 10px;text-align:right"><a class="btn btn-danger btn-xs" href="javascript:void(0);" id="" style="font-size: 12px" onclick="hapus_file(<?php echo $berkas->id_file ?>, '<?php echo basename($berkas->nama_file); ?>');">Hapus</a></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </div>
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
    <?php $this->load->view("taskman_footer_page");
    ?>
    <script>
        var list_nip = [];
        var list_nama = [];
        var list_departemen = [];
        var list_id = [];
        var sudah_diproses = false;
<?php
foreach ($users as $user) {
    ?>$('#nama_<?php echo $user->id_akun; ?>').html('<?php echo $user->nip; ?> - <?php echo $user->nama; ?>');<?php
}
?>
        function query_staff() {
            if (list_id.length === 0) {
                var json = jQuery.parseJSON('<?php echo json_encode($my_staff); ?>');
                var jumlah_data = json.length;
                for (var i = 0; i < jumlah_data; i++) {
                    //var id = json.data[i]["id_akun"];
                    list_nip[i] = json[i]["nip"];
                    list_nama[i] = json[i]["nama"];
                    list_departemen[i] = json[i]["nama_departemen"];
                    list_id[i] = json[i]["id_akun"];
                    var id = list_id[i];
                    sudah_diproses = true;
                    //$('#nama_' + id).html(json[i]["nip"] + " - " + json[i]["nama"]);
                }
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
                var row_baru = false;
                if ($('#' + row_id).length == 0) {
                    tubuh.append('<tr id="tabel_list_enroll_staff_row_' + list_id[i] + '"></tr>');
                    row_baru = true;
                    crow++;
                }
                if (row_baru) {
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
            }
            //var assigned = $('#staff').val().split('::');
        }
        function pilih_staff_ok() {
            var jumlah_data = list_id.length;
            var staf = $('#staff');
            //staf.val('::');
            //$('#span_list_assign_staff').html('');
            var list_id_yg_ditambahkan='::';
            for (var i = 0; i < jumlah_data; i++) {
                var check_id = list_id[i]+'::';
                console.log(list_id_yg_ditambahkan);
                console.log(check_id);
                if(list_id_yg_ditambahkan.indexOf(check_id)>=0)
                    continue;
                console.log("processing");
                if ($('#enroll_' + list_id[i]).attr('checked')) {
                    list_id_yg_ditambahkan+=check_id;
                    staf.val(staf.val() + list_id[i] + '::');
                    $('#tabel_assign_staff').append('<tr id="staff_' + list_id[i] + '">' +
                            '<td id="nama_staff_' + list_id[i] + '">' + list_nip[i]+' - ' +list_nama[i] + '</td>' +
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

        $('#pilih_berkas_assign').change(function() {
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
        document.title = "Task Management - Edit Pekerjaan";
<?php
$mulai = date('Y-m-d', strtotime(substr($pekerjaan[0]->tgl_mulai,0,19)));
$akhir = date('Y-m-d', strtotime(substr($pekerjaan[0]->tgl_selesai,0,19)));
?>
        var mulai = new Date('<?php echo $mulai; ?>');
        var akhir = new Date('<?php echo $akhir; ?>');
        $('.dpd1').val(mulai.getDate() + '-' + (mulai.getMonth() + 1) + '-' + mulai.getFullYear());
        $('.dpd2').val(akhir.getDate() + '-' + (akhir.getMonth() + 1) + '-' + akhir.getFullYear());
        console.log(mulai);
        console.log(mulai.getDate());
        console.log(mulai.getMonth());
        console.log(mulai.getFullYear());
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        $('#button_trigger_file').click(function() {
            $('#pilih_berkas_assign').click();
        });
        function hapus_file(id_file, deskripsi)
        {
            var c = confirm("Anda yakin menghapus file " + deskripsi + "?");
            if (c == true) {
                $.ajax({// create an AJAX call...
                    data: {id_file: id_file,
                        id_pekerjaan: $('#id_pekerjaan').val()
                    }, // get the form data
                    type: "get", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/hapus_file", // the file to call
                    success: function(response) { // on success..
                        var json = jQuery.parseJSON(response);
                        //alert(response);
                        if (json.status === "OK") {
                            $('#berkas_' + id_file).remove();
                            //$('#tombol_validasi_usulan').remove();
                        } else {
                            alert("Gagal menghapus file, " + json.reason);
                        }
                    }
                });
            }
            else {
            }
        }
    </script>
    <?php //print_r($mulai);
    ?>