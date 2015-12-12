<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH.'/libraries/ceklogin.php';
class profil extends ceklogin {

    public function __construct() {
        parent::__construct();
        $this->load->model('akun');
        $this->load->model('departemen');
        $this->load->model('jabatan_model');
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
//var_dump($result);
        if ($result["kode"] == 1) {
            $this->session->set_userdata(array('user_jabatan' => strtolower($result["nama_jabatan"])));
            return 1;
        }
        return 0;
    }

    public function index() {
//$this->load->view('profil/taskman_profil_page');
//        if ($this->check_session_and_cookie() == 1) {
        $temp = $this->session->userdata('logged_in');
        $data['data_akun']= $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'],0, "Aktivitas Profil", $temp['user_nama']." sedang melihat profil miliknya sendiri..");        
            
        $data['jabatan'] = $this->taskman_repository->sp_view_jabatan($temp['user_id']);
            $data['profil'] = $this->taskman_repository->sp_view_profil($temp['user_id']);
            $data['aktivitas'] = $this->taskman_repository->sp_aktivitas_staff($temp['user_id']);
            $data['pekerjaan'] = $this->taskman_repository->sp_log_pekerjaan($temp['user_id']);
            $this->load->view('profil/taskman_profil_page',$data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect('login');
//        }
    }

    public function setting() {
//        if ($this->check_session_and_cookie() == 1) {
            $kirim = array();
            $temp = $this->session->userdata('logged_in');
            $kirim['data_akun']= $this->session->userdata('logged_in');
            $kirim["akun"] = $this->akun->get_akun($temp['user_nip']);
            $kirim["jabatan"] = $this->jabatan_model->semua();
            $kirim["departemen"]=$this->departemen->semua();
            $this->load->view('profil/setting', $kirim);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect('login');
//        }
    }

    public function ubah_password() {
        $password_lama = pg_escape_string($this->input->post("password_lama"));
        $password_baru = pg_escape_string($this->input->post("password_baru"));
        $password_baru_2 = pg_escape_string($this->input->post("password_baru_2"));
        $nip = pg_escape_string($this->session->userdata("user_nip"));
        
        if (strlen($password_baru)>0&&$this->akun->ubah_password($nip, $password_lama, $password_baru, $password_baru_2) == 1) {
            $this->session->set_userdata(array("user_password"=>$password_baru));
            echo json_encode(array("status" => "OK"));
        }else{
            echo json_encode(array("status" => "FAILED"));
        }
    }

    public function ubah_profil() {
//        if ($this->check_session_and_cookie() == 1) {
            $update = array();
            $update["nama"] = pg_escape_string($this->input->post("nama"));
            $update["jenis_kelamin"] = pg_escape_string($this->input->post("jenis_kelamin"));
            $update["tempat_lahir"] = pg_escape_string($this->input->post("tempat_lahir"));
            $update["tgl_lahir"] = pg_escape_string($this->input->post("tanggal_lahir"));
            $update["alamat"] = pg_escape_string($this->input->post("alamat"));
            $update["agama"] = pg_escape_string($this->input->post("agama"));
            $update["telepon"] = pg_escape_string($this->input->post("telepon"));
            $update["hp"] = pg_escape_string($this->input->post("hp"));
            $update["email"] = pg_escape_string($this->input->post("email"));
            $update["id_departemen"] = pg_escape_string($this->input->post("departemen"));
            $update["id_jabatan"] = pg_escape_string($this->input->post("jabatan"));
            $jumlah = count($update);
            foreach ($update as $id => $val){
                if(strlen($val)==0){
                    unset($update[$id]);
                }
            }
            $nip = pg_escape_string($this->session->userdata("user_nip"));
            if ($this->akun->update($nip, $update) == 1) {
                echo json_encode(array("status" => "OK"));
            } else {
                echo json_encode(array("status" => "FAILED"));
            }
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect('login');
//        }
    }

}
