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
        $id_file = pg_escape_string($this->input->get('id_file'));
        $this->load->model(array('pekerjaan_model', 'berkas_model'));
        $berkas = $this->berkas_model->get_berkas($id_file);
        $session = $this->session->userdata('logged_in');
        $status = 1;
        if (count($berkas) > 0) {
            $status = 0;
            $id_pekerjaan = $berkas[0]->id_pekerjaan;
            $path = $berkas[0]->nama_file;
        }
        if ($status == 0) {
            $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
            $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan(array($id_pekerjaan));
            if (count($pekerjaan) == 0) {
                $status = 1;
            }
        }
        if ($status == 0) {
            $atasan = $pekerjaan[0]->id_penanggung_jawab;
            $terbuka = $pekerjaan[0]->id_sifat_pekerjaan == '2';
            $ikut_serta = false;
            foreach ($detil_pekerjaan as $detil) {
                if ($detil->id_akun == $session['id_akun']) {
                    $ikut_serta = true;
                }
            }
            $usulan = $pekerjaan[0]->flag_usulan == '1';
            $draft = $pekerjaan[0]->flag_usulan == '5';
            $approved = $pekerjaan[0]->flag_usulan == '2';
            $terlambat = $pekerjaan[0]->flag_usulan == '9';
        }
        $berhak = $atasan || $terbuka;
        $pekerjaan_valid = $usulan ||  $approved || $terlambat;
        $berhak = $berhak || ($ikut_serta && $pekerjaan_valid);
        $berhak = $berhak&&in_array(1,$session['idmodul']);
        if($berhak){
            if(file_exists($path)){
                header('Content-Description: file');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition:  filename="'.basename($path).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                //header('Pragma: Public');
                header('Content-Length: ' . filesize($path));
                //header('lokasi: "' . $path.'"');
                ob_clean();
                flush();
                readfile($path);
            }
            else{
                echo 'file tidak dapat ditemukan';
            }
        }else{
            echo 'anda tidak berhak mengakses berkas ini';
        }
    }

}

?>