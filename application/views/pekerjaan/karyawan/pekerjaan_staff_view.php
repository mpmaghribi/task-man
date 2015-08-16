<div id="PekerjaanStaff" class="tab-pane col-md-12">
    <section class="panel">
        <header class="panel-heading">
            Daftar Pekerjaan staff
        </header>
        <div class="panel-body">
            <div class="form">
                <table class="table table-striped table-hover table-condensed" id="tabel_pekerjaan_staff">
                    <thead>
                        <tr>
                            <th style="width: 60px">No</th>
                            <th style="width: 200px"  class="hidden-phone">Pekerjaan</th>
                            <th style="width: 120px">Deadline</th>
                            <th>Assign To</th>
                            <th>Prioritas</th>
                            <th style="min-width: 100px">Status</th>
                            <th style="text-align: right;min-width: 200px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($pekerjaan_staff)) {
                            $prioritas = array(1 => 'Urgent', 2 => 'Tinggi', 3 => 'Sedang', 4 => 'Rendah');
                            $list_status = array(1 => 'Not Approved', 2 => 'Approved', 9 => 'Perpanjang');
                            $label_status = array(1 => 'label-danger', 2 => 'label-success', 9 => "label-inverse");
                            $label_prioritas = array(1 => 'label-danger', 2 => 'label-success', 3 => 'label-info', 4 => 'label-inverse');
                            //var_dump($my_staff);
                            $counter = 0;
                            $list_id_pekerjaan = array();
                            //$sekarang = date('Y-m-d');
                            foreach ($pekerjaan_staff as $kerja) {
                                if (!in_array($kerja->id_pekerjaan, $list_id_pekerjaan)) {
                                    $list_id_pekerjaan[] = $kerja->id_pekerjaan;
                                    $counter++;
                                    ?>
                                    <tr style="vertical-align: middle">
                                        <td style=""> <?php echo $counter; ?></td>
                                        <td style=""> <?php echo $kerja->nama_pekerjaan; ?></td>
                                        <td style=""><?= $kerja->tanggal_mulai ?> - <?= $kerja->tanggal_selesai ?></td>
                                        <td style="" id="list_staff_<?= $kerja->id_pekerjaan; ?>"></td>
                                        <td style=""><span class="label <?= $label_prioritas[$kerja->level_prioritas]; ?> label-mini"><?= $prioritas[$kerja->level_prioritas] ?></span></td>
                                        <td style="" id="pekerjaan_staff_status_<?= $kerja->id_pekerjaan ?>"><span class="label <?= $label_status[$kerja->flag_usulan] ?> label-mini"><?= $list_status[$kerja->flag_usulan] ?></span></td>
                                        <td style="text-align: right;">
                                            <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: 0px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                                <?php if ($kerja->flag_usulan == '1') { ?>
                                                    <a class="btn btn-info btn-xs" href="javascript:void(0);" id="tombol_validasi_usulan_<?php echo $kerja->id_pekerjaan; ?>" style="font-size: 10px" onclick="validasi_usulan(<?php echo $kerja->id_pekerjaan; ?>);">Validasi</a>
                                                <?php } ?>
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>pekerjaan/edit?id_pekerjaan=<?php echo $kerja->id_pekerjaan; ?>" id="" style="font-size: 10px">Edit</a>
                                                <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>pekerjaan/deskripsi_pekerjaan?id_detail_pkj=<?php echo $kerja->id_pekerjaan; ?>" id="" style="font-size: 10px">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <script>
                                ubah_status_pekerjaan('pekerjaan_staff_status_<?php echo $kerja->id_pekerjaan; ?>', <?php echo $kerja->flag_usulan; ?>, '<?php echo $kerja->sekarang; ?>', '<?php echo $kerja->tgl_mulai; ?>', '<?php echo $kerja->tgl_selesai; ?>', '<?php echo $kerja->tgl_read; ?>', '<?php echo $kerja->status; ?>', <?php echo $kerja->progress; ?>);
                            </script>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <script>
                    var list_user = [];
                    function set_assign_to(id, nama) {
                        var sep = '';
                        if ($('#' + id).html().length > 0)
                            sep = '<br/>';
                        $('#' + id).html($('#' + id).html() + sep + nama);
                    }
                    jQuery(document).ready(function() {
<?php foreach ($users as $user) {
    ?>list_user[<?php echo $user->id_akun; ?>] = '<?php echo $user->nama; ?>';
    <?php
}
if (isset($detil_pekerjaan_staff)) {
    foreach ($detil_pekerjaan_staff as $detil) {
        ?>set_assign_to('list_staff_<?php echo $detil->id_pekerjaan; ?>', list_user[<?php echo $detil->id_akun; ?>]);
        <?php
    }
}
?>
                $('#tabel_pekerjaan_staff').dataTable({});
            });
            function validasi_usulan(id_pekerjaan) {
                //alert("pekerjaan yg divalidasi " + id_pekerjaan);
                $.ajax({// create an AJAX call...
                    data: "id_pekerjaan=" + id_pekerjaan, // get the form data
                    type: "POST", // GET or POST
                    url: "<?php echo site_url(); ?>/pekerjaan/validasi_usulan", // the file to call
                    success: function(response) { // on success..
                        var json = jQuery.parseJSON(response);
                        //alert(response);
                        if (json.status === "OK") {
                            console.log('validasi pekerjaan berhasil');
                            $('#tombol_validasi_usulan_'+id_pekerjaan).remove();
                        } else {
                            alert(json.reason);
                            console.log('validasi pekerjaan gagal');
                        }
                    }
                });
            }
                </script>
            </div>
        </div>
    </section>
</div>