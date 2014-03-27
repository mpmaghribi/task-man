<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class registration extends CI_Controller {

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
    
    public function forgot_password()
    {
        //$this->email->clear();
        $email_user = $this->input->post('email_user');
        
        $this->email->from('you@example.com', 'Administrator');
        $this->email->to($email_user);
        $this->email->subject('Password Reset');
        $this->email->message('<h1>ini mesage pertamaku</h1>');
        
        $this->email->send();
        
        if (!$this->email->send())
        {
            echo "Error";
        }
        show_error($this->email->print_debugger());
    }
}

