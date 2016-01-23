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
                                    <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>draft/assign?id_draft=<?php echo $draft['id_pekerjaan']; ?>" id="" style="font-size: 10px">Assign</a>
                                    <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>draft/edit?id_draft=<?php echo $draft['id_pekerjaan']; ?>" id="" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>draft/view?id_draft=<?php echo $draft['id_pekerjaan']; ?>" id="" style="font-size: 10px">View</a>
                                    <a class="btn btn-warning btn-xs" href="javascript:void(0);" id="" onclick="confirm_batal(<?php echo $draft['id_pekerjaan'] ?>, '<?php echo $draft['nama_pekerjaan']; ?>');" style="font-size: 10px">Batalkan</a>
                                </div><script>
                                    var url_hapus = '<?php echo base_url(); ?>draft/batalkan?id_draft=';
                                    function confirm_batal(id_draft, judul) {
                                        var myurl = url_hapus + id_draft;
                                        var c = confirm('apakah anda yakin menghapus draft "' + judul + '"?');
                                        if (c === true) {
                                            window.location = myurl;
                                        }
                                    }
                                </script>
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
                                                    <input type="hidden" value="::" name="staff" id="staff"/>
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
        <!--main content end-->
        <!--right sidebar start-->
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script>
                                                        var list_staff = <?= json_encode($my_staff); ?>;
    </script>
    <script type="text/javascript">
        document.title = "Assign Draft Pekerjaan - Task Management";
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        jQuery(document).ready(function () {
            console.log(list_staff);
            init_list_staff();
        });
        function init_list_staff(){
             
        }
        function query_staff() {
            if (list_id.length === 0) {
                $.ajax({// create an AJAX call...
                    data: "", // get the form data
                    type: "GET", // GET or POST
                    url: "<?php echo site_url(); ?>/user/my_staff", // the file to call
                    success: function (response) { // on success..
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
        //query_staff();
        var tubuh = $("#tabel_list_enroll_staff_body");
        function tampilkan_staff() {
            var jumlah_staff = list_staff.length;
            //alert("jumlah data" + jumlah_staff)
            tubuh.html("");
            var id_staff_assigned = [];
			var list_staff_enrolled = $('.id_staff_enrolled');
			for(var i=0, i2=list_staff_enrolled.length; i<i2; i++){
				var staff_enrolled = list_staff_enrolled[i];
				id_staff_assigned.push(staff_enrolled[id_akun]);
			}
            var crow = 0;
            for (var i = 0; i < jumlah_staff; i++) {
				var staff = list_staff[i];
                if(id_staff_assigned.indexOf(staff["id_akun"])>=0){
					continue;
				}
                
                    tubuh.append('<tr id="tabel_list_enroll_staff_row_' + staff["id_akun"] + '" id_akun="'+staff["id_akun"]+'"></tr>');
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
            //var assigned = $('#staff').val().split('::');
        }
        function pilih_staff_ok() {
            var jumlah_data = list_id.length;
            var staf = $('#staff');
            for (var i = 0; i < jumlah_data; i++) {
                if ($('#enroll_' + list_id[i]).attr('checked')) {
                    staf.val(staf.val() + list_id[i] + '::');
                    $('#tabel_assign_staff').append('<tr id="staff_' + list_id[i] + '">' +
                            '<td id="nama_staff_baru_' + i + '">' + list_nama[i] + '</td>' +
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
    </script>