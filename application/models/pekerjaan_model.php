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

    public function usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj) {
        $query1 = "insert into pekerjaan (id_sifat_pekerjaan, parent_pekerjaan, "
                . "nama_pekerjaan, deskripsi_pekerjaan, tgl_mulai, tgl_selesai, asal_pekerjaan, "
                . "level_prioritas, flag_usulan)"
                . " values ('$sifat_pkj', '$parent_pkj', '$nama_pkj', "
                . "'$deskripsi_pkj', to_date('$tgl_mulai_pkj', 'DD-MM-YYYY'), to_date('$tgl_selesai_pkj', 'DD-MM-YYYY'), "
                . "'$asal_pkj','$prioritas', '$status_pkj');";
        $query2 = $this->db->query($query1);
        if ($query2 === true) {
            
        }
        //echo $query1;
        return 1;
    }

    public function sp_deskripsi_pekerjaan($id_detail_pkj) {
        $query = "select * from pekerjaan where id_pekerjaan = " . $id_detail_pkj . ";";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar) {
        $query = "insert into komentar (id_akun, id_pekerjaan, isi_komentar) values ('" . $id_akun . "','" . $id_detail_pkj . "','" . $isi_komentar . "');";
        $query = $this->db->query($query);
        return 1;
    }

    public function sp_lihat_komentar_pekerjaan($id_detail_pkj) {
        $query = "select * from komentar inner join pekerjaan on pekerjaan.id_pekerjaan = komentar.id_pekerjaan inner join akun on akun.id_akun = komentar.id_akun where komentar.id_pekerjaan = " . $id_detail_pkj . ";";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_list_usulan_pekerjaan($id_departemen) {
        $query = "select detil_pekerjaan.id_detil_pekerjaan, pekerjaan.nama_pekerjaan, pekerjaan.tgl_mulai," .
                "pekerjaan.tgl_selesai, akun.nama, pekerjaan.flag_usulan, pekerjaan.id_pekerjaan " .
                "from detil_pekerjaan inner join akun on akun.id_akun=detil_pekerjaan.id_akun " .
                "inner join departemen on departemen.id_departemen=akun.id_departemen " .
                "inner join pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan " .
                "where departemen.id_departemen=".$id_departemen;
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

}

?>