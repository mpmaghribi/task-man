<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detil_pekerjaan_model
 *
 * @author mozar
 */
require_once APPPATH . '/libraries/dtpg.php';
class detil_pekerjaan_model extends dtpg {
    function get_detil_pekerjaan($id_pekerjaan){
        $q=$this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan' order by id_akun")->result_array();
        return $q;
    }
}
