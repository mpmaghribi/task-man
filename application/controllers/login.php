<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    public function index() {
//        $query = "lala";
//        $query = $this->db->query('SELECT id, nama, asal FROM mahasiswa');

        $this->load->view('login/taskman_login_page');
    }

}

