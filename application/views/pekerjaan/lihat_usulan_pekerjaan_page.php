
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
                                    <table class="table  table-hover general-table">
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
                                            if ($counter == 0) {
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
                                    $("#validasi" + id_pekerjaan).css("display", "none");
                                    $('#td_flag_' + id_pekerjaan).html("<span class=\"label label-success label-mini\">Aprroved</span>");
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
    <script type="text/javascript">

    </script>
    <?php $this->load->view("taskman_footer_page") ?>
