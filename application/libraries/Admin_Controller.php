<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define("PERMITTED", 1);
define("NPERMITTED", 0);
define("NLOGIN", -1);
define("BYPASS", 100);
require APPPATH.'/libraries/iView.php';

abstract class Admin_Controller extends CI_Controller implements iView
{
    
    protected $_activeTheme;
    protected $_activeUser;
    protected $_idUserActive;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        if ($this->_getPermit()== NLOGIN) 
        {
            redirect('http://localhost/integrarsud');
        }
        else if ($this->_getPermit()==NPERMITTED)
        {
            $message_403 = "Maaf, Anda tidak memiliki akses ke bagian ini.";
            show_error($message_403 , 403 ); 
            
        }
    }
    
    abstract function get_idModule();
    
    protected function _getPermit()
    {
        if  ($this->get_idModule()=="admin") return BYPASS;
        if (!$this->_getSession()) return NLOGIN;//belum login
        $this->load->model(array('module_m'));
        //$num_row= $this->module_m->getPermission($this->_idUserActive, $this->get_idModule());
        //if ($num_row>0 || $this->get_idModule()==0) return PERMITTED; //permitted 
        //return NPERMITTED;//belum ada akses
        return NPERMITTED;
        
    }

    /*
    * @package		IntegraRSUD
    * @author		Felix - Artcak Media Digital
    * @copyright	Copyright (c) 2014
    * @link		http://artcak.com
    * @since		Version 1.0
     */
    public function _getSession()
    {
        if($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $this->_activeUser = $session_data['nama'];
            $this->_idUserActive=$session_data['id_akun'];
            return true;
        }
        else
        {
            return false;
        }
    }
    /*
    * @package		IntegraRSUD
    * @author		Felix - Artcak Media Digital
    * @copyright	Copyright (c) 2014
    * @link		http://artcak.com
    * @since		Version 1.0
     */
    public function _getTheme()
    {
        //jika tidak ada theme aktif maka menggunakan theme default
        if(!$this->config->item('active_theme'))
                   $this->_activeTheme=$this->config->item('default_theme');
               else
                   $this->_activeTheme=$this->config->item('active_theme');   
    }
}
?>
