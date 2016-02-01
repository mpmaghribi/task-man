var usulan_date_min = new Date();
var usulan_date_max = new Date();

jQuery(document).ready(function () {
	usulan_kategori_changed();
	usulan_date_min.setMonth(0);
	usulan_date_min.setDate(1);
	usulan_date_min.setHours(0);
	usulan_date_min.setMinutes(0);
	usulan_date_min.setSeconds(0);
	usulan_date_min.setMilliseconds(0);
	usulan_date_max.setMonth(11);
	usulan_date_max.setDate(31);
	usulan_date_max.setHours(0);
	usulan_date_max.setMinutes(0);
	usulan_date_max.setSeconds(0);
	usulan_date_max.setMilliseconds(0);
	console.log(usulan_date_min);
	console.log(usulan_date_max);
	init_date_picker();
	periode_changed();
});

function berkas_usulan_changed(){
	var berkas = document.getElementById("pilih_berkas_usulan");
	console.log(berkas.files);
	populate_file("berkas_usulan", berkas.files);
}

function click_pilih_berkas_usulan(){
	$("#pilih_berkas_usulan")[0].click();
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

var waktu_mulai=null;
var waktu_selesai=null;
function init_date_picker(){
	waktu_mulai = $("#usulan_tanggal_mulai").datepicker({
		format: "dd-mm-yyyy",
		onRender: function(date){
			return date <= usulan_date_min || date > usulan_date_max ? "disabled" : "";
		}
	}).on("changeDate", function(ev){
		waktu_mulai.hide("fast");
		$("#usulan_tanggal_selesai").focus();
		console.log("waktu mulai " + ev.date);
	}).data("datepicker");
	
	waktu_selesai = $("#usulan_tanggal_selesai").datepicker({
		format: "dd-mm-yyyy",
		onRender: function(date){
			return date < usulan_date_min || date > usulan_date_max || date < waktu_mulai.date ? "disabled" : "";
		}
	}).on("changeDate", function(ev){
		waktu_selesai.hide("fast");
		console.log("waktu selesai " + ev.date);
	}).data("datepicker");
	
	waktu_mulai.setValue(usulan_date_min);
	waktu_selesai.setValue(usulan_date_max);
}

function periode_changed(){
	var periode = $("#usulan_periode").val();
	usulan_date_min.setFullYear(periode);
	usulan_date_max.setFullYear(periode);
	waktu_mulai.setValue(usulan_date_min);
	waktu_selesai.setValue(usulan_date_max);
}

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

function usulan_kategori_changed(){
	var kategori = $("#select_usulan_kategori").val();
	if(kategori == "project" || kategori == "rutin"){
		$("#div_ak").show("fast");
		$("#div_kuantitas").show("fast");
		$("#div_kualitas").show("fast");
		$("#div_biaya").show("fast");
		$("#div_manfaat").hide("fast");
	}else{
		$("#div_ak").hide("fast");
		$("#div_kuantitas").hide("fast");
		$("#div_kualitas").hide("fast");
		$("#div_biaya").hide("fast");
		if(kategori == "tambahan"){
			$("#div_manfaat").hide("fast");
		}else if(kategori == "kreativitas"){
			$("#div_manfaat").show("fast");
		}
	}
}