<?php

class akun extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_akun($nip) {
        $nip = pg_escape($nip);
        $query = "select * from akun where nip='$nip'";
        $query = $this->db->query($query);
        if ($query->num_rows() == 1){
            $row=$query->result();
            return $row[0];
        }
        return array("error"=>"not found");
    }
}

?>