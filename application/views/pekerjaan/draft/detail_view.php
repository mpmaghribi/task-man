<div id="deskripsiPekerjaan" class="tab-pane active">
    <section class="panel" >
    </section>
    <div class="col-md-12">
        <section class="panel">
            <h4 style="color: #1FB5AD;">
                Nama Pekerjaan
            </h4>
            <p style="font-size: larger">
                <?php echo $draft[0]->nama_pekerjaan; ?> 
            </p>
            <h4 style="color: #1FB5AD;">
                Penjelasan Pekerjaan
            </h4>
            <p style="font-size: larger">
                <?php echo $draft[0]->deskripsi_pekerjaan; ?> 
            </p>
            <h4 style="color: #1FB5AD;">
                Jenis Pekerjaan
            </h4>
            <p style="font-size: larger">
                <?php echo $draft[0]->nama_sifat_pekerjaan; ?>
            </p>
            <h4 style="color: #1FB5AD;">
                Deadline
            </h4>
            <p style="font-size: larger">
                <?php
                echo date("d M Y", strtotime($draft[0]->tgl_mulai));
                echo " - ";
                echo date("d M Y", strtotime($draft[0]->tgl_selesai));
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
                <table class="table table-striped table-hover table-condensed" id="table_deskripsi">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama File</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($list_berkas)) {
                            $i = 1;
                            foreach ($list_berkas as $berkas) {
                                ?>
                                <tr id="berkas_<?php echo $berkas->id_file; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo basename($berkas->nama_file); ?></td>
                                    <td style="text-align: right">
                                        <a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="window.open('<?php echo base_url() . $berkas->nama_file ?>');">Download</a>
<!--                                        <a class="btn btn-danger btn-xs" href="javascript:void(0);" id="" style="font-size: 10px" onclick="hapus_file(<?php echo $berkas->id_file ?>, '<?php echo basename($berkas->nama_file); ?>');">Hapus</a>-->
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>