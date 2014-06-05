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
                <!-- page start-->

                <div class="row">
                    <div class="col-md-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#div_view_draft">Daftar Draft Pekerjaan</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#div_create_draft">Membuat Draft Pekerjaan</a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <?php 
                                    
                                    //echo $draft_create_submit;
                                    $this->load->view('pekerjaan/draft/draft_view');
                                    $this->load->view('pekerjaan/draft/draft_create');
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

        <!-- END JAVASCRIPTS -->
        <script>
            jQuery(document).ready(function() {
                EditableTableProgress.init();
            });
        </script>
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->
    </section>
    <?php $this->load->view("taskman_footer_page") ?>
    <script type="text/javascript">
        $(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            var checkin = $('.dpd1').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
            var checkout = $('.dpd2').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function(date) {
                    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function(ev) {
                checkout.hide();
            }).data('datepicker');
        });
        
        
        document.title = "Draft Pekerjaan - Task Management";
        $('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
        
        $('#pilih_berkas_assign').change(function() {
            var pilih_berkas = document.getElementById('pilih_berkas_assign');
            var files = pilih_berkas.files;
           populate_file('berkas_baru', files);
        });
        function populate_file(id_tabel, files) {
            $('#' + id_tabel).html('');
            var jumlah_file = files.length;
            for (var i = 0; i < jumlah_file; i++) {
                $('#' + id_tabel).append('<tr id="berkas_baru_' + i + '">' +
                        '<td id="nama_berkas_baru_' + i + '">' + files[i].name + ' ' + format_ukuran_file(files[i].size) + '</td>' +
                        '<td id="keterangan_' + i + '" style="width=10px;text-align:right"><a class="btn btn-info btn-xs" href="javascript:void(0);" id="" style="font-size: 12px">Baru</a></td>' +
                        '</tr>');
            }
        }
        function format_ukuran_file(s) {
            var KB = 1024;
            var spasi = ' ';
            var satuan = 'bytes';
            if (s > KB) {
                s = s / KB;
                satuan = 'KB';
            }
            if (s > KB) {
                s = s / KB;
                satuan = 'MB';
            }
            return '   [' + Math.round(s) + spasi + satuan + ']';
        }
        $('#div_view_draft').attr('class','tab-pane active');
    </script>