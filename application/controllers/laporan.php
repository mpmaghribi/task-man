<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//require APPPATH . '/libraries/ceklogin.php';
class laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->database();
        $this->load->model('laporan_model');
        $this->load->model('taskman_repository');
        $this->load->model('akun');
        $this->load->model('pekerjaan_model');
    }
    
    public function cetak_logaktifitas(){
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $monthNum  = $bulan;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        $data['tahun'] = $tahun;
        $data['bulan'] = $monthName;
        $data['aktifitas'] = $this->pekerjaan_model->logaktifitas($bulan,$tahun);
        $this->load->view('laporan/cetak_aktifitas',$data);
    }

    public function cetak_form_skp() {
        $id = $this->input->get('id_akun');
        //$data["nilai_skp"] = $this->laporan_model->nilai_laporan_skp($id);
        $periode = abs(intval($this->input->get('periode')));
        $data["nilai_skp"] = $this->db->query("select *, case when p.kategori='rutin' or p.kategori='project' then 0 else 1 end as urutan_kategori "
                        . "from pekerjaan p "
                        . "inner join detil_pekerjaan dp on dp.id_pekerjaan=p.id_pekerjaan "
                        . "where dp.id_akun='$id' and p.status_pekerjaan=7 "
                        . "and (date_part('year',tgl_mulai)='$periode' or date_part('year',tgl_selesai)='$periode') "
                        . "order by urutan_kategori")->result_array();
        $data["jabatan"] = $this->input->get('jabatan');
        $data["departemen"] = $this->input->get('departemen');
        $data["nama"] = $this->input->get('nama');
        $data["nip"] = $this->input->get('nip');
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan SKP.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $id_penilai = $temp["user_id"];
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id_penilai . "/format/json"
        ));
        $data["jabatan_penilai"] = $jabatan[0]->nama_jabatan;
        $data["departemen_penilai"] = $jabatan[0]->nama_departemen;
        $data["nama_penilai"] = $jabatan[0]->nama;
        $data["nip_penilai"] = $jabatan[0]->nip;
        $this->load->model("pekerjaan_model");
        $result = $this->taskman_repository->sp_view_pekerjaan($id);
        $data['pkj_karyawan'] = $result;
        $list_id_pekerjaan = array();
        foreach ($result as $pekerjaan) {
            $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
        }
        //var_dump($list_id_pekerjaan);
        $staff = $this->akun->my_staff($temp["user_id"]);
        $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
        $data["detil_pekerjaan"] = json_encode($detil_pekerjaan);
        $data["my_staff"] = json_encode($staff);

        $this->load->view('laporan/cetak_form_skp', $data);
    }

    public function cetak_form_ckp() {
        $id = $this->input->get('id_akun');
        //$data["nilai_skp"] = $this->laporan_model->nilai_laporan_ckp($id);
        $periode = abs(intval($this->input->get('periode')));
        $data["nilai_skp"] = $this->db->query("select *, case when p.kategori='rutin' or p.kategori='project' then 0 else 1 end as urutan_kategori "
                        . "from pekerjaan p "
                        . "inner join detil_pekerjaan dp on dp.id_pekerjaan=p.id_pekerjaan "
                        . "where dp.id_akun='$id' and p.status_pekerjaan=7 "
                        . "and (date_part('year',tgl_mulai)='$periode' or date_part('year',tgl_selesai)='$periode') "
                        . "order by urutan_kategori")->result_array();
        $data["jabatan"] = $this->input->get('jabatan');
        $data["departemen"] = $this->input->get('departemen');
        $data["nama"] = $this->input->get('nama');
        $data["nip"] = $this->input->get('nip');
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan Capaian Kerja Staff.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $id_penilai = $temp["user_id"];
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id_penilai . "/format/json"
        ));
        $data["jabatan_penilai"] = $jabatan[0]->nama_jabatan;
        $data["departemen_penilai"] = $jabatan[0]->nama_departemen;
        $data["nama_penilai"] = $jabatan[0]->nama;
        $data["nip_penilai"] = $jabatan[0]->nip;
        $this->load->model("pekerjaan_model");
        $result = $this->taskman_repository->sp_view_pekerjaan($id);
        $data['pkj_karyawan'] = $result;
        $list_id_pekerjaan = array();
        foreach ($result as $pekerjaan) {
            $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
        }
        //var_dump($list_id_pekerjaan);
        $staff = $this->akun->my_staff($temp["user_id"]);
        $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
        $data["detil_pekerjaan"] = json_encode($detil_pekerjaan);
        $data["my_staff"] = json_encode($staff);

        $this->load->view('laporan/cetak_form_ckp', $data);
    }

    public function index() {
        $temp = $this->session->userdata('logged_in');
        $data["data_akun"] = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat laporan pekerjaan dari para staffnya.");
        $this->load->model("akun");
        $data["my_staff"] = $this->akun->my_staff($temp["user_id"]);
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
        $this->load->view("laporan/laporan_pekerjaan_page", $data);
    }

    function exportFormCKP() {
        $id = $this->input->get('id_akun');
        $periode = abs(intval($this->input->get('periode')));
        $data["nilai_skp"] = $this->db->query("select *, case when p.kategori='rutin' or p.kategori='project' then 0 else 1 end as urutan_kategori "
                        . "from pekerjaan p "
                        . "inner join detil_pekerjaan dp on dp.id_pekerjaan=p.id_pekerjaan "
                        . "where dp.id_akun='$id' and p.status_pekerjaan=7 "
                        . "and (date_part('year',tgl_mulai)='$periode' or date_part('year',tgl_selesai)='$periode') "
                        . "order by urutan_kategori")->result_array();
        $data["jabatan"] = $this->input->get('jabatan');
        $data["departemen"] = $this->input->get('departemen');
        $data["nama"] = $this->input->get('nama');
        $data["nip"] = $this->input->get('nip');
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan Capaian Kerja Staff.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $id_penilai = $temp["user_id"];
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id_penilai . "/format/json"
        ));
        $data["jabatan_penilai"] = $jabatan[0]->nama_jabatan;
        $data["departemen_penilai"] = $jabatan[0]->nama_departemen;
        $data["nama_penilai"] = $jabatan[0]->nama;
        $data["nip_penilai"] = $jabatan[0]->nip;
        $this->load->model("pekerjaan_model");
        $result = $this->taskman_repository->sp_view_pekerjaan($id);
        $data['pkj_karyawan'] = $result;
        $list_id_pekerjaan = array();
        foreach ($result as $pekerjaan) {
            $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
        }
        //var_dump($list_id_pekerjaan);
        $staff = $this->akun->my_staff($temp["user_id"]);
        $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
        $data["detil_pekerjaan"] = json_encode($detil_pekerjaan);
        $data["my_staff"] = json_encode($staff);

        $html = $this->load->view('laporan/laporan_ckp_pdf', $data, true);
        //$pdf->WriteHTML($html, isset($_GET['vuehtml']));
        header("Content-type:application/pdf");

        // It will be called downloaded.pdf
        //header("Content-Disposition:attachment;filename=" . $filename);
        echo generate_pdf($html, $filename, false);
    }

    function laporan_pekerjaan_saya() {

        $jenis = $this->input->get("jenis_laporan");
        $periode = $this->input->get("periode");
        //print_r($jenis);
        //print_r($periode);
        if ($jenis == 1) {
            $periode = $this->input->get("periode");
            $data["periode"] = $periode;
            $temp = $this->session->userdata("logged_in");
            $data['data_akun'] = $temp;
            $data['temp'] = $temp;
            $id = $temp["user_id"];
            $data["nilai_skp"] = $this->laporan_model->nilai_laporan_skp($id);
            $jabatan = json_decode(
                    file_get_contents(
                            str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id . "/format/json"
            ));
            $data["jabatan"] = $jabatan[0]->nama_jabatan;
            $data["departemen"] = $jabatan[0]->nama_departemen;
            $data["nama"] = $jabatan[0]->nama;
            $data["nip"] = $jabatan[0]->nip;

            $atasan = json_decode(
                    file_get_contents(
                            str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $id . "/format/json"
            ));
            if ($atasan != NULL) {
                $data["jabatan_penilai"] = $atasan[0]->nama_jabatan;
                $data["departemen_penilai"] = $atasan[0]->nama_departemen;
                $data["nama_penilai"] = $atasan[0]->nama;
                $data["nip_penilai"] = $atasan[0]->nip;
            } else {
                $data["jabatan_penilai"] = "-";
                $data["departemen_penilai"] = "-";
                $data["nama_penilai"] = "-";
                $data["nip_penilai"] = "-";
            }

            $this->load->helper(array('pdf', 'date'));
            $filename = 'Laporan SKP ' . $data['nama'] . '.pdf';
            $data['state'] = 'Report';
            $this->load->model("pekerjaan_model");
            $result = $this->laporan_model->sp_laporan_per_periode($periode, $id);
            $data['pkj_karyawan'] = $result;
            $html = $this->load->view('laporan/laporan_pekerjaan_pdf', $data, true);
            //$pdf->WriteHTML($html, isset($_GET['vuehtml']));
            header("Content-type:application/pdf");

            // It will be called downloaded.pdf
            //header("Content-Disposition:attachment;filename=" . $filename);
            echo generate_pdf($html, $filename, false);
        } else {
            $periode = $this->input->get("periode");
            $data["periode"] = $periode;
            $temp = $this->session->userdata("logged_in");
            $data['data_akun'] = $temp;
            $data['temp'] = $temp;
            $id = $temp["user_id"];
            $data["nilai_skp"] = $this->laporan_model->nilai_laporan_ckp($id);
            $jabatan = json_decode(
                    file_get_contents(
                            str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id . "/format/json"
            ));
            $atasan = json_decode(
                    file_get_contents(
                            str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/atasan/id/" . $id . "/format/json"
            ));
            //print_r($atasan);
            if ($atasan != NULL) {
                $data["jabatan_penilai"] = $atasan[0]->nama_jabatan;
                $data["departemen_penilai"] = $atasan[0]->nama_departemen;
                $data["nama_penilai"] = $atasan[0]->nama;
                $data["nip_penilai"] = $atasan[0]->nip;
            } else {
                $data["jabatan_penilai"] = "-";
                $data["departemen_penilai"] = "-";
                $data["nama_penilai"] = "-";
                $data["nip_penilai"] = "-";
            }
            $data["jabatan"] = $jabatan[0]->nama_jabatan;
            $data["departemen"] = $jabatan[0]->nama_departemen;
            $data["nama"] = $jabatan[0]->nama;
            $data["nip"] = $jabatan[0]->nip;
            $this->load->helper(array('pdf', 'date'));
            $filename = 'Laporan CKP ' . $data['nama'] . '.pdf';
            $data['state'] = 'Report';
            $this->load->model("pekerjaan_model");
            $result = $this->laporan_model->sp_laporan_per_periode($periode, $id);
            $data['pkj_karyawan'] = $result;
            $html = $this->load->view('laporan/laporan_ckp_pdf', $data, TRUE);
            //$pdf->WriteHTML($html, isset($_GET['vuehtml']));
            header("Content-type:application/pdf");

            // It will be called downloaded.pdf
            //header("Content-Disposition:attachment;filename=" . $filename);
            echo generate_pdf($html, $filename, false);
        }
    }

    function laporan_ckp_per_periode() {
        $temp = $this->session->userdata("logged_in");
        $periode = $this->input->get("periode2");
        $tahun = intval($this->input->get('tahun2'));
        $data["periode"] = $periode;
        $data["data_akun"] = $this->session->userdata("logged_in");
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat laporan pekerjaan per periode dari para staffnya.");
        $id_penilai = $temp["user_id"];
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id_penilai . "/format/json"
        ));
        $data["jabatan_penilai"] = $jabatan[0]->nama_jabatan;
        $data["departemen_penilai"] = $jabatan[0]->nama_departemen;
        $data["nama_penilai"] = $jabatan[0]->nama;
        $data["nip_penilai"] = $jabatan[0]->nip;
        $id = $this->input->get("id_akun2");
//        $data["nilai_skp"] = $this->laporan_model->nilai_laporan_ckp($id);
        $tanggal_min = $tahun . '-01-01';
        $tanggal_max = $tahun . '-12-31';
        if ($periode == 'januari') {
            $tanggal_min = $tahun . '-01-01';
            $tanggal_max = $tahun . '-02-01';
        } else if ($periode == 'februari') {
            $tanggal_min = $tahun . '-02-01';
            $tanggal_max = $tahun . '-03-01';
        } else if ($periode == 'maret') {
            $tanggal_min = $tahun . '-03-01';
            $tanggal_max = $tahun . '-04-01';
        } else if ($periode == 'april') {
            $tanggal_min = $tahun . '-04-01';
            $tanggal_max = $tahun . '-05-01';
        } else if ($periode == 'mei') {
            $tanggal_min = $tahun . '-05-01';
            $tanggal_max = $tahun . '-06-01';
        } else if ($periode == 'juni') {
            $tanggal_min = $tahun . '-06-01';
            $tanggal_max = $tahun . '-07-01';
        } else if ($periode == 'juli') {
            $tanggal_min = $tahun . '-07-01';
            $tanggal_max = $tahun . '-08-01';
        } else if ($periode == 'agustus') {
            $tanggal_min = $tahun . '-08-01';
            $tanggal_max = $tahun . '-09-01';
        } else if ($periode == 'september') {
            $tanggal_min = $tahun . '-09-01';
            $tanggal_max = $tahun . '-10-01';
        } else if ($periode == 'oktober') {
            $tanggal_min = $tahun . '-10-01';
            $tanggal_max = $tahun . '-11-01';
        } else if ($periode == 'november') {
            $tanggal_min = $tahun . '-11-01';
            $tanggal_max = $tahun . '-12-01';
        } else if ($periode == 'desember') {
            $tanggal_min = $tahun . '-12-01';
            $tanggal_max = ($tahun + 1) . '-01-01';
        } else if ($periode == 'tri_1') {
            $tanggal_min = $tahun . '-01-01';
            $tanggal_max = $tahun . '-04-01';
        } else if ($periode == 'tri_2') {
            $tanggal_min = $tahun . '-04-01';
            $tanggal_max = $tahun . '-07-01';
        } else if ($periode == 'tri_3') {
            $tanggal_min = $tahun . '-07-01';
            $tanggal_max = $tahun . '-10-01';
        } else if ($periode == 'tri_4') {
            $tanggal_min = $tahun . '-10-01';
            $tanggal_max = ($tahun + 1) . '-01-01';
        } else if ($periode == 'sms_1') {
            $tanggal_min = $tahun . '-01-01';
            $tanggal_max = $tahun . '-07-01';
        } else if ($periode == 'sms_2') {
            $tanggal_min = $tahun . '-07-01';
            $tanggal_max = ($tahun + 1) . '-01-01';
        }
        $data["nilai_skp"] = $this->db->query("select p.*, "
                        . "dp.sasaran_angka_kredit, dp.sasaran_kuantitas_output, dp.sasaran_kualitas_mutu,"
                        . "dp.sasaran_waktu, dp.sasaran_biaya, dp.pakai_biaya, dp.satuan_kuantitas,"
                        . "dp.realisasi_angka_kredit, dp.realisasi_kualitas_mutu, dp.realisasi_biaya,"
                        . "ak.*, ((date_part('year',waktu_max) - date_part('year',waktu_min))*12) + (date_part('month',waktu_max) - date_part('month',waktu_min) + case when date_part('day',waktu_max)-date_part('day',waktu_min) > 0 then 1 else 0 end) as realisasi_waktu, "
                        . "case when p.kategori='rutin' or p.kategori='project' then 0 else 1 end as urutan_kategori "
                        . "from pekerjaan p "
                        . "inner join detil_pekerjaan dp on dp.id_pekerjaan=p.id_pekerjaan "
                        . "left join ("
                        . "select ak.id_detil_pekerjaan, coalesce(sum(ak.kuantitas_output),0) as realisasi_kuantitas_output, min(ak.waktu_mulai) as waktu_min, max(ak.waktu_selesai) as waktu_max  "
                        . "from aktivitas_pekerjaan ak "
                        . "where to_date('$tanggal_min','YYYY-MM-DD') <= ak.waktu_mulai and ak.waktu_selesai < to_date('$tanggal_max','YYYY-MM-DD') "
                        . "group by ak.id_detil_pekerjaan "
                        . ") as ak on ak.id_detil_pekerjaan=dp.id_detil_pekerjaan "
                        . "where dp.id_akun='$id' and p.status_pekerjaan=7 "
//                        . "and  to_date('$tanggal_min','YYYY-MM-DD') <= p.tgl_mulai  and p.tgl_selesai <= to_date('$tanggal_max','YYYY-MM-DD') "
                        . "and (date_part('year',tgl_mulai)='$tahun' or date_part('year',tgl_selesai)='$tahun') "
                        . "order by urutan_kategori")->result_array();
//        echo $this->db->last_query();
        $data['tanggal_min'] = $tanggal_min;
        $data['tanggal_max'] = $tanggal_max;
        $data["jabatan"] = $this->input->get("nama_jabatan2");
        $data["departemen"] = $this->input->get("nama_departemen2");
        $data["nama"] = $this->input->get("nama2");
        $data["nip"] = $this->input->get("nip2");
        $data['tahun']=$tahun;
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan CKP Per Periode.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $result = $this->laporan_model->sp_laporan_per_periode($periode, $id);
        $data['pkj_karyawan'] = $result;
//        $html = $this->load->view('laporan/laporan_ckp_pdf', $data, false);
        $html = $this->load->view('laporan/laporan_ckp_pdf', $data, true);
        header("Content-type:application/pdf");
        echo generate_pdf($html, $filename, false);
//$pdf->WriteHTML($html, isset($_GET['vuehtml']));
        // It will be called downloaded.pdf
//        header("Content-Disposition:attachment;filename=" . $filename);
    }

    function laporan_per_periode() {
        $temp = $this->session->userdata("logged_in");
        $periode = $this->input->get("periode");
        $tahun = intval($this->input->get('tahun'));
        $data["periode"] = $periode;
        $data["data_akun"] = $this->session->userdata("logged_in");
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat laporan pekerjaan per periode dari para staffnya.");
        $id_penilai = $temp["user_id"];
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id_penilai . "/format/json"
        ));
        $data["jabatan_penilai"] = $jabatan[0]->nama_jabatan;
        $data["departemen_penilai"] = $jabatan[0]->nama_departemen;
        $data["nama_penilai"] = $jabatan[0]->nama;
        $data["nip_penilai"] = $jabatan[0]->nip;
        $id = $this->input->get("id_akun");
//        $data["nilai_skp"] = $this->laporan_model->nilai_laporan_skp($id);
        $tanggal_min = $tahun . '-01-01';
        $tanggal_max = $tahun . '-12-31';
        if ($periode == 'januari') {
            $tanggal_min = $tahun . '-01-01';
            $tanggal_max = $tahun . '-02-01';
        } else if ($periode == 'februari') {
            $tanggal_min = $tahun . '-02-01';
            $tanggal_max = $tahun . '-03-01';
        } else if ($periode == 'maret') {
            $tanggal_min = $tahun . '-03-01';
            $tanggal_max = $tahun . '-04-01';
        } else if ($periode == 'april') {
            $tanggal_min = $tahun . '-04-01';
            $tanggal_max = $tahun . '-05-01';
        } else if ($periode == 'mei') {
            $tanggal_min = $tahun . '-05-01';
            $tanggal_max = $tahun . '-06-01';
        } else if ($periode == 'juni') {
            $tanggal_min = $tahun . '-06-01';
            $tanggal_max = $tahun . '-07-01';
        } else if ($periode == 'juli') {
            $tanggal_min = $tahun . '-07-01';
            $tanggal_max = $tahun . '-08-01';
        } else if ($periode == 'agustus') {
            $tanggal_min = $tahun . '-08-01';
            $tanggal_max = $tahun . '-09-01';
        } else if ($periode == 'september') {
            $tanggal_min = $tahun . '-09-01';
            $tanggal_max = $tahun . '-10-01';
        } else if ($periode == 'oktober') {
            $tanggal_min = $tahun . '-10-01';
            $tanggal_max = $tahun . '-11-01';
        } else if ($periode == 'november') {
            $tanggal_min = $tahun . '-11-01';
            $tanggal_max = $tahun . '-12-01';
        } else if ($periode == 'desember') {
            $tanggal_min = $tahun . '-12-01';
            $tanggal_max = ($tahun + 1) . '-01-01';
        } else if ($periode == 'tri_1') {
            $tanggal_min = $tahun . '-01-01';
            $tanggal_max = $tahun . '-04-01';
        } else if ($periode == 'tri_2') {
            $tanggal_min = $tahun . '-04-01';
            $tanggal_max = $tahun . '-07-01';
        } else if ($periode == 'tri_3') {
            $tanggal_min = $tahun . '-07-01';
            $tanggal_max = $tahun . '-10-01';
        } else if ($periode == 'tri_4') {
            $tanggal_min = $tahun . '-10-01';
            $tanggal_max = ($tahun + 1) . '-01-01';
        } else if ($periode == 'sms_1') {
            $tanggal_min = $tahun . '-01-01';
            $tanggal_max = $tahun . '-07-01';
        } else if ($periode == 'sms_2') {
            $tanggal_min = $tahun . '-07-01';
            $tanggal_max = ($tahun + 1) . '-01-01';
        }
        $data["nilai_skp"] = $this->db->query("select *, case when p.kategori='rutin' or p.kategori='project' then 0 else 1 end as urutan_kategori "
                        . "from pekerjaan p "
                        . "inner join detil_pekerjaan dp on dp.id_pekerjaan=p.id_pekerjaan "
                        . "where dp.id_akun='$id' and p.status_pekerjaan=7 "
//                        . "and  to_date('$tanggal_min','YYYY-MM-DD') <= p.tgl_mulai  and p.tgl_selesai <= to_date('$tanggal_max','YYYY-MM-DD') "
                        . "and (date_part('year',tgl_mulai)='$tahun' or date_part('year',tgl_selesai)='$tahun') "
                        . "order by urutan_kategori")->result_array();
//        echo $this->db->last_query();
        $data['tanggal_min'] = $tanggal_min;
        $data['tanggal_max'] = $tanggal_max;
        $data['tahun']=$tahun;
        $data["jabatan"] = $this->input->get("nama_jabatan");
        $data["departemen"] = $this->input->get("nama_departemen");
        $data["nama"] = $this->input->get("nama");
        $data["nip"] = $this->input->get("nip");
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan SKP Per Periode.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $result = $this->laporan_model->sp_laporan_per_periode($periode, $id);
        $data['pkj_karyawan'] = $result;
        $html = $this->load->view('laporan/laporan_pekerjaan_pdf', $data, true);
        //$pdf->WriteHTML($html, isset($_GET['vuehtml']));
        header("Content-type:application/pdf");
        // It will be called downloaded.pdf
        //header("Content-Disposition:attachment;filename=" . $filename);
        echo generate_pdf($html, $filename, false);
    }

    function exportToExcel() {
        $time = $this->input->get('id');
        $start = $this->input->get('val1');
        $end = $this->input->get('val2');
        if ($time == 1) {
            $results = $this->pengaduan_m->getPengaduanPerYear($start, $end);
            $ket = 'Tahun ' . $start . ' - ' . $end;
            $filename = 'report' . str_replace(' ', '', $start) . '-' . str_replace(' ', '', $end);
        } else if ($time == 2) {
            $results = $this->pengaduan_m->getPengaduanPerMonth($start, $end);
            $ket = 'Bulan ' . $start . ' - ' . $end;
            $filename = 'report' . str_replace(' ', '', $start) . '-' . str_replace(' ', '', $end);
        } else if ($time == 3) {
            $results = $this->pengaduan_m->getPengaduanPerDay($start, $end);
            $ket = 'Tanggal ' . $start . ' - ' . $end;
            $filename = 'report' . str_replace(' ', '', $start) . '-' . str_replace(' ', '', $end);
        } else if ($time == 4) {
            $results = $this->pengaduan_m->getPengaduanPerStatus();
            $ket = 'Per Status';
            $filename = 'report_status';
        } else if ($time == 5) {
            $results = $this->pengaduan_m->getPengaduanDepartemen();
            $ket = 'Per Departemen';
            $filename = 'report_departemen';
        } else if ($time == 6) {
            $data['state'] = 'List';
            $id_statuses = $this->session->flashdata('statuses');
            $id_departemen = $this->session->flashdata('dept');
            $id_kategoris = $this->session->flashdata('kategoris');
            $this->session->set_flashdata('statuses', $id_statuses);
            $this->session->set_flashdata('dept', $id_departemen);
            $this->session->set_flashdata('kategoris', $id_kategoris);
            $data['results'] = $this->pengaduan_m->getListPengaduan($start, $end, $id_statuses, $id_departemen, id_kategoris);
            $ket = '';
            $filename = 'report_pengaduan';
        } else if ($time == 7) {
            $results = $this->pengaduan_m->getPengaduanPerKategori();
            $ket = 'Per Kategori';
            $filename = 'report_kategori';
        }
        $this->_getTheme();

        $stringData = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sheet 1</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>

<body>
<table style="table-layout: fixed; width: 100%;">
<tr colspan="2">
    <td colspan="5" style="text-align:center; font-size:large; word-wrap:break-word;">
Data Pengaduan ' . $ket . '
    <td>
    </tr>
    <tr></tr>
    </table>';
        if ($time == 6) {
            $stringData.='<table border="1">
                
                                <tr>
                                    <th>Nama</th>
                                    <th>Topik</th>
                                    <th>Tanggal</th>
                                    <th>Sumber</th>
                                    <th>Status</th>
                                    <th>Departemen</th>
                                </tr>';
            foreach ($results as $res) {
                $stringData.='<tr>
                                    <td>' . utf8_decode($res->nama_pengadu) . '</td>
                                    <td>' . utf8_decode($res->topik) . '</td>
                                    <td>' . utf8_decode($res->tanggal) . '</td>
                                    <td>' . utf8_decode($res->nama_sumber) . '</td>
                                    <td>' . utf8_decode($res->nama_status_pengaduan) . '</td>
                                    <td>' . utf8_decode($res->nama_departemen) . '</td>
                                </tr>';
            }
        } else {
            $stringData.='<table border="1">
                
                                <tr>
                                    <th></th>
                                    <th>Telpon</th>
                                    <th>SMS</th>
                                    <th>Email</th>
                                    <th>Web</th>
                                </tr>';
            foreach ($results as $res) {
                $stringData.='<tr>
                                    <td>' . utf8_decode($res->parameter_pengaduan) . '</td>
                                    <td>' . utf8_decode($res->phone) . '</td>
                                    <td>' . utf8_decode($res->sms) . '</td>
                                    <td>' . utf8_decode($res->email) . '</td>
                                    <td>' . utf8_decode($res->web) . '</td>
                                </tr>';
            }
        }
        $stringData.='</table></body></html>';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename . '.xls');

        echo $stringData;
    }

    function exportToPDF() {
        $id = $this->input->get('id_akun');
        $periode = abs(intval($this->input->get('periode')));
        $data["nilai_skp"] = $this->db->query("select *, case when p.kategori='rutin' or p.kategori='project' then 0 else 1 end as urutan_kategori "
                        . "from pekerjaan p "
                        . "inner join detil_pekerjaan dp on dp.id_pekerjaan=p.id_pekerjaan "
                        . "where dp.id_akun='$id' and p.status_pekerjaan=7 "
                        . "and (date_part('year',tgl_mulai)='$periode' or date_part('year',tgl_selesai)='$periode') "
                        . "order by urutan_kategori")->result_array();
        $data["jabatan"] = $this->input->get('jabatan');
        $data["jabatan"] = $this->input->get('jabatan');
        $data["departemen"] = $this->input->get('departemen');
        $data["nama"] = $this->input->get('nama');
        $data["nip"] = $this->input->get('nip');
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan SKP.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $id_penilai = $temp["user_id"];
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/" . $id_penilai . "/format/json"
        ));
        $data["jabatan_penilai"] = $jabatan[0]->nama_jabatan;
        $data["departemen_penilai"] = $jabatan[0]->nama_departemen;
        $data["nama_penilai"] = $jabatan[0]->nama;
        $data["nip_penilai"] = $jabatan[0]->nip;
        $this->load->model("pekerjaan_model");
        $result = $this->taskman_repository->sp_view_pekerjaan($id);
        $data['pkj_karyawan'] = $result;
        $list_id_pekerjaan = array();
        foreach ($result as $pekerjaan) {
            $list_id_pekerjaan[] = $pekerjaan->id_pekerjaan;
        }
        //var_dump($list_id_pekerjaan);
        $staff = $this->akun->my_staff($temp["user_id"]);
        $detil_pekerjaan = $this->pekerjaan_model->get_detil_pekerjaan($list_id_pekerjaan);
        $data["detil_pekerjaan"] = json_encode($detil_pekerjaan);
        $data["my_staff"] = json_encode($staff);

        $html = $this->load->view('laporan/laporan_pekerjaan_pdf', $data, true);
        //$pdf->WriteHTML($html, isset($_GET['vuehtml']));
        header("Content-type:application/pdf");

        // It will be called downloaded.pdf
        //header("Content-Disposition:attachment;filename=" . $filename);
        echo generate_pdf($html, $filename, false);
    }

    public function get_idModule() {
        return "admin";
    }

}