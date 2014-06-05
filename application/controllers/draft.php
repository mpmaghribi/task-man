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
        $my_staff = $this->akun->my_staff($session['user_id']);
        if (isset($my_staff->error))
            $my_staff = array();
        $staff_ = array();
        foreach ($my_staff as $s) {
            $staff_[] = $s->id_akun;
        }
        $list_draft = $this->pekerjaan_model->get_list_draft($session['user_id']);
        //$draft_create_submit=base_url().'pekerjaan/usulan_pekerjaan2';
        $this->load->view('pekerjaan/draft/draft_body', array('draft_create_submit' => base_url() . 'draft/create', 'data_akun' => $session, 'list_draft' => $list_draft));
    }

    public function create() {
        $temp = $this->session->userdata('logged_in');
        $insert['id_sifat_pekerjaan'] = pg_escape_string($this->input->post('sifat_pkj'));
        $insert['parent_pekerjaan'] = 0;
        $insert['nama_pekerjaan'] = pg_escape_string($this->input->post('nama_pkj'));
        $insert['deskripsi_pekerjaan'] = $this->input->post('deskripsi_pkj');
        $insert['tgl_mulai'] = pg_escape_string($this->input->post('tgl_mulai_pkj'));
        $insert['tgl_selesai'] = pg_escape_string($this->input->post('tgl_selesai_pkj'));
        $insert['level_prioritas'] = pg_escape_string($this->input->post('prioritas'));
        $insert['flag_usulan'] = '5';
        $insert['asal_pekerjaan'] = 'task management';
        $insert['kategori'] = pg_escape_string(strtolower($this->input->post('kategori')));



        $lempar = 'draft';

        $this->load->model("akun");
        $this->load->model("pekerjaan_model");
        $my_staff = $this->akun->my_staff($temp['user_id']);
        if (!isset($my_staff->error)) {
            $id_pekerjaan = $this->pekerjaan_model->create_draft($insert);
            if ($id_pekerjaan != NULL) {


                //echo "path = $path<br/>";
                if (isset($_FILES["berkas"])) {
                    $path = './uploads/pekerjaan/' . $id_pekerjaan . '/';
                    //$this->load->library('upload');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $files = $_FILES["berkas"];
                    $this->upload_file($files, $path, $id_pekerjaan);
                }
                $result = $this->taskman_repository->sp_insert_activity($temp['id_akun'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " baru saja membuat draft pekerjaan.");
                $this->pekerjaan_model->isi_pemberi_pekerjaan($temp['user_id'], $id_pekerjaan);
            } else {
                echo 'id draft null';
            }
        }
        redirect(base_url() . 'draft');
    }

    public function edit() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun', 'berkas_model'));
        $data['id_draft'] = pg_escape_string($this->input->get('id_draft'));
        $data['data_akun'] = $session;
        $status = 0;
        $judul = '';
        $keterangan = '';
        if (strlen($data['id_draft']) == 0) {
            $status = 1;
            $judul = 'id draft tidak valid';
            $keterangan = 'id draft yang diminta tidak valid';
        }
        if ($status == 0) {
            $data['draft_edit_submit'] = base_url() . 'draft/do_edit';
            $data['draft'] = $this->pekerjaan_model->get_draft(array($data['id_draft']));
            if ($data['draft'][0]->id_akun == $session['id_akun']) {
                
            } else {
                $status = 1;
                $judul = 'Kesalahan';
                $keterangan = "anda tidak berhak untuk mengedit draft ini";
            }
        }
        if ($status == 0) {
            $data['list_berkas'] = $this->berkas_model->get_berkas_of_pekerjaan($data['id_draft']);
            //print_r($data['draft']);
        }
        if ($status == 1) {
            $data['judul_kesalahan'] = $judul;
            $data['deskripsi_kesalahan'] = $keterangan;
            $this->load->view('pekerjaan/kesalahan', $data);
        }
        if ($status == 0) {
            $this->load->view('pekerjaan/draft/draft_edit_body', $data);
        }
    }

    public function view() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun', 'berkas_model'));
        $id_draft = pg_escape_string($this->input->get('id_draft'));
        $data['data_akun'] = $session;
        $data['draft'] = $this->pekerjaan_model->get_draft(array($id_draft));
        //echo 'oeee';
        //print_r($data['draft']);
        if (count($data['draft']) > 0) {
            $data['id_draft'] = $id_draft;
            $data['list_berkas'] = $this->berkas_model->get_berkas_of_pekerjaan($id_draft);
            $this->load->view('pekerjaan/draft/view', $data);
        } else {
            $data['judul_kesalahan'] = 'Kesalahan Draft';
            $data['deskripsi_kesalahan'] = 'Draft tidak dapat ditemukan';
            $this->load->view('pekerjaan/kesalahan', $data);
        }
    }

    public function assign() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun', 'berkas_model'));
        $id_draft = pg_escape_string($this->input->get('id_draft'));
        $detail_draft = $this->pekerjaan_model->get_draft(array($id_draft));
        $data['draft'] = $detail_draft;
        $data['data_akun'] = $session;
        $status = 0;
        $judul = '';
        $keterangan = '';
        if (count($data['draft']) > 0) {
            
        } else {
            $status = 1;
            $judul = 'Kesalahan Draft';
            $keterangan = 'draft tidak dapat ditemukan';
        }
        if($status==0){
            if($detail_draft[0]->id_akun!=$session['id_akun']){
                $status=1;
                $judul='Tidak Berhak';
                $keterangan="Anda tidak berhak mengakses draft ini";
            }
        }
        if ($status == 0) {
            $data['id_draft'] = $id_draft;
            $data['list_berkas'] = $this->berkas_model->get_berkas_of_pekerjaan($data['id_draft']);
            //$data['my_staff']=$this->akun->my_staff($session['user_id']);
            $this->load->view('pekerjaan/draft/assign', $data);
        }
        if($status==1){
            $data['judul_kesalahan']=$judul;
            $data['deskripsi_kesalahan']=$keterangan;
            $this->load->view('pekerjaan/kesalahan', $data);
        }
    }

    public function do_assign() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun'));
        $id_draft = pg_escape_string($this->input->post('id_draft'));
        $set_id_staff = $this->input->post('staff');
        $detail_draft = $this->pekerjaan_model->get_draft(array($id_draft));
        $data['data_akun'] = $session;
        $list_staff = explode("::", $set_id_staff);
        foreach ($list_staff as $key => $val) {
            if (strlen($val) == 0) {
                unset($list_staff[$key]);
            }
        }
        if (count($list_staff) > 0) {
            //print_r($list_staff);
            if ($session['user_id'] == $detail_draft[0]->id_akun) {

                $my_staff = $this->akun->my_staff($session['user_id']);
                $mystaff = array();
                foreach ($my_staff as $s) {
                    $mystaff[] = $s->id_akun;
                }
                $update['flag_usulan'] = 2;
                $update = $this->pekerjaan_model->update_pekerjaan($update, $id_draft);
                print_r($update);
                if ($update === true) {
                    foreach ($list_staff as $key => $val) {
                        if (strlen($val) > 0 && in_array($val, $mystaff)) {
                            $res = $this->pekerjaan_model->tambah_detil_pekerjaan($val, $id_draft);
                            print_r($res);
                        }
                    }
                }
                redirect(base_url() . 'draft');
            } else {
                $data['judul_kesalahan'] = 'kesalahan';
                $data['deskripsi_kesalahan'] = 'anda tidak berhak mengakses draft pekerjaan ini';
                $this->load->view('pekerjaan/kesalahan', $data);
            }
        } else {
            $data['judul_kesalahan'] = 'kesalahan';
            $data['deskripsi_kesalahan'] = 'anda tidak menambahkan staff untuk draft pekerjaan';
            $this->load->view('pekerjaan/kesalahan', $data);
        }
        //print_r($detail_draft);
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
                redirect(base_url() . 'draft');
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

    public function batalkan() {
        $id_draft = pg_escape_string($this->input->get('id_draft'));
        $session = $this->session->userdata('logged_in');
        if (strlen($id_draft) == 0) {
            
        } else {
            $this->load->model(array('pekerjaan_model', 'berkas_model'));
            $detail_draft = $this->pekerjaan_model->get_draft(array($id_draft));
            if ($detail_draft[0]->id_akun == $session['user_id']) {
                $list_berkas = $this->berkas_model->get_berkas_of_pekerjaan($id_draft);
                foreach ($list_berkas as $berkas) {
                    $this->berkas_model->hapus_file($berkas->id_file);
                    unlink($berkas->nama_file);
                }
                $update['flag_usulan'] = '6';
                $this->pekerjaan_model->update_pekerjaan($update, $id_draft);
            }
            redirect(base_url() . 'draft');
        }
    }

}
