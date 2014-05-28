<section class="panel" >
</section>
<div class="col-md-7">
    <section class="panel">
        <h4 style="color: #1FB5AD;">
            Daftar Staff
        </h4>
        <div >
            <table id="tabel_assign_staff" class="table table-hover general-table">
                <?php foreach ($listassign_pekerjaan as $detail) { ?>
                    <tr>
                        <td style="vertical-align: middle"><?php echo $staff_array[$detail->id_akun]; ?></td>
                        <td>
                            <div class="btn-group btn-group-lg btn-xs" style="float: right; padding: -25px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                <a class="btn btn-info " href="#modal_" data-toggle="modal" id="target_<?php echo $detail->id_akun; ?>" onclick="load_target(<?php echo $detail->id_akun; ?>);" style="font-size: 12px;padding: 4px 10px;">Target</a>
                                <a class="btn btn-success" href="#modal_" data-toggle="modal" id="realisasi_<?php echo $detail->id_akun; ?>" style="font-size: 12px;padding: 4px 10px;" onclick="load_realisasi(<?php echo $detail->id_akun; ?>);">Realisasi</a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                //print_r($staff_array);
                ?>
            </table>
        </div>
    </section>
</div>
<script>
    var id_pekerjaan = '<?php echo $listassign_pekerjaan[0]->id_pekerjaan; ?>';
    var staff = jQuery.parseJSON('<?php echo json_encode($staff_array); ?>');
    var mode='target';
    console.log(staff);
    function load_target(id_staff) {
        $('#div_loading').css('display', 'block');
        mode='target';
        $('#modal_div_1').html('Target untuk ' + staff[id_staff]);
        $.ajax({// create an AJAX call...
            data: {
                id_staff: id_staff,
                id_pekerjaan: id_pekerjaan
            }, // get the form data
            type: "post", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/target_get", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                if (json.status === "OK") {
                    $('#modal_div_body').css('display','block');
                    $('#div_loading').css('display', 'none');
                    console.log(json.data);
                    console.log(json.data.length);
                    if(json.data.length>0){
                        
                    }
                } else {
                }
            }
        });
    }
    function load_realisasi(id_staff) {
        loading.css('display', 'block');
    }
</script>
<div class="modal fade" id="modal_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="judul_modal">Isi Target <strong><?php echo $deskripsi_pekerjaan[0]->nama_pekerjaan; ?></strong></h4>
            </div>
            <div class="modal-body" id="div_loading"  style="display: none; text-align: center; vertical-align: middle;">
                <img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif"/>
            </div>
            <div class="modal-body" id="modal_div_body" style="display: none">
                <div id="modal_div_1">
                    Body goes here...
                </div>
                <div>

                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button data-dismiss="modal" class="btn btn-warning" type="button"> Confirm</button>
            </div>
        </div>
    </div>
</div>
