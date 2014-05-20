<?php

class laporan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function sp_laporan_per_periode($periode, $id_user)
    {
        if ($periode == 6){
            if (date("n") <= 6){
                $query = "select * from pekerjaan inner join detil_pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun=".$id_user." and EXTRACT(month from tgl_mulai) >= 1 AND EXTRACT(month from tgl_mulai) <= 6";
            }
            else {
                 $query = "select * from pekerjaan inner join detil_pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun=".$id_user." and EXTRACT(month from tgl_mulai) >= 7 AND EXTRACT(month from tgl_mulai) <= 12";
            }
        }
        else
        {
             $query = "select * from pekerjaan inner join detil_pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun=".$id_user." and EXTRACT(month from tgl_mulai) >= 1 AND EXTRACT(month from tgl_mulai) <= 12";
        }
        $query = $this->db->query($query);
        return $query->result();
    }
}

?>