<?php

class berkas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function upload_file($id_user, $path, $id_pekerjaan) {
        if($id_user==NULL || $path==NULL  || strlen($id_user)==0||
                strlen($path)==0||   $id_pekerjaan==NULL ||
                strlen($id_pekerjaan)===0){
            //echo "null";
            return NULL;
                }
        $id_pekerjaan=  pg_escape_string($id_pekerjaan);
        $path = pg_escape_string($path);
        $query = "insert into file (id_pekerjaan, nama_file, waktu) values ('$id_pekerjaan','$path',now())";
        //echo $query;
        $this->db->query($query);
    }
    public function get_berkas_of_pekerjaan($id_pekerjaan,$start=0,$limit=100) {
        if($id_pekerjaan==NULL||  strlen($id_pekerjaan)==0)
            return NULL;
        $query = "select * from file where id_pekerjaan=$id_pekerjaan order by waktu limit $limit offset $start";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function get_berkas($id_file){
        $query = "select * from file where id_file=$id_file";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function hapus_file($id_file){
        $query = "delete from file where id_file='$id_file'";
        return $this->db->query($query);
    }
}
?>