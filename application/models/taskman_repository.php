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
        $f_username = pg_escape_string($f_username);
        $query = "SELECT * from function_login('$f_username', '$f_pwd') as (kode integer, nip character varying(50), nama character varying(50), email character varying(25))";
        $query = "select akun.*, jabatan.nama_jabatan from akun inner join jabatan on akun.id_jabatan=jabatan.id_jabatan where nip='$f_username'";
        $query = $this->db->query($query);
        $hasil = array();
        $hasil["kode"] = -1;
        if ($query->num_rows() == 1) {
            $hasil["kode"] = 1;
            $row = $query->result();
            foreach ($row[0] as $p => $v) {
                $hasil[$p] = $v;
            }
            if ($hasil["akun_password"] == sha1($f_pwd)) {
                
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

    public function sp_tambah_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj) {
        $query = "SELECT * from function_tambah_pkj(
            '$sifat_pkj',
            '$parent_pkj',
            '$nama_pkj',
            '$deskripsi_pkj',
            '$tgl_mulai_pkj',
            '$tgl_selesai_pkj',
            '$status_pkj',
            '$asal_pkj',
            '$prioritas') as (kode integer)";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    public function sp_view_pekerjaan() {
        $query = "SELECT * from pekerjaan";
        $query = $this->db->query($query);
        return $query->result();
    }

}
