<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH.'/libraries/ceklogin.php';

class home extends ceklogin {
    
    public function __construct() {
        parent::__construct();
        //$this->load->database();
        
        $this->load->model('pekerjaan_model');
    }

//    private function check_session_and_cookie() {
//        //$usernamecookie = $this->input->cookie("cookie_user", TRUE);
//        //$passwordcookie = $this->input->cookie("cookie_password", TRUE);
//        $usernamecookie = get_cookie("cookie_user");
//        $passwordcookie = get_cookie("cookie_password");
//        $username = $this->session->userdata("user_nip");
//        $password = $this->session->userdata("user_password");
//        if (strlen($username) > 0 && strlen($password) > 0) {
//            if ($this->authenticate($username, $password) == 1) {
//                //echo "login by session";
//                return 1;
//            } else {
//                if (strlen($usernamecookie) > 0 && strlen($passwordcookie) > 0) {
//                    if ($this->authenticate($usernamecookie, $passwordcookie) == 1) {
//                        //echo "login by cookie";
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//                }
//            }
//        }
//    }
//
//    private function authenticate($username, $password) {
//        $result = $this->taskman_repository->sp_login_sistem($username, $password);
//        if ($result["kode"] == 1) {
//            
//            $this->session->set_userdata(array('user_jabatan' => strtolower($result["nama_jabatan"])));
//            return 1;
//        }
//        return 0;
//    }

    public function index() {
//        if($this->session->userdata('logged_in'))
//        {
            $temp = $this->session->userdata('logged_in');
            $result = $this->taskman_repository->sp_view_pekerjaan($temp['user_id']);
            $data['data_akun'] = $this->session->userdata('logged_in');
            $data['pkj_karyawan'] = $result;
            $result1 = $this->pekerjaan_model->alltask($temp['user_id']);
            $result2 = $this->pekerjaan_model->ongoingtask($temp['user_id']);
            $result3 = $this->pekerjaan_model->finishtask($temp['user_id']);
            $result4 = $this->pekerjaan_model->notworkingtask($temp['user_id']);
            $data['alltask'] = $result1[0]->count;
            $data['ongoingtask'] = $result2[0]->count;
            $data['finishtask'] = $result3[0]->count;
            $data['notworkingtask'] = $result4[0]->count;
            $url = str_replace('taskmanagement','integrarsud',str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
            $data["temp"] = $this->session->userdata('logged_in');
            $data["users"] = json_decode(file_get_contents($url));
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'],0, "Aktivitas Login", $temp['user_nama']." sedang berada di halaman dashboard.");
            $this->load->view('homepage/taskman_home_page',$data);
            //var_dump($data["pkj_karyawan"]);
    }
    
    public function recent_activity()
    {
        $data['activity'] = $this->taskman_repository->sp_recent_activity();
        
        $this->load->view('recent_activity_page',$data);
    }

    public function get_idModule() {
        return "admin";
    }

}
