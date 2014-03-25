<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //$this->load->database();
    }

    public function index() {
//        $query = "lala";
//        $query = $this->db->query('SELECT id, nama, asal FROM mahasiswa');

        $this->load->view('login/taskman_login_page');
    }

    public function authentication() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $result = $this->taskman_repository->sp_login_sistem($username, md5($password));

        if ($result[0]->kode == 1) {
            $session_data = array(
                'user_nip' => $result[0]->nip,
                'user_email' => $result[0]->email,
                'user_nama' => $result[0]->nama,
                'is_login' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('home');
        } else {
            $this->session->set_flashdata('status', -1);
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
