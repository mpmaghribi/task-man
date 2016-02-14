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
                            $periode_sekarang = date('Y');
                            foreach ($list_periode as $periode){
                                echo '<option ' . ($periode['periode'] == $periode_sekarang ? 'selected=""' : '') . ' value="'.$periode['periode'].'">'.$periode['periode'].'</option>';
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