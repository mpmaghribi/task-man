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
                                        <a data-toggle="tab" href="#div_view_draft">Daftar Draft Pekerjaan</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#div_create_draft">Membuat Draft Pekerjaan</a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <?php 
                                    $this->load->view('pekerjaan/draft/view');
                                    $this->load->view('pekerjaan/draft/create');
                                    ?>
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
        <script>
            jQuery(document).ready(function() {
                EditableTableProgress.init();
            });
        </script>
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
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
                        $("#validasi" + id_pekerjaan).css("display", "none");
                        $('#td_tabel_pekerjaan_staff_status_' + id_pekerjaan).html("<span class=\"label label-success label-mini\">Aprroved</span>");
                    } else {
                        alert("validasi gagal, " + json.reason);
                    }
                }
            });
        }
        
        document.title = "Draft Pekerjaan - Task Management";
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        var list_nip = [];
        var list_nama = [];
        var list_departemen = [];
        var list_id = [];
        var sudah_diproses = false;
        function query_staff() {
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
                                var cell = $('#nama_staff_'+id);
                                if(cell.length>0){
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
            var crow=0;
            for (var i = 0; i < jumlah_staff; i++) {
                if(assigned.indexOf('::'+list_id[i]+'::')>=0)
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
            //EditableTableProgress.init();
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
    </script>