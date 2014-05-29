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
                                <a class="btn btn-info " href="#modal_" data-toggle="modal" id="target_<?php echo $detail->id_akun; ?>" onclick="load_nilai(<?php echo $detail->id_akun; ?>, 'target');" style="font-size: 12px;padding: 4px 10px;">Target</a>
                                <a class="btn btn-success" href="#modal_" data-toggle="modal" id="realisasi_<?php echo $detail->id_akun; ?>" style="font-size: 12px;padding: 4px 10px;" onclick="load_nilai(<?php echo $detail->id_akun; ?>, 'realisasi');">Realisasi</a>
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
    function capitaliseFirstLetter(string)
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    var id_pekerjaan = '<?php echo $listassign_pekerjaan[0]->id_pekerjaan; ?>';
    var staff = jQuery.parseJSON('<?php echo json_encode($staff_array); ?>');
    var tipe_nilai = 'target';
    var prev_tipe_nilai = '';
    var prev_id = 0;
    console.log(staff);
    function load_nilai(id_staff, tipeNilai) {
        tipe_nilai = tipeNilai;
        $('#div_loading').css('display', 'block');
        $('#judul_modal').html('Isi ' + capitaliseFirstLetter(tipe_nilai) + ' <strong><?php echo $deskripsi_pekerjaan[0]->nama_pekerjaan; ?></strong>');
        $('#modal_div_1').html(capitaliseFirstLetter(tipe_nilai) + ' untuk <strong>' + staff[id_staff] + '</strong>');

        if (!(prev_tipe_nilai === tipe_nilai && prev_id === id_staff)) {
            prev_tipe_nilai = tipe_nilai;
            prev_id = id_staff;
            $('#ak').val('');
            $('#kuantitas_output').val('');
            $('#kualitas_mutu').val('');
            $('#waktu').val('');
            $('#biaya').val('');
        }
        $.ajax({// create an AJAX call...
            data: {
                id_staff: id_staff,
                id_pekerjaan: id_pekerjaan,
                tipe_nilai: tipe_nilai
            }, // get the form data
            type: "post", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/nilai_get", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                
                if (json.status === "OK" || json.status==='kosong') {
                    $('#div_loading').css('display', 'none');
                    $('#modal_div_body').css('display', 'block');
                    $('#modal_div_1').css('display', 'block');
                    $('#nilai_body').css('display', 'block');
                    $('#div_nilai_error').css('display', 'none');
                    console.log(json.data);
                    console.log(json.data.length);
                    if (json.data.length > 0) {
                        console.log('sudah punya ' + tipe_nilai);
                        $('#ak').val(json.data[0]['ak']);
                        $('#kuantitas_output').val(json.data[0]['kuatitas_output']);
                        $('#kualitas_mutu').val(json.data[0]['kualitas_mutu']);
                        $('#waktu').val(json.data[0]['waktu']);
                        $('#biaya').val(json.data[0]['biaya']);
                    } else {
                        console.log('belum punya ' + tipe_nilai);
                    }
                    $('#tombol_confirm').click(function(e) {
                        nilai_set(id_staff);
                            
                    });
                } else {
                    console.log('sini');
                    $('#nilai_body').css('display', 'none');
                    $('#div_nilai_error').css('display', 'block');
                    $('#div_nilai_error').html('error, ' + json.keterangan);
                    $('#modal_div_1').css('display','none');
                }
            }
        });
    }

    function nilai_set(id_staff) {
        $('#div_loading').css('display', 'block');
        $.ajax({// create an AJAX call...
            data: {
                id_staff: id_staff,
                id_pekerjaan: id_pekerjaan,
                tipe_nilai: tipe_nilai,
                ak: $('#ak').val(),
                kuantitas_output: $('#kuantitas_output').val(),
                kualitas_mutu: $('#kualitas_mutu').val(),
                waktu: $('#waktu').val(),
                biaya: $('#biaya').val()
            }, // get the form data
            type: "post", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/nilai_set", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                if (json.status === "OK") {
                    $('#tombol_close').click();
                }else{
                    alert(json.keterangan);
                }
            }
        });
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
            <div id="div_nilai_error" style="display:none;text-align: center;">
                </div>
            <div class="modal-body" id="modal_div_body" style="display: none">
                <div id="modal_div_1">
                    Body goes here...
                </div>
                
                <div class="form" id="nilai_body">
                    <div class=" cmxform form-horizontal " style="margin-top: 15px">
                        <div class="form-group ">
                            <label for="ak" class="control-label col-lg-3">AK</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="ak" name="ak" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="kuantitas_output" class="control-label col-lg-3">Kuantitas Output</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="kuantitas_output" name="kuantitas_output" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="kualitas_mutu" class="control-label col-lg-3">Kualitas Mutu</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="kualitas_mutu" name="kualitas_mutu" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="waktu" class="control-label col-lg-3">Waktu</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="waktu" name="waktu" type="text" />
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="biaya" class="control-label col-lg-3">Biaya</label>
                            <div class="col-lg-6">
                                <input class=" form-control" id="biaya" name="biaya" type="text" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" id="tombol_close" type="button">Close</button>
                <button class="btn btn-warning" id="tombol_confirm" type="button">Confirm</button>
            </div>
        </div>
    </div>
</div>
