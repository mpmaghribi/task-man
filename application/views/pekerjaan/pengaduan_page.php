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
                            <div class="panel-body profile-information">
                                <div class="col-lg-6">
                                    <div class="panel-body">
                                        <form action="<?php echo site_url() ?>pekerjaan/tambah_pengaduan">
                                            <table class="table general-table">
                                                <tr>
                                                    <td>Nama Pengaduan</td>
                                                </tr>
                                                <tr>
                                                    <td><input name="nama_pengaduan" class="form-control" type="text"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Deskripsi Pengaduan</td>
                                                </tr>
                                                <tr>
                                                    <td>
<!--                                                            <input class="form-control" type="text"/>-->
                                                        <textarea name="deskripsi_pengaduan" class="form-control"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Deadline</td>
                                                </tr>
                                                <tr>
                                                    <td><input name="tgl_selesai_pkj" class="form-control" type="text"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Penerima Pekerjaan</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select id="departemen" name="jabatan" class="form-control m-bot15">
                                                            <option value="">Pilih Departemen</option>    
                                                            <option value="1">Teknologi Informasi</option>
                                                            <option value="2">Departemen A</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                            <input type="submit" class="btn btn-lg btn-login btn-block" value="Submit"/>
                                        </form>
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
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    