
<style type="text/css">
    .well {
       //display: none;
    }
</style>
<script>
                function page(pageNumber)
                {
                    
                  var page="#page-"+pageNumber;
                  $('.well').hide();
                  $(page).show();

                }
        </script>
<?php date_default_timezone_set('Asia/Jakarta'); $counter=1; foreach ($lihat_komentar_pekerjaan as $value) { ?>
    <div id="page-<?php echo $counter;?>" class="well">
        <h5 id="komentar_nama_<?php echo $value->id_akun; ?>">
            <strong>
                <?php foreach ($users as $value2) { ?>
                    <?php if ($value->id_akun == $value2->id_akun) { ?><?php echo $value2->nama ?><?php } ?>
                <?php } ?>
            </strong>
        </h5>
        <?php echo $value->isi_komentar; ?><br>
        <small><strong>terakhir komentar diubah: <?php echo date("d M Y H:i:s",  strtotime($value->tgl_komentar))?></strong></small>
        <?php if ($value->id_akun == $temp['id_akun']){?>
        <p><a class="btn btn-danger btn-xs" onclick="hapus(<?php echo $value->id_komentar?>)" data-toggle="modal" href="#myModal2" type="button"><strong>hapus</strong></a>
        <a class="btn btn-danger btn-xs" onclick="ubah_komentar(<?php echo $value->id_komentar?>)" data-toggle="modal" href="#UbahKomentar" type="button"><strong>Ubah</strong></a></p>
        <?php }?>
    </div>
<?php $counter++; } ?>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Konfirmasi Penghapusan</h4>
            </div>
            <div class="modal-body">

                Anda yakin ingin menghapus komentar ini ? Proses ini tidak dapat diulang kembali.

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                <button class="btn btn-warning" data-dismiss="modal" id="hapus_komen" type="button"> Ya</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="UbahKomentar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Silahkan ubah komentar anda</h4>
            </div>
            <div class="modal-body">

                <textarea class="form-control" id="komentar_pkj_ubah" name="komentar_pkj_ubah" value="" rows="12"></textarea>

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                <button class="btn btn-warning" data-dismiss="modal" id="ubah_komen" type="button"> Ubah</button>
            </div>
        </div>
    </div>
</div>
<div id="paging"></div>
            <script>
             $(function() {
    $("#paging").pagination({
        items: <?php echo $counter-1;?>,
        itemsOnPage: 10,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber,event){page(pageNumber); event.preventDefault();}
    });
});
        </script>