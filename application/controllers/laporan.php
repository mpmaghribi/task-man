<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class laporan extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
        $this->load->model('laporan_model');
    }

    public function index() {
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $this->load->view('laporan/laporan_pekerjaan_page', $data);
        //var_dump($data["pkj_karyawan"]);
    }

    function exportToPDF() {
        $this->load->helper(array('pdf', 'date'));
        $filename = 'testing.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $this->load->model("pekerjaan_model");
        $this->load->model("akun");
        $result = $this->taskman_repository->sp_view_pekerjaan($temp['user_id']);
        $data['pkj_karyawan'] = $result;
        $list_id_pekerjaan = array();
        foreach ($result as $pekerjaan) {
            $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
        }
        //var_dump($list_id_pekerjaan);
        $staff = $this->akun->my_staff($temp["user_id"]);
        $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
        $data["detil_pekerjaan"] = json_encode($detil_pekerjaan);
        $data["my_staff"] = json_encode($staff);
        
        $html = $this->load->view('laporan/laporan_pekerjaan_pdf',$data,true);
        //$pdf->WriteHTML($html, isset($_GET['vuehtml']));
        header("Content-type:application/pdf");

// It will be called downloaded.pdf
        //header("Content-Disposition:attachment;filename=" . $filename);
        echo generate_pdf($html, $filename, false);
    }

    public function get_idModule() {
        return "admin";
    }

}
