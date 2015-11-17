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

    function detail() {
        $id_pekerjaan = (int) $this->input->get('id_pekerjaan');
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $pekerjaan = null;
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            redirect(base_url() . 'pekerjaan_staff');
            return;
        }
        $detil_pekerjaan = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $data = array(
            'pekerjaan' => $pekerjaan,
            'detil_pekerjaan' => $detil_pekerjaan
        );
        $url = str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/users/format/json";
        $data["users"] = json_decode(file_get_contents($url));
        $data['data_akun'] = $this->session->userdata('logged_in');
        $this->load->view('pekerjaan_staff/view_detail', $data);
    }

    function staff() {
        $id_staff = (int) $this->input->get('id_staff');
    }

    function add() {
        $session = $this->session->userdata('logged_in');
        $list_id_staff_enroll = $this->input->post('staff_enroll');
//        var_dump($list_id_staff_enroll);
        if (!is_array($list_id_staff_enroll)) {
//            $list_id_staff_enroll=array();
            redirect(base_url() . 'pekerjaan_staff');
            return;
        }
        $sifat_pekerjaan = (int) $this->input->post('sifat_pkj');
        $kategori_pekerjaan = $this->input->post('kategori');
        $nama_pekerjaan = $this->input->post('nama_pkj');
        $deskripsi_pekerjaan = $this->input->post('deskripsi_pkj');
        $tanggal_mulai = $this->input->post('tgl_mulai_pkj');
        $tanggal_selesai = $this->input->post('tgl_selesai_pkj');
        $prioritas = (int) $this->input->post('prioritas');
        $list_staff = $this->akun->my_staff($session["user_id"]);
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
        if (!in_array($kategori_pekerjaan, array('rutin', 'project'))) {
            $kategori_pekerjaan = 'rutin';
        }
        $pekerjaan = array(
            'id_sifat_pekerjaan' => $sifat_pekerjaan,
            'nama_pekerjaan' => $nama_pekerjaan,
            'deskripsi_pekerjaan' => $deskripsi_pekerjaan,
            'tgl_mulai' => $tanggal_mulai,
            'tgl_selesai' => $tanggal_selesai,
            'asal_pekerjaan' => 'taskmanagement',
            'level_prioritas' => $prioritas,
            'flag_usulan' => 2,
            'kategori' => 'rutin',
            'id_penanggung_jawab' => $session['user_id']
        );
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'European'");
        $this->db->insert('pekerjaan', $pekerjaan);
        $id_pekerjaan = $this->db->insert_id();
        if (count($list_id_staff_enroll) > 0) {
            require_once APPPATH . '/libraries/my_email.php';
            $eml = new my_email();
            foreach ($list_id_staff_enroll as $id_staff) {
                $this->db->query("insert into detil_pekerjaan (id_pekerjaan,id_akun) values ($id_pekerjaan,$id_staff)");
                //$eml->kirim_email($list_staff2[$id_staff]->email, 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
                //$eml->kirim_email('mohammad.zarkasi@gmail.com', 'Pekerjaan baru Taskmanagement', "Anda mendapat tugas baru");
            }
            $this->db->trans_complete();
            redirect(base_url() . 'pekerjaan_staff/detail?id_pekerjaan=' . $id_pekerjaan);
            echo "tersimpan";
        } else {
            $this->db->trans_rollback();
            echo "rollback";
        }
    }

}
