<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class pekerjaan extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->model("pengaduan_model");
    }

    public function index() {
        redirect(base_url() . 'pekerjaan/karyawan');
    }

    function pengaduan() {
        //http://localhost:90/integrarsud/helpdesk/index.php/pengaduan/getDelegate/
        //print_r($url);
        $url = str_replace('taskmanagement', 'integrarsud/helpdesk', str_replace('://', '://hello:world@', base_url())) . "index.php/pengaduan/getDelegate";
        $data["pengaduan"] = json_decode(file_get_contents($url));
        $url2 = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["pegawai"] = json_decode(file_get_contents($url2));
        $url3 = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/departemens/format/json";
        $data["departemen"] = json_decode(file_get_contents($url3));
        $temp = $this->session->userdata('logged_in');
        $data['temp'] = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        //print_r($url);
        $this->load->view("pekerjaan/pengaduan_page", $data);
    }

    function get_pengaduan() {
        //http://localhost:90/integrarsud/helpdesk/index.php/pengaduan/getDelegate/
        //print_r($url);
        $id = $this->input->post("id_pengaduan");

        $url = str_replace('taskmanagement', 'integrarsud/helpdesk', site_url()) . "/pengaduan/getIdDelegate/" . pg_escape_string($id);
        $data["pengaduan"] = json_decode(file_get_contents($url));

        $temp = $this->session->userdata('logged_in');
        $data['temp'] = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        //print_r($url);
        echo json_encode(array("status" => "OK", "data" => $data["pengaduan"]));
    }

    function tambah_pengaduan() {
        $topik = $this->input->post("topik_pengaduan");
        $isi = $this->input->post("isi_pengaduan");
        $tgl = $this->input->post("tgl_pengaduan");
        $tgl2 = $this->input->post("tgl_pengaduan2");
        $urgensitas = $this->input->post("urgensitas");
        $staff = $this->input->post("staff_rsud");
        foreach ($staff as $value) {
            echo ($value);
        }
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        $sifat_pkj = 2;
        $parent_pkj = 0; //$this->input->post('parent_pkj');
        $nama_pkj = $this->input->post('topik_pengaduan');
        $deskripsi_pkj = $this->input->post('isi_pengaduan');
        $tgl_mulai_pkj = $this->input->post('tgl_mulai_pengaduan');
        $tgl_selesai_pkj = $this->input->post('tgl_selesai_pengaduan');
        $prioritas = $this->input->post('urgensitas');
        $status_pkj = '2'; //$this->input->post('status_pkj');
        $asal_pkj = 'Help Desk'; //$this->input->post('asal_pkj');
        //$list_staff = $this->input->post("staff_rsud");
        //$staff = explode("::", $list_staff);
        //var_dump($staff);;
        $this->load->model("akun");
        $this->load->model("pekerjaan_model");
        $this->load->model("pengaduan_model");
        //var_dump($staff);
        $respon = $this->input->post("respon_pengaduan");
        $alasan = "0";
        $pengaduan = $this->pengaduan_model->sp_tambah_pengaduan($nama_pkj, $deskripsi_pkj, $tgl, $prioritas, $respon, $alasan);
        $data_pengaduan = $this->pengaduan_model->sp_get_idpengaduan();
        foreach ($data_pengaduan as $value) {
            $id_pengaduan = $value->id_pengaduan;
        }
        $id_pekerjaan = $this->pekerjaan_model->usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj, $id_pengaduan, "insidentil");
        $this->pekerjaan_model->isi_pemberi_pekerjaan($temp['user_id'], $id_pekerjaan);
        if ($id_pekerjaan != NULL) {
            foreach ($staff as $val) {//val itu nip
//                if (strlen($val) == 0) {
//                    continue;
//                }
//                //echo "id akun akan dikenai pekerjaan $val ";
//                //$id_akun = $this->akun->get_id_akun($val);
//                if ($id_akun == NULL) {
//                    //echo "id akun tidak valid ";
//                    continue;
//                }
                //echo "akun valid ";
                $this->pekerjaan_model->tambah_detil_pekerjaan($val, $id_pekerjaan);
                //echo "id akun $id_akun mendapat pekerjaan $id_pekerjaan <br/>";
            }


            //echo "path = $path<br/>";
            if (isset($_FILES["berkas"])) {
                $path = './uploads/pekerjaan/' . $id_pekerjaan . '/';
                //$this->load->library('upload');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $files = $_FILES["berkas"];
                $this->upload_file($files, $path, $id_pekerjaan);
            }
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja memberikan pekerjaan kepada staffnya.");
        }
        $this->session->set_flashdata("notif_sukses", "sukses");
        redirect('pekerjaan/pengaduan');
    }

    public function karyawan() {
        $this->session->set_userdata('prev', 'karyawan');
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
        $update["kategori"] = pg_escape_string($this->input->post("kategori"));
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
            if (isset($_FILES["berkas"])) {
                $path = './uploads/pekerjaan/' . $id_pekerjaan . '/';
                //$this->load->library('upload');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $files = $_FILES["berkas"];
                $this->upload_file($files, $path, $id_pekerjaan);
            }
        } else {
            echo "gagal update";
        }
        redirect(base_url() . "pekerjaan/deskripsi_pekerjaan?id_detail_pkj=" . $id_pekerjaan);
    }

    public function usulan_pekerjaan2() {
//        if ($this->check_session_and_cookie() == 1 && $this->session->userdata("user_jabatan") == "manager") {
        $temp = $this->session->userdata('logged_in');
//        $data['data_akun'] = $this->session->userdata('logged_in');
//        $pekerjaan['id_sifat_pekerjaan'] = pg_escape_string($this->input->post('sifat_pkj'));
//        $pekerjaan['parent_pekerjaan'] = 0;
//        $pekerjaan['nama_pekerjaan'] = pg_escape_string($this->input->post('sifat_pkj'));
//        $pekerjaan['deskripsi_pekerjaan'] = pg_escape_string($this->input->post('deskripsi_pkj'));
//        $pekerjaan['tgl_mulai'] = pg_escape_string($this->input->post('tgl_mulai_pkj'));
//        $pekerjaan['tgl_selesai'] = pg_escape_string($this->input->post('tgl_selesai_pkj'));
//        $pekerjaan['asal_pekerjaan'] = 'task management';
//        $pekerjaan['level_prioritas'] = pg_escape_string($this->input->post('prioritas'));



        $sifat_pkj = $this->input->post('sifat_pkj');
        $parent_pkj = 0;
        $nama_pkj = $this->input->post('nama_pkj');
        $deskripsi_pkj = $this->input->post('deskripsi_pkj');
        $tgl_mulai_pkj = $this->input->post('tgl_mulai_pkj');
        $tgl_selesai_pkj = $this->input->post('tgl_selesai_pkj');
        $prioritas = $this->input->post('prioritas');
        $status_pkj = '2';
        $asal_pkj = 'task management';
        $kategori = pg_escape_string(strtolower($this->input->post('kategori')));


        if (!($kategori == 'project' || $kategori == 'rutin')) {
            $kategori = null;
        }


        $list_staff = $this->input->post("staff");
        $jenis_usulan = $this->input->post('jenis_usulan');

        $lempar = 'pekerjaan/pekerjaan_staff';



        $staff = explode("::", $list_staff);
        foreach ($staff as $key => $s) {
            if (strlen($s) == 0) {
                unset($staff[$key]);
            }
        }

        if ($jenis_usulan == 'usulan' && count($staff) == 0) {
            $this->load->view('pekerjaan/kesalahan', array('judul_kesalahan' => 'Kesalahan Menambahkan Pekerjaan', 'deskripsi_kesalahan' => 'Tidak ada staff yang ditugaskan'));
            exit(0);
        }



        $this->load->model("akun");
        $this->load->model("pekerjaan_model");
        $my_staff = $this->akun->my_staff($temp['user_id']);
        $mystaff = array();
        foreach ($my_staff as $s) {
            $mystaff[] = $s->id_akun;
        }
        $id_pekerjaan = $this->pekerjaan_model->usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj, $kategori);
        if ($id_pekerjaan != NULL) {
            if ($jenis_usulan == 'usulan') {
                foreach ($staff as $index => $val) {//val itu nip
                    if (strlen($val) == 0) {
                        continue;
                    }
                    if (in_array($val, $mystaff))
                        $this->pekerjaan_model->tambah_detil_pekerjaan($val, $id_pekerjaan);
                }
            }


            //echo "path = $path<br/>";
            if (isset($_FILES["berkas"])) {
                $path = './uploads/pekerjaan/' . $id_pekerjaan . '/';
                //$this->load->library('upload');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $files = $_FILES["berkas"];
                $this->upload_file($files, $path, $id_pekerjaan);
            }
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja memberikan pekerjaan kepada staffnya.");
            $this->pekerjaan_model->isi_pemberi_pekerjaan($temp['user_id'], $id_pekerjaan);
        }
        redirect($lempar);
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
        $sifat_pkj = $this->input->post('sifat_pkj2');
        $parent_pkj = 0; //$this->input->post('parent_pkj');
        $nama_pkj = $this->input->post('nama_pkj2');
        $deskripsi_pkj = $this->input->post('deskripsi_pkj2');
        $tgl_mulai_pkj = $this->input->post('tgl_mulai_pkj2');
        $tgl_selesai_pkj = $this->input->post('tgl_selesai_pkj2');
        $prioritas = $this->input->post('prioritas2');
        $status_pkj = '1'; //$this->input->post('status_pkj');
        if (strtolower($temp['hakakses']) == 'administrator')
            $status_pkj = '2';
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
        $data["list_pekerjaan"] = $this->pekerjaan_model->list_pekerjaan(array($temp['user_id']));
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

        $this->load->model(array("pekerjaan_model", "berkas_model", 'akun'));
        
        
        $id_detail_pkj = $this->input->get('id_detail_pkj');
        if ($id_detail_pkj == NULL || strlen($id_detail_pkj) == 0) {
            redirect(base_url() . "pekerjaan/karyawan");
            //exit(0);
        } else {

            /* mengupdate status pekerjaan dilihat dan tanggal read jika pekerjaan itu belum pernah
             * dibaca
             */
            $this->baca_pending_task($id_detail_pkj);
            //$is_isi_komentar = $this->input->get('is_isi_komentar');
            $data["deskripsi_pekerjaan"] = $this->pekerjaan_model->sp_deskripsi_pekerjaan($id_detail_pkj);
            //print_r($data['deskripsi_pekerjaan']);
            if (count($data['deskripsi_pekerjaan']) > 0) {
                $data["listassign_pekerjaan"] = $this->pekerjaan_model->sp_listassign_pekerjaan($id_detail_pkj);
                $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
                $data["temp"] = $this->session->userdata('logged_in');
                $data["users"] = json_decode(file_get_contents($url));
                $data["display"] = "none";
                $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat detail tentang pekerjaannya.");
                $data["lihat_komentar_pekerjaan"] = $this->pekerjaan_model->sp_lihat_komentar_pekerjaan($id_detail_pkj);
                $data["id_pkj"] = $id_detail_pkj;
                $data['my_staff'] = $this->akun->my_staff($temp["user_id"]);
                //print_r($data['my_staff']);
                $staff_array = array();
                
                foreach ($data['my_staff'] as $s) {
                    //print_r($s);
                    if(is_array($s))
                    $staff_array[$s->id_akun] = $s->nama;
                }
                $data['staff_array'] = $staff_array;
                //$data['my_staff'] = json_encode($data['my_staff']);
                $data["list_berkas"] = $this->berkas_model->get_berkas_of_pekerjaan($id_detail_pkj);
                $this->load->view('pekerjaan/karyawan/deskripsi_pekerjaan_page', $data);
            } else {
                $data['judul_kesalahan'] = 'Kesalahan membaca pekerjaan';
                $data['deskripsi_kesalahan'] = 'Tidak dapat menemukan pekerjaan yang diminta';
                $this->load->view('pekerjaan/kesalahan', $data);
            }
        }
    }

    public function lihat_komentar_pekerjaan($id_pkj = 0) {
        $this->load->model("pekerjaan_model");
        $id_detail_pkj = $id_pkj;
        $data["lihat_komentar_pekerjaan"] = $this->pekerjaan_model->sp_lihat_komentar_pekerjaan($id_detail_pkj);
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["temp"] = $this->session->userdata('logged_in');
        $data["users"] = json_decode(file_get_contents($url));
        $this->load->view("pekerjaan/lihat_komentar", $data);
    }

    public function ubah_komentar_pekerjaan() {
        $this->load->model("pekerjaan_model");
        $id_komentar = $this->input->get("id_komentar_ubah");
        $isi_komentar = $this->input->get("isi_komentar_ubah");
        $data["ubah_komentar_pekerjaan"] = $this->pekerjaan_model->sp_ubah_komentar_pekerjaan($id_komentar, $isi_komentar);
    }

    public function lihat_komentar_pekerjaan_by_id() {
        $this->load->model("pekerjaan_model");
        $id_komentar = $this->input->get("id_komentar_ubah");
        //echo $id_komentar;
        $data = $this->pekerjaan_model->sp_lihat_komentar_pekerjaan_by_id($id_komentar);
        foreach ($data as $value) {
            $komentar = $value->isi_komentar;
        }
        //echo $id_komentar;
        echo json_encode(array("status" => "OK", "data" => $komentar));
    }

    public function hapus_file() {
        $id_file = pg_escape_string($this->input->get('id_file'));
        $id_pekerjaan = pg_escape_string($this->input->get("id_pekerjaan"));
        $this->load->model(array('pekerjaan_model', 'berkas_model'));
        $session = $this->session->userdata('logged_in');
        $cek = $this->pekerjaan_model->cek_pemberi_pekerjaan($id_pekerjaan);
        $hasil['status'] = 'error';
        //print_r($cek);
        if (count($cek) == 0 || (count($cek) > 0 && $cek[0]->id_akun == $session['user_id'])) {
            $berkas = $this->berkas_model->get_berkas($id_file);
            $hapus = $this->berkas_model->hapus_file($id_file);
            if ($hapus == true) {
                $hasil['status'] = 'OK';
                unlink($berkas[0]->nama_file);
            } else
                $hasil['reason'] = 'gagal menghapus';
        }else {
            $hasil['reason'] = 'bukan milik anda';
        }



        echo json_encode($hasil);
    }

    public function hapus_komentar_pekerjaan() {
        $this->load->model("pekerjaan_model");
        $id_komentar = $this->input->get('id_komentar');
        $data["hapus_komentar_pekerjaan"] = $this->pekerjaan_model->sp_hapus_komentar_pekerjaan($id_komentar);
    }

    public function komentar_pekerjaan() {
//        if ($this->check_session_and_cookie() == 1) {
        //list pekerjaan, query semua pekerjaan per individu dari tabel detil pekerjaan

        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        $this->load->model("pekerjaan_model");
        $id_detail_pkj = $this->input->get('id_detail_pkj');
        $isi_komentar = $this->input->get('komentar_pkj');
        $id_akun = $temp['user_id'];
        $data["tambah_komentar_pekerjaan"] = $this->pekerjaan_model->sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar);
        $data["display"] = "block";
        $r = $this->taskman_repository->sp_insert_activity($id_akun, 0, "Aktivitas Komentar", $temp['user_nama'] . " baru saja memberikan komentar : " . $isi_komentar . "");

//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function lihat_usulan() {
        $this->session->set_userdata('prev', 'lihat_usulan');
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
            $this->pekerjaan_model->isi_pemberi_pekerjaan($temp['user_id'], $id_pekerjaan);
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
        $this->session->set_userdata('prev', 'pekerjaan_per_staff?id_akun=' . $id_staff);
        $data["pekerjaan_staff"] = $this->pekerjaan_model->list_pekerjaan(array($id_staff));
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

    public function batalkan_pekerjaan() {
        $this->load->model(array("pekerjaan_model", "akun"));
        /*
         * mendapatkan list id pekerjaan yang akan dibatalkan
         */
        $list_id_pekerjaan = $this->input->get("id_pekerjaan");
        $id_pekerjaan = explode("::", $list_id_pekerjaan);
        $session = $this->session->userdata('logged_in');
        /*
         * mendapatkan list staff, untuk dicek apakah suatu pekerjaan dilakukan oleh staffnya
         * atau oleh staff manager yang lain
         */
        $staff = $this->akun->my_staff($session["user_id"]);
        $id_staff = array();
        foreach ($staff as $s) {
            $id_staff[] = $s->id_akun;
        }
        //echo "id staff ";
        //print_r($id_staff);
        $update['flag_usulan']='9';
        
        foreach ($id_pekerjaan as $key => $val) {
            if (strlen($val) > 0) {
                $cur_id_pekerjaan = pg_escape_string($val);
                $this->pekerjaan_model->update_pekerjaan($update,$cur_id_pekerjaan);
                //echo 'id pekerjaan yang akan dibatalkan untuk staffku=' . $cur_id_pekerjaan . "<br>\n";
                $this->pekerjaan_model->batalkan_task($cur_id_pekerjaan, $id_staff);
            }
        }
        //echo 'id pekerjaan ';
        //print_r($id_pekerjaan);
        echo json_encode(array('status' => 'OK'));
//        $list_detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($id_pekerjaan);
//        echo 'detil pekerjaan pekerjaan ';
//        print_r($list_detil_pekerjaan);
//        $cur_id_pekerjaan="";
//        $cur_jumlah_staff_ku=0;
//        $cur_jumlah_staff_orang_lain=0;
//        foreach($list_detil_pekerjaan as $detil_pekerjaan){
//            //print_r($detil_pekerjaan);
//            if($cur_id_pekerjaan==$detil_pekerjaan->id_pekerjaan){
//                if(in_array($detil_pekerjaan->id_akun,$id_staff)){
//                    /* jika pekerjaan ini dikerjakan oleh staff ku*/
//                    $cur_jumlah_staff_ku++;
//                }else{/*selain itu*/
//                    $cur_jumlah_staff_orang_lain++;
//                }
//            }else{
//                /*
//                 * aksi untuk membatalkan pekerjaan
//                 */
//                $cur_jumlah_staff_ku=0;
//                $cur_jumlah_staff_orang_lain=0;
//                $cur_id_pekerjaan=$detil_pekerjaan->id_pekerjaan;
//            }
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

    public function nilai_get() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $id_pekerjaan = pg_escape_string($this->input->post('id_pekerjaan'));
        $id_staff = pg_escape_string($this->input->post('id_staff'));
        $nama_tipe_nilai = strtolower(pg_escape_string($this->input->post('tipe_nilai')));
        $query_staff = $this->akun->my_staff($session['user_id']);
        $my_staff = array();
        $nama_staff = array();
        foreach ($query_staff as $s) {
            $my_staff[] = $s->id_akun;
            $nama_staff[$s->id_akun] = $s->nama;
        }
        if (in_array($id_staff, $my_staff) || ($session['user_id'] == $id_staff && $session['hakakses'] == 'Administrator')) {//jika staff yang dinilai atau bawahannya
            $detail_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan_of_staff(array($id_pekerjaan), $id_staff);
            if (count($detail_pekerjaan) > 0) {//jika ada detil pekerjaan yg berkaitan dengan pekerjaan dan staff nya
                $tipe_nilai = $this->pekerjaan_model->get_tipe_nilai_by_nama($nama_tipe_nilai);
                if (count($tipe_nilai) > 0) {//jika tipe penilaian valid
                    $nilai = $this->pekerjaan_model->nilai_get($detail_pekerjaan[0]->id_detil_pekerjaan, $tipe_nilai[0]->id_tipe_nilai);
                    if (count($nilai) > 0) {//jika sudah ada sebelumnya
                        $data['status'] = 'OK';
                        $data['data'] = $nilai;
                        echo json_encode($data);
                    } else if ($nama_tipe_nilai == 'realisasi') {
                        //jika yang direquest adalah nilai realisasi tetapi nilai target belum ada
                        $tipe_target = 'target';
                        $tipe_nilai = $this->pekerjaan_model->get_tipe_nilai_by_nama($tipe_target);
                        if (count($tipe_nilai) > 0) {
                            //mengambil nilai target
                            $nilai = $this->pekerjaan_model->nilai_get($detail_pekerjaan[0]->id_detil_pekerjaan, $tipe_nilai[0]->id_tipe_nilai);
                            if (count($nilai) > 0) {//jika target sudah diisi
                                echo json_encode(array('status' => 'kosong', 'keterangan' => 'belum ada nilai'));
                            } else {//jika target belum diisi
                                echo json_encode(array('status' => 'null', 'keterangan' => 'harap mengisi target terlebih dahulu'));
                            }
                        } else {
                            echo json_encode(array('status' => 'null', 'keterangan' => 'kesalahan pada database tipe nilai'));
                        }
                    } else {
                        echo json_encode(array('status' => 'kosong', 'keterangan' => 'belum ada nilai'));
                    }
                } else {
                    echo json_encode(array('status' => 'null', 'keterangan' => 'tipe nilai tidak dikenal'));
                }
            } else {
                echo json_encode(array('status' => 'null', 'keterangan' => 'detil pekerjaan untuk ' . $nama_staff[$id_staff] . ' tidak ditemukan'));
            }
        } else {
            echo json_encode(array('status' => 'null', 'keterangan' => 'bukan bawahan anda'));
        }
    }

    public function nilai_set() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $id_pekerjaan = pg_escape_string($this->input->post('id_pekerjaan'));
        $id_staff = pg_escape_string($this->input->post('id_staff'));
        $ak = pg_escape_string($this->input->post('ak'));
        $kuantitas_output = pg_escape_string($this->input->post('kuantitas_output'));
        $kualitas_mutu = pg_escape_string($this->input->post('kualitas_mutu'));
        $waktu = pg_escape_string($this->input->post('waktu'));
        $biaya = pg_escape_string($this->input->post('biaya'));
        $nama_tipe_nilai = strtolower(pg_escape_string($this->input->post('tipe_nilai')));
        if ($nama_tipe_nilai=='target'&&($ak == '0' || $kualitas_mutu == '0' || $kuantitas_output == '0' || $biaya == '0' || $waktu == '0') ){
            echo json_encode(array('status' => 'null', 'keterangan' => 'nilai tidak boleh 0'));
        } else {
            

            $tipe_nilai = $this->pekerjaan_model->get_tipe_nilai_by_nama($nama_tipe_nilai);
            $detail_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan_of_staff(array($id_pekerjaan), $id_staff);



            $query_staff = $this->akun->my_staff($session['user_id']);
            $my_staff = array();
            foreach ($query_staff as $s) {
                $my_staff[] = $s->id_akun;
            }
            $error='';
            if (count($detail_pekerjaan) > 0) {
                //print_r($detail_pekerjaan);
                if (in_array($id_staff, $my_staff) || ($session['user_id'] == $id_staff && $session['hakakses'] == 'Administrator')) {//jika staff yang dinilai atau bawahannya
                    if (count($tipe_nilai) > 0) {//jika tipe nilai valid
                        $insert['ak'] = $ak;
                        $insert['kuatitas_output'] = $kuantitas_output;
                        $insert['kualitas_mutu'] = $kualitas_mutu;
                        $insert['waktu'] = $waktu;
                        $insert['biaya'] = $biaya;
                        $insert['id_tipe_nilai'] = $tipe_nilai[0]->id_tipe_nilai;
                        $insert['id_detil_pekerjaan'] = $detail_pekerjaan[0]->id_detil_pekerjaan;
                        $existing_nilai = $this->pekerjaan_model->nilai_get($detail_pekerjaan[0]->id_detil_pekerjaan, $tipe_nilai[0]->id_tipe_nilai);
                        if ($nama_tipe_nilai == 'realisasi') {//jika merupakan realisasi
                            $tipe_target = 'target';
                            $tipe_target = $this->pekerjaan_model->get_tipe_nilai_by_nama($tipe_target);
                            if (count($tipe_target) > 0) {//nilai target adalah valid
                                //mengambil nilai target
                                $target = $this->pekerjaan_model->nilai_get($detail_pekerjaan[0]->id_detil_pekerjaan, $tipe_target[0]->id_tipe_nilai);
                                if (count($target) > 0) {//jika target sudah diisi
                                    $kuantitas = 100 * $kuantitas_output / $target[0]->kuatitas_output;
                                    $kualitas = 100 * $kualitas_mutu / $target[0]->kualitas_mutu;
                                    $persen_waktu = 100 - (100 * $waktu / $target[0]->waktu);
                                    $nilai_waktu = 0;
                                    if ($persen_waktu > 24) {
                                        $nilai_waktu = 76 - ((((1.76 * $target[0]->waktu - $waktu) / $target[0]->waktu) * 100) - 100);
                                    } else {
                                        $nilai_waktu = ((1.76 * $target[0]->waktu - $waktu) / $target[0]->waktu) * 100;
                                    }
                                    $nilai_biaya = 0;
                                    $persen_biaya = 100 - ($biaya / $target[0]->biaya * 100);
                                    if ($persen_biaya > 24) {
                                        $nilai_biaya = 76 - ((((1.76 * $target[0]->biaya - $biaya) / $target[0]->biaya) * 100) - 100);
                                    } else {
                                        $nilai_biaya = ((1.76 * $target[0]->biaya - $biaya) / $target[0]->biaya) * 100;
                                    }
                                    $insert['penghitungan'] = $kualitas + $kuantitas + $nilai_biaya + $nilai_waktu;
                                    $insert['nilai_skp'] = $insert['penghitungan'] / 4;
                                    if ($target[0]->biaya == 0 && $biaya == 0) {
                                        $insert['nilai_skp'] = $insert['penghitungan'] / 3;
                                    }
                                } else {//jika target belum diisi
                                    //echo json_encode(array('status' => 'null', 'keterangan' => 'target belum diisi XX'));
                                    $error='target belum diisi ';
                                }
                            } else {//tidak ada tipe nilai target
                                //echo json_encode(array('status' => 'null', 'keterangan' => 'tipe nilai target belum terdaftar'));
                                $error='tipe nilai target belum terdaftar';
                            }
                        } else {//jika bukan tipe nilai realisasi
                        }
                        //commit
                        if (count($existing_nilai) > 0 && $error=='') {
                            //print_r($existing_nilai);
                            $perbarui = $this->pekerjaan_model->nilai_update($insert, $existing_nilai[0]->id_nilai);
                            if ($perbarui)
                                echo json_encode(array('status' => 'OK', 'keterangan' => $nama_tipe_nilai . ' sudah ada, telah diperbarui'));
                            else
                                echo json_encode(array('status' => 'null', 'keterangan' => 'gagal memperbarui nilai'));
                        } else if($error==''){
                            $nilai = $this->pekerjaan_model->nilai_set($insert);
                            //print_r($nilai);
                            if ($nilai) {
                                echo json_encode(array('status' => 'OK', 'keterangan' => 'berhasil'));
                            } else {
                                echo json_encode(array('status' => 'null', 'keterangan' => 'gagal menambahkan nilai'));
                            }
                        }else{
                            echo json_encode(array('status' => 'null', 'keterangan' => $error));
                        }
                    }//jika tipe valid
                    else {//jika tipe tidak valid
                        echo json_encode(array('status' => 'null', 'keterangan' => 'tipe nilai diperlukan'));
                    }
                } else {
                    echo json_encode(array('status' => 'null', 'keterangan' => 'bukan bawahan anda'));
                }
            } else {
                echo json_encode(array('status' => 'null', 'keterangan' => 'pekerjaan tidak ditemukan'));
            }
        }
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

        $this->load->model(array("pekerjaan_model", 'berkas_model', 'akun'));
        //$this->load->model("berkas_model");
        $id_pekerjaan = pg_escape_string($this->input->get('id_pekerjaan'));
        if ($id_pekerjaan == NULL || strlen($id_pekerjaan) == 0) {
            redirect(base_url() . "pekerjaan/karyawan");
            exit(0);
        }
        $data = array();
        $data["pekerjaan"] = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        $data["detail_pekerjaan"] = $this->pekerjaan_model->get_detil_pekerjaan(array($id_pekerjaan));
        $data["list_berkas"] = $this->berkas_model->get_berkas_of_pekerjaan($id_pekerjaan);
        $data["data_akun"] = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja melakukan perubahan pada detail pekerjaan.");
        $url3 = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data['my_staff'] = json_encode(json_decode(file_get_contents($url3)));
        $this->load->view("pekerjaan/edit_pekerjaan_page", $data);
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