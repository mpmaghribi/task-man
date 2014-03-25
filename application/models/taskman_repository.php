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
        $query = "SELECT * from function_login('$f_username', '$f_pwd') as (kode integer, nip character varying(50), nama character varying(50), email character varying(25))";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function sp_register_sistem($nama,$jabatan,$email,$agama,$homephone,$mobilephone,$address,$gender,$nip,$userpassword,$departemen){
        $query = "SELECT * from function_register('$jabatan','$departemen','$nip','$nama','$address','$gender','$agama','$homephone','$mobilephone','$email','$userpassword') as (kode integer)";
        $query = $this->db->query($query);
        return $query->result();
    }
}