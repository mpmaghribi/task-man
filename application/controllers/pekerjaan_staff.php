<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pekerjaan_staff
 *
 * @author mozar
 */
require APPPATH . '/libraries/ceklogin.php';

class pekerjaan_staff extends ceklogin {

    public function __construct() {
        parent::__construct();
        $this->load->model(array("akun", 'pekerjaan_model'));
    }

    public function index() {
        $session = $this->session->userdata('logged_in');
        //print_r($temp);
        $data["data_akun"] = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($session['user_id'], 0, "Aktivitas Pekerjaan", $session['user_nama'] . " sedang melihat progress pekerjaan dari para staffnya.");

        $data["my_staff"] = $this->akun->my_staff($session["user_id"]);
        $this->load->view("pekerjaan_staff/view_pekerjaan_staff", $data);
    }

//    function detail_tambahan() {
//        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
//        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
//        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
//        if ($pekerjaan == null) {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        if ($pekerjaan['kategori'] != 'tambahan') {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
//        $detil_pekerjaan = $this->detil_pekerjaan_model->get_detil_pekerjaan($id_pekerjaan);
//        $session = $this->session->userdata('logged_in');
//        $data = array(
//            'pekerjaan' => $pekerjaan,
//            'detil_pekerjaan' => $detil_pekerjaan,
//            'users' => json_decode(file_get_contents($url)),
//            'data_akun' => $session
//        );
//        $my_id = $session['user_id'];
////        $this->mark_read($my_id, $id_pekerjaan);
//        $this->load->view('pekerjaan_staff/view_detail_tambahan', $data);
//    }
//    function detail_kreativitas() {
//        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
//        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
//        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
//        if ($pekerjaan == null) {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        if ($pekerjaan['kategori'] != 'kreativitas') {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
//        $detil_pekerjaan = $this->detil_pekerjaan_model->get_detil_pekerjaan($id_pekerjaan);
//        $session = $this->session->userdata('logged_in');
//        $data = array(
//            'pekerjaan' => $pekerjaan,
//            'detil_pekerjaan' => $detil_pekerjaan,
//            'users' => json_decode(file_get_contents($url)),
//            'data_akun' => $session
//        );
//        $my_id = $session['user_id'];
////        $this->mark_read($my_id, $id_pekerjaan);
//        $this->load->view('pekerjaan_staff/view_detail_kreativitas', $data);
//    }

    function detail() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $id_staff = abs(intval($this->input->get('id_staff')));
        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        if ($pekerjaan == null) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        $session = $this->session->userdata('logged_in');
        if ($session['user_id'] != $pekerjaan['id_penanggung_jawab']) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $detil_pekerjaan = $this->detil_pekerjaan_model->get_detil_pekerjaan($id_pekerjaan);
        $list_file = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_progress is null")->result_array();
        $data = array(
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaan' => $detil_pekerjaan,
            'users' => json_decode(file_get_contents($url)),
            'data_akun' => $session,
            'id_staff' => $id_staff,
            'list_file' => $list_file
        );
        $this->load->view('pekerjaan_staff/view_detail', $data);
    }

//    function detail_skp() {
//        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
//        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
//        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
//        if ($pekerjaan == null) {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        if ($pekerjaan['kategori'] != 'skp') {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
//        $detil_pekerjaan = $this->detil_pekerjaan_model->get_detil_pekerjaan($id_pekerjaan);
//        $session = $this->session->userdata('logged_in');
//        $data = array(
//            'pekerjaan' => $pekerjaan,
//            'detil_pekerjaan' => $detil_pekerjaan,
//            'users' => json_decode(file_get_contents($url)),
//            'data_akun' => $session
//        );
//        $my_id = $session['user_id'];
////        $this->mark_read($my_id, $id_pekerjaan);
//        $this->load->view('pekerjaan_staff/view_detail', $data);
//    }
//    private function mark_read($id_akun, $id_pekerjaan) {
//        $this->db->query("update detil_pekerjaan set tgl_read=now() where id_akun='$id_akun' and id_pekerjaan='$id_pekerjaan' and tgl_read is null");
//    }

    function detail_aktivitas() {
        $session = $this->session->userdata('logged_in');
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $id_staff = (int) $this->input->get('id_staff');
        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        if ($pekerjaan == null) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        if ($pekerjaan['id_penanggung_jawab'] != $session['user_id']) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        $list_detil_pekerjaan = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $detil_pekerjaan = null;
        foreach ($list_detil_pekerjaan as $dp) {
            if ($dp['id_akun'] == $id_staff) {
                $detil_pekerjaan = $dp;
            }
        }
        if ($detil_pekerjaan == null) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data = array(
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaan' => $detil_pekerjaan,
            'detil_pekerjaans' => $list_detil_pekerjaan,
            'users' => json_decode(file_get_contents($url)),
            'data_akun' => $session
        );
        $this->load->view('pekerjaan_staff/view_detail_aktivitas', $data);
    }

    function edit() {
        $id_pekerjaan = abs(intval($this->input->get('id_pekerjaan')));
        $this->load->model(array('akun'));
        $pekerjaan = null;
        $q = $this->db->query("select *, to_char(tgl_mulai,'DD-MM-YYYY') as tanggal_mulai, to_char(tgl_selesai,'DD-MM-YYYY') as tanggal_selesai from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        $session = $this->session->userdata('logged_in');
        if ($session['user_id'] != $pekerjaan['id_penanggung_jawab']) {
            echo 'Anda tidak berhak mengubah pekerjaan ini';
            return;
        }
        $detil_pekerjaan = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $list_file = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_progress is null")->result_array();
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $data = array(
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaan' => $detil_pekerjaan,
            'list_file' => $list_file,
            'list_staff' => $list_staff,
            'data_akun' => $session
        );
        $this->load->view('pekerjaan_staff/view_edit', $data);
    }

    function staff() {
        $id_staff = (int) $this->input->get('id_staff');
        $session = $this->session->userdata('logged_in');
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data = array(
            "my_staff" => $this->akun->my_staff($session["user_id"]),
            'data_akun' => $this->session->userdata('logged_in'),
            'id_staff' => $id_staff
        );
        $list_staff = $data['my_staff'];
        $data['nama_staff'] = '';
        $staff_valid = false;
        foreach ($list_staff as $staff) {
            if ($staff->id_akun == $id_staff) {
                $data['nama_staff'] = $staff->nama;
                $staff_valid = true;
                break;
            }
        }
        if (!$staff_valid) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
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
        $data['pekerjaan_staff'] = $this->db->query("select * from pekerjaan where id_pekerjaan in (select id_pekerjaan from detil_pekerjaan where id_akun='$id_staff')")->result_array();
        $this->load->view('pekerjaan_staff/view_pekerjaan_per_staff', $data);
    }

//    function add_kreativitas() {
//        $session = $this->session->userdata('logged_in');
//        $list_id_staff_enroll = $this->input->post('staff_enroll');
//        if (!is_array($list_id_staff_enroll)) {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
//        $nama_pekerjaan = $this->input->post('nama_pkj');
//        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
//        $periode = abs(intval($this->input->post('periode')));
//        $prioritas = (int) $this->input->post('prioritas');
//        $list_staff = $this->akun->my_staff($session["user_id"]);
//        $angka_kredit = abs(floatval($this->input->post('angka_kredit')));
//        $kuantitas_output = abs(floatval($this->input->post('kuantitas_output')));
//        $kualitas_mutu = abs(floatval($this->input->post('kualitas_mutu')));
//        $biaya = abs(floatval($this->input->post('biaya')));
//        $pakai_biaya = abs(intval($this->input->post('pakai_biaya')));
//        $satuan_kuantitas = $this->input->post('satuan_kuantitas');
//        $tgl_mulai = $this->input->post('tgl_mulai');
//        $tgl_selesai = $this->input->post('tgl_selesai');
//        $level_manfaat = intval($this->input->post('select_kemanfaatan'));
//        $list_id_staff = array();
//        $list_staff2 = array();
//        foreach ($list_staff as $staff) {
//            $list_id_staff[] = $staff->id_akun;
//            $list_staff2[$staff->id_akun] = $staff;
//        }
//        foreach ($list_id_staff_enroll as $key => $id_staff) {
//            if (!in_array($id_staff, $list_id_staff)) {
//                unset($list_id_staff_enroll[$key]);
//            }
//        }
//        if (!in_array($sifat_pekerjaan, array(1, 2))) {
//            $sifat_pekerjaan = 1;
//        }
//        if (!in_array($level_manfaat, array(1, 2, 3))) {
//            $level_manfaat = 1;
//        }
//        $pekerjaan = array(
//            'id_sifat_pekerjaan' => $sifat_pekerjaan,
//            'nama_pekerjaan' => $nama_pekerjaan,
//            'deskripsi_pekerjaan' => $deskripsi_pekerjaan,
//            'asal_pekerjaan' => 'taskmanagement',
//            'level_prioritas' => $prioritas,
//            'kategori' => 'kreativitas',
//            'id_penanggung_jawab' => $session['user_id'],
//            'status_pekerjaan' => 7,
//            'tgl_mulai' => $tgl_mulai,
//            'tgl_selesai' => $tgl_selesai,
//            'level_manfaat' => $level_manfaat
//        );
//        $this->db->trans_begin();
//        $this->db->query("set datestyle to 'European'");
//        $this->db->insert('pekerjaan', $pekerjaan);
//        $id_pekerjaan = $this->db->insert_id();
//        if (count($list_id_staff_enroll) > 0) {
//            require_once APPPATH . '/libraries/my_email.php';
////            $eml = new my_email();
//            foreach ($list_id_staff_enroll as $id_staff) {
//                $this->db->query("insert into detil_pekerjaan (id_pekerjaan,id_akun) values ($id_pekerjaan,$id_staff)");
//                //$eml->kirim_email($list_staff2[$id_staff]->email, 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
//                //$eml->kirim_email('mohammad.zarkasi@gmail.com', 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
//            }
//            $this->db->trans_complete();
//            redirect(site_url() . '/pekerjaan_staff/detail_kreativitas?id_pekerjaan=' . $id_pekerjaan);
//            echo "tersimpan";
//        } else {
//            $this->db->trans_rollback();
//            echo "rollback";
//            redirect(site_url() . '/pekerjaan_staff');
//        }
//    }
//    function add_tambahan() {
//        $session = $this->session->userdata('logged_in');
//        $list_id_staff_enroll = $this->input->post('staff_enroll');
//        if (!is_array($list_id_staff_enroll)) {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
//        $nama_pekerjaan = $this->input->post('nama_pkj');
//        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
//        $periode = abs(intval($this->input->post('periode')));
//        $prioritas = (int) $this->input->post('prioritas');
//        $list_staff = $this->akun->my_staff($session["user_id"]);
//        $angka_kredit = abs(floatval($this->input->post('angka_kredit')));
//        $kuantitas_output = abs(floatval($this->input->post('kuantitas_output')));
//        $kualitas_mutu = abs(floatval($this->input->post('kualitas_mutu')));
//        $biaya = abs(floatval($this->input->post('biaya')));
//        $pakai_biaya = abs(intval($this->input->post('pakai_biaya')));
//        $satuan_kuantitas = $this->input->post('satuan_kuantitas');
//        $tgl_mulai = $this->input->post('tgl_mulai');
//        $tgl_selesai = $this->input->post('tgl_selesai');
//        $list_id_staff = array();
//        $list_staff2 = array();
//        foreach ($list_staff as $staff) {
//            $list_id_staff[] = $staff->id_akun;
//            $list_staff2[$staff->id_akun] = $staff;
//        }
//        foreach ($list_id_staff_enroll as $key => $id_staff) {
//            if (!in_array($id_staff, $list_id_staff)) {
//                unset($list_id_staff_enroll[$key]);
//            }
//        }
//        if (!in_array($sifat_pekerjaan, array(1, 2))) {
//            $sifat_pekerjaan = 1;
//        }
//
//        $pekerjaan = array(
//            'id_sifat_pekerjaan' => $sifat_pekerjaan,
//            'nama_pekerjaan' => $nama_pekerjaan,
//            'deskripsi_pekerjaan' => $deskripsi_pekerjaan,
//            'asal_pekerjaan' => 'taskmanagement',
//            'level_prioritas' => $prioritas,
//            'kategori' => 'tambahan',
//            'id_penanggung_jawab' => $session['user_id'],
//            'status_pekerjaan' => 7,
//            'tgl_mulai' => $tgl_mulai,
//            'tgl_selesai' => $tgl_selesai
//        );
//        $this->db->trans_begin();
//        $this->db->query("set datestyle to 'European'");
//        $this->db->insert('pekerjaan', $pekerjaan);
//        $id_pekerjaan = $this->db->insert_id();
//        if (count($list_id_staff_enroll) > 0) {
//            require_once APPPATH . '/libraries/my_email.php';
////            $eml = new my_email();
//            foreach ($list_id_staff_enroll as $id_staff) {
//                $this->db->query("insert into detil_pekerjaan (id_pekerjaan,id_akun) values ($id_pekerjaan,$id_staff)");
//                //$eml->kirim_email($list_staff2[$id_staff]->email, 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
//                //$eml->kirim_email('mohammad.zarkasi@gmail.com', 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
//            }
//            $this->db->trans_complete();
//            redirect(site_url() . '/pekerjaan_staff/detail_tambahan?id_pekerjaan=' . $id_pekerjaan);
//            echo "tersimpan";
//        } else {
//            $this->db->trans_rollback();
//            echo "rollback";
//            redirect(site_url() . '/pekerjaan_staff');
//        }
//    }

    function add() {
        $session = $this->session->userdata('logged_in');
        $list_id_staff_enroll = $this->input->post('staff_enroll');
        if (!is_array($list_id_staff_enroll)) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
        $nama_pekerjaan = $this->input->post('nama_pkj');
        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
        $periode = abs(intval($this->input->post('periode')));
        $tanggal_mulai = $this->input->post('tgl_mulai');
        $tanggal_selesai = $this->input->post('tgl_selesai');
        $prioritas = (int) $this->input->post('prioritas');
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $angka_kredit = abs(floatval($this->input->post('angka_kredit')));
        $kuantitas_output = abs(floatval($this->input->post('kuantitas_output')));
        $kualitas_mutu = abs(floatval($this->input->post('kualitas_mutu')));
        $biaya = abs(floatval($this->input->post('biaya')));
        $pakai_biaya = abs(intval($this->input->post('pakai_biaya')));
        $satuan_kuantitas = $this->input->post('satuan_kuantitas');
        $kategori_pakerjaan = $this->input->post('kategori_pekerjaan');
        $level_manfaat = intval($this->input->post('select_kemanfaatan'));
        $list_id_staff = array();
        $list_staff2 = array();

        foreach ($list_staff as $staff) {
            $list_id_staff[] = $staff->id_akun;
            $list_staff2[$staff->id_akun] = $staff;
        }
        foreach ($list_id_staff_enroll as $key => $id_staff) {
            if (!in_array($id_staff, $list_id_staff)) {
                unset($list_id_staff_enroll[$key]);
            }
        }
        if (!in_array($sifat_pekerjaan, array(1, 2))) {
            $sifat_pekerjaan = 1;
        }
        $pekerjaan = array(
            'id_sifat_pekerjaan' => $sifat_pekerjaan,
            'nama_pekerjaan' => $nama_pekerjaan,
            'deskripsi_pekerjaan' => $deskripsi_pekerjaan,
            'asal_pekerjaan' => 'taskmanagement',
            'level_prioritas' => $prioritas,
            'id_penanggung_jawab' => $session['user_id'],
            'status_pekerjaan' => 7
        );
        $bulan = 0;
        if ($kategori_pakerjaan == 'rutin') {
            $pekerjaan['periode'] = $periode;
            $pekerjaan['tgl_mulai'] = $periode . "-1-1";
            $pekerjaan['tgl_selesai'] = $periode . "-12-31";
            $pekerjaan['kategori'] = 'rutin';
        } else {
            $pekerjaan['tgl_mulai'] = $tanggal_mulai;
            $pekerjaan['tgl_selesai'] = $tanggal_selesai;
            if (in_array($kategori_pakerjaan, array('project', 'tambahan', 'kreativitas'))) {
                $pekerjaan['kategori'] = $kategori_pakerjaan;
                if ($kategori_pakerjaan == 'kreativitas') {
                    if (!in_array($level_manfaat, array(1, 2, 3))) {
                        $level_manfaat = 1;
                    }
                    $pekerjaan['level_manfaat'] = $level_manfaat;
                }
            } else {
                redirect(site_url() . '/pekerjaan_staff');
                return;
            }
            $date1 = new DateTime($tanggal_mulai);
            $date2 = new DateTime($tanggal_selesai);
//            $t1=new DateInterval('P2D');
//            $date2->add($t1);
            $interval = $date1->diff($date2);
            $bulan = $interval->m;
            if ($interval->y > 0) {
                $bulan+=($interval->y * 12);
            }
            if ($interval->d > 0) {
                $bulan++;
            }
            print_r($date1);
            print_r($date2);
            print_r($interval);
        }
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'European'");

        if (count($list_id_staff_enroll) > 0) {
            $this->db->insert('pekerjaan', $pekerjaan);
            $id_pekerjaan = $this->db->insert_id();
            $this->load->library(array('myuploadlib'));
            $uploader = new MyUploadLib();
            $uploader->prosesUpload('berkas');
            $uploadedFiles = $uploader->getUploadedFiles();
            foreach ($uploadedFiles as $file) {
                $sql = "insert into file (id_pekerjaan,nama_file,waktu, path) values ($id_pekerjaan,'" . $file['name'] . "',now(),'" . $file['filePath'] . "')";
                $this->db->query($sql);
            }
            $pekerjaan_rutin = $kategori_pakerjaan == 'rutin';
            $pekerjaan_project = $kategori_pakerjaan == 'project';
            foreach ($list_id_staff_enroll as $id_staff) {
                $detil_pekerjaan = array(
                    'id_pekerjaan' => $id_pekerjaan,
                    'id_akun' => $id_staff
                );
                if ($pekerjaan_rutin || $pekerjaan_project) {
                    $detil_pekerjaan['sasaran_angka_kredit'] = $angka_kredit;
                    $detil_pekerjaan['sasaran_kuantitas_output'] = $kuantitas_output;
                    $detil_pekerjaan['sasaran_kualitas_mutu'] = $kualitas_mutu;
                    $detil_pekerjaan['sasaran_biaya'] = $biaya;
                    $detil_pekerjaan['satuan_kuantitas'] = $satuan_kuantitas;
                    if ($pekerjaan_rutin) {
                        $detil_pekerjaan['sasaran_waktu'] = 12;
                    } else {
                        $detil_pekerjaan['sasaran_waktu'] = $bulan;
                    }
                } else {
                    
                }
                $this->db->insert('detil_pekerjaan', $detil_pekerjaan);
            }
            $this->db->trans_complete();
            redirect(site_url() . '/pekerjaan_staff/detail?id_pekerjaan=' . $id_pekerjaan);
            echo "tersimpan";
        } else {
            $this->db->trans_rollback();
            echo "rollback";
            redirect(site_url() . '/pekerjaan_staff');
        }
    }

//    function add_skp() {
//        $session = $this->session->userdata('logged_in');
//        $list_id_staff_enroll = $this->input->post('staff_enroll');
//        if (!is_array($list_id_staff_enroll)) {
//            redirect(site_url() . '/pekerjaan_staff');
//            return;
//        }
//        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
//        $nama_pekerjaan = $this->input->post('nama_pkj');
//        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
//        $periode = abs(intval($this->input->post('periode')));
//        $prioritas = (int) $this->input->post('prioritas');
//        $list_staff = $this->akun->my_staff($session["user_id"]);
//        $angka_kredit = abs(floatval($this->input->post('angka_kredit')));
//        $kuantitas_output = abs(floatval($this->input->post('kuantitas_output')));
//        $kualitas_mutu = abs(floatval($this->input->post('kualitas_mutu')));
//        $biaya = abs(floatval($this->input->post('biaya')));
//        $pakai_biaya = abs(intval($this->input->post('pakai_biaya')));
//        $satuan_kuantitas = $this->input->post('satuan_kuantitas');
//        $list_id_staff = array();
//        $list_staff2 = array();
//        foreach ($list_staff as $staff) {
//            $list_id_staff[] = $staff->id_akun;
//            $list_staff2[$staff->id_akun] = $staff;
//        }
//        foreach ($list_id_staff_enroll as $key => $id_staff) {
//            if (!in_array($id_staff, $list_id_staff)) {
//                unset($list_id_staff_enroll[$key]);
//            }
//        }
//        if (!in_array($sifat_pekerjaan, array(1, 2))) {
//            $sifat_pekerjaan = 1;
//        }
//        $pekerjaan = array(
//            'id_sifat_pekerjaan' => $sifat_pekerjaan,
//            'nama_pekerjaan' => $nama_pekerjaan,
//            'deskripsi_pekerjaan' => $deskripsi_pekerjaan,
//            'periode' => $periode,
//            'asal_pekerjaan' => 'taskmanagement',
//            'level_prioritas' => $prioritas,
//            'kategori' => 'skp',
//            'id_penanggung_jawab' => $session['user_id'],
//            'status_pekerjaan' => 7
//        );
//        $this->db->trans_begin();
//        $this->db->query("set datestyle to 'European'");
//        $this->db->insert('pekerjaan', $pekerjaan);
//        $id_pekerjaan = $this->db->insert_id();
//        if (count($list_id_staff_enroll) > 0) {
//            require_once APPPATH . '/libraries/my_email.php';
////            $eml = new my_email();
//            foreach ($list_id_staff_enroll as $id_staff) {
//                $this->db->query("insert into detil_pekerjaan (id_pekerjaan,id_akun, sasaran_angka_kredit,"
//                        . " sasaran_kuantitas_output, sasaran_kualitas_mutu,sasaran_waktu, sasaran_biaya, pakai_biaya,"
//                        . " satuan_kuantitas, satuan_waktu) values ($id_pekerjaan,$id_staff, $angka_kredit,"
//                        . "$kuantitas_output, $kualitas_mutu,12, $biaya, $pakai_biaya, '$satuan_kuantitas', 'bulan')");
//                //$eml->kirim_email($list_staff2[$id_staff]->email, 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
//                //$eml->kirim_email('mohammad.zarkasi@gmail.com', 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
//            }
//            $this->db->trans_complete();
//            redirect(site_url() . '/pekerjaan_staff/detail_skp?id_pekerjaan=' . $id_pekerjaan);
//            echo "tersimpan";
//        } else {
//            $this->db->trans_rollback();
//            echo "rollback";
//            redirect(site_url() . '/pekerjaan_staff');
//        }
//    }

    function batalkan() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $id_staff_c = abs(intval($this->input->get('id_staff')));
        $session = $this->session->userdata('logged_in');
        $this->db->trans_begin();
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $pekerjaan = null;
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        if ($pekerjaan['id_penanggung_jawab'] != $session['user_id']) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        $list_id_staff = array();
        $q = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        foreach ($q as $dp) {
            $list_id_staff[] = $dp['id_akun'];
        }
        foreach ($list_id_staff as $id_staff) {
            $this->db->query("delete from aktivitas_pekerjaan where id_pekerjaan='$id_pekerjaan' and id_akun='$id_staff'");
        }
        $q = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan'")->result_array();
        foreach ($q as $f) {
            unlink($f['path']);
        }
        //$this->db->query("delete from file where id_pekerjaan='$id_pekerjaan'");
        $this->db->query("delete from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'");
        $this->db->query("delete from pekerjaan where id_pekerjaan='$id_pekerjaan'");
        $this->db->trans_complete();
        redirect(site_url() . '/pekerjaan_staff/staff?id_staff=' . $id_staff_c);
    }

    function update() {
        $id_pekerjaan = intval($this->input->post('id_pekerjaan'));
        $session = $this->session->userdata('logged_in');
        $list_id_staff_enroll = $this->input->post('staff_enroll');
        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
        $nama_pekerjaan = $this->input->post('nama_pkj');
        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
        $periode = abs(intval($this->input->post('periode')));
        $tanggal_mulai = $this->input->post('tgl_mulai');
        $tanggal_selesai = $this->input->post('tgl_selesai');
        $prioritas = (int) $this->input->post('prioritas');
        $angka_kredit = abs(floatval($this->input->post('angka_kredit')));
        $kuantitas_output = abs(floatval($this->input->post('kuantitas_output')));
        $kualitas_mutu = abs(floatval($this->input->post('kualitas_mutu')));
        $biaya = abs(floatval($this->input->post('biaya')));
        $pakai_biaya = abs(intval($this->input->post('pakai_biaya')));
        $satuan_kuantitas = $this->input->post('satuan_kuantitas');
        $kategori_pakerjaan = $this->input->post('kategori_pekerjaan');
        if (!is_array($list_id_staff_enroll)) {
            redirect(site_url() . '/pekerjaan_staff');
            return;
        }
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            header('refresh:1;url=' . site_url() . '/pekerjaan_staff');
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        $pekerjaan = $q[0];
        if ($pekerjaan['id_penanggung_jawab'] != $session['user_id']) {
            header('refresh:1;url=' . site_url() . '/pekerjaan_staff');
            echo 'Anda tidak berhak mengubah pekerjaan ini';
            return;
        }
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $list_id_staff = array();
        $list_staff2 = array();
        foreach ($list_staff as $staff) {
            $list_id_staff[] = $staff->id_akun;
            $list_staff2[$staff->id_akun] = $staff;
        }
        $detil_pekerjaan = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();

        foreach ($list_id_staff_enroll as $key => $id_staff) {
            if (!in_array($id_staff, $list_id_staff)) {
                //jika id akun yg disubmit tidak termasuk ke dalam list staff
                unset($list_id_staff_enroll[$key]);
            }
        }
        $list_id_detil_pekerjaan_update = array();
        $list_id_detil_pekerjaan_hapus = array();
        foreach ($detil_pekerjaan as $dp) {
            if (in_array($dp['id_akun'], $list_id_staff_enroll)) {
                $list_id_detil_pekerjaan_update[] = $dp['id_akun'];
            } else {
                //id akun pada detil pekerjaan lama tidak terdapat pada list staff yg diberi pekerjaan,
                //sehingga perlu dihapus
                $list_id_detil_pekerjaan_hapus[] = $dp['id_akun'];
            }
        }
        if (!in_array($sifat_pekerjaan, array(1, 2))) {
            $sifat_pekerjaan = 1;
        }
        $pekerjaan = array(
            'id_sifat_pekerjaan' => $sifat_pekerjaan,
            'nama_pekerjaan' => $nama_pekerjaan,
            'deskripsi_pekerjaan' => $deskripsi_pekerjaan,
            'asal_pekerjaan' => 'taskmanagement',
            'level_prioritas' => $prioritas,
            'id_penanggung_jawab' => $session['user_id'],
            'status_pekerjaan' => 7
        );
        $bulan = 0;
        if ($kategori_pakerjaan == 'rutin') {
            $pekerjaan['periode'] = $periode;
            $pekerjaan['tgl_mulai'] = $periode . "-1-1";
            $pekerjaan['tgl_selesai'] = $periode . "-12-31";
            $pekerjaan['kategori'] = 'rutin';
        } else {
            $pekerjaan['tgl_mulai'] = $tanggal_mulai;
            $pekerjaan['tgl_selesai'] = $tanggal_selesai;
            if (in_array($kategori_pakerjaan, array('project', 'tambahan', 'kreativitas'))) {
                $pekerjaan['kategori'] = $kategori_pakerjaan;
            } else {
                redirect(site_url() . '/pekerjaan_staff');
                return;
            }
            $date1 = new DateTime($tanggal_mulai);
            $date2 = new DateTime($tanggal_selesai);
            $interval = $date1->diff($date2);
            $bulan = $interval->m;
            if ($interval->y > 0) {
                $bulan+=($interval->y * 12);
            }
            if ($interval->d > 0) {
                $bulan++;
            }
            print_r($date1);
            print_r($date2);
            print_r($interval);
        }
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'European'");

        if (count($list_id_staff_enroll) > 0 || count()) {
            $this->db->update('pekerjaan', $pekerjaan, array('id_pekerjaan' => $id_pekerjaan));
            $this->load->library(array('myuploadlib'));
            $uploader = new MyUploadLib();
            $uploader->prosesUpload('berkas');
            $uploadedFiles = $uploader->getUploadedFiles();
            foreach ($uploadedFiles as $file) {
                $sql = "insert into file (id_pekerjaan,nama_file,waktu, path) values ($id_pekerjaan,'" . $file['name'] . "',now(),'" . $file['filePath'] . "')";
                $this->db->query($sql);
            }
            $pekerjaan_rutin = $kategori_pakerjaan == 'rutin';
            $pekerjaan_project = $kategori_pakerjaan == 'project';
            foreach ($list_id_staff_enroll as $id_staff) {
                $detil_pekerjaan = array(
                    'id_pekerjaan' => $id_pekerjaan,
                    'id_akun' => $id_staff
                );
                if ($pekerjaan_rutin || $pekerjaan_project) {
                    $detil_pekerjaan['sasaran_angka_kredit'] = $angka_kredit;
                    $detil_pekerjaan['sasaran_kuantitas_output'] = $kuantitas_output;
                    $detil_pekerjaan['sasaran_kualitas_mutu'] = $kualitas_mutu;
                    $detil_pekerjaan['sasaran_biaya'] = $biaya;
                    $detil_pekerjaan['satuan_kuantitas'] = $satuan_kuantitas;
                    if ($pekerjaan_rutin) {
                        $detil_pekerjaan['sasaran_waktu'] = 12;
                    } else {
                        $detil_pekerjaan['sasaran_waktu'] = $bulan;
                    }
                } else {
                    
                }
                if (in_array($id_staff, $list_id_detil_pekerjaan_update)) {
                    $this->db->update('detil_pekerjaan', $detil_pekerjaan, array('id_pekerjaan' => $id_pekerjaan, 'id_akun' => $id_staff));
                } else {
                    $this->db->insert('detil_pekerjaan', $detil_pekerjaan);
                }
            }
            foreach ($list_id_detil_pekerjaan_hapus as $id_akun) {
                $this->db->delete('detil_pekerjaan', array('id_pekerjaan' => $id_pekerjaan, 'id_akun' => $id_akun));
            }
            $this->db->trans_complete();
            redirect(site_url() . '/pekerjaan_staff/detail?id_pekerjaan=' . $id_pekerjaan);
            echo "tersimpan";
        } else {
            $this->db->trans_rollback();
            echo "rollback";
            redirect(site_url() . '/pekerjaan_staff');
        }
    }

    function hapus_file() {
        $id_file = abs(intval($this->input->get('id_file')));
        $session = $this->session->userdata('logged_in');
        $q = $this->db->query("select * from file where id_file='$id_file'")->result_array();
        $berkas = null;
        $pekerjaan = null;
        $detil_pekerjaan = null;
        $berhak = false;
        if (count($q) > 0) {
            $berkas = $q[0];
        }
        if ($berkas == null) {
            echo "Dokumen tidak dapat ditemukan";
            return;
        }
        $id_pekerjaan = $berkas['id_pekerjaan'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            echo "Pekerjaan tidak dapat ditemukan";
            return;
        }
        if ($pekerjaan['id_penanggung_jawab'] != $session['user_id']) {
            echo "Anda tidak berhak menghapus berkas di pekerjaan ini";
            return;
        }
        $this->db->query("delete from file where id_file='$id_file'");
        unlink($berkas['path']);
        echo "OK";
    }

    function get_list_tugas_tambahan() {
        $session = $this->session->userdata('logged_in');
        $periode = abs(intval($this->input->post('periode')));
        $id_staff = (int) $this->input->post('id_staff');
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $staff_valid = false;
        $staff = null;
        foreach ($list_staff as $s) {
            if ($s->id_akun == $id_staff) {
                $staff = $s;
                break;
            }
        }
        $result = array();
        if ($staff == null) {
            echo json_encode($result);
            return;
        }
        $my_id = $session['user_id'];
        $this->load->model(array('pekerjaan_staff_model'));
        $result = $this->pekerjaan_staff_model->get_list_tugas_tambahan($my_id, $id_staff, $periode);
        echo json_encode($result);
    }

    function get_list_tugas_kreativitas() {
        $session = $this->session->userdata('logged_in');
        $periode = abs(intval($this->input->post('periode')));
        $id_staff = (int) $this->input->post('id_staff');
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $staff_valid = false;
        $staff = null;
        foreach ($list_staff as $s) {
            if ($s->id_akun == $id_staff) {
                $staff = $s;
                break;
            }
        }
        $result = array();
        if ($staff == null) {
            echo json_encode($result);
            return;
        }
        $my_id = $session['user_id'];
        $this->load->model(array('pekerjaan_staff_model'));
        $result = $this->pekerjaan_staff_model->get_list_tugas_kreativitas($my_id, $id_staff, $periode);
        echo json_encode($result);
    }

    function get_list_skp() {
        $session = $this->session->userdata('logged_in');
        $periode = abs(intval($this->input->post('periode')));
        $id_staff = (int) $this->input->post('id_staff');
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $staff_valid = false;
        $staff = null;
        foreach ($list_staff as $s) {
            if ($s->id_akun == $id_staff) {
                $staff = $s;
                break;
            }
        }
        $result = array();
        if ($staff == null) {
            echo json_encode($result);
            return;
        }
        $my_id = $session['user_id'];
        $this->load->model(array('pekerjaan_staff_model'));
        $result = $this->pekerjaan_staff_model->get_list_skp_staff($my_id, $id_staff, $periode);
        echo json_encode($result);
    }

}
