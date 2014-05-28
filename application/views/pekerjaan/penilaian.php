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
                                <a class="btn btn-info " href="#modal_target" data-toggle="modal" id="target_<?php echo $detail->id_akun; ?>" style="font-size: 12px;padding: 4px 10px;">Target</a>
                                <a class="btn btn-success" href="#modal_realisasi" data-toggle="modal" id="realisasi_<?php echo $detail->id_akun; ?>" style="font-size: 12px;padding: 4px 10px;">Realisasi</a>
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
<div class="modal fade" id="modal_target" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Isi Target Staff</h4>
            </div>
            <div class="modal-body">

                Body goes here...

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button data-dismiss="modal" class="btn btn-warning" type="button"> Confirm</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_realisasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal Tittle</h4>
            </div>
            <div class="modal-body">

                Body goes here...

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button class="btn btn-warning" data-dismiss="modal" type="button"> Confirm</button>
            </div>
        </div>
    </div>
</div>