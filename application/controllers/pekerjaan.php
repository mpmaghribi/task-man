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
    
    public function karyawan() {
        $result = $this->taskman_repository->sp_view_pekerjaan();
        $data['pkj_karyawan'] = $result;
        $this->load->view('pekerjaan/karyawan/karyawan_page', $data);
    }

    public function usulan_pekerjaan() {
        $sifat_pkj = $this->input->post('sifat_pkj');
        $parent_pkj= 0;//$this->input->post('parent_pkj');
        $nama_pkj= $this->input->post('nama_pkj');
        $deskripsi_pkj= $this->input->post('deskripsi_pkj');
        $tgl_mulai_pkj= $this->input->post('tgl_mulai_pkj');
        $tgl_selesai_pkj= $this->input->post('tgl_selesai_pkj');
        $prioritas= $this->input->post('prioritas');
        $status_pkj= 'Not Approved';//$this->input->post('status_pkj');
        $asal_pkj= 'task management';//$this->input->post('asal_pkj');
        $result = $this->taskman_repository->sp_tambah_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj);
        
        redirect('pekerjaan/karyawan');
    }

    public function assign_pekerjaan() {
        
    }

    public function list_pekerjaan() {
        $this->load->view('pekerjaan/taskman_listpekerjaan_page');
    }

}

?>