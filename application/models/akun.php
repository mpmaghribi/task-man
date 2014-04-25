<?php

class akun extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_akun($nip) {
        $nip = pg_escape_string($nip);
        $query = "select * from akun where nip='$nip'";
        $query = $this->db->query($query);
        if ($query->num_rows() == 1) {
            $row = $query->result();
            return $row[0];
        }
        return array("error" => "not found");
    }
    public function get_id_akun($nip) {
        $nip=  pg_escape_string($nip);
        $query = "select id_akun from akun where nip='$nip'";
        $query = $this->db->query($query);
        if($query->num_rows()==0)
            return NULL;
        foreach ($query->result() as $row){
            return $row->id_akun;
        }
    }

    public function update($nip, $updatedata) {
        $this->db->where("nip", $nip);
        $this->db->update("akun", $updatedata);
        return 1;
    }

    public function ubah_password($nip, $pl, $pb, $pb2) {
        if ($pb == $pb2) {
            $query = $this->db->get_where('akun', array('nip' => $nip));
            if ($query->num_rows() == 1) {
                $row = $query->result();
                if ($row[0]->akun_password === sha1($pl)) {
                    $this->db->update('akun', array("akun_password" => sha1($pb)), array('nip' => $nip));
                    return 1;
                } else
                    return -1;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    public function my_staff($id_akun) {
        $query = "select * from akun where id_akun=$id_akun";
        $query = $this->db->query($query);
        if ($query->num_rows() == 0) {
            echo "akun not found";
            return NULL;
        }
        $id_departemen = $this->session->userdata("user_departemen");
        /* ($query->result() as $row) {
            $id_departemen = $row->id_departemen;
            break;
        }
        if ($id_departemen == NULL) {
            echo "departemen not found";
            return NULL;
        }*/
        $this->load->model("jabatan_model");
        $id_jabatan = $this->jabatan_model->get_id_jabatan("staff");
        if ($id_jabatan == NULL){
            echo "id jabatan not found";
            return NULL;
        }
        $query = "select id_akun, nip, nama from akun where id_departemen=$id_departemen and id_jabatan=$id_jabatan";
        $query=$this->db->query($query);
        return $query->result();
    }

}

?>