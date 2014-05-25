<div id="div_view_draft" class="tab-pane active">
    <section class="panel">
        <header class="panel-heading">
            Daftar Staff
        </header>
        <div class="panel-body">
            <div class="form">
                <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="hidden-phone">NIP Staff</th>
                            <th class="hidden-phone">Nama Staff</th>
                            <th class="hidden-phone">Jabatan Staff</th>
                            <th class="hidden-phone">Departemen</th>
                            <th class="hidden-phone">Email Staff</th>
                            <th style="text-align: right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($my_staff)) {
                            //var_dump($my_staff);
                            $counter = 0;
                            foreach ($my_staff as $staff) {
                                $counter++;
                                echo '<tr>';
                                echo '<td >' . $counter . '</td>';
                                echo '<td>' . $staff->nip . '</td>';
                                echo '<td>' . $staff->nama . '</td>';
                                echo '<td>' . $staff->nama_jabatan . '</td>';
                                echo '<td>' . $staff->nama_departemen . '</td>';
                                echo '<td>' . $staff->email . '</td>';
                                echo '<td ><form method="get" action="' . base_url() . 'pekerjaan/pekerjaan_per_staff"><input type="hidden" name="id_akun" value="' . $staff->id_akun . '"/><button type="submit" class="btn btn-success btn-xs" style="float:right;"><i class="fa fa-eye"></i>View</button></form></td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section></div>