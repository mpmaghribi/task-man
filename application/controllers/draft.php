<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class draft extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->model("pengaduan_model");
    }

    function get_list_draft() {
        $session = $this->session->userdata('logged_in');
        $periode = abs(intval($this->input->get('periode')));
        $my_id = $session['id_akun'];
        $q = $this->db->query("
                select p.*, to_char(p.tgl_mulai, 'YYYY-MM-DD') as tanggal_mulai,
                to_char(p.tgl_selesai, 'YYYY-MM-DD') as tanggal_selesai
                from pekerjaan p
                where p.id_penanggung_jawab = '$my_id'
                and p.status_pekerjaan = '9'
                and (
                    date_part('year', p.tgl_mulai) = '$periode' or date_part('year', p.tgl_selesai) = '$periode'
                )
                "
                )->result_array();
        echo json_encode($q);
    }

    private function hapus_draft() {
        $id_draft = intval($this->input->get("id_draft"));
        $hasil = array("status" => "fail", "reason" => "unknown");
        $q = $this->db->where(array("id_pekerjaan" => $id_draft, "status_pekerjaan" => 9))->get("pekerjaan")->result_array();
        if (count($q) < 1) {
            $hasil["reason"] = "Draft tidak dapat ditemukan";
            return $hasil;
        }
        $draft = $q[0];
        $session = $this->session->userdata("logged_in");
        if ($draft["id_penanggung_jawab"] != $session["id_akun"]) {
            $hasil["reason"] = "Anda tidak berhak menghapus draft orang lain";
            return $hasil;
        }
        $list_berkas = $this->db->where(array("id_pekerjaan" => $id_draft))->get("file")->result_array();
        $this->db->trans_begin();
        
        $this->db->delete("file", array("id_pekerjaan" => $id_draft));
        $this->db->delete("pekerjaan", array("id_pekerjaan" => $id_draft));
        foreach ($list_berkas as $berkas) {
            if (file_exists($berkas["nama_file"])) {
                unlink($berkas["nama_file"]);
            }
        }
        $this->db->trans_complete();
        $hasil["status"] = "ok";
        return $hasil;
    }

    function hapus_draft_json() {
        $hasil = $this->hapus_draft();
        echo json_encode($hasil);
    }

    private function hapus_file() {
        $hasil = array("status" => "fail", "reason" => "unknown");
        $id_file = intval($this->input->get("id_file"));
        $session = $this->session->userdata("logged_in");
        $q = $this->db->where(array("id_file" => $id_file))->get("file")->result_array();
        if (count($q) < 1) {
            $hasil["reason"] = "File tidak dapat ditemukan";
            return $hasil;
        }
        $berkas = $q[0];
        $id_pekerjaan = $berkas["id_pekerjaan"];
        $q = $this->db->where(array("id_pekerjaan" => $id_pekerjaan, "status_pekerjaan" => 9))->get("pekerjaan")->result_array();
        if (count($q) < 1) {
            $hasil["reason"] = "Draft Pekerjaan tidak dapat ditemukan";
            return $hasil;
        }
        $pekerjaan = $q[0];
        if ($pekerjaan["id_penanggung_jawab"] != $session["id_akun"]) {
            $hasil["reason"] = "Anda tidak berhak menghapus file pekerjaan draft milik orang lain";
            return $hasil;
        }

        if (file_exists($berkas["path"])) {
            unlink($berkas["path"]);
        }
        $this->db->delete("file", array("id_file" => $id_file));
        $hasil["status"] = "ok";
        return $hasil;
    }

    public function hapus_file_json() {
        $hasil = $this->hapus_file();
        echo json_encode($hasil);
        return;
    }

    public function index() {
        $session = $this->session->userdata('logged_in');
        $data['data_akun'] = $session;
        if (in_array(3, $session['idmodul']) == false) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses fungsionalitas draft';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $my_id = $session['id_akun'];
        $list_tahun = $this->db->query("select distinct periode 
                from pekerjaan 
                where id_penanggung_jawab = '$my_id'
                and status_pekerjaan = '9'
                order by periode desc")->result_array();
        if(count($list_tahun) < 1){
            $list_tahun[] = array('periode'=>date('Y'));
        }
        $this->load->view('draft/draft_body', array(
            'draft_create_submit' => site_url() . 'draft/create',
            'data_akun' => $session,
            'list_periode' => $list_tahun
        ));
    }

    public function create() {
        $session = $this->session->userdata('logged_in');
        $data['data_akun'] = $session;
        if (in_array(3, $session['idmodul']) == false) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses fungsionalitas draft';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $insert['id_sifat_pekerjaan'] = intval($this->input->post('sifat_pkj'));
        $insert['nama_pekerjaan'] = pg_escape_string($this->input->post('nama_pkj'));
        $mutu = floatval($this->input->post('kualitas_mutu'));
        $biaya = $this->input->post('biaya');
        $insert['deskripsi_pekerjaan'] = json_encode(array(
            'deskripsi' => pg_escape_string($this->input->post('deskripsi_pkj')),
            'angka_kredit' => max(0, floatval($this->input->post('angka_kredit'))),
            'kuantitas_output' => max(intval($this->input->post('kuantitas_output')), 1),
            'satuan_kuantitas' => pg_escape_string($this->input->post('satuan_kuantitas')),
            'kualitas_mutu' => max(1, min(100, $mutu)),
            'pakai_biaya' => ($biaya == '-' ? false : true),
            'biaya' => ($biaya == '-' ? 0 : max(1, floatval($biaya)))
        ));
        $insert['periode'] = intval($this->input->post('draft_periode'));
        $insert['tgl_mulai'] = pg_escape_string($this->input->post('tgl_mulai_pkj'));
        $insert['tgl_selesai'] = pg_escape_string($this->input->post('tgl_selesai_pkj'));
        $insert['level_prioritas'] = intval($this->input->post('prioritas'));
        $insert['status_pekerjaan'] = '9';
        $insert['asal_pekerjaan'] = 'taskmanagement';
        $insert['kategori'] = strtolower($this->input->post('kategori'));
        $insert['id_penanggung_jawab'] = $session['id_akun'];
        $insert['level_manfaat'] = intval($this->input->post('select_kemanfaatan'));
        if (in_array($insert['level_manfaat'], array(1, 2, 3)) == false) {
            $insert['level_manfaat'] = 1;
        }
        if (!in_array($insert['kategori'], array('rutin', 'project', 'tambahan', 'kreativitas'))) {
            $insert['kategori'] = 'rutin';
        }
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'European'");
        $res = $this->db->insert('pekerjaan', $insert);
        $id_pekerjaan = $this->db->insert_id();
        $this->load->library(array('myuploadlib'));
        $uploader = new MyUploadLib();
        $uploader->prosesUpload('berkas', date('Y') . '/' . date('m') . '/' . $id_pekerjaan);
        $uploadedFiles = $uploader->getUploadedFiles();
        foreach ($uploadedFiles as $file) {
            $this->db->insert('file', array(
                'id_pekerjaan' => $id_pekerjaan,
                'nama_file' => $file['name'],
                'path' => $file['filePath']
            ));
        }
        $this->taskman_repository->sp_insert_activity($session['id_akun'], 0, "Aktivitas Pekerjaan", $session['user_nama'] . " baru saja membuat draft pekerjaan.");
        $this->db->trans_complete();
        if ($res == 1) {
            redirect(site_url() . '/draft/view?id_draft=' . $id_pekerjaan);
        }

//        redirect(site_url() . '/draft');
    }

    public function edit() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('akun'));
        $data['id_draft'] = $id_draft = intval($this->input->get('id_draft'));
        $data['data_akun'] = $session;
        if (!in_array(3, $session['idmodul'])) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses modul ini';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $data['draft_edit_submit'] = base_url() . 'draft/do_edit';
        $q = $this->db->query("select pekerjaan.*, sifat_pekerjaan.nama_sifat_pekerjaan,
                to_char(tgl_mulai,'YYYY-MM-DD') as tanggal_mulai, 
                to_char(tgl_selesai,'YYYY-MM-DD') as tanggal_selesai 
                from pekerjaan 
                inner join sifat_pekerjaan
                    on sifat_pekerjaan.id_sifat_pekerjaan=pekerjaan.id_sifat_pekerjaan
                where status_pekerjaan=9 and id_pekerjaan='$id_draft'
                ")->result_array();
        if (count($q) < 1) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Draft tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $data['draft'] = $q[0];
        if ($data['draft']['id_penanggung_jawab'] != $session['id_akun']) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses draft orang lain';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $data['list_berkas'] = $this->db->where(array('id_pekerjaan'=>$id_draft))->get('file')->result_array();
        $this->load->view('draft/draft_edit_body', $data);
    }

    public function view() {
        $session = $this->session->userdata('logged_in');
        $data['data_akun'] = $session;
        if (!in_array(3, $session['idmodul'])) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses fungsionalitas draft';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $id_draft = intval($this->input->get('id_draft'));
        $q = $this->db->query("select pekerjaan.*, sifat_pekerjaan.nama_sifat_pekerjaan,
                to_char(tgl_mulai,'YYYY-MM-DD') as tanggal_mulai, 
                to_char(tgl_selesai,'YYYY-MM-DD') as tanggal_selesai 
                from pekerjaan 
                inner join sifat_pekerjaan
                    on sifat_pekerjaan.id_sifat_pekerjaan=pekerjaan.id_sifat_pekerjaan
                where status_pekerjaan=9 and id_pekerjaan='$id_draft'
                ")->result_array();
        if (count($q) <= 0) {
            $data['judul_kesalahan'] = 'Kesalahan Draft';
            $data['deskripsi_kesalahan'] = 'Draft tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $data['draft'] = $q[0];
        if ($data['draft']['id_penanggung_jawab'] != $session['id_akun'] && $data['draft']['id_sifat_pekerjaan'] == '1') {
            $data['judul_kesalahan'] = 'Kesalahan Draft';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses data draft orang lain';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $data['id_draft'] = $id_draft;
        $data['list_berkas'] = $this->db->where(array('id_pekerjaan'=>$id_draft))->get('file')->result_array();
        $this->load->view('draft/view', $data);
    }

    public function assign() {
        $session = $this->session->userdata('logged_in');
        if (in_array(3, $session['idmodul']) == false) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses fungsionalitas draft';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $this->load->model(array('akun'));
        $id_draft = intval($this->input->get('id_draft'));
        $data['data_akun'] = $session;
        $q = $this->db->query("select pekerjaan.*, sifat_pekerjaan.nama_sifat_pekerjaan,
                to_char(tgl_mulai,'YYYY-MM-DD') as tanggal_mulai, 
                to_char(tgl_selesai,'YYYY-MM-DD') as tanggal_selesai 
                from pekerjaan 
                inner join sifat_pekerjaan
                    on sifat_pekerjaan.id_sifat_pekerjaan=pekerjaan.id_sifat_pekerjaan
                where status_pekerjaan=9 and id_pekerjaan='$id_draft'
                ")->result_array();
        if (count($q) <= 0) {
            $data['judul_kesalahan'] = 'Kesalahan Draft';
            $data['deskripsi_kesalahan'] = 'Draft tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $draft = $q[0];
        $data['draft'] = $draft;
        if ($draft['id_penanggung_jawab'] != $session['id_akun']) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses draft orang lain';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $data['id_draft'] = $id_draft;
        $data['list_berkas'] = $this->db->where(array('id_pekerjaan'=>$id_draft))->get('file')->result_array();
        $data['my_staff'] = $this->akun->my_staff($session['user_id']);
        $this->load->view('draft/assign', $data);
    }

    public function do_assign() {
        $session = $this->session->userdata('logged_in');
        $data['data_akun'] = $session;
        if (in_array(3, $session['idmodul']) == false) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak meng-assign draft';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $this->load->model(array('akun'));
        $id_draft = intval($this->input->post('id_draft'));
        $list_staff = $this->input->post('id_akun');
        if(is_array($list_staff) == false){
            $list_staff = array();
        }
        foreach ($list_staff as $key => $val) {
            $val = intval($val);
            if ($val == 0) {
                unset($list_staff[$key]);
            }
        }
        if (count($list_staff) <= 0) {
            $data['judul_kesalahan'] = 'kesalahan';
            $data['deskripsi_kesalahan'] = 'Anda belum memilih staff untuk mengerjakaan draft anda';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $q = $this->db->query("select * from pekerjaan where status_pekerjaan=9 and id_pekerjaan='$id_draft'")->result_array();
        if (count($q) <= 0) {
            $data['judul_kesalahan'] = 'kesalahan';
            $data['deskripsi_kesalahan'] = 'Draft tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $draft = $q[0];
        if ($session['user_id'] != $draft["id_penanggung_jawab"]) {
            $data['judul_kesalahan'] = 'kesalahan';
            $data['deskripsi_kesalahan'] = 'anda tidak berhak mengakses draft pekerjaan ini';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }

        $my_staff = $this->akun->my_staff($session['user_id']);
        $mystaff = array();
        foreach ($my_staff as $s) {
            $mystaff[] = $s->id_akun;
        }
        $this->db->trans_begin();
        //$update['flag_usulan'] = 2;
        $detail_draft = json_decode($draft["deskripsi_pekerjaan"]);
        $deskripsi_pekerjaan = $detail_draft->deskripsi;
        $angka_kredit = $detail_draft->angka_kredit;
        $kuantitas_output = $detail_draft->kuantitas_output;
        $satuan_kuantitas = $detail_draft->satuan_kuantitas;
        $kualitas_mutu = $detail_draft->kualitas_mutu;
        $pakai_biaya = $detail_draft->pakai_biaya;
        $biaya = $detail_draft->biaya;
        $date1 = new DateTime($draft['tgl_mulai']);
        $date2 = new DateTime($draft['tgl_selesai']);
        $interval = $date1->diff($date2);
        $bulan = $interval->m;
        if ($interval->y > 0) {
            $bulan+=($interval->y * 12);
        }
        if ($interval->d > 0) {
            $bulan++;
        }
        $update = $this->db->update("pekerjaan", array("deskripsi_pekerjaan" => $deskripsi_pekerjaan, "status_pekerjaan" => 7), array("id_pekerjaan" => $id_draft));
        //print_r($update);
        if ($update === true) {
            $detail_pekerjaan = array(
                "id_pekerjaan" => $id_draft,
                "skor" => 0,
                "progress" => 0,
                "sasaran_angka_kredit" => $angka_kredit,
                "sasaran_kuantitas_output" => $kuantitas_output,
                "sasaran_kualitas_mutu" => $kualitas_mutu,
                "sasaran_waktu" => $bulan,
                "sasaran_biaya" => $biaya,
                "pakai_biaya" => $pakai_biaya,
                "satuan_kuantitas" => $satuan_kuantitas,
                "satuan_waktu" => "bulan"
            );
            foreach ($list_staff as $key => $val) {
                if (in_array($val, $mystaff)) {
                    $detail_pekerjaan["id_akun"] = $val;
                    $this->db->insert("detil_pekerjaan", $detail_pekerjaan);
                    //$res = $this->pekerjaan_model->tambah_detil_pekerjaan($val, $id_draft);
                    //print_r($res);
                }
            }
            $this->db->trans_complete();
        }
        redirect(site_url() . '/draft');
    }

    public function do_edit() {
        $session = $this->session->userdata('logged_in');
        $data['data_akun'] = $session;
        if (in_array(3, $session['idmodul']) == false) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak meng-edit draft';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $id_draft = intval($this->input->post('id_draft'));
        $update["id_sifat_pekerjaan"] = intval($this->input->post("sifat_pkj"));
        $update["nama_pekerjaan"] = pg_escape_string($this->input->post("nama_pkj"));
        $mutu = floatval($this->input->post('kualitas_mutu'));
        $biaya = $this->input->post('biaya');
        $update["tgl_mulai"] = pg_escape_string($this->input->post("tgl_mulai_pkj"));
        $update["tgl_selesai"] = pg_escape_string($this->input->post("tgl_selesai_pkj"));
        $update["level_prioritas"] = intval($this->input->post("prioritas"));
        $update["kategori"] = $this->input->post("kategori");
        $update["asal_pekerjaan"] = 'taskmanagement';
        $update['deskripsi_pekerjaan'] = json_encode(array(
            'deskripsi' => pg_escape_string($this->input->post('deskripsi_pkj')),
            'angka_kredit' => floatval($this->input->post('angka_kredit')),
            'kuantitas_output' => floatval($this->input->post('kuantitas_output')),
            'satuan_kuantitas' => pg_escape_string($this->input->post('satuan_kuantitas')),
            'kualitas_mutu' => ($mutu > 100 ? 100 : $mutu <= 0 ? 100 : $mutu),
            'pakai_biaya' => ($biaya == '-' ? false : true),
            'biaya' => ($biaya == '-' ? 0 : floatval($biaya)),
        ));
        $update['level_manfaat'] = intval($this->input->post('select_kemanfaatan'));
        if (in_array($update['level_manfaat'], array(1, 2, 3)) == false) {
            $update['level_manfaat'] = 1;
        }
        if (in_array($update['kategori'], array('rutin', 'project', 'tambahan', 'kreativitas')) == false) {
            $update["kategori"] = 'rutin';
        }
        $q = $this->db->query("select * from pekerjaan where status_pekerjaan=9 and id_pekerjaan='$id_draft'")->result_array();
        if (count($q) <= 0) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Draft tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $draft = $q[0];
        if ($draft['id_penanggung_jawab'] != $session['user_id']) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengubah draft milik orang lain';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $this->db->trans_begin();
        $this->db->query("set datestyle to 'ISO, DMY'");
        $this->db->update('pekerjaan', $update, array('id_pekerjaan' => $id_draft));
        $this->load->library(array('myuploadlib'));
        $uploader = new MyUploadLib();
        $uploader->prosesUpload('berkas', date('Y') . '/' . date('m') . '/' . $id_draft);
        $uploadedFiles = $uploader->getUploadedFiles();
        foreach ($uploadedFiles as $file) {
            $this->db->insert('file', array(
                'id_pekerjaan' => $id_draft,
                'nama_file' => $file['name'],
                'path' => $file['filePath']
            ));
        }
//                    $data['list_draft'] = $this->pekerjaan_model->get_list_draft($session['user_id']);
        $this->db->trans_complete();
        redirect(base_url() . 'index.php/draft/view?id_draft=' . $id_draft);
    }

    public function batalkan() {
        $session = $this->session->userdata('logged_in');
        if (in_array(3, $session['idmodul']) == false) {
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak mengakses fungsionalitas draft';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $id_draft = intval($this->input->get('id_draft'));
        $q = $this->db->where(array('id_pekerjaan' => $id_draft, 'status_pekerjaan' => 9))->get('pekerjaan')->result_array();
        if (count($q) < 1) {
            $data['judul_kesalahan'] = 'Kesalahan';
            $data['deskripsi_kesalahan'] = 'Draft Pekerjaan tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $pekerjaan = $q[0];
        if($pekerjaan['id_penanggung_jawab'] != $session['id_akun']){
            $data['judul_kesalahan'] = 'Tidak Berhak';
            $data['deskripsi_kesalahan'] = 'Anda tidak berhak membatalkan draft pekerjaan milik orang lain';
            $this->load->view('pekerjaan/kesalahan', $data);
            return;
        }
        $this->db->trans_begin();
        $list_berkas = $this->db->where(array('id_pekerjaan'=>$id_draft))->get('file')->result_array();
        $this->db->delete('file',array('id_pekerjaan'=>$id_draft));
        $this->db->delete('pekerjaan',array('id_pekerjaan'=>$id_draft));
        foreach($list_berkas as $berkas){
            if(file_exists($berkas['path'])){
                unlink($berkas['path']);
            }
        }
        $this->db->trans_complete();
        redirect(site_url() . '/draft');
    }

}
