<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of taskman_repository
 *
 * @author Oktri Raditya
 */
class taskman_repository extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    //put your code here
    public function sp_login_sistem($f_username, $f_pwd){
        $query = "SELECT function_login('$f_username', '$f_pwd') as hasil";
        $query = $this->db->query($query);
        return $query->result();
    }
}