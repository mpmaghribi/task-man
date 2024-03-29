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

class aktivitas_model extends dtpg {

    function get_list_aktivitas_pekerjaan_datatable($id_pekerjaan = 0, $id_detil_pekerjaan = 0, $request = array()) {
        $sql = "select ap.*,
                to_char(ap.waktu_mulai, 'YYYY-MM-DD HH24:MI') as waktu_mulai2, 
                to_char(ap.waktu_selesai, 'YYYY-MM-DD HH24:MI') as waktu_selesai2
                from aktivitas_pekerjaan ap
                where ap.id_detil_pekerjaan='$id_detil_pekerjaan' 
                ";
        $columns = array(
            array('name' => 'id_pekerjaan'),
            array('name' => 'id_aktivitas'),
            array('name' => 'keterangan'),
            array('name' => 'waktu_mulai'),
            array('name' => 'ids'),
            array('name' => 'status_validasi'),
            array('name' => 'kuantitas_output'),
            array('name' => 'angka_kredit'),
            array('name' => 'kualitas_mutu'),
            array('name' => 'biaya'),
            array('name' => 'waktu_selesai'),
            array('name' => 'id_detil_pekerjaan'),
            array('name' => 'nama_files'),
            array('name' => 'waktu_mulai2'),
            array('name' => 'waktu_selesai2')
        );
        return $this->get_datatable($sql, $columns, $request);
    }

    function get_list_progress_pekerjaan_datatable($id_pekerjaan, $id_deti_pekerjaan, $request) {
        $sql = "select dp.*, cast(berkas.nama_files as text) as nama_files, cast(berkas.ids as text) as ids,
                to_char(dp.waktu_mulai,'YYYY-MM-DD HH24:MI:SS') as waktu_mulai2,
                to_char(dp.waktu_selesai,'YYYY-MM-DD HH24:MI:SS') as waktu_selesai2
                from detil_progress dp
                left join (
                    select id_progress, array_agg(nama_file) as nama_files, array_agg(id_file) as ids
                    from file
                    where id_detil_pekerjaan = '$id_deti_pekerjaan'
                    group by id_progress
                ) as berkas
                on berkas.id_progress=dp.id_detil_progress
                where dp.id_detil_pekerjaan='$id_deti_pekerjaan'";
        $columns = array(
            array('name' => 'id_detil_pekerjaan'),
            array('name' => 'id_detil_progress'),
            array('name' => 'deskripsi'),
            array('name' => 'progress'),
            array('name' => 'waktu_mulai'),
            array('name' => 'ids'),
            array('name' => 'validated'),
            array('name' => 'id_pekerjaan'),
            array('name' => 'waktu_selesai'),
            array('name' => 'nama_files'),
            array('name' => 'waktu_mulai2'),
            array('name' => 'waktu_selesai2')
        );
        return $this->get_datatable($sql, $columns, $request);
    }

    function get_tugas_by_id($id_tugas) {
        $q=$this->db->query("select * from assign_tugas where id_assign_tugas='$id_tugas'")->result_array();
        if(count($q)>0){
            return $q[0];
        }
        return null;
    }
    
    function get_realisasi_tugas($id_tugas,$id_detil_pekerjaan){
        $q=$this->db->query("select * from aktivitas_pekerjaan where id_tugas='$id_tugas' and id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
        if(count($q)>0){
            return $q[0];
        }
        return null;
    }

}
