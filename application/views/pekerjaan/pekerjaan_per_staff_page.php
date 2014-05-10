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
                            <header class="panel-heading" id="header_pekerjaan_staff">
                                Daftar Pekerjaan <?php echo $nama_staff ?>
                            </header>
                            <div class="panel-body">
                                <div class="form">
                                    <table class="table  table-hover general-table" id="tabel_pekerjaan_staff">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <td>Nama Pekerjaan</td>
                                                <th>Deadline</th>
                                                <th>Assign To</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 0;
                                            foreach ($pekerjaan_staff as $pekerjaan) {
                                                $counter++;
                                                ?><tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $pekerjaan->nama_pekerjaan; ?></td>
                                                    <td><?php echo $pekerjaan->tgl_mulai . ' - ' . $pekerjaan->tgl_selesai; ?></td>
                                                    <td id="assigh_to_<?php echo $pekerjaan->id_pekerjaan; ?>"></td>
                                                    <td>status</td>
                                                    <td></td>
                                                </tr><?php
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
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script>
        document.title = "Daftar Pekerjaan <?php echo $nama_staff; ?> - Task Management";
        var my_staff = jQuery.parseJSON('<?php echo $my_staff; ?>');
        var detil_pekerjaan = jQuery.parseJSON('<?php echo $detil_pekerjaan; ?>');
        var jumlah_detil = detil_pekerjaan.length;
        var jumlah_staff= my_staff.length;
        for(var i=0;i<jumlah_detil;i++){
            var cell = $('#assigh_to_'+detil_pekerjaan[i]['id_pekerjaan']);
            if(cell.length>0){
                var nama_staff = '';
                for(var j=0;j<jumlah_staff;j++){
                    if(my_staff[j]['id_akun']==detil_pekerjaan[i]['id_akun'])
                    {
                        nama_staff=my_staff[j]['nama'];
                        break;
                    }
                }
                if(cell.html()>0){
                    cell.html(cell.html()+', '+nama_staff);
                }else{
                    cell.html(nama_staff);
                }
            }
        }
    </script>