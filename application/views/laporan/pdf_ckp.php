<?php 
$nama_periode=array(
    'januari'=>'Januari',
    'februari'=>'Februari',
    'maret'=>'Maret',
    'april'=>'April',
    'mei'=>'Mei',
    'juni'=>'Juni',
    'juli'=>'Juli',
    'agustus'=>'Agustus',
    'september'=>'September',
    'oktober'=>'Oktober',
    'november'=>'November',
    'desember'=>'Desember',
    'tri_1'=>'Triwulan I',
    'tri_2'=>'Triwulan II',
    'tri_3'=>'Triwulan III',
    'tri_4'=>'Triwulan IV',
    'sms_1'=>'Semester I',
    'sms_2'=>'Semester II'
);
?>
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
        <style type="text/css"><?php echo file_get_contents(base_url() . APPPATH . 'assets/bs3/css/bootstrap.min.css'); ?></style>
        <style>
            .tabel_pdf_staff{
                //border: #000 thin thin;
                width: 100%;
                font-size: 9;
                border-collapse: collapse;
            }
            thead th{
                border: #000 solid thin;
            }
            tbody td{
                border: #000 solid thin;
            }
            body{

            }
        </style>
    </head>

    <body>

        <section id="container" >
            <section id="main-content">
                <section class="wrapper" >
                    <!-- page start-->
                    <div class="row">
                        <div class="col-md-6">
                            <section class="panel">
                                <div class="form">
                                    <h2 align="center">Formulir Capaian Kerja Pegawai Negeri Sipil <?php if (isset($periode2)) echo "Selama " . $nama_periode[$periode2] . " Tahun ".$periode ?></h2>
                                </div>

                            </section>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <div class="form">
                                    <table>
                                        <tr>
                                            <th width="372" align="left">Pejabat Penilai</th>
                                            <th width="370" align="left">Pegawai yang Dinilai</th>
                                        </tr>
                                    </table>
                                </div>

                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <div class="form">
                                    <table>
                                        <tr>
                                            <th width="70" align="left">NIP</th>
                                            <td width="300" align="left">: <?= (isset($data_atasan) ? $data_atasan->nip : '') ?></td>
                                            <th width="70" align="left">NIP</th>
                                            <td width="300" align="left">: <?= (isset($data_staff) ? $data_staff->nip : '') ?></td>
                                        </tr>
                                    </table>
                                </div>

                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <section class="panel">
                                <div class="form">
                                    <table>
                                        <tr>
                                            <th width="70" align="left">Nama</th>
                                            <td width="300" align="left">: <?= (isset($data_atasan) ? $data_atasan->nama : '') ?></td>
                                            <th width="70" align="left">Nama</th>
                                            <td width="300" align="left">: <?= (isset($data_staff) ? $data_staff->nama : '') ?></td>
                                        </tr>
                                    </table>
                                </div>

                            </section>
                        </div>
                        <div class="col-md-6">
                            <section class="panel">
                                <div class="form">
                                    <table>
                                        <tr>
                                            <th width="70" align="left">Departemen</th>
                                            <td width="300" align="left">: <?= (isset($data_atasan) ? $data_atasan->nama_departemen : '') ?></td>
                                            <th width="70" align="left">Departemen</th>
                                            <td width="300" align="left">: <?= (isset($data_staff) ? $data_staff->nama_departemen : '') ?></td>
                                        </tr>
                                    </table>
                                </div>

                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <section class="panel">
                                <div class="form">
                                    <table>
                                        <tr>
                                            <th width="70" align="left">Jabatan</th>
                                            <td width="300" align="left">: <?= (isset($data_atasan) ? $data_atasan->nama_jabatan : '') ?></td>
                                            <th width="70" align="left">Jabatan</th>
                                            <td width="300" align="left">: <?= (isset($data_staff) ? $data_staff->nama_jabatan : '') ?></td>
                                        </tr>
                                    </table>
                                </div>

                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <section class="panel">
                                <div class="form">
                                    <table>
                                        <tr>
                                            <th width="70" align="left">Tanggal</th>
                                            <td>: <?php echo date("d M Y") ?></td>
                                        </tr>
                                    </table>
                                </div>

                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <div class="form">
                                    <br/>
                                </div>

                            </section>
                        </div>
                    </div>
                    <div class="row" style="height: 40%;">
                        <div class="col-md-12">
                            <section class="panel">
                                <div class="form">
                                    <table class="tabel_pdf_staff"  >
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
                                            <?php
                                            $total_skor = 0;
                                            if (isset($nilai_skp)) {
                                                $i = 1;
                                                foreach ($nilai_skp as $value) {
                                                    if (!in_array($value['kategori'], array('rutin', 'project'))) {
                                                        continue;
                                                    }
//                                                    print_r($value);
                                                    $detil_pekerjaan = $value;
                                                    $persen_waktu = 0;
                                                    if ($detil_pekerjaan['sasaran_waktu'] > 0) {
                                                        $persen_waktu = 100 - (100 * $detil_pekerjaan['realisasi_waktu'] / $detil_pekerjaan['sasaran_waktu']);
                                                    }
                                                    $persen_biaya = 0;
                                                    if ($detil_pekerjaan['pakai_biaya'] == '1' && $detil_pekerjaan['sasaran_biaya'] > 0) {
                                                        $persen_biaya = 100 - (100 * $detil_pekerjaan['realisasi_biaya'] / $detil_pekerjaan['sasaran_biaya']);
                                                    }
                                                    $kuantitas = 0;
                                                    if ($detil_pekerjaan['sasaran_kuantitas_output'] > 0) {
                                                        $kuantitas = 100 * $detil_pekerjaan['realisasi_kuantitas_output'] / $detil_pekerjaan['sasaran_kuantitas_output'];
                                                    }
                                                    $kualitas = 0;
                                                    if ($detil_pekerjaan['sasaran_kualitas_mutu'] > 0) {
                                                        $kualitas = 100 * $detil_pekerjaan['realisasi_kualitas_mutu'] / $detil_pekerjaan['sasaran_kualitas_mutu'];
                                                    }
                                                    $waktu = 0;
                                                    if ($persen_waktu > 24) {
                                                        if ($detil_pekerjaan['sasaran_waktu'] > 0) {
                                                            $waktu = 76 - ((((1.76 * $detil_pekerjaan['sasaran_waktu'] - $detil_pekerjaan['realisasi_waktu']) / $detil_pekerjaan['sasaran_waktu']) * 100) - 100);
                                                        }
                                                    } else {
                                                        if ($detil_pekerjaan['sasaran_waktu'] > 0) {
                                                            $waktu = ((1.76 * $detil_pekerjaan['sasaran_waktu'] - $detil_pekerjaan['realisasi_waktu']) / $detil_pekerjaan['sasaran_waktu']) * 100;
                                                        }
                                                    }
                                                    $biaya = 0;
                                                    if ($persen_biaya > 24) {
                                                        if ($detil_pekerjaan['pakai_biaya'] == '1' && $detil_pekerjaan['sasaran_biaya'] > 0) {
                                                            $waktu = 76 - ((((1.76 * $detil_pekerjaan['sasaran_biaya'] - $detil_pekerjaan['realisasi_biaya']) / $detil_pekerjaan['sasaran_biaya']) * 100) - 100);
                                                        }
                                                    } else {
                                                        if ($detil_pekerjaan['pakai_biaya'] == '1' && $detil_pekerjaan['sasaran_biaya'] > 0) {
                                                            $waktu = ((1.76 * $detil_pekerjaan['sasaran_biaya'] - $detil_pekerjaan['realisasi_biaya']) / $detil_pekerjaan['sasaran_biaya']) * 100;
                                                        }
                                                    }
                                                    $penghitungan = $waktu + $kuantitas + $kualitas;
                                                    $skor = $penghitungan / 3;
                                                    if ($detil_pekerjaan['pakai_biaya'] == '1') {
                                                        $penghitungan+=$biaya;
                                                        $skor = $penghitungan / 4;
                                                    }
                                                    $total_skor+=$skor;
                                                    ?>
                                                    <tr>
                                                        <td align="center"><?php echo $i; ?></td>
                                                        <td  align="justify"><?php echo $value['nama_pekerjaan'] ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo $value['sasaran_angka_kredit'] ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo $value['sasaran_kuantitas_output'] . ' ' . $value['satuan_kuantitas'] ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo $value['sasaran_kualitas_mutu'] ?>%</td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo $value['sasaran_waktu'] . ' Bulan'; ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo ($value['pakai_biaya'] == '1' ? 'Rp. ' . number_format($value['sasaran_biaya'], 2, ',', '.') : '-') ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo $value['realisasi_angka_kredit'] ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo intval($value['realisasi_kuantitas_output']) . ' ' . $value['satuan_kuantitas'] ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo $value['realisasi_kualitas_mutu'] ?>%</td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo intval($value['realisasi_waktu']) . ' Bulan'; ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo ($value['pakai_biaya'] == '1' ? 'Rp. ' . number_format($value['realisasi_biaya'], 2, ',', '.') : '-') ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo number_format($penghitungan, 2) ?></td>
                                                        <td  align="center" style="vertical-align: middle"><?php echo number_format($skor, 2) ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td align="center" style="vertical-align: middle" rowspan="2" colspan="13">Nilai Capaian SKP</td>
                                                <td align="center" style="vertical-align: middle"><?= number_format($total_skor, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="vertical-align: middle"><?= $total_skor<=50?'Buruk':($total_skor<=60?'Sedang':($total_skor<=75?'Cukup':($total_skor<=90.99?'Baik':'Sangat Baik'))) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <div class="form">
                                    <table>
                                        <tr>
                                            <th width="100" align="left"></th>
                                            <th width="100" align="left">Surabaya, <?php echo date("d M Y") ?></th>
                                        </tr>
                                        <tr>
                                            <th style="padding-bottom: 50px;" width="500" align="left">Pejabat Penilai</th>
                                            <th style="padding-bottom: 50px;" width="500" align="left">Pegawai yang Dinilai</th>
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

                            </section>
                        </div>
                    </div>
                </section>
                <section class="footer-section">

                </section>
            </section>
        </section>
    </body>
</html>
