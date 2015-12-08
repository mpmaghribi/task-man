<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class home extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->database();

        $this->load->model('pekerjaan_model');
    }

    public function index() {
        $this->load->model(array('akun'));
        $temp = $this->session->userdata('logged_in');
        //print_r($temp['user_email']);
        $bisa_lihat_pekerjaanku = in_array(1, $temp['idmodul']);
        if ($bisa_lihat_pekerjaanku) {
            $result = $this->taskman_repository->sp_view_pekerjaan($temp['user_id']);
            $data['pkj_karyawan'] = $result;
            $list_id_pekerjaan_saya = array();
            foreach ($result as $pekerjaan_saya) {
                $list_id_pekerjaan_saya[] = $pekerjaan_saya->id_pekerjaan;
            }
            $data['detil_pekerjaan_saya'] = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan_saya);
            $data['data_akun'] = $this->session->userdata('logged_in');
            
            //$result1 = $this->pekerjaan_model->alltask($temp['user_id']);
            $result1 = $this->pekerjaan_model->jobthisyear($temp['user_id']);
            $result2 = $this->pekerjaan_model->ongoingtask($temp['user_id']);
            $result3 = $this->pekerjaan_model->finishtask($temp['user_id']);
            $result4 = $this->pekerjaan_model->notworkingtask($temp['user_id']);
            
            $data['alltask'] = $result1[0]->count;
            $data['ongoingtask'] = $result2[0]->count;
            $data['finishtask'] = $result3[0]->count;
            $data['notworkingtask'] = $result4[0]->count;
            $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
            //$data["temp"] = $this->session->userdata('logged_in');
            $data["users"] = json_decode(file_get_contents($url));
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Login", $temp['user_nama'] . " sedang berada di halaman dashboard.");
            
            $staff = $this->akun->my_staff($temp['user_id']);
            $data['my_staff'] = $staff;
            if (count($data['my_staff']) > 0) {
                
                $data['list_draft'] = $this->pekerjaan_model->get_list_draft($temp['user_id']);
                
                $my_staff = array();
                //print_r($staff);
                //var_dump($staff);
                if (isset($staff->error)) {
                    $staff = array();
                    $data['my_staff'] = $staff;
                }
                foreach ($staff as $s) {
                    //print_r($s);
                    //if(is_array($s))
                    $my_staff[] = $s->id_akun;
                }
                //print_r($my_staff);
                $data['pekerjaan_staff'] = $this->pekerjaan_model->get_pekerjaan_staff($my_staff);
                $list_id_pekerjaan = array();
                if ($data['pekerjaan_staff'] != NULL) {
                    foreach ($data['pekerjaan_staff'] as $job) {
                        $list_id_pekerjaan[] = $job->id_pekerjaan;
                    }
                }
                $data['detil_pekerjaan_staff'] = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
            }
            
            $this->load->view('homepage/taskman_home_page', $data);
            //print_r($data);
            $this->session->set_userdata("prev", "home");
            $this->session->set_userdata("prev_text", "Kembali ke Dashboard");
        } else {
            $data['judul_kesalahan'] = 'Tidak Berhask';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak melihat dashboard';
            $this->load->view('pekerjaan/kesalahan', $data);
        }
    }

    public function recent_activity_staff() {
        $temp = $this->session->userdata("logged_in");
        $data['temp'] = $temp;
        $id = $temp["user_id"];
        $data['bawahan'] = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/bawahan/id/" . $id . "/format/json"
        ));
        $data['activity'] = $this->taskman_repository->sp_recent_activity();

        $this->load->view('recent_activity_staff', $data);
    }

    public function recent_activity() {
        $temp = $this->session->userdata("logged_in");
        $data['temp'] = $temp;
        $id = $temp["user_id"];
        $data['bawahan'] = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/bawahan/id/" . $id . "/format/json"
        ));
        $data['activity'] = $this->taskman_repository->sp_recent_activity();

        $this->load->view('recent_activity_page', $data);
    }

    public function get_idModule() {
        return "admin";
    }

}
