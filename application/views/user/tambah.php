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
                                <header class="panel-heading">
                                    Daftar Akun Baru
                                </header>
                                <div class="panel-body">
                                    <form class="form-horizontal bucket-form" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">NIP</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="NIP" id="NIP"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nama</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="nama" id="nama"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jenis Kelamin</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tempat Tanggal Lahir</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="tempat_tanggal_lahir" id="tempat_tanggal_lahir"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Alamat</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="alamat" id="alamat"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Agama</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="agama" id="agama"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Telepon</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="telepon" id="telepon"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">HP</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="hp" id="hp"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="email" id="email"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Departemen</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="departemen" id="departemen"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jabatan</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="jabatan" id="jabatan"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Akun Password</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="password" id="password"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"></label>
                                            <div class="col-sm-6">
                                                 <input type="submit" class="btn btn-info" value="Submit"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- page end-->
                </section>
            </section>
            <!--main content end-->
            <!--right sidebar start-->
           <?php $this->load->view('taskman_rightbar_page')?>
            <!--right sidebar end-->

        </section>
<?php $this->load->view("taskman_footer_page") ?>