<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH.'/libraries/ceklogin.php';
class registration extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    public function index() {
        
        $this->load->view('user/taskman_registration_page');
    }
    
    public function register_staff()
    {
        $jabatan = $this->input->post('jabatan');
        foreach ($jabatan as $key => $value) {
             $jabatan = $value;
             
        }
        $gender = $this->input->post('gender');
        foreach ($gender as $key => $value) {
             $gender = $value;
             
        }
        $nama = $this->input->post('fullname');
        $email = $this->input->post('email');
        $agama = $this->input->post('religion');
        $homephone = $this->input->post('homephone');
        $mobilephone = $this->input->post('mobilephone');
        $address = $this->input->post('address');
        $departemen = $this->input->post('departemen');
        $nip = $this->input->post("usernip");
        $userpassword = $this->input->post('userpassword');
        if ($nama != NULL && $jabatan!= NULL && $email!= NULL && $agama!= NULL && $homephone != NULL && $mobilephone != NULL && $address!= NULL && $gender!= NULL && $nip!= NULL && $userpassword!= NULL && $departemen != NULL){
            $result = $this->taskman_repository->sp_register_sistem($nama,$jabatan,$email,$agama,$homephone,$mobilephone,$address,$gender,$nip,sha1($userpassword),$departemen);
            $kode = $result[0]->kode;
            $this->session->set_flashdata('status',$kode);
            if ($kode == 1)
            {
                redirect('registration');
            }else
            {
                redirect('login');
            }
            
        }
        else
        {
            $kode = 3;
            $this->session->set_flashdata('status',$kode);
            redirect('registration'); 
        }
        
        
    }
}

