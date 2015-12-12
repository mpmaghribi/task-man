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
    
    //untuk data graph di controller pekerjaan saya, fungsi index
    public function vardata() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        $id_akun = $this->session->userdata['logged_in']["user_id"];
        $query = $this->pekerjaan_model->activityjobthismonth($id_akun);
        echo json_encode($query);
    }

//    function detail_tambahan() {
//        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
//        $session = $this->session->userdata('logged_in');
//        $pekerjaan = null;
//        $q = $this->db->query("select * from pekerjaan p inner join sifat_pekerjaan s on s.id_sifat_pekerjaan=p.id_sifat_pekerjaan where p.id_pekerjaan='$id_pekerjaan'")->result_array();
//        if (count($q) > 0) {
//            $pekerjaan = $q[0];
//        }
//        if ($pekerjaan == null) {
//            redirect(site_url() . '/pekerjaan_saya');
//            return;
//        }
//        if($pekerjaan['kategori']!='tambahan'){
//            redirect(site_url() . '/pekerjaan_saya');
//            return;
//        }
//        $detil_pekerjaans = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
//        $detil_pekerjaan = null;
//        foreach ($detil_pekerjaans as $dp) {
//            if ($dp['id_akun'] == $session['user_id']) {
//                $detil_pekerjaan = $dp;
//                break;
//            }
//        }
//        if ($detil_pekerjaan == null) {
//            redirect(site_url() . '/pekerjaan_saya');
//            return;
//        }
//        $data = array(
//            'data_akun' => $session,
//            'pekerjaan' => $pekerjaan,
//            'detil_pekerjaans' => $detil_pekerjaans,
//            'detil_pekerjaan' => $detil_pekerjaan
//        );
//        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
//        $data["users"] = json_decode(file_get_contents($url));
//        $this->mark_read($session['user_id'], $id_pekerjaan);
//        $this->load->view('pekerjaan_saya/view_detail_tambahan', $data);
//    }
//    function detail_kreativitas() {
//        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
//        $session = $this->session->userdata('logged_in');
//        $pekerjaan = null;
//        $q = $this->db->query("select * from pekerjaan p inner join sifat_pekerjaan s on s.id_sifat_pekerjaan=p.id_sifat_pekerjaan where p.id_pekerjaan='$id_pekerjaan'")->result_array();
//        if (count($q) > 0) {
//            $pekerjaan = $q[0];
//        }
//        if ($pekerjaan == null) {
//            redirect(site_url() . '/pekerjaan_saya');
//            return;
//        }
//        if($pekerjaan['kategori']!='kreativitas'){
//            redirect(site_url() . '/pekerjaan_saya');
//            return;
//        }
//        $detil_pekerjaans = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
//        $detil_pekerjaan = null;
//        foreach ($detil_pekerjaans as $dp) {
//            if ($dp['id_akun'] == $session['user_id']) {
//                $detil_pekerjaan = $dp;
//                break;
//            }
//        }
//        if ($detil_pekerjaan == null) {
//            redirect(site_url() . '/pekerjaan_saya');
//            return;
//        }
//        $data = array(
//            'data_akun' => $session,
//            'pekerjaan' => $pekerjaan,
//            'detil_pekerjaans' => $detil_pekerjaans,
//            'detil_pekerjaan' => $detil_pekerjaan
//        );
//        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
//        $data["users"] = json_decode(file_get_contents($url));
//        $this->mark_read($session['user_id'], $id_pekerjaan);
//        $this->load->view('pekerjaan_saya/view_detail_kreativitas', $data);
//    }
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
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["users"] = json_decode(file_get_contents($url));
        $data['aktivitas']=$this->db->query("select * from aktivitas_pekerjaan where id_tugas='$id_tugas'")->result_array();
        $data['file_pendukung_pekerjaan']=$this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_detil_pekerjaan is null and id_progress is null and id_tugas is null and id_aktivitas is null")->result_array();
        $data['file_pendukung_tugas']=$this->db->query("select * from file where id_tugas = '$id_tugas'")->result_array();
        $this->load->view('pekerjaan_saya/view_detail_tugas', $data);
    }

    function detail() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $session = $this->session->userdata('logged_in');
        $pekerjaan = null;
        $q = $this->db->query("select *, to_char(tgl_mulai,'YYYY-MM-DD') as tanggal_mulai, to_char(tgl_selesai,'YYYY-MM-DD') as tanggal_selesai "
                        . "from pekerjaan p "
                        . "inner join sifat_pekerjaan s on s.id_sifat_pekerjaan=p.id_sifat_pekerjaan "
                        . "where p.id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            redirect(site_url() . '/pekerjaan_saya');
            return;
        }

        $detil_pekerjaans = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $detil_pekerjaan = null;
        foreach ($detil_pekerjaans as $dp) {
            if ($dp['id_akun'] == $session['user_id']) {
                $detil_pekerjaan = $dp;
                break;
            }
        }
        if ($detil_pekerjaan == null) {
            redirect(site_url() . '/pekerjaan_saya');
            return;
        }
        $id_detil_pekerjaan = $detil_pekerjaan['id_detil_pekerjaan'];
        $list_file_pendukung = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_progress is null")->result_array();
        $list_file_progress = $this->db->query("select * from file where id_pekerjaan='$id_pekerjaan' and id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
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

    public function get_list_skp_saya() {
        $this->load->model(array('pekerjaan_saya_model'));
        $session = $this->session->userdata('logged_in');
        $periode = abs(intval($this->input->post('periode')));
        echo json_encode($this->pekerjaan_saya_model->get_list_skp_saya($session['user_id'], $periode));
    }

    function get_list_tugas() {
        $periode = abs(intval($this->input->get('periode')));
        $session = $this->session->userdata('logged_in');
        $my_id = $session['user_id'];
        $q = $this->db->query("select assign_tugas.*, "
                        . "pekerjaan.nama_pekerjaan, "
                        . "aktivitas_pekerjaan.id_aktivitas, aktivitas_pekerjaan.status_validasi as status_validasi_aktivitas, "
                        . "to_char(assign_tugas.tanggal_mulai,'YYYY-MM-DD') as tanggal_mulai2,"
                        . "to_char(assign_tugas.tanggal_selesai,'YYYY-MM-DD') as tanggal_selesai2 "
                        . "from assign_tugas "
                        . "inner join pekerjaan on pekerjaan.id_pekerjaan=assign_tugas.id_pekerjaan "
                        . "inner join detil_pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan and detil_pekerjaan.id_akun='$my_id' "
                        . "left join aktivitas_pekerjaan on aktivitas_pekerjaan.id_detil_pekerjaan=detil_pekerjaan.id_detil_pekerjaan and assign_tugas.id_assign_tugas=aktivitas_pekerjaan.id_tugas "
                        . "where '$my_id'=any(assign_tugas.id_akun) "
                        . "and date_part('year',assign_tugas.tanggal_mulai)='$periode'")->result_array();
        echo json_encode($q);
    }

    private function mark_read($id_akun, $id_pekerjaan) {
        $this->db->query("update detil_pekerjaan set tgl_read=now() where id_akun='$id_akun' and id_pekerjaan='$id_pekerjaan' and tgl_read is null");
    }

}
