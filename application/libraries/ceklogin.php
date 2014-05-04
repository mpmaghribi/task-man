<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ceklogin extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in'))
        {
            
        }else
            redirect('http://localhost/integrarsud');   
    }
    
    public function index() {
        
    }
}

?>