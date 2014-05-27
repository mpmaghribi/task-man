<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/ceklogin.php';

class draft extends ceklogin {

    public function __construct() {
        parent::__construct();
        //$this->load->model("pengaduan_model");
    }

    public function index() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
//        $my_staff = $this->akun->my_staff($session['user_id']);
//        $staff_ = array();
//        foreach ($my_staff as $s) {
//            $staff_[] = $s->id_akun;
//        }
        $list_draft = $this->pekerjaan_model->get_list_draft($session['user_id']);
        //$draft_create_submit=base_url().'pekerjaan/usulan_pekerjaan2';
        $this->load->view('pekerjaan/draft/draft_body', array('draft_create_submit' => base_url() . 'pekerjaan/usulan_pekerjaan2', 'data_akun' => $session, 'list_draft' => $list_draft));
    }

    public function edit() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun', 'berkas_model'));
        $data['id_draft'] = pg_escape_string($this->input->get('id_draft'));
        $data['data_akun'] = $session;
        if (strlen($data['id_draft']) == 0) {
            $data['judul_kesalahan'] = 'id_draft tidak valid';
            $data['deskripsi_kesalahan'] = 'id_draft tidak valid';
            $this->load->view('pekerjaan/kesalahan', $data);
        } else {
            $data['draft_edit_submit'] = base_url() . 'draft/do_edit';
            $data['draft'] = $this->pekerjaan_model->get_draft(array($data['id_draft']));
            $data['list_berkas'] = $this->berkas_model->get_berkas_of_pekerjaan($data['id_draft']);
            $this->load->view('pekerjaan/draft/draft_edit_body', $data);
            //print_r($data['draft']);
        }
    }
    public function view() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $id_draft = pg_escape_string($this->input->get('id_draft'));
    }
    public function assign() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun','berkas_model'));
        $id_draft = pg_escape_string($this->input->get('id_draft'));
        $detail_draft = $this->pekerjaan_model->get_draft(array($id_draft));
        $data['draft']=$detail_draft;
        $data['data_akun']=$session;
        $data['id_draft']=$id_draft;
        $data['list_berkas'] = $this->berkas_model->get_berkas_of_pekerjaan($data['id_draft']);
        $this->load->view('pekerjaan/draft/assign',$data);
    }

    public function do_edit() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $id_draft = pg_escape_string($this->input->post('id_draft'));
        $data['data_akun'] = $session;
        $update["id_sifat_pekerjaan"] = pg_escape_string($this->input->post("sifat_pkj"));
        $update["nama_pekerjaan"] = pg_escape_string($this->input->post("nama_pkj"));
        $update["deskripsi_pekerjaan"] = pg_escape_string($this->input->post("deskripsi_pkj"));
        $update["tgl_mulai"] = pg_escape_string($this->input->post("tgl_mulai_pkj"));
        $update["tgl_selesai"] = pg_escape_string($this->input->post("tgl_selesai_pkj"));
        $update["level_prioritas"] = pg_escape_string($this->input->post("prioritas"));
        $update["kategori"] = pg_escape_string($this->input->post("kategori"));
        $update["asal_pekerjaan"] = 'task management';
        
        $detail_draft = $this->pekerjaan_model->get_draft(array($id_draft));
        if ($detail_draft[0]->id_akun == $session['user_id']) {
            if ($this->pekerjaan_model->update_pekerjaan($update, $id_draft)) {
                if (isset($_FILES["berkas"])) {
                    $path = './uploads/pekerjaan/' . $id_draft . '/';
                    //$this->load->library('upload');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $files = $_FILES["berkas"];
                    $this->upload_file($files, $path, $id_draft);
                }
                $data['list_draft'] = $this->pekerjaan_model->get_list_draft($session['user_id']);
                redirect(base_url().'draft');
            }
        } else {
            $data['judul_kesalahan'] = 'kesalahan';
            $data['deskripsi_kesalahan'] = 'anda tidak berhak mengakses pekerjaan ini';
            $this->load->view('pekerjaan/kesalahan', $data);
        }
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
                    $this->berkas_model->upload_file(
                            $temp['user_id'], $new_file_path, $id_pekerjaan);
                }
            }
        }
    }

}
