<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    private function check_session_and_cookie() {
        //$usernamecookie = $this->input->cookie("cookie_user", TRUE);
        //$passwordcookie = $this->input->cookie("cookie_password", TRUE);
        $usernamecookie = get_cookie("cookie_user");
        $passwordcookie = get_cookie("cookie_password");
        $username = $this->session->userdata("user_nip");
        $password = $this->session->userdata("user_password");
        if (strlen($username) > 0 && strlen($password) > 0) {
            if ($this->authenticate($username, $password) == 1) {
                //echo "login by session";
                return 1;
            } else {
                if (strlen($usernamecookie) > 0 && strlen($passwordcookie) > 0) {
                    if ($this->authenticate($usernamecookie, $passwordcookie) == 1) {
                        //echo "login by cookie";
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
        }
    }

    private function authenticate($username, $password) {
        $result = $this->taskman_repository->sp_login_sistem($username, $password);
        if ($result["kode"] == 1) {
            $this->session->set_userdata(array('user_jabatan' => strtolower($result["nama_jabatan"])));
            return 1;
        }
        return 0;
    }

    public function index() {
        $this->load->view('user/tambah');
    }

    public function tambah() {
        $this->load->view('user/tambah');
    }

    public function list_karyawan() {
        $this->load->view('user/list_karyawan');
    }

    public function my_staff() {
        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan")=="manager") {
            $staff="";
            echo json_encode(array("status"=>"OK", "data"=>$staff));
        } else {
            echo json_encode(array("status"=>"FAILED", "reason"=>"mbuh"));
        }
    }

}

?>