<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="<?php echo site_url() ?>/home">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user"></i>
                        <span>Akun Saya</span>
                    </a>
                    <ul class="sub">
                        <li><a href="<?php echo site_url() ?>/profil">Akun</a></li>
                    </ul>
                </li>
<!--                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-users"></i>
                        <span>User Manajemen</span>
                    </a>
                    <ul class="sub">
                    </ul>
                </li>-->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Pekerjaan</span>
                    </a>
                    <ul class="sub">
                        <li class="sub-menu">
                            <a href="<?php echo site_url()?>/pekerjaan/karyawan">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Saya</span>
                            </a>
                        </li>
                        <?php if($this->session->userdata("user_jabatan")=="manager"){?>
                        <li class="sub-menu">
                            <a href="<?php echo site_url(); ?>/pekerjaan/lihat_usulan">
                                <i class="fa fa-book"></i>
                                <span>Usulan Pekerjaan</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="<?php echo site_url(); ?>/pekerjaan/pekerjaan_staff">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Karyawan</span>
                            </a>
                        </li>
                        <?php } ?>
<!--                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Karyawan</span>
                            </a>
                            <ul class="sub">
                                <li><a href="<?php echo base_url()."index.php/pekerjaan/karyawan"?>">List Pekerjaan</a></li>
                                <li><a href="#">Penilaian Kinerja</a></li>
                                <li><a href="#">Grafik Kinerja Karyawan</a></li>
                            </ul>
                        </li>-->
<!--                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Usulan Pekerjaan</span>
                            </a>
                        </li>-->
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-laptop"></i>
                        <span>Rekap Pekerjaan</span>
                    </a>
                    <ul class="sub">
                        <li><a href="#">Per Periode</a></li>
                        <li><a href="#">Per Status</a></li>
                        <li><a href="#">Filter Lainnya</a></li>
                        <li><a href="#">Export File</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo site_url()?>/login/logout">
                        <i class="fa fa-angle-double-right"></i>
                        <span>Log Out</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>