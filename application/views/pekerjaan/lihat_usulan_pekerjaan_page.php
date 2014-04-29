
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
                                Usulan Pekerjaan
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table  table-hover general-table" id="tabel_usulan_pekerjaan">
                                        <thead>
                                            <tr>
                                                <th> No</th>
                                                <th class="hidden-phone">Pekerjaan</th>
                                                <th>Deadline</th>
                                                <th>Assign To</th>
                                                <th>Status</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 0;
                                            if (isset($list_usulan)) {
                                                foreach ($list_usulan as $usulan) {
                                                    $counter++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $usulan->nama_pekerjaan; ?></td>
                                                        <td><?php echo $usulan->tgl_mulai . " - " . $usulan->tgl_selesai; ?></td>
                                                        <td><?php echo $usulan->nama; ?></td>
                                                        <td id="td_flag_<?php echo $usulan->id_pekerjaan; ?>"><?php if ($usulan->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($usulan->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
                                                        <td>
                                                            <form method="POST" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                <input type="hidden" name="id_detail_pkj" value="<?php echo $usulan->id_pekerjaan ?>"/>
                                                                <button type="submit" class="btn btn-success"><i class="fa fa-eye"></i> View </button>
                                                            </form>
                                                        </td>
                                                        <td id="td<?php echo $usulan->id_pekerjaan; ?>">
                                                            <button id="validasi<?php echo $usulan->id_pekerjaan; ?>" type="button" class="btn btn-default" onclick="validasi(<?php echo $usulan->id_pekerjaan; ?>);"><i class="fa fa-eye"> OK</i> </button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            if ($counter == -1) {
                                                ?>
                                                <tr>
                                                    <td colspan="7" style="text-align: center">Tidak ada pekerjaan yang diusulkan</td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <script>
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
                                    $("#td_tabel_usulan_pekerjaan_validasi_" + id_pekerjaan).css("display", "none");
                                    $('#td_tabel_usulan_pekerjaan_status_' + id_pekerjaan).html("<span class=\"label label-success label-mini\">Aprroved</span>");
                                } else {
                                    alert("validasi gagal, " + json.reason);
                                }
                            }
                        });
                    }
                </script>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script>
        function get_data_usulan_pekerjaan() {
            $.ajax({// create an AJAX call...
                data: "", // get the form data
                type: "get", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/get_usulan_pekerjaan", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    if (json.status === "OK") {
                        var jumlah_data = json.data.length;
                        var nomor_baris = 1;
                        for (var i = 0; i < jumlah_data; i++) {
                            var html_tabel = "";
                            var id_pekerjaan = json.data[i]["id_pekerjaan"];
                            /* mengecek apakah element dengan id xxx telah ada pada halaman*/
                            if ($("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).length > 0) {
                            } else {/* element dengan id xxx belum ada pada halaman*/
                                $("#tabel_usulan_pekerjaan").append("<tr id=\"tr_tabel_usulan_pekerjaan_" + id_pekerjaan + "\"></tr>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_nomor_" + id_pekerjaan + "\">" + nomor_baris + "</td>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_nama_pekerjaan_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_deadline_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_nama_staff_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_status_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_progress_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_view_" + id_pekerjaan + "\"></td>");
                                $("#tr_tabel_usulan_pekerjaan_" + id_pekerjaan).append("<td id=\"td_tabel_usulan_pekerjaan_validasi_" + id_pekerjaan + "\"></td>");
                                nomor_baris++;
                            }
                            $("#td_tabel_usulan_pekerjaan_nama_pekerjaan_" + id_pekerjaan).html(json.data[i]["nama_pekerjaan"]);
                            $("#td_tabel_usulan_pekerjaan_deadline_" + id_pekerjaan).html(json.data[i]["tgl_mulai"] + " - " + json.data[i]["tgl_selesai"]);
                            var isi = $("#td_tabel_usulan_pekerjaan_nama_staff_" + id_pekerjaan).html();
                            if (isi.length > 0) {
                                isi += ", ";
                            }
                            $("#td_tabel_usulan_pekerjaan_nama_staff_" + id_pekerjaan).html(isi + json.data[i]["nama"]);
                            var status = "";//$("#td_tabel_pekerjaan_staff_status_" + id_pekerjaan).html();

                            status += "<span class=\"label label-";
                            if (json.data[i]["flag_usulan"] === "1")
                                status += "danger label-mini\">Not Approved";
                            else
                                status += "success label-mini\">Approved";

                            status += "</span>";
                            $("#td_tabel_usulan_pekerjaan_status_" + id_pekerjaan).html(status);
                            var pemisah = "style=\"margin-top:5px\"";
                            isi = $("#td_tabel_usulan_pekerjaan_progress_" + id_pekerjaan).html();
                            if (isi.length > 0) {
                                pemisah = "style=\"margin-top:25px\"";
                            }
                            var progress = "<div class=\"progress progress-striped progress-xs\" " + pemisah + ">" +
                                    "<div style=\"width: " + json.data[i]["progress"] + "%\" aria-valuemax=\"100\" aria-valuemin=\"0\" aria-valuenow=\"" + json.data[i]["progress"] + "\" role=\"progressbar\" class=\"progress-bar progress-bar-danger\">" +
                                    "<span class=\"sr-only\">" + json.data[i]["progress"] + "% Complete (success)</span>" +
                                    "</div>" +
                                    "</div>";
                            //alert(progress);
                            $("#td_tabel_usulan_pekerjaan_progress_" + id_pekerjaan).html(isi + progress);
                            $("#td_tabel_usulan_pekerjaan_view_" + id_pekerjaan).html("<form method=\"get\" action=\"<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan\">" +
                                    "<input type=\"hidden\" name=\"id_detail_pkj\" value=\"" + id_pekerjaan + "\"/>" +
                                    "<button type=\"submit\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-eye\"></i> View </button>" +
                                    "</form>");
                            if (json.data[i]["flag_usulan"] === "1") {
                                $("#td_tabel_usulan_pekerjaan_validasi_" + id_pekerjaan).html("<button id=\"validasi" + id_pekerjaan + "\" type=\"button\" class=\"btn btn-default btn-xs\" onclick=\"validasi(" + id_pekerjaan + ")\"><i class=\"fa fa-eye\"> OK</i> </button>");
                            }
                        }
                        if (jumlah_data === 0) {
                            $("#tabel_usulan_pekerjaan").append("<tr><td colspan=\"7\" style=\"text-align: center\">Tidak ada pekerjaan yang diusulkan</td></tr>");
                        }
                    } else {
                    }
                }
            });
        }
        get_data_usulan_pekerjaan();
    </script>
