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
                                    <div class="col-md-3">
                                        <div class="profile-pic text-center">
                                            <img src="images/lock_thumb.jpg" alt=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-desk">
                                            
                                                
                                            
                                            <h1><?php  echo $profil->nama?></h1>
                                            <span class="text-muted"><?php echo $jabatan[0]->nama_jabatan?> - <?php echo $jabatan[0]->nama_departemen?></span>
                                            <p>
                                                Seorang staff yang memiliki NIP <?php echo $profil->nip?> ini adalah seorang karyawan yang sangat pekerja keras.
                                                Jika ada perlu terhadap beliau terkait pekerjaan, dapat menghubungi ke
                                                Email: <?php echo $profil->email?>, HP: <?php echo $profil->hp?>
                                                
                                            </p>
                                        </div>
                                    </div>
<!--                                    <div class="col-md-3">
                                        <div class="profile-statistics">
                                            <h1>1240</h1>
                                            <p>This Week Sales</p>
                                            <h1>$5,61,240</h1>
                                            <p>This Week Earn</p>
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="active">
                                                    <a href="#">
                                                        <i class="fa fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa fa-google-plus"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>-->
                                </div>
                            </section>
                        </div>
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading tab-bg-dark-navy-blue">
                                    <ul class="nav nav-tabs nav-justified ">
                                        <li class="active">
                                            <a data-toggle="tab" href="#overview">
                                                Rekam Aktivitas
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#job-history">
                                                Rekam Pekerjaan
                                            </a>
                                        </li>
                                    </ul>
                                </header>
                                <div class="panel-body">
                                    <div class="tab-content tasi-tab">
                                        <div id="overview" class="tab-pane active">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="recent-act">
                                                        <h1>Semua Aktivitas</h1>
                                                        
                                                        <?php foreach ($aktivitas as $value) {?>
                                                            <div class="activity-icon terques">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        <div class="activity-desk">
                                                            <h2><?php date_default_timezone_set('Asia/Jakarta'); echo date('d M Y h:i:s',strtotime($value->tanggal_activity))?></h2>
                                                            <p><?php echo $value->nama_activity?></p>
                                                            <p><?php echo $value->deskripsi_activity?></p>
                                                        </div>
                                                        <?php }?>
                                                        

                                                    </div>
                                                </div>
                          <!--                       <div class="col-md-4">
                                                   <div class="prf-box">
                                                        <h3 class="prf-border-head">work in progress</h3>
                                                        <div class=" wk-progress">
                                                            <div class="col-md-5">Themeforest</div>
                                                            <div class="col-md-5">
                                                                <div class="progress  ">
                                                                    <div style="width: 70%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                                        <span class="sr-only">70% Complete (success)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">70%</div>
                                                        </div>
                                                        <div class=" wk-progress">
                                                            <div class="col-md-5">Graphics River</div>
                                                            <div class="col-md-5">
                                                                <div class="progress ">
                                                                    <div style="width: 57%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
                                                                        <span class="sr-only">57% Complete (success)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">57%</div>
                                                        </div>
                                                        <div class=" wk-progress">
                                                            <div class="col-md-5">Code Canyon</div>
                                                            <div class="col-md-5">
                                                                <div class="progress ">
                                                                    <div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-info">
                                                                        <span class="sr-only">20% Complete (success)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">20%</div>
                                                        </div>
                                                        <div class=" wk-progress">
                                                            <div class="col-md-5">Audio Jungle</div>
                                                            <div class="col-md-5">
                                                                <div class="progress ">
                                                                    <div style="width: 30%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
                                                                        <span class="sr-only">30% Complete (success)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">30%</div>
                                                        </div>
                                                    </div>-->
<!--                                                    <div class="prf-box">
                                                        <h3 class="prf-border-head">performance status</h3>
                                                        <div class=" wk-progress pf-status">
                                                            <div class="col-md-8 col-xs-8">Total Product Sales</div>
                                                            <div class="col-md-4 col-xs-4">
                                                                <strong>23545</strong>
                                                            </div>
                                                        </div>
                                                        <div class=" wk-progress pf-status">
                                                            <div class="col-md-8 col-xs-8">Total Product Refer</div>
                                                            <div class="col-md-4 col-xs-4">
                                                                <strong>235</strong>
                                                            </div>
                                                        </div>
                                                        <div class=" wk-progress pf-status">
                                                            <div class="col-md-8 col-xs-8">Total Earn</div>
                                                            <div class="col-md-4 col-xs-4">
                                                                <strong>235452344$</strong>
                                                            </div>
                                                        </div>
                                                    </div>-->
<!--                                                    <div class="prf-box">
                                                        <h3 class="prf-border-head">team members</h3>
                                                        <div class=" wk-progress tm-membr">
                                                            <div class="col-md-2 col-xs-2">
                                                                <div class="tm-avatar">
                                                                    <img src="images/lock_thumb.jpg" alt=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 col-xs-7">
                                                                <span class="tm">John Boltana</span>
                                                            </div>
                                                            <div class="col-md-3 col-xs-3">
                                                                <a href="#" class="btn btn-white">Assign</a>
                                                            </div>
                                                        </div>
                                                        <div class=" wk-progress tm-membr">
                                                            <div class="col-md-2 col-xs-2">
                                                                <div class="tm-avatar">
                                                                    <img src="images/avatar-mini-2.jpg" alt=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 col-xs-7">
                                                                <span class="tm">John Boltana</span>
                                                            </div>
                                                            <div class="col-md-3 col-xs-3">
                                                                <a href="#" class="btn btn-white">Assign</a>
                                                            </div>
                                                        </div>
                                                        <div class=" wk-progress tm-membr">
                                                            <div class="col-md-2 col-xs-2">
                                                                <div class="tm-avatar">
                                                                    <img src="images/avatar-mini-3.jpg" alt=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 col-xs-7">
                                                                <span class="tm">John Boltana</span>
                                                            </div>
                                                            <div class="col-md-3 col-xs-3">
                                                                <a href="#" class="btn btn-white">Assign</a>
                                                            </div>
                                                        </div>
                                                        <div class=" wk-progress tm-membr">
                                                            <div class="col-md-2 col-xs-2">
                                                                <div class="tm-avatar">
                                                                    <img src="images/avatar-mini-4.jpg" alt=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 col-xs-7">
                                                                <span class="tm">John Boltana</span>
                                                            </div>
                                                            <div class="col-md-3 col-xs-3">
                                                                <a href="#" class="btn btn-white">Assign</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                                            </div>
                                        </div>
                                        <div id="job-history" class="tab-pane ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="timeline-messages">
                                                        <h3>Seluruh Rekam Pekerjaan Yang Selesai</h3>
                                                        <!-- Comment -->
                                                        <?php foreach ($pekerjaan as $value) {?>
                                                            <div class="msg-time-chat">
                                                            <div class="message-body msg-in">
                                                                <span class="arrow"></span>
                                                                <div class="text">
                                                                    <div class="first">
                                                                       Selesai tanggal <?php echo date("d M Y h:i:s",  strtotime($value->tglaslli_selesai));?>
                                                                    </div>
                                                                    <div class="second bg-terques ">
                                                                        <p><?php echo $value->nama_pekerjaan?></p>
                                                                        <p><?php echo $value->deskripsi_pekerjaan?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="contacts" class="tab-pane ">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="prf-contacts">
                                                        <h2> <span><i class="fa fa-map-marker"></i></span> location</h2>
                                                        <div class="location-info">
                                                            <p>Postal Address<br>
                                                                PO Box 16122 Collins Street West<br>
                                                                Victoria 8007 Australia</p>
                                                            <p>Headquarters<br>
                                                                121 King Street, Melbourne<br>
                                                                Victoria 3000 Australia</p>
                                                        </div>
                                                        <h2> <span><i class="fa fa-phone"></i></span> contacts</h2>
                                                        <div class="location-info">
                                                            <p>Phone	: +61 3 8376 6284 <br>
                                                                Cell		: +61 3 8376 6284</p>
                                                            <p>Email		: david@themebucket.net<br>
                                                                Skype		: david.rojormillan</p>
                                                            <p>
                                                                Facebook	: https://www.facebook.com/themebuckets <br>
                                                                Twitter	: https://twitter.com/theme_bucket
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="map-canvas"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="settings" class="tab-pane ">
                                            <div class="position-center">
                                                <div class="prf-contacts sttng">
                                                    <h2>Personal Information</h2>
                                                </div>
                                                <form role="form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Avatar</label>
                                                        <div class="col-lg-6">
                                                            <input type="file" id="exampleInputFile" class="file-pos" name="avatar">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">NIP</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder="NIP" id="nip" name="nip" class="form-control" readonly="true" value="<?php echo $this->session->userdata('user_nip'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Nama</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="lives-in" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Country</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="country" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Description</label>
                                                        <div class="col-lg-10">
                                                            <textarea rows="10" cols="30" class="form-control" id="" name=""></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="prf-contacts sttng">
                                                    <h2> socail networks</h2>
                                                </div>
                                                <form role="form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Facebook</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="fb-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Twitter</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="twitter" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Google plus</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="g-plus" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Flicr</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="flicr" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Youtube</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="youtube" class="form-control">
                                                        </div>
                                                    </div>

                                                </form>
                                                <div class="prf-contacts sttng">
                                                    <h2>Contact</h2>
                                                </div>
                                                <form role="form" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Address 1</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="addr1" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Address 2</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="addr2" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Phone</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="phone" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Cell</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="cell" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Email</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Skype</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" placeholder=" " id="skype" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10">
                                                            <button class="btn btn-primary" type="submit">Save</button>
                                                            <button class="btn btn-default" type="button">Cancel</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>

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
            <?php $this->load->view('taskman_rightbar_page')?>
            <!--right sidebar end-->

        </section>
<?php $this->load->view("taskman_footer_page") ?>