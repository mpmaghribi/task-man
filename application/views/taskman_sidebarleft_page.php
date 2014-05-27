<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a href="<?php echo base_url() ?>home">
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
                        <li><a href="<?php echo base_url() ?>profil">Akun</a></li>
                    </ul>
                </li>
                <li class="sub-menu" id="submenu_pekerjaan_li">
                    <a href="javascript:;" id="submenu_pekerjaan">
                        <i class="fa fa-book" ></i>
                        <span>Pekerjaan</span>
                    </a>
                    <ul class="sub" id="submenu_pekerjaan_ul">
                        <li class="sub-menu">
                            <a href="<?php echo base_url(); ?>pekerjaan/pengaduan">
                                <i class="fa fa-book"></i>
                                <span>Pengaduan</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="<?php echo base_url()?>pekerjaan/karyawan">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Saya</span>
                            </a>
                        </li>
                        <?php if($data_akun['jmlstaff'] > 0){?>
                        <li class="sub-menu">
                            <a href="<?php echo base_url(); ?>pekerjaan/lihat_usulan">
                                <i class="fa fa-book"></i>
                                <span>Usulan Pekerjaan</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="<?php echo base_url(); ?>pekerjaan/pekerjaan_staff">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Staff</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="<?php echo base_url(); ?>draft">
                                <i class="fa fa-book"></i>
                                <span>Draft Pekerjaan</span>
                            </a>
                        </li>
                        <?php } ?>
<!--                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Karyawan</span>
                            </a>
                            <ul class="sub">
                                <li><a href="<?php echo base_url()."pekerjaan/karyawan"?>">List Pekerjaan</a></li>
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
                        <?php $temp = $this->session->userdata('logged_in'); if ($temp['jmlstaff'] > 0){?><li><a href="<?php echo base_url()?>laporan">Laporan Pekerjaan Staff</a></li><?php }?>
                         <li><a href="<?php echo base_url()?>laporan/laporan_pekerjaan_saya">Laporan Pekerjaan Saya</a></li>
<!--                        <li><a href="#">Per Periode</a></li>
                        <li><a href="#">Per Status</a></li>
                        <li><a href="#">Filter Lainnya</a></li>
                        <li><a href="#">Export File</a></li>-->
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url()?>login/logout">
                        <i class="fa fa-angle-double-right"></i>
                        <span>Log Out</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>