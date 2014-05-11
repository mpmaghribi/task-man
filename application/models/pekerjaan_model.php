<?php

class pekerjaan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function alltask($id_akun)
    {
        $query = "Select COUNT(*) from detil_pekerjaan inner join pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun = ". pg_escape_string($id_akun)."";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    public function ongoingtask($id_akun)
    {
        $query = "Select COUNT(*) from detil_pekerjaan inner join pekerjaan on detil_pekerjaan.id_akun = ". pg_escape_string($id_akun)."where status = 'on-going'";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    public function finishtask($id_akun)
    {
        $query = "Select COUNT(*) from detil_pekerjaan inner join pekerjaan on detil_pekerjaan.id_akun = ". pg_escape_string($id_akun)."where status = 'finished'";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    public function notworkingtask($id_akun)
    {
        $query = "Select COUNT(*) from detil_pekerjaan inner join pekerjaan on detil_pekerjaan.id_akun = ". pg_escape_string($id_akun)."where status = 'un-read'";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    public function list_pekerjaan($id_akun) {
        $id_akun = pg_escape_string($id_akun);
        $query = "select detil_pekerjaan.id_akun, pekerjaan.*, pekerjaan.tgl_selesai"
                . "  from detil_pekerjaan inner join pekerjaan on "
                . "detil_pekerjaan.id_pekerjaan=pekerjaan.id_pekerjaan  where detil_pekerjaan.id_akun=$id_akun "
                . "order by tglasli_mulai desc";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function list_pending_task($id_akun) {
        $id_akun = pg_escape_string($id_akun);
        $query = "select detil_pekerjaan.id_detil_pekerjaan, pekerjaan.nama_pekerjaan,"
                . "detil_pekerjaan.id_pekerjaan, detil_pekerjaan.id_akun, detil_pekerjaan.progress, "
                . "pekerjaan.tgl_selesai from detil_pekerjaan inner join pekerjaan on "
                . "detil_pekerjaan.id_pekerjaan=pekerjaan.id_pekerjaan  "
                . "where id_akun=$id_akun "
                . "and progress<100";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj) {
        $sifat_pkj = pg_escape_string($sifat_pkj);
        $deskripsi_pkj = pg_escape_string($deskripsi_pkj);
        $prioritas = pg_escape_string($prioritas);
        $status_pkj = pg_escape_string($status_pkj);
        $asal_pkj = pg_escape_string($asal_pkj);
        $parent_pkj = pg_escape_string($parent_pkj);
        $tgl_mulai_pkj = pg_escape_string($tgl_mulai_pkj);
        $tgl_selesai_pkj = pg_escape_string($tgl_selesai_pkj);
        $nama_pkj = pg_escape_string($nama_pkj);
        $query1 = "insert into pekerjaan (id_sifat_pekerjaan, parent_pekerjaan, "
                . "nama_pekerjaan, deskripsi_pekerjaan, tgl_mulai, tgl_selesai, asal_pekerjaan, "
                . "level_prioritas, flag_usulan)"
                . " values ('$sifat_pkj', '$parent_pkj', '$nama_pkj', "
                . "'$deskripsi_pkj', to_date('$tgl_mulai_pkj', 'DD-MM-YYYY'), to_date('$tgl_selesai_pkj', 'DD-MM-YYYY'), "
                . "'$asal_pkj','$prioritas', '$status_pkj');";
        $query2 = $this->db->query($query1);
        if ($query2 === true) {
            $query1 = "select currval('tbl_pekerjaan_id') as id_baru";
            $query2 = $this->db->query($query1);
            //return $query2->result()[0]->id_baru;
            foreach ($query2->result() as $row) {
                return $row->id_baru;
            }
        }
        //echo $query1;
        return NULL;
    }

    public function tambah_detil_pekerjaan($id_akun, $id_pekerjaan) {
        $query = "insert into detil_pekerjaan(id_akun, id_pekerjaan, "
                . "skor, progress, status) values ('$id_akun', '$id_pekerjaan',0,0,"
                . "'Belum Dibaca')";
        $query = $this->db->query($query);
    }

    public function sp_deskripsi_pekerjaan($id_detail_pkj) {
        $query = "select * from pekerjaan inner join sifat_pekerjaan "
                . "on sifat_pekerjaan.id_sifat_pekerjaan = pekerjaan.id_sifat_pekerjaan "
                . "where pekerjaan.id_pekerjaan = " . $id_detail_pkj . ";";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_progress_pekerjaan($id_detail_pkj) {
        $query = "select * from detil_pekerjaan inner join pekerjaan "
                . "on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan "
                . "inner join sifat_pekerjaan on sifat_pekerjaan.id_sifat_pekerjaan "
                . "= pekerjaan.id_sifat_pekerjaan inner join akun on akun.id_akun "
                . "= detil_pekerjaan.id_akun where pekerjaan.id_pekerjaan = " . 
                $id_detail_pkj . " and akun.id_akun = " . $this->session->userdata('user_id') . ";";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_updateprogress_pekerjaan($data, $id_detail_pkj) {
        $query = "update detil_pekerjaan set progress =" . $data . " where id_detil_pekerjaan =" . $id_detail_pkj;
        if ($this->db->query($query)) {
            return 1;
        }
        return 0;
    }

    public function sp_listassign_pekerjaan($id_detail_pkj) {
        $query = "select * from detil_pekerjaan inner join pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan inner join sifat_pekerjaan on sifat_pekerjaan.id_sifat_pekerjaan = pekerjaan.id_sifat_pekerjaan where pekerjaan.id_pekerjaan = " . $id_detail_pkj . ";";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar) {
        $query = "insert into komentar (id_akun, id_pekerjaan, isi_komentar) values ('" . $id_akun . "','" . $id_detail_pkj . "','" . $isi_komentar . "');";
        $query = $this->db->query($query);
    }

    public function sp_lihat_komentar_pekerjaan($id_detail_pkj) {
        $query = "select * from komentar inner join pekerjaan on pekerjaan.id_pekerjaan = komentar.id_pekerjaan  where komentar.id_pekerjaan = " . $id_detail_pkj . ";";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_list_usulan_pekerjaan($list_id_akun) {
        if (count($list_id_akun)==0)
            return NULL;
        $query = "select detil_pekerjaan.id_detil_pekerjaan, pekerjaan.nama_pekerjaan, pekerjaan.tgl_mulai," .
                "pekerjaan.tgl_selesai, pekerjaan.flag_usulan, pekerjaan.id_pekerjaan, detil_pekerjaan.id_akun " .
                "from detil_pekerjaan " .
                "inner join pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan " .
                "where pekerjaan.flag_usulan='1' and id_akun in (".implode(",",  $list_id_akun).")";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function validasi_pekerjaan($id_pekerjaan) {
        $id_pekerjaan=  pg_escape_string($id_pekerjaan);
        $query = "update pekerjaan set flag_usulan=2 where id_pekerjaan=" . $id_pekerjaan;
        if ($this->db->query($query)) {
            $query = "update detil_pekerjaan set status='Belum Dibaca', tgl_read=null, tglasli_mulai=null, tglasli_selesai=null, skor=0, progress=0 where id_pekerjaan=$id_pekerjaan";
            $this->db->query($query);
            return 1;
        }
        return 0;
    }

    /*
     * query pekerjaan yang pernah dan sedang dikerjakan oleh staff pada suatu departemen
     */

    public function list_pekerjaan_staff($id_departemen) {
        /*if ($id_departemen != NULL && strlen($id_departemen) > 0) {
            $this->load->model("jabatan_model");
            $id_jabatan_staff = $this->jabatan_model->get_id_jabatan("staff");
            if ($id_jabatan_staff == NULL) {
                return NULL;
            }
            $query = "select pekerjaan.*,detil_pekerjaan.progress,detil_pekerjaan.status, akun.nama, detil_pekerjaan.tgl_read, now() "
                    . "as sekarang from pekerjaan left outer join detil_pekerjaan on pekerjaan.id_pekerjaan="
                    . "detil_pekerjaan.id_pekerjaan inner join akun on akun.id_akun=detil_pekerjaan.id_akun"
                    . " where akun."
                    . "id_jabatan=$id_jabatan_staff and akun.id_departemen=$id_departemen"
                    . " order by pekerjaan.id_pekerjaan desc";
            //echo $query;
            return $this->db->query($query)->result();
        }
        return NULL;*/
        $this->load->model("akun");
    }

    public function staff_progress($id_pekerjaan) {
        if ($id_pekerjaan == NULL || strlen($id_pekerjaan) == 0) {
            return NULL;
        }
        $this->load->model("jabatan_model");
        $id_jabatan_staff = $this->jabatan_model->get_id_jabatan("staff");
        $query = "select detil_pekerjaan.progress, detil_pekerjaan.skor, akun.nama from detil_pekerjaan"
                . " inner join akun on akun.id_akun=detil_pekerjaan.id_akun where "
                . "akun.id_jabatan=$id_jabatan_staff and detil_pekerjaan.id_pekerjaan=$id_pekerjaan "
                . "and akun.id_departemen=" . $this->session->userdata("user_departemen")
                . " order by pekerjaan.id_pekerjaan";
        //echo $query;
        return $this->db->query($query)->result();
    }

    public function baca_pending_task($id_pekerjaan, $id_user) {
        if ($id_pekerjaan != NULL && $id_user != NULL && strlen($id_pekerjaan) > 0 &&
                strlen($id_user) > 0) {
            $query = "update detil_pekerjaan set tgl_read=now() where id_akun=$id_user and "
                    . "id_pekerjaan=$id_pekerjaan and tgl_read is null";
            $query="update detil_pekerjaan set tgl_read=now(), status='Sudah Dibaca' "
                    . "from pekerjaan where id_akun=$id_user "
                    . "and pekerjaan.id_pekerjaan=$id_pekerjaan and tgl_read is null and "
                    . "pekerjaan.flag_usulan='2' and pekerjaan.id_pekerjaan = "
                    . "detil_pekerjaan.id_pekerjaan";
            $this->db->query($query);
        }
    }
    public function get_status_usulan($id_pekerjaan ){
        $query = "select flag_usulan from pekerjaan where id_pekerjaan = $id_pekerjaan";
        $query = $this->db->query($query);
        foreach ($query->result() as $row){
            return $row->flag_usulan;
        }
        return NULL;
    }
    public function get_pekerjaan($id_pekerjaan) {
        $query = "select * from pekerjaan where id_pekerjaan = $id_pekerjaan";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function get_detil_of_pekerjaan($id_pekerjaan) {
        $query="select detil_pekerjaan.*, akun.nama,akun.nip from detil_pekerjaan inner join akun"
                . " on akun.id_akun=detil_pekerjaan.id_akun where id_pekerjaan=$id_pekerjaan";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function  get_detil_pekerjaan($list_id_pekerjaan){
        if(count($list_id_pekerjaan)==0)return NULL;
        $query = "select detil_pekerjaan.id_pekerjaan, id_akun, tgl_read, tglasli_mulai, tglasli_selesai, progress, skor, now() as sekarang, status, pekerjaan.tgl_selesai "
                . "from detil_pekerjaan inner join pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_pekerjaan in "
                . "(".implode(",",  $list_id_pekerjaan).")";
        $query=$this->db->query($query);
        return $query->result();
    }
}

?>