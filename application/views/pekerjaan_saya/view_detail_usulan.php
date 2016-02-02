<?php $this->load->view("taskman_header_page") ?> 
<?php
$user = array();
foreach ($users as $u) {
    $user[$u->id_akun] = $u;
}
$list_kategori = array(
	"rutin" => "Pekerjaan Rutin",
	"project" => "Pekerjaan Project",
	"tambahan" => "Pekerjaan Tambahan",
	"kreativitas" => "Pekerjaan Kreativitas"
);
?>
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

                    <div class="col-md-12" >
                        <section class="panel">
                            <header class="panel-heading tab-bg-dark-navy-blue ">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#deskripsiPekerjaan">Deskripsi Pekerjaan</a>
                                    </li>
                                </ul>
                                <div class="btn-group btn-group-lg btn-xs" style="float: right; margin-top: -35px;padding-top: 0px; font-size: 12px;" id="div_acc_edit_cancel_usulan_pekerjaan">
                                    <a class="btn btn-danger btn-xs" href="<?php echo site_url(); ?>/pekerjaan_saya/view_edit_usulan?id_pekerjaan=<?php echo $pekerjaan['id_pekerjaan']; ?>" id="tombol_edit_usulan" style="font-size: 10px">Edit</a>
                                    <a class="btn btn-warning btn-xs" href="javascript:hapus_usulan();" id="tombol_batalkan_usulan" style="font-size: 10px">Batalkan</a>
                                </div>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="deskripsiPekerjaan" class="tab-pane active">
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">Ditujukan Kepada</h4>
                                                <p style="font-size: larger" id="nama_penanggung_jawab"><?= $user[$pekerjaan['id_penanggung_jawab']]->nama ?></p>
                                                <h4 style="color: #1FB5AD;">Nama Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['nama_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Penjelasan Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $pekerjaan['deskripsi_pekerjaan'] ?></p>
                                                <h4 style="color: #1FB5AD;">Jenis Pekerjaan</h4>
                                                <p style="font-size: larger"><?php echo $pekerjaan['nama_sifat_pekerjaan']; ?></p>
                                                <h4 style="color: #1FB5AD;">Kategori Pekerjaan</h4>
                                                <p style="font-size: larger"><?= $list_kategori[$pekerjaan["kategori"]] ?></p>
												<?php 
												if($pekerjaan["kategori"] == "kreativitas"){
													$list_level_manfaat = array(
														1 => "Bermanfaat untuk Unit Kerja",
														2 => "Bermanfaat untuk Organisasi",
														3 => "Bermanfaat untuk Negara"
													);
													?>
													<h4 style="color: #1FB5AD;">Tingkat Manfaat</h4>
													<p style="font-size: larger"><?= $list_level_manfaat[$pekerjaan["level_manfaat"]] ?></p>
													<?php
												}
												?>
                                                <h4 style="color: #1FB5AD;">Periode</h4>
                                                <p style="font-size: larger"><?= explode(' ', $pekerjaan['tgl_mulai'])[0] . ' - ' . explode(' ', $pekerjaan['tgl_selesai'])[0] ?></p>
                                            </section>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="panel">
                                                <h4 style="color: #1FB5AD;">
                                                    File Pendukung
                                                </h4>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover table-condensed" id="table_list_file">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px">#</th>
                                                                <th>Nama File</th>
                                                                <th style="width: 250px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($list_berkas)) {
                                                                $i = 0;
                                                                foreach ($list_berkas as $berkas) {
																	$i++;
                                                                    ?>
                                                                    <tr id="berkas_<?php echo $berkas["id_file"]; ?>" title="diupload pada <?php echo date("d M Y H:i", strtotime($berkas["waktu"])); ?>">
                                                                        <td><?php echo $i; ?></td>
                                                                        <td id="berkas_nama_<?= $berkas["id_file"]; ?>"><?php echo $berkas["nama_file"]; ?></td>
                                                                        <td style="text-align: right">
                                                                            <a class="btn btn-info btn-xs" href="<?php echo base_url() ?>download?id_file=<?= $berkas["id_file"]; ?>" id="" style="font-size: 10px" target="_blank">Download</a>
                                                                            <a class="btn btn-danger btn-xs" href="javascript:hapus_file(<?php echo $berkas["id_file"] ?>);" id="" style="font-size: 10px" onclick=";">Hapus</a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                            
                                    </div>
                                            
                                </div>
								<div class="col-md-12" id="anggota_tim">
									<section class="panel">
										<h4 style="color: #1FB5AD;">
											Anggota Tim
										</h4>
										<div class="panel-body">
											<table class="table table-striped table-hover table-condensed" id="staff_pekerjaan">
												<thead>
													<tr>
														<th>#</th>
														<th>Nama</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$counter = 0;
													foreach ($detil_pekerjaan as $dp) {
														if (!isset($user[$dp['id_akun']]))
															continue;
														$counter++;
														echo '<tr>';
														echo '<td>' . $counter . '</td>';
														echo '<td>' . $user[$dp['id_akun']]->nama . '</td>';
														echo '</tr>';
													}
													?>
												</tbody>
											</table>
										</div>
									</section>
								</div>
                                            
                            


                                        <div class="panel-body">
                                            <form style="display:none" class="cmxform form-horizontal " id="signupForm" method="POST" action="#<?php //echo site_url()                                                                             ?>/pekerjaan/usulan_pekerjaan">
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <button id="komentar" class="btn btn-primary" type="button">Lihat Komentar</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div id="box_komentar" style="display: block">
                                                <div class="form">
                                                    <form class="cmxform form-horizontal " id="signupForm" method="post" action="javascript:void(0)">
                                                        <input type="hidden" id="is_isi_komentar" name="is_isi_komentar" value="true"/>
                                                        <input type="hidden" id="id_detail_pkj" name="id_detail_pkj" value="<?php echo $pekerjaan['id_pekerjaan'] ?>"/>
                                                        <div class="form-group">
                                                            <div id="lihat_komen" class="col-lg-12">

                                                            </div>
                                                            <div id="tes" class="col-lg-12">

                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="col-lg-12">
                                                                <textarea class="form-control" id="komentar_pkj" name="komentar_pkj" rows="12"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-lg-12">
                                                                <button id="save_komen" class="btn btn-primary" type="button">Tambah Komentar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!--script for this page only-->

            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <?php $this->load->view('taskman_rightbar_page') ?>
        <!--right sidebar end-->

    </section>
    <script src="<?php echo base_url() ?>assets/js/table-editable-progress.js"></script>
    <?php
    $this->load->view("taskman_footer_page");
    ?>
    <script>
		var pekerjaan = <?= json_encode($pekerjaan) ?>;
		var id_pekerjaan = pekerjaan["id_pekerjaan"];
		var base_url = '<?= base_url() ?>';
		var site_url = '<?= site_url() ?>';
		var list_akun =<?= json_encode($users) ?>;
		var detil_pekerjaan =<?= json_encode($detil_pekerjaan) ?>;
		$(document).ready(function () {
			document.title = 'Deskripsi Pekerjaan: ' + pekerjaan["nama_pekerjaan"] + ' - Task Management';
			$('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + $('#id_detail_pkj').val());
			$('#submenu_pekerjaan').attr('class', 'dcjq-parent active');
			$('#submenu_pekerjaan_ul').show();
		});
		
		function hapus_usulan(){
			if(confirm("Anda akan membatalkan usulan pekerjaan " + pekerjaan["nama_pekerjaan"] + ". Lanjutkan?") == false){
				return;
			}
			window.location = site_url + "/pekerjaan_saya/hapus_usulan?id_pekerjaan=" + pekerjaan["id_pekerjaan"];
		}
		
		function _(el) {
			return document.getElementById(el);
		}
		function progressHandler(event) {
			_("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
			var percent = (event.loaded / event.total) * 100;
			_("progressBar").value = Math.round(percent);
			_("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
		}
		function completeHandler(event) {
			_("status").innerHTML = '';
			_("progressBar").value = 0;
		}
		function errorHandler(event) {
			_("status").innerHTML = "Upload Failed";
		}
		function abortHandler(event) {
			_("status").innerHTML = "Upload Aborted";
		}

		function uploadFile() {
			$(".tampil_progress").css("display", "block");
			var file = _("file1").files[0];
			var idp = document.getElementById("id_pkj").value;
			var nama_file = document.getElementById("nama_file").value;
			if (file.type === "application/pdf" || file.type === "application/x-download" || file.type === "application/msword")
			{
				var formdata = new FormData();
				formdata.append("file1", file);
				formdata.append("id_pekerjaan", idp);
				if (file.type === "application/x-download" || file.type === "application/pdf") {
					formdata.append("nama_file", nama_file + "_" + new Date().toDateString() + ".pdf");
				}
				else
				{
					formdata.append("nama_file", nama_file + "_" + new Date().toDateString() + ".doc");
				}
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "<?php echo site_url() ?>/file_upload_parser");
				ajax.send(formdata);
			}
			else
			{
				//alert(file.name+" | "+file.size+" | "+file.type); 

				alert("Silahkan upload hanya pdf dan ms word < 2007 saja.");
			}
			//alert(file.name+" | "+file.size+" | "+file.type); 

		}
		function hapus_file(id_file)
		{
			var deskripsi = $("#berkas_nama_" + id_file).html();
			var c = confirm("Anda yakin menghapus file " + deskripsi + "?");
			if (c == true) {
				$.ajax({// create an AJAX call...
					data: {
						id_file: id_file,
					}, 
					type: "get", // GET or POST
					url: "<?php echo site_url(); ?>/pekerjaan_saya/hapus_file_json", // the file to call
					success: function (response) { // on success..
						var json = jQuery.parseJSON(response);
						//alert(response);
						if (json.status === "ok") {
							$('#berkas_' + id_file).remove();
							//$('#tombol_validasi_usulan').remove();
						} else {
							alert("Gagal menghapus file, " + json.reason);
						}
					}
				});
			}
			else {
			}
		}
		function ubah_komentar(id_komen) {
			$.ajax({// create an AJAX call...
				data: {
					id_komentar_ubah: id_komen
				},
				type: "GET", // GET or POST
				url: "<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan_by_id", // the file to call
				success: function (response) { // on success..
					var json = jQuery.parseJSON(response);
					$("#komentar_pkj_ubah").val(json.data);
				}
			});
			$('#ubah_komen').click(function (e) {
				e.preventDefault();
				var id_pkj = document.getElementById('id_detail_pkj').value;
				$.ajax({// create an AJAX call...
					data: {
						id_komentar_ubah: id_komen,
						isi_komentar_ubah: $('#komentar_pkj_ubah').val()
					}, // get the form data
					type: "GET", // GET or POST
					url: "<?php echo site_url(); ?>/pekerjaan/ubah_komentar_pekerjaan", // the file to call
					success: function (response) { // on success..
						//var json = jQuery.parseJSON(response);
						$('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
					}
				});
			});
		}

		function hapus(id) {
			$('#hapus_komen').click(function (e) {
				//alert("pekerjaan yg divalidasi " + id_pekerjaan);
				e.preventDefault();
				var id_pkj = document.getElementById('id_detail_pkj').value;
				$.ajax({// create an AJAX call...
					data:
							{
								id_komentar: id
							}, // get the form data                     type: "GET", // GET or POST
					url: "<?php echo site_url(); ?>/pekerjaan/hapus_komentar_pekerjaan", // the file to call
					success: function (response) { // on success..
						$('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
					}
				});
			});
		}


		$('#save_komen').click(function (e) {
			//alert("pekerjaan yg divalidasi " + id_pekerjaan);
			e.preventDefault();
			var id_pkj = document.getElementById('id_detail_pkj').value;
			$.ajax({// create an AJAX call...
				data:
						{
							id_detail_pkj: document.getElementById('id_detail_pkj').value, // get the form data
							komentar_pkj: document.getElementById('komentar_pkj').value,
							is_isi_komentar: document.getElementById('is_isi_komentar').value
						}, // get the form data
				type: "GET", // GET or POST
				url: "<?php echo site_url(); ?>/pekerjaan/komentar_pekerjaan", // the file to call
				success: function (response) { // on success..
					$('#lihat_komen').load("<?php echo site_url(); ?>/pekerjaan/lihat_komentar_pekerjaan/" + id_pkj);
					document.getElementById('komentar_pkj').value = '';
				}
			});
		});
</script>