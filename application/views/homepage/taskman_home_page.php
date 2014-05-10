<?php $this->load->view("taskman_header_page") ?> 
<body>
    <section id="container">
        <!--header start-->
        <?php $this->load->view("taskman_header2_page") ?>
        <!--header end-->
        <!--sidebar start-->
        <?php $this->load->view("taskman_sidebarleft_page") ?>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon tar"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($alltask) && $alltask > 0)
                                        echo $alltask;
                                    else
                                        echo '0';
                                    ?></span>
                                All Tasks
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon pink"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($ongoingtask) && $ongoingtask > 0)
                                        echo $ongoingtask;
                                    else
                                        echo '0';
                                    ?></span>
                                On-Going Tasks
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon green"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($finishtask) && $finishtask > 0)
                                        echo $finishtask;
                                    else
                                        echo '0';
                                    ?></span>
                                Finished Tasks
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon orange"><i class="fa fa-tasks"></i></span>
                            <div class="mini-stat-info">
                                <span><?php
                                    if (isset($notworkingtask) && $notworkingtask > 0)
                                        echo $notworkingtask;
                                    else
                                        echo '0';
                                    ?></span>
                                Not Working Yet
                            </div>
                        </div>
                    </div>
                </div>
                <!--mini statistics start-->
                <!--mini statistics end-->
                <div class="row">
                    <div class="col-md-8">
                        <section class="panel">
                            <header class="panel-heading">
                                List of tasks
                            </header>
                            <div class="panel-body">
                                <table class="table table-hover general-table">
                                    <thead>
                                        <tr>
                                            <th> No</th>
                                            <th class="hidden-phone">Pekerjaan</th>
                                            <th>Deadline</th>
                                            <th>Assign To</th>
                                            <th>Status</th>
<!--                                                            <th>Progress</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($pkj_karyawan)) { ?>
                                            <?php
                                            $i = 1;
                                            foreach ($pkj_karyawan as $value) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <a href="#">
                                                            <?php echo $i; ?>
                                                        </a>
                                                    </td>
                                                    <td class="hidden-phone"><?php echo $value->nama_pekerjaan ?></td>
                                                    <td> <?php echo date("d M Y", strtotime($value->tgl_mulai)) ?> - <?php echo date("d M Y", strtotime($value->tgl_selesai)) ?></td>
                                                    <td id="assign_to_<?php echo $value->id_pekerjaan; ?>"></td>
                                                    <td><?php if ($value->flag_usulan == 1) { ?><span class="label label-danger label-mini"><?php echo 'Not Aprroved'; ?></span><?php } else if ($value->flag_usulan == 2) { ?><span class="label label-success label-mini"><?php echo 'Aprroved'; ?></span><?php } else { ?><span class="label label-info label-mini"><?php echo 'On Progress'; ?></span><?php } ?></td>
                                                    <td>
                                                        <form method="get" action="<?php echo site_url() ?>/pekerjaan/deskripsi_pekerjaan">
                                                            <input type="hidden" name="id_detail_pkj" value="<?php echo $value->id_pekerjaan ?>"/>
                                                            <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> View </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <div class="profile-nav alt">
                            <section class="panel">
                                <div class="user-heading alt clock-row terques-bg">
                                    <h4><?php echo date("Y F l d"); ?></h4>
                                    <p class="text-left">Week <?php echo date("W"); ?></p>
                                </div>
                                <ul id="clock">
                                    <li id="sec"></li>
                                    <li id="hour"></li>
                                    <li id="min"></li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script>
        var my_staff = [];
        function get_my_staff() {
            $.ajax({// create an AJAX call...
                type: "get", // GET or POST
                url: "<?php echo base_url(); ?>user/my_staff", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        //alert("aku punya staff");
                        var jumlah_staff = json.data.length;
                        for (var i = 0; i < jumlah_staff; i++) {
                            my_staff.push(json.data[i]);
                        }
                    } else {
                        //alert("aku tidak punya staff");
                    }
                    get_staff_yang_mengerjakan();
                }
            });
        }
        var list_detil_pekerjaan = [];
        function get_staff_yang_mengerjakan() {
            $.ajax({// create an AJAX call...
                data: {list_id_pekerjaan: array_id_pekerjaan},
                type: "post", // GET or POST
                url: "<?php echo base_url(); ?>pekerjaan/get_detil_pekerjaan", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        var jumlah_detil = json.data.length;
                        for (var i = 0; i < jumlah_detil; i++) {
                            list_detil_pekerjaan.push(json.data[i]);
                        }
                    } else {
                    }
                    update_tabel_home();
                }
            });
        }
        get_my_staff();
        var array_id_pekerjaan = [];
<?php
if (isset($pkj_karyawan)) {
    foreach ($pkj_karyawan as $pekerjaan) {
        ?>
                array_id_pekerjaan.push(<?php echo $pekerjaan->id_pekerjaan; ?>);
        <?php
    }
}
?>

        function update_tabel_home() {
            var n = list_detil_pekerjaan.length;
            var m = my_staff.length;
            console.log("list my staff");
            console.log(my_staff);
            for (var i = 0; i < n; i++) {
                var id_akun = list_detil_pekerjaan[i]["id_akun"];
                var id_pekerjaan = list_detil_pekerjaan[i]["id_pekerjaan"];
                //alert(id_akun + " " + id_pekerjaan);
                var isi_lama = $("#assign_to_" + id_pekerjaan).html();
                var nama = "";
                if (id_akun === '<?php echo $data_akun["user_id"]; ?>') {
                    nama = '<?php echo $data_akun["nama"]; ?>';
                } else {
                    for (var x = 0; x < m; x++) {
                        if (my_staff[x]["id_akun"] === id_akun) {
                            nama = my_staff[x]["nama"];
                            break;
                        }
                    }
                }

                if (isi_lama.trim().length > 0) {
                    $("#assign_to_" + id_pekerjaan).html(isi_lama + ", " + nama);
                } else {
                    $("#assign_to_" + id_pekerjaan).html(nama);
                }
            }
        }
document.title="DashBoard - Task Management";
    </script>