<?php
class departemen extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function semua() {
        $query = $this->db->query("select * from departemen order by id_departemen");
        return $query->result();
    }

}
?>