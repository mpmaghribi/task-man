<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pekerjaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('pekerjaan/tambah_pekerjaan');
    }

    public function tambah_pekerjaan() {
        $this->load->view('pekerjaan/tambah_pekerjaan');
    }
    
    public function list_pekerjaan() {
        $this->load->view('pekerjaan/taskman_listpekerjaan_page');
    }

}
?>