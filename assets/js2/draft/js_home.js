$(document).ready(function () {
    get_list_draft();
});
function draft_ubah_periode() {
    get_list_draft();
}
var tabel_draft = null;
var list_prioritas = [];
list_prioritas[1] = 'Urgent';
list_prioritas[2] = 'Tinggi';
list_prioritas[3] = 'Sedang';
list_prioritas[4] = 'Rendah';
function get_list_draft() {
    $.ajax({
        type: "get",
        url: site_url + "/draft/get_list_draft",
        data: {
            periode: $('#draft_select_periode').val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            var counter = 0;
            if (tabel_draft != null) {
                tabel_draft.fnDestroy();
            }
            var tabel = $('#tabel_draft_body');
            tabel.html('');
            for (var i = 0, i2 = json.length; i < i2; i++) {
                var p = json[i];
                var id = p['id_pekerjaan'];
                var html = '<tr id="draft_id_'+id+'">'
                        + '<td>' + (i + 1) + '</td>'
                        + '<td id="draft_nama_' + id + '"></td>'
                        + '<td id="draft_waktu_' + id + '"></td>'
						+ '<td id="draft_kategori_' + id + '"></td>'
                        + '<td id="draft_prioritas_' + id + '"></td>'
                        + '<td id="draft_aksi_' + id + '"></td>'
                        + '</tr>';
                tabel.append(html);
                $('#draft_nama_' + id).html(p['nama_pekerjaan']);
                $('#draft_kategori_' + id).html(p['kategori']);
                $('#draft_waktu_' + id).html(p['tanggal_mulai'] + ' - ' + p['tanggal_selesai']);
                $('#draft_prioritas_' + id).html(list_prioritas[p['level_prioritas']]);
                $('#draft_aksi_' + id).html(
                        '<div class="btn-group">'
                        + '<button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button">Aksi<span class="caret"></span></button>'
                        + '<ul class="dropdown-menu">'
                        + '<li><a href="'+site_url+'/draft/view?id_draft='+id+'" target="">Detail Draft</a></li>'
						+ '<li><a href="'+site_url+'/draft/assign?id_draft='+id+'" target="">Assign Draft</a></li>'
                        + '<li><a href="'+site_url+'/draft/edit?id_draft='+id+'" target="">Edit Darft</a></li>'
                        + '<li><a href="javascript:show_dialog_hapus_draft('+id+')" target="">Hapus Draft</a></li>'
                        + '</ul>'
                        + '</div>'
                        );
            }
            tabel_draft = $('#tabel_draft').dataTable();
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });
}
function show_dialog_hapus_draft(id_draft){
	$("#id_draft_hapus").val(id_draft);
	$("#modal_draft_hapus").modal("show");
	var td = $("#draft_id_" + id_draft).children();
	//console.log(td);
	var nama_pekerjaan = $(td[1]).html();
	$("#modal_draft_hapus_body").html("<h4>Anda akan menghapus draft pekerjaan <strong>" + nama_pekerjaan +"</strong>. Lanjutkan?</h4>");
}
function hapus_draft(){
	var id_draft = $("#id_draft_hapus").val();
	$.ajax({
		data: {
			id_draft: id_draft
		},
		type: "get",
		url: site_url+"/draft/hapus_draft_json",
		success: function(response) {
			var json = jQuery.parseJSON(response);
			if (json.status == "ok") {
				$("#modal_draft_hapus").modal("hide");
				get_list_draft();
			} else {
				alert(json.reason);
			}
		}
	});
}