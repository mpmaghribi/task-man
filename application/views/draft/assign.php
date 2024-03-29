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
                            <header class="panel-heading  ">
                                Assign Draft
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -5px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-info btn-xs" href="<?php echo site_url(); ?>draft/assign?id_draft=<?php echo $draft['id_pekerjaan']; ?>" style="font-size: 10px">Assign</a>
                                    <a class="btn btn-warning btn-xs" href="<?php echo site_url(); ?>draft/edit?id_draft=<?php echo $draft['id_pekerjaan']; ?>" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-success btn-xs" href="<?php echo site_url(); ?>draft/view?id_draft=<?php echo $draft['id_pekerjaan']; ?>"  style="font-size: 10px">View</a>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="dialog_batalkan_draft();" style="font-size: 10px">Batalkan</button>
                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="" class="tab-pane active">
                                        <section class="panel" >
                                        </section>
                                        <div class="col-md-7">
                                            <section class="panel">
                                                <form method="post" action="<?php echo base_url() ?>draft/do_assign">
                                                    <input type="hidden" name="id_draft" value="<?php echo $draft['id_pekerjaan']; ?>"/>
                                                    <h4 style="color: #1FB5AD;">
                                                        Tambahkan Staff
                                                    </h4>
                                                    <div id="div_staff">
                                                        <table id="tabel_assign_staff" class="table table-hover general-table"></table>
                                                    </div>
                                                    <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff();">Tambah Staff</a>
                                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                                </form>
                                            </section>
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
                                    <?php $this->load->view('draft/detail_view'); ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <div class="modal fade" id="modal_any" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modal_any_title">Modal Title</h4>
                    </div>
                    <div class="form modal-body" id="modal_any_body">
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button" id="modal_any_button_cancel">Cancel</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button" id="modal_any_button_ok">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!--main content end-->
        <!--right sidebar start-->
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script>
                                                        var list_staff = <?= json_encode($my_staff); ?>;
                                                        var pekerjaan = <?= json_encode($draft); ?>;
                                                        var site_url = '<?= site_url(); ?>';
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            console.log(list_staff);
            document.title = "Assign Draft Pekerjaan - Task Management";
            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        });
        function dialog_batalkan_draft() {
            $('#modal_any').modal('show');
            $('#modal_any_title').html('Konfirmasi Pembatalan Draft Pekerjaan');
            $('#modal_any_body').html('<h5>Anda akan membatalkan draft pekerjaan <strong>' + pekerjaan['nama_pekerjaan'] + '</strong>. Lanjutkan?</h5>');
            $('#modal_any_button_cancel').attr({'class': 'btn btn-warning'}).html('Tutup');
            $('#modal_any_button_ok').attr({'class': 'btn btn-danger', 'onclick': 'batalkan_draft()'}).html('Batalkan');
        }
        function batalkan_draft() {
            var form = $('<form></form>').attr({
                'method': 'get',
                'action': site_url + '/draft/batalkan'
            });
            var id_draft = $('<input></input>').attr({'name': 'id_draft', 'value': pekerjaan['id_pekerjaan']});
            form.append(id_draft);
            $('body').append(form);
            form.submit();
        }
        var tubuh = $("#tabel_list_enroll_staff_body");
        function tampilkan_staff() {
            var jumlah_staff = list_staff.length;
            tubuh.html("");
            var id_staff_assigned = [];
            var list_staff_enrolled = $('.id_staff_enrolled');
            for (var i = 0, i2 = list_staff_enrolled.length; i < i2; i++) {
                var staff_enrolled = list_staff_enrolled[i];
                id_staff_assigned.push(staff_enrolled.value);
            }
            console.log(id_staff_assigned);
            var crow = 0;
            for (var i = 0; i < jumlah_staff; i++) {
                var staff = list_staff[i];
                if (id_staff_assigned.indexOf(staff["id_akun"]) >= 0) {
                    continue;
                }
                tubuh.append('<tr id="tabel_list_enroll_staff_row_' + staff["id_akun"] + '" id_akun="' + staff["id_akun"] + '"></tr>');
                var row = $('#tabel_list_enroll_staff_row_' + staff["id_akun"]);
                row.append('<td>' + crow + '</td>');
                row.append('<td>' + staff["nip"] + '</td>');
                row.append('<td>' + staff["nama_departemen"] + '</td>');
                row.append('<td>' + staff["nama"] + '</td>');
                //row.append('<td>0</td>');
                row.append('<td><input type="checkbox" id="enroll_' + staff["id_akun"] + '" value="' + staff["id_akun"] + '"/></td>');
                //row.append('<td><div class="minimal-green single-row"><div class="checkbox"><div class="icheckbox_minimal-green checked" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></input><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div><label>Green</label></div></div></td>')
                $('#enroll_' + staff["id_akun"]).attr('checked', false);

            }
        }
        function pilih_staff_ok() {
            var jumlah_data = list_staff.length;
            var staf = $('#staff');
            for (var i = 0; i < jumlah_data; i++) {
                var staff = list_staff[i];
                if ($('#enroll_' + staff["id_akun"]).is(':checked')) {
                    $('#tabel_assign_staff').append('<tr>' +
                            '<td>' + staff["nama"] + '<input type="hidden" class="id_staff_enrolled" value="' + staff["id_akun"] + '" name="id_akun[]"/></td>' +
                            '<td style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px" onclick="hapus_staff(this)">Hapus</a></td>' +
                            '</tr>');
                }
            }
            $('#tombol_tutup').click();
        }
        function hapus_staff(button_element) {
            var tr = button_element.parentNode.parentNode;
            tr.remove();
        }
    </script>