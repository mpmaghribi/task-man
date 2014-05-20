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
    }

    public function index() {
        $temp = $this->session->userdata('logged_in');
        $data["data_akun"] = $this->session->userdata('logged_in');
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat laporan pekerjaan dari para staffnya.");
        $this->load->model("akun");
        $data["my_staff"] = $this->akun->my_staff($temp["user_id"]);
        $this->load->view("laporan/laporan_pekerjaan_page", $data);
    }
    
    function laporan_pekerjaan_saya()
    {
        $temp = $this->session->userdata("logged_in");
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
        $id = $temp["user_id"];
        $jabatan = json_decode(
                file_get_contents(
                        str_replace('taskmanagement','integrarsud',str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/userjabdep/id/".$id."/format/json"
                        ));
        $data["jabatan"] = $jabatan[0]->nama_jabatan;
        $data["departemen"] = $jabatan[0]->nama_departemen;
        $data["nama"] = $jabatan[0]->nama;
        $data["nip"] = $jabatan[0]->nip;
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan Kerja '.$data['nama'].'.pdf';
        $data['state'] = 'Report';
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
    
    function laporan_per_periode() {
        $temp = $this->session->userdata("logged_in");
        $periode = $this->input->get("periode");
        $data["periode"] = $periode;
        $data["data_akun"] = $this->session->userdata("logged_in");
        $result = $this->taskman_repository->sp_insert_activity($temp['user_id'], 0, "Aktivitas Pekerjaan", $temp['user_nama'] . " sedang melihat laporan pekerjaan per periode dari para staffnya.");
        
        $id = $this->input->get("id_akun");
        $data["jabatan"] = $this->input->get("nama_jabatan");
        $data["departemen"] = $this->input->get("nama_departemen");
        $data["nama"] = $this->input->get("nama");
        $data["nip"] = $this->input->get("nip");
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan Kerja Staff.pdf';
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
        $data["jabatan"] = $this->input->get('jabatan');
        $data["departemen"] = $this->input->get('departemen');
        $data["nama"] = $this->input->get('nama');
        $data["nip"] = $this->input->get('nip');
        $this->load->helper(array('pdf', 'date'));
        $filename = 'Laporan Kerja Staff.pdf';
        $data['state'] = 'Report';
        $temp = $this->session->userdata('logged_in');
        $data['data_akun'] = $temp;
        $data['temp'] = $temp;
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
