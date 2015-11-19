<?php $this->load->view("taskman_header_page"); ?> 
<?php
$user = array();
foreach ($users as $u) {
    $user[$u->id_akun] = $u;
}
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
                                                <p style="font-size: larger"><?php echo $pekerjaan['kategori']; ?></p>
                                                <h4 style="color: #1FB5AD;">Deadline</h4>
                                                <p style="font-size: larger">
                                                    <?php
                                                    echo date("d M Y", strtotime(substr($pekerjaan['tgl_mulai'], 0, 19)));
                                                    echo " - ";
                                                    echo date("d M Y", strtotime(substr($pekerjaan['tgl_selesai'], 0, 19)));
                                                    ?>
                                                </p>
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
                                                                <th>AK</th>
                                                                <th>Kuantitas Output</th>
                                                                <th>Kualitas Mutu</th>
                                                                <th>Waktu</th>
                                                                <th>Biaya</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabel_aktivitas_body">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>                                            
                                        </div>
                                        <div class="col-md-12" id="anggota_tim">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    Staff Lain yang Mengerjakan Tugas Ini
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="staff_pekerjaan">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nama</th>
                                                                <th>Nilai</th>
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
                                                                echo '<td><a  href="' . base_url() . 'pekerjaan_staff/detail_aktivitas?id_pekerjaan=' . $pekerjaan['id_pekerjaan'] . '&id_staff=' . $dp['id_akun'] . '" class="btn btn-success btn-xs" target=""><i class="fa fa-eye"> Lihat Aktivitas</i></a></td>';
                                                                echo '<td>' . $user[$dp['id_akun']]->nama . '</td>';
                                                                echo '<td>' . number_format(floatval($dp['skor']), 2) . '</td>';
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
        var id_staff = '<?= $detil_pekerjaan['id_akun'] ?>';
        var list_user =<?= json_encode($users) ?>;
        var detil_pekerjaan=<?=json_encode($detil_pekerjaan)?>;
        $(document).ready(function () {
            document.title = 'Detail Aktivitas Pekerjaan: <?php echo $pekerjaan['nama_pekerjaan']; ?> - Task Management';
            $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
            $('#submenu_pekerjaan_ul').show();
            $('#staff_pekerjaan').dataTable({
                "columnDefs": [{"targets": [0], "orderable": false}],
            });
            init_tabel_aktivitas();
        });
        var tabel_aktivitas = null;
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
                        id_staff: id_staff,
                        id_pekerjaan: id_pekerjaan
                    },
                    "url": base_url + "aktivitas_pekerjaan/get_list_aktivitas_pekerjaan",
                    "dataSrc": function (json) {
                        var jsonData = json.data;
                        return jsonData;
                    }
                },
                "createdRow": function (row, data, index) {
                    var tgl_mulai = data[6];
                    var tgl_mulai_tmzn = tgl_mulai.split('+');
                    var tgl_jam_mulai = tgl_mulai_tmzn[0].split(' ');
                    var tgl_selesai = data[8];
                    var tgl_selesai_tmzn = tgl_selesai.split('+');
                    var tgl_jam_selesai = tgl_selesai_tmzn[0].split(' ');
                    $('td', row).eq(6).html(tgl_jam_mulai[0] + ' - ' + tgl_jam_selesai[0]);
                    $('td', row).eq(0).html('');
                    $('td', row).eq(4).html(data[4] + ' ' + detil_pekerjaan['satuan_kuantitas']);
                    $('td', row).eq(5).html(data[5] + '%');
//            $('td', row).eq(5).html('<a  href="' + base_url + 'pekerjaan_staff/detail?id_pekerjaan=' + data[0] + '" class="btn btn-success btn-xs"><i class="fa fa-eye">View</i></a>');
                    $(row).attr('id', 'row_' + index)
                }
            });
        }
    </script>