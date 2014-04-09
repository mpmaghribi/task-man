<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pekerjaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    private function check_session_and_cookie() {
        //$usernamecookie = $this->input->cookie("cookie_user", TRUE);
        //$passwordcookie = $this->input->cookie("cookie_password", TRUE);
        $usernamecookie = get_cookie("cookie_user");
        $passwordcookie = get_cookie("cookie_password");
        $username = $this->session->userdata("user_nip");
        $password = $this->session->userdata("user_password");
        if (strlen($username) > 0 && strlen($password) > 0) {
            if ($this->authenticate($username, $password) == 1) {
                //echo "login by session";
                return 1;
            } else {
                if (strlen($usernamecookie) > 0 && strlen($passwordcookie) > 0) {
                    if ($this->authenticate($usernamecookie, $passwordcookie) == 1) {
                        //echo "login by cookie";
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
        }
    }

    private function authenticate($username, $password) {
        $result = $this->taskman_repository->sp_login_sistem($username, $password);
        if ($result["kode"] == 1) {
            $this->session->set_userdata(array('user_jabatan' => strtolower($result["nama_jabatan"])));
            return 1;
        }
        return 0;
    }

    public function index() {
        if ($this->check_session_and_cookie() == 1) {
            $this->load->view('pekerjaan/tambah_pekerjaan');
        } else {
            $this->session->set_flashdata('status', 4);
            redirect("login");
        }
    }

    public function karyawan() {
        if ($this->check_session_and_cookie() == 1) {
            $result = $this->taskman_repository->sp_view_pekerjaan();
            $data['pkj_karyawan'] = $result;
            $this->load->view('pekerjaan/karyawan/karyawan_page', $data);
        } else {
            $this->session->set_flashdata('status', 4);
            redirect("login");
        }
    }

    public function usulan_pekerjaan2() {
        if ($this->check_session_and_cookie() == 1) {
            $sifat_pkj = $this->input->post('sifat_pkj');
            $parent_pkj = 0; //$this->input->post('parent_pkj');
            $nama_pkj = $this->input->post('nama_pkj');
            $deskripsi_pkj = $this->input->post('deskripsi_pkj');
            $tgl_mulai_pkj = $this->input->post('tgl_mulai_pkj');
            $tgl_selesai_pkj = $this->input->post('tgl_selesai_pkj');
            $prioritas = $this->input->post('prioritas');
            $status_pkj = '2'; //$this->input->post('status_pkj');
            $asal_pkj = 'task management'; //$this->input->post('asal_pkj');
            $this->load->model("pekerjaan_model");
            $result = $this->pekerjaan_model->usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj);

            //redirect('pekerjaan/karyawan');
        } else {
            $this->session->set_flashdata('status', 4);
            redirect("login");
        }
    }

    public function usulan_pekerjaan() {
        if ($this->check_session_and_cookie() == 1) {
            $sifat_pkj = $this->input->post('sifat_pkj');
            $parent_pkj = 0; //$this->input->post('parent_pkj');
            $nama_pkj = $this->input->post('nama_pkj');
            $deskripsi_pkj = $this->input->post('deskripsi_pkj');
            $tgl_mulai_pkj = $this->input->post('tgl_mulai_pkj');
            $tgl_selesai_pkj = $this->input->post('tgl_selesai_pkj');
            $prioritas = $this->input->post('prioritas');
            $status_pkj = '1'; //$this->input->post('status_pkj');
            $asal_pkj = 'task management'; //$this->input->post('asal_pkj');
            $result = $this->taskman_repository->sp_tambah_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj);
            //var_dump($result);
            //echo $result[0]->kode;
            $id_pekerjaan_baru = $result[0]->kode;
            if ($id_pekerjaan_baru >= 0) {
                $result = $this->taskman_repository->sp_tambah_detil_pekerjaan($id_pekerjaan_baru, $this->session->userdata("user_id"));
            }else{
                
            }
            redirect('pekerjaan/karyawan');
        } else {
            $this->session->set_flashdata('status', 4);
            redirect("login");
        }
    }

    public function assign_pekerjaan() {
        
    }

    public function list_pekerjaan() {
        if ($this->check_session_and_cookie() == 1) {
            //list pekerjaan, query semua pekerjaan per individu dari tabel detil pekerjaan
            $this->load->model("pekerjaan_model");
            $data["list_pekerjaan"] = $this->pekerjaan_model->list_pekerjaan();
            $this->load->view('pekerjaan/taskman_listpekerjaan_page', $data);
        } else {
            $this->session->set_flashdata('status', 4);
            redirect("login");
        }
    }

}

?>