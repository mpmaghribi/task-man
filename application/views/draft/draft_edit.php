<div id="div_create_draft" class="tab-pane active">
    <div class="form" style="">
        <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo $draft_edit_submit; ?>" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $draft['id_pekerjaan']; ?>" name="id_draft" id="id_draft"/>
            <div class="form-group ">
                <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                <div class="col-lg-6">
                    <select name="sifat_pkj" id="sifat_pekerjaan" class="form-control m-bot15">
                        <option value="1">Personal</option>
                        <option value="2">Umum</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="kategori" class="control-label col-lg-3">Kategori</label>
                <div class="col-lg-6">
                    <select name="kategori" id="select_kategori" class="form-control m-bot15" onchange="kategori_changed()">
                        <option value="rutin">Rutin</option>
                        <option value="project">Project</option>
                        <option value="tambahan">Tambahan</option>
                        <option value="kreativitas">Kreativitas</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                <div class="col-lg-6">
                    <input class="form-control" id="nama_pekerjaan" name="nama_pkj" type="text" value=""/>
                </div>
            </div>
            <div class="form-group ">
                <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                <div class="col-lg-6">
                    <textarea id="deskripsi_pekerjaan" class="form-control" name="deskripsi_pkj" rows="12"></textarea>
                </div>
            </div>
            <div class="form-group " id="div_angka_kredit">
                <label for="prioritas" class="control-label col-lg-3">Angka Kredit</label>
                <div class="col-lg-6">
                    <input type="text" class="form-control" id="angka_kredit" name="angka_kredit"/>
                </div>
            </div>
            <div class="form-group " id="div_kuantitas">
                <label for="prioritas" class="control-label col-lg-3">Kuantitas Output</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="kuantitas_output" name="kuantitas_output"/>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control" id="satuan_kuantitas" name="satuan_kuantitas" value="" placeholder="satuan kuanttias"/>
                </div>
            </div>
            <div class="form-group" id="div_kualitas">
                <label for="prioritas" class="control-label col-lg-3">Kualitas Mutu</label>
                <div class="col-lg-6">
                    <input type="text" class="form-control" id="kualitas_mutu" name="kualitas_mutu"/>
                </div>
            </div>
            <div class="form-group ">
                <label for="deskripsi_pkj" class="control-label col-lg-3">Periode</label>
                <div class="col-lg-6">
                    <input type="text" id="select_periode" name="draft_periode" value="<?= date('Y'); ?>" class="form-control" onchange="periode_changed();"/>
                </div>
            </div>
            <div class="form-group ">
                <label for="deadline" class="control-label col-lg-3">Deadline</label>
                <div class="col-lg-6 ">
                    <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                        <input id="waktu_mulai_baru" readonly type="text" class="form-control" value="" name="tgl_mulai_pkj">
                        <span class="input-group-addon">Sampai</span>
                        <input id="waktu_selesai_baru" readonly type="text" class="form-control" value="" name="tgl_selesai_pkj">
                    </div>
                </div>
            </div>
            <div class="form-group " id="div_biaya">
                <label for="prioritas" class="control-label col-lg-3">Biaya</label>
                <div class="col-lg-6">
                    <input type="text" class="form-control" id="biaya" name="biaya"/>
                </div>
            </div>
            <div class="form-group " id="div_manfaat">
                <label for="prioritas" class="control-label col-lg-3">Tingkat Kemanfaatan</label>
                <div class="col-lg-6">
                    <select name="select_kemanfaatan" class="form-control" id="manfaat">
                        <option value="1">Bermanfaat bagi unit kerjanya</option>
                        <option value="2">Bermanfaat bagi oragnisasinya</option>
                        <option value="3">Bermanfaat bagi negara</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                <div class="col-lg-6">
                    <select name="prioritas" id="prioritas" class="form-control m-bot15">
                        <option value="1">Urgent</option>
                        <option value="2">Tinggi</option>
                        <option value="3">Sedang</option>
                        <option value="4">Rendah</option>
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
                        <input type="file" multiple="" name="berkas[]" id="pilih_berkas_draft" onchange="draft_file_changed()"/>
                    </div>
                    <button class="btn btn-success" type="button" id="button_trigger_file" onclick="trigger_pilih_file()"><i class="fa fa-file"></i> Pilih File</button>
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
<script src="<?= base_url() ?>assets/js2/draft/js_create.js" type="text/javascript"></script>
<script>
	var draft = <?= json_encode($draft); ?>;
	jQuery(document).ready(function () {
		console.log(draft);
		var detail = JSON.parse(draft['deskripsi_pekerjaan']);
		console.log(detail);
		$('#sifat_pekerjaan').val(draft['id_sifat_pekerjaan']);
		$('#select_kategori').val(draft['kategori']);
		$('#nama_pekerjaan').val(draft['nama_pekerjaan']);
		$('#deskripsi_pekerjaan').val(detail['deskripsi']);
		$('#angka_kredit').val(detail['angka_kredit']);
		$('#kuantitas_output').val(detail['kuantitas_output']);
		$('#satuan_kuantitas').val(detail['satuan_kuantitas']);
		$('#kualitas_mutu').val(detail['kualitas_mutu']);
		$('#biaya').val(detail['pakai_biaya']?detail['biaya']:'-');
		$('#manfaat').val(draft['level_manfaat']);
		$('#periode').val(draft['periode']);
		periode_changed();
		kategori_changed();
	});
</script>