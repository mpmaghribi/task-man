<div id="div_create_draft" class="tab-pane">
    <div class="form" style="">
        <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo $draft_create_submit; ?>" enctype="multipart/form-data">
            <input type="hidden" name="jenis_usulan" value="draft"/>
            <div class="form-group ">
                <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                <div class="col-lg-6">
                    <select name="sifat_pkj" class="form-control m-bot15">
                        <option value="1" >Personal</option>
                        <option value="2" >Umum</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="kategori" class="control-label col-lg-3">Kategori</label>
                <div class="col-lg-6">
                    <select name="kategori" class="form-control m-bot15">
                        <option value="rutin">Rutin</option>
                        <option value="project">Project</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                <div class="col-lg-6">
                    <input class=" form-control" id="firstname" name="nama_pkj" type="text" value=""/>
                </div>
            </div>
            <div class="form-group ">
                <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                <div class="col-lg-6">
                    <textarea class="form-control" name="deskripsi_pkj" rows="12"></textarea>
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
                    <select name="prioritas" class="form-control m-bot15">
                        <option value="1" >Urgent</option>
                        <option value="2" >Tinggi</option>
                        <option value="3" >Sedang</option>
                        <option value="4" >Rendah</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="prioritas" class="control-label col-lg-3">File</label>
                <div class="col-lg-6">
                    <div id="file_baru">
                        <table  class="table table-hover general-table" id="berkas_baru"></table>
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
    $('#button_trigger_file').click(function() {
        $('#pilih_berkas_assign').click();
    });
</script>