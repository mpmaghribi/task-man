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
                            $prioritas = array(1 => 'Urgent', 2 => 'Tinggi', 3 => 'Sedang', 4 => 'Rendah');
                            //var_dump($my_staff);
                            $counter = 0;
                            foreach ($list_draft as $draft) {
                                $counter++;
                                echo '<tr>';
                                echo '<td >' . $counter . '</td>';
                                echo '<td>' . $draft->nama_pekerjaan . '</td>';
                                echo '<td>' . date("d M Y", strtotime($draft->tgl_mulai)) . ' - ' . date("d M Y", strtotime($draft->tgl_selesai)) . '</td>';
                                echo '<td>' . $prioritas[$draft->level_prioritas] . '</td>';
                                ?><td style="text-align: right">
                        <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -5px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>draft/assign?id_draft=<?php echo $draft->id_pekerjaan; ?>" id="" style="font-size: 10px">Assign</a>
                                <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>draft/edit?id_draft=<?php echo $draft->id_pekerjaan; ?>" id="" style="font-size: 10px">Edit</a>
                                <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>draft/view?id_draft=<?php echo $draft->id_pekerjaan; ?>" id="" style="font-size: 10px">View</a>
                                <a class="btn btn-warning btn-xs" href="javascript:void(0);" id="" onclick="confirm_batal(<?php echo $draft->id_pekerjaan?>,'<?php echo $draft->nama_pekerjaan; ?>');" style="font-size: 10px">Batalkan</a>
                                    
                            </div><script>
                                        var url_hapus= '<?php echo base_url(); ?>draft/batalkan?id_draft=';
                                        function confirm_batal(id_draft, judul){
                                            var myurl = url_hapus+id_draft;
                                            var c = confirm('apakah anda yakin menghapus draft "' + judul + '"?');
                                            if(c===true){
                                                window.location=myurl;
                                            }
                                        }
                                        </script></td><?php
                            echo '</tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section></div>