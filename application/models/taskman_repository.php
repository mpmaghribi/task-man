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
    public function sp_login_sistem($f_username, $f_pwd) {
        $query = "SELECT * from function_login('$f_username', '$f_pwd') as (kode integer, nip character varying(50), nama character varying(50), email character varying(25))";
        $query = "select * from akun where nip='$f_username'";
        $query = $this->db->query($query);
        $hasil = array();
        $hasil["kode"] = -1;
        if ($query->num_rows() == 1) {
            $hasil["kode"] = 1;
            $row = $query->result();
            foreach ($row[0] as $p => $v) {
                $hasil[$p] = $v;
            }
            if ($hasil["akun_password"] == md5($f_pwd)) {
                
            } else {
                $hasil["kode"] = -1;
            }
        }
        return $hasil;
    }

    public function sp_register_sistem($nama, $jabatan, $email, $agama, $homephone, $mobilephone, $address, $gender, $nip, $userpassword, $departemen) {
        $query = "SELECT * from function_register('$jabatan','$departemen','$nip','$nama','$address','$gender','$agama','$homephone','$mobilephone','$email','$userpassword') as (kode integer)";
        $query = $this->db->query($query);
        return $query->result();
    }

}
