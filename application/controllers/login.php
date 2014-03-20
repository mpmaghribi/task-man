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
    
    public function authentication()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $result = $this->taskman_repository->sp_login_sistem($username, $password);
        
        if ($result[0]->hasil == 1)
            redirect('home');
        else
        {
            $this->session->set_flashdata('status', -1);
            redirect('login');
        }
    }

}

