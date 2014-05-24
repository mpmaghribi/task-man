<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class testing extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
           echo base_url();
           echo "<br>";
           echo str_replace('://', '://hello:world@', base_url())."index.php/api/integration/bawahan/id/1/format/json";
           echo '<br><br>';
           $this->load->database();
           $this->kuery("show datestyle");
           $this->kuery("show config_file");
	}
        public function kuery($param) {
            $query = $this->db->query($param);
           foreach ($query->result() as $row){
               var_dump($row);
           }
        }
        public function session(){
            $session = $this->session->userdata('logged_in');
            var_dump($session);
            print_r($session);
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */