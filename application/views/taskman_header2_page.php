<!--header start-->
<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">

        <a href="<?php echo site_url() ?>" class="logo">
            <img src="<?php echo base_url() ?>assets/logo-taskman.png" alt="">
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->

    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-tasks"></i>
                    <span class="badge bg-success" id="jumlah_pending_task"></span>
                </a>
                <ul class="dropdown-menu extended tasks-bar" id="bagian_pending_task" style="overflow: scroll; max-height: 400px;overflow-x: hidden">
                    <li><p class="">Anda Tidak Memiliki Pending Task</p></li>
                    <li class="external">
                        <a href="<?php echo site_url(); ?>/pekerjaan/karyawan">Lihat Semua Task</a>
                    </li>
                </ul>
            </li>

        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <!--            <li>
                            <input type="text" class="form-control search" placeholder=" Search">
                        </li>-->
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
<!--                    <img alt="" src="<?php echo base_url() ?>/assets/images/avatar1_small.jpg">-->
                    <span class="username"><?php echo $data_akun['user_nama'].' - '. $data_akun['nama_jabatan'].' - '. $data_akun['nama_departemen']; ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="<?php echo site_url() ?>/profil"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="<?php echo site_url() ?>/login/logout"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
            <li>
                <div class="toggle-right-box">
                    <div class="fa fa-bars"></div>
                </div>
            </li>
        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->
