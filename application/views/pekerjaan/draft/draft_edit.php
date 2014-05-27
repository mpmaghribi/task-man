<div id="div_create_draft" class="tab-pane active">
    <div class="form" style="">
        <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo $draft_edit_submit; ?>" enctype="multipart/form-data">
            <input type="hidden" name="jenis_usulan" value="draft"/>
            <input type="hidden" value="<?php echo $draft[0]->id_pekerjaan; ?>" name="id_draft" id="id_draft"/>
            <div class="form-group ">
                <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                <div class="col-lg-6">
                    <select name="sifat_pkj" id="sifat_pekerjaan" class="form-control m-bot15">
                        <option value="1" <?php echo $draft[0]->id_sifat_pekerjaan == '1' ? 'selected' : ''; ?>>Personal</option>
                        <option value="2" <?php echo $draft[0]->id_sifat_pekerjaan == '2' ? 'selected' : ''; ?>>Umum</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="kategori" class="control-label col-lg-3">Kategori</label>
                <div class="col-lg-6">
                    <select name="kategori" id="kategori" class="form-control m-bot15">
                        <option value="rutin" <?php echo $draft[0]->kategori == 'rutin' ? 'selected' : ''; ?>>Rutin</option>
                        <option value="project" <?php echo $draft[0]->kategori == 'project' ? 'selected' : ''; ?>>Project</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                <div class="col-lg-6">
                    <input class=" form-control" id="firstname" name="nama_pkj" type="text" value="<?php echo $draft[0]->nama_pekerjaan; ?>"/>
                </div>
            </div>
            <div class="form-group ">
                <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                <div class="col-lg-6">
                    <textarea class="form-control" name="deskripsi_pkj" rows="12"><?php echo $draft[0]->deskripsi_pekerjaan; ?></textarea>
                </div>
            </div>
            <div class="form-group ">
                <label for="deadline" class="control-label col-lg-3">Deadline</label>
                <div class="col-lg-6 ">
                    <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                        <input id="d" readonly type="text" class="form-control dpd1" value="" name="tgl_mulai_pkj">
                        <span class="input-group-addon">Sampai</span>
                        <input readonly type="text" class="form-control dpd2" value="" name="tgl_selesai_pkj">
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                <div class="col-lg-6">
                    <select name="prioritas" id="prioritas" class="form-control m-bot15">
                        <option value="1" <?php echo $draft[0]->level_prioritas == '1' ? 'selected' : ''; ?>>Urgent</option>
                        <option value="2" <?php echo $draft[0]->level_prioritas == '2' ? 'selected' : ''; ?>>Tinggi</option>
                        <option value="3" <?php echo $draft[0]->level_prioritas == '3' ? 'selected' : ''; ?>>Sedang</option>
                        <option value="4" <?php echo $draft[0]->level_prioritas == '4' ? 'selected' : ''; ?>>Rendah</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="prioritas" class="control-label col-lg-3">File</label>
                <div class="col-lg-6">
                    <div id="list_file_upload_assign">
                        <div id="file_lama">
                            <table  class="table table-hover general-table">
                                <?php
                                if (isset($list_berkas)) {
                                    foreach ($list_berkas as $berkas) {
                                        ?>
                                        <tr id="berkas_<?php echo $berkas->id_file; ?>">
                                            <td id="nama_file_<?php echo $berkas->id_file; ?>"><?php echo basename($berkas->nama_file); ?></td>
                                            <td id="aksi_<?php echo $berkas->id_file; ?>" style="width: 10px;text-align:right"><a class="btn btn-danger btn-xs" href="javascript:void(0);" id="" style="font-size: 12px" onclick="hapus_file(<?php echo $berkas->id_file ?>, '<?php echo basename($berkas->nama_file); ?>');">Hapus</a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <div id="file_baru">
                            <table  class="table table-hover general-table" id="berkas_baru"></table>
                        </div>
                    </div>
                    <div style="display:none">
                    <input type="file" multiple="" name="berkas[]" id="pilih_berkas_assign"/>
                    </div>
                        <button class="btn btn-primary" type="button" id="button_trigger_file">Pilih File</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-6">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var mulai = new Date('<?php echo $draft[0]->tgl_mulai; ?>');
    var akhir = new Date('<?php echo $draft[0]->tgl_selesai; ?>');
    $('.dpd1').val(mulai.getDate() + '-' + (mulai.getMonth() + 1) + '-' + mulai.getFullYear());
    $('.dpd2').val(akhir.getDate() + '-' + (akhir.getMonth() + 1) + '-' + akhir.getFullYear());
    $('#pilih_berkas_assign').change(function() {
        var pilih_berkas = document.getElementById('pilih_berkas_assign');
        var files = pilih_berkas.files;
        populate_file('berkas_baru', files);
    });
    function populate_file(id_tabel, files) {
        $('#' + id_tabel).html('');
        var jumlah_file = files.length;
        for (var i = 0; i < jumlah_file; i++) {
            $('#' + id_tabel).append('<tr id="berkas_baru_' + i + '">' +
                    '<td id="nama_berkas_baru_' + i + '">' + files[i].name +' ' + format_ukuran_file(files[i].size)+ '</td>' +
                    '<td id="keterangan_' + i + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px">Baru</a></td>' +
                    '</tr>');
            console.log(files[i]);
        }
    }
    function format_ukuran_file(s){
        var KB = 1024;
        var spasi=' ';
        var satuan = 'bytes';
        if(s>KB){
            s = s/KB;
            satuan = 'KB';
        }
        if(s>KB){
            s = s/KB;
            satuan = 'MB';
        }
        return '   ['+Math.round(s)+spasi+satuan+']';
    }
    function hapus_file(id_file, deskripsi)
    {
        var c = confirm("Anda yakin menghapus file " + deskripsi + "?");
        if (c == true) {
            $.ajax({// create an AJAX call...
                data: {id_file: id_file,
                    id_pekerjaan: $('#id_draft').val()
                }, // get the form data
                type: "get", // GET or POST
                url: "<?php echo site_url(); ?>/pekerjaan/hapus_file", // the file to call
                success: function(response) { // on success..
                    var json = jQuery.parseJSON(response);
                    //alert(response);
                    if (json.status === "OK") {
                        $('#berkas_' + id_file).remove();
                        //$('#tombol_validasi_usulan').remove();
                    } else {
                        alert("Gagal menghapus file, " + json.reason);
                    }
                }
            });
        }
        else {
        }
    }
    $(function() {
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var checkin = $('.dpd1').datepicker({
            format: 'dd-mm-yyyy',
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('.dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('.dpd2').datepicker({
            format: 'dd-mm-yyyy',
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');
    });
    $('#button_trigger_file').click(function(){
        $('#pilih_berkas_assign').click();
    });
</script>