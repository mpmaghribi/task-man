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