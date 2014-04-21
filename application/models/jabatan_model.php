<?php

class jabatan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function semua() {
        $query = $this->db->query("select * from jabatan order by id_jabatan");
        return $query->result();
    }
    
    public function get_id_jabatan($nama_jabatan) {
        $nama_jabatan = strtolower($nama_jabatan);
        $nama_jabatan=  pg_escape_string($nama_jabatan);
        $query = "select * from jabatan where lower(nama_jabatan)='$nama_jabatan'";
        $query=$this->db->query($query);
        if($query->num_rows()==0){
            return null;
        }
        foreach ($query->result() as $row){
            return $row->id_jabatan;
        }
    }

}

?>