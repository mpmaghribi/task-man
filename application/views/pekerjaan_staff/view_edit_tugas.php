<?php
$this->load->view("taskman_header_page");
?> 
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
                                                    <button data-dismiss="modal" class="btn btn-default" type="button">Tutup</button>
                                                    <button class="btn btn-success" type="button" onclick="pilih_staff_ok();">Pilih Staff</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div_skp" class="tab-pane active">
                                        
                                        <div class="form">
                                            <form class="cmxform form-horizontal " id="form_edit_tugas" method="POST" action="<?php echo site_url() ?>/pekerjaan_staff/update_tugas" enctype="multipart/form-data">
                                                <input type="hidden" name="id_tugas" value="<?=$tugas['id_assign_tugas']?>"/>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Periode</label>
                                                    <div class="col-lg-6" id="">
                                                        <select class="form-control" id="tugas_select_periode" name="periode">
                                                            <?php
                                                            $tahun_max = max(array($tahun_max, $tugas['periode']));
                                                            $tahun_min = min(array($tahun_min, $tugas['periode']));
                                                            for ($i = $tahun_max; $i >= $tahun_min; $i--) {
                                                                echo '<option value="' . $i . '"' . ($i == $tugas['periode'] ? ' selected="" ' : '') . '>' . $i . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Pekerjaan</label>
                                                    <div class="col-lg-6" id="">
                                                        <select class="form-control" id="tugas_select_pekerjaan" name="id_pekerjaan">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="staff" class="control-label col-lg-3">Staff</label>
                                                    <div class="col-lg-6">
                                                        <div id="span_list_assign_staff">
                                                            <table id="tabel_assign_staff_tugas" class="table table-hover general-table">
                                                            </table>
                                                        </div>
                                                        <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff_tugas();">Tambah Staff</a>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="deskripsi_pkj" rows="12"><?= $tugas['deskripsi'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group " >
                                                    <label for="prioritas" class="control-label col-lg-3">Deadline</label>
                                                    <div class="col-lg-6" id="div_periode_tanggal">
                                                        <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                                                            <input readonly type="text" class="form-control" value="<?= $tugas['tanggal_mulai2'] ?>" name="tgl_mulai" id="tugas_tanggal_mulai">
                                                            <span class="input-group-addon">Sampai</span>
                                                            <input readonly type="text" class="form-control" value="<?= $tugas['tanggal_selesai2'] ?>" name="tgl_selesai" id="tugas_tanggal_selesai">
                                                        </div>
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
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/date_picker_init.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js2/pekerjaan_staff/js_view_pekerjaan_staff.js"></script>

    <script >
                                                            var list_staff = <?php echo json_encode($users) ?>;
                                                            var pekerjaan =<?= json_encode($pekerjaan) ?>;
                                                            var detil_pekerjaan =<?= json_encode($detil_pekerjaan) ?>;
                                                            var site_url = '<?= site_url() ?>';
                                                            var tugas=<?=  json_encode($tugas)?>;
                                                            $(document).ready(function () {
                                                                var p = pekerjaan;
                                                                var tanggal_bawah_arr = p['tanggal_mulai'].split('-');
                                                                var tanggal_atas_arr = p['tanggal_selesai'].split('-');
                                                                var tanggal_bawah = new Date(parseInt(tanggal_bawah_arr[0]), parseInt(tanggal_bawah_arr[1]) - 1, parseInt(tanggal_bawah_arr[2]));
//                                                                console.log('tanggal bawah = ' + tanggal_bawah);
                                                                var tanggal_atas = new Date(parseInt(tanggal_atas_arr[0]), parseInt(tanggal_atas_arr[1]) - 1, parseInt(tanggal_atas_arr[2]));
                                                                console.log('tanggal atas = ' + tanggal_atas);
//                                                                $('#tugas_tanggal_mulai').val(tanggal_bawah_arr[2] + '-' + tanggal_bawah_arr[1] + '-' + tanggal_bawah_arr[0]);
//                                                                $('#tugas_tanggal_selesai').val(tanggal_atas_arr[2] + '-' + tanggal_atas_arr[1] + '-' + tanggal_atas_arr[0]);
                                                                var tanggal_mulai = $('#tugas_tanggal_mulai').datepicker({
                                                                    format: 'dd-mm-yyyy',
                                                                    onRender: function (date) {
                                                                        return  tanggal_bawah > date || date > tanggal_atas ? 'disabled' : '';
                                                                    }
                                                                }).on('changeDate', function (ev) {
                                                                    tanggal_selesai.setValue(new Date(ev.date));
                                                                    tanggal_mulai.hide();
//        tanggal_selesai.click();
                                                                    $('#tugas_tanggal_selesai').focus();
                                                                }).data('datepicker');

                                                                var tanggal_selesai = $('#tugas_tanggal_selesai').datepicker({
                                                                    format: 'dd-mm-yyyy',
                                                                    onRender: function (date) {
                                                                        return tanggal_bawah > date || date > tanggal_atas || tanggal_mulai.date > date ? 'disabled' : '';
                                                                    }
                                                                }).on('changeDate', function (ev) {
                                                                    tanggal_selesai.hide();
                                                                }).data('datepicker');
                                                            });
                                                            list_detil_pekerjaan[pekerjaan['id_pekerjaan']] = [];
                                                            for (var i = 0, i2 = detil_pekerjaan.length; i < i2; i++) {
                                                                var dp = detil_pekerjaan[i];
                                                                list_detil_pekerjaan[pekerjaan['id_pekerjaan']].push(dp);
                                                            }
                                                            var list_id_terlibat2 = JSON.parse(tugas['id_akun'].replace('{', '[').replace('}', ']'));
                                                            query_staff();
                                                            for (var i = 0, i2 = list_id_terlibat2.length; i < i2; i++) {
                                                                var id_terlibat2 = list_id_terlibat2[i];
                                                                var nama='';
                                                                for (var j = 0, j2 = list_id.length; j < j2; j++) {
                                                                    if(id_terlibat2==list_id[j]){
                                                                        nama=list_nama[j];
                                                                        break;
                                                                    }
                                                                }
                                                                enroll_staff(id_terlibat2,nama,'tugas');
                                                            }

    </script>