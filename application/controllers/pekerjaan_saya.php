<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pekerjaan_saya
 *
 * @author mozar
 */
require APPPATH . '/libraries/ceklogin.php';

class pekerjaan_saya extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->model("pengaduan_model");
        $this->load->model('pekerjaan_model');
    }

    public function index() {
        $this->session->set_userdata('prev', 'pekerjaan/karyawan');
//        $this->load->model("pekerjaan_model");
        $this->load->model("akun");
        $temp = $this->session->userdata('logged_in');
        $data = array();
        if (in_array(1, $temp['idmodul'])) {
            $data['data_akun'] = $this->session->userdata('logged_in');
            $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang berada di halaman pekerjaan.");
            if (in_array(2, $temp['idmodul'])) {
                $atasan = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $temp["user_id"] . "/format/json";
                $data["atasan"] = json_decode(file_get_contents($atasan));
            }
            $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
            $data["users"] = json_decode(file_get_contents($url));
            $tahun_max = date('Y');
            $q = $this->db->query("select max(coalesce(date_part('year',tgl_selesai),periode,date_part('year',now()))) as tahun_max from pekerjaan")->result_array();
            if (count($q) > 0) {
                $tahun = (int) $q[0]['tahun_max'];
                if ($tahun_max < $tahun) {
                    $tahun_max = $tahun;
                }
            }
            $tahun_min = $tahun_max - 10;
            $q = $this->db->query("select min(coalesce(date_part('year',tgl_mulai),periode,date_part('year',now()))) as tahun_min from pekerjaan")->result_array();
            if (count($q) > 0) {
                $tahun_min = (int) $q[0]['tahun_min'];
            }
            $data['tahun_max'] = $tahun_max;
            $data['tahun_min'] = $tahun_min;
            $id_akun = $this->session->userdata['logged_in']["user_id"];
            $data['aktivitas'] = $this->pekerjaan_model->activityjobthismonth($id_akun);
            $this->load->view('pekerjaan_saya/view_pekerjaan_saya', $data);
        } else {
            $data['judul_kesalahan'] = 'Tidak berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses pekerjaan';
            $this->load->view('pekerjaan/kesalahan', $data);
        }
    }

    function create_usulan() {
        $session = $this->session->userdata("logged_in");
        //print_r($session);
        $data = array("data_akun" => $session);
        if (in_array("2", $session["idmodul"]) == false) {
            $data['judul_kesalahan'] = 'Tidak berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak untuk membuat usulan pekerjaan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $atasan = intval($this->input->post("atasan"));
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $session["user_id"] . "/format/json";
        $list_atasan = json_decode(file_get_contents($url));
        $atasan_valid = false;
        foreach ($list_atasan as $ats) {
            if ($ats->id_akun == $atasan) {
                $atasan_valid = true;
                break;
            }
        }
        if ($atasan_valid == false) {
            $data['judul_kesalahan'] = 'Tidak berhak';
            $data['deskripsi_kesalahan'] = 'Anda belum memilih atasan untuk usulan pekerjaan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $kategori = $this->input->post("kategori");
        if (in_array($kategori, array("rutin", "project", "tambahan", "kreativitas")) == false) {
            $kategori = "rutin";
        }
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_selesai = $this->input->post("tgl_selesai");
        $pekerjaan_baru = array(
            "id_sifat_pekerjaan" => intval($this->input->post("sifat")),
            "nama_pekerjaan" => $this->input->post("nama_pekerjaan"),
            "deskripsi_pekerjaan" => $this->input->post("deskripsi_pekerjaan"),
            "tgl_mulai" => $tgl_mulai,
            "tgl_selesai" => $tgl_selesai,
            "asal_pekerjaan" => "taskmanagement",
            "level_prioritas" => intval($this->input->post("prioritas")),
            "kategori" => $kategori,
            "id_penanggung_jawab" => $atasan,
            "id_pengusul" => $session["id_akun"],
            "status_pekerjaan" => 6,
            "periode" => intval($this->input->post("periode")),
            "level_manfaat" => intval($this->input->post("manfaat"))
        );
        $biaya = $this->input->post("biaya");
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'ISO, DMY'");
        $this->db->insert("pekerjaan", $pekerjaan_baru);
        $id_pekerjaan = $this->db->insert_id();
        $detil_pekerjaan = array(
            "id_pekerjaan" => $id_pekerjaan,
            "id_akun" => $session["id_akun"],
            "skor" => 0,
            "progress" => 0,
            "sasaran_angka_kredit" => max(floatval($this->input->post("angka_kredit")), 1),
            "sasaran_kuantitas_output" => max(intval($this->input->post("kuantitas")), 1),
            "sasaran_kualitas_mutu" => max(1, min(100, intval($this->input->post("kualitas")))),
            "sasaran_waktu" => 12,
            "sasaran_biaya" => ($biaya == "-" ? 0 : abs(floatval($biaya))),
            "pakai_biaya" => ($biaya == "-" ? 0 : 1),
            "satuan_kuantitas" => $this->input->post("satuan_kuantitas"),
            "satuan_waktu" => "bulan"
        );
        $this->db->insert("detil_pekerjaan", $detil_pekerjaan);
        $this->load->library(array('myuploadlib'));
        $uploader = new MyUploadLib();
        $uploader->prosesUpload('berkas',  date('Y') . '/' . date('m') . '/' . $id_pekerjaan);
        $uploadedFiles = $uploader->getUploadedFiles();
        foreach ($uploadedFiles as $file) {
            //$sql = "insert into file (id_pekerjaan,nama_file,waktu, path) values ($id_pekerjaan,'" . $file['name'] . "',now(),'" . $file['filePath'] . "')";
            $berkas = array(
                "id_pekerjaan" => $id_pekerjaan,
                "nama_file" => $file["name"],
                "path" => $file["filePath"]
            );
            $this->db->insert("file", $berkas);
        }
        $this->db->trans_complete();
        redirect(site_url() . "/pekerjaan_saya/detail_usulan?id_pekerjaan=" . $id_pekerjaan);
    }

    //untuk data graph di controller pekerjaan saya, fungsi index
    public function vardata() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        $id_akun = $this->session->userdata['logged_in']["user_id"];
        $query = $this->pekerjaan_model->activityjobthismonth($id_akun);
        echo json_encode($query);
    }

    function detail_usulan() {
        $id_pekerjaan = intval($this->input->get("id_pekerjaan"));
        $session = $this->session->userdata("logged_in");
        $data = array("data_akun" => $session);
        $q = $this->db->select(array("pekerjaan.*", "sifat_pekerjaan.nama_sifat_pekerjaan"))
                        ->where(array("id_pekerjaan" => $id_pekerjaan, "status_pekerjaan" => 6))
                        ->join("sifat_pekerjaan", "pekerjaan.id_sifat_pekerjaan=sifat_pekerjaan.id_sifat_pekerjaan")
                        ->get("pekerjaan")->result_array();
        if (count($q) < 1) {
            $data['judul_kesalahan'] = 'Tidak berhak';
            $data['deskripsi_kesalahan'] = 'Pekerjaan tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $pekerjaan = $q[0];
        $detil_pekerjaan = $this->db->where(array("id_pekerjaan" => $id_pekerjaan))->get("detil_pekerjaan")->result_array();
        $berkas = $this->db->where(array("id_pekerjaan" => $id_pekerjaan, "id_progress" => NULL, "id_detil_pekerjaan" => NULL, "id_aktivitas" => NULL, "id_tugas" => NULL))->get("file")->result_array();
        //print_r($this->db->last_query());
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $users = json_decode(file_get_contents($url));
        $data["pekerjaan"] = $pekerjaan;
        $data["detil_pekerjaan"] = $detil_pekerjaan;
        $data["list_berkas"] = $berkas;
        $data["users"] = $users;
        $this->load->view("pekerjaan_saya/view_detail_usulan", $data);
    }

    function detail_tugas() {
        $id_tugas = intval($this->input->get('id_tugas'));
        $session = $this->session->userdata('logged_in');
        $q = $this->db->query("select *, to_char(tanggal_mulai,'YYYY-MM-DD') as tanggal_mulai2, to_char(tanggal_selesai,'YYYY-MM-DD') as tanggal_selesai2 "
                        . "from assign_tugas where id_assign_tugas='$id_tugas'")->result_array();
        if (count($q) <= 0) {
            redirect(site_url() . '/pekerjaan_saya');
            return;
        }
        $tugas = $q[0];
        $id_akun_json = json_decode(str_replace('}', ']', str_replace('{', '[', $tugas['id_akun'])));
        if (!in_array($session['id_akun'], $id_akun_json)) {
            redirect(site_url() . '/pekerjaan_saya');
            return;
        }
        $id_pekerjaan = $tugas['id_pekerjaan'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            redirect(site_url() . '/pekerjaan_saya');
            return;
        }
        $pekerjaan = $q[0];
        $detil_pekerjaan = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();

        $data = array(
            'data_akun' => $session,
            'tugas' => $tugas,
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaan' => $detil_pekerjaan
        );
        $data['detil_pekerjaan_saya'] = null;
        foreach ($detil_pekerjaan as $dp) {
            if ($dp['id_akun'] == $session['id_akun']) {
                $data['detil_pekerjaan_saya'] = $dp;
//                print_r($data['detil_pekerjaan_saya']);
                break;
            }
        }
        if ($data['detil_pekerjaan_saya'] == null) {
            redirect(site_url() . '/pekerjaan_saya');
            return;
        }
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["users"] = json_decode(file_get_contents($url));
        $data['aktivitas'] = $this->db->query("select *, to_char(waktu_mulai,'YYYY-MM-DD') as waktu_mulai2, 
				to_char(waktu_selesai,'YYYY-MM-DD') as waktu_selesai2, berkas.id_file, berkas.nama_file
				from aktivitas_pekerjaan 
				left join (select json_agg(id_file) as id_file, json_agg(nama_file) as nama_file, id_tugas,id_aktivitas from file group by id_tugas,id_aktivitas) berkas 
				on berkas.id_aktivitas=aktivitas_pekerjaan.id_aktivitas and berkas.id_tugas=aktivitas_pekerjaan.id_tugas
				where aktivitas_pekerjaan.id_tugas='$id_tugas'")->result_array();
        $data['aktivitas_saya'] = null;
//        print_r($data);
        foreach ($data['aktivitas'] as $akt) {
            if ($akt['id_detil_pekerjaan'] == $data['detil_pekerjaan_saya']['id_detil_pekerjaan']) {
                $data['aktivitas_saya'] = $akt;
            }
        }
        $data['file_pendukung_pekerjaan'] = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_detil_pekerjaan is null and id_progress is null and id_tugas is null and id_aktivitas is null")->result_array();
        $data['file_pendukung_tugas'] = $this->db->query("select * from file where id_tugas = '$id_tugas' and id_detil_pekerjaan is null")->result_array();
        $this->load->view('pekerjaan_saya/view_detail_tugas', $data);
    }

    function detail() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $session = $this->session->userdata('logged_in');
        $data = array('data_akun' => $session);
        $pekerjaan = null;
        $q = $this->db->query("select *, to_char(tgl_mulai,'YYYY-MM-DD') as tanggal_mulai, to_char(tgl_selesai,'YYYY-MM-DD') as tanggal_selesai "
                        . "from pekerjaan p "
                        . "inner join sifat_pekerjaan s on s.id_sifat_pekerjaan=p.id_sifat_pekerjaan "
                        . "where p.id_pekerjaan='$id_pekerjaan' and p.status_pekerjaan = 7")->result_array();
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Pekerjaan tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }

        $detil_pekerjaans = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan' order by id_detil_pekerjaan")->result_array();
        $detil_pekerjaan = null;
        foreach ($detil_pekerjaans as $dp) {
            if ($dp['id_akun'] == $session['user_id']) {
                $detil_pekerjaan = $dp;
                break;
            }
        }
        if ($detil_pekerjaan == null) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Anda tidak terlibat dalam pekerjaan ini';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $id_detil_pekerjaan = $detil_pekerjaan['id_detil_pekerjaan'];
        $list_file_pendukung = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_progress is null and id_detil_pekerjaan is null and id_aktivitas is null and id_tugas is null")->result_array();
        $list_file_progress = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_detil_pekerjaan='$id_detil_pekerjaan' and id_progress is null and id_tugas is null")->result_array();
        $data = array(
            'data_akun' => $session,
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaans' => $detil_pekerjaans,
            'detil_pekerjaan' => $detil_pekerjaan,
            'list_file_pendukung' => $list_file_pendukung
        );
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["users"] = json_decode(file_get_contents($url));
        $this->mark_read($session['user_id'], $id_pekerjaan);
        $this->load->view('pekerjaan_saya/view_detail', $data);
    }

    function update_usulan() {
        $id_pekerjaan = intval($this->input->post("id_pekerjaan"));
        $session = $this->session->userdata("logged_in");
        $data = array("data_akun" => $session);
        $q = $this->db->where(array("id_pekerjaan" => $id_pekerjaan, "status_pekerjaan" => 6))->get("pekerjaan")->result_array();
        if (count($q) < 1) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Usulan pekerjaan tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $pekerjaan = $q[0];
        if ($session["id_akun"] != $pekerjaan["id_pengusul"]) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengubah usulan pekerjaan orang lain';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $atasan = intval($this->input->post("atasan"));
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $session["user_id"] . "/format/json";
        $list_atasan = json_decode(file_get_contents($url));
        $atasan_valid = false;
        foreach ($list_atasan as $ats) {
            if ($ats->id_akun == $atasan) {
                $atasan_valid = true;
                break;
            }
        }
        if ($atasan_valid == false) {
            $data['judul_kesalahan'] = 'Tidak berhak';
            $data['deskripsi_kesalahan'] = 'Anda belum memilih atasan untuk usulan pekerjaan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $kategori = $this->input->post("kategori_pekerjaan");
        if (in_array($kategori, array("rutin", "project", "tambahan", "kreativitas")) == false) {
            $kategori = "rutin";
        }
        $level_manfaat = intval($this->input->post("select_kemanfaatan"));
        $level_manfaat = max(min($level_manfaat, 3), 1);
        $update_pekerjaan = array(
            "id_sifat_pekerjaan" => intval($this->input->post("sifat_pkj")),
            "nama_pekerjaan" => $this->input->post("nama_pkj"),
            "deskripsi_pekerjaan" => $this->input->post("deskripsi_pkj"),
            "tgl_mulai" => $this->input->post("tgl_mulai"),
            "tgl_selesai" => $this->input->post("tgl_selesai"),
            "asal_pekerjaan" => "taskmanagement",
            "level_prioritas" => intval($this->input->post("prioritas")),
            "kategori" => $kategori,
            "id_penanggung_jawab" => $atasan,
            "periode" => abs(intval($this->input->post("periode"))),
            "level_manfaat" => $level_manfaat
        );
        $biaya = $this->input->post("biaya");
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'ISO, DMY'");
        $kualitas = intval($this->input->post("kualitas_mutu"));
        $kualitas = max(min($kualitas, 100), 1);
        $this->db->update("pekerjaan", $update_pekerjaan, array("id_pekerjaan" => $id_pekerjaan));
        $update_detil_pekerjaan = array(
            "sasaran_angka_kredit" => abs(floatval($this->input->post("angka_kredit"))),
            "sasaran_kuantitas_output" => max(intval($this->input->post("kuantitas_output"), 1)),
            "sasaran_kualitas_mutu" => $kualitas,
            "sasaran_biaya" => ($biaya == "-" ? 0 : max(floatval($biaya), 1)),
            "pakai_biaya" => ($biaya == "-" ? 0 : 1),
            "satuan_kuantitas" => $this->input->post("satuan_kuantitas")
        );
        $this->db->update("detil_pekerjaan", $update_detil_pekerjaan, array("id_pekerjaan" => $id_pekerjaan, "id_akun" => $session["id_akun"]));
        $this->load->library(array("myuploadlib"));
        $uploader = new MyUploadLib();
        $uploader->prosesUpload('berkas', date('Y') . '/' . date('m') . '/' . $id_pekerjaan);
        $uploadedFiles = $uploader->getUploadedFiles();
        foreach ($uploadedFiles as $file) {
            $berkas = array(
                "id_pekerjaan" => $id_pekerjaan,
                "nama_file" => $file["name"],
                "path" => $file["filePath"]
            );
            $this->db->insert("file", $berkas);
        }
        $this->db->trans_complete();
        redirect(site_url() . "/pekerjaan_saya/detail_usulan?id_pekerjaan=" . $id_pekerjaan);
    }

    function view_edit_usulan() {
        $id_pekerjaan = intval($this->input->get("id_pekerjaan"));
        $session = $this->session->userdata("logged_in");
        $data = array("data_akun" => $session);
        $q = $this->db->where(array("id_pekerjaan" => $id_pekerjaan, "status_pekerjaan" => 6))->get("pekerjaan")->result_array();
        if (count($q) < 1) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Usulan pekerjaan tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $pekerjaan = $q[0];
        if ($pekerjaan["id_pengusul"] != $session["id_akun"]) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengubah usulan pekerjaan orang lain';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $detil_pekerjaan = $this->db->where(array("id_pekerjaan" => $id_pekerjaan))->get("detil_pekerjaan")->result_array();
        $list_berkas = $this->db->where(array("id_pekerjaan" => $id_pekerjaan))->get("file")->result_array();
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $users = json_decode(file_get_contents($url));
        $atasan = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $session["user_id"] . "/format/json";
        $atasan = json_decode(file_get_contents($atasan));
        $data["pekerjaan"] = $pekerjaan;
        $data["detil_pekerjaan"] = $detil_pekerjaan;
        $data["list_berkas"] = $list_berkas;
        $data["list_users"] = $users;
        $data["list_atasan"] = $atasan;
//     	print_r($atasan);
        $this->load->view("pekerjaan_saya/view_edit_usulan", $data);
    }

    public function get_list_skp_saya() {
        $this->load->model(array('pekerjaan_saya_model'));
        $session = $this->session->userdata('logged_in');
        $periode = abs(intval($this->input->get('periode')));
        echo json_encode($this->pekerjaan_saya_model->get_list_skp_saya($session['user_id'], $periode));
    }

    function get_list_draft() {
        $session = $this->session->userdata('logged_in');
        $periode = abs(intval($this->input->post('periode')));
        $my_id = $session['id_akun'];
        $q = $this->db->query("
            select p.*, to_char(p.tgl_mulai,'YYYY-MM-DD') as tanggal_mulai,
            to_char(p.tgl_selesai,'YYYY-MM-DD') as tanggal_selesai
            from pekerjaan p
            where p.id_penanggung_jawab='$my_id' and p.status_pekerjaan='9'
            and (date_part('year',p.tgl_mulai)='$periode' or date_part('year',p.tgl_selesai)='$periode' )
            ")->result_array();
        echo json_encode($q);
    }

    function get_list_usulan() {
        $periode = abs(intval($this->input->get("periode")));
        $session = $this->session->userdata("logged_in");
        $my_id = $session["id_akun"];
        $q = $this->db->query(
                        "select p.*, detils.id_akuns, to_char(p.tgl_mulai, 'YYYY-MM-DD') as tanggal_mulai,
		to_char(p.tgl_selesai, 'YYYY-MM-DD') as tanggal_selesai
		from pekerjaan p
		inner join (
			select dp2.id_pekerjaan, json_agg(dp2.id_akun) as id_akuns
			from detil_pekerjaan dp2
			group by dp2.id_pekerjaan
		) as detils
		on detils.id_pekerjaan = p.id_pekerjaan
		where p.status_pekerjaan = 6
		and p.id_pekerjaan in (
			select id_pekerjaan 
			from detil_pekerjaan dp
			where dp.id_akun = '$my_id'
		)
		and p.id_pengusul = '$my_id'
		order by p.tgl_mulai asc, p.tgl_selesai asc
		"
                )->result_array();
        echo json_encode($q);
    }

    function get_list_tugas() {
        $periode = abs(intval($this->input->get('periode')));
        $session = $this->session->userdata('logged_in');
        $my_id = $session['user_id'];
        $q = $this->db->query(
                        "select assign_tugas.*, 
		pekerjaan.nama_pekerjaan, 
		aktivitas_pekerjaan.id_aktivitas, aktivitas_pekerjaan.status_validasi as status_validasi_aktivitas, 
		to_char(assign_tugas.tanggal_mulai,'YYYY-MM-DD') as tanggal_mulai2,
		to_char(assign_tugas.tanggal_selesai,'YYYY-MM-DD') as tanggal_selesai2 
		from assign_tugas 
		inner join pekerjaan on pekerjaan.id_pekerjaan=assign_tugas.id_pekerjaan 
		inner join detil_pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan and detil_pekerjaan.id_akun='$my_id' 
		left join aktivitas_pekerjaan on aktivitas_pekerjaan.id_detil_pekerjaan=detil_pekerjaan.id_detil_pekerjaan and assign_tugas.id_assign_tugas=aktivitas_pekerjaan.id_tugas 
		where '$my_id'=any(assign_tugas.id_akun) 
		and date_part('year',assign_tugas.tanggal_mulai)='$periode'"
                )->result_array();
        echo json_encode($q);
    }

    private function mark_read($id_akun, $id_pekerjaan) {
        $this->db->query("update detil_pekerjaan set tgl_read=now() where id_akun='$id_akun' and id_pekerjaan='$id_pekerjaan' and tgl_read is null");
    }

    function hapus_usulan_json() {
        $hasil = $this->hapus_usulan();
        echo json_encode($hasil);
    }

    function hapus_usulan_page() {
        $session = $this->session->userdata("logged_in");
        $hasil = $this->hapus_usulan();
        if ($hasil["status"] == "ok") {
            redirect(site_url() . '/pekerjaan_saya');
        } else {
            $data = array("data_akun" => $session);
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = $hasil['reason'];
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
    }

    private function hapus_usulan() {
        $id_pekerjaan = intval($this->input->get("id_pekerjaan"));
        $q = $this->db->where(array("status_pekerjaan" => 6, "id_pekerjaan" => $id_pekerjaan))->get("pekerjaan")->result_array();
        $session = $this->session->userdata("logged_in");
        $data = array("data_akun" => $session);
        $hasil = array("status" => "fail", "reason" => "unknown");
        if (count($q) < 1) {
            $hasil["reason"] = "Usulan tidak dapat ditemukan";
            return $hasil;
        }
        $usulan = $q[0];
        if ($usulan["id_penanggung_jawab"] == $session["id_akun"] || $usulan["id_pengusul"] == $session["id_akun"]) {
            //hapus usulan
            $this->db->trans_begin();
            $files = $this->db->where(array("id_pekerjaan" => $id_pekerjaan))->get("file")->result_array();
            $this->db->delete("file", array("id_pekerjaan" => $id_pekerjaan));
            $this->db->delete("komentar", array("id_pekerjaan" => $id_pekerjaan));
            $this->db->delete("detil_pekerjaan", array("id_pekerjaan" => $id_pekerjaan));
            $this->db->delete("pekerjaan", array("id_pekerjaan" => $id_pekerjaan));
            foreach ($files as $file) {
                if (file_exists($file["path"])) {
                    unlink($file["path"]);
                }
            }
            $this->db->trans_complete();
            $hasil["status"] = "ok";
            return $hasil;
        }
        return $hasil;
    }

    function hapus_file_json() {
        $hasil = $this->hapus_file();
        echo json_encode($hasil);
    }

    private function hapus_file() {
        $id_file = intval($this->input->get('id_file'));
        $session = $this->session->userdata('logged_in');
        $hasil = array("status" => "fail", "reason" => "unknown");
        $q = $this->db->query("select * from file where id_file='$id_file'")->result_array();
        if (count($q) <= 0) {
            $hasil["reason"] = "Berkas dengan id $id_file tidak dapat ditemukan";
            return $hasil;
        }
        $berkas = $q[0];
        $id_pekerjaan = $berkas["id_pekerjaan"];
        $q = $this->db->where(array("id_pekerjaan" => $id_pekerjaan))->get("pekerjaan")->result_array();
        if (count($q) < 1) {
            //file terdaftar sebagai milik dari suatu pekerjaan, tapi pekerjaan itu tidak ada
            $hasil["reason"] = "Pekerjaan tidak terdaftar";
            return $hasil;
        }
        $pekerjaan = $q[0];
        if ($pekerjaan["status_pekerjaan"] == 6) {
            //jika pekerjaan tersebut masih berupa draft, maka pengusul berhak menghapus berkas
            if ($session["id_akun"] == intval($pekerjaan["id_pengusul"])) {
                if (file_exists($berkas['path'])) {
                    unlink($berkas['path']);
                }
                $this->db->query("delete from file where id_file='$id_file'");
                $hasil["status"] = "ok";
                return $hasil;
            }
        }
//        if ($pekerjaan["id_penanggung_jawab"] == $session["id_akun"]) {
//            //penanggung jawab berhak menghapus berkas apapun yang berkaitan dengan pekerjaan ini
//            if (file_exists($berkas['path'])) {
//                unlink($berkas['path']);
//            }
//            $this->db->query("delete from file where id_file='$id_file'");
//            $hasil["status"] = "ok";
//            return $hasil;
//        }
        $id_detil_pekerjaan = $berkas['id_detil_pekerjaan'];
        $q = $this->db->query("select * from detil_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            $hasil['reason'] = 'detil pekerjaan tidak dapat ditemukan';
            return $hasil;
        }
//        $detil_pekerjaan = $q[0];
//        if ($detil_pekerjaan['id_akun'] != $session['id_akun']) {
//            echo 'Anda tidak terlibat di dalam Pekerjaan ini';
//            return;
//        }
        $id_aktivitas = $berkas['id_aktivitas'];
        $id_progress = $berkas['id_progress'];
        if (intval($id_aktivitas) > 0) {
            $q = $this->db->query("select * from aktivitas_pekerjaan where id_aktivitas='$id_aktivitas'")->result_array();
            if (count($q) <= 0) {
                $hasil["reason"] = 'Aktivitas pekerjaan tidak dapat ditemukan';
                return $hasil;
            }
            $aktivitas = $q[0];
            if ($aktivitas['status_validasi'] == '1') {
                $hasil["reason"] = 'Anda tidak berhak menghapus berkas di aktivitas yang sudah divalidasi';
                return $hasil;
            }
        } else if (intval($id_progress) > 0) {
            $q = $this->db->query("select * from detil_progress where id_detil_progress='$id_progress'")->result_array();
            if (count($q) <= 0) {
                $hasil["reason"] = "Progress tidak dapat ditemukan";
                return $hasil;
            }
            $progress = $q[0];
            if ($progress['validated'] == '1') {
                $hasil["reason"] = 'Anda tidak berhak menghapus berkas di progress yang sudah divalidasi';
                return $hasil;
            }
        }
        if (file_exists($berkas['path'])) {
            unlink($berkas['path']);
        }
        $this->db->query("delete from file where id_file='$id_file'");
        $hasil["status"] = "ok";
        return $hasil;
    }

}
