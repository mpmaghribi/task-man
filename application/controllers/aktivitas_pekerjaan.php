<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aktivitas_pekerjaan
 *
 * @author mozar
 */
require APPPATH . '/libraries/ceklogin.php';

class aktivitas_pekerjaan extends ceklogin {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('aktivitas_model'));
    }

    function add() {
        $id_pekerjaan = (int) $this->input->post('id_pekerjaan');
        $id_akun = (int) $this->input->post('id_akun');
        $keterangan = $this->input->post('keterangan');
        $kuantitas_output = abs((double) $this->input->post('kuantitas_output'));
        $kualitas_mutu = abs((double) $this->input->post('kualitas_mutu'));
        $waktu_mulai = $this->input->post('waktu_mulai');
        $waktu_selesai = $this->input->post('waktu_selesai');
        $biaya = abs((double) $this->input->post('biaya'));
        $ak = abs((double) $this->input->post('ak'));
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $pekerjaan = null;
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        $q = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan' and id_akun='$id_akun'")->result_array();
        $detil_pekerjaan = null;
        if (count($q) > 0) {
            $detil_pekerjaan = $q[0];
        }
        if ($detil_pekerjaan == null) {
            echo 'Anda tidak termasuk dalam anggota staff yang mengerjakan pekerjaan ini';
            return;
        }
        $this->db->query("set datestyle to 'European'");
        $this->db->trans_begin();
        $sql="insert into aktivitas_pekerjaan (id_pekerjaan, id_akun, keterangan, angka_kredit, kuantitas_output, kualitas_mutu,"
                . " waktu_mulai, waktu_selesai, biaya, status_validasi, tanggal_transaksi) values ($id_pekerjaan, $id_akun, "
                . "'$keterangan', $ak, $kuantitas_output, $kualitas_mutu, '$waktu_mulai', '$waktu_selesai', $biaya, 0, now())";
        $this->db->query($sql);
        $this->db->trans_complete();
        echo 'ok';
    }

    function get_list_aktivitas_pekerjaan() {
        $id_pekerjaan = (int) $this->input->post('id_pekerjaan');
        $id_staff = (int) $this->input->post('id_staff');
        echo json_encode($this->aktivitas_model->get_list_aktivitas_pekerjaan_datatable($id_pekerjaan, $id_staff, $_POST));
    }

}
