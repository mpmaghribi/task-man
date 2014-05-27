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
                                echo '<td>' . date("d M Y", strtotime($draft->tgl_mulai)) . ' - '. date("d M Y", strtotime($draft->tgl_selesai)) . '</td>';
                                echo '<td>' . $prioritas[$draft->level_prioritas] . '</td>';
                                echo '<td style="text-align: right"><a class="btn btn-info btn-xs" href="'.base_url().'draft/assign?id_draft='.$draft->id_pekerjaan.'" id="" style="font-size: 10px">Assign</a><a class="btn btn-danger btn-xs" href="'.base_url().'draft/edit?id_draft='.$draft->id_pekerjaan.'" id="" style="font-size: 10px">Edit</a></td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section></div>