<div id="div_create_draft" class="tab-pane">
    <div class="form">
        <form class="cmxform form-horizontal " id="form_tambah_pekerjaan2" method="POST" action="<?php echo base_url() ?>pekerjaan/usulan_pekerjaan2" enctype="multipart/form-data">
            <div class="form-group ">
                <label for="staff" class="control-label col-lg-3">Staff</label>
                <div class="col-lg-6">
                    <div id="span_list_assign_staff">
                    </div>
                    <a class="btn btn-success" data-toggle="modal" href="#modalTambahStaff" onclick="tampilkan_staff();">Tambah Staff</a>
                    <input type="hidden" value="::" name="staff" id="staff"/>
                </div>
            </div>

            <div class="form-group ">
                <label for="sifat_pkj" class="control-label col-lg-3">Sifat Pekerjaan</label>
                <div class="col-lg-6">
                    <select name="sifat_pkj" class="form-control m-bot15">
                        <option value="1" >Personal</option>
                        <option value="2" >Umum</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="nama_pkj" class="control-label col-lg-3">Nama Pekerjaan</label>
                <div class="col-lg-6">
                    <input class=" form-control" id="firstname" name="nama_pkj" type="text" value=""/>
                </div>
            </div>
            <div class="form-group ">
                <label for="deskripsi_pkj" class="control-label col-lg-3">Deskripsi</label>
                <div class="col-lg-6">
                    <textarea class="form-control" name="deskripsi_pkj" rows="12"></textarea>
                </div>
            </div>
            <div class="form-group ">
                <label for="deadline" class="control-label col-lg-3">Deadline</label>
                <div class="col-lg-6 ">
                    <div class=" input-group input-large" data-date-format="dd-mm-yyyy">
                        <input id="d" readonly type="text" class="form-control dpd1" value="" name="tgl_mulai_pkj">
                        <span class="input-group-addon">Sampai</span>
                        <input readonly type="text" class="form-control dpd2" value="" name="tgl_selesai_pkj">
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <label for="prioritas" class="control-label col-lg-3">Prioritas</label>
                <div class="col-lg-6">
                    <select name="prioritas" class="form-control m-bot15">
                        <option value="1" >Urgent</option>
                        <option value="2" >Tinggi</option>
                        <option value="3" >Sedang</option>
                        <option value="4" >Rendah</option>
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="prioritas" class="control-label col-lg-3">File</label>
                <div class="col-lg-6">
                    <div id="list_file_upload_assign">
                    </div>
                    <input type="file" multiple="" name="berkas[]" id="pilih_berkas_assign"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-6">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalTambahStaff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="tombol_tutup">&times;</button>
                <h4 class="modal-title">Tambahkan Staff</h4>
            </div>
            <div class="modal-body" id="tambahkan_staff_body">
                <table id="tabel_list_enroll_staff" class="table table-hover general-table">
                    <thead id="tabel_list_enroll_staff_head">
                        <tr id="tabel_list_enroll_staff_head">
                            <th>No</th>
                            <th>NIP</th>
                            <th>Departemen</th>
                            <th>Nama</th>
                            <th>Enroll</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_list_enroll_staff_body">                                                            
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button class="btn btn-success" type="button" onclick="pilih_staff_ok();">Save changes</button>
            </div>
        </div>
    </div>
</div>