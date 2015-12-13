<?php

require_once APPPATH . '/libraries/dtpg.php';

class berkas_model extends dtpg {

    public function __construct() {
        parent::__construct();
    }

    public function upload_file($id_user, $path, $id_pekerjaan, $id_progress = null) {
        if ($id_user == NULL || $path == NULL || strlen($id_user) == 0 ||
                strlen($path) == 0 || $id_pekerjaan == NULL ||
                strlen($id_pekerjaan) === 0) {
            //echo "null";
            return NULL;
        }
        $id_pekerjaan = pg_escape_string($id_pekerjaan);
        $path = pg_escape_string($path);
        $query = "insert into file (id_pekerjaan, nama_file, waktu";
        $query2 = " values ('$id_pekerjaan','$path',now()";
        if ($id_progress != null) {
            $query.=",id_progress";
            $query2.=",$id_progress";
        }

        $query2.=")";
        $query.=")" . $query2;
        //echo $query;
        $this->db->query($query);
    }

    public function get_berkas_progress($list_id_progress) {
        if (count($list_id_progress) == 0)
            return array();
        $query = 'select * from file where id_progress in (' . implode(',', $list_id_progress) . ')';
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_berkas_of_pekerjaan($id_pekerjaan, $start = 0, $limit = 100) {
        if ($id_pekerjaan == NULL || strlen($id_pekerjaan) == 0)
            return NULL;
        $query = "select * from file where id_pekerjaan=$id_pekerjaan and id_progress is null order by waktu limit $limit offset $start";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_berkas($id_file) {
        $query = "select * from file where id_file=$id_file";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function hapus_file($id_file) {
        $query = "delete from file where id_file='$id_file'";
        return $this->db->query($query);
    }

    function get_list_file_aktivitas_datatable($id_detil_pekerjaan) {
        $sql = "select file.*, aktivitas_pekerjaan.keterangan, aktivitas_pekerjaan.status_validasi "
                . "from file "
                . "inner join aktivitas_pekerjaan on aktivitas_pekerjaan.id_aktivitas=file.id_aktivitas "
                . "where file.id_detil_pekerjaan='$id_detil_pekerjaan' and file.id_aktivitas is not null";
        $columns = array(
            array('name' => 'id_file'),
            array('name' => 'nama_file'),
            array('name' => 'keterangan'),
            array('name' => 'status_validasi')
        );
        return $this->get_datatable($sql, $columns, $_POST);
    }

    function get_list_file_progress_datatable($id_detil_pekerjaan) {
        $sql = "select file.*, detil_progress.deskripsi, detil_progress.validated "
                . "from file "
                . "inner join detil_progress on detil_progress.id_detil_progress=file.id_progress "
                . "where file.id_detil_pekerjaan='$id_detil_pekerjaan' and file.id_progress is not null";
        $columns = array(
            array('name' => 'id_file'),
            array('name' => 'nama_file'),
            array('name' => 'deskripsi'),
            array('name' => 'validated'),
        );
        return $this->get_datatable($sql, $columns, $_POST);
    }

}

?>