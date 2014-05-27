<div id="div_create_draft" class="tab-pane active">
    <div class="form" style="">
        <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo $draft_edit_submit; ?>" enctype="multipart/form-data">
            <input type="hidden" name="jenis_usulan" value="draft"/>
            <input type="hidden" value="<?php echo $draft[0]->id_pekerjaan; ?>" name="id_draft"/>
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
                    </div>
                    <input type="file" multiple="" name="berkas[]" id="pilih_berkas_assign"/>
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
</script>