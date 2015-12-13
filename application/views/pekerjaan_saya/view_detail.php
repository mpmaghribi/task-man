<?php $this->load->view("taskman_header_page") ?> 
<?php
$user = array();
foreach ($users as $u) {
    $user[$u->id_akun] = $u;
}
$list_kategori = array(
    'rutin' => 'SKP Rutin',
    'project' => 'SKP Project',
    'tambahan' => 'Pekerjaan Tambahan',
    'kreativitas' => 'Pekerjaan Kreativitas'
);
$list_tingkat_manfaat = array(
    1 => 'Bermanfaat bagi Unit Kerja',
    2 => 'Bermanfaat bagi Organisasi',
    3 => 'Bermanfaat bagi Negara'
);
?>
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

                    <div class="col-md-12" >
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#deskripsiPekerjaan">Deskripsi Pekerjaan</a>
                                    </li>
                                </ul>
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-info btn-xs" href="javascript:void(0);" id="tombol_validasi_usulan" style="font-size: 10px;display:none" onclick="validasi_usulan(<?= $pekerjaan['id_pekerjaan'] ?>);">Validasi</a>
                                    <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>pekerjaan/edit?id_pekerjaan=<?php echo $pekerjaan['id_pekerjaan']; ?>" id="tombol_edit_usulan" style="font-size: 10px;display:none">Edit</a>
                                    <a class="btn btn-warning btn-xs" href="javascript:void(0);" id="tombol_batalkan_usulan" style="font-size: 10px;display:none">Batalkan</a>
                                    <a class="btn btn-primary btn-xs" href="javascript:void(0);" id="tombol_perpanjang" style="font-size: 10px;display:none">Perpanjangan Telah Dikirim</a>
                                    <a class="btn btn-primary btn-xs" href="javascript:void(0);" id="setuju_perpanjang"  style="font-size: 10px;display:none">Minta Diperpanjang</a>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal_perpanjang" id="tombol_perpanjang" style="font-size: 10px;display:none">Minta Perpanjang</a>
                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="deskripsiPekerjaan" class="tab-pane active">
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    <?php
                                                    if ($pekerjaan['status_pekerjaan'] == '7') {
                                                        echo 'Penanggung Jawab';
                                                    } else if ($pekerjaan['status_pekerjaan'] == '6') {
                                                        echo 'Ditujukan Kepada';
                                                    }
                                                    ?>
                                                </h4>
                                                <p style="font-size: larger" id="nama_penanggung_jawab"><?= $user[$pekerjaan['id_penanggung_jawab']]->nama ?></p>
                                                <h4 style="color: #1FB5AD;">Nama Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['nama_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Penjelasan Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['deskripsi_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Jenis Pekerjaan</h4>
                                                <p style="font-size: larger"><?php echo $pekerjaan['nama_sifat_pekerjaan']; ?></p>
                                                <h4 style="color: #1FB5AD;">Kategori Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $list_kategori[$pekerjaan['kategori']] ?></p>
                                                <?php
                                                if ($pekerjaan['kategori'] == 'kreativitas') {
                                                    ?>
                                                    <h4 style="color: #1FB5AD;">Tingkat Kemanfaatan</h4>
                                                    <p style="font-size: larger"><?= $list_tingkat_manfaat[$pekerjaan['level_manfaat']] ?></p>
                                                    <?php
                                                }
                                                ?>
                                                <h4 style="color: #1FB5AD;">Periode</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['tanggal_mulai'] . ' - ' . $pekerjaan['tanggal_selesai'] ?></p>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung Pekerjaan
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="table_file_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th style="width: 250px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table_file_pekerjaan_body">
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    List File Progress
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="table_file_progress">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th>Deskripsi Aktivitas</th>
                                                                <th style="width: 250px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="col-md-12" id="div_aktivitas">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Aktivitas Pekerjaan
                                                </h4>
                                                <div class="panel-body">
                                                    <button class="btn btn-success" id="button_tampilkan_form_aktivitas" onclick="tampilkan_form_tambah_aktivitas()" type="button">Tambah Aktivitas</button>
                                                </div>
                                                <div class="panel-body" id="div_form_tambah_aktivitas" style="display:none">
                                                    <form method="post" action="<?= site_url() ?>/aktivitas_pekerjaan/add_v2" enctype="multipart/form-data" id="form_tambah_aktivitas" target="frame_tambah_aktivitas">
                                                        <div class="form-horizontal">
                                                            <div class="form-group">
                                                                <label class="col-lg-2 control-label">Keterangan</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" class="form-control" id="keterangan_baru" name="keterangan"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="div_aktivitas_angka_kredit">
                                                                <label class="col-lg-2 control-label">Angka Kredit</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" class="form-control" id="ak_baru" name="ak"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="div_aktivitas_kuantitas_output">
                                                                <label class="col-lg-2 control-label">Kuantitas Output</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" class="form-control" id="kuantitas_output_baru" name="kuantitas_output"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="div_aktivitas_kualitas_mutu">
                                                                <label class="col-lg-2 control-label">Kualitas Mutu</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" class="form-control" id="kualitas_mutu_baru" name="kualitas_mutu"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="div_nilai_progress">
                                                                <label class="col-lg-2 control-label" >Progress</label>
                                                                <div class="col-lg-8">
                                                                    <select name="nilai_progress" class="form-control">
                                                                        <?php
                                                                        for ($i = 10; $i <= 100; $i+=10) {
                                                                            echo '<option value="' . $i . '">' . $i . '%</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="div_aktivitas_waktu">
                                                                <label class="col-lg-2 control-label">Waktu</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" id="waktu_mulai_baru" name="waktu_mulai"/>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" id="waktu_selesai_baru" name="waktu_selesai"/>
                                                                    <!--<input type="text" class="form-control time " id="jam_selesai_baru" name="jam_selesai"/>-->
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="div_aktivitas_biaya">
                                                                <label class="col-lg-2 control-label">Biaya</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" class="form-control" id="biaya_baru" name="biaya"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="div_file_aktivitas">
                                                                <label class="col-lg-2 control-label">File Lampiran</label>
                                                                <div class="col-lg-8">
                                                                    <table class="table" id="tabel_berkas_aktivitas"></table>
                                                                    <button class="btn btn-info" id="button_pilih_berkas_aktivitas" onclick="return pilih_berkas_aktivitas();
                                                                            return false;">Pilih Berkas</button>
                                                                    <div style="display:none">
                                                                        <input type="file" id="file_berkas_aktivitas" name="berkas_aktivitas[]" multiple=""/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-8 col-lg-offset-2">
                                                                    <button class="btn btn-warning" id="button_simpan_aktivitas" onclick="simpan_aktivitas()" type="button">Simpan Aktivitas</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id_pekerjaan" value="<?= $pekerjaan['id_pekerjaan'] ?>"/>
                                                        <input type="hidden" name="id_akun" value="<?= $detil_pekerjaan['id_akun'] ?>"/>
                                                    </form>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_aktivitas">
                                                        <thead>
                                                            <tr>
                                                                <th>Aksi</th>
                                                                <th>No</th>
                                                                <th>Keterangan</th>
                                                                <!--<th>AK</th>-->
                                                                <!--<th>Kuantitas Output</th>-->
                                                                <!--<th>Kualitas Mutu</th>-->
                                                                <th>Waktu</th>
                                                                <th>Berkas</th>
                                                                <!--<th>Biaya</th>-->
                                                                <th>Validation</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_aktivitas_body">
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_progress">
                                                        <thead>
                                                            <tr>
                                                                <th>Aksi</th>
                                                                <th>No</th>
                                                                <th>Keterangan</th>
                                                                <th>Nilai Progress</th>
                                                                <th>Waktu</th>
                                                                <th>Berkas</th>
                                                                <th>Validation</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_aktivitas_body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="panel-body" id="div_penilaian_skp" style="display:none">
                                                    <h4 style="color: #1FB5AD;">
                                                        Detil Pekerjaan
                                                    </h4>
<!--                                                    <table class="table table-striped table-hover table-condensed" id="" >
                                                        <thead>
                                                            <tr >
                                                                <th style="vertical-align: middle" rowspan="2">Kegiatan</th>
                                                                <th style="vertical-align: middle; text-align: center" colspan="5">Sasaran</th>
                                                                <th style="vertical-align: middle; text-align: center" colspan="5">Realisasi</th>
                                                                <th style="vertical-align: middle" rowspan="2">Penghitungan</th>
                                                            </tr>
                                                            <tr>
                                                                <th>AK</th>
                                                                <th>Kuantitas Output</th>
                                                                <th>Kualitas Mutu</th>
                                                                <th>Waktu</th>
                                                                <th>Biaya</th>
                                                                <th>AK</th>
                                                                <th>Kuantitas Output</th>
                                                                <th>Kualitas Mutu</th>
                                                                <th>Waktu</th>
                                                                <th>Biaya</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="">
                                                            <tr>
                                                                <td><?= $pekerjaan['nama_pekerjaan'] ?></td>
                                                                <td><?= $detil_pekerjaan['sasaran_angka_kredit'] ?></td>
                                                                <td><?= $detil_pekerjaan['sasaran_kuantitas_output'] . ' ' . $detil_pekerjaan['satuan_kuantitas'] ?></td>
                                                                <td><?= $detil_pekerjaan['sasaran_kualitas_mutu'] ?>%</td>
                                                                <td><?= $detil_pekerjaan['sasaran_waktu'] .' '.$detil_pekerjaan['satuan_waktu'] ?></td>
                                                                <td><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['sasaran_biaya'],2,',','.') : '-' ?></td>
                                                                <td><?= $detil_pekerjaan['realisasi_angka_kredit'] ?></td>
                                                                <td><?= $detil_pekerjaan['realisasi_kuantitas_output'] . ' ' . $detil_pekerjaan['satuan_kuantitas'] ?></td>
                                                                <td><?= $detil_pekerjaan['realisasi_kualitas_mutu'] ?>%</td>
                                                                <td><?= $detil_pekerjaan['realisasi_waktu'] .' '.$detil_pekerjaan['satuan_waktu'] ?></td>
                                                                <td><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['realisasi_biaya'],2,',','.') : '-' ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>-->
                                                    <table class="table table-striped table-hover table-condensed" id="" >
                                                        <tbody id="">
                                                            <tr>
                                                                <td></td>
                                                                <th>AK</th>
                                                                <th>Kuantitas Output</th>
                                                                <th>Kualitas Mutu</th>
                                                                <th>Waktu</th>
                                                                <th>Biaya</th>
                                                            </tr>
                                                            <tr>
                                                                <th >Sasaran</th>
                                                            
                                                                <td><?= $detil_pekerjaan['sasaran_angka_kredit'] ?></td>
                                                                <td><?= $detil_pekerjaan['sasaran_kuantitas_output'] . ' ' . $detil_pekerjaan['satuan_kuantitas'] ?></td>
                                                                <td><?= $detil_pekerjaan['sasaran_kualitas_mutu'] ?>%</td>
                                                                <td><?= $detil_pekerjaan['sasaran_waktu'] .' '.$detil_pekerjaan['satuan_waktu'] ?></td>
                                                                <td><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['sasaran_biaya'],2,',','.') : '-' ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Realisasi</th>
                                                                <td><?= $detil_pekerjaan['realisasi_angka_kredit'] ?></td>
                                                                <td><?= $detil_pekerjaan['realisasi_kuantitas_output'] . ' ' . $detil_pekerjaan['satuan_kuantitas'] ?></td>
                                                                <td><?= $detil_pekerjaan['realisasi_kualitas_mutu'] ?>%</td>
                                                                <td><?= $detil_pekerjaan['realisasi_waktu'] .' '.$detil_pekerjaan['satuan_waktu'] ?></td>
                                                                <td><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['realisasi_biaya'],2,',','.') : '-' ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Penghitungan</th>
                                                                <td colspan="5"><?= number_format($detil_pekerjaan['progress'],2) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nilai SKP</th>
                                                                <td colspan="5"><?= number_format($detil_pekerjaan['skor'],2) ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </section>
                                        </div>
                                        <div class="col-md-12" id="anggota_tim">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Anggota Tim
                                                </h4>
                                                <div class="panel-body">
                                                    <?php $skp = in_array($pekerjaan['kategori'], array('rutin', 'project')); ?>
                                                    <table class="table table-striped table-hover table-condensed" id="staff_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama</th>
                                                                <th><?=$skp==true?'Nilai':'Progress'?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $counter = 0;
                                                            foreach ($detil_pekerjaans as $dp) {
                                                                if (!isset($user[$dp['id_akun']]))
                                                                    continue;
                                                                $counter++;
                                                                echo '<tr>';
                                                                if ($pekerjaan['id_sifat_pekerjaan'] == '2') {
                                                                    echo '<td><a  href="' . site_url() . '/pekerjaan_staff/detail_aktivitas?id_pekerjaan=' . $pekerjaan['id_pekerjaan'] . '&id_staff=' . $dp['id_akun'] . '" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-eye"> Lihat Aktivitas</i></a></td>';
                                                                } else {
                                                                    echo '<td>' . $counter . '</td>';
                                                                }
                                                                echo '<td>' . $user[$dp['id_akun']]->nama . '</td>';
                                                                if ($skp == true) {
                                                                    echo '<td>' . number_format(floatval($dp['skor']), 2) . '</td>';
                                                                } else {
                                                                    echo '<td><div class="progress progress-striped progress-xs">'
                                                                    . '<div style="width: ' . $dp['progress'] . '%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="' .$dp['progress']. '" role="progressbar" class="progress-bar progress-bar-warning" title="progress '.$dp['progress'].'%">'
                                                                    . '<span class="sr-only">'.$dp['progress'].'% Complete (success)</span>'
                                                                    . '</div>'
                                                                    . '</div></td>';
                                                                }
                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="modal fade" id="modal_perpanjang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Permintaan Perpanjangan</h4>
                                                    </div>
                                                    <div class="form modal-body">
                                                        <div class="col-lg-12">
                                                            <textarea class="form-control" id="alasan_perpanjangan" rows="10" placeholder="Isi Alasan Perpanjangan"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" onclick="minta_perpanjang();" type="button">Kirim Permintaan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       


                                        <div class="panel-body">
                                            <form style="display:none" class="cmxform form-horizontal " id="signupForm" method="POST" action="#<?php //echo site_url()                                                                                 ?>/pekerjaan/usulan_pekerjaan">
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <button id="komentar" class="btn btn-primary" type="button">Lihat Komentar</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div id="box_komentar" style="display: block">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal " id="signupForm" method="post" action="javascript:void(0)">
                                                        <input type="hidden" id="is_isi_komentar" name="is_isi_komentar" value="true"/>
                                                        <input type="hidden" id="id_detail_pkj" name="id_detail_pkj" value="<?php echo $pekerjaan['id_pekerjaan'] ?>"/>
                                                        <div class="form-group">
                                                            <div id="lihat_komen" class="col-lg-12">

                                                            </div>
                                                            <div id="tes" class="col-lg-12">

                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="col-lg-12">
                                                                <textarea class="form-control" id="komentar_pkj" name="komentar_pkj" rows="12"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <button id="save_komen" class="btn btn-primary" type="button">Tambah Komentar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!--script for this page only-->

            </section>
        </section>
        <iframe id="frame_tambah_aktivitas" name="frame_tambah_aktivitas" style="display:none"></iframe>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
    <script src="<?php echo base_url() ?>assets/js2/pekerjaan_saya/js_detail.js"></script>
    <?php
    $this->load->view("taskman_footer_page");
    ?>
    <script>
                                                                var id_pekerjaan = <?= $pekerjaan['id_pekerjaan'] ?>;
                                                                var base_url = '<?= base_url() ?>';
                                                                var site_url = '<?= site_url() ?>';
                                                                var id_staff = '<?= $detil_pekerjaan['id_akun'] ?>';
                                                                var list_akun =<?= json_encode($users) ?>;
                                                                var detil_pekerjaan =<?= json_encode($detil_pekerjaan) ?>;
                                                                var pekerjaan = <?= json_encode($pekerjaan) ?>;
                                                                var file_pekerjaan = <?= json_encode($list_file_pendukung) ?>;
                                                                $(document).ready(function () {
                                                                    document.title = 'Deskripsi Pekerjaan: <?php echo $pekerjaan['nama_pekerjaan']; ?> - Task Management';
                                                                    $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + $('#id_detail_pkj').val());
                                                                });

                                                                function _(el) {
                                                                    return document.getElementById(el);
                                                                }
                                                                function progressHandler(event) {
                                                                    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
                                                                    var percent = (event.loaded / event.total) * 100;
                                                                    _("progressBar").value = Math.round(percent);
                                                                    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                                                                }
                                                                function completeHandler(event) {
                                                                    _("status").innerHTML = '';
                                                                    _("progressBar").value = 0;
                                                                }
                                                                function errorHandler(event) {
                                                                    _("status").innerHTML = "Upload Failed";
                                                                }
                                                                function abortHandler(event) {
                                                                    _("status").innerHTML = "Upload Aborted";
                                                                }

                                                                function uploadFile() {
                                                                    $(".tampil_progress").css("display", "block");
                                                                    var file = _("file1").files[0];
                                                                    var idp = document.getElementById("id_pkj").value;
                                                                    var nama_file = document.getElementById("nama_file").value;
                                                                    if (file.type === "application/pdf" || file.type === "application/x-download" || file.type === "application/msword")
                                                                    {
                                                                        var formdata = new FormData();
                                                                        formdata.append("file1", file);
                                                                        formdata.append("id_pekerjaan", idp);
                                                                        if (file.type === "application/x-download" || file.type === "application/pdf") {
                                                                            formdata.append("nama_file", nama_file + "_" + new Date().toDateString() + ".pdf");
                                                                        }
                                                                        else
                                                                        {
                                                                            formdata.append("nama_file", nama_file + "_" + new Date().toDateString() + ".doc");
                                                                        }
                                                                        var ajax = new XMLHttpRequest();
                                                                        ajax.upload.addEventListener("progress", progressHandler, false);
                                                                        ajax.addEventListener("load", completeHandler, false);
                                                                        ajax.addEventListener("error", errorHandler, false);
                                                                        ajax.addEventListener("abort", abortHandler, false);
                                                                        ajax.open("POST", "<?php echo site_url() ?>/file_upload_parser");
                                                                        ajax.send(formdata);
                                                                    }
                                                                    else
                                                                    {
                                                                        //alert(file.name+" | "+file.size+" | "+file.type); 

                                                                        alert("Silahkan upload hanya pdf dan ms word < 2007 saja.");
                                                                    }
                                                                    //alert(file.name+" | "+file.size+" | "+file.type); 

                                                                }
                                                                function hapus_file(id_file, deskripsi)
                                                                {
                                                                    var c = confirm("Anda yakin menghapus file " + deskripsi + "?");
                                                                    if (c == true) {
                                                                        $.ajax({// create an AJAX call...
                                                                            data: {id_file: id_file,
                                                                                id_pekerjaan: <?php echo $pekerjaan['id_pekerjaan']; ?>
                                                                            }, // get the form data
                                                                            type: "get", // GET or POST
                                                                            url: "<?php echo site_url(); ?>/pekerjaan/hapus_file", // the file to call
                                                                            success: function (response) { // on success..
                                                                                var json = jQuery.parseJSON(response);
                                                                                //alert(response);
                                                                                if (json.status === "OK") {
                                                                                    $('#berkas_' + id_file).remove();
                                                                                    //$('#tombol_validasi_usulan').remove();
                                                                                } else {
                                                                                    alert("Gagal menghapus file, " + json.reason);
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                    else {
                                                                    }
                                                                }
                                                                function ubah_komentar(id_komen) {
                                                                    $.ajax({// create an AJAX call...
                                                                        data: {
                                                                            id_komentar_ubah: id_komen
                                                                        },
                                                                        type: "GET", // GET or POST
                                                                        url: "<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan_by_id", // the file to call
                                                                        success: function (response) { // on success..
                                                                            var json = jQuery.parseJSON(response);
                                                                            $("#komentar_pkj_ubah").val(json.data);
                                                                        }
                                                                    });
                                                                    $('#ubah_komen').click(function (e) {
                                                                        e.preventDefault();
                                                                        var id_pkj = document.getElementById('id_detail_pkj').value;
                                                                        $.ajax({// create an AJAX call...
                                                                            data: {
                                                                                id_komentar_ubah: id_komen,
                                                                                isi_komentar_ubah: $('#komentar_pkj_ubah').val()
                                                                            }, // get the form data
                                                                            type: "GET", // GET or POST
                                                                            url: "<?php echo site_url(); ?>/pekerjaan/ubah_komentar_pekerjaan", // the file to call
                                                                            success: function (response) { // on success..
                                                                                //var json = jQuery.parseJSON(response);
                                                                                $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                                                                            }
                                                                        });
                                                                    });
                                                                }

                                                                function hapus(id) {
                                                                    $('#hapus_komen').click(function (e) {
                                                                        //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                                                                        e.preventDefault();
                                                                        var id_pkj = document.getElementById('id_detail_pkj').value;
                                                                        $.ajax({// create an AJAX call...
                                                                            data:
                                                                                    {
                                                                                        id_komentar: id
                                                                                    }, // get the form data                     type: "GET", // GET or POST
                                                                            url: "<?php echo site_url(); ?>/pekerjaan/hapus_komentar_pekerjaan", // the file to call
                                                                            success: function (response) { // on success..
                                                                                $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                                                                            }
                                                                        });
                                                                    });
                                                                }


                                                                $('#save_komen').click(function (e) {
                                                                    //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                                                                    e.preventDefault();
                                                                    var id_pkj = document.getElementById('id_detail_pkj').value;
                                                                    $.ajax({// create an AJAX call...
                                                                        data:
                                                                                {
                                                                                    id_detail_pkj: document.getElementById('id_detail_pkj').value, // get the form data
                                                                                    komentar_pkj: document.getElementById('komentar_pkj').value,
                                                                                    is_isi_komentar: document.getElementById('is_isi_komentar').value
                                                                                }, // get the form data
                                                                        type: "GET", // GET or POST
                                                                        url: "<?php echo site_url(); ?>/pekerjaan/komentar_pekerjaan", // the file to call
                                                                        success: function (response) { // on success..
                                                                            $('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
                                                                            document.getElementById('komentar_pkj').value = '';
                                                                        }
                                                                    });
                                                                });
    </script>