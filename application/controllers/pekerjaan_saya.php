<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pekerjaan_saya
 *
 * @author mozar
 */
require APPPATH . '/libraries/ceklogin.php';

class pekerjaan_saya extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->model("pengaduan_model");
    }

    public function index() {
        $this->session->set_userdata('prev', 'pekerjaan/karyawan');
        $this->load->model("pekerjaan_model");
        $this->load->model("akun");
        $temp = $this->session->userdata('logged_in');
        if (in_array(1, $temp['idmodul'])) {
            //$result = $this->taskman_repository->sp_view_pekerjaan($temp['user_id']);
            $data['data_akun'] = $this->session->userdata('logged_in');
            //$data['pkj_karyawan'] = $result;
            //$list_id_pekerjaan = array();
//            foreach ($result as $pekerjaan) {
//                $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
//            }
            //$staff = $this->akun->my_staff($temp["user_id"]);
            //$detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
            //$data["detil_pekerjaan"] = $detil_pekerjaan;
            //$data["my_staff"] = json_encode($staff);
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang berada di halaman pekerjaan.");
            //var_dump($data["pkj_karyawan"]);
            if (in_array(2, $temp['idmodul'])) {
                $atasan = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $temp["user_id"] . "/format/json";
                $data["atasan"] = json_decode(file_get_contents($atasan));
            }
            $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
            $data["users"] = json_decode(file_get_contents($url));
            $this->load->view('pekerjaan_saya/view_pekerjaan_saya', $data);
        } else {
            $data['judul_kesalahan'] = 'Tidak berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses pekerjaan';
            $this->load->view('pekerjaan/kesalahan', $data);
        }
    }

    function detail() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $session = $this->session->userdata('logged_in');
        $pekerjaan = null;
        $q = $this->db->query("select * from pekerjaan p inner join sifat_pekerjaan s on s.id_sifat_pekerjaan=p.id_sifat_pekerjaan where p.id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            redirect(base_url() . 'pekerjaan_saya');
            return;
        }
        $detil_pekerjaans = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $detil_pekerjaan = null;
        foreach ($detil_pekerjaans as $dp) {
            if ($dp['id_akun'] == $session['user_id']) {
                $detil_pekerjaan = $dp;
                break;
            }
        }
        if ($detil_pekerjaan == null) {
            redirect(base_url() . 'pekerjaan_saya');
            return;
        }
        $data = array(
            'data_akun' => $session,
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaans' => $detil_pekerjaans,
            'detil_pekerjaan' => $detil_pekerjaan
        );
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["users"] = json_decode(file_get_contents($url));
        $this->load->view('pekerjaan_saya/view_detail', $data);
    }

    public function get_list_pekerjaan_saya_datatable() {
        $this->load->model(array('pekerjaan_saya_model'));
        $session = $this->session->userdata('logged_in');

        echo json_encode($this->pekerjaan_saya_model->get_list_pekerjaan_saya_datatable($_POST, $session['user_id']));
    }

}
