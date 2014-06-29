<?php $temp = $this->session->userdata('logged_in'); ?>
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
                <?php //foreach ($temp["idmodul"] as $value) { ?>

                <li class="sub-menu" id="submenu_pekerjaan_li">
                    <a href="javascript:;" id="submenu_pekerjaan">
                        <i class="fa fa-book" ></i>
                        <span>Pekerjaan</span>
                    </a>
                    <ul class="sub" id="submenu_pekerjaan_ul">
                        <?php foreach ($temp["idmodul"] as $value) { ?>
                            <?php if ($value == 7) { ?>
                                <li class="sub-menu">
                                    <a href="<?php echo base_url(); ?>pekerjaan/pengaduan">
                                        <i class="fa fa-book"></i>
                                        <span>Pengaduan</span>
                                    </a>
                                </li>
                            <?php } else if ($value == 1) { ?>
                                <li class="sub-menu">
                                    <a href="<?php echo base_url() ?>pekerjaan/karyawan">
                                        <i class="fa fa-book"></i>

                                        <span>Pekerjaan Saya</span>
                                    </a>
                                </li>
                            <?php } else if ($value == 2) { ?>

                                <li class="sub-menu">
                                    <a href="<?php echo base_url(); ?>pekerjaan/lihat_usulan">
                                        <i class="fa fa-book"></i>
                                        <span>Usulan Pekerjaan Staff</span>
                                    </a>
                                </li>
                            <?php } else if ($value == 5) { ?>
                                <li class="sub-menu">
                                    <a href="<?php echo base_url(); ?>pekerjaan/pekerjaan_staff">
                                        <i class="fa fa-book"></i>
                                        <span>Pekerjaan Staff</span>
                                    </a>
                                </li>
                            <?php } else if ($value == 3) { ?>
                                <li class="sub-menu">
                                    <a href="<?php echo base_url(); ?>draft">
                                        <i class="fa fa-book"></i>
                                        <span>Draft Pekerjaan</span>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-laptop"></i>
                        <span>Rekap Pekerjaan</span>
                    </a>

                    <ul class="sub">
                        <?php foreach ($temp["idmodul"] as $value) { ?>
                            <?php if ($value == 9) { ?>
                                <li><a href="<?php echo base_url() ?>laporan">Laporan Pekerjaan Staff</a></li>
                            <?php } else if ($value == 8) { ?>
                                <li><a href="#exportPeriodePkjSaya" data-toggle="modal">Laporan Pekerjaan Saya</a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>

                <?php //} ?>
                <li>
                    <a href="<?php echo str_replace("taskmanagement", "integrarsud", site_url()) ?>">
                        <i class="fa fa-angle-double-left"></i>
                        <span>Kembali ke Integra</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo str_replace("taskmanagement", "integrarsud", site_url()) ?>/dasboard/logout">
                        <i class="fa fa-angle-double-right"></i>
                        <span>Log Out</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<div class="modal fade" id="exportPeriodePkjSaya" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Pilih Periode dan Laporan Pekerjaan yang Ingin Anda Eksport</h4>
            </div>
            <form action="<?php echo site_url() ?>laporan/laporan_pekerjaan_saya" method="GET">
                <div class="modal-body">
                    <select name="periode" class="form-control m-bot15">
                        <option value="6">
                            6 Bulan
                        </option>
                        <option value="12">
                            1 Tahun
                        </option>
                    </select>
                    <select name="jenis_laporan" class="form-control m-bot15">
                        <option value="1">
                            Laporan SKP
                        </option>
                        <option value="2">
                            Laporan CKP
                        </option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                    <button class="btn btn-warning" type="submit"> Export PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>