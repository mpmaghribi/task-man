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
                    $this->db->update('akun', array("akun_password"=>sha1($pb)), array('nip' => $nip));
                    return 1;
                }else
                    return -1;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

}

?>