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
        $query = "insert into file (id_pekerjaan, nama_file) values ('$id_pekerjaan','$path')";
        //echo $query;
        $this->db->query($query);
    }
}
?>