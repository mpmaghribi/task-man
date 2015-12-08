<!--Core js-->
<script src="<?php echo base_url() ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url() ?>assets/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>

<!--Morris Chart-->
<script src="<?php echo base_url() ?>assets/js/morris-chart/morris.js"></script>
<script src="<?php echo base_url() ?>assets/js/morris-chart/raphael-min.js"></script>
<script src="<?php echo base_url() ?>assets/js/morris.init.js"></script>

<!--common script init for all pages-->
<script src="<?php echo base_url() ?>assets/js/scripts.js"></script>

<script src="<?php echo base_url(); ?>assets/js/fullcalendar/fullcalendar.min.js"></script>
<!--script for this page only-->
<script src="<?php echo base_url(); ?>assets/js/external-dragging-calendar.js"></script>  
<script>
    var detil_pekerjaan_saya = jQuery.parseJSON('<?php if (isset($detil_pekerjaan_saya)) echo json_encode($detil_pekerjaan_saya); ?>');
    var tgl_selesai_pekerjaan_saya = [];
    var tgl_mulai_pekerjaan_saya = [];
    var flag_usulan_pekerjaan_saya = [];
<?php foreach ($pkj_karyawan as $pekerjaan_saya) { ?>
        tgl_selesai_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->tgl_selesai; ?>';
        flag_usulan_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->flag_usulan; ?>';
        tgl_mulai_pekerjaan_saya[<?php echo $pekerjaan_saya->id_pekerjaan; ?>] = '<?php echo $pekerjaan_saya->tgl_mulai; ?>';<?php }
?>

    document.title = "DashBoard - Task Management";
    var jumlah_detil_saya = 0

    if (detil_pekerjaan_saya != null)
        jumlah_detil_saya = detil_pekerjaan_saya.length;

    for (var i = 0; i < jumlah_detil_saya; i++) {
        var detil = detil_pekerjaan_saya[i];
        if (detil['id_akun'] == '<?php echo $data_akun['id_akun']; ?>') {
            ubah_status_pekerjaan('pekerjaan_saya_status_' + detil['id_pekerjaan'], flag_usulan_pekerjaan_saya[detil['id_pekerjaan']], detil['sekarang'], tgl_mulai_pekerjaan_saya[detil['id_pekerjaan']], tgl_selesai_pekerjaan_saya[detil['id_pekerjaan']], detil['tgl_read'], detil['status'], detil['progress']);
        }
    }
</script>

<script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>

<script>
    var tabel_pekerjaan_saya = null;
    var site_url = "<?php echo site_url() ?>";
    jQuery(document).ready(function () {
        $('#tabel_home').dataTable({});
        if (tabel_pekerjaan_saya != null) {
            tabel_pekerjaan_saya.fnDestroy();
            console.log('tabel pekerjaan saya is destroyed');
        }
        tabel_pekerjaan_saya = $('#tabel_pekerjaan_saya').dataTable({
            bServerSide: true,
            sServerMethod: 'post',
            sAjaxSource: site_url + 'pekerjaan/get_pekerjaan_saya_datatable',
            bProcessing: true,
            fnCreatedRow: function (row, data, index) {
                console.log(row);
                console.log(data);
                console.log(index);
            },
            fnServerParams: function (aoData) {
                aoData.push({"name": "more_data", "value": "my_value"});
            }
        });
    });
</script>
<style>
    table thead tr th{
        vertical-align: middle;
        //text-align: center;
    }
</style>