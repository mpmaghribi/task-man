<section class="panel" >
</section>
<div class="col-md-12">
    <section class="panel">
        <h4 style="color: #1FB5AD;">
            Pilih Staff
        </h4>
        <!--div>
            <table id="tabel_assign_staff" class="table table-hover general-table">
        <?php
        $list_user = array();
        foreach ($users as $user) {
            $list_user[$user->id_akun] = $user->nama;
        }
        foreach ($listassign_pekerjaan as $detail) {
            ?>
                                                                                                        <tr>
                                                                                                            <td style="vertical-align: middle"><?php echo $list_user[$detail->id_akun]; ?></td>
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
        </div-->
        <div class="cmxform form-horizontal">
            <div class="form-group ">
                <!--label for="pilih_staff_nilai" class="control-label col-lg-3">Staff</label-->
                <div class="col-lg-9">
                    <select name="pilih_staff_nilai" id="pilih_staff_nilai" class="form-control m-bot15" style="color: black;font-weight: bold">
                        <?php foreach ($listassign_pekerjaan as $detil) { ?>
                            <option value="<?php echo $detil->id_akun; ?>"><?php echo $list_user[$detil->id_akun]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <a class="btn btn-success" href="javascript:void(0);"  id="tombol_untuk_menilai" onclick="munculkan_penilaian()" style="font-size: 12px;padding: 7px 10px;" >Pilih</a>
            </div>
        </div>
        <div class="cmxform form-horizontal col-md-8" id="div_penilaian1" style="display: none">
            <!--            <H5>TARGET</H5>-->
            <table class="table table-hover general-table" style="vertical-align: middle; text-align: center">
                <thead>
                    <tr >
                        <th rowspan="2" style="vertical-align: middle; text-align: center">AK</th>
                        <th colspan="4" style="vertical-align: middle; text-align: center">TARGET</th>
                    </tr>
                    <tr >
                        <th style="vertical-align: middle; text-align: center">Kuantitas Output</th>
                        <th style="vertical-align: middle; text-align: center">Kualitas Mutu</th>
                        <th style="vertical-align: middle; text-align: center">Waktu</th>
                        <th style="vertical-align: middle; text-align: center">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="row_target">
                        <td><input type="text" id="input_target_ak"        value="ak" style="display: none" class="form-control"/><label id="label_target_ak">ak</label></td>
                        <td><input type="text" id="input_target_kuantitas" value="ak" style="display: none" class="form-control" /><label id="label_target_kuantitas">kuantitas output</label></td>
                        <td><input type="text" id="input_target_kualitas"  value="ak" style="display: none" class="form-control"/><label id="label_target_kualitas">kualitas mutu</label></td>
                        <td><input type="text" id="input_target_waktu"     value="ak" style="display: none" class="form-control" placeholder="bulan"/><label id="label_target_waktu">waktu</label></td>
                        <td><input type="text" id="input_target_biaya"     value="ak" style="display: none" class="form-control"/><label id="label_target_biaya">biaya</label></td>
                    </tr>
                </tbody>
            </table>
            <div class="col-lg-9 pull-right">
                <a class="btn btn-info pull-right" href="javascript:void(0);" style="font-size: 12px;padding: 7px 10px;" id="tombol_edit_target" onclick="edit_target()">Edit</a>
                <a class="btn btn-success pull-right" href="javascript:void(0);" style="font-size: 12px;padding: 7px 10px;" id="tombol_simpan_target" onclick="simpan_target()">Simpan</a>
            </div>
            <!--            <H5>REALISASI</H5>-->
            <table class="table table-hover general-table" style="vertical-align: middle; text-align: center">
                <thead>
                    <tr >
                        <th rowspan="2" style="vertical-align: middle; text-align: center">AK</th>
                        <th colspan="4" style="vertical-align: middle; text-align: center">REALISASI</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center">Penghitungan</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center">Nilai Capaian<br/>SKP</th>
                    </tr>
                    <tr >
                        <th style="vertical-align: middle; text-align: center">Kuantitas Output</th>
                        <th style="vertical-align: middle; text-align: center">Kualitas Mutu</th>
                        <th style="vertical-align: middle; text-align: center">Waktu</th>
                        <th style="vertical-align: middle; text-align: center">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="row_realisasi">
                        <td><input type="text" id="input_realisasi_ak"        value="ak" style="display: none" class="form-control"/><label id="label_realisasi_ak"       >ak</label></td>
                        <td><input type="text" id="input_realisasi_kuantitas" value="ak" style="display: none" class="form-control"/><label id="label_realisasi_kuantitas">kuantitas output</label></td>
                        <td><input type="text" id="input_realisasi_kualitas"  value="ak" style="display: none" class="form-control"/><label id="label_realisasi_kualitas" >kualitas mutu</label></td>
                        <td><input type="text" id="input_realisasi_waktu"     value="ak" style="display: none" class="form-control" placeholder="bulan"/><label id="label_realisasi_waktu"    >waktu</label></td>
                        <td><input type="text" id="input_realisasi_biaya"     value="ak" style="display: none" class="form-control"/><label id="label_realisasi_biaya"    >biaya</label></td>
                        <td><label id="label_penghitungan">0</label></td>
                        <td><label id="label_skp">0</label></td>
                    </tr>
                </tbody>
            </table>
            <div class="col-lg-9 pull-right">
                <a class="btn btn-info pull-right" href="javascript:void(0);" style="font-size: 12px;padding: 7px 10px;" id="tombol_edit_realisasi" onclick="edit_realisasi()">Edit</a>
                <a class="btn btn-success pull-right" href="javascript:void(0);" style="font-size: 12px;padding: 7px 10px;" id="tombol_simpan_realisasi" onclick="simpan_realisasi()">Simpan</a>
            </div>
        </div>
        <div class="cmxform form-horizontal col-md-8" style="display:none" id="div_show_progress">
            <h4>Progress Staff</h4>
            <table class="table table-hover general-table" style="vertical-align: middle; text-align: center" id="tabel_penilaian_progress">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Progress</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody id="tabel_penilaian_progress_body"></tbody>
            </table>
        </div>
    </section>
</div>

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
                                <input class=" form-control" id="waktu" name="waktu" type="text" placeholder="bulan"/>
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
                <button class="btn btn-warning" id="tombol_confirm" type="button" style="visibility: visible">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script>
    var list_id_detil_pekerjaan = [];
<?php
foreach ($listassign_pekerjaan as $detil) {
    ?>
        list_id_detil_pekerjaan[<?= $detil->id_akun; ?>] = '<?= $detil->id_detil_pekerjaan; ?>';
    <?php
}
?>
    var div_penilaian = $('#div_penilaian1');

    var label_target_ak = $('#label_target_ak');
    var label_target_kuantitas = $('#label_target_kuantitas');
    var label_target_kualitas = $('#label_target_kualitas');
    var label_target_waktu = $('#label_target_waktu');
    var label_target_biaya = $('#label_target_biaya');

    var input_target_ak = $('#input_target_ak');
    var input_target_kuantitas = $('#input_target_kuantitas');
    var input_target_kualitas = $('#input_target_kualitas');
    var input_target_waktu = $('#input_target_waktu');
    var input_target_biaya = $('#input_target_biaya');

    var label_realisasi_ak = $('#label_realisasi_ak');
    var label_realisasi_kuantitas = $('#label_realisasi_kuantitas');
    var label_realisasi_kualitas = $('#label_realisasi_kualitas');
    var label_realisasi_waktu = $('#label_realisasi_waktu');
    var label_realisasi_biaya = $('#label_realisasi_biaya');

    var input_realisasi_ak = $('#input_realisasi_ak');
    var input_realisasi_kuantitas = $('#input_realisasi_kuantitas');
    var input_realisasi_kualitas = $('#input_realisasi_kualitas');
    var input_realisasi_waktu = $('#input_realisasi_waktu');
    var input_realisasi_biaya = $('#input_realisasi_biaya');

    var row_target = $('#row_target');
    var row_realisasi = $('#row_realisasi');

    var tombol_edit_target = $('#tombol_edit_target');
    var tombol_simpan_target = $('#tombol_simpan_target');
    var tombol_edit_realisasi = $('#tombol_edit_realisasi');
    var tombol_simpan_realisasi = $('#tombol_simpan_realisasi');

    var label_realisasi_hitung = $('#label_penghitungan');
    var label_realisasi_skp = $('#label_skp');

    function reset_isi_tabel_penilaian() {
        console.log('reset tabel penilaian');
        label_target_ak.html('0');
        label_target_kuantitas.html('0');
        label_target_kualitas.html('0');
        label_target_waktu.html('0 bulan');
        label_target_biaya.html('0');

        input_target_ak.val('0');
        input_target_kuantitas.val('0');
        input_target_kualitas.val('0');
        input_target_waktu.val('0');
        input_target_biaya.val('0');

        label_realisasi_ak.html('0');
        label_realisasi_kuantitas.html('0');
        label_realisasi_kualitas.html('0');
        label_realisasi_waktu.html('0 bulan');
        label_realisasi_biaya.html('0');

        input_realisasi_ak.val('0');
        input_realisasi_kuantitas.val('0');
        input_realisasi_kualitas.val('0');
        input_realisasi_waktu.val('0');
        input_realisasi_biaya.val('0');

        tombol_simpan_target.attr('style', 'visibility:hidden');
        tombol_simpan_realisasi.attr('style', 'visibility:hidden');

        tombol_edit_target.attr('style', 'visibility:visible');
        tombol_edit_realisasi.attr('style', 'visibility:visible');

        label_realisasi_hitung.html(0);
        label_realisasi_skp.html(0);

    }
    function muat_nilai() {
        var id_staff = document.getElementById('pilih_staff_nilai').value;
        var id_pekerjaan = document.getElementById('id_detail_pkj').value;
        $.ajax({// create an AJAX call...
            data: {
                id_staff: id_staff,
                id_pekerjaan: id_pekerjaan
            }, // get the form data
            type: "post", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/nilai_get", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                console.log('memuat nilai');
                console.log(json);
                if (json.status === "OK") {
                    if (json.target.length > 0) {
                        var target = json.target[0];
                        label_target_ak.html(target['ak']);
                        label_target_kuantitas.html(target['kuatitas_output']);
                        label_target_kualitas.html(target['kualitas_mutu']);
                        label_target_waktu.html(target['waktu'] + ' bulan');
                        label_target_biaya.html(target['biaya']);

                        input_target_ak.val(target['ak']);
                        input_target_kuantitas.val(target['kuatitas_output']);
                        input_target_kualitas.val(target['kualitas_mutu']);
                        input_target_waktu.val(target['waktu']);
                        input_target_biaya.val(target['biaya']);


                    }
                    if (json.realisasi.length > 0) {
                        var realisasi = json.realisasi[0];
                        label_realisasi_ak.html(realisasi['ak']);
                        label_realisasi_kuantitas.html(realisasi['kuatitas_output']);
                        label_realisasi_kualitas.html(realisasi['kualitas_mutu']);
                        label_realisasi_waktu.html(realisasi['waktu'] + ' bulan');
                        label_realisasi_biaya.html(realisasi['biaya']);
                        label_realisasi_hitung.html(realisasi['penghitungan']);
                        label_realisasi_skp.html(realisasi['nilai_skp']);

                        input_realisasi_ak.val(realisasi['ak']);
                        input_realisasi_kuantitas.val(realisasi['kuatitas_output']);
                        input_realisasi_kualitas.val(realisasi['kualitas_mutu']);
                        input_realisasi_waktu.val(realisasi['waktu']);
                        input_realisasi_biaya.val(realisasi['biaya']);
                    }
                } else {
                }
            },
            error: function(respone) {
            }
        });
    }
    function edit_target() {
        label_target_ak.attr('style', 'display:none');
        label_target_kuantitas.attr('style', 'display:none');
        label_target_kualitas.attr('style', 'display:none');
        label_target_biaya.attr('style', 'display:none');
        label_target_waktu.attr('style', 'display:none');

        input_target_ak.attr('style', 'display:block');
        input_target_kuantitas.attr('style', 'display:block');
        input_target_kualitas.attr('style', 'display:block');
        input_target_biaya.attr('style', 'display:block');
        input_target_waktu.attr('style', 'display:block');

        tombol_edit_target.attr('style', 'visibility:hidden');
        tombol_simpan_target.attr('style', 'visibility:visible');
        input_target_ak.focus();
    }
    function simpan_target() {
        label_target_ak.attr('style', 'display:block');
        label_target_kuantitas.attr('style', 'display:block');
        label_target_kualitas.attr('style', 'display:block');
        label_target_biaya.attr('style', 'display:block');
        label_target_waktu.attr('style', 'display:block');

        input_target_ak.attr('style', 'display:none');
        input_target_kuantitas.attr('style', 'display:none');
        input_target_kualitas.attr('style', 'display:none');
        input_target_biaya.attr('style', 'display:none');
        input_target_waktu.attr('style', 'display:none');

        tombol_edit_target.attr('style', 'visibility:visible');
        tombol_simpan_target.attr('style', 'visibility:hidden');

        $.ajax({// create an AJAX call...
            data: {
                id_staff: document.getElementById('pilih_staff_nilai').value,
                id_pekerjaan: document.getElementById('id_detail_pkj').value,
                tipe_nilai: 'target',
                ak: input_target_ak.val(),
                kuantitas_output: input_target_kuantitas.val(),
                kualitas_mutu: input_target_kualitas.val(),
                waktu: input_target_waktu.val(),
                biaya: input_target_biaya.val()
            }, // get the form data
            type: "post", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/nilai_set", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                if (json.status === "OK") {
                    console.log('nilai set ok');
                    muat_nilai();
                } else {
                    console.log('nilai set error=>' + json.keterangan);
                    alert(json.keterangan);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });

    }
    function edit_realisasi() {
        label_realisasi_ak.attr('style', 'display:none');
        label_realisasi_kuantitas.attr('style', 'display:none');
        label_realisasi_kualitas.attr('style', 'display:none');
        label_realisasi_biaya.attr('style', 'display:none');
        label_realisasi_waktu.attr('style', 'display:none');

        input_realisasi_ak.attr('style', 'display:block');
        input_realisasi_kuantitas.attr('style', 'display:block');
        input_realisasi_kualitas.attr('style', 'display:block');
        input_realisasi_biaya.attr('style', 'display:block');
        input_realisasi_waktu.attr('style', 'display:block');

        tombol_edit_realisasi.attr('style', 'visibility:hidden');
        tombol_simpan_realisasi.attr('style', 'visibility:visible');
        input_realisasi_ak.focus();
    }
    function simpan_realisasi() {
        label_realisasi_ak.attr('style', 'display:block');
        label_realisasi_kuantitas.attr('style', 'display:block');
        label_realisasi_kualitas.attr('style', 'display:block');
        label_realisasi_biaya.attr('style', 'display:block');
        label_realisasi_waktu.attr('style', 'display:block');

        input_realisasi_ak.attr('style', 'display:none');
        input_realisasi_kuantitas.attr('style', 'display:none');
        input_realisasi_kualitas.attr('style', 'display:none');
        input_realisasi_biaya.attr('style', 'display:none');
        input_realisasi_waktu.attr('style', 'display:none');

        tombol_edit_realisasi.attr('style', 'visibility:visible');
        tombol_simpan_realisasi.attr('style', 'visibility:hidden');
        $.ajax({// create an AJAX call...
            data: {
                id_staff: document.getElementById('pilih_staff_nilai').value,
                id_pekerjaan: document.getElementById('id_detail_pkj').value,
                tipe_nilai: 'realisasi',
                ak: input_realisasi_ak.val(),
                kuantitas_output: input_realisasi_kuantitas.val(),
                kualitas_mutu: input_realisasi_kualitas.val(),
                waktu: input_realisasi_waktu.val(),
                biaya: input_realisasi_biaya.val()
            }, // get the form data
            type: "post", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/nilai_set", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                if (json.status === "OK") {
                    console.log('nilai set ok');
                    muat_nilai();
                } else {
                    console.log('nilai set error=>' + json.keterangan);
                    alert(json.keterangan);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    }
    function munculkan_progress() {
        var tabel_body = $('#tabel_penilaian_progress_body');
        $('#div_show_progress').show();
        tabel_body.html('');
        $.ajax({// create an AJAX call...
            data:
                    {
                        user_id: document.getElementById('pilih_staff_nilai').value,
                        id_detail_pkj: list_id_detil_pekerjaan[document.getElementById('pilih_staff_nilai').value]
                    }, // get the form data
            type: "POST", // GET or POST
            url: "<?php echo base_url(); ?>pekerjaan/show_log_progress", // the file to call
            cache: false,
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                if (json.status === "OK") {
                    console.log('retrieve progress ok');
                    var count = 1;
                    var jml = json.data.length;
                    for (var i = 0; i < jml; i++)
                    {
                        var waktu = json.data[i].waktu;
                        //console.log(json.data[i]);
                        var tanggal = new Date(waktu.substring(0, 10));
                        if (waktu.length > 19) {
                            waktu = waktu.substring(0, 19);
                        }
                        var html = '';

                        html += "<tr>";
                        html += "<td>" + count;
                        html += "</td>";

                        html += '<td >' + json.data[i].deksripsi;
                        html += '<div id="deskripsi_' + json.data[i].id_detil_progress + '" style="font-size:8pt; color:blue;text-align:left"></div></td>';
                        html += "<td>" + json.data[i].progress + "%";
                        html += "</td>";
                        html += "<td>" + waktu + "";
                        html += "</td>";
                        html += "</tr>";
                        count++;
                        tabel_body.append(html);
                    }
                    var l = json.berkas.length;
                    for (var i = 0; i < l; i++) {
                        var berkas = json.berkas[i];
                        $('#deskripsi_' + berkas.id_progress).append('<br><a target="_blank" href="<?php echo base_url() ?>download?id_file=' + berkas.id_file + '" style="font-size:7pt; color:blue;">' + basename(berkas.nama_file) + '</a>');
                    }
                    //$('#tabel_penilaian_progress').dataTable();
                } else {
                }
            }
        });
    }
    function munculkan_penilaian() {
        div_penilaian.show();
        reset_isi_tabel_penilaian();
        muat_nilai();
        munculkan_progress();
    }
    function capitaliseFirstLetter(string)
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    var id_pekerjaan = '<?php echo $listassign_pekerjaan[0]->id_pekerjaan; ?>';
    var staff = jQuery.parseJSON('<?php echo json_encode($list_user); ?>');
    var tipe_nilai = 'target';
    var prev_tipe_nilai = '';
    var prev_id = 0;
    console.log("peniliaian=>list user");
    console.log(staff);
    function load_nilai(id_staff, tipeNilai) {
        tipe_nilai = tipeNilai;
        $('#div_loading').css('display', 'block');
        $('#judul_modal').html('Isi ' + capitaliseFirstLetter(tipe_nilai) + ' <strong><?php echo $deskripsi_pekerjaan[0]->nama_pekerjaan; ?></strong>');
        $('#modal_div_1').html(capitaliseFirstLetter(tipe_nilai) + ' untuk <strong>' + staff[id_staff] + '</strong>');
        $('#tombol_confirm').css('visibility', 'visible');

        //if (!(prev_tipe_nilai === tipe_nilai && prev_id === id_staff)) {
        prev_tipe_nilai = tipe_nilai;
        prev_id = id_staff;
        $('#ak').val('1');
        $('#kuantitas_output').val('1');
        $('#kualitas_mutu').val('1');
        $('#waktu').val('1');
        $('#biaya').val('1');
        //}
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

                if (json.status === "OK" || json.status === 'kosong') {
                    $('#div_loading').css('display', 'none');
                    $('#modal_div_body').css('display', 'block');
                    $('#modal_div_1').css('display', 'block');
                    $('#nilai_body').css('display', 'block');
                    $('#div_nilai_error').css('display', 'none');
                    if (json.status === 'OK') {
                        $('#judul_modal').html('Update ' + capitaliseFirstLetter(tipe_nilai) + ' <strong><?php echo $deskripsi_pekerjaan[0]->nama_pekerjaan; ?></strong>');
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
                    } else {
                        $('#judul_modal').html('Isi ' + capitaliseFirstLetter(tipe_nilai) + ' <strong><?php echo $deskripsi_pekerjaan[0]->nama_pekerjaan; ?></strong>');
                        console.log('kosong, belum ada nilai');
                    }
                } else {
                    console.log('error=>' + json.keterangan);
                    $('#nilai_body').css('display', 'none');
                    $('#div_nilai_error').css('display', 'block');
                    $('#div_nilai_error').html('error, ' + json.keterangan);
                    $('#modal_div_1').css('display', 'none');
                    $('#tombol_confirm').css('visibility', 'hidden');
                }
            },
            error: function(respone) {
                $('#nilai_body').css('display', 'none');
                $('#div_nilai_error').css('display', 'block');
                $('#div_nilai_error').html(respone);
                $('#modal_div_1').css('display', 'none');
                $('#tombol_confirm').css('visibility', 'hidden');
            }
        });
    }
    $('#tombol_confirm').click(function(e) {
        nilai_set();
    });
    function nilai_set() {
        $('#div_loading').css('display', 'block');
        $.ajax({// create an AJAX call...
            data: {
                id_staff: prev_id,
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
                console.log('parsing nilai set json object');
                var json = jQuery.parseJSON(response);
                if (json.status === "OK") {
                    console.log('nilai set ok');
                    $('#tombol_close').click();
                } else {
                    console.log('nilai set error=>' + json.keterangan);
                    alert(json.keterangan);
                    $('#div_loading').css('display', 'none');
                }
                //$('#tombol_close').click();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#nilai_body').css('display', 'none');
                $('#div_nilai_error').css('display', 'block');
                //console.log(errorThrown);
                //console.log(textStatus);
                //console.log(jqXHR);
                //console.log(jqXHR.getAllResponseHeaders());
                $('#div_nilai_error').html(errorThrown);
                $('#modal_div_1').css('display', 'none');
            }
        });
    }
    function basename(nama) {
        var p = nama.length;
        var h = '';
        for (var i = p - 1; i > 0; i--) {
            if (nama[i] == '/') {
                break;
            }
            h = nama[i]+h;
        }
        return h;
    }
</script>