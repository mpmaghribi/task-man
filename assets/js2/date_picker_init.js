$(function () {
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var checkin = $('.dpd1').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
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
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        checkout.hide();
    }).data('datepicker');

    var checkin2 = $('.dpd3').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        if (ev.date.valueOf() > checkout2.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout2.setValue(newDate);
        }
        checkin2.hide();
        $('.dpd4')[0].focus();
    }).data('datepicker');
    var checkout2 = $('.dpd4').datepicker({
        format: 'dd-mm-yyyy',
        onRender: function (date) {
            return date.valueOf() <= checkin2.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        checkout2.hide();
    }).data('datepicker');
});