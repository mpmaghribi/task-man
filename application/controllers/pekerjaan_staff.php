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

    function detail_skp() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        if ($pekerjaan == null) {
            redirect(site_url().'/pekerjaan_staff');
            return;
        }
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $detil_pekerjaan = $this->detil_pekerjaan_model->get_detil_pekerjaan($id_pekerjaan);
        $session = $this->session->userdata('logged_in');
        $data = array(
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaan' => $detil_pekerjaan,
            'users' => json_decode(file_get_contents($url)),
            'data_akun' => $session
        );
        $my_id = $session['user_id'];
        $this->mark_read($my_id, $id_pekerjaan);
        $this->load->view('pekerjaan_staff/view_detail', $data);
    }

    private function mark_read($id_akun, $id_pekerjaan) {
        $this->db->query("update detil_pekerjaan set tgl_read=now() where id_akun='$id_akun' and id_pekerjaan='$id_pekerjaan' and tgl_read is null");
    }

    function detail_aktivitas() {
        $session = $this->session->userdata('logged_in');
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $id_staff = (int) $this->input->get('id_staff');
        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        if ($pekerjaan == null) {
            redirect(site_url().'/pekerjaan_staff');
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
            redirect(site_url().'/pekerjaan_staff');
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

    function add_tambahan() {
        $session = $this->session->userdata('logged_in');
        $list_id_staff_enroll = $this->input->post('staff_enroll');
        if (!is_array($list_id_staff_enroll)) {
            redirect(site_url().'/pekerjaan_staff');
            return;
        }
        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
        $nama_pekerjaan = $this->input->post('nama_pkj');
        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
        $periode = abs(intval($this->input->post('periode')));
        $prioritas = (int) $this->input->post('prioritas');
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $angka_kredit = abs(floatval($this->input->post('angka_kredit')));
        $kuantitas_output = abs(floatval($this->input->post('kuantitas_output')));
        $kualitas_mutu = abs(floatval($this->input->post('kualitas_mutu')));
        $biaya = abs(floatval($this->input->post('biaya')));
        $pakai_biaya = abs(intval($this->input->post('pakai_biaya')));
        $satuan_kuantitas = $this->input->post('satuan_kuantitas');
        $tgl_mulai=$this->input->post('tgl_mulai');
        $tgl_selesai=$this->input->post('tgl_selesai');
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
            'kategori' => 'tambahan',
            'id_penanggung_jawab' => $session['user_id'],
            'status_pekerjaan' => 7,
            'tgl_mulai'=>$tgl_mulai,
            'tgl_selesai'=>$tgl_selesai
        );
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'European'");
        $this->db->insert('pekerjaan', $pekerjaan);
        $id_pekerjaan = $this->db->insert_id();
        if (count($list_id_staff_enroll) > 0) {
            require_once APPPATH . '/libraries/my_email.php';
//            $eml = new my_email();
            foreach ($list_id_staff_enroll as $id_staff) {
                $this->db->query("insert into detil_pekerjaan (id_pekerjaan,id_akun) values ($id_pekerjaan,$id_staff)");
                //$eml->kirim_email($list_staff2[$id_staff]->email, 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
                //$eml->kirim_email('mohammad.zarkasi@gmail.com', 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
            }
            $this->db->trans_complete();
            redirect(site_url() . '/pekerjaan_staff/detail_tambahan?id_pekerjaan=' . $id_pekerjaan);
            echo "tersimpan";
        } else {
            $this->db->trans_rollback();
            echo "rollback";
            redirect(site_url() . '/pekerjaan_staff');
        }
    }

    function add_skp() {
        $session = $this->session->userdata('logged_in');
        $list_id_staff_enroll = $this->input->post('staff_enroll');
        if (!is_array($list_id_staff_enroll)) {
            redirect(site_url().'/pekerjaan_staff');
            return;
        }
        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
        $nama_pekerjaan = $this->input->post('nama_pkj');
        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
        $periode = abs(intval($this->input->post('periode')));
        $prioritas = (int) $this->input->post('prioritas');
        $list_staff = $this->akun->my_staff($session["user_id"]);
        $angka_kredit = abs(floatval($this->input->post('angka_kredit')));
        $kuantitas_output = abs(floatval($this->input->post('kuantitas_output')));
        $kualitas_mutu = abs(floatval($this->input->post('kualitas_mutu')));
        $biaya = abs(floatval($this->input->post('biaya')));
        $pakai_biaya = abs(intval($this->input->post('pakai_biaya')));
        $satuan_kuantitas = $this->input->post('satuan_kuantitas');
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
            'periode' => $periode,
            'asal_pekerjaan' => 'taskmanagement',
            'level_prioritas' => $prioritas,
            'kategori' => 'skp',
            'id_penanggung_jawab' => $session['user_id'],
            'status_pekerjaan' => 7
        );
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'European'");
        $this->db->insert('pekerjaan', $pekerjaan);
        $id_pekerjaan = $this->db->insert_id();
        if (count($list_id_staff_enroll) > 0) {
            require_once APPPATH . '/libraries/my_email.php';
//            $eml = new my_email();
            foreach ($list_id_staff_enroll as $id_staff) {
                $this->db->query("insert into detil_pekerjaan (id_pekerjaan,id_akun, sasaran_angka_kredit,"
                        . " sasaran_kuantitas_output, sasaran_kualitas_mutu,sasaran_waktu, sasaran_biaya, pakai_biaya,"
                        . " satuan_kuantitas, satuan_waktu) values ($id_pekerjaan,$id_staff, $angka_kredit,"
                        . "$kuantitas_output, $kualitas_mutu,12, $biaya, $pakai_biaya, '$satuan_kuantitas', 'bulan')");
                //$eml->kirim_email($list_staff2[$id_staff]->email, 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
                //$eml->kirim_email('mohammad.zarkasi@gmail.com', 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
            }
            $this->db->trans_complete();
            redirect(site_url() . '/pekerjaan_staff/detail_skp?id_pekerjaan=' . $id_pekerjaan);
            echo "tersimpan";
        } else {
            $this->db->trans_rollback();
            echo "rollback";
            redirect(site_url() . '/pekerjaan_staff');
        }
    }

    function batalkan() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $session = $this->session->userdata('logged_in');
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $pekerjaan = null;
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            redirect(site_url().'/pekerjaan_staff');
            return;
        }
        if ($pekerjaan['id_penanggung_jawab'] != $session['user_id']) {
            redirect(site_url().'/pekerjaan_staff');
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
        $this->db->query("delete from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'");
        $this->db->query("delete from pekerjaan where id_pekerjaan='$id_pekerjaan'");
        redirect(site_url() . '/pekerjaan_staff');
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
