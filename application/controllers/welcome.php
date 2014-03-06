<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        $query = "lala";
        $query = $this->db->query('SELECT id, nama, asal FROM mahasiswa');

        $this->load->view('welcome_message', array("data" => $query));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */