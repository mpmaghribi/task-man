<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="<?php echo site_url() ?>">
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
                        <li><a href="responsive_table.html">Daftar Pekerjaan</a></li>
                        <li><a href="dynamic_table.html">Detail Pekerjaan</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-users"></i>
                        <span>User Manajemen</span>
                    </a>
                    <ul class="sub">
                        <li><a href="<?php echo base_url() . "index.php/user/tambah" ?>">Daftar Akun Baru</a></li>
                        <li><a href="advanced_form.html">Tambah Akun Baru</a></li>
                        <li><a href="<?php echo base_url() . "index.php/user/list_karyawan" ?>">Daftar Karyawan Saya</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Pekerjaan</span>
                    </a>
                    <ul class="sub">
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Saya</span>
                            </a>
                            <ul class="sub">
                                <li><a href="#">Daftar Pekerjaan</a></li>
                                <li><a href="#">Group By Upcoming, Ongoing, Completed Task</a></li>
                                <li><a href="#">Progress Tiap Pekerjaan</a></li>
                                <li><a href="#">Link ke Detail Pekerjaan</a></li>
                                <li><a href="#">Ubah Status Pekerjaan</a></li>
                                <li><a href="#">Progress Pekerjaan</a></li>
                                <li><a href="#">Pekerjaan Baru</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Tambahkan Pekerjaan</span>
                            </a>
                            <ul class="sub">
                                <li><a href="<?php echo base_url()."index.php/pekerjaan/tambah_pekerjaan"?>">Isi Data Pekerjaan</a></li>
                                <li><a href="#">Penerima Pekerjaan</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Pekerjaan Karyawan</span>
                            </a>
                            <ul class="sub">
                                <li><a href="#">Penilaian Kinerja</a></li>
                                <li><a href="#">Grafik Kinerja Karyawan</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>Usulan Pekerjaan</span>
                            </a>
                        </li>
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
                    <a href="javascript:;">
                        <i class="fa fa-angle-double-right"></i>
                        <span>Log Out</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>