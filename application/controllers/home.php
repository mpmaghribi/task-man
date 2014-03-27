<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends CI_Controller {

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
        //var_dump($result);
        if ($result["kode"] == 1) {
            return 1;
        }
        return 0;
    }

    public function index() {
        /* if ($this->session->userdata('is_login') == true) {
          $this->load->view('homepage/taskman_home_page');
          } else {
          $this->session->set_flashdata('status', 4);
          redirect('login');
          } */
        if ($this->check_session_and_cookie() == 1) {
            $this->load->view('homepage/taskman_home_page');
        } else {
            $this->session->set_flashdata('status', 4);
            redirect('login');
        }
    }

}
