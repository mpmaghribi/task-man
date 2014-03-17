<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    public function index() {
        $this->load->view('user/tambah');
    }
    public function tambah(){
        $this->load->view('user/tambah');
    }
    public function list_karyawan(){
        $this->load->view('user/list_karyawan');
    }
}
?>