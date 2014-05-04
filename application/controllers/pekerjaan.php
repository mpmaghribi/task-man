<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH.'/libraries/ceklogin.php';
class pekerjaan extends ceklogin {

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
//        if ($this->check_session_and_cookie() == 1) {
            redirect(base_url() . 'pekerjaan/karyawan');
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function karyawan() {
//        if ($this->check_session_and_cookie() == 1) {
        $temp = $this->session->userdata('logged_in');
            $result = $this->taskman_repository->sp_view_pekerjaan($temp['user_id']);
            $data['data_akun'] = $this->session->userdata('logged_in');
//            $result = $this->taskman_repository->sp_view_pekerjaan($this->session->userdata('user_id'));
            $data['pkj_karyawan'] = $result;
            $this->load->view('pekerjaan/karyawan/karyawan_page', $data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function usulan_pekerjaan2() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $sifat_pkj = $this->input->post('sifat_pkj');
            $parent_pkj = 0; //$this->input->post('parent_pkj');
            $nama_pkj = $this->input->post('nama_pkj');
            $deskripsi_pkj = $this->input->post('deskripsi_pkj');
            $tgl_mulai_pkj = $this->input->post('tgl_mulai_pkj');
            $tgl_selesai_pkj = $this->input->post('tgl_selesai_pkj');
            $prioritas = $this->input->post('prioritas');
            $status_pkj = '2'; //$this->input->post('status_pkj');
            $asal_pkj = 'task management'; //$this->input->post('asal_pkj');
            $list_staff = $this->input->post("staff");
            $staff = explode("::", $list_staff);
            //var_dump($staff);
            $this->load->model("akun");
            $this->load->model("pekerjaan_model");
            //var_dump($staff);
            $id_pekerjaan = $this->pekerjaan_model->usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj);
            if ($id_pekerjaan != NULL) {
                foreach ($staff as $index => $val) {//val itu nip
                    if (strlen($val) == 0) {
                        continue;
                    }
                    //echo "id akun akan dikenai pekerjaan $val ";
                    $id_akun = $this->akun->get_id_akun($val);
                    if ($id_akun == NULL) {
                        //echo "id akun tidak valid ";
                        continue;
                    }
                    //echo "akun valid ";
                    $this->pekerjaan_model->tambah_detil_pekerjaan($id_akun, $id_pekerjaan);
                    //echo "id akun $id_akun mendapat pekerjaan $id_pekerjaan <br/>";
                }
            }
            $path = './uploads/pekerjaan/' . $id_pekerjaan . '/';
            $this->load->library('upload');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            //echo "path = $path<br/>";
            if (isset($_FILES["berkas"])) {
                $files = $_FILES["berkas"];
                $this->upload_file($files, $path, $id_pekerjaan);
            }

            redirect('pekerjaan/karyawan');
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function upload_file($files, $path, $id_pekerjaan) {
        $this->load->model("berkas_model");
        $jumlah_file = count($files["name"]);
        for ($i = 0; $i < $jumlah_file; $i++) {
            if ($files["tmp_name"][$i] != "") {
                $filename = $files["name"][$i];
                $new_file_path = $path . $filename;
                $e = explode('.', $filename);
                $ext = '.' . end($e);
                $filename = str_replace($ext, '', $filename);
                $c = 1;
                while (file_exists($new_file_path)) {
                    $new_file_path = $path . $filename . $c . $ext;
                    $c++;
                }
                if (move_uploaded_file($files["tmp_name"][$i], $new_file_path)) {
                    $this->berkas_model->upload_file(
                            $this->session->userdata('user_id'), $new_file_path, $id_pekerjaan);
                }
            }
        }
    }

    public function usulan_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1) {
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
            $id_pekerjaan_baru = $result[0]->kode;
            if ($id_pekerjaan_baru >= 0) {
                $result = $this->taskman_repository->sp_tambah_detil_pekerjaan($id_pekerjaan_baru, $this->session->userdata("user_id"));
                if (isset($_FILES["berkas"])) {
                    $path = './uploads/pekerjaan/' . $id_pekerjaan_baru . '/';
                    $this->load->library('upload');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $files = $_FILES["berkas"];
                    $this->upload_file($files, $path, $id_pekerjaan_baru);
                }
            } else {
                
            }
            redirect('pekerjaan/karyawan');
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function list_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1) {
            //list pekerjaan, query semua pekerjaan per individu dari tabel detil pekerjaan
            $this->load->model("pekerjaan_model");
            $data["list_pekerjaan"] = $this->pekerjaan_model->list_pekerjaan();
            $this->load->view('pekerjaan/taskman_listpekerjaan_page', $data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function req_pending_task() {
//        if ($this->check_session_and_cookie() == 1) {
            $this->load->model("pekerjaan_model");
            $list_pekerjaan = $this->pekerjaan_model->list_pending_task($this->session->userdata("user_id"));
            echo json_encode(array("status" => "OK", "data" => $list_pekerjaan));
            //return true;
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "failed to authenticate"));
//            //return false;
//        }
    }

    public function deskripsi_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1) {
            //list pekerjaan, query semua pekerjaan per individu dari tabel detil pekerjaan
            $this->load->model("pekerjaan_model");
            $id_detail_pkj = $this->input->get('id_detail_pkj');
            if ($id_detail_pkj == NULL || strlen($id_detail_pkj) == 0) {
                redirect(base_url() . "pekerjaan/karyawan");
                exit(0);
            }

            /* mengupdate status pekerjaan dilihat dan tanggal read jika pekerjaan itu belum pernah
             * dibaca
             */
            $this->baca_pending_task($id_detail_pkj);
            $is_isi_komentar = $this->input->post('is_isi_komentar');
            $data["deskripsi_pekerjaan"] = $this->pekerjaan_model->sp_deskripsi_pekerjaan($id_detail_pkj);
            $data["listassign_pekerjaan"] = $this->pekerjaan_model->sp_listassign_pekerjaan($id_detail_pkj);
            $data["display"] = "none";
            if (isset($is_isi_komentar)) {
                if ($is_isi_komentar == TRUE) {
                    $isi_komentar = $this->input->post('komentar_pkj');
                    $id_akun = $this->session->userdata('user_id');
                    $data["tambah_komentar_pekerjaan"] = $this->pekerjaan_model->sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar);
                    $data["display"] = "block";
                    $r = $this->taskman_repository->sp_insert_activity($id_akun, 0, "Komentar", "baru saja memberikan komentar");
                }
            }
            $data["lihat_komentar_pekerjaan"] = $this->pekerjaan_model->sp_lihat_komentar_pekerjaan($id_detail_pkj);
            $data["id_pkj"] = $id_detail_pkj;
            $this->load->view('pekerjaan/karyawan/deskripsi_pekerjaan_page', $data);
            //redirect("pekerjaan/karyawan/deskripsi_pekerjaan_page?id_detail_pkj=".$id_detail_pkj);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function komentar_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1) {
            //list pekerjaan, query semua pekerjaan per individu dari tabel detil pekerjaan
            $this->load->model("pekerjaan_model");
            $id_detail_pkj = $this->input->post('id_detail_pkj');
            $isi_komentar = $this->input->post('komentar_pkj');
            $id_akun = $this->session->userdata('user_id');
            $data["tambah_komentar_pekerjaan"] = $this->pekerjaan_model->sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function lihat_usulan() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $this->load->model("pekerjaan_model");
            //$data["list_usulan"] = $this->pekerjaan_model->get_list_usulan_pekerjaan($this->session->userdata("user_departemen"));
            $this->load->view("pekerjaan/lihat_usulan_pekerjaan_page");
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function get_usulan_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $this->load->model("pekerjaan_model");
            $data = $this->pekerjaan_model->get_list_usulan_pekerjaan($this->session->userdata("user_departemen"));

            echo json_encode(array("status" => "OK", "data" => $data));
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "failed to authenticate"));
//        }
    }

    public function validasi_usulan() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $id_pekerjaan = $this->input->post("id_pekerjaan");
            $this->load->model("pekerjaan_model");
            if ($this->pekerjaan_model->validasi_pekerjaan($id_pekerjaan) == 1) {
                $result = $this->taskman_repository->sp_insert_activity($this->session->userdata('user_id'), 0, "Validasi Pekerjaan Staff", "Sudah melakukan validasi terhadap usulan pekerjaan dari staffnya");
                echo json_encode(array("status" => "OK"));
            } else
                echo json_encode(array("status" => "FAILED", "reason" => "failed to update"));
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "failed to authenticate"));
//        }
    }

    /*
     * fungsi untuk menampilkan halaman daftar pekerjaan yang dimiliki staff yang dibawahi,
     */

    public function pekerjaan_staff() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $this->load->view("pekerjaan/lihat_daftar_pekerjaan_staff_page");
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    /*
     * fungsi untuk data daftar pekerjaan yang dimiliki staff yang dibawahi,
     */

    public function data_pekerjaan_staff() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $this->load->model("pekerjaan_model");
            $data_pekerjaan_staff = $this->pekerjaan_model->list_pekerjaan_staff($this->session->userdata("user_departemen"));
            echo json_encode(array("status" => "OK", "data" => $data_pekerjaan_staff));
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "gagal"));
//        }
    }

    private function baca_pending_task($id_pekerjaan) {
//        if ($this->check_session_and_cookie() == 1) {
            $this->load->model("pekerjaan_model");
            $this->pekerjaan_model->baca_pending_task(pg_escape_string($id_pekerjaan), $this->session->userdata("user_id"));
            return true;
//        } else {
//            return false;
//        }
    }

    public function progress() {
//        if ($this->check_session_and_cookie() == 1) {
            $id_detail_pkj = $this->input->get('id_detail_pkj');
            $this->load->model("pekerjaan_model");
            $data["progress_pekerjaan"] = $this->pekerjaan_model->sp_progress_pekerjaan($id_detail_pkj);
            $this->load->view("pekerjaan/progress/progress_pekerjaan_page", $data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function get_status_usulan() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $this->load->model("pekerjaan_model");
            $id_pekerjaan = pg_escape_string($this->input->get("id_pekerjaan"));
            $status_usulan = $this->pekerjaan_model->get_status_usulan($id_pekerjaan);
            echo json_encode(array("status" => "OK", "data" => $status_usulan));
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "gagal"));
//        }
    }

    public function update_progress() {
//        if ($this->check_session_and_cookie() == 1) {
            $id_detail_pkj = $this->input->post('id_detail_pkj');
            $data = $this->input->post('data_baru');
            $this->load->model("pekerjaan_model");
            $result = $this->pekerjaan_model->sp_updateprogress_pekerjaan($data, $id_detail_pkj);

            if ($result == 1)
                $status = array('status' => 'OK');
            else
                $status = array('status' => 'NotOK');

            echo json_encode($status);
            //$this->load->view("pekerjaan/progress/progress_pekerjaan_page",$data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function edit() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
            $this->load->model("pekerjaan_model");
            $this->load->model("berkas_model");
            $id_pekerjaan = pg_escape_string($this->input->get('id_pekerjaan'));
            if ($id_pekerjaan == NULL || strlen($id_pekerjaan) == 0) {
                redirect(base_url() . "pekerjaan/karyawan");
                exit(0);
            }
            $data = array();
            $data["pekerjaan"]=$this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
            $data["detail_pekerjaan"]=$this->pekerjaan_model->get_detil_of_pekerjaan($id_pekerjaan);
            $data["berkas"]=$this->berkas_model->get_berkas_of_pekerjaan($id_pekerjaan);
            $this->load->view("pekerjaan/edit_pekerjaan_page",$data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function get_idModule() {
        
    }

}

?>