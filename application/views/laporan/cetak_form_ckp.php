<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <link rel="shortcut icon" href="images/favicon.png">
        <title>Dashboard</title>
        <link href="<?php echo base_url() ?>/assets/bs3/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url() ?>/assets/css/style.css" rel="stylesheet">
        <!--Notification style-->
        <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/notification.css">
        <style>
            .tabel_pdf_staff{
                //border: #000 thin thin;
                width: 100%;
                font-size: 9;
            }
            @media print {
                #toolButton {
                    display: none;
                }
            }
        </style>
    </head>

    <body>

        <section id="main" >
    <!--        <section id="main-content">-->
    <!--            <section class="wrapper" >-->
            <!-- page start-->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <h2 align="center">Formulir Capaian Kerja Pegawai Negeri Sipil <?php if (isset($periode)) echo "Selama " . $periode . " Bulan" ?></h2>
                        <div id="toolButton" class="btn-group pull-right">
                            <button onclick="window.print()" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-print"></i>&nbsp; Cetak</button>
                        </div>
                    </div>

                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <table>
                            <tr>
                                <th width="500" align="left">Pejabat Penilai</th>
                                <th width="500" align="left">Pegawai yang Dinilai</th>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th width="90" align="left">NIP</th>
                                <td width="385" align="left">: <?= (isset($data_atasan) ? $data_atasan->nip : '') ?></td>
                                <th width="90" align="left">NIP</th>
                                <td width="385" align="left">: <?= (isset($data_staff) ? $data_staff->nip : '') ?></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th width="90" align="left">Nama</th>
                                <td width="385" align="left">: <?= (isset($data_atasan) ? $data_atasan->nama : '') ?></td>
                                <th width="90" align="left">Nama</th>
                                <td width="385" align="left">: <?= (isset($data_staff) ? $data_staff->nama : '') ?></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th width="90" align="left">Departemen</th>
                                <td width="385" align="left">: <?= (isset($data_atasan) ? $data_atasan->nama_departemen : '') ?></td>
                                <th width="90" align="left">Departemen</th>
                                <td width="385" align="left">: <?= (isset($data_staff) ? $data_staff->nama_departemen : '') ?></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th width="90" align="left">Jabatan</th>
                                <td width="385" align="left">: <?= (isset($data_atasan) ? $data_atasan->nama_jabatan : '') ?></td>
                                <th width="90" align="left">Jabatan</th>
                                <td width="385" align="left">: <?= (isset($data_staff) ? $data_staff->nama_jabatan : '') ?></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th width="90" align="left">Tanggal</th>
                                <td>: <?php echo date("d M Y") ?></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
            <div class="row" style="height: 40%;">
                <div class="col-md-12">
                    <div class="panel-body">
                        <table class="tabel_pdf_staff table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="30" style="text-align: center; vertical-align: middle">No</th>
                                    <th rowspan="2" width="150" style="text-align: center; vertical-align: middle">Kegiatan Tugas Jabatan</th>
                                    <th rowspan="2" width="30" style="text-align: center; vertical-align: middle">AK</th>
                                    <th colspan="4" style="text-align: center; vertical-align: middle">Target</th>
                                    <th rowspan="2" width="30" style="text-align: center; vertical-align: middle">AK</th>
                                    <th colspan="4" style="text-align: center; vertical-align: middle">Realisasi</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Penghitungan</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Nilai Capaian SKP</th>
                                </tr>
                                <tr>
                                    <th width="50">Output</th>
                                    <th width="50">Kualitas</th>
                                    <th width="50">Waktu</th>
                                    <th width="50">Biaya</th>
                                    <th width="50">Output</th>
                                    <th width="50">Kualitas</th>
                                    <th width="50">Waktu</th>
                                    <th width="50">Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($nilai_skp)) { ?>
                                    <?php
                                    $i = 0;
                                    $jumlah_tambahan = 0;
                                    $jumlah_kreativitas = 0;
                                    $nilai_kreativitas = 0;
                                    $jumlah_tambahan_selesai = 0;
                                    $list_nilai_kreativitas = array(1 => 3, 2 => 6, 3 => 12);
                                    foreach ($nilai_skp as $value) {
                                        if ($value['kategori'] == 'tambahan') {
                                            if ($value['progress'] >= 100)
                                                $jumlah_tambahan++;
                                            continue;
                                        }
                                        if ($value['kategori'] == 'kreativitas') {
                                            if ($value['progress'] >= 100) {
                                                $jumlah_kreativitas++;
                                                if ($nilai_kreativitas < $list_nilai_kreativitas[$value['level_manfaat']]) {
                                                    $nilai_kreativitas = $list_nilai_kreativitas[$value['level_manfaat']];
                                                }
                                            }
                                            continue;
                                        }
                                        $i++;
                                        ?>
                                        <tr>
                                            <td align="center">
                                                <?php echo $i; ?>
                                            </td>
                                            <td  align="justify"><?php echo $value['nama_pekerjaan'] ?></td>
                                            <td  align="center"  style="vertical-align: middle"><?php echo $value['sasaran_angka_kredit'] ?></td>
                                            <td  align="center"  style="vertical-align: middle"><?php echo $value['sasaran_kuantitas_output'] . ' ' . $value['satuan_kuantitas'] ?></td>
                                            <td  align="center"  style="vertical-align: middle"><?php echo $value['sasaran_kualitas_mutu'] ?>%</td>
                                            <td  align="center"  style="vertical-align: middle"><?= $value['sasaran_waktu'] . ' ' . $value['satuan_waktu'] ?></td>
                                            <td  align="center" style="vertical-align: middle"><?php echo ($value['pakai_biaya'] == 1 ? 'Rp. ' . number_format($value['sasaran_biaya'], 2, ',', '.') : '-') ?></td>

                                            <td  align="center"  style="vertical-align: middle"><?php echo $value['realisasi_angka_kredit'] ?></td>
                                            <td  align="center"  style="vertical-align: middle"><?php echo $value['realisasi_kuantitas_output'] . ' ' . $value['satuan_kuantitas'] ?></td>
                                            <td  align="center"  style="vertical-align: middle"><?php echo $value['realisasi_kualitas_mutu'] ?>%</td>
                                            <td  align="center"  style="vertical-align: middle"><?= $value['realisasi_waktu'] . ' ' . $value['satuan_waktu'] ?></td>
                                            <td  align="center" style="vertical-align: middle"><?php echo ($value['pakai_biaya'] == 1 ? 'Rp. ' . number_format($value['realisasi_biaya'], 2, ',', '.') : '-') ?></td>
                                            <td  align="center" style="vertical-align: middle"><?php echo $value['progress'] ?></td>
                                            <td  align="center" style="vertical-align: middle"><?php echo $value['skor'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    $first = true;
                                    foreach ($nilai_skp as $t) {
                                        if ($t['kategori'] != 'tambahan') {
                                            continue;
                                        }
                                        if ($value['progress'] < 100)
                                            continue;
                                        $i++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $i; ?></td>
                                            <td align=""><?php echo $t['nama_pekerjaan']; ?></td>
                                            <td colspan="5"></td>
                                            <td colspan="5"></td>
                                            <td rowspan="<?= $jumlah_tambahan ?>" colspan=""></td>
                                            <?php
                                            if ($first) {
                                                $first = false;
                                                $nilai_tambahan = 0;
                                                if ($jumlah_tambahan >= 7) {
                                                    $nilai_tambahan = 3;
                                                } else if ($jumlah_tambahan >= 4) {
                                                    $nilai_tambahan = 2;
                                                } else if ($jumlah_tambahan >= 1) {
                                                    $nilai_tambahan = 1;
                                                }
                                                ?>
                                                <td rowspan="<?= $jumlah_tambahan ?>" align="center"><?php echo $nilai_tambahan; ?></td>
                                            <?php }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                    $first = true;
                                    foreach ($nilai_skp as $t) {
                                        if ($t['kategori'] != 'kreativitas') {
                                            continue;
                                        }
                                        if ($value['progress'] < 100)
                                            continue;
                                        $i++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $i; ?></td>
                                            <td align=""><?php echo $t['nama_pekerjaan']; ?></td>
                                            <td colspan="5"></td>
                                            <td colspan="5"></td>
                                            <td rowspan="<?= $jumlah_tambahan ?>" colspan=""></td>
                                            <?php
                                            if ($first) {
                                                $first = false;
//                                                $nilai_kreativitas = 0;
                                                ?>
                                                <td rowspan="<?= $jumlah_tambahan ?>" align="center"><?php echo $nilai_kreativitas; ?></td>
                                            <?php }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                    <!--                        </section>-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <table>
                            <tr>
                                <th width="2000" align="left"></th>
                                <th width="100" align="left">Surabaya, <?php echo date("d M Y") ?></th>
                            </tr>
                            <tr>
                                <th style="padding-bottom: 50px;" width="600" align="left">Pejabat Penilai</th>
                                <th style="padding-bottom: 50px;" width="800" align="left">Pegawai yang Dinilai</th>
                            </tr>
                            <tr>
                                <td style="text-decoration: underline;" width="200" align="left"> <?= (isset($data_atasan) ? $data_atasan->nama : '') ?></td>
                                <td style="text-decoration: underline;" width="200" align="left"> <?= (isset($data_staff) ? $data_staff->nama : '') ?></td>
                            </tr>
                            <tr>
                                <td width="200" align="left"> <?= (isset($data_atasan) ? $data_atasan->nip : '') ?></td>
                                <td width="200" align="left"> <?= (isset($data_staff) ? $data_staff->nip : '') ?></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </section>
    </body>
</html>