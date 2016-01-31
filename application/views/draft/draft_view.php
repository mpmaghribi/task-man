<div id="div_view_draft" class="tab-pane col-md-12">
    <section class="panel">
        <header class="panel-heading">
            Daftar Draft Pekerjaan
        </header>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-1">Periode</label>
                    <div class="col-lg-2">
                        <select class="form-control" id="draft_select_periode" onchange="draft_ubah_periode()">
                            <?php
                            for($tahun=$tahun_max;$tahun>=$tahun_min;$tahun--){
                                echo '<option value="'.$tahun.'">'.$tahun.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form">
                <table class="table table-striped table-hover table-condensed" id="tabel_draft">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="hidden-phone">Nama Pekerjaan</th>
                            <th class="hidden-phone">Periode</th>
                            <th class="hidden-phone">Kategori</th>
                            <th class="hidden-phone">Prioritas</th>
                            <th style="text-align: right; min-width: 248px; width: 300px"></th>
                        </tr>
                    </thead>
                    <tbody id="tabel_draft_body">
                    </tbody>
                </table>
                <script type="text/javascript" src="<?=base_url()?>assets/js2/draft/js_home.js"></script>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal_draft_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal_draft_hapus_judul">Hapus Draft</h4>
            </div>
            <div class="modal-body" id="modal_draft_hapus_body" style="">
                
            </div>
			<input type="hidden" id="id_draft_hapus" value="0"/>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-info" id="tombol_close" type="button">Batal</button>
                <button class="btn btn-danger" id="" type="button" style="visibility: visible" onclick="hapus_draft()">Hapus</button>
            </div>
        </div>
    </div>
</div>