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
                                                <p style="font-size: larger"><?= $pekerjaan['kategori'] == 'rutin' ? $pekerjaan['periode'] : explode(' ', $pekerjaan['tgl_mulai'])[0] . ' - ' . explode(' ', $pekerjaan['tgl_selesai'])[0] ?></p>
                                            </section>
                                        </div>
                                        <div class="col-md-12" id="list_aktivitas">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Daftar Aktivitas Pekerjaan
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="tabel_aktivitas">
                                                        <thead>
                                                            <tr>
                                                                <th>Aksi</th>
                                                                <th>No</th>
                                                                <th>Keterangan</th>
                                                                <!--<th>AK</th>-->
                                                                <th>Kuantitas Output</th>
                                                                <!--<th>Kualitas Mutu</th>-->
                                                                <th>Waktu</th>
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
                                            </section>                                            
                                        </div>
                                        <div class="panel-body" id="div_penilaian_skp" style="display:none">
                                            <h4 style="color: #1FB5AD;">
                                                Detil Pekerjaan
                                            </h4>
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
                                                        <td><?= $detil_pekerjaan['sasaran_waktu'] . ' ' . $detil_pekerjaan['satuan_waktu'] ?></td>
                                                        <td><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['sasaran_biaya'], 2, ',', '.') : '-' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Realisasi</th>
                                                        <td><?= $detil_pekerjaan['realisasi_angka_kredit'] ?></td>
                                                        <td><?= $detil_pekerjaan['realisasi_kuantitas_output'] . ' ' . $detil_pekerjaan['satuan_kuantitas'] ?></td>
                                                        <td><?= $detil_pekerjaan['realisasi_kualitas_mutu'] ?>%</td>
                                                        <td><?= $detil_pekerjaan['realisasi_waktu'] . ' ' . $detil_pekerjaan['satuan_waktu'] ?></td>
                                                        <td><?= $detil_pekerjaan['pakai_biaya'] == '1' ? 'Rp. ' . number_format($detil_pekerjaan['realisasi_biaya'], 2, ',', '.') : '-' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Penghitungan</th>
                                                        <td colspan="5"><?= $detil_pekerjaan['progress'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nilai SKP</th>
                                                        <td colspan="5"><?= $detil_pekerjaan['skor'] ?></td>
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
                                                                if ($dp['id_akun'] == $detil_pekerjaan['id_akun']) {
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
        $(document).ready(function () {
            document.title = 'Detail Aktivitas Pekerjaan: <?php echo $pekerjaan['nama_pekerjaan']; ?> - Task Management';
            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
            $('#submenu_pekerjaan_ul').show();
            $('#staff_pekerjaan').dataTable({
                columnDefs: [{targets: [0], orderable: false}],
                order: [[1, "asc"]]
            });
            if (pekerjaan['kategori'] == 'rutin' || pekerjaan['kategori'] == 'project') {
                init_tabel_aktivitas();
                $('#tabel_progress').hide();
                $('#div_penilaian_skp').show();
            } else {
                init_tabel_progress();
                $('#tabel_aktivitas').hide();
            }
        });
        var tabel_aktivitas = null;
        function init_tabel_progress() {
            if (tabel_aktivitas != null) {
                tabel_aktivitas.fnDestroy();
            }
            tabel_aktivitas = $('#tabel_progress').dataTable({
                order: [[1, "asc"]],
                "columnDefs": [{"targets": [0], "orderable": false}],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'method': 'post',
                    'data': {
                        id_detil_pekerjaan: detil_pekerjaan['id_detil_pekerjaan'],
                        id_pekerjaan: id_pekerjaan
                    },
                    "url": site_url + "/aktivitas_pekerjaan/get_list_progress_pekerjaan_datatable",
                    "dataSrc": function (json) {
                        var jsonData = json.data;
                        return jsonData;
                    }
                },
                "createdRow": function (row, data, index) {
                    var tgl_mulai = data[4];
                    var tgl_mulai_tmzn = tgl_mulai.split('+');
                    var tgl_jam_mulai = tgl_mulai_tmzn[0].split(' ');
                    var tgl_selesai = data[6];
                    var tgl_selesai_tmzn = tgl_selesai.split('+');
                    var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
                    var id = data[1];

                    var validated = parseInt(data[7]);
                    var list_berkas = JSON.parse(data[8]);
                    var list_id_berkas = JSON.parse(data[9]);
                    var html_berkas = '';
                    if (list_berkas != null) {
                        for (var i = 0, n = list_berkas.length; i < n; i++) {
                            html_berkas += '<a href="' + site_url + '/download?id_file=' + list_id_berkas[i] + '" target="_blank" title="' + list_berkas[i] + '"><i class="fa fa-paperclip fa-fw"></i></a> ';
                        }
                    }
                    var html = '<div class="btn-group">'
                            + '<button class="btn btn-default btn-xs dropdown-toggle btn-info" data-toggle="dropdown">Aksi <span class="caret"></span></button>'
                            + '<ul class="dropdown-menu">';
                    if (validated == 0) {
                        html += '<li><a href="javascript:viewValidateProgress(' + id + ');"><i class="fa fa-check fa-fw"></i> Validasi</a></li>';
                    }
                    html += '<li><a href="javascript:viewHapusProgress(' + id + ');"><i class="fa fa-times fa-fw"></i> Hapus</a></li>';
                    html += '</ul></div>';

                    $('td', row).eq(4).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);
                    $('td', row).eq(0).html(html);

                    $('td', row).eq(1).html(index + 1);
                    $('td', row).eq(3).html(data[3] + '%');
                    $('td', row).eq(5).html(html_berkas);
                    $('td', row).eq(6).html('Unvalidated');
                    if (validated == 1) {
                        $('td', row).eq(6).html('Validated');
                    }

                    $(row).attr('id', 'row_' + id)
                }
            });
        }
        function init_tabel_aktivitas() {
            if (tabel_aktivitas != null) {
                tabel_aktivitas.fnDestroy();
            }
            tabel_aktivitas = $('#tabel_aktivitas').dataTable({
                order: [[1, "asc"]],
                "columnDefs": [{"targets": [0], "orderable": false}],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'method': 'post',
                    'data': {
                        id_detil_pekerjaan: detil_pekerjaan['id_detil_pekerjaan'],
                        id_pekerjaan: id_pekerjaan
                    },
                    "url": site_url + "/aktivitas_pekerjaan/get_list_aktivitas_pekerjaan",
                    "dataSrc": function (json) {
                        var jsonData = json.data;
                        return jsonData;
                    }
                },
                "createdRow": function (row, data, index) {
                    var id = data[1];
                    var tgl_mulai = data[4];
                    var tgl_mulai_tmzn = tgl_mulai.split('+');
                    var tgl_jam_mulai = tgl_mulai_tmzn[0].split(' ');
                    var tgl_selesai = data[9];
                    var tgl_selesai_tmzn = tgl_selesai.split('+');
                    var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
                    var status_validasi = parseInt(data[5]);
                    var html = '<div class="btn-group">'
                            + '<button class="btn btn-default btn-xs dropdown-toggle btn-info" data-toggle="dropdown">Aksi <span class="caret"></span></button>'
                            + '<ul class="dropdown-menu">';
                    if (status_validasi == 0) {
                        html += '<li><a href="javascript:viewValidasiAktivitas(' + id + ');"><i class="fa fa-check fa-fw"></i> Validasi</a></li>';
                    }
                    html += '<li><a href="javascript:viewHapusAktivitas(' + id + ');"><i class="fa fa-times fa-fw"></i> Hapus</a></li>';
                    html += '</ul></div>';
                    $('td', row).eq(0).html(html);
                    $('td', row).eq(1).html(index + 1);
                    $('td', row).eq(3).html(data[3] + ' ' + detil_pekerjaan['satuan_kuantitas']);
                    $('td', row).eq(4).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);

                    if (status_validasi == 1) {
                        $('td', row).eq(5).html('Validated');
                    } else {
                        $('td', row).eq(5).html('Unvalidated');
                    }
                    $(row).attr('id', 'row_' + id)
                }
            });
        }
        function viewValidateProgress(id) {
            var row = $('#row_' + id);
            var deskripsi = $(row.children()[2]).html();
            if (confirm('Anda akan memvalidasi progress ' + deskripsi + '?') == true) {
                $.ajax({
                    type: "POST",
                    url: site_url + "/aktivitas_pekerjaan/validate_progress",
                    data: {
                        id_progress: id
                    },
                    success: function (data) {
                        if (data == 'ok') {
                            tabel_aktivitas.fnDraw();
                        } else {
                            alert(data);
                        }
                        $('.snake_loader').remove();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.snake_loader').remove();
                    }
                });
            }
        }
        function viewValidasiAktivitas(id) {
            var row = $('#row_' + id);
            var deskripsi = $(row.children()[2]).html();
            if (confirm('Anda akan memvalidasi aktivitas ' + deskripsi + '?') == true) {
                $.ajax({
                    type: "POST",
                    url: site_url + "/aktivitas_pekerjaan/validate_aktivitas",
                    data: {
                        id_aktivitas: id
                    },
                    success: function (data) {
                        if (data == 'ok') {
                            tabel_aktivitas.fnDraw();
                        } else {
                            alert(data);
                        }
                        $('.snake_loader').remove();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.snake_loader').remove();
                    }
                });
            }
        }
        function viewHapusProgress(id) {
            var row = $('#row_' + id);
            var deskripsi = $(row.children()[2]).html();
            if (confirm('Anda akan menghapus progress ' + deskripsi + '?') == true) {
                $.ajax({
                    type: "POST",
                    url: site_url + "/aktivitas_pekerjaan/hapus_progress",
                    data: {
                        id_progress: id
                    },
                    success: function (data) {
                        if (data == 'ok') {
                            tabel_aktivitas.fnDraw();
                        } else {
                            alert(data);
                        }
                        $('.snake_loader').remove();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.snake_loader').remove();
                    }
                });
            }
        }
        function viewHapusAktivitas(id) {
            var row = $('#row_' + id);
            var deskripsi = $(row.children()[2]).html();
            if (confirm('Anda akan menghapus aktivitas ' + deskripsi + '?') == true) {
                $.ajax({
                    type: "POST",
                    url: site_url + "/aktivitas_pekerjaan/hapus_aktivitas",
                    data: {
                        id_aktivitas: id
                    },
                    success: function (data) {
                        if (data == 'ok') {
                            tabel_aktivitas.fnDraw();
                        } else {
                            alert(data);
                        }
                        $('.snake_loader').remove();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.snake_loader').remove();
                    }
                });
            }
        }
    </script>