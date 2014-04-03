<?php

class pekerjaan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function list_pekerjaan() {
        $query = "select detil_pekerjaan.*, pekerjaan.nama_pekerjaan, pekerjaan.tgl_selesai, akun.nama from detil_pekerjaan inner join pekerjaan on detil_pekerjaan.id_pekerjaan=pekerjaan.id_pekerjaan inner join akun on akun.id_akun=detil_pekerjaan.id_akun order by tglasli_mulai desc";
        $query = $this->db->query($query);
        return $query->result();
    }
}
?>