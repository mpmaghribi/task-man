
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
                                    <table class="table  table-hover general-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="hidden-phone">Pekerjaan</th>
                                                <th>Deadline</th>
                                                <th>Assign To</th>
                                                <th>Status</th>
                                                <th>Progress</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 0;
                                            $list_id_pekerjaan = "::";
                                            if (isset($list_pekerjaan_staff)) {
                                                foreach ($list_pekerjaan_staff as $pekerjaan) {
                                                    $counter++;
                                                    $list_id_pekerjaan = $list_id_pekerjaan . $pekerjaan->id_pekerjaan . "::";
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $pekerjaan->nama_pekerjaan; ?></td>
                                                        <td><?php echo $pekerjaan->tgl_mulai . " - " . $pekerjaan->tgl_selesai; ?></td>
                                                        <td id="yang_mengerjakan<?php echo $pekerjaan->id_pekerjaan; ?>"></td>
                                                        <td id="td_flag_<?php echo $pekerjaan->id_pekerjaan; ?>"><?php if ($pekerjaan->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($pekerjaan->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
                                                        <td id="progress<?php echo $pekerjaan->id_pekerjaan; ?>">
                                                            <!--div class="progress progress-striped progress-xs">
                                                                <div style="width: <?php echo $pekerjaan->progress; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $pekerjaan->progress; ?>" role="progressbar" class="progress-bar progress-bar-danger">
                                                                    <span class="sr-only"><?php echo $pekerjaan->progress; ?>% Complete (success)</span>
                                                                </div>
                                                            </div-->
                                                        </td>
                                                        <td>
                                                            <form method="get" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                                <input type="hidden" name="id_detail_pkj" value="<?php echo $pekerjaan->id_pekerjaan ?>"/>
                                                                <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </button>
                                                            </form>
                                                        </td>
                                                        <?php if ($pekerjaan->flag_usulan == 1) { ?>
                                                            <td id="td<?php echo $pekerjaan->id_pekerjaan; ?>">
                                                                <button id="validasi<?php echo $pekerjaan->id_pekerjaan; ?>" type="button" class="btn btn-default" onclick="validasi(<?php echo $pekerjaan->id_pekerjaan; ?>);"><i class="fa fa-eye"> OK</i> </button>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            if ($counter == 0) {
                                                ?>
                                                <tr>
                                                    <td colspan="7" style="text-align: center">Tidak ada data pekerjaan</td>
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

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script type="text/javascript">
        var list_id_pekerjaan = "<?php echo $list_id_pekerjaan; ?>";
        var id_pekerjaan_array = list_id_pekerjaan.split("::");
        var jumlah_pekerjaan = id_pekerjaan_array.length;
        for (var i = 0; i < jumlah_pekerjaan; i++) {
            if (id_pekerjaan_array[i].length > 0) {
                //alert(id_pekerjaan_array[i]);
                get_info_progress_staff(id_pekerjaan_array[i]);
            }
        }
        function get_info_progress_staff(id_pekerjaan) {
            $.ajax({// create an AJAX call...
                data: "id_pekerjaan=" + id_pekerjaan, // get the form data
                type: "get", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/get_staff_progress", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        //alert("mengolah untuk id " + id_pekerjaan);
                        var html_nama = "";
                        var html_progress = "";
                        var pemisah = "";
                        var margin = "";
                        var panjang_data = json.data.length;
                        for (var i = 0; i < panjang_data; i++) {
                            html_nama += pemisah + json.data[i]["nama"];
                            html_progress += "<div class=\"progress progress-striped progress-xs\" "+margin+">" +
                                    "<div style=\"width: "+json.data[i]["progress"]+"%\" aria-valuemax=\"100\" aria-valuemin=\"0\" aria-valuenow=\""+json.data[i]["progress"]+"\" role=\"progressbar\" class=\"progress-bar progress-bar-danger\">" +
                                    "<span class=\"sr-only\">"+json.data[i]["progress"]+"% Complete (success)</span>" +
                                    "</div>" +
                                    "</div>";
                            pemisah = "<br/>";
                            margin = "style=\"margin-top:15px\"";
                        }
                        $("#yang_mengerjakan" + id_pekerjaan).html(html_nama);
                        $("#progress"+id_pekerjaan).html(html_progress);
                    } else {
                        //alert("validasi gagal, " + json.reason);
                    }
                }
            });
        }
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
                        $('#td_flag_' + id_pekerjaan).html("<span class=\"label label-success label-mini\">Aprroved</span>");
                    } else {
                        alert("validasi gagal, " + json.reason);
                    }
                }
            });
        }
    </script>
