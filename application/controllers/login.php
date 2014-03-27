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

    public function authentication() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');


        $result = $this->taskman_repository->sp_login_sistem($username, md5($password));

        //echo "$username $password $rememberme";
        //$result = $this->taskman_repository->sp_login_sistem($username, $password);


        if ($result[0]->kode == 1) {
            echo "home";
            redirect('home');
        } else {
            $this->session->set_flashdata('status', -1);
            echo "login";
            redirect('login');
        }
    }

    public function logout() {
        $session_data = array(
            'user_nip' => "",
            'user_email' => "",
            'user_nama' => "",
            //'user_pwd' => "",
            'is_login' => FALSE,
            'admin' => FALSE
        );
        $this->session->sess_destroy();
        $this->session->unset_userdata($session_data);
        redirect('login');
    }

}
