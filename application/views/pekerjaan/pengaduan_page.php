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
                <div class="col-lg-12">
                    <section class="panel">
<!--                        <header class="panel-heading">
                            Form Pengaduan
                            <span class="tools pull-right">
                             </span>
                        </header>
                        <div class="panel-body">
                            <div class="form">
                                <form class="cmxform form-horizontal " id="signupForm" method="get" action="">
                                    <div class="form-group ">
                                        <label for="topik_pengaduan" class="control-label col-lg-3">Topik Pengaduan</label>
                                        <div class="col-lg-6">
                                            <input class=" form-control" id="topik_pengaduan" name="topik_pengaduan" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="isi_pengaduan" class="control-label col-lg-3">Isi Pengaduan</label>
                                        <div class="col-lg-6">
                                            <textarea class=" form-control" id="isi_pengaduan" name="isi_pengaduan" rows="12">
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="tgl_pengaduan" class="control-label col-lg-3">Tanggal Pengaduan</label>
                                        <div class="col-lg-6">
                                            <input readonly="true" class="form-control " id="tgl_pengaduan" name="tgl_pengaduan" type="text" value="<?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d H:i:s")?>" />
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="urgensitas" class="control-label col-lg-3">Rekomendasi Urgensitas</label>
                                        <div class="col-lg-6">
                                            <select name="urgensitas" class="form-control m-bot15">
                                                <option value="rendah">
                                                    Rendah
                                                </option>
                                                <option value="sedang">
                                                    Sedang
                                                </option>
                                                <option value="tinggi">
                                                    Tinggi
                                                </option>
                                                <option value="urgent">
                                                    Urgent
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-6">
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>-->
                        <h1>NOT IMPLEMENTED YET</h1>
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
    