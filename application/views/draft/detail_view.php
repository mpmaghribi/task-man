<?php
$detail_draft = json_decode($draft['deskripsi_pekerjaan']);
?>
<div id="deskripsiPekerjaan" class="tab-pane active">
    <section class="panel" >
    </section>
    <div class="col-md-12">
        <section class="panel">
            <h4 style="color: #1FB5AD;">
                Nama Pekerjaan
            </h4>
            <p style="font-size: larger">
                <?php echo $draft['nama_pekerjaan']; ?> 
            </p>
            <h4 style="color: #1FB5AD;">
                Penjelasan Pekerjaan
            </h4>
            <p style="font-size: larger">
                <?php echo $detail_draft->deskripsi ?> 
            </p>
            <h4 style="color: #1FB5AD;">
                Jenis Pekerjaan
            </h4>
            <p style="font-size: larger">
                <?php echo $draft['nama_sifat_pekerjaan']; ?>
            </p>
            <h4 style="color: #1FB5AD;">
                Deadline
            </h4>
            <p style="font-size: larger">
                <?php
                echo date("d M Y", strtotime($draft['tanggal_mulai']));
                echo " - ";
                echo date("d M Y", strtotime($draft['tanggal_selesai']));
                ?>
            </p>
        </section>
    </div>
    <div class="col-md-12">
        <section class="panel">
            <h4 style="color: #1FB5AD;">
                File Pendukung
            </h4>
            <div class="panel-body">
                <table class="table table-striped table-hover table-condensed" id="table_deskripsi_file">
                    <thead>
                        <tr>
                            <th style="width: 70px">#</th>
                            <th >Nama File</th>
                            <th style="width: 150px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $i = 0;
                        foreach ($list_berkas as $berkas) {
                            $i++;
                            ?>
                            <tr id="berkas_<?php echo $berkas['id_file']; ?>">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $berkas['nama_file']; ?></td>
                                <td style="text-align: right">
                                    <a class="btn btn-info btn-xs" href="<?= site_url() ?>/download?id_file=<?= $berkas['id_file'] ?>" target="_blank" style="font-size: 10px">Download</a>
                                    <button class="btn btn-danger btn-xs" onclick="dialog_hapus_file(<?= $berkas['id_file'] ?>);" style="font-size: 10px">Hapus</button>
                                </td>
                            </tr>
                            <?php
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<script>
    var view_draft = <?= json_encode($draft); ?>;
    function dialog_hapus_file(id){
        var tr = $('#berkas_'+id);
        console.log(tr);
        var tds = tr.children();
        console.log(tds);
        if(tds.length == 0){
            return;
        }
        var deskripsi = tds[1].innerHTML;
        $('#modal_any').modal('show');
        $('#modal_any_title').html('Konfirmasi Hapus Berkas Draft');
        $('#modal_any_body').html('<h5>Anda akan menghapus berkas <strong>'+deskripsi+'</strong>. Lanjutkan?</h5>');
        $('#modal_any_button_cancel').attr({'class':'btn btn-success'}).html('Batal');
        $('#modal_any_button_ok').attr({'class':'btn btn-danger', 'onclick':'hapus_file('+id+')'}).html('Hapus Berkas');
    }
    function hapus_file(id) {
        $.ajax({
            data: {
                id_file: id
            },
            type: "get", 
            url: site_url + "/draft/hapus_file_json",
            success: function (response) { 
                var json = jQuery.parseJSON(response);
                if (json.status === "ok") {
                    $('#berkas_' + id).remove();
                } else {
                    alert("Gagal menghapus file, " + json.reason);
                }
            }
        });
    }
</script>