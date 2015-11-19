<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aktivitas_model
 *
 * @author mozar
 */
require_once APPPATH . '/libraries/dtpg.php';
class aktivitas_model extends dtpg{
    function get_list_aktivitas_pekerjaan_datatable($id_pekerjaan=0,$id_staff=0, $request=array()){
        $sql="select * from aktivitas_pekerjaan where id_akun='$id_staff' and id_pekerjaan='$id_pekerjaan'";
        $columns=array(
            array('name'=>'id_pekerjaan'),
            array('name'=>'id_aktivitas'),
            array('name'=>'keterangan'),
            array('name'=>'angka_kredit'),
            array('name'=>'kuantitas_output'),
            array('name'=>'kualitas_mutu'),
            array('name'=>'waktu_mulai'),
            array('name'=>'biaya'),
            array('name'=>'waktu_selesai'),
            array('name'=>'id_akun'),
            array('name'=>'status_validasi')
        );
        return $this->get_datatable($sql,$columns,$request);
    }
}
