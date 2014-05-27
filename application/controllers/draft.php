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
        $this->load->view('pekerjaan/draft/draft_body', array('draft_create_submit' => base_url() . 'draft/create', 'data_akun' => $session, 'list_draft' => $list_draft));
    }
public function create() {
    $temp = $this->session->userdata('logged_in');
        $sifat_pkj = $this->input->post('sifat_pkj');
        $parent_pkj = 0;
        $nama_pkj = $this->input->post('nama_pkj');
        $deskripsi_pkj = $this->input->post('deskripsi_pkj');
        $tgl_mulai_pkj = $this->input->post('tgl_mulai_pkj');
        $tgl_selesai_pkj = $this->input->post('tgl_selesai_pkj');
        $prioritas = $this->input->post('prioritas');
        $status_pkj = '5';
        $asal_pkj = 'task management';
        $kategori = pg_escape_string(strtolower($this->input->post('kategori')));


        if (!($kategori == 'project' || $kategori == 'rutin')) {
            $kategori = null;
        }


        $list_staff = $this->input->post("staff");
        $jenis_usulan = $this->input->post('jenis_usulan');

        $lempar = 'draft';

        $this->load->model("akun");
        $this->load->model("pekerjaan_model");
        $my_staff = $this->akun->my_staff($temp['user_id']);

        $id_pekerjaan = $this->pekerjaan_model->usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj, $kategori);
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
        }
        redirect($lempar);
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
        $this->load->model(array('pekerjaan_model', 'akun', 'berkas_model'));
        $id_draft = pg_escape_string($this->input->get('id_draft'));
        $data['data_akun'] = $session;
        $data['draft'] = $this->pekerjaan_model->get_draft(array($id_draft));
        $data['id_draft'] = $id_draft;
        $data['list_berkas'] = $this->berkas_model->get_berkas_of_pekerjaan($id_draft);
        $this->load->view('pekerjaan/draft/view', $data);
    }

    public function assign() {
        $session = $this->session->userdata('logged_in');
        $this->load->model(array('pekerjaan_model', 'akun', 'berkas_model'));
        $id_draft = pg_escape_string($this->input->get('id_draft'));
        $detail_draft = $this->pekerjaan_model->get_draft(array($id_draft));
        $data['draft'] = $detail_draft;
        $data['data_akun'] = $session;
        $data['id_draft'] = $id_draft;
        $data['list_berkas'] = $this->berkas_model->get_berkas_of_pekerjaan($data['id_draft']);
        //$data['my_staff']=$this->akun->my_staff($session['user_id']);
        $this->load->view('pekerjaan/draft/assign', $data);
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
            $this->load->model(array('pekerjaan_model','berkas_model'));
            $detail_draft = $this->pekerjaan_model->get_draft(array($id_draft));
            if ($detail_draft[0]->id_akun == $session['user_id']) {
                $list_berkas = $this->berkas_model->get_berkas_of_pekerjaan($id_draft);
                foreach ($list_berkas as $berkas){
                    $this->berkas_model->hapus_file($berkas->id_file);
                    unlink($berkas->nama_file);
                }
                $update['flag_usulan']='7';
                $this->pekerjaan_model->update_pekerjaan($update,$id_draft);
            }
            redirect(base_url() . 'draft');
        }
    }

}
