<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class testing extends CI_Controller {

    public function index() {
        echo base_url();
        echo "<br>";
        echo str_replace('://', '://hello:world@', base_url()) . "index.php/api/integration/bawahan/id/1/format/json";
        echo '<br><br>';
        $this->load->database();
        $this->kuery("show datestyle");
        $this->kuery("show config_file");
    }

    public function kuery($param) {
        $query = $this->db->query($param);
        foreach ($query->result() as $row) {
            var_dump($row);
        }
    }

    public function session() {
        $session = $this->session->all_userdata();
        var_dump($session);
        print_r($session);
    }

    public function upload_view() {
        echo strcmp('3','2');
        $this->load->view('testing/upload');
    }
    
    public function do_upload(){
        $teks=$this->input->post('teks');
        var_dump($teks);
        
    }
    
    public function atasan() {
        $session = $this->session->userdata('logged_in');
        $atasan_url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $session['user_id'] . "/format/json";
        print_r($atasan_url);
        print_r(file_get_contents($atasan_url));
    }

}
