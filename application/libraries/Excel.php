<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Excel
 *
 * @author mozar
 */
require_once APPPATH.'/libraries/excel/PHPExcel.php';
class Excel extends PHPExcel{
    public function __construct() {
        parent::__construct();
    }
}