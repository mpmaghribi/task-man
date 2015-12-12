<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class download extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->model("pengaduan_model");
    }

    public function index() {
        $id_file = abs(intval($this->input->get('id_file')));
        $session = $this->session->userdata('logged_in');
        $q = $this->db->query("select * from file where id_file='$id_file'")->result_array();
        $berkas = null;
        $pekerjaan = null;
        $detil_pekerjaan = null;
        $berhak = false;
        if (count($q) > 0) {
            $berkas = $q[0];
        }
        if ($berkas == null) {
            echo "Dokumen tidak dapat ditemukan";
            return;
        }
        $id_pekerjaan = $berkas['id_pekerjaan'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            echo "Pekerjaan tidak dapat ditemukan";
            return;
        }
        if ($pekerjaan['id_penanggung_jawab'] == $session['user_id']) {
            $berhak = true;
        } else {
            $my_id = $session['user_id'];
            $q = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan' and id_akun='$my_id'")->result_array();
            if (count($q) > 0) {
                $detil_pekerjaan = $q[0];
            }
            if ($detil_pekerjaan == null) {
                echo "Anda tidak berhak mengakses dokumen pekerjaan ini";
                return;
            }
            $berhak = true;
        }

        if (file_exists($berkas['path'])) {
            header('Content-Description: file');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition:  filename="' . $berkas['nama_file'] . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Content-Length: ' . filesize($berkas['path']));
            ob_clean();
            flush();
            readfile($berkas['path']);
        } else {
            echo 'file tidak dapat ditemukan';
        }
    }

}

?>