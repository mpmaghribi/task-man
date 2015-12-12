<?php

class laporan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function nilai_laporan_skp($id_akun)
    {
        $query = "select * from nilai_pekerjaan inner join detil_pekerjaan on detil_pekerjaan.id_detil_pekerjaan = nilai_pekerjaan.id_detil_pekerjaan".
                " inner join pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun = $id_akun and nilai_pekerjaan.id_tipe_nilai = 1";
        return $this->db->query($query)->result();
    }
    public function nilai_laporan_ckp($id_akun)
    {
        $query = "select * from nilai_pekerjaan inner join detil_pekerjaan on detil_pekerjaan.id_detil_pekerjaan = nilai_pekerjaan.id_detil_pekerjaan".
                " inner join pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun = $id_akun and nilai_pekerjaan.id_tipe_nilai = 2";
        return $this->db->query($query)->result();
    }
    public function sp_laporan_per_periode($periode, $id_user)
    {
        if ($periode == 6){
            if (date("n") <= 6){
                $query = "select * from pekerjaan inner join detil_pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun=".pg_escape_string($id_user)." and EXTRACT(month from tgl_mulai) >= 1 AND EXTRACT(month from tgl_mulai) <= 6 and pekerjaan.flag_usulan != '5'";
            }
            else {
                 $query = "select * from pekerjaan inner join detil_pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun=".pg_escape_string($id_user)." and EXTRACT(month from tgl_mulai) >= 7 AND EXTRACT(month from tgl_mulai) <= 12 and pekerjaan.flag_usulan != '5'";
            }
        }
        else
        {
             $query = "select * from pekerjaan inner join detil_pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun=".pg_escape_string($id_user)." and EXTRACT(month from tgl_mulai) >= 1 AND EXTRACT(month from tgl_mulai) <= 12 and pekerjaan.flag_usulan != '5'";
        }
        $query = $this->db->query($query);
        return $query->result();
    }
}

?>