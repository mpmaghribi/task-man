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
                            <header class="panel-heading">
                                Pekerjaan Staff
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="hidden-phone">NIP Staff</th>
                                                <th class="hidden-phone">Nama Staff</th>
                                                <th class="hidden-phone">Jabatan Staff</th>
                                                <th class="hidden-phone">Departemen</th>
                                                <th class="hidden-phone">Email Staff</th>
                                                <th style="text-align: right"></th>
                                                <th style="text-align: right"></th>
                                                <th style="text-align: right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($my_staff)) {
                                                //var_dump($my_staff);
                                                $counter = 0;
                                                foreach ($my_staff as $staff) {
                                                    $counter++;
                                                    echo '<tr>';
                                                    echo '<td >' . $counter . '</td>';
                                                    echo '<td>' . $staff->nip . '</td>';
                                                    echo '<td>' . $staff->nama . '</td>';
                                                    echo '<td>' . $staff->nama_jabatan . '</td>';
                                                    echo '<td>' . $staff->nama_departemen. '</td>';
                                                    echo '<td>' . $staff->email . '</td>';
                                                    echo '<td ><form method="get" action="' . base_url() . 'pekerjaan/pekerjaan_per_staff"><input type="hidden" name="id_akun" value="' . $staff->id_akun . '"/><button type="submit" class="btn btn-success btn-xs" style="float:right;"><i class="fa fa-eye"></i>View</button></form></td>';
                                                    ?>
                                            
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button"> Download Laporan <span class="caret"></span> </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" id="export<?php echo $staff->id_akun?>" onclick="window.open('<?= site_url('laporan/exportToPDF?id_akun='.$staff->id_akun.'&jabatan='.$staff->nama_jabatan.'&departemen='.$staff->nama_departemen.'&nama='.$staff->nama.'&nip='.$staff->nip.'') ?>', '_blank')" >Download Form SKP</a></li>
                                                    <li><a href="#" id="export<?php echo $staff->id_akun?>" onclick="window.open('<?= site_url('laporan/exportFormCKP?id_akun='.$staff->id_akun.'&jabatan='.$staff->nama_jabatan.'&departemen='.$staff->nama_departemen.'&nama='.$staff->nama.'&nip='.$staff->nip.'') ?>', '_blank')" >Download Form CKP</a></li>
                                                    <li></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button"> Download Laporan Per Periode<span class="caret"></span> </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#exportPeriode" data-toggle="modal"  onclick="exportPeriode('<?php echo $staff->id_akun?>','<?php echo $staff->nama?>','<?php echo $staff->nama_jabatan?>','<?php echo $staff->nama_departemen?>','<?php echo $staff->nip?>')" >Laporan SKP per Periode</a></li>
                                                    <li><a href="#exportPeriode2" data-toggle="modal"  onclick="exportPeriode2('<?php echo $staff->id_akun?>','<?php echo $staff->nama?>','<?php echo $staff->nama_jabatan?>','<?php echo $staff->nama_departemen?>','<?php echo $staff->nip?>')" >Laporan CKP per Periode</a></li>
                                                    <li></li>
                                                </ul>
                                            </div>
                                        </td>
                                                    <?php echo '</tr>';
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
                <div class="modal fade" id="exportPeriode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Pilih Periode Yang Anda Ingin Eksport</h4>
                            </div>
                            <form action="<?php echo site_url()?>laporan/laporan_per_periode" method="GET">
                            <div class="modal-body">

                                    <input type="hidden" id="id_akun" name="id_akun" value="" />
                                    <input type="hidden" id="nama" name="nama" value="" />
                                    <select name="periode" class="form-control m-bot15">
                                        <option value="6">
                                            6 Bulan
                                        </option>
                                        <option value="12">
                                            1 Tahun
                                        </option>
                                    </select>

                                    <input type="hidden" id="nama_jabatan" name="nama_jabatan" value="" />
                                    <input type="hidden" id="nama_departemen" name="nama_departemen" value="" />
                                    <input type="hidden" id="nip" name="nip" value="" />

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                                <button class="btn btn-warning" type="submit"> Export PDF</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exportPeriode2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Pilih Periode Yang Anda Ingin Eksport</h4>
                            </div>
                            <form action="<?php echo site_url()?>laporan/laporan_ckp_per_periode" method="GET">
                            <div class="modal-body">

                                    <input type="hidden" id="id_akun2" name="id_akun2" value="" />
                                    <input type="hidden" id="nama2" name="nama2" value="" />
                                    <select name="periode2" class="form-control m-bot15">
                                        <option value="6">
                                            6 Bulan
                                        </option>
                                        <option value="12">
                                            1 Tahun
                                        </option>
                                    </select>

                                    <input type="hidden" id="nama_jabatan2" name="nama_jabatan2" value="" />
                                    <input type="hidden" id="nama_departemen2" name="nama_departemen2" value="" />
                                    <input type="hidden" id="nip2" name="nip2" value="" />

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                                <button class="btn btn-warning" type="submit"> Export PDF</button>
                            </div>
                            </form>
                        </div>
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
    <script>
        function exportPeriode(id_akun,nama,jabatan,departemen,nip)
        {
            $("#id_akun").val(id_akun);
            $("#nama").val(nama);
            $("#nama_jabatan").val(jabatan);
            $("#nama_departemen").val(departemen);
            $("#nip").val(nip);
        } 
        function exportPeriode2(id_akun,nama,jabatan,departemen,nip)
        {
            $("#id_akun2").val(id_akun);
            $("#nama2").val(nama);
            $("#nama_jabatan2").val(jabatan);
            $("#nama_departemen2").val(departemen);
            $("#nip2").val(nip);
        } 
                </script>
    <script type="text/javascript">
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
        function get_data_pekerjaan_staff() {
            $.ajax({// create an AJAX call...
                data: "", // get the form data                 type: "get", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/data_pekerjaan_staff", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    if (json.status === "OK") {
                        var jumlah_data = json.data.length;
                        var nomor_baris = 1;
                        for (var i = 0; i < jumlah_data; i++) {
                            var html_tabel = "";
                            var id_pekerjaan = json.data[i]["id_pekerjaan"];
                            /* mengecek apakah element dengan id xxx telah ada pada halaman*/
                            if ($("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).length > 0) {
                            } else {/* element dengan id xxx belum ada pada halaman*/
                                /*
                                 * menambahkan row baru tentang suatu pekerjaan
                                 */
                                $("#tabel_pekerjaan_staff").append("<tr id=\"tr_tabel_pekerjaan_staff_" + id_pekerjaan + "\"></tr>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_nomor_" + id_pekerjaan + "\">" + nomor_baris + "</td>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_nama_pekerjaan_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_deadline_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_nama_staff_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_status_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_progress_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_view_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_pekerjaan_staff_" + id_pekerjaan).append("<td id=\"td_tabel_pekerjaan_staff_validasi_" + id_pekerjaan + "\"></td>");
                                nomor_baris++;
                            }
                            /*
                             * mengisi data tiap row
                             */

                            /*mengisi nama pekerjaan */
                            $("#td_tabel_pekerjaan_staff_nama_pekerjaan_" + id_pekerjaan).html(json.data[i]["nama_pekerjaan"]);

                            /*mengisi deadline*/
                            $("#td_tabel_pekerjaan_staff_deadline_" + id_pekerjaan).html(json.data[i]["tgl_mulai"] + " - " + json.data[i]["tgl_selesai"]);

                            /*mengisi list orang yang mengerjakan suatu pekerjaan*/
                            var isi = $("#td_tabel_pekerjaan_staff_nama_staff_" + id_pekerjaan).html();
                            if (isi.length > 0) {
                                isi += ", ";
                            }
                            $("#td_tabel_pekerjaan_staff_nama_staff_" + id_pekerjaan).html(isi + json.data[i]["nama"]);

                            /*mengisi status pengerjaan pekerjaan*/
                            var status = "";
                            status += "<span class=\"label label-";
                            if (json.data[i]["flag_usulan"] === "1") {
                                status += "default label-mini\">";
                                if (json.data[i]["status"] === null || json.data[i]["status"].trim().length === 0) {
                                    status += "Not Approved";
                                } else {
                                    status += json.data[i]["status"];
                                }
                            }
                            else if (json.data[i]["flag_usulan"] === "2") {
                                //status += "success label-mini\">Approved";
                                var sekarang = json.data[i]["sekarang"];
                                /*if (json.data[i]["tgl_read"] === null) {
                                 status += "success label-mini\">Belum Dibaca";
                                 }
                                 else {*/

                                if (sekarang <= json.data[i]["tgl_selesai"]) {
                                    if (json.data[i]["tgl_read"] === null) {
                                        status += "primary label-mini\">";
                                        if (json.data[i]["status"] === null || json.data[i]["status"].trim().length === 0) {
                                            status += "Belum Dibaca";
                                        } else {
                                            status += json.data[i]["status"];
                                        }
                                    }
                                    else {
                                        if (json.data[i]["progress"] === "0") {
                                            status += "info label-mini\">";
                                            if (json.data[i]["status"] === null || json.data[i]["status"].trim().length === 0) {
                                                status += "Sudah Dibaca";
                                            } else {
                                                status += json.data[i]["status"];
                                            }
                                        } else if (json.data[i]["progress"] === "100") {
                                            status += "success label-mini\">";
                                            if (json.data[i]["status"] === null || json.data[i]["status"].trim().length === 0) {
                                                status += "Selesai";
                                            } else {
                                                status += json.data[i]["status"];
                                            }
                                        } else {
                                            status += "inverse label-mini\">";
                                            if (json.data[i]["status"] === null || json.data[i]["status"].trim().length === 0) {
                                                status += "Dikerjakan";
                                            } else {
                                                status += json.data[i]["status"];
                                            }
                                        }
                                    }
                                }
                                else if (json.data[i]["progress"] !== "100") {
                                    status += "danger label-mini\">Terlambat";
                                }
                                /*}*/
                            }
                            status += "</span>";
                            $("#td_tabel_pekerjaan_staff_status_" + id_pekerjaan).html(status);

                            /*mengisi progress*/
                            var pemisah = "style=\"margin-top:5px\"";
                            isi = $("#td_tabel_pekerjaan_staff_progress_" + id_pekerjaan).html();
                            if (isi.length > 0) {
                                pemisah = "style=\"margin-top:25px\"";
                            }
                            var progress = "<div class=\"progress progress-striped progress-xs\" " + pemisah + ">" +
                                    "<div style=\"width: " + json.data[i]["progress"] + "%\" aria-valuemax=\"100\" aria-valuemin=\"0\" aria-valuenow=\"" + json.data[i]["progress"] + "\" role=\"progressbar\" class=\"progress-bar progress-bar-danger\">" +
                                    "<span class=\"sr-only\">" + json.data[i]["progress"] + "% Complete (success)</span>" +
                                    "</div>" +
                                    "</div>";
                            //alert(progress);
                            $("#td_tabel_pekerjaan_staff_progress_" + id_pekerjaan).html(isi + progress);

                            /*tombol view*/
                            $("#td_tabel_pekerjaan_staff_view_" + id_pekerjaan).html("<form method=\"get\" action=\"<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan\">" +
                                    "<input type=\"hidden\" name=\"id_detail_pkj\" value=\"" + id_pekerjaan + "\"/>" +
                                    "<button type=\"submit\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-eye\"></i> View </button>" +
                                    "</form>");

                            /*tombol validasi pekerjaan yg berstatus diajukan*/
                            if (json.data[i]["flag_usulan"] === "1") {
                                $("#td_tabel_pekerjaan_staff_validasi_" + id_pekerjaan).html("<button id=\"validasi" + id_pekerjaan + "\" type=\"button\" class=\"btn btn-default btn-xs\" onclick=\"validasi(" + id_pekerjaan + ")\"><i class=\"fa fa-eye\"> OK</i> </button>");
                            }
                        }
                    } else {
                    }
                }
            });
        }
        get_data_pekerjaan_staff();
        document.title = "Daftar Pekerjaan Staff - Task Management";
    </script>
