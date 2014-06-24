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

    public function perpanjang() {
        $id_pekerjaan = pg_escape_string($this->input->post('id_pekerjaan'));
        $tanggal_baru = pg_escape_string($this->input->post('tanggal_baru'));
        $komentar = pg_escape_string($this->input->post('komentar_perpanjang'));
        $session = $this->session->userdata('logged_in');
        $status = true;
        if (strlen($id_pekerjaan) == 0) {
            $status = false;
        }
        $status = in_array(4, $session['idmodul']);
        if ($status) {
            $this->load->model(array('pekerjaan_model'));
            $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
            if (count($pekerjaan) == 0) {
                $status = false;
            }
        }

        if ($status) {
            $status = $status && $pekerjaan[0]->id_penanggung_jawab == $session['id_akun'];
        }
        if($status){
            $update['tgl_selesai']=$tanggal_baru;
            //$this->pekerjaan_model->update($update);
            //echo $pekerjaan[0]->tgl_selesai.' ';
            $t = strtotime($tanggal_baru);
            //echo $t.' ';
            $baru= date('Y-m-d', $t);
            $sistem = date('Y-m-d');
            //echo $sistem . ' ' . $baru.' ';
            $banding = strcmp(date('Y-m-d'), $baru);
            //echo $banding;
            if($banding <= 0){
                $update['flag_usulan']='2';
                $ubah = $this->pekerjaan_model->update_pekerjaan($update,$id_pekerjaan);
                if($ubah){
                    $result = $this->pekerjaan_model->sp_tambah_komentar_pekerjaan($id_pekerjaan, $session['id_akun'], $komentar);
                }
                echo json_encode(array('status'=>'OK'));
            }else{
                echo json_encode(array('status'=>'error','reason'=>'Tanggal yang anda masukkan tidak valid'));
            }
        }
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
                $path = './uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $id_pekerjaan . '/';
                //$this->load->library('upload');

                $files = $_FILES["berkas"];
                if (count($files) > 0)
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
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
        $data["detil_pekerjaan"] = $detil_pekerjaan;
        $data["my_staff"] = json_encode($staff);
        $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang berada di halaman pekerjaan.");
        //var_dump($data["pkj_karyawan"]);
        if (in_array(2, $temp['idmodul'])) {
            $atasan = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $temp["user_id"] . "/format/json";
            $data["atasan"] = json_decode(file_get_contents($atasan));
        }
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["users"] = json_decode(file_get_contents($url));
        $this->load->view('pekerjaan/karyawan/karyawan_page', $data);
    }

    public function do_edit() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array("pekerjaan_model", "akun"));
        $update["id_sifat_pekerjaan"] = pg_escape_string($this->input->post("sifat_pkj"));
        $update["nama_pekerjaan"] = pg_escape_string($this->input->post("nama_pkj"));
        $update["deskripsi_pekerjaan"] = pg_escape_string($this->input->post("deskripsi_pkj"));
        $update["tgl_mulai"] = pg_escape_string($this->input->post("tgl_mulai_pkj"));
        $update["tgl_selesai"] = pg_escape_string($this->input->post("tgl_selesai_pkj"));
        $update["level_prioritas"] = pg_escape_string($this->input->post("prioritas"));
        $update["asal_pekerjaan"] = 'task management';
        $id_pekerjaan = pg_escape_string($this->input->post('id_pekerjaan'));
        $update["kategori"] = pg_escape_string($this->input->post("kategori"));
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        $status = 0;
        $nama_status = "";
        $keterangan = "";
        if (count($pekerjaan) == 0) {
            $status = 1;
            $nama_status = "kesalahan";
            $keterangan = "pekerjaan tidak ditemukan";
        }
        if ($pekerjaan[0]->flag_usulan == '3' || $pekerjaan[0]->flag_usulan == '6') {
            $status = 1;
            $nama_status = "kesalahan";
            $keterangan = "Pekerjaan ini telah dibatalkan";
        }
        $atasan = in_array(5,$session['idmodul']);
        $terlibat = false;
        $usulan = false;
        $detil_pekerjaan = "";
        $my_staff = $this->akun->my_staff($session['user_id']);
        $list_id_staff = array();
        if (!isset($my_staff->error)) {
            foreach ($my_staff as $staff) {
                $list_id_staff[] = $staff->id_akun;
            }
        }
        if ($status == 0) {
            if ($pekerjaan[0]->flag_usulan == '9' && strcmp(date('Y-m-d'), date('Y-m-d',strtotime($update["tgl_selesai"]))) <= 0) {
                $update['flag_usulan'] = '2';
            }
            echo "mencari siapa yang terlibat, siapa yang atasan";
            $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan(array($id_pekerjaan));
            foreach ($detil_pekerjaan as $detil) {
                if ($detil->id_akun == $session['user_id']) {
                    $terlibat = true;
                    echo "terlibat";
                    //break;
                }
                if (!in_array($detil->id_akun, $list_id_staff)) {
                    $atasan = false;
                    echo "bukan atasan";
                }
            }
            //$atasan = $atasan || ($session['hakakses'] == 'Administrator');
            if ($pekerjaan[0]->flag_usulan == '1')
                $usulan = true;
        }
        if ($status == 0) {
            if (!($atasan || ($usulan && $terlibat))) {
                $staff = 1;
                $nama_status = "kesalahan";
                $keterangan = "anda tidak berhak mengubah pekerjaan";
            }
        }

        if ($status == 1) {
            $data['judul_kesalahan'] = $nama_status;
            $data['deskripsi_kesalahan'] = $keterangan;
            $this->load->view('pekerjaan/kesalahan', $data);
        }

        if ($status == 0) {
            if ($this->pekerjaan_model->update_pekerjaan($update, $id_pekerjaan)) {
                if ($usulan && $terlibat && !$atasan) {
                    
                } else if ($atasan) {
                    $list_staff = $this->input->post("staff");

                    //var_dump($assigned_staff);
                    foreach ($detil_pekerjaan as $detil) {
                        echo "mencari " . '::' . $detil->id_akun . '::' . " dalam $list_staff";
                        if (strpos($list_staff, '::' . $detil->id_akun . '::') === false) {
                            $this->pekerjaan_model->batalkan_penugasan_staff($detil->id_akun, $id_pekerjaan);
                            echo "batalkan $detil->id_akun<br>";
                        } else {
                            $list_staff = str_replace("::$detil->id_akun::", "::", $list_staff);
                            echo "sudah ada $detil->id_akun<br>";
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
                }
                echo "check upload";
                if (isset($_FILES["berkas"])) {
                    echo "uploading";
                    $path = './uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $id_pekerjaan . '/';
                    //$this->load->library('upload');

                    $files = $_FILES["berkas"];
                    if (count($files) > 0)
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                    echo "uploading...";
                    $this->upload_file($files, $path, $id_pekerjaan);
                }
                redirect(base_url() . "pekerjaan/deskripsi_pekerjaan?id_detail_pkj=" . $id_pekerjaan);
                //var_dump($update);
            } else {
                echo "gagal update";
            }
        }
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

        $status = 0;
        $deskripsi_kesalahan = "";
        $judul_kesalahan = "";
        if (!($kategori == 'project' || $kategori == 'rutin')) {
            $status = 1;
            $judul_kesalahan = "kategori pekerjaan tidak valid";
            $deskripsi_kesalahan = 'Harap isi kategori pekerjaan dengan "project" atau "rutin"';
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
            //$this->load->view('pekerjaan/kesalahan', array('judul_kesalahan' => 'Kesalahan Menambahkan Pekerjaan', 'deskripsi_kesalahan' => 'Tidak ada staff yang ditugaskan'));
            //exit(0);
            $status = 1;
            $judul_kesalahan = "Data tidak lengkap";
            $deskripsi_kesalahan = "pilih staff yang akan mengerjakan pekerjaan";
        }



        $this->load->model("akun");
        $this->load->model("pekerjaan_model");
        $my_staff = $this->akun->my_staff($temp['user_id']);
        $mystaff = array();
        foreach ($my_staff as $s) {
            $mystaff[] = $s->id_akun;
        }

        foreach ($staff as $s) {
            if (!in_array($s, $mystaff)) {
                $status = 1;
                $judul_kesalahan = "tidak berhak";
                $deskripsi_kesalahan = "anda hanya dapat memberi pekerjaan kepada staff anda";
                break;
            }
        }

        $insert['id_sifat_pekerjaan'] = $sifat_pkj;
        $insert['parent_pekerjaan'] = 0;
        $insert['nama_pekerjaan'] = $nama_pkj;
        $insert['deskripsi_pekerjaan'] = $deskripsi_pkj;
        $insert['tgl_mulai'] = $tgl_mulai_pkj;
        $insert['tgl_selesai'] = $tgl_selesai_pkj;
        $insert['level_prioritas'] = $prioritas;
        $insert['flag_usulan'] = '2';
        $insert['asal_pekerjaan'] = 'task management';
        $insert['kategori'] = $kategori;
        $insert['id_penanggung_jawab'] = $temp['id_akun'];
        if ($status == 1) {
            $data['judul_kesalahan'] = $judul_kesalahan;
            $data['deskripsi_kesalahan'] = $deskripsi_kesalahan;
            $data['data_akun'] = $temp;
            $this->load->view('pekerjaan/kesalahan', $data);
        }
        if ($status == 0) {
            $id_pekerjaan = $this->pekerjaan_model->usul_pekerjaan2($insert);
            if ($id_pekerjaan != NULL) {

                foreach ($staff as $index => $val) {//val itu nip
                    $this->pekerjaan_model->tambah_detil_pekerjaan($val, $id_pekerjaan);
                }

                //echo "path = $path<br/>";
                if (isset($_FILES["berkas"])) {
                    $path = './uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $id_pekerjaan . '/';
                    //$this->load->library('upload');

                    $files = $_FILES["berkas"];
                    if (count($files) > 0)
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                    $this->upload_file($files, $path, $id_pekerjaan);
                }
                $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja memberikan pekerjaan kepada staffnya.");
                //$this->pekerjaan_model->isi_pemberi_pekerjaan($temp['user_id'], $id_pekerjaan);
            }
            redirect($lempar);
        }
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
                    $this->berkas_model->upload_file($temp['user_id'], $new_file_path, $id_pekerjaan);
                    echo "berhasil memindah file";
                } else {
                    echo "gagal memindah file";
                }
            } else {
                echo "nama file kosong";
            }
        }
    }

    public function usulan_pekerjaan() {
        $data['data_akun'] = $this->session->userdata("logged_in");
        $this->load->model("pekerjaan_model");
        $temp = $this->session->userdata('logged_in');
        $sifat_pkj = $this->input->post('sifat_pkj2');
        $parent_pkj = 0; //$this->input->post('parent_pkj');
        $nama_pkj = $this->input->post('nama_pkj2');
        $deskripsi_pkj = $this->input->post('deskripsi_pkj2');
        $tgl_mulai_pkj = $this->input->post('tgl_mulai_pkj2');
        $tgl_selesai_pkj = $this->input->post('tgl_selesai_pkj2');
        $prioritas = $this->input->post('prioritas2');
        $idatasan = $this->input->post('atasan');
        $status_pkj = '1'; //$this->input->post('status_pkj');

        $asal_pkj = 'task management'; //$this->input->post('asal_pkj');
        $insert['id_sifat_pekerjaan'] = $sifat_pkj;
        $insert['parent_pekerjaan'] = 0;
        $insert['nama_pekerjaan'] = $nama_pkj;
        $insert['deskripsi_pekerjaan'] = $deskripsi_pkj;
        $insert['tgl_mulai'] = $tgl_mulai_pkj;
        $insert['tgl_selesai'] = $tgl_selesai_pkj;
        $insert['level_prioritas'] = $prioritas;
        $insert['flag_usulan'] = '1';
        $insert['asal_pekerjaan'] = 'task management';
        $insert["id_penanggung_jawab"] = $idatasan;
        $insert["id_pengusul"] = $temp['id_akun'];
        $status = 0;
        $judul_kesalahan = '';
        $deskripsi_kesalahan = '';
        if (!in_array(2, $temp['idmodul'])) {
            $status = 1;
            $judul_kesalahan = 'Kesalahan';
            $deskripsi_kesalahan = 'Anda tidak berhak mengusulkan pekerjaan';
        }
        if ($status == 0 && strlen(trim($insert['id_penanggung_jawab'])) == 0) {
            $status = 1;
            $judul_kesalahan = 'data tidak lengkap';
            $deskripsi_kesalahan = 'atasan  diperlukan';
        }
        if ($status == 0 && strlen(trim($insert['level_prioritas'])) == 0) {
            $status = 1;
            $judul_kesalahan = 'data tidak lengkap';
            $deskripsi_kesalahan = 'level_prioritas diperlukan';
        }
        if ($status == 0 && strlen(trim($insert['tgl_mulai'])) == 0) {
            $status = 1;
            $judul_kesalahan = 'data tidak lengkap';
            $deskripsi_kesalahan = 'tgl_mulai diperlukan';
        }
        if ($status == 0 && strlen(trim($insert['tgl_selesai'])) == 0) {
            $status = 1;
            $judul_kesalahan = 'data tidak lengkap';
            $deskripsi_kesalahan = 'tgl_selesai diperlukan';
        }
        if ($status == 0 && strlen(trim($insert['deskripsi_pekerjaan'])) == 0) {
            $status = 1;
            $judul_kesalahan = 'data tidak lengkap';
            $deskripsi_kesalahan = 'deskripsi pekerjaan diperlukan';
        }
        if ($status == 0 && strlen(trim($insert['nama_pekerjaan'])) == 0) {
            $status = 1;
            $judul_kesalahan = 'data tidak lengkap';
            $deskripsi_kesalahan = 'nama pekerjaan diperlukan';
        }
        if ($status == 0 && strlen(trim($insert['id_sifat_pekerjaan'])) == 0) {
            $status = 1;
            $judul_kesalahan = 'data tidak lengkap';
            $deskripsi_kesalahan = 'id sifat pekerjaan diperlukan';
        }
        if ($status == 1) {
            $data['data_akun'] = $temp;
            $data['judul_kesalahan'] = $judul_kesalahan;
            $data['deskripsi_kesalahan'] = $deskripsi_kesalahan;
            $this->load->view('pekerjaan/kesalahan', $data);
        }
        if ($status == 0) {//$result = $this->taskman_repository->sp_tambah_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj);
            $result = $this->pekerjaan_model->usul_pekerjaan2($insert);
            $id_pekerjaan_baru = -1;
            if ($result != NULL)
                $id_pekerjaan_baru = $result;
            if ($id_pekerjaan_baru >= 0) {
                //$atasan_url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $id_akun . "/format/json";

                $result = $this->taskman_repository->sp_tambah_detil_pekerjaan($id_pekerjaan_baru, $temp['user_id']);

                if (isset($_FILES["berkas"])) {
                    $path = './uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $id_pekerjaan_baru . '/';
                    //$path = './uploads/pekerjaan/' . $id_pekerjaan_baru . '/';
                    $this->load->library('upload');
                    $files = $_FILES["berkas"];
                    if (count($files) > 0) {
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                    }
                    $this->upload_file($files, $path, $id_pekerjaan_baru);
                }
            } else {
                
            }
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja mengusulkan pekerjaan.");
            redirect('pekerjaan/karyawan');
        }
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

    public function req_perpanjangan() {
        $id_pekerjaan = pg_escape_string($this->input->post('id_pekerjaan'));
        $alasan = pg_escape_string($this->input->post('alasan'));
        $this->load->model(array('pekerjaan_model'));
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        $status = 0;
        $deskripsi_kesalahan = '';
        $detil_pekerjaan = '';
        $data['data_akun'] = $this->session->userdata('logged_in');
        if (count($pekerjaan) > 0) {
            $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan(array($id_pekerjaan));
        } else {
            $status = 1;
            $deskripsi_kesalahan = 'pekerjaan tidak ditemukan';
        }
        $id_staff = array();
        if ($status == 0) {
            if (count($detil_pekerjaan) > 0) {
                foreach ($detil_pekerjaan as $detil) {
                    $id_staff[] = $detil->id_akun;
                }
            } else {
                $status = 1;
                $deskripsi_kesalahan = 'anda tidak berhak mengakses pekerjaan ini';
            }
        }
        if ($status == 0) {
            if (in_array($data['data_akun']['id_akun'], $id_staff)) {
                $data['terlambat'] = strcmp(substr($pekerjaan[0]->sekarang, 0, 10), substr($pekerjaan[0]->tgl_selesai, 0, 10));
            } else {
                $status = 1;
                $deskripsi_kesalahan = "anda tidak terlibat dalam pekerjaan ini";
            }
        }
        if ($status == 0) {
            if ($data['terlambat']) {
                $update = array();
                $update['flag_usulan'] = '9';
                $result = $this->pekerjaan_model->update_pekerjaan($update, $id_pekerjaan);
                if ($result) {
                    if (strlen($alasan) > 0)
                        $result = $this->pekerjaan_model->sp_tambah_komentar_pekerjaan($id_pekerjaan, $data['data_akun']['id_akun'], $alasan);
                    echo json_encode(array("status" => "OK"));
                }
            } else {
                $status = 1;
                $deskripsi_kesalahan = 'pekerjaan tidak dalam keadaan terlambat';
            }
        }
        if ($status == 1) {
            echo json_encode(array("status" => "error", "keterangan" => $deskripsi_kesalahan));
        }
    }

    public function req_pending_task() {
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $this->session->userdata('logged_in');
        $this->load->model(array("pekerjaan_model", "akun"));
        $list_pekerjaan = $this->pekerjaan_model->list_pending_task($temp['user_id']);
        $my_staff = $this->akun->my_staff($temp['id_akun']);
        $mystaff = array();
        $pekerjaan_staff = array();
        $detil_pekerjaan_staff = array();
        $progress_staff = array();
        if (in_array(5, $temp['idmodul'])) {
            foreach ($my_staff as $ms) {
                $mystaff[] = $ms->id_akun;
            }

            $pekerjaan_staff = $this->pekerjaan_model->get_pekerjaan_staff($mystaff);
            $list_id_pekerjaan = array();
            if (count($pekerjaan_staff) > 0)
                foreach ($pekerjaan_staff as $kerja) {
                    $list_id_pekerjaan[] = $kerja->id_pekerjaan;
                }
            $detil_pekerjaan_staff = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
            $progress_staff = $this->pekerjaan_model->get_progress_per_staff($mystaff);
        }
        echo json_encode(array("status" => "OK", "data" => $list_pekerjaan,
            "staff" => $my_staff,
            "pekerjaan_staff" => $pekerjaan_staff,
            "detil_pekerjaan_staff" => $detil_pekerjaan_staff,
            "progress_staff" => $progress_staff));
    }

    public function deskripsi_pekerjaan() {
        $data['data_akun'] = $this->session->userdata('logged_in');
        //$data['temp'] = $this->session->userdata('logged_in');
        $temp = $this->session->userdata('logged_in');

        $this->load->model(array("pekerjaan_model", "berkas_model", 'akun'));

        $id_detail_pkj = $this->input->get('id_detail_pkj');
        $status = 0;
        $nama_status = "OK";
        $keterangan = "OK";
        if ($id_detail_pkj == NULL || strlen($id_detail_pkj) == 0) {
            $status = 1;
            $nama_status = "Kesalahan";
            $keterangan = "id pekerjaan dibutuhkan";
        }
        $data["deskripsi_pekerjaan"] = "";
        $deskripsi_pekerjaan = "";
        if ($status == 0) {
            //$is_isi_komentar = $this->input->get('is_isi_komentar');
            $data["deskripsi_pekerjaan"] = $this->pekerjaan_model->sp_deskripsi_pekerjaan($id_detail_pkj);
            $deskripsi_pekerjaan = $data['deskripsi_pekerjaan'];
            //print_r($deskripsi_pekerjaan);
            if (count($deskripsi_pekerjaan) > 0) {
                //pekerjaan berhasil di-query dari database, pekerjaan ada
                $data['terlambat'] = strcmp(substr($deskripsi_pekerjaan[0]->sekarang, 0, 10), substr($deskripsi_pekerjaan[0]->tgl_selesai, 0, 10));
            } else {
                $status = 1;
                $nama_status = "Pekerjaan tidak ditemukan";
                $keterangan = "Pekerjaan tidak ditemukan";
            }
        }
        //print_r($data['deskripsi_pekerjaan']);
        $data['bisa_validasi'] = false;
        $data['bisa_edit'] = false;
        $data['bisa_batalkan'] = false;
        $data["listassign_pekerjaan"] = "";
        $atasan = false;
        if ($status == 0) {
            $data['my_staff'] = $this->akun->my_staff($temp["user_id"]);
            $my_staff = $data['my_staff'];
            $list_my_staff = array();
            if (!isset($my_staff->error)) {
                foreach ($my_staff as $staff) {
                    $list_my_staff[] = $staff->id_akun;
                }
            }

            $desk = $data["deskripsi_pekerjaan"];
            $data['list_my_staff'] = $list_my_staff;
            $usulan = $desk[0]->flag_usulan == '1';
            $data['perpanjang'] = $desk[0]->flag_usulan == '9';
            //$admin = $temp['hakakses'] == 'Administrator';
            $data["listassign_pekerjaan"] = $this->pekerjaan_model->sp_listassign_pekerjaan($id_detail_pkj);
            $detil_pekerjaan = $data['listassign_pekerjaan'];
            $ikut_serta = false;
            $diassign_ke_bawahan_saya = true; //menandakan bahwa yang mengerjakan suatu pekerjaan seluruhnya adalah bawahanku
            foreach ($detil_pekerjaan as $detil) {
                if ($detil->id_akun == $temp['user_id']) {
                    $ikut_serta = true;
                    //break;
                }
                if (!in_array($detil->id_akun, $list_my_staff)) {
                    $diassign_ke_bawahan_saya = false;
                }
            }
            $data['diassign_ke_bawahan_saya'] = $diassign_ke_bawahan_saya;
            $data['ikut_serta'] = $ikut_serta;
            if ($desk[0]->id_penanggung_jawab == $temp['user_id'] && $usulan) {//pemberi pekerjaan, atasan yg dituju pada pengusulan, atau atasan yg mengusulkan
                $data['bisa_validasi'] = $usulan;
                $data['bisa_edit'] = true;
                $data['bisa_batalkan'] = true;
                $atasan = true;
            } else if ($desk[0]->flag_usulan == '2' && ($diassign_ke_bawahan_saya || $desk[0]->id_penanggung_jawab == $temp['user_id'])) {//berkuasa atas pekerjaan
                $data['bisa_edit'] = true;
                $data['bisa_batalkan'] = true;
                $atasan = true;
            } else if ($usulan && $ikut_serta) { //jika usulan dan dia adalah anggota pekerja
                $data['bisa_edit'] = true;
                $data['bisa_batalkan'] = true;
            } else if ($data['perpanjang'] && $desk[0]->id_penanggung_jawab == $temp['user_id']) {
                $data['bisa_edit'] = true;
                $data['bisa_batalkan'] = true;
                $atasan = true;
            }
            $sifat_terbuka = strtolower($deskripsi_pekerjaan[0]->nama_sifat_pekerjaan) == 'umum';
            $data['bisa_edit'] &= in_array(4, $temp['idmodul']);
            $data['bisa_validasi'] &= in_array(4, $temp['idmodul']);
            $data['bisa_batalkan'] &= in_array(4, $temp['idmodul']);
            if ($data['bisa_validasi'] || $data['bisa_edit'] || $data['bisa_batalkan'] || $sifat_terbuka || $ikut_serta) {
                
            } else {
                $status = 1;
                $nama_status = "Tidak Berhak";
                $keterangan = "Anda tidak berhak melihat pekerjaan ini ";
            }
            $data['atasan'] = $atasan;
            $data['ikut_serta'] = $ikut_serta;
            $data['sifat_terbuka'] = $sifat_terbuka;
            $data['usulan'] = $usulan;
        }
        //var_dump($data);
        if ($status == 1) {
            $data['judul_kesalahan'] = $nama_status;
            $data['deskripsi_kesalahan'] = $keterangan;
            $this->load->view('pekerjaan/kesalahan', $data);
        }
        if ($status == 0) {
            /* mengupdate status pekerjaan dilihat dan tanggal read jika pekerjaan itu belum pernah
             * dibaca
             */
            $this->baca_pending_task($id_detail_pkj);
            $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
            $data["users"] = json_decode(file_get_contents($url));
            $data["display"] = "none";
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat detail tentang pekerjaannya.");
            $data["lihat_komentar_pekerjaan"] = $this->pekerjaan_model->sp_lihat_komentar_pekerjaan($id_detail_pkj);
            $data["id_pkj"] = $id_detail_pkj;

            $data["list_berkas"] = $this->berkas_model->get_berkas_of_pekerjaan($id_detail_pkj);
            //var_dump($data);
            $this->load->view('pekerjaan/karyawan/deskripsi_pekerjaan_page', $data);
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
        $cek = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        $hasil['status'] = 'error';
        //print_r($cek);
        if (count($cek) > 0) {
            $berhak = false;
            if ($cek[0]->id_penanggung_jawab == $session['user_id']) {
                $berhak = true;
            } else if ($cek[0]->flag_usulan == '1' && $cek[0]->id_pengusul == $session['id_akun']) {
                $berhak = true;
            } else {
                $hasil['reason'] = "Anda tidak berhak menghapus berkas";
            }
            if ($berhak) {
                $berkas = $this->berkas_model->get_berkas($id_file);
                $hapus = $this->berkas_model->hapus_file($id_file);
                if ($hapus == true && count($berkas) > 0) {
                    $hasil['status'] = 'OK';
                    if (file_exists($berkas[0]->nama_file))
                        unlink($berkas[0]->nama_file);
                } else
                    $hasil['reason'] = 'gagal menghapus';
            }
        }else {
            $hasil['reason'] = 'Pekerjaan tidak ditemukan';
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
        //$data["temp"] = $this->session->userdata('logged_in');
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
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        $status = 0;
        if (count($pekerjaan) > 0) {
            
        } else {
            echo json_encode(array("status" => "error", "reason" => "pekerjaan tidak ditemukan"));
            $status = 1;
        }
        if ($status == 0) {
            if ($pekerjaan[0]->id_penanggung_jawab == $temp['id_akun']) {
                
            } else {
                $status = 1;
                echo json_encode(array("status" => "error", "reason" => "anda tidak berhak memvalidasi usulan ini"));
            }
        }
        if ($status == 0) {
            if ($this->pekerjaan_model->validasi_pekerjaan($id_pekerjaan) == 1) {
                $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja melakukan validasi terhadap usulan pekerjaan dari staffnya");
                //$this->pekerjaan_model->isi_pemberi_pekerjaan($temp['user_id'], $id_pekerjaan);
                echo json_encode(array("status" => "OK"));
            } else {
                echo json_encode(array("status" => "FAILED", "reason" => "failed to update"));
            }
        }
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
        //print_r($data);
        $this->load->view("pekerjaan/lihat_daftar_pekerjaan_staff_page", $data);
    }

    public function pekerjaan_per_staff() {
        $this->load->model(array("pekerjaan_model", "akun"));
        $session = $this->session->userdata('logged_in');
        $data["data_akun"] = $session;
        $id_staff = $this->input->get("id_akun");
        $this->session->set_userdata('prev', 'pekerjaan_per_staff?id_akun=' . $id_staff);

        //print_r($data['pekerjaan_staff']);
        $data["my_staff"] = $this->akun->my_staff($session["user_id"]);
        $data["id_staff"] = $id_staff;
        $data["nama_staff"] = "";
        $status = 1;
        $judul_kesalahan = "Tidak Berhak";
        $deskripsi_kesalahan = "Anda tidak berhak melihat daftar pekerjaan staff ini";
        foreach ($data["my_staff"] as $st) {
            if ($st->id_akun == $id_staff) {
                $data["nama_staff"] = $st->nama;
                $status = 0;
                break;
            }
        }
        if ($status == 0) {
            $data["pekerjaan_staff"] = $this->pekerjaan_model->list_pekerjaan(array($id_staff));
            $list_id_pekerjaan = array();
            foreach ($data["pekerjaan_staff"] as $pekerjaan) {
                $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
            }
            $data["detil_pekerjaan"] = json_encode($this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan));
            //$data["my_staff"] = json_encode($data["my_staff"]);
            $data['detil_progress'] = $this->pekerjaan_model->get_progress_per_staff(array($id_staff));
            $this->load->view('pekerjaan/pekerjaan_per_staff_page', $data);
        }
        if ($status == 1) {
            $data['judul_kesalahan'] = $judul_kesalahan;
            $data['deskripsi_kesalahan'] = $deskripsi_kesalahan;
            $this->load->view('pekerjaan/kesalahan', $data);
        }
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
        $this->load->model(array("pekerjaan_model", "akun", 'berkas_model'));
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
        if (!isset($staff->error)) {
            foreach ($staff as $s) {
                $id_staff[] = $s->id_akun;
            }
        }
        //echo "id staff ";
        //print_r($id_staff);
        $update['flag_usulan'] = '3';

        foreach ($id_pekerjaan as $key => $val) {
            if (strlen($val) > 0) {
                $cur_id_pekerjaan = pg_escape_string($val);
                $pekerjaan = $this->pekerjaan_model->get_pekerjaan($cur_id_pekerjaan);
                if (count($pekerjaan) > 0) {
                    $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan(array($cur_id_pekerjaan));
                    $list_pekerja = array();
                    $berhak_pekerjaan = true;
                    foreach ($detil_pekerjaan as $detil) {
                        if (!in_array($detil->id_akun, $id_staff)) {
                            $berhak_pekerjaan = false;
                            break;
                        }
                    }
                    $usulan = $pekerjaan[0]->flag_usulan == '1';
                    $berhak_usulan = ($session ['user_id'] == $pekerjaan[0]->id_penanggung_jawab && $usulan);
                    $berhak_usulan = $berhak_usulan || ($session ['user_id'] == $pekerjaan[0]->id_pengusul && $usulan);
                    //$admin = $session['hakakses'] == 'Administrator';
                    if (($berhak_pekerjaan && !$usulan) || $berhak_usulan) {
                        $this->pekerjaan_model->update_pekerjaan($update, $cur_id_pekerjaan);
                        //echo 'id pekerjaan yang akan dibatalkan untuk staffku=' . $cur_id_pekerjaan . "<br>\n";
                        $this->pekerjaan_model->batalkan_task($cur_id_pekerjaan);
                        $list_berkas = $this->berkas_model->get_berkas_of_pekerjaan($cur_id_pekerjaan);
                        foreach ($list_berkas as $berkas) {
                            $this->berkas_model->hapus_file($berkas->id_file);
                            unlink($berkas->nama_file);
                        }
                    }
                }
            }
        }
        //echo 'id pekerjaan ';
        //print_r($id_pekerjaan);
        echo json_encode(array('status' => 'OK'));
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


        $status = 'OK';
        $keterangan = '';
        $id_target = null;
        $id_realisasi = null;

        if ($status == 'OK') {
            if (strlen($id_pekerjaan) > 0) {
                //echo 'panjang id pekerjaan'.strlen($id_pekerjaan);
            } else {
                $status = '1';
                $keterangan = 'ID pekerjaan diperlukan';
            }
        }

        if ($status == 'OK') {
            if (strlen($id_staff) > 0) {
                
            } else {
                $status = '1';
                $keterangan = 'staff yang dinilai tidak ditentukan';
            }
        }


        if ($status == 'OK') {
            $tipe_nilai = $this->pekerjaan_model->get_list_tipe_nilai();
            foreach ($tipe_nilai as $tipeNilai) {
                if ($tipeNilai->nama_tipe == 'target')
                    $id_target = $tipeNilai->id_tipe_nilai;
                if ($tipeNilai->nama_tipe == 'realisasi')
                    $id_realisasi = $tipeNilai->id_tipe_nilai;
            }
        }


        $list_id_staff = array();
        $nama_staff = array();
        if ($status == 'OK' && ($id_target == null || $id_realisasi == null)) {
            $status = '1';
            $keterangan = 'Data tipe nilai tidak dapat ditemukan';
        } else {
            $query_staff = $this->akun->my_staff($session['user_id']);
            foreach ($query_staff as $s) {
                $list_id_staff[] = $s->id_akun;
                $nama_staff[$s->id_akun] = $s->nama;
            }
        }

//cek berhak atau tidak untuk menilai seseorang
        if ($status == 'OK') {
            $staff_ku = in_array($id_staff, $list_id_staff);
            //$admin = $session['hakakses'] == 'Administrator';
            //$manager = $session['hakakses'] == 'Manager';

            //if (in_array($id_staff, $list_id_staff) || ($session ['user_id'] == $id_staff && $session['hakakses'] == 'Administrator')) {
            if (($staff_ku && $manager) ) {
                
            } else {
                $status = '1';
                $keterangan = "Anda tidak berhak untuk melakukan penilaian ini";
            }
        }

//mendapatkan detil pekerjaan staff untuk dinilai
        $id_detil_pekerjaan = null;
        if ($status == 'OK') {
            $detail_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan_of_staff(array($id_pekerjaan), $id_staff);
            if (count($detail_pekerjaan) > 0) {//jika ada detil pekerjaan yg berkaitan dengan pekerjaan dan staff nya
                $id_detil_pekerjaan = $detail_pekerjaan[0]->id_detil_pekerjaan;
            } else {
                $status = '1';
                $keterangan = 'Tidak dapat menemukan detil pekerjaan bagi staff yang anda pilih untuk pekerjaan ini';
            }
        }
        //if (count($detail_pekerjaan) > 0) {//jika ada detil pekerjaan yg berkaitan dengan pekerjaan dan staff nya
        //$tipe_nilai = $this->pekerjaan_model->get_tipe_nilai_by_nama($nama_tipe_nilai);
        //if (count($tipe_nilai) > 0) {//jika tipe penilaian valid
        $nilai_target = null;
        $nilai_realisasi = null;
        $data = array();

        if ($status == 'OK') {
            $nilai_target = $this->pekerjaan_model->nilai_get($id_detil_pekerjaan, $id_target);
            $nilai_realisasi = $this->pekerjaan_model->nilai_get($id_detil_pekerjaan, $id_realisasi);
            if ($nama_tipe_nilai == 'realisasi') {
                if (count($nilai_target) > 0) {
                    if (count($nilai_realisasi) > 0) {
                        $data['status'] = $status;
                        $data['data'] = $nilai_realisasi;
                    } else {
                        $status = 'kosong';
                        $keterangan = 'Belum ada nilai';
                    }
                } else {
                    $status = '1';
                    $keterangan = 'Anda belum mengisi nilai target';
                }
            } else if ($nama_tipe_nilai == 'target') {
                if (count($nilai_target) > 0) {
                    $data['status'] = $status;
                    $data['data'] = $nilai_target;
                } else {
                    $status = 'kosong';
                    $keterangan = 'Belum ada nilai';
                }
            } else {
                $status = '1';
                $keterangan = 'Tipe nilai yang diminta tidak dikenal';
            }
        }


        if ($status == 'OK') {
            echo json_encode($data);
        } else {
            echo json_encode(array('status' => $status, 'keterangan' =>
                $keterangan));
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

        $status = 'OK';
        $keterangan = '';
        $id_target = null;
        $id_realisasi = null;

        if (strlen($id_pekerjaan) > 0) {
            //echo 'panjang id pekerjaan'.strlen($id_pekerjaan);
        } else {
            $status = '1';
            $keterangan = 'ID pekerjaan diperlukan';
        }

        if ($status == 'OK') {
            if (strlen($id_staff) > 0) {
                
            } else {
                $status = '1';
                $keterangan = 'staff yang dinilai tidak ditentukan';
            }
        }


        if ($status == 'OK') {
            $tipe_nilai = $this->pekerjaan_model->get_list_tipe_nilai();
            foreach ($tipe_nilai as $tipeNilai) {
                if ($tipeNilai->nama_tipe == 'target')
                    $id_target = $tipeNilai->id_tipe_nilai;
                if ($tipeNilai->nama_tipe == 'realisasi')
                    $id_realisasi = $tipeNilai->id_tipe_nilai;
            }
        }


        $list_id_staff = array();
        $nama_staff = array();
        if ($status == 'OK' && ($id_target == null || $id_realisasi == null)) {
            $status = '1';
            $keterangan = 'Data tipe nilai tidak dapat ditemukan';
        } else {
            $query_staff = $this->akun->my_staff($session['user_id']);
            foreach ($query_staff as $s) {
                $list_id_staff[] = $s->id_akun;
                $nama_staff[$s->id_akun] = $s->nama;
            }
        }

//cek berhak atau tidak untuk menilai seseorang
        if ($status == 'OK') {
            $staff_ku = in_array($id_staff, $list_id_staff);
            //$admin = $session['hakakses'] == 'Administrator';
            //$manager = $session['hakakses'] == 'Manager';

            //if (in_array($id_staff, $list_id_staff) || ($session ['user_id'] == $id_staff && $session['hakakses'] == 'Administrator')) {
            if (($staff_ku && $manager) ) {
                
            } else {
                $status = '1';
                $keterangan = "Anda tidak berhak untuk melakukan penilaian ini";
            }
        }

//mendapatkan detil pekerjaan staff untuk dinilai
        $id_detil_pekerjaan = null;
        if ($status == 'OK') {
            $detail_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan_of_staff(array($id_pekerjaan), $id_staff);
            if (count($detail_pekerjaan) > 0) {//jika ada detil pekerjaan yg berkaitan dengan pekerjaan dan staff nya
                $id_detil_pekerjaan = $detail_pekerjaan[0]->id_detil_pekerjaan;
            } else {
                $status = '1';
                $keterangan = 'Tidak dapat menemukan detil pekerjaan bagi staff yang anda pilih untuk pekerjaan ini';
            }
        }

        $nilai_target = null;
        $nilai_realisasi = null;
        $data = array();
        $id_nilai_target = null;
        $id_nilai_realisasi = null;

        $insert = array();
        if ($status == 'OK') {
            $insert['ak'] = $ak;
            $insert['kuatitas_output'] = $kuantitas_output;
            $insert['kualitas_mutu'] = $kualitas_mutu;
            $insert['waktu'] = $waktu;
            $insert['biaya'] = $biaya;
            $insert['id_detil_pekerjaan'] = $id_detil_pekerjaan;
        }

        $update_data = false;
        $update_id = null;

        if ($status == 'OK') {
            $nilai_target = $this->pekerjaan_model->nilai_get($id_detil_pekerjaan, $id_target);
            $nilai_realisasi = $this->pekerjaan_model->nilai_get($id_detil_pekerjaan, $id_realisasi);
            if ($nama_tipe_nilai == 'realisasi') {
                $insert['id_tipe_nilai'] = $id_realisasi;
                if (count($nilai_target) > 0) {
                    if (count($nilai_realisasi) > 0) {
                        $update_data = true;
                        $update_id = $nilai_realisasi[0]->id_nilai;
                    }
                    $kuantitas = 100 * $kuantitas_output / $nilai_target[0]->kuatitas_output;
                    $kualitas = 100 * $kualitas_mutu / $nilai_target[0]->kualitas_mutu;
                    $persen_waktu = 100 - (100 * $waktu / $nilai_target[0]->waktu);
                    $nilai_waktu = 0;
                    if ($persen_waktu > 24) {
                        $nilai_waktu = 76 - ( ( ((1.76 * $nilai_target[0]->waktu - $waktu) / $nilai_target[0]->waktu) * 100) - 100);
                    } else {
                        $nilai_waktu = ( (1.76 * $nilai_target[0]->waktu - $waktu) / $nilai_target[0]->waktu) * 100;
                    }
                    $nilai_biaya = 0;
                    $persen_biaya = 100 - ($biaya / $nilai_target[0]->biaya * 100);
                    if ($persen_biaya > 24) {
                        $nilai_biaya = 76 - ( ( ((1.76 * $nilai_target[0]->biaya - $biaya) / $nilai_target[0]->biaya) * 100) - 100);
                    } else {
                        $nilai_biaya = ( (1.76 * $nilai_target[0]->biaya - $biaya) / $nilai_target[0]->biaya) * 100;
                    }
                    $insert ['penghitungan'] = $kualitas + $kuantitas + $nilai_biaya + $nilai_waktu;
                    $insert['nilai_skp'] = $insert['penghitungan'] / 4;
                    if ($nilai_target[0]->biaya == 0 && $biaya == 0) {
                        $insert['nilai_skp'] = $insert['penghitungan'] / 3;
                    }
                } else {
                    $status = '1';
                    $keterangan = 'Anda belum mengisi nilai target';
                }
            } else if ($nama_tipe_nilai == 'target') {
                $insert['id_tipe_nilai'] = $id_target;
                if (count($nilai_target) > 0) {
                    $update_data = true;
                    $update_id = $nilai_target[0]->id_nilai;
                }
            } else {
                $status = '1';
                $keterangan = 'Tipe nilai yang diminta tidak dikenal';
            }
        }

        $status_nilai = null;

        if ($status == 'OK') {
            if ($update_data) {//update nilai
                $status_nilai = $this->pekerjaan_model->nilai_update($insert, $update_id);
            } else {//nilai baru
                $status_nilai = $this->pekerjaan_model->nilai_set($insert);
            }
            if ($status_nilai) {
                echo json_encode(array('status' => 'OK', 'keterangan' => 'berhasil'));
            }
        } else {
            echo json_encode(array('status' => $status, 'keterangan' => $keterangan));
        }



//        if ($nama_tipe_nilai == 'target' && ( $ak == '0' || $kualitas_mutu == '0' || $kuantitas_output == '0' || $biaya == '0' || $waktu == '0')) {
//            echo json_encode(array('status' => 'null', 'keterangan' => 'nilai tidak boleh 0'));
//        } else {
//
//
//            $tipe_nilai = $this->pekerjaan_model->get_tipe_nilai_by_nama($nama_tipe_nilai);
//            $detail_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan_of_staff(array($id_pekerjaan), $id_staff);
//
//
//
//            $query_staff = $this->akun->my_staff($session['user_id']);
//            $my_staff = array();
//            foreach ($query_staff as $s) {
//                $my_staff[] = $s->id_akun;
//            }
//            $error = '';
//            if (count($detail_pekerjaan) > 0) {
//                //print_r($detail_pekerjaan);
//                if (in_array($id_staff, $my_staff) || ($session['user_id'] == $id_staff && $session['hakakses'] == 'Administrator')) {//jika staff yang dinilai atau bawahannya
//                    if (count($tipe_nilai) > 0) {//jika tipe nilai valid
//                        $insert['ak'] = $ak;
//                        $insert['kuatitas_output'] = $kuantitas_output;
//                        $insert['kualitas_mutu'] = $kualitas_mutu;
//                        $insert['waktu'] = $waktu;
//                        $insert['biaya'] = $biaya;
//                        $insert['id_tipe_nilai'] = $tipe_nilai[0]->id_tipe_nilai;
//                        $insert['id_detil_pekerjaan'] = $detail_pekerjaan[0]->id_detil_pekerjaan;
//                        $existing_nilai = $this->pekerjaan_model->nilai_get($detail_pekerjaan[0]->id_detil_pekerjaan, $tipe_nilai[0]->id_tipe_nilai);
//                        if ($nama_tipe_nilai == 'realisasi') {//jika merupakan realisasi
//                            $tipe_target = 'target';
//                            $tipe_target = $this->pekerjaan_model->get_tipe_nilai_by_nama($tipe_target);
//                            if (count($tipe_target) > 0) {//nilai target adalah valid
//                                //mengambil nilai target
//                                $target = $this->pekerjaan_model->nilai_get($detail_pekerjaan[0]->id_detil_pekerjaan, $tipe_target[0]->id_tipe_nilai);
//                                if (count($target) > 0) {//jika target sudah diisi
//                                    $kuantitas = 100 * $kuantitas_output / $target[0]->kuatitas_output;
//                                    $kualitas = 100 * $kualitas_mutu / $target[0]->kualitas_mutu;
//                                    $persen_waktu = 100 - (100 * $waktu / $target[0]->waktu);
//                                    $nilai_waktu = 0;
//                                    if ($persen_waktu > 24) {
//                                        $nilai_waktu = 76 - ( ( ((1.76 * $target[0]->waktu - $waktu) / $target[0]->waktu) * 100) - 100);
//                                    } else {
//                                        $nilai_waktu = ( (1.76 * $target[0]->waktu - $waktu) / $target[0]->waktu) * 100;
//                                    }
//                                    $nilai_biaya = 0;
//                                    $persen_biaya = 100 - ($biaya / $target[0]->biaya * 100);
//                                    if ($persen_biaya > 24) {
//                                        $nilai_biaya = 76 - ( ( ((1.76 * $target[0]->biaya - $biaya) / $target[0]->biaya) * 100) - 100);
//                                    } else {
//                                        $nilai_biaya = ( (1.76 * $target[0]->biaya - $biaya) / $target[0]->biaya) * 100;
//                                    }
//                                    $insert ['penghitungan'] = $kualitas + $kuantitas + $nilai_biaya + $nilai_waktu;
//                                    $insert['nilai_skp'] = $insert['penghitungan'] / 4;
//                                    if ($target[0]->biaya == 0 && $biaya == 0) {
//                                        $insert['nilai_skp'] = $insert['penghitungan'] / 3;
//                                    }
//                                } else {//jika target belum diisi
//                                    //echo json_encode(array('status' => 'null', 'keterangan' => 'target belum diisi XX'));
//                                    $error = 'target belum diisi ';
//                                }
//                            } else {//tidak ada tipe nilai target
//                                //echo json_encode(array('status' => 'null', 'keterangan' => 'tipe nilai target belum terdaftar'));
//                                $error = 'tipe nilai target belum terdaftar';
//                            }
//                        } else {//jika bukan tipe nilai realisasi
//                        }
//                        //commit
//                        if (count($existing_nilai) > 0 && $error == '') {
////print_r($existing_nilai);
//                            $perbarui = $this->pekerjaan_model->nilai_update($insert, $existing_nilai[0]->id_nilai);
//                            if (
//                                    $perbarui)
//                                echo json_encode(array('status' => 'OK', 'keterangan' => $nama_tipe_nilai . ' sudah ada, telah diperbarui'));
//                            else
//                                echo json_encode(array('status' => 'null', 'keterangan' => 'gagal memperbarui nilai'));
//                        } else if ($error == '') {
//                            $nilai = $this->pekerjaan_model->nilai_set($insert);
////print_r($nilai);
//                            if ($nilai) {
//                                echo json_encode(array('status' => 'OK', 'keterangan' => 'berhasil'));
//                            } else {
//                                echo json_encode(array('status' => 'null', 'keterangan' => 'gagal menambahkan nilai'));
//                            }
//                        } else {
//                            echo json_encode(array('status' => 'null', 'keterangan' => $error));
//                        }
//                    }//jika tipe valid
//                    else {//jika tipe tidak valid
//                        echo json_encode(array('status' => 'null', 'keterangan' => 'tipe nilai diperlukan'));
//                    }
//                } else {
//                    echo json_encode(array('status' => 'null', 'keterangan' => 'bukan bawahan anda'));
//                }
//            } else {
//                echo json_encode(array('status' => 'null', 'keterangan' => 'pekerjaan tidak ditemukan'));
//            }
//        }
    }

    public function update_progress() {
//        if ($this->check_session_and_cookie() == 1) {
        $temp = $this->session->userdata('logged_in');
        $id_detail_pkj = $this->input->post("id_detail_pkj");
        $data = $this->input->post("data_progress");
        $perubahan = $this->input->post("perubahan");
        $this->load->model("pekerjaan_model");
        $result = $this->pekerjaan_model->sp_updateprogress_pekerjaan($data, $id_detail_pkj);
        $result2 = $this->pekerjaan_model->sp_tambah_progress($data, $id_detail_pkj, $perubahan);


        if ($result == 1 && $result2 == 1)
            $status = array(
                'status' => 'OK');
        else
            $status = array('status' => 'NotOK');

        echo json_encode($status);
//$this->load->view("pekerjaan/progress/progress_pekerjaan_page",$data);
//        } else {
//            $this->session->set_flashdata('status', 4);
//            redirect("login");
//        }
    }

    public function show_log_progress() {
        $temp = $this->session->userdata('logged_in');
        $id_detail_pkj = $this->input->post("id_detail_pkj");
        $id_akun = $this->input->post("user_id");
        $this->load->model("pekerjaan_model");
        $result = $this->pekerjaan_model->sp_history_progress($id_akun, $id_detail_pkj);
        //var_dump($result);
        $status = array(
            'status' => 'OK', 'data' => $result);

        echo json_encode($status);
    }

    public function show_progress() {
//        if ($this->check_session_and_cookie() == 1) {
        $temp = $this->session->userdata('logged_in');
        $id_detail_pkj = $this->input->post('id_detail_pkj');
        $id_akun = $this->input->post('user_id');
        $this->load->model("pekerjaan_model");
        $result = $this->pekerjaan_model->sp_lihat_progress($id_akun, $id_detail_pkj);
        //var_dump($result);
        $status = array(
            'status' => 'OK', 'data' => $result);

        echo json_encode($status);
    }

    public function edit() {
        $temp = $this->session->userdata('logged_in');
        $this->load->model(array("pekerjaan_model", 'berkas_model', 'akun'));
        $id_pekerjaan = pg_escape_string($this->input->get('id_pekerjaan'));
        $status = 0;
        $nama_status = "";
        $keterangan = "";
        if ($id_pekerjaan == NULL || strlen($id_pekerjaan) == 0) {
            $status = 1;
            $nama_status = "id pekerjaan diperlukan";
            $keterangan = "id pekerjaan diperlukan";
        }
        $data = array();
        if ($status == 0) {
            $data["pekerjaan"] = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
            if (count($data['pekerjaan']) == 0) {
                $status = 1;
                $nama_status = "pekerjaan tidak ditemukan";
                $keterangan = "pekerjaan tidak ditermukan";
            }
        }
        if ($data["pekerjaan"][0]->flag_usulan == '3' || $data["pekerjaan"][0]->flag_usulan == '6') {
            $status = 1;
            $nama_status = "kesalahan";
            $keterangan = "Pekerjaan ini telah dibatalkan";
        }
        $data["data_akun"] = $temp;

        if ($status == 0) {
            $data['atasan'] = true;
            $data['usulan'] = false;
            $p = $data['pekerjaan'];
            $data['my_staff'] = $this->akun->my_staff($temp['user_id']);
            $list_id_staff = array();
            if (isset($data['my_staff']->error)) {
                $data['my_staff'] = array();
            }
            foreach ($data['my_staff'] as $staff) {
                $list_id_staff[] = $staff->id_akun;
            }
            $data["detail_pekerjaan"] = $this->pekerjaan_model->get_detil_pekerjaan(array($id_pekerjaan));
            $detil_pekerjaan = $data['detail_pekerjaan'];
//            if ($p[0]->id_akun == $temp['user_id'] || in_array($p[0]->id_akun, $list_id_staff) || $temp['hakakses'] == 'Administrator') {
//                $data['atasan'] = true;
//            }
            //var_dump($list_id_staff);
            foreach ($detil_pekerjaan as $detil) {
                if (!in_array($detil->id_akun, $list_id_staff)) {
                    $data['atasan'] = false;
                    //var_dump($data['atasan']);
                }
            }
            if ($p[0]->flag_usulan == '1') {
                $data['usulan'] = true;
                //var_dump($data['atasan']);
                $data['atasan'] = $data['atasan'] && $p[0]->id_penanggung_jawab == $temp['id_akun'];
                //var_dump($data['atasan']);
            }
            //$data['atasan'] = $data['atasan'] || $temp['hakakses'] == 'Administrator';
            //var_dump($data['atasan']);

            $data['terlibat'] = false;

            foreach ($detil_pekerjaan as $detil) {
                if ($detil->id_akun == $temp['user_id']) {
                    $data['terlibat'] = true;
                    break;
                }
            }
            if (!($data['atasan'] || ($data['usulan'] && $data['terlibat']))) {
                $status = 1;
                $nama_status = "Tidak berhak";
                $keterangan = "anda tidak berhak mengubah pekerjaan";
            }
        }

        //var_dump($data);
        if ($status == 0) {
            $data["list_berkas"] = $this->berkas_model->get_berkas_of_pekerjaan($id_pekerjaan);
            $result = $this->taskman_repository->sp_insert_activity($temp ['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja melakukan perubahan pada detail pekerjaan.");
            $url2 = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
            $data["users"] = json_decode(file_get_contents($url2));
            $this->load->view("pekerjaan/edit_pekerjaan_page", $data);
        }
        if ($status == 1) {
            $data['judul_kesalahan'] = $nama_status;
            $data['deskripsi_kesalahan'] = $keterangan;
            $this->load->view('pekerjaan/kesalahan', $data);
        }
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