/*
 Morris.Bar({
 element: 'graph-bar',
 data: [
 {x: '2011 Q1', y: 3, z: 2, a: 3},
 {x: '2011 Q2', y: 2, z: null, a: 1},
 {x: '2011 Q3', y: 0, z: 2, a: 4},
 {x: '2011 Q4', y: 2, z: 4, a: 3}
 ],
 xkey: 'x',
 ykeys: ['y', 'z', 'a'],
 labels: ['Y', 'Z', 'A'],
 barColors:['#E67A77','#D9DD81','#79D1CF']
 
 
 });
 */
//var day_data = [
//    {"elapsed": "1", "value": 34},
//    {"elapsed": "2", "value": 24},
//    {"elapsed": "3", "value": 3},
//    {"elapsed": "4", "value": 12},
//    {"elapsed": "5", "value": 13},
//    {"elapsed": "6", "value": 22},
//    {"elapsed": "7", "value": 5},
//    {"elapsed": "8", "value": 26},
//    {"elapsed": "9", "value": 12},
//    {"elapsed": "10", "value": 19}
//];
var day_data = [];

$(document).ready(function () {
    var tt = {};
    var a = 1;
    $.ajax({
        type: "POST",
        url: location.origin + "/taskmanagement/index.php/pekerjaan_saya/vardata",
        success: function (dataCheck) {
            //alert(dataCheck['nama_pekerjaan'][0]);
            var objData = eval(dataCheck);
            $.each(objData, function (index, value) {
                day_data.push({"elapsed": "P " +a, "value": value.jml});
                a = a + 1;
            });
            Morris.Line(
            {
                element: 'graph-line',
                data: day_data,
                xkey: 'elapsed',
                ykeys: ['value'],
                labels: ['Jumlah'],
                lineColors: ['#1FB5AD'],
                parseTime: false
            });
        }

        , error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
        }
    });
    //console.log(day_data);
    
});



//function getdatachart() {
////    alert(location.origin+"/taskmanagement/index.php/pekerjaan_saya/vardata");
//    var tt = {};
//    var a = 1;
//    $.ajax({
//        type: "POST",
//        url: location.origin + "/taskmanagement/index.php/pekerjaan_saya/vardata",
//        success: function (dataCheck) {
//            //alert(dataCheck['nama_pekerjaan'][0]);
//            var objData = eval(dataCheck);
//            $.each(objData, function (index, value) {
//
////                    alert(value.nama_pekerjaan+" "+value.jml)
//                tt = {"elapsed": "P" + a, "value": a};
//                day_data.push({"elapsed": "P" + a, "value": a});
//                a = a + 1;
//            });
//        }
//
//        , error: function (xhr, ajaxOptions, thrownError) {
//            alert(xhr.status);
//            alert(thrownError);
//            alert(xhr.responseText);
//        }
//    });
//    console.log(day_data);
//}






/*
 // Use Morris.Area instead of Morris.Line
 Morris.Area({
 element: 'graph-area-line',
 behaveLikeLine: false,
 data: [
 {x: '2011 Q1', y: 3, z: 3},
 {x: '2011 Q2', y: 2, z: 1},
 {x: '2011 Q3', y: 2, z: 4},
 {x: '2011 Q4', y: 3, z: 3},
 {x: '2011 Q5', y: 3, z: 4}
 ],
 xkey: 'x',
 ykeys: ['y', 'z'],
 labels: ['Y', 'Z'],
 lineColors:['#E67A77','#79D1CF']
 
 
 
 });
 
 
 
 
 
 // Use Morris.Area instead of Morris.Line
 Morris.Donut({
 element: 'graph-donut',
 data: [
 {value: $('#alltaskval').val(), label: 'All', formatted: $('#alltaskval').val()+' Tasks' },
 {value: $('#ongoingval').val(), label: 'On-Going', formatted: $('#ongoingval').val()+' Tasks' },
 {value: $('#finishedval').val(), label: 'Finished', formatted: $('#finishedval').val()+' Tasks' },
 {value: $('#nwyval').val(), label: 'Not Working Yet', formatted: $('#nwyval').val()+' Tasks' }
 ],
 backgroundColor: '#fff',
 labelColor: '#1fb5ac',
 colors: [
 '#E67A77','#D9DD81','#79D1CF','#95D7BB'
 ],
 formatter: function (x, data) { return data.formatted; }
 });
 
 
 
 // Use Morris.Area instead of Morris.Line
 Morris.Area({
 element: 'graph-area',
 behaveLikeLine: true,
 gridEnabled: false,
 gridLineColor: '#dddddd',
 axes: true,
 fillOpacity:.7,
 data: [
 {period: '2010 Q1', iphone: 10, ipad: 10, itouch: 10},
 {period: '2010 Q2', iphone: 1778, ipad: 7294, itouch: 18441},
 {period: '2010 Q3', iphone: 4912, ipad: 12969, itouch: 3501},
 {period: '2010 Q4', iphone: 3767, ipad: 3597, itouch: 5689},
 {period: '2011 Q1', iphone: 6810, ipad: 1914, itouch: 2293},
 {period: '2011 Q2', iphone: 5670, ipad: 4293, itouch: 1881},
 {period: '2011 Q3', iphone: 4820, ipad: 3795, itouch: 1588},
 {period: '2011 Q4', iphone: 25073, ipad: 5967, itouch: 5175},
 {period: '2012 Q1', iphone: 10687, ipad: 34460, itouch: 22028},
 {period: '2012 Q2', iphone: 1000, ipad: 5713, itouch: 1791}
 
 
 ],
 lineColors:['#E67A77','#D9DD81','#79D1CF'],
 xkey: 'period',
 ykeys: ['iphone', 'ipad', 'itouch'],
 labels: ['iPhone', 'iPad', 'iPod Touch'],
 pointSize: 0,
 lineWidth: 0,
 hideHover: 'auto'
 
 });
 
 
 
 
 
 */