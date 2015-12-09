<?php $this->load->view("taskman_header_page"); ?> 
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
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="deskripsiPekerjaan" class="tab-pane active">
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">Nama Staff</h4>
                                                <p style="font-size: larger"><?= $user[$detil_pekerjaan['id_akun']]->nama ?></p>
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
                                                <p style="font-size: larger"><?= explode(' ', $pekerjaan['tgl_mulai'])[0] . ' - ' . explode(' ', $pekerjaan['tgl_selesai'])[0] ?></p>
                                            </section>
                                        </div>
                                        <div class="col-md-12" id="list_aktivitas">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Daftar Aktivitas Pekerjaan
                                                </h4>
                                                <button class="btn btn-danger" id="button_validasi_semua" onclick="validasi_semua_aktivitas()" type="button">Validasi Semua</button>
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
                                                <button class="btn btn-danger" id="button_lock_nilai_progress" onclick="lock_nilai()" type="button">Lock</button>
                                            </section>                                            
                                        </div>
                                        <div class="panel-body" id="div_penilaian_skp" style="display:none">
                                            <h4 style="color: #1FB5AD;">
                                                Detil Pekerjaan
                                            </h4>
                                            <button class="btn btn-danger" id="button_lock_nilai" onclick="lock_nilai()" type="button">Lock</button>
                                            <button class="btn btn-success" id="button_tampilkan_form_penilaian" onclick="tampilkan_form_penilaian()" type="button">Ubah Penilaian</button>
                                            <button class="btn btn-success" id="button_simpan_penilaian" onclick="simpan_penilaian()" type="button">Simpan Penilaian</button>
                                            <button class="btn btn-danger" id="button_batal_penilaian" onclick="sembunyikan_form_penilaian()" type="button">Batal</button>
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
                                                        <td id="td_target_ak" class="td_view_nilai"><?= $detil_pekerjaan['sasaran_angka_kredit'] ?></td>
                                                        <td class="td_edit_nilai"><input type="text" id="input_target_ak" value="<?= $detil_pekerjaan['sasaran_angka_kredit'] ?>" placeholder="target angka kredit"/></td>
                                                        <td id="td_target_out" class="td_view_nilai"><?= $detil_pekerjaan['sasaran_kuantitas_output'] . ' ' . $detil_pekerjaan['satuan_kuantitas'] ?></td>
                                                        <td class="td_edit_nilai"><input type="text" id="input_target_output" value="<?= $detil_pekerjaan['sasaran_kuantitas_output'] ?>" placeholder="target kuantitas output"/><input type="text" id="input_satuan_kuantitas" value="<?= $detil_pekerjaan['satuan_kuantitas'] ?>" placeholder="satuan kuantitas"/></td>
                                                        <td id="td_target_mutu" class="td_view_nilai"><?= $detil_pekerjaan['sasaran_kualitas_mutu'] ?>%</td>
                                                        <td class="td_edit_nilai"><input type="text" id="input_target_mutu" value="<?= $detil_pekerjaan['sasaran_kualitas_mutu'] ?>" placeholder="target kualitas mutu"/></td>
                                                        <td><?= $detil_pekerjaan['sasaran_waktu'] . ' ' . $detil_pekerjaan['satuan_waktu'] ?></td>
                                                        <td id="td_target_biaya" class="td_view_nilai"><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['sasaran_biaya'], 2, ',', '.') : '-' ?></td>
                                                        <td class="td_edit_nilai"><input type="text" id="input_target_biaya" value="<?= $detil_pekerjaan['pakai_biaya'] == '1' ? $detil_pekerjaan['sasaran_biaya'] : '-' ?>" placeholder="target biaya"/></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Realisasi</th>
                                                        <td id="td_real_ak" class="td_view_nilai"><?= $detil_pekerjaan['realisasi_angka_kredit'] ?></td>
                                                        <td class="td_edit_nilai"><input type="text" id="input_realisasi_ak" value="<?= $detil_pekerjaan['realisasi_angka_kredit'] ?>" placeholder="realisasi angka kredit"/></td>
                                                        <td id="td_real_out"><?= $detil_pekerjaan['realisasi_kuantitas_output'] . ' ' . $detil_pekerjaan['satuan_kuantitas'] ?></td>
                                                        <td id="td_real_mutu" class="td_view_nilai"><?= $detil_pekerjaan['realisasi_kualitas_mutu'] ?>%</td>
                                                        <td class="td_edit_nilai"><input type="text" id="input_realisasi_mutu" value="<?= $detil_pekerjaan['realisasi_kualitas_mutu'] ?>"/></td>
                                                        <td><?= $detil_pekerjaan['realisasi_waktu'] . ' ' . $detil_pekerjaan['satuan_waktu'] ?></td>
                                                        <td id="td_real_biaya" class="td_view_nilai"><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['realisasi_biaya'], 2, ',', '.') : '-' ?></td>
                                                        <td class="td_edit_nilai"><input type="text" id="input_realisasi_biaya" value="<?= $detil_pekerjaan['pakai_biaya'] == '1' ? $detil_pekerjaan['realisasi_biaya'] : '-' ?>"/></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Penghitungan</th>
                                                        <td colspan="5" id="nilai_penghitungan"><?= number_format($detil_pekerjaan['progress'],2) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nilai SKP</th>
                                                        <td colspan="5" id="skor_skp"><?= number_format($detil_pekerjaan['skor'],2) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12" id="anggota_tim">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Staff Lain yang Mengerjakan Tugas Ini
                                                </h4>
                                                <div class="panel-body">
                                                    <?php $skp = in_array($pekerjaan['kategori'], array('rutin', 'project')); ?>
                                                    <table class="table table-striped table-hover table-condensed" id="staff_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama</th>
                                                                <th><?= $skp ? 'Nilai' : 'Progress' ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $counter = 0;
                                                            foreach ($detil_pekerjaans as $dp) {
                                                                if (!isset($user[$dp['id_akun']]))
                                                                    continue;
                                                                if ($dp['id_akun'] == $detil_pekerjaan['id_akun'] && in_array($pekerjaan['kategori'],array('rutin','project'))) {
                                                                    continue;
                                                                }
                                                                $counter++;
                                                                echo '<tr>';
                                                                echo '<td><a  href="' . site_url() . '/pekerjaan_staff/detail_aktivitas?id_pekerjaan=' . $pekerjaan['id_pekerjaan'] . '&id_staff=' . $dp['id_akun'] . '" class="btn btn-success btn-xs" target=""><i class="fa fa-eye"> Lihat Aktivitas</i></a></td>';
                                                                echo '<td>' . $user[$dp['id_akun']]->nama . '</td>';
//                                                                echo '<td>' . number_format(floatval($dp['skor']), 2) . '</td>';
                                                                if ($skp == true) {
                                                                    echo '<td>' . number_format(floatval($dp['skor']), 2) . '</td>';
                                                                } else {
                                                                    echo '<td><div class="progress progress-striped progress-xs">'
                                                                    . '<div style="width: ' . $dp['progress'] . '%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="' . $dp['progress'] . '" role="progressbar" class="progress-bar progress-bar-warning" title="progress ' . $dp['progress'] . '%">'
                                                                    . '<span class="sr-only">' . $dp['progress'] . '% Complete (success)</span>'
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
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!--script for this page only-->
                <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <?php
    $this->load->view("taskman_footer_page");
    ?>
    <script>
                                                var id_pekerjaan = <?= $pekerjaan['id_pekerjaan'] ?>;
                                                var base_url = '<?= base_url() ?>';
                                                var site_url = '<?= site_url() ?>';
                                                var id_staff = '<?= $detil_pekerjaan['id_akun'] ?>';
                                                var list_user =<?= json_encode($users) ?>;
                                                var detil_pekerjaan =<?= json_encode($detil_pekerjaan) ?>;
                                                var pekerjaan = <?= json_encode($pekerjaan); ?>;
    </script>
    <script src="<?=base_url()?>assets/js2/pekerjaan_staff/js_detail_aktivitas.js" type="text/javascript"></script>