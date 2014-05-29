<div id="PekerjaanStaff" class="tab-pane ">
    <section class="panel">
        <header class="panel-heading">
            Daftar  Pekerjaan staff
        </header>
        <div class="panel-body">
            <div class="form">
                <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="hidden-phone">Pekerjaan</th>
                            <th>Deadline</th>
                            <th>Assign To</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th style="text-align: right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($pekerjaan_staff)) {
                            $prioritas = array(1 => 'Urgent', 2 => 'Tinggi', 3 => 'Sedang', 4 => 'Rendah');
                            $list_status = array(1 => 'Not Approved', 2 => 'Approved');
                            $label_status = array(1 => 'label-danger', 2 => 'label-success');
                            //var_dump($my_staff);
                            $counter = 0;
                            foreach ($pekerjaan_staff as $kerja) {
                                $counter++;
                                echo '<tr>';
                                echo '<td >' . $counter . '</td>';
                                echo '<td>' . $kerja->nama_pekerjaan . '</td>';
                                echo '<td>' . date("d M Y", strtotime($kerja->tgl_mulai)) . ' - ' . date("d M Y", strtotime($kerja->tgl_selesai)) . '</td>';
                                echo '<td id="list_staff_' . $kerja->id_pekerjaan . '"></td>';
                                echo '<td>' . $prioritas[$kerja->level_prioritas] . '</td>';
                                echo '<td id="status_' . $kerja->id_pekerjaan . '"><span class="label ' . $label_status[$kerja->flag_usulan] . ' label-mini">' . $list_status[$kerja->flag_usulan] . '</span></td>';
                                ?>
                            <td style="text-align: right">
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: 0px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>pekerjaan/edit?id_detail_pkj=<?php echo $kerja->id_pekerjaan; ?>" id="" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>pekerjaan/deskripsi_pekerjaan?id_detail_pkj=<?php echo $kerja->id_pekerjaan; ?>" id="" style="font-size: 10px">View</a>
                                </div>
                            </td>
                            <?php
                            echo '</tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <script>
                    var list_user = [];
                    function set_assign_to(id, nama){
                        var sep='';
                        if($('#'+id).html().length>0)
                            sep=', ';
                        $('#'+id).html($('#'+id).html()+sep+nama);
                    }
<?php foreach ($users as $user) {
    ?>list_user[<?php echo $user->id_akun; ?>] = '<?php echo $user->nama; ?>';
    <?php
}
foreach ($detil_pekerjaan as $detil) {
    ?>set_assign_to('list_staff_<?php echo $detil->id_pekerjaan; ?>',list_user[<?php echo $detil->id_akun; ?>]);
    <?php
}
?>
                </script>
            </div>
        </div>
    </section>
</div>