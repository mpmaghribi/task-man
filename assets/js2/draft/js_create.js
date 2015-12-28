jQuery(document).ready(function () {
    var sekarang = new Date();
    change_input_deadline(sekarang.getFullYear());
});
function change_input_deadline(periode) {
    var date_min = new Date(periode, 0, 1, 0, 0, 0);
    var date_max = new Date(periode, 11, 31, 23, 59, 59);
    console.log(date_min);
    var waktu_mulai_baru = $('#waktu_mulai_baru').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date < date_min || date > date_max ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        waktu_selesai_baru.setValue(new Date(ev.date));
        waktu_mulai_baru.hide();
        $('#waktu_selesai_baru').focus();
    }).data('datepicker');
    var waktu_selesai_baru = $('#waktu_selesai_baru').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date < date_min || date > date_max || waktu_mulai_baru.date > date ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        waktu_selesai_baru.hide();
    }).data('datepicker');
    waktu_mulai_baru.setValue(date_min);
    waktu_selesai_baru.setValue(date_max);
}