var tipe_kalender = 'rutin';
var date_min = 0;
var date_max = 0;
$('#periode').on('change', function () {
    var year = parseInt(this.value);
    date_min = new Date(year, 0, 0, 23, 59, 59, 0);
    date_max = new Date(year + 1, 0, 1, 0, 0, 0, 0);
    $('.dpd1').val('01-01-' + (date_min.getFullYear() + 1));
    $('.dpd2').val('31-12-' + (date_min.getFullYear() + 1));
});
$(function () {

    var nowTemp = new Date();
    //var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
//    var now = new Date(Date.UTC(nowTemp.getFullYear(), 0, 0, 0, 0, 0, 0));
    var year = parseInt($('#periode').val());
    date_min = new Date(year, 0, 0, 23, 59, 59, 0);
    date_max = new Date(year + 1, 0, 1, 0, 0, 0, 0);
    console.log(nowTemp);
    console.log(date_min);
    console.log(date_max);
    if ($('.dpd1').val().length <= 0)
        $('.dpd1').val('01-01-' + (date_min.getFullYear() + 1));
    if ($('.dpd2').val().length <= 0)
        $('.dpd2').val('31-12-' + (date_min.getFullYear() + 1));
    var checkin = $('.dpd1').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date.valueOf() < date_min.valueOf() || date.valueOf() >= date_max ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
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
        onRender: function (date) {
            return date.valueOf() <= checkin.date.valueOf() || date.valueOf() >= date_max ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        checkout.hide();
    }).data('datepicker');

//    var checkin2 = $('.dpd3').datepicker({
//        format: 'dd-mm-yyyy',
//        onRender: function (date) {
//            return date.valueOf() < now.valueOf() ? 'disabled' : '';
//        }
//    }).on('changeDate', function (ev) {
//        if (ev.date.valueOf() > checkout2.date.valueOf()) {
//            var newDate = new Date(ev.date)
//            newDate.setDate(newDate.getDate() + 1);
//            checkout2.setValue(newDate);
//        }
//        checkin2.hide();
//        $('.dpd4')[0].focus();
//    }).data('datepicker');
//    var checkout2 = $('.dpd4').datepicker({
//        format: 'dd-mm-yyyy',
//        onRender: function (date) {
//            return date.valueOf() <= checkin2.date.valueOf() ? 'disabled' : '';
//        }
//    }).on('changeDate', function (ev) {
//        checkout2.hide();
//    }).data('datepicker');
});