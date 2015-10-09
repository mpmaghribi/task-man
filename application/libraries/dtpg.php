<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dtpg
 *
 * @author mozar
 */
class dtpg {

    static function query_datatable($sqlCount, $sql, $request) {
        $qRow = $this->db->query($sqlCount)->result_array();
        $numRow = $qRow[0]['count'];
    }

}
