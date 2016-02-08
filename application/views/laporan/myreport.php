<?php $this->load->view("taskman_header_page") ?> 
<body>

    <section id="container" >
        <!--header start-->
        <?php $this->load->view("taskman_header2_page") ?>
        <!--header end-->
        <?php $this->load->view("taskman_sidebarleft_page") ?>

        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <section class="panel">
                    

                            <header class="panel-heading">
                                Pekerjaan Saya
                            </header>
                            <section class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                     <label class="control-label col-lg-1">Periode</label>
                                        <div class="col-lg-2">
                                            <select id="select_periode" name="select_periode" class="form-control">
                                                <?php
                                                for ($i = $tahun_max; $i >= $tahun_min; $i--) {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table  table-hover general-table">
                                            <thead>
                                                <tr>
                                                    <th> NIP</th>
                                                    <th >Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Departemen</th>
                                                    <th>Email</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $this->session->userdata['logged_in']['nip'] ?></td>
                                                    <td><?php echo $this->session->userdata['logged_in']['nama'] ?></td>
                                                    <td><?php echo $this->session->userdata['logged_in']['nama_jabatan'] ?></td>
                                                    <td><?php echo $this->session->userdata['logged_in']['nama_departemen'] ?></td>
                                                    <td><?php echo $this->session->userdata['logged_in']['user_email'] ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button"> Cetak Laporan<span class="caret"></span> </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="javascript:export_pdf({tipe: 'skp', id_akun: '<?= $this->session->userdata['logged_in']['id_akun'] ?>'});">Form SKP</a></li>
                                                                <li><a href="javascript:export_pdf({tipe: 'ckp', id_akun: '<?= $this->session->userdata['logged_in']['id_akun'] ?>'});">Form CKP</a></li>
                                                                <li><a href="javascript:export_periode({'tipe': 'skp', 'id_akun': '<?= $this->session->userdata['logged_in']['id_akun'] ?>'});" data-toggle="modal">Laporan SKP per Periode</a></li>
                                                                <li><a href="javascript:export_periode({'tipe': 'ckp', 'id_akun': '<?= $this->session->userdata['logged_in']['id_akun'] ?>'});" data-toggle="modal">Laporan CKP per Periode</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                        
                </section>
            </section>
        </section>
        <form style="display:none" id="form_submit"></form>
        <div class="modal fade" id="exportPeriode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Pilih Periode Yang Anda Ingin Eksport</h4>
                            </div>
                            <form action="<?php echo site_url() ?>/laporan/laporan_per_periode" method="GET" target="_blank">
                                <div class="modal-body">

                                    <input type="hidden" id="id_akun" name="id_akun" value="" />
                                    <input type="hidden" id="nama" name="nama" value="" />
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3">Tahun</label>
                                            <div class="col-lg-8">
                                                <select id="select_periode2" name="tahun" class="form-control">
                                                    <?php
                                                    for ($i = $tahun_max; $i >= $tahun_min; $i--) {
                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3">Periode</label>
                                            <div class="col-lg-8">
                                                <select name="periode" class="form-control m-bot15">
                                                    <option value="januari">Januari</option>
                                                    <option value="februari">Februari</option>
                                                    <option value="maret">Maret</option>
                                                    <option value="april">April</option>
                                                    <option value="mei">Mei</option>
                                                    <option value="juni">Juni</option>
                                                    <option value="juli">Juli</option>
                                                    <option value="agustus">Agustus</option>
                                                    <option value="september">September</option>
                                                    <option value="oktober">Oktober</option>
                                                    <option value="november">November</option>
                                                    <option value="desember">Desember</option>
                                                    <option value="tri_1">Triwulan I</option>
                                                    <option value="tri_2">Triwulan II</option>
                                                    <option value="tri_3">Triwulan III</option>
                                                    <option value="tri_4">Triwulan IV</option>
                                                    <option value="sms_1">Semester I</option>
                                                    <option value="sms_2">Semester II</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="nama_jabatan" name="nama_jabatan" value="" />
                                    <input type="hidden" id="nama_departemen" name="nama_departemen" value="" />
                                    <input type="hidden" id="nip" name="nip" value="" />

                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                                    <button class="btn btn-warning" type="submit"> Export PDF</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exportPeriode2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Pilih Periode Yang Anda Ingin Eksport</h4>
                            </div>
                            <form action="<?php echo site_url() ?>/laporan/laporan_ckp_per_periode" method="GET" target="_blank">
                                <div class="modal-body">

                                    <input type="hidden" id="id_akun2" name="id_akun2" value="" />
                                    <input type="hidden" id="nama2" name="nama2" value="" />
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3">Tahun</label>
                                            <div class="col-lg-8">
                                                <select id="select_periode2" name="tahun2" class="form-control">
                                                    <?php
                                                    for ($i = $tahun_max; $i >= $tahun_min; $i--) {
                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-3">Periode</label>
                                            <div class="col-lg-8">
                                                <select name="periode2" class="form-control m-bot15">
                                                    <option value="januari">Januari</option>
                                                    <option value="februari">Februari</option>
                                                    <option value="maret">Maret</option>
                                                    <option value="april">April</option>
                                                    <option value="mei">Mei</option>
                                                    <option value="juni">Juni</option>
                                                    <option value="juli">Juli</option>
                                                    <option value="agustus">Agustus</option>
                                                    <option value="september">September</option>
                                                    <option value="oktober">Oktober</option>
                                                    <option value="november">November</option>
                                                    <option value="desember">Desember</option>
                                                    <option value="tri_1">Triwulan I</option>
                                                    <option value="tri_2">Triwulan II</option>
                                                    <option value="tri_3">Triwulan III</option>
                                                    <option value="tri_4">Triwulan IV</option>
                                                    <option value="sms_1">Semester I</option>
                                                    <option value="sms_2">Semester II</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <input type="hidden" id="nama_jabatan2" name="nama_jabatan2" value="" />
                                    <input type="hidden" id="nama_departemen2" name="nama_departemen2" value="" />
                                    <input type="hidden" id="nip2" name="nip2" value="" />

                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                                    <button class="btn btn-warning" type="submit"> Export PDF</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        <!--main content end-->
        <!--right sidebar start-->
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

        <!-- END JAVASCRIPTS -->

        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script>
        jQuery(document).ready(function () {
//                                                                    EditableTableProgress.init();
//                                                                    document.title = "Daftar Staff - Laporan Task Management";
            $('#tabel_pekerjaan_staff').dataTable();
            var tab = $($('.sidebar-menu').children()[3]).children();
            console.log(tab);
            $(tab[0]).attr('class', 'dcjq-parent active');
            $(tab[1]).show();
            document.title = 'Laporan SKP - Taskmanagement';
        });
        function exportPeriode(id_akun, nama, jabatan, departemen, nip)
        {
            $("#id_akun").val(id_akun);
            $("#nama").val(nama);
            $("#nama_jabatan").val(jabatan);
            $("#nama_departemen").val(departemen);
            $("#nip").val(nip);
        }
        function exportPeriode2(id_akun, nama, jabatan, departemen, nip)
        {
            $("#id_akun2").val(id_akun);
            $("#nama2").val(nama);
            $("#nama_jabatan2").val(jabatan);
            $("#nama_departemen2").val(departemen);
            $("#nip2").val(nip);
        }
        var site_url = '<?= site_url() ?>';
        
        function export_periode(data){
            //$('#modal_export_form').attr({'action': site_url + '/laporan/export_periode'});
            $('#modal_export').modal('show');
            $('#modal_export_id_akun').val(data.id_akun);
            $('#modal_export_tipe').val(data.tipe);
        }
        
        function print_skp(id_staff){
            var form = $('#form_submit');
            form.attr({'method':'get','target':'_blank', 'action': site_url+'/laporan/cetak_form_skp'});
            form.html($('<input></input>').attr({'name':'id_akun','value':id_staff}));
            form.append($('<input></input>').attr({name: 'periode', value: $('#select_periode').val()}));
            form.submit();
        }
        
        function print_ckp(id_staff){
            var form = $('#form_submit');
            form.attr({'method':'get','target':'_blank', 'action': site_url+'/laporan/cetak_form_ckp'});
            form.html($('<input></input>').attr({'name':'id_akun','value':id_staff}));
            form.append($('<input></input>').attr({name: 'periode', value: $('#select_periode').val()}));
            form.submit();
        }
        
        function export_pdf(data) {
            var form = $('#form_submit');
            console.log('function print_form_skp(data)');
            console.log(data);
            form.attr({action: site_url + '/laporan/pdf', method: 'get', target: '_blank'});
            form.html($('<input></input>').attr({type: 'hidden', name: 'periode', value: $('#select_periode').val()}));
//            form.append($('<input></input>').attr({type: 'hidden', name: 'departemen', value: data.departemen}));
            form.append($('<input></input>').attr({type: 'hidden', name: 'id_akun', value: data.id_akun}));
            form.append($('<input></input>').attr({type: 'hidden', name: 'tipe', value: data.tipe}));
//            form.append($('<input></input>').attr({type: 'hidden', name: 'jabatan', value: data.jabatan}));
//            form.append($('<input></input>').attr({type: 'hidden', name: 'nama', value: data.nama}));
//            form.append($('<input></input>').attr({type: 'hidden', name: 'nip', value: data.nip}));
            form.submit();
        }
    </script>