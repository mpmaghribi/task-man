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
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }
    public function sp_tambah_detil_pekerjaan($id_pekerjaan_baru, $id_akun){
        $query = "select * from function_tambah_detil_pekerjaan('$id_pekerjaan_baru','$id_akun') "
                . "as (kode integer)";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }


    public function sp_view_pekerjaan($id_user, $start=0, $limit=100) {
        $query = "SELECT * from pekerjaan "
                . "inner join detil_pekerjaan on "
                . "pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan "
                . "where detil_pekerjaan.id_akun=".$id_user." and pekerjaan.flag_usulan in ('1', '2','9') "
                . "and detil_pekerjaan.status!='Batal' limit $limit offset $start";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_recent_activity() {
        $query = "SELECT * from activity order by activity.tanggal_activity DESC limit 10";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    public function sp_insert_activity($id_akun, $id_detil, $nama_pkj, $deskripsi_pkj) {
        $query ="insert into activity (id_akun, id_detil_pekerjaan,"
                . "nama_activity, deskripsi_activity, tanggal_activity)"
                . " values ('$id_akun', '$id_detil', '$nama_pkj', "
                . "'$deskripsi_pkj', 'now()');"; 
        $query = $this->db->query($query);
        return 1;
    }
    
    public function sp_view_profil($id_user)
    {
//        $query = "select * from akun inner join jabatan on jabatan.id_jabatan = akun.id_jabatan where id_akun = ".$id_user."";
//        $query = $this->db->query($query);
//        return $query->result();
        $akun = json_decode(
                file_get_contents(
                        str_replace('taskmanagement','integrarsud',str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/user/id/".$id_user."/format/json"
                        ));
        //var_dump($list_staff);
        return $akun;
    }
    
    public function sp_view_jabatan($id_user)
    {
//        $query = "select * from akun inner join jabatan on jabatan.id_jabatan = akun.id_jabatan where id_akun = ".$id_user."";
//        $query = $this->db->query($query);
//        return $query->result();
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement','integrarsud',str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/".$id_user."/format/json"
                        ));
        //var_dump($list_staff);
        return $jabatan;
    }
    
    public function sp_aktivitas_staff($id_user) {
        $query = "select * from activity where activity.id_akun= ".$id_user." order by activity.tanggal_activity DESC";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    public function sp_log_pekerjaan($id_user) {
        $query = "SELECT * from pekerjaan inner join detil_pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun=".$id_user." and status = 'finished'";
        $query = $this->db->query($query);
        return $query->result();
    }
}
