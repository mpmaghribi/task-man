<?php

class jabatan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function semua() {
        $query = $this->db->query("select * from jabatan order by id_jabatan");
        return $query->result();
    }

}

?>