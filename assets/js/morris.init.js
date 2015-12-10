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
<<<<<<< HEAD
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

