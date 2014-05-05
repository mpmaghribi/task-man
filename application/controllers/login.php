<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->helper('cookie');
        //$this->load->database();
    }

    public function index() {
        if ($this->check_session_and_cookie() == 1) {
            redirect('home');
            //echo "redirect";
            exit();
        }
        $this->load->view('login/taskman_login_page');
    }
    
    public function tesdb() {
        echo 'tes';
    }

    private function check_session_and_cookie() {
        //$usernamecookie = $this->input->cookie("cookie_user", TRUE);
        //$passwordcookie = $this->input->cookie("cookie_password", TRUE);
        //$usernamecookie = get_cookie("cookie_user");
        //$passwordcookie = get_cookie("cookie_password");
        $username = $this->session->userdata("user_nip");
        $password = $this->session->userdata("user_password");
        if (strlen($username) > 0 && strlen($password) > 0) {
            if ($this->authenticate($username, $password) == 1) {
                //echo "login by session";
                return 1;
            } else {
                //if (strlen($usernamecookie) > 0 && strlen($passwordcookie) > 0) {
                //if ($this->authenticate($usernamecookie, $passwordcookie) == 1) {
                //echo "login by cookie";
                //return 1;
                //}
                //}
            }
        }
        return 0;
    }

    private function authenticate($username, $password) {
        $rememberme = $this->input->post("rememberme");
        $result = $this->taskman_repository->sp_login_sistem($username, $password);
        //var_dump($result);
        if ($result["kode"] == 1) {
            $session_data = array(
                'user_nip' => $result["nip"],
                'user_email' => $result["email"],
                'user_nama' => $result["nama"],
                'is_login' => TRUE,
                'user_password' => $password,
                'user_jabatan' => strtolower($result["nama_jabatan"]),
                "user_id"=> $result["id_akun"],
                "user_departemen"=>$result["id_departemen"]
            );
            $this->session->set_userdata($session_data);
            if ($rememberme == "remember-me") {
                $cookie = array(
                    'name' => 'cookie_user',
                    'value' => $username,
                    'expire' => 86500,
                    'domain' => site_url(),
                    'path' => '/',
                    'secure' => TRUE
                );
                set_cookie($cookie);
                $cookie = array(
                    'name' => 'cookie_password',
                    'value' => $password,
                    'expire' => 86500,
                    'domain' => site_url(),
                    'path' => '/',
                    'secure' => TRUE
                );
                set_cookie($cookie);
            }
            return 1;
        }
        $session_data = array(
            'user_nip' => "",
            'user_email' => "",
            'user_nama' => "",
            //'user_pwd' => "",
            'is_login' => FALSE,
            'admin' => FALSE
        );
        delete_cookie("cookie_user");
        delete_cookie("cookie_password");
        $this->session->sess_destroy();
        $this->session->unset_userdata($session_data);
        return 0;
    }

    public function authentication() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        //echo "$username $password $rememberme";
        //$result = $this->taskman_repository->sp_login_sistem($username, $password);

        if ($this->authenticate($username, $password) == 1) {
            //echo "home";
            $result = $this->taskman_repository->sp_insert_activity($this->session->userdata('user_id'),0, "Login", "baru saja login");
            redirect('home');
        } else {
            $this->session->set_flashdata('status', -1);
            //echo "login";
            redirect('login');
        }
    }

    public function logout() {
        $session_data = array(
//            'user_nip' => "",
//            'user_email' => "",
//            'user_nama' => "",
//            //'user_pwd' => "",
//            'is_login' => FALSE,
//            'admin' => FALSE
            
            'id_akun' => "",
            'nip' => "",
            'user_id' => "",
            'user_nip' => "",
            'nama' => "",
            'user_nama' => "",
            'user_email' => "",
            'is_login' => FALSE,
            'user_jabatan' => "",
            'user_departemen'=>"",
        );
        $temp = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'],0, "Logout", "baru saja logout");
//        delete_cookie("cookie_user");
//        delete_cookie("cookie_password");
        
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect(str_replace('taskmanagement','',  base_url()).'integrarsud');
    }

}
