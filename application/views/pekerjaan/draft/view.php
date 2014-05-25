<div id="div_view_draft" class="tab-pane active">
    <section class="panel">
        <header class="panel-heading">
            Daftar Draft Pekerjaan
        </header>
        <div class="panel-body">
            <div class="form">
                <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="hidden-phone">Nama Pekerjaan</th>
                            <th class="hidden-phone">Waktu Pekerjaan</th>
                            <th class="hidden-phone">Prioritas</th>
                            <th style="text-align: right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($list_draft)) {
                            $prioritas = array(1=>'Urgent',2=>'Tinggi',3=>'Sedang',4=>'Rendah');
                            //var_dump($my_staff);
                            $counter = 0;
                            foreach ($list_draft as $draft) {
                                $counter++;
                                echo '<tr>';
                                echo '<td >' . $counter . '</td>';
                                echo '<td>' . $draft->nama_pekerjaan . '</td>';
                                echo '<td>' . $draft->tgl_mulai . ' - '. $draft->tgl_selesai . '</td>';
                                echo '<td>' . $prioritas[$draft->level_prioritas] . '</td>';
                                echo '<td><form method="get" action="' . base_url() . 'pekerjaan/pekerjaan_per_staff"><input type="hidden" name="id_akun" value="' . $staff->id_akun . '"/><button type="submit" class="btn btn-success btn-xs" style="float:right;"><i class="fa fa-eye"></i>View</button></form></td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section></div>