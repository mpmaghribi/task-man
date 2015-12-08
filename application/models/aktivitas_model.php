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
        $sql = "select ap.* , berkas.nama_files, berkas.ids
                from aktivitas_pekerjaan ap
                left join (
                    select id_aktivitas, json_agg(nama_file) as nama_files, json_agg(id_file) as ids
                    from file
                    where id_detil_pekerjaan = '$id_detil_pekerjaan'
                    group by id_aktivitas
                ) as berkas
                on berkas.id_aktivitas=ap.id_aktivitas
                where ap.id_detil_pekerjaan='$id_detil_pekerjaan' 
                and ap.id_pekerjaan='$id_pekerjaan'";
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
            
            array('name' => 'nama_files')
        );
        return $this->get_datatable($sql, $columns, $request);
    }

    function get_list_progress_pekerjaan_datatable($id_pekerjaan, $id_deti_pekerjaan, $request) {
        $sql = "select dp.*, cast(berkas.nama_files as text) as nama_files, cast(berkas.ids as text) as ids,
                to_char(dp.waktu_mulai,'YYYY-MM-DD HH24:MI:SS') as waktu_mulai2,
                to_char(dp.waktu_selesai,'YYYY-MM-DD HH24:MI:SS') as waktu_selesai2
                from detil_progress dp
                left join (
                    select id_progress, json_agg(nama_file) as nama_files, json_agg(id_file) as ids
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

}
