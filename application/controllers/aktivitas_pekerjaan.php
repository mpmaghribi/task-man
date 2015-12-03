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

    private function add() {
        $this->load->library(array('myuploadlib'));
        $id_pekerjaan = (int) $this->input->post('id_pekerjaan');
        $id_akun = (int) $this->input->post('id_akun');
        $keterangan = $this->input->post('keterangan');
        $kuantitas_output = abs((double) $this->input->post('kuantitas_output'));
        $kualitas_mutu = abs((double) $this->input->post('kualitas_mutu'));
        $waktu_mulai = $this->input->post('waktu_mulai');
        $waktu_selesai = $this->input->post('waktu_selesai');
        $biaya = abs((double) $this->input->post('biaya'));
        $ak = abs((double) $this->input->post('ak'));
        $nilai_progress = intval($this->input->post('nilai_progress'));
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        $pekerjaan = null;
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            return 'Pekerjaan tidak dapat ditemukan';
        }
        $q = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan' and id_akun='$id_akun'")->result_array();
        $detil_pekerjaan = null;
        if (count($q) > 0) {
            $detil_pekerjaan = $q[0];
        }
        if ($detil_pekerjaan == null) {
            return 'Anda tidak termasuk dalam anggota staff yang mengerjakan pekerjaan ini';
        }
        $this->db->query("set datestyle to 'European'");
        $this->db->trans_begin();
//        $sql = "insert into aktivitas_pekerjaan (id_pekerjaan, id_akun, keterangan, angka_kredit, kuantitas_output, kualitas_mutu,"
//                . " waktu_mulai, waktu_selesai, biaya, status_validasi, tanggal_transaksi) values ($id_pekerjaan, $id_akun, "
//                . "'$keterangan', $ak, $kuantitas_output, $kualitas_mutu, '$waktu_mulai', '$waktu_selesai', $biaya, 0, now())";
        $uploader = new MyUploadLib();

        if (in_array($pekerjaan['kategori'], array('rutin', 'project'))) {
            $aktivitas = array(
                'id_pekerjaan' => $id_pekerjaan,
                'id_detil_pekerjaan' => $detil_pekerjaan['id_detil_pekerjaan'],
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'kuantitas_output' => $kuantitas_output,
                'kualitas_mutu' => $kualitas_mutu,
                'angka_kredit' => $ak,
                'keterangan' => $keterangan
            );
            if ($detil_pekerjaan['pakai_biaya'] == '1') {
                $aktivitas['biaya'] = $biaya;
            }
            $this->db->insert('aktivitas_pekerjaan', $aktivitas);
            $id_aktivitas = $this->db->insert_id();
            $uploader->prosesUpload('berkas_aktivitas');
            $uploadedFiles = $uploader->getUploadedFiles();
            foreach ($uploadedFiles as $file) {
                $berkas = array(
                    'id_pekerjaan' => $id_pekerjaan,
                    'id_detil_pekerjaan' => $detil_pekerjaan['id_detil_pekerjaan'],
                    'id_aktivitas' => $id_aktivitas,
                    'nama_file' => $file['name'],
                    'path' => $file['filePath']
                );
                $this->db->insert('file', $berkas);
            }
        } else {
            $aktivitas = array(
                'id_pekerjaan' => $id_pekerjaan,
                'id_detil_pekerjaan' => $detil_pekerjaan['id_detil_pekerjaan'],
                'deskripsi' => $keterangan,
                'progress' => $nilai_progress,
                'total_progress' => 100,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai
            );
            $this->db->insert('detil_progress', $aktivitas);
            $id_progress = $this->db->insert_id();
            $uploader->prosesUpload('berkas_aktivitas');
            $uploadedFiles = $uploader->getUploadedFiles();
            foreach ($uploadedFiles as $file) {
                $berkas = array(
                    'id_pekerjaan' => $id_pekerjaan,
                    'id_detil_pekerjaan' => $detil_pekerjaan['id_detil_pekerjaan'],
                    'id_progress' => $id_progress,
                    'nama_file' => $file['name'],
                    'path' => $file['filePath']
                );
                $this->db->insert('file', $berkas);
            }
//            $id_detil_pekerjaan = $detil_pekerjaan['id_detil_pekerjaan'];
//            $sql = "select * from detil_progress where id_detil_pekerjaan='$id_detil_pekerjaan' order by waktu_mulai desc limit 1";
//            $q = $this->db->query($sql)->result_array();
//            if (count($q) > 0) {
//                $last = $q[0];
//                $this->db->update('detil_pekerjaan', array('progress' => $last['progress']), array('id_detil_pekerjaan' => $id_detil_pekerjaan));
//            }
        }
//        $this->db->query($sql);
        $this->mark_started($detil_pekerjaan['id_detil_pekerjaan']);
        $this->db->trans_complete();
        return 'ok';
    }

    private function mark_started($id_detil_pekerjaan = 0) {
        $this->db->query("update detil_pekerjaan set tglasli_mulai=now() where id_detil_pekerjaan='$id_detil_pekerjaan' and tglasli_mulai is null");
    }

    function add_v1() {
        echo $this->add();
    }

    function add_v2() {
        $res = $this->add();
        echo '<html><head></head><body><script>';
        if ($res == 'ok') {
            echo 'parent.refreshAktivitas();';
        } else {
            echo 'parent.alert("' . $res . '");';
        }
        echo '</script></body></html>';
    }

    function hapus_aktivitas() {
        $id_aktivitas = intval($this->input->post('id_aktivitas'));
        $q = $this->db->query("select * from aktivitas_pekerjaan where id_aktivitas='$id_aktivitas'")->result_array();
        if (count($q) <= 0) {
            echo 'Aktivitas tidak dapat ditemukan';
            return;
        }
        $aktivitas = $q[0];
        $id_pekerjaan = $aktivitas['id_pekerjaan'];
        $id_detil_pekerjaan = $aktivitas['id_detil_pekerjaan'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        $pekerjaan = $q[0];
        $session = $this->session->userdata('logged_in');
        if ($session['user_id'] == $pekerjaan['id_penanggung_jawab']) {
            //user adalaha penanggung jawab, berhak
        } else {
            $q = $this->db->query("select * from detil_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
            if (count($q) <= 0) {
                echo 'Detil Pekerjaan tidak dapat ditemukan';
                return;
            }
            $detil_pekerjaan = $q[0];
            if ($detil_pekerjaan['id_akun'] != $session['user_id']) {
                echo 'Anda tidak berhak menghapus aktivitas pekerjaan orang lain';
                return;
            }
            if ($aktivitas['status_validasi'] == 1) {
                echo 'Anda tidak berhak menghapus aktivitas yang telah divalidasi';
                return;
            }
        }
        $this->db->trans_begin();
        $list_file = $this->db->query("select * from file where id_aktivitas='$id_aktivitas'")->result_array();
        foreach ($list_file as $f) {
            if (file_exists($f['path'])) {
                unlink($f['path']);
            }
        }
        $this->db->query("delete from file where id_aktivitas='$id_aktivitas'");
        $this->db->query("delete from aktivitas_pekerjaan where id_aktivitas='$id_aktivitas'");
        
        $q = $this->db->query("select coalesce(sum(kuantitas_output),0) as jumlah from aktivitas_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan' and status_validasi='1'")->result_array();
        $total_kuantitas = 0;
        if (count($q) > 0) {
            $kuant = $q[0];
            $total_kuantitas = $kuant['jumlah'];
        }
        $this->db->query("update detil_pekerjaan set realisasi_kuantitas_output='$total_kuantitas' where id_detil_pekerjaan='$id_detil_pekerjaan'");
        
        $this->db->trans_complete();
        echo 'ok';
    }

    function hapus_progress() {
        $id_progress = intval($this->input->post('id_progress'));
        $q = $this->db->query("select * from detil_progress where id_detil_progress='$id_progress'")->result_array();
        $detil_progress = null;
        if (count($q) > 0) {
            $detil_progress = $q[0];
        }
        if ($detil_progress == null) {
            echo 'progress tidak dapat ditemukan';
            return;
        }
        $id_pekerjaan = $detil_progress['id_pekerjaan'];
        $id_detil_pekerjaan = $detil_progress['id_detil_pekerjaan'];
        $session = $this->session->userdata('logged_in');
        $q = $this->db->query("select * from detil_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
        $detil_pekerjaan = null;
        $pekerjaan = null;
        if (count($q) > 0) {
            $detil_pekerjaan = $q[0];
        }
        if ($detil_pekerjaan == null) {
            echo 'detil pekerjaan tidak dapat ditemukan';
            return;
        }
        if ($detil_pekerjaan['id_akun'] == $session['user_id']) {
            if ($detil_progress['validated'] == 0) {
                
            } else {
                echo 'progress yg telah divalidasi tidak dapat dihapus';
                return;
            }
        } else {
            $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
            if (count($q) > 0) {
                $pekerjaan = $q[0];
            }
            if ($pekerjaan == null) {
                echo 'Pekerjaan tidak dapat ditemukan';
                return;
            }
            if ($pekerjaan['id_penanggung_jawab'] == $session['user_id']) {
                
            } else {
                echo 'Anda tidak berhak menghapus progress di pekerjaan ini';
                return;
            }
        }
        $this->db->trans_begin();
        $list_berkas = $this->db->query("select * from file where id_progress='$id_progress'")->result_array();
        foreach ($list_berkas as $berkas) {
            if (file_exists($berkas['path'])) {
                unlink($berkas['path']);
            }
        }
        $this->db->query("delete from file where id_progress='$id_progress'");
        $this->db->query("delete from detil_progress where id_detil_progress='$id_progress'");

        $sql = "select * from detil_progress where id_detil_pekerjaan='$id_detil_pekerjaan' and validated=1 order by waktu_mulai desc limit 1";
        $q = $this->db->query($sql)->result_array();
        if (count($q) > 0) {
            $last = $q[0];
            $this->db->update('detil_pekerjaan', array('progress' => $last['progress']), array('id_detil_pekerjaan' => $id_detil_pekerjaan));
        } else {
            $this->db->update('detil_pekerjaan', array('progress' => 0), array('id_detil_pekerjaan' => $id_detil_pekerjaan));
        }

        $this->db->trans_complete();
        echo 'ok';
    }

    function validate_aktivitas() {
        $id_aktivitas = intval($this->input->post('id_aktivitas'));
        $q = $this->db->get_where('aktivitas_pekerjaan', array('id_aktivitas' => $id_aktivitas))->result_array();
        if (count($q) <= 0) {
            echo 'Aktivitas tidak dapat ditemukan';
            return;
        }
        $aktivitas = $q[0];
        $id_detil_pekerjaan = $aktivitas['id_detil_pekerjaan'];
        $id_pekerjaan = $aktivitas['id_pekerjaan'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        $pekerjaan = $q[0];
        $session = $this->session->userdata('logged_in');
        if ($session['user_id'] != $pekerjaan['id_penanggung_jawab']) {
            echo 'Anda tidak berhak memvalidasi aktivitas';
            return;
        }
        $this->db->trans_begin();
        $this->db->query("update aktivitas_pekerjaan set status_validasi='1' where id_aktivitas='$id_aktivitas'");

        $q = $this->db->query("select coalesce(sum(kuantitas_output),0) as jumlah from aktivitas_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan' and status_validasi='1'")->result_array();
        $total_kuantitas = 0;
        if (count($q) > 0) {
            $kuant = $q[0];
            $total_kuantitas = $kuant['jumlah'];
        }
        $this->db->query("update detil_pekerjaan set realisasi_kuantitas_output='$total_kuantitas' where id_detil_pekerjaan='$id_detil_pekerjaan'");
        $this->db->trans_complete();
        echo 'ok';
    }

    function validate_progress() {
        $id_progress = intval($this->input->post('id_progress'));
        $q = $this->db->query("select * from detil_progress where id_detil_progress='$id_progress'")->result_array();
        $detil_progress = null;
        if (count($q) > 0) {
            $detil_progress = $q[0];
        }
        if ($detil_progress == null) {
            echo 'progress tidak dapat ditemukan';
            return;
        }
        $id_pekerjaan = $detil_progress['id_pekerjaan'];
        $id_detil_pekerjaan = $detil_progress['id_detil_pekerjaan'];
        $session = $this->session->userdata('logged_in');
        $pekerjaan = null;
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) > 0) {
            $pekerjaan = $q[0];
        }
        if ($pekerjaan == null) {
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        if ($pekerjaan['id_penanggung_jawab'] == $session['user_id']) {
            
        } else {
            echo 'Anda tidak berhak menghapus progress di pekerjaan ini';
            return;
        }

        $this->db->trans_begin();
        $this->db->update('detil_progress', array('validated' => 1, 'validated_by' => $session['user_id']), array('id_detil_progress' => $id_progress));
        $id_detil_pekerjaan = $detil_progress['id_detil_pekerjaan'];

        $sql = "select * from detil_progress where id_detil_pekerjaan='$id_detil_pekerjaan' and validated=1 order by waktu_mulai desc limit 1";
        $q = $this->db->query($sql)->result_array();
        if (count($q) > 0) {
            $last = $q[0];
            $this->db->update('detil_pekerjaan', array('progress' => $last['progress']), array('id_detil_pekerjaan' => $id_detil_pekerjaan));
            if ($last['progress'] >= 100) {
                $this->mark_finished($id_detil_pekerjaan);
            }
        } else {
            $this->db->update('detil_pekerjaan', array('progress' => 0), array('id_detil_pekerjaan' => $id_detil_pekerjaan));
        }

        $this->db->trans_complete();
        echo 'ok';
    }

    private function mark_finished($id_detil_pekerjaan = 0) {
        $this->db->query("update detil_pekerjaan set tglasli_selesai=now() where id_detil_pekerjaan='$id_detil_pekerjaan' and tglasli_selesai is null");
    }

    function get_list_aktivitas_pekerjaan() {
        $id_pekerjaan = (int) $this->input->post('id_pekerjaan');
        $id_detil_pekerjaan = (int) $this->input->post('id_detil_pekerjaan');
        echo json_encode($this->aktivitas_model->get_list_aktivitas_pekerjaan_datatable($id_pekerjaan, $id_detil_pekerjaan, $_POST));
    }

    function get_list_progress_pekerjaan_datatable() {
        $id_pekerjaan = (int) $this->input->post('id_pekerjaan');
        $id_detil_pekerjaan = (int) $this->input->post('id_detil_pekerjaan');
        echo json_encode($this->aktivitas_model->get_list_progress_pekerjaan_datatable($id_pekerjaan, $id_detil_pekerjaan, $_POST));
    }

}
