<?php

class pengaduan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function sp_tambah_pengaduan($topik, $isi, $tgl, $rekomendasi, $respon, $alasan)
    {
        $query = "insert into pengaduan (topik_pengaduan,isi_pengaduan,tanggal_pengaduan,rekomendasi_urgensitas,respon,alasan_respon) values".
                " ('".pg_escape_string($topik)."','".pg_escape_string($isi)."','".pg_escape_string($tgl)."','".pg_escape_string($rekomendasi)."','".pg_escape_string($respon)."','".pg_escape_string($alasan)."')";
        $query = $this->db->query($query);
        if($query)
        return 1;
        else
            return 0;
    }
}

?>