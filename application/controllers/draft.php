<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class draft extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->model("pengaduan_model");
    }

    public function index() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $my_staff = $this->akun->my_staff($session['user_id']);
        $staff_ = array();
        foreach ($my_staff as $s) {
            $staff_[] = $s->id_akun;
        }
        $list_draft = $this->pekerjaan_model->get_list_draft($session['user_id']);
        //$draft_create_submit=base_url().'pekerjaan/usulan_pekerjaan2';
        $this->load->view('pekerjaan/draft/draft_body', array('draft_create_submit' => base_url() . 'pekerjaan/usulan_pekerjaan2', 'data_akun' => $session, 'list_draft' => $list_draft));
    }

    public function edit() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $data['id_draft'] = pg_escape_string($this->input->get('id_draft'));
        $data['data_akun']=$session;
        if (strlen($data['id_draft']) == 0) {
            $data['judul_kesalahan'] = 'id_draft tidak valid';
            $data['deskripsi_kesalahan'] = 'id_draft tidak valid';
            $this->load->view('pekerjaan/kesalahan', $data);
        } else {
            $data['draft_edit_submit']=base_url().'draft/do_edit';
            $data['draft'] = $this->pekerjaan_model->get_draft(array($data['id_draft']));
            $this->load->view('pekerjaan/draft/draft_edit_body',$data);
            //print_r($data['draft']);
        }
    }
    public function do_edit(){
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $data['id_draft'] = pg_escape_string($this->input->get('id_draft'));
        $data['data_akun']=$session;
    }

}
