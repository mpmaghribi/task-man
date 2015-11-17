<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pekerjaan_saya_model
 *
 * @author mozar
 */
require APPPATH . '/libraries/dtpg.php';

class pekerjaan_saya_model extends dtpg {

    function get_list_pekerjaan_saya_datatable($request, $userId) {
        $sqlCount = "select count(p.id_pekerjaan)
            from pekerjaan p
            where p.id_pekerjaan in (
                select dp.id_pekerjaan
                from detil_pekerjaan dp
                where dp.id_akun = '$userId'
            )";
        $sql = "select p.id_pekerjaan, p.nama_pekerjaan,
            concat(p.tgl_mulai, p.tgl_selesai) as deadline,
            0 as assignto, s.status_nama
            from pekerjaan p
            left join status s
            on s.status_id=p.status_pekerjaan
            where p.id_pekerjaan in (
                select dp.id_pekerjaan
                from detil_pekerjaan dp
                where dp.id_akun = '$userId'
            )";
        $columns = array(
            array('name' => 'id_pekerjaan'),
            array('name' => 'nama_pekerjaan'),
            array('name' => 'deadline'),
            array('name' => 'assignto'),
            array('name' => 'status_nama')
        );
        return $this->get_datatable($sql, $columns, $request);
    }

}
