<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class pekerjaan extends ceklogin {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'pekerjaan/karyawan');
    }

    public function karyawan() {
        $this->load->model("pekerjaan_model");
        $this->load->model("akun");
        $temp = $this->session->userdata('logged_in');
        $data['temp'] = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_view_pekerjaan($temp['user_id']);
        $data['data_akun'] = $this->session->userdata('logged_in');
//            $result = $this->taskman_repository->sp_view_pekerjaan($this->session->userdata('user_id'));
        $data['pkj_karyawan'] = $result;
        //var_dump($result);
        $list_id_pekerjaan = array();
        foreach ($result as $pekerjaan) {
            $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
        }
        //var_dump($list_id_pekerjaan);
        $staff = $this->akun->my_staff($temp["user_id"]);
        $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
        //var_dump($detil_pekerjaan);
        //var_dump($staff);
        //echo "temp";
        //var_dump($temp);
        $data["detil_pekerjaan"] = json_encode($detil_pekerjaan);
        $data["my_staff"] = json_encode($staff);
        $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang berada di halaman pekerjaan.");
        //var_dump($data["pkj_karyawan"]);
        $this->load->view('pekerjaan/karyawan/karyawan_page', $data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function do_edit() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array("pekerjaan_model"));
        $update["id_sifat_pekerjaan"] = pg_escape_string($this->input->post("sifat_pkj"));
        $update["nama_pekerjaan"] = pg_escape_string($this->input->post("nama_pkj"));
        $update["deskripsi_pekerjaan"] = pg_escape_string($this->input->post("deskripsi_pkj"));
        $update["tgl_mulai"] = pg_escape_string($this->input->post("tgl_mulai_pkj"));
        $update["tgl_selesai"] = pg_escape_string($this->input->post("tgl_selesai_pkj"));
        $update["level_prioritas"] = pg_escape_string($this->input->post("prioritas"));
        $update["asal_pekerjaan"] = 'task management';
        $id_pekerjaan = pg_escape_string($this->input->post('id_pekerjaan'));
        if ($this->pekerjaan_model->update_pekerjaan($update, $id_pekerjaan)) {
            $list_staff = $this->input->post("staff");
            $assigned_staff = $this->pekerjaan_model->get_detil_pekerjaan(array($id_pekerjaan));
            //var_dump($assigned_staff);
            foreach ($assigned_staff as $assigned) {
                echo "mencari " . '::' . $assigned->id_akun . '::' . " dalam $list_staff";
                if (strpos($list_staff, '::' . $assigned->id_akun . '::') === false) {
                    $this->pekerjaan_model->batalkan_penugasan_staff($assigned->id_akun, $id_pekerjaan);
                    echo "batalkan $assigned->id_akun<br>";
                } else {
                    $list_staff = str_replace("::$assigned->id_akun::", "::", $list_staff);
                    echo "sudah ada $assigned->id_akun<br>";
                }
            }
            $staff = explode("::", $list_staff);
            foreach ($staff as $index => $val) {//val itu nip
                if (strlen($val) == 0) {
                    continue;
                }
                $this->pekerjaan_model->tambah_detil_pekerjaan($val, $id_pekerjaan);
                echo "menambahkan $val <br/>";
            }
        } else {
            echo "gagal update";
        }
        redirect(base_url() . "pekerjaan/deskripsi_pekerjaan?id_detail_pkj=" . $id_pekerjaan);
    }

    public function usulan_pekerjaan2() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
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
        //var_dump($staff);;
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
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja memberikan pekerjaan kepada staffnya.");
        }
        redirect('pekerjaan/karyawan');
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function upload_file($files, $path, $id_pekerjaan) {
        $temp = $this->session->userdata('logged_in');
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
                            $temp['user_id'], $new_file_path, $id_pekerjaan);
                }
            }
        }
    }

    public function usulan_pekerjaan() {
        $data['data_akun'] = $this->session->userdata("logged_in");
        $temp = $this->session->userdata('logged_in');
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
            $result = $this->taskman_repository->sp_tambah_detil_pekerjaan($id_pekerjaan_baru, $temp['user_id']);
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
        $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja mengusulkan pekerjaan.");

        redirect('pekerjaan/karyawan');
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function list_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1) {
        //list pekerjaan, query semua pekerjaan per individu dari tabel detil pekerjaan
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        $this->load->model("pekerjaan_model");
        $data["list_pekerjaan"] = $this->pekerjaan_model->list_pekerjaan();
        $this->load->view('pekerjaan/taskman_listpekerjaan_page', $data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function req_pending_task() {
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        $this->load->model("pekerjaan_model");
        $list_pekerjaan = $this->pekerjaan_model->list_pending_task($temp['user_id']);
        echo json_encode(array("status" => "OK", "data" => $list_pekerjaan));
    }

    public function deskripsi_pekerjaan() {
        $data['data_akun'] = $this->session->userdata('logged_in');
        $data['temp'] = $this->session->userdata('logged_in');
        $temp = $this->session->userdata('logged_in');
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
        $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat detail tentang pekerjaannya.");

        if (isset($is_isi_komentar)) {
            if ($is_isi_komentar == TRUE) {
                $isi_komentar = $this->input->post('komentar_pkj');
                $id_akun = $temp['user_id'];
                $data["tambah_komentar_pekerjaan"] = $this->pekerjaan_model->sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar);
                $data["display"] = "block";
                $r = $this->taskman_repository->sp_insert_activity($id_akun, 0, "Aktivitas Komentar", $temp['user_nama'] . " baru saja memberikan komentar : " . $isi_komentar . "");
            }
        }
        $data["lihat_komentar_pekerjaan"] = $this->pekerjaan_model->sp_lihat_komentar_pekerjaan($id_detail_pkj);
        $data["id_pkj"] = $id_detail_pkj;
        $this->load->model("akun");
        $data['my_staff'] = $this->akun->my_staff($temp["user_id"]);
        $data['my_staff'] = json_encode($data['my_staff']);
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
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        $this->load->model("pekerjaan_model");
        $id_detail_pkj = $this->input->post('id_detail_pkj');
        $isi_komentar = $this->input->post('komentar_pkj');
        $id_akun = $temp['user_id'];
        $data["tambah_komentar_pekerjaan"] = $this->pekerjaan_model->sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function lihat_usulan() {
        $this->load->model(array("pekerjaan_model", "akun"));
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        $staff = $this->akun->my_staff($temp["user_id"]);
        $data["my_staff"] = json_encode($staff);
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat daftar usulan pekerjaan yang ada.");
        $this->load->view("pekerjaan/lihat_usulan_pekerjaan_page", $data);
    }

    public function get_usulan_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
        $this->load->model(array("pekerjaan_model"));
        //var_dump($this->session->userdata('logged_in'));
        $temp = $this->session->userdata('logged_in');
        //$staff = $this->akun->my_staff($temp["user_id"]);
        $staff = $this->input->post("list_id_staff");
        //var_dump($staff);
        $list_id_staff = array();
        foreach ($staff as $my_staff) {
            $list_id_staff[] = $my_staff;
        }
        $data = $this->pekerjaan_model->get_list_usulan_pekerjaan($list_id_staff);
        echo json_encode(array("status" => "OK", "data" => $data));
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "failed to authenticate"));
//        }
    }

    public function validasi_usulan() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
        $temp = $this->session->userdata('logged_in');
        $id_pekerjaan = $this->input->post("id_pekerjaan");
        $this->load->model("pekerjaan_model");
        if ($this->pekerjaan_model->validasi_pekerjaan($id_pekerjaan) == 1) {
            $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya");
            echo json_encode(array("status" => "OK"));
        } else {
            echo json_encode(array("status" => "FAILED", "reason" => "failed to update"));
        }
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "failed to authenticate"));
//        }
    }

    /*
     * fungsi untuk menampilkan halaman daftar pekerjaan yang dimiliki staff yang dibawahi,
     */

    public function pekerjaan_staff() {
        $temp = $this->session->userdata('logged_in');
        $data["data_akun"] = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat progress pekerjaan dari para staffnya.");
        $this->load->model("akun");
        $data["my_staff"] = $this->akun->my_staff($temp["user_id"]);
        $this->load->view("pekerjaan/lihat_daftar_pekerjaan_staff_page", $data);
    }

    public function pekerjaan_per_staff() {
        $this->load->model(array("pekerjaan_model", "akun"));
        $session = $this->session->userdata('logged_in');
        $data["data_akun"] = $session;
        $id_staff = $this->input->get("id_akun");
        $data["pekerjaan_staff"] = $this->pekerjaan_model->list_pekerjaan($id_staff);
        $data["my_staff"] = $this->akun->my_staff($session["user_id"]);
        $data["id_staff"] = $id_staff;
        $data["nama_staff"] = "";
        foreach ($data["my_staff"] as $st) {
            if ($st->id_akun == $id_staff) {
                $data["nama_staff"] = $st->nama;
                break;
            }
        }
        $list_id_pekerjaan = array();
        foreach ($data["pekerjaan_staff"] as $pekerjaan) {
            $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
        }
        $data["detil_pekerjaan"] = json_encode($this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan));
        $data["my_staff"] = json_encode($data["my_staff"]);
        $this->load->view('pekerjaan/pekerjaan_per_staff_page', $data);
    }

    /*
     * fungsi untuk data daftar pekerjaan yang dimiliki staff yang dibawahi,
     */

    public function data_pekerjaan_staff() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
        $temp = $this->session->userdata('logged_in');
        //var_dump($temp);
        $this->load->model("pekerjaan_model");
        /* query list pekerjaan staff berdasarkan feedback list staff dari integra, */
        //"http://localhost:90/integrarsud/index.php/api/integration/bawahan/id/".$temp["user_id"]."/format/json";
        $data_pekerjaan_staff = $this->pekerjaan_model->list_pekerjaan_staff();
        echo json_encode(array("status" => "OK", "data" => $data_pekerjaan_staff));
//        } else {
//            echo json_encode(array("status" => "FAILED", "reason" => "gagal"));
//        }
    }

    private function baca_pending_task($id_pekerjaan) {
//        if ($this->check_session_and_cookie() == 1) {
        $temp = $this->session->userdata('logged_in');
        $this->load->model("pekerjaan_model");
        $this->pekerjaan_model->baca_pending_task(pg_escape_string($id_pekerjaan), $temp["user_id"]);
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
        $temp = $this->session->userdata('logged_in');
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
        $temp = $this->session->userdata('logged_in');
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
        $temp = $this->session->userdata('logged_in');

        $this->load->model("pekerjaan_model");
        $this->load->model("berkas_model");
        $id_pekerjaan = pg_escape_string($this->input->get('id_pekerjaan'));
        if ($id_pekerjaan == NULL || strlen($id_pekerjaan) == 0) {
            redirect(base_url() . "pekerjaan/karyawan");
            exit(0);
        }
        $data = array();
        $data["pekerjaan"] = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        $data["detail_pekerjaan"] = $this->pekerjaan_model->get_detil_pekerjaan(array($id_pekerjaan));
        $data["berkas"] = $this->berkas_model->get_berkas_of_pekerjaan($id_pekerjaan);
        $data["data_akun"] = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja melakukan perubahan pada detail pekerjaan.");

        $this->load->view("pekerjaan/edit_pekerjaan_page", $data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function get_idModule() {
        
    }

    public function get_detil_pekerjaan() {
        $list_pekerjaan = $this->input->post("list_id_pekerjaan");
        //echo json_decode($list_pekerjaan);
        //var_dump($list_pekerjaan);
        $this->load->model("pekerjaan_model");
        $hasil = $this->pekerjaan_model->get_detil_pekerjaan($list_pekerjaan);
        echo json_encode(array("status" => "OK", "data" => $hasil));
    }

}

?>