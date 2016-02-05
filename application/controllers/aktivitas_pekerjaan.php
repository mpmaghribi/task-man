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

    function add_realisasi_tugas_v2() {
        $res = $this->add_realisasi_tugas();
        echo '<html>';
        echo '<head></head>';
        echo '<body>';
        echo '<script>';
        if (is_numeric($res)) {
            $id_aktivitas = $res;
            $q = $this->db->query("select *, to_char(waktu_mulai,'YYYY-MM-DD') as waktu_mulai2, to_char(waktu_selesai,'YYYY-MM-DD') as waktu_selesai2,
					berkas.id_file, berkas.nama_file
					from aktivitas_pekerjaan 
					left join (select json_agg(id_file) as id_file, json_agg(nama_file) as nama_file, id_tugas,id_aktivitas from file group by id_tugas,id_aktivitas) berkas 
					on berkas.id_aktivitas=aktivitas_pekerjaan.id_aktivitas and berkas.id_tugas=aktivitas_pekerjaan.id_tugas
					where aktivitas_pekerjaan.id_aktivitas='$id_aktivitas'")->result_array();
            if (count($q) > 0) {
                echo 'parent.set_my_aktivitas(' . json_encode($q[0]) . ');';
            }
        } else {
            echo 'parent.alert("' . $res . '");';
        }
        echo '</script>';
        echo '</body>';
        echo '</html>';
    }

    private function add_realisasi_tugas() {
        $this->load->model(array('pekerjaan_model', 'detil_pekerjaan_model'));
        $id_tugas = intval($this->input->post('id_tugas'));
        $deskripsi = $this->input->post('deskripsi');
        $waktu_mulai = $this->input->post('waktu_mulai');
        $waktu_selesai = $this->input->post('waktu_selesai');
        $tugas = $this->aktivitas_model->get_tugas_by_id($id_tugas);
        if ($tugas == null) {
            return 'Tugas tidak dapat ditemukan';
        }
//        print_r($tugas);
        $id_pekerjaan = $tugas['id_pekerjaan'];
        $pekerjaan = $this->pekerjaan_model->get_pekerjaan($id_pekerjaan);
        if ($pekerjaan == null) {
            return 'Pekerjaan tidak dapat ditemukan';
        }
//        print_r($pekerjaan);
        $session = $this->session->userdata('logged_in');
        $tugas_list_id_akun = json_decode(str_replace('{', '[', str_replace('}', ']', $tugas['id_akun'])));
        if (in_array($session['id_akun'], $tugas_list_id_akun) == false) {
            return 'Anda tidak terlibat dalam tugas ini';
        }
        $detil_pekerjaan2 = $this->detil_pekerjaan_model->get_detil_pekerjaan($id_pekerjaan);
        $detil_pekerjaan = array();
        foreach ($detil_pekerjaan2 as $dp) {
            $detil_pekerjaan[$dp['id_akun']] = $dp;
        }
        if (isset($detil_pekerjaan[$session['id_akun']]) == false) {
            return 'Anda tidak terlibat dalam Pekerjaan';
        }
        $detil_pekerjaan_saya = $detil_pekerjaan[$session['id_akun']];
        $existing_realisasi = $this->aktivitas_model->get_realisasi_tugas($id_tugas, $detil_pekerjaan_saya['id_detil_pekerjaan']);
        if ($existing_realisasi != null) {
            return 'Anda telah melaksanakan tugas ini sebelumnya';
        }
        $akt = array(
            'id_pekerjaan' => $id_pekerjaan,
            'id_detil_pekerjaan' => $detil_pekerjaan_saya['id_detil_pekerjaan'],
            'kuantitas_output' => 1,
            'id_tugas' => $id_tugas,
            'keterangan' => $deskripsi,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai
        );
        $this->db->query("set datestyle to 'ISO, DMY'");
        $this->db->insert('aktivitas_pekerjaan', $akt);
        $id_aktivitas = $this->db->insert_id();
        $this->load->library(array('myuploadlib'));
        $uploader = new MyUploadLib();
        $uploader->prosesUpload('berkas');
        $uploadedFiles = $uploader->getUploadedFiles();
        foreach ($uploadedFiles as $file) {
            $berkas = array(
                'id_pekerjaan' => $id_pekerjaan,
                'id_detil_pekerjaan' => $detil_pekerjaan_saya['id_detil_pekerjaan'],
                'id_aktivitas' => $id_aktivitas,
                'id_tugas' => $id_tugas,
                'nama_file' => $file['name'],
                'path' => $file['filePath']
            );
            $this->db->insert('file', $berkas);
        }
        return $id_aktivitas;
    }

    private function add() {
        $this->load->library(array('myuploadlib'));
        $id_pekerjaan = (int) $this->input->post('id_pekerjaan');
        $id_akun = (int) $this->input->post('id_akun');
        $keterangan = $this->input->post('keterangan');
        $kuantitas_output = abs((double) $this->input->post('kuantitas_output'));
        $kuantitas_output = 1;
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
        if ($detil_pekerjaan['locked'] == '1') {
            return 'Pekerjaan Anda telah di-lock. Anda tidak bisa menambahkan aktivitas';
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
                'waktu_mulai' => $waktu_mulai . ' 08:00',
                'waktu_selesai' => $waktu_selesai . ' 16:00',
                'kuantitas_output' => $kuantitas_output,
//                'kuantitas_output' => 1,
                'kualitas_mutu' => $kualitas_mutu,
                'angka_kredit' => $ak,
                'keterangan' => $keterangan
            );
            if ($detil_pekerjaan['pakai_biaya'] == '1') {
                $aktivitas['biaya'] = $biaya;
            }
            $this->db->insert('aktivitas_pekerjaan', $aktivitas);
            $id_aktivitas = $this->db->insert_id();
            $uploader->prosesUpload('berkas_aktivitas', date('Y') . '/' . date('m') . '/' . $id_pekerjaan . '/' . $detil_pekerjaan['id_detil_pekerjaan']);
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
                'waktu_mulai' => $waktu_mulai . ' 08:00',
                'waktu_selesai' => $waktu_selesai . ' 16:00'
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

    function addFromPengaduan() {
        $this->load->library(array('myuploadlib'));
        $id_pekerjaan = (int) $this->input->post('id_pekerjaan');
        $id_akun = (int) $this->input->post('id_akun');
        $pre = $this->input->post('keterangan');
        $kode = $this->input->post('kodepengaduan');
        $keterangan = "[Pengaduan " . $kode . ")] " . $pre;

        $kuantitas_output = abs((double) $this->input->post('kuantitas_output'));
        $kuantitas_output = 1;
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
        if ($detil_pekerjaan['locked'] == '1') {
            return 'Pekerjaan Anda telah di-lock. Anda tidak bisa menambahkan aktivitas';
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
                'waktu_mulai' => $waktu_mulai . ' 08:00',
                'waktu_selesai' => $waktu_selesai . ' 16:00',
                'kuantitas_output' => $kuantitas_output,
//                'kuantitas_output' => 1,
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
                'waktu_mulai' => $waktu_mulai . ' 08:00',
                'waktu_selesai' => $waktu_selesai . ' 16:00'
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
        redirect(site_url() . '/pekerjaan/pengaduan');
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

        $this->hitung_nilai_aktivitas($id_detil_pekerjaan);

        $this->db->trans_complete();
        echo 'ok';
    }

    private function hitung_nilai_aktivitas($id_detil_pekerjaan) {
        $q = $this->db->query("select coalesce(sum(kuantitas_output),0) as jumlah from aktivitas_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan' and status_validasi='1'")->result_array();
        $total_kuantitas = 0;
        if (count($q) > 0) {
            $kuant = $q[0];
            $total_kuantitas = $kuant['jumlah'];
        }
        $q = $this->db->query("select * from aktivitas_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan' and status_validasi='1' order by waktu_mulai asc limit 1")->result_array();
        $date1 = null;
        $date2 = null;
        if (count($q) > 0) {
            $w = $q[0];
            $date1 = new DateTime($w['waktu_mulai']);
        }
        $q = $this->db->query("select * from aktivitas_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan' and status_validasi='1' order by waktu_selesai desc limit 1")->result_array();
        if (count($q) > 0) {
            $w = $q[0];
            $date2 = new DateTime($w['waktu_selesai']);
        }
        $waktu_realisasi = 0;
        if ($date1 != null && $date2 != null) {
            $interval = $date1->diff($date2);
            $waktu_realisasi = $interval->m;
            if ($interval->y > 0) {
                $waktu_realisasi +=($interval->y * 12);
            }
            if ($interval->d > 0) {
                $waktu_realisasi++;
            }
        }
        $this->db->query("update detil_pekerjaan set realisasi_kuantitas_output='$total_kuantitas', realisasi_waktu='$waktu_realisasi', progress='0', skor='0' where id_detil_pekerjaan='$id_detil_pekerjaan'");
        $q = $this->db->query("select * from detil_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
        if (count($q) > 0) {
            $detil_pekerjaan = $q[0];
            $persen_waktu = 0;
            if ($detil_pekerjaan['sasaran_waktu'] > 0) {
                $persen_waktu = 100 - (100 * $detil_pekerjaan['realisasi_waktu'] / $detil_pekerjaan['sasaran_waktu']);
            }
            $persen_biaya = 0;
            if ($detil_pekerjaan['pakai_biaya'] == '1' && $detil_pekerjaan['sasaran_biaya'] > 0) {
                $persen_biaya = 100 - (100 * $detil_pekerjaan['realisasi_biaya'] / $detil_pekerjaan['sasaran_biaya']);
            }
            $kuantitas = 0;
            if ($detil_pekerjaan['sasaran_kuantitas_output'] > 0) {
                $kuantitas = 100 * $detil_pekerjaan['realisasi_kuantitas_output'] / $detil_pekerjaan['sasaran_kuantitas_output'];
            }
            $kualitas = 0;
            if ($detil_pekerjaan['sasaran_kualitas_mutu'] > 0) {
                $kualitas = 100 * $detil_pekerjaan['realisasi_kualitas_mutu'] / $detil_pekerjaan['sasaran_kualitas_mutu'];
            }
            $waktu = 0;
            if ($persen_waktu > 24) {
                if ($detil_pekerjaan['sasaran_waktu'] > 0) {
                    $waktu = 76 - ((((1.76 * $detil_pekerjaan['sasaran_waktu'] - $detil_pekerjaan['realisasi_waktu']) / $detil_pekerjaan['sasaran_waktu']) * 100) - 100);
                }
            } else {
                if ($detil_pekerjaan['sasaran_waktu'] > 0) {
                    $waktu = ((1.76 * $detil_pekerjaan['sasaran_waktu'] - $detil_pekerjaan['realisasi_waktu']) / $detil_pekerjaan['sasaran_waktu']) * 100;
                }
            }
            $biaya = 0;
            if ($persen_biaya > 24) {
                if ($detil_pekerjaan['pakai_biaya'] == '1' && $detil_pekerjaan['sasaran_biaya'] > 0) {
                    $waktu = 76 - ((((1.76 * $detil_pekerjaan['sasaran_biaya'] - $detil_pekerjaan['realisasi_biaya']) / $detil_pekerjaan['sasaran_biaya']) * 100) - 100);
                }
            } else {
                if ($detil_pekerjaan['pakai_biaya'] == '1' && $detil_pekerjaan['sasaran_biaya'] > 0) {
                    $waktu = ((1.76 * $detil_pekerjaan['sasaran_biaya'] - $detil_pekerjaan['realisasi_biaya']) / $detil_pekerjaan['sasaran_biaya']) * 100;
                }
            }
            $penghitungan = $waktu + $kuantitas + $kualitas;
            $skor = $penghitungan / 3;
            if ($detil_pekerjaan['pakai_biaya'] == '1') {
                $penghitungan+=$biaya;
                $skor = $penghitungan / 4;
            }
            $this->db->query("update detil_pekerjaan set progress='$penghitungan', skor='$skor' where id_detil_pekerjaan='$id_detil_pekerjaan'");
        }
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

        $this->hitung_nilai_progress($id_detil_pekerjaan);

        $this->db->trans_complete();
        echo 'ok';
    }

    private function hitung_nilai_progress($id_detil_pekerjaan) {
        $sql = "select * from detil_progress where id_detil_pekerjaan='$id_detil_pekerjaan' and validated=1 order by waktu_mulai desc limit 1";
        $q = $this->db->query($sql)->result_array();
        if (count($q) > 0) {
            $last = $q[0];
            $this->db->update('detil_pekerjaan', array('progress' => $last['progress']), array('id_detil_pekerjaan' => $id_detil_pekerjaan));
        } else {
            $this->db->update('detil_pekerjaan', array('progress' => 0), array('id_detil_pekerjaan' => $id_detil_pekerjaan));
        }
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

        $this->hitung_nilai_aktivitas($id_detil_pekerjaan);

        $this->db->trans_complete();
        echo 'ok';
    }

    function validasi_semua_aktivitas() {
        $id_detil_pekerjaan = intval($this->input->post('id_detil_pekerjaan'));
        $session = $this->session->userdata('logged_in');
        $q = $this->db->query("select * from detil_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
//        var_dump($session);
        if (!in_array(12 || 6, $session['idmodul'])) {
            echo 'Anda tidak berhak mengakses fungsionalitas ini';
            return;
        }
        if (count($q) <= 0) {
            echo 'Detil Pekerjaan tidak dapat ditemukan';
            return;
        }
        $detil_pekerjaan = $q[0];
        if ($detil_pekerjaan['locked'] == '1') {
            echo 'Pekerjaan telah di-lock';
            return;
        }
        $id_pekerjaan = $detil_pekerjaan['id_pekerjaan'];
        $id_akun = $detil_pekerjaan['id_akun'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        $pekerjaan = $q[0];
        $this->db->query("update aktivitas_pekerjaan set status_validasi=1 where id_detil_pekerjaan='$id_detil_pekerjaan'");
        $this->hitung_nilai_aktivitas($id_detil_pekerjaan);
        echo 'ok';
    }

    function validasi_semua_progress() {
        $id_detil_pekerjaan = intval($this->input->post('id_detil_pekerjaan'));
        $session = $this->session->userdata('logged_in');
        $q = $this->db->query("select * from detil_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
//        var_dump($session);
        if (!in_array(12 || 6, $session['idmodul'])) {
            echo 'Anda tidak berhak mengakses fungsionalitas ini';
            return;
        }
        if (count($q) <= 0) {
            echo 'Detil Pekerjaan tidak dapat ditemukan';
            return;
        }
        $detil_pekerjaan = $q[0];
        if ($detil_pekerjaan['locked'] == '1') {
            echo 'Pekerjaan telah di-lock';
            return;
        }
        $id_pekerjaan = $detil_pekerjaan['id_pekerjaan'];
        $id_akun = $detil_pekerjaan['id_akun'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            echo 'Pekerjaan tidak dapat ditemukan';
            return;
        }
        $pekerjaan = $q[0];
        $my_id = $session['user_id'];
        $this->db->query("update detil_progress set validated=1, validated_by='$my_id' where id_detil_pekerjaan='$id_detil_pekerjaan'");
        $this->hitung_nilai_progress($id_detil_pekerjaan);
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

        $this->hitung_nilai_progress($id_detil_pekerjaan);

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

    function get_list_file_progress_pekerjaan_datatable() {
        $id_detil_pekerjaan = intval($this->input->post('id_detil_pekerjaan'));
        $q = $this->db->query("select * from detil_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            echo 'detil pekerjaan tidak dapat ditemukan';
            return;
        }
        $detil_pekerjaan = $q[0];
        $id_pekerjaan = $detil_pekerjaan['id_pekerjaan'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            echo 'pekerjaan tidak dapat ditemukan';
            return;
        }
        $pekerjaan = $q[0];
        $this->load->model(array('berkas_model'));
        if (in_array($pekerjaan['kategori'], array('rutin', 'project'))) {
            echo json_encode($this->berkas_model->get_list_file_aktivitas_datatable($id_detil_pekerjaan));
        } else {
            echo json_encode($this->berkas_model->get_list_file_progress_datatable($id_detil_pekerjaan));
        }
    }

    function edit_realisasi_tugas() {
        $id_tugas = intval($this->input->post('id_tugas'));
        $waktu_selesai = $this->input->post('waktu_selesai');
        $waktu_mulai = $this->input->post('waktu_mulai');
        $deskripsi = $this->input->post('deskripsi');
        $tugas = $this->aktivitas_model->get_tugas_by_id($id_tugas);
        if ($tugas == null) {
            $this->send_frame_error('Tugas tidak dapat ditemukan');
            return;
        }
        $session = $this->session->userdata('logged_in');
        $my_id = $session['id_akun'];
        $id_pekerjaan = $tugas['id_pekerjaan'];
        $q = $this->db->query("select * from pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) <= 0) {
            $this->send_frame_error('Pekerjaan tidak dapat ditemukan');
            return;
        }
        $q = $this->db->query("select * from detil_pekerjaan where id_pekerjaan='$id_pekerjaan' and id_akun='$my_id'")->result_array();
        if (count($q) <= 0) {
            $this->send_frame_error('Anda tidak terlibat di dalam pekerjaan');
            return;
        }
        $detil_pekerjaan = $q[0];
        $id_detil_pekerjaan = $detil_pekerjaan['id_detil_pekerjaan'];
        $q = $this->db->query("select * from aktivitas_pekerjaan where id_detil_pekerjaan='$id_detil_pekerjaan' and id_tugas='$id_tugas'")->result_array();
        if (count($q) <= 0) {
            $this->send_frame_error('Anda belum melakukan realisasi tugas, tidak ada data untuk diupdate');
            return;
        }
        $aktivitas = $q[0];
        $id_aktivitas = $aktivitas['id_aktivitas'];
        $this->db->query("set datestyle to 'ISO, DMY'");
        $this->db->update('aktivitas_pekerjaan', array('keterangan' => $deskripsi, 'waktu_mulai' => $waktu_mulai, 'waktu_selesai' => $waktu_selesai), array('id_detil_pekerjaan' => $id_detil_pekerjaan, 'id_tugas' => $id_tugas));
        $this->load->library(array('myuploadlib'));
        $uploader = new MyUploadLib();
        $uploader->prosesUpload('berkas');
        $uploadedFiles = $uploader->getUploadedFiles();
        foreach ($uploadedFiles as $file) {
            $berkas = array(
                'id_pekerjaan' => $id_pekerjaan,
                'id_detil_pekerjaan' => $id_detil_pekerjaan,
                'id_aktivitas' => $id_aktivitas,
                'id_tugas' => $id_tugas,
                'nama_file' => $file['name'],
                'path' => $file['filePath']
            );
            $this->db->insert('file', $berkas);
        }
        $q = $this->db->query("select *, to_char(waktu_mulai,'YYYY-MM-DD') as waktu_mulai2, to_char(waktu_selesai,'YYYY-MM-DD') as waktu_selesai2,
					berkas.id_file, berkas.nama_file
					from aktivitas_pekerjaan 
					left join (select json_agg(id_file) as id_file, json_agg(nama_file) as nama_file, id_tugas,id_aktivitas from file group by id_tugas,id_aktivitas) berkas 
					on berkas.id_aktivitas=aktivitas_pekerjaan.id_aktivitas and berkas.id_tugas=aktivitas_pekerjaan.id_tugas
					where aktivitas_pekerjaan.id_aktivitas='$id_aktivitas'")->result_array();
        $result = null;
        if (count($q) > 0) {
            $result = $q[0];
        }
        $this->send_frame_ok('set_my_aktivitas', $result);
    }

    private function send_frame_ok($function_name, $data) {
        echo '<html><head></head><body><script>parent.' . $function_name . '(' . json_encode($data) . ');</script></body></html>';
    }

    private function send_frame_error($pesan) {
        echo '<html><head></head><body><script>parent.alert(' . $pesan . ');</script></body></html>';
    }

}
