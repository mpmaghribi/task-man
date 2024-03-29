<?php

require_once APPPATH . '/libraries/dtpg.php';

class pekerjaan_model extends dtpg {

    public function __construct() {
        parent::__construct();
    }

    public function sp_list_file_progress($id_pekerjaan) {
        $query = "Select file.id_file, file.id_pekerjaan, file.nama_file, file.waktu from file inner join detil_progress on detil_progress.id_detil_progress = file.id_progress where file.id_pekerjaan = " . pg_escape_string($id_pekerjaan) . " ";
        $query = $this->db->query($query);
        return $query->result();
    }

    //log aktifitas, parameter bulan $ tahun
    public function logaktifitas($bulan, $tahun, $akun) {
        $query = "select pekerjaan.nama_pekerjaan, aktivitas_pekerjaan.id_detil_pekerjaan, aktivitas_pekerjaan.id_aktivitas, aktivitas_pekerjaan.keterangan,
to_char(aktivitas_pekerjaan.waktu_mulai::timestamp::date, 'dd Month YYYY') as waktu_mulai, to_char(aktivitas_pekerjaan.waktu_selesai::timestamp::date, 'dd Month YYYY') as waktu_selesai
from aktivitas_pekerjaan
left join detil_pekerjaan dp on dp.id_detil_pekerjaan = aktivitas_pekerjaan.id_detil_pekerjaan
left join pekerjaan on pekerjaan.id_pekerjaan = dp.id_pekerjaan
where 
dp.id_akun = $akun
and
(
extract( month from aktivitas_pekerjaan.waktu_mulai) = $bulan
or
extract( month from aktivitas_pekerjaan.waktu_selesai) = $bulan
)
and
(
extract( year from aktivitas_pekerjaan.waktu_mulai) = $tahun
or
extract( year from aktivitas_pekerjaan.waktu_selesai) = $tahun
)
			
ORDER BY aktivitas_pekerjaan.waktu_mulai asc";
        $result = $this->db->query($query);
        return $result->result();
    }

    //untuk data graph di controller pekerjaan saya, fungsi index. 
    public function activityjobthismonth($id_akun) {
        $query = "select pekerjaan.nama_pekerjaan, pekerjaan.id_pekerjaan, pekerjaan.tgl_mulai, pekerjaan.tgl_selesai, tbl2.id_detil_pekerjaan, tbl2.jml 
from pekerjaan
inner join detil_pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan
inner join
(
select count(aktivitas_pekerjaan.id_aktivitas) as jml, aktivitas_pekerjaan.id_detil_pekerjaan from aktivitas_pekerjaan
left join detil_pekerjaan dp on dp.id_detil_pekerjaan = aktivitas_pekerjaan.id_detil_pekerjaan
where 
dp.id_akun = $id_akun
and
(
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) <= 
            aktivitas_pekerjaan.waktu_mulai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) >= 
            aktivitas_pekerjaan.waktu_mulai
            )
            or
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) <= 
            aktivitas_pekerjaan.waktu_selesai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) <= 
            aktivitas_pekerjaan.waktu_selesai
            )
            or
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) >= 
            aktivitas_pekerjaan.waktu_mulai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) <= 
            aktivitas_pekerjaan.waktu_selesai
            )
			)
			GROUP BY aktivitas_pekerjaan.id_detil_pekerjaan
) as tbl2 on tbl2.id_detil_pekerjaan = detil_pekerjaan.id_detil_pekerjaan 
ORDER BY pekerjaan.tgl_mulai asc";
        $query = $this->db->query($query);
        return $query->result();
    }

    //untuk query aktifitas bulan ini di kalender / home
    public function listactivitythismonth($id_akun) {
        $query = "
select pekerjaan.nama_pekerjaan, aktivitas_pekerjaan.id_detil_pekerjaan, aktivitas_pekerjaan.id_aktivitas, aktivitas_pekerjaan.keterangan, aktivitas_pekerjaan.waktu_mulai::timestamp::date, aktivitas_pekerjaan.waktu_selesai::timestamp::date
from aktivitas_pekerjaan
left join detil_pekerjaan dp on dp.id_detil_pekerjaan = aktivitas_pekerjaan.id_detil_pekerjaan
left join pekerjaan on pekerjaan.id_pekerjaan = dp.id_pekerjaan
where 
dp.id_akun = $id_akun
and
(
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) <= 
            aktivitas_pekerjaan.waktu_mulai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) >= 
            aktivitas_pekerjaan.waktu_mulai
            )
            or
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) <= 
            aktivitas_pekerjaan.waktu_selesai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) <= 
            aktivitas_pekerjaan.waktu_selesai
            )
            or
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) >= 
            aktivitas_pekerjaan.waktu_mulai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) <= 
            aktivitas_pekerjaan.waktu_selesai
            )
			)
			
ORDER BY aktivitas_pekerjaan.waktu_mulai asc";
        $result = $this->db->query($query);
        return $result->result();
    }

    //already tested
    public function jobthismonth($id_akun) {
        $query = "select pekerjaan.nama_pekerjaan, pekerjaan.tgl_mulai, pekerjaan.tgl_selesai from detil_pekerjaan 
            inner join pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan 
            where detil_pekerjaan.id_akun = $id_akun 
            and 
			(
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) <= 
            pekerjaan.tgl_mulai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) >= 
            pekerjaan.tgl_mulai
            )
            or
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) <= 
            pekerjaan.tgl_selesai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) <= 
            pekerjaan.tgl_selesai
            )
            or
            (
            ( select cast(date_trunc('month', current_date  ) as date ) as firstdate ) >= 
            pekerjaan.tgl_mulai
            and
            ( select cast(date_trunc('month', current_date)+ interval '1 month - 1 day' as date ) as lastdate) <= 
            pekerjaan.tgl_selesai
            )
			)";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function alltask($id_akun) {
        $query = "Select COUNT(*) from detil_pekerjaan inner join pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun = '" . pg_escape_string($id_akun) . "'";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function ongoingtask($id_akun) {
        $id_akun = pg_escape_string($id_akun);
        $query = "Select COUNT(*) 
                 from detil_pekerjaan 
                 inner join pekerjaan 
                 on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan 
                 and detil_pekerjaan.id_akun = '$id_akun' 
                 where pekerjaan.tgl_mulai::date <= now()::date
                 and detil_pekerjaan.tgl_read is not null
                 and pekerjaan.tgl_selesai::date >= now()::date";
        $query = $this->db->query($query);
        return $query->result();
    }

//    public function cek_pemberi_pekerjaan($id_pekerjaan) {
//        $query = "select * from pemberi_pekerjaan where id_pekerjaan='$id_pekerjaan'";
//        $query = $this->db->query($query);
//        return $query->result();
//    }
    public function create_draft($param) {
        $this->db->query("set datestyle to 'European'");
        //$query = "insert into pekerjaan ($colom) values ($isi)";
        //$q=$this->db->query($query);
        $q = $this->db->insert('pekerjaan', $param);
        if ($q === true) {
            $query = "select currval('tbl_pekerjaan_id') as id_baru";
            $query = $this->db->query($query);
            //print_r($query);
            $row = $query->result();
            //print_r($row);
            return $row[0]->id_baru;
        }
        return NULL;
    }

    public function finishtask($id_akun) {
        $id_akun = pg_escape_string($id_akun);
        $query = "Select COUNT(*) 
                 from detil_pekerjaan 
                 inner join pekerjaan 
                 on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan 
                 and detil_pekerjaan.id_akun = '$id_akun' 
                 where pekerjaan.tgl_selesai::date < now()::date 
                 and detil_pekerjaan.progress=100";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function notworkingtask($id_akun) {
        $id_akun = pg_escape_string($id_akun);
        $query = "Select COUNT(*) 
                 from detil_pekerjaan 
                 inner join pekerjaan 
                 on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan 
                 and detil_pekerjaan.id_akun = '$id_akun' 
                 where pekerjaan.tgl_mulai::date > now()::date
                 or detil_pekerjaan.tgl_read is null
                ";
        $query = $this->db->query($query);
        return $query->result();
    }

//    public function isi_pemberi_pekerjaan($user_id, $id_pekerjaan) {
//        $queri = "insert into pemberi_pekerjaan (id_pekerjaan, id_akun) values ('$id_pekerjaan','$user_id')";
//        return $this->db->query($queri);
//    }

    public function list_pekerjaan($id_akun, $offset = 0, $limit = 100) {
        //$id_akun = pg_escape_string($id_akun);
        if (count($id_akun) == 0)
            return NULL;
        $query = "select detil_pekerjaan.id_akun, pekerjaan.* "
                . "  from detil_pekerjaan inner join pekerjaan on "
                . "detil_pekerjaan.id_pekerjaan=pekerjaan.id_pekerjaan "
                . "where detil_pekerjaan.id_akun in (" . implode(",", $id_akun) . ") "
                . "and detil_pekerjaan.status!='Batal' "
                . "and pekerjaan.flag_usulan in('1','2','9') "
                . "order by tglasli_mulai desc limit $limit offset $offset";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function list_pending_task($id_akun, $offset = 0, $limit = 100) {
        $id_akun = pg_escape_string($id_akun);
        $query = "select detil_pekerjaan.id_detil_pekerjaan, pekerjaan.nama_pekerjaan,"
                . "detil_pekerjaan.id_pekerjaan, detil_pekerjaan.id_akun, detil_pekerjaan.progress, pekerjaan.tgl_mulai, "
                . "pekerjaan.tgl_selesai,detil_pekerjaan.tgl_read from detil_pekerjaan inner join pekerjaan on "
                . "detil_pekerjaan.id_pekerjaan=pekerjaan.id_pekerjaan  "
                . "where id_akun=$id_akun "
                . "and progress<100 and detil_pekerjaan.status!='Batal' and pekerjaan.flag_usulan in ('2') "
                . "limit $limit offset $offset";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function usul_pekerjaan($sifat_pkj, $parent_pkj, $nama_pkj, $deskripsi_pkj, $tgl_mulai_pkj, $tgl_selesai_pkj, $prioritas, $status_pkj, $asal_pkj, $id_pengaduan, $kategori) {

        $sifat_pkj = pg_escape_string($sifat_pkj);
        $deskripsi_pkj = pg_escape_string($deskripsi_pkj);
        $prioritas = pg_escape_string($prioritas);
        $status_pkj = pg_escape_string($status_pkj);
        $asal_pkj = pg_escape_string($asal_pkj);
        $parent_pkj = pg_escape_string($parent_pkj);
        $tgl_mulai_pkj = pg_escape_string($tgl_mulai_pkj);
        $tgl_selesai_pkj = pg_escape_string($tgl_selesai_pkj);
        $nama_pkj = pg_escape_string($nama_pkj);
        $id_pengaduan = pg_escape_string($id_pengaduan);
        $kategori = pg_escape_string($kategori);
        $query1 = "insert into pekerjaan (id_sifat_pekerjaan, parent_pekerjaan, "
                . "nama_pekerjaan, deskripsi_pekerjaan, tgl_mulai, tgl_selesai, asal_pekerjaan, "
                . "level_prioritas, flag_usulan, id_pengaduan, kategori)"
                . " values ('$sifat_pkj', '$parent_pkj', '$nama_pkj', "
                . "'$deskripsi_pkj', '$tgl_mulai_pkj', '$tgl_selesai_pkj', "
                . "'$asal_pkj','$prioritas', '$status_pkj','$id_pengaduan','$kategori');";
        $query2 = $this->db->query($query1);
        if ($query2 === true) {
            $query1 = "select currval('tbl_pekerjaan_id') as id_baru";
            $query2 = $this->db->query($query1);
            //return $query2->result()[0]->id_baru;
            foreach ($query2->result() as $row) {
                return $row->id_baru;
            }
        }
        //echo $query1;
        return NULL;
    }

    public function usul_pekerjaan2($data) {
        $this->db->query("set datestyle to 'European'");
        $pekerjaan = $this->db->insert('pekerjaan', $data);
        if ($pekerjaan === true) {
            $query1 = "select currval('tbl_pekerjaan_id') as id_baru";
            $query2 = $this->db->query($query1);
            //return $query2->result()[0]->id_baru;
            foreach ($query2->result() as $row) {
                return $row->id_baru;
            }
        }
        //echo $query1;
        return NULL;
    }

    public function tambah_detil_pekerjaan($id_akun, $id_pekerjaan) {
        $query = "insert into detil_pekerjaan(id_akun, id_pekerjaan, "
                . "skor, progress, status) values ('$id_akun', '$id_pekerjaan',0,0,"
                . "'Belum Dibaca')";
        $query = $this->db->query($query);
    }

    public function nilai_get($id_detil_pekerjaan, $tipe_nilai) {
        $tipe_nilai = strtolower($tipe_nilai);
        $query = "select detil_pekerjaan.*, nilai_pekerjaan.*,tipe_nilai.* "
                . "from nilai_pekerjaan inner join tipe_nilai "
                . "on nilai_pekerjaan.id_tipe_nilai=tipe_nilai.id_tipe_nilai "
                . "inner join detil_pekerjaan on detil_pekerjaan.id_detil_pekerjaan="
                . "nilai_pekerjaan.id_detil_pekerjaan "
                . "where detil_pekerjaan.id_detil_pekerjaan=$id_detil_pekerjaan and "
                . "tipe_nilai.id_tipe_nilai=$tipe_nilai";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function nilai_set($insert) {
        $pekerjaan = $this->db->insert('nilai_pekerjaan', $insert);
        return $pekerjaan;
    }

    public function nilai_update($data, $id) {
        $this->db->where('id_nilai', $id);
        $pekerjaan = $this->db->update('nilai_pekerjaan', $data);
        return $pekerjaan;
    }

    public function get_tipe_nilai_by_nama($nama_tipe_nilai) {
        //$nama_tipe_nilai=strtolower($nama_tipe_nilai);
        $query = "select tipe_nilai.* from tipe_nilai where lower(tipe_nilai.nama_tipe)"
                . " like '%$nama_tipe_nilai%' ";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_deskripsi_pekerjaan($id_detail_pkj, $offset = 0, $limit = 100) {
        $query = "select pekerjaan.*,sifat_pekerjaan.*, now() as sekarang "
                . " from pekerjaan inner join sifat_pekerjaan "
                . "on sifat_pekerjaan.id_sifat_pekerjaan = pekerjaan.id_sifat_pekerjaan "
                . "where pekerjaan.id_pekerjaan = " . $id_detail_pkj . " limit $limit offset $offset;";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_progress_pekerjaan($id_detail_pkj) {
        $query = "select * from detil_pekerjaan inner join pekerjaan "
                . "on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan "
                . "inner join sifat_pekerjaan on sifat_pekerjaan.id_sifat_pekerjaan "
                . "= pekerjaan.id_sifat_pekerjaan inner join akun on akun.id_akun "
                . "= detil_pekerjaan.id_akun where pekerjaan.id_pekerjaan = " .
                $id_detail_pkj . " and akun.id_akun = " . $this->session->userdata('user_id') . ";";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_progress_by_id($list_id_progress) {
        if (count($list_id_progress) == 0)
            return NULL;
        $query = "select * from detil_progress where id_detil_progress in (" . implode(',', $list_id_progress) . ")";
        $query = $this->db->query($query);
        return $query->result();
    }

    //membaca detil progress seorang staff untuk seluruh pekerjaannya
    public function get_progress_per_staff($id_akun) {
        if (count($id_akun) == 0)
            return NULL;
        $query = "select detil_progress.*, detil_pekerjaan.id_pekerjaan from detil_pekerjaan inner join detil_progress on detil_progress.id_detil_pekerjaan="
                . "detil_pekerjaan.id_detil_pekerjaan inner join pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan "
                . "where detil_pekerjaan.id_akun in (" . implode(",", $id_akun) . ") and pekerjaan.flag_usulan='2' "
                . "order by detil_progress.waktu,detil_pekerjaan.id_detil_pekerjaan,detil_progress.id_detil_progress";
        return $this->db->query($query)->result();
    }

    public function sp_updateprogress_pekerjaan($data, $id_detail_pkj) {
        $query = "update detil_pekerjaan set progress =" . $data . " where id_detil_pekerjaan =" . $id_detail_pkj;
        //$query2 = "insert into detil_progress (id_detil_pekerjaan,deskripsi,progress,total_progress,waktu) values ('".$id_detail_pkj."','".$deskripsi."','".$data."','100','now()');";
        if ($this->db->query($query)) {
            $query = "update detil_pekerjaan set tglasli_mulai=now() where id_detil_pekerjaan=$id_detail_pkj and tglasli_mulai is null";
            $this->db->query($query);
            return 1;
        }
        return 0;
    }

    public function sp_tambah_progress($data, $id_detail_pkj, $deskripsi) {
        //$query = "update detil_pekerjaan set progress =" . $data . " where id_detil_pekerjaan =" . $id_detail_pkj;
        $query = "insert into detil_progress (id_detil_pekerjaan,deksripsi,progress,total_progress,waktu) values ('" . $id_detail_pkj . "','" . $deskripsi . "','" . $data . "','100','now()');";
        if ($this->db->query($query)) {
            $id_progress = $this->db->query("select currval('detil_progress_id_detil_progress_seq') as id_baru")->result();
            //var_dump($id_progress                    );
            return $id_progress[0]->id_baru;
        }
        return null;
    }

    public function sp_lihat_progress($id_akun, $id_detail_pkj) {
        $query = "select * from detil_pekerjaan" .
                " where detil_pekerjaan.id_akun = $id_akun and detil_pekerjaan.id_detil_pekerjaan = $id_detail_pkj";

        return $this->db->query($query)->result();
    }

    public function sp_history_progress($id_akun, $id_detail_pkj) {
        $query = "select *, detil_progress.progress from detil_progress inner join detil_pekerjaan on detil_pekerjaan.id_detil_pekerjaan = detil_progress.id_detil_pekerjaan" .
                " inner join pekerjaan on pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan where detil_pekerjaan.id_akun = $id_akun and detil_progress.id_detil_pekerjaan = $id_detail_pkj order by detil_progress.waktu DESC";

        return $this->db->query($query)->result();
    }

    public function sp_file_progress($id_detail_pkj) {
        $query = "select * from file where id_pekerjaan = $id_detail_pkj order by waktu DESC";

        return $this->db->query($query)->result();
    }

    public function sp_listassign_pekerjaan($id_detail_pkj, $offset = 0, $limit = 100) {
        $query = "select detil_pekerjaan.*,pekerjaan.*,sifat_pekerjaan.*"
                . "from detil_pekerjaan inner join pekerjaan on "
                . "pekerjaan.id_pekerjaan = detil_pekerjaan.id_pekerjaan "
                . "inner join sifat_pekerjaan on sifat_pekerjaan.id_sifat_pekerjaan "
                . "= pekerjaan.id_sifat_pekerjaan where pekerjaan.id_pekerjaan = "
                . $id_detail_pkj . "  ";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_tambah_komentar_pekerjaan($id_detail_pkj, $id_akun, $isi_komentar) {
        $query = "insert into komentar (id_akun, id_pekerjaan, isi_komentar, tgl_komentar, history_komentar) values ('" . $id_akun . "','" . $id_detail_pkj . "','" . $isi_komentar . "','now()','null');";
        $query = $this->db->query($query);
    }

    public function sp_hapus_komentar_pekerjaan($id_komentar) {
        $query = "delete from komentar where id_komentar = " . $id_komentar;
        $query = $this->db->query($query);
    }

    public function sp_ubah_komentar_pekerjaan($id_komentar, $isi_komen) {
        $query = "update komentar set isi_komentar = '" . $isi_komen . "', tgl_komentar = now() where id_komentar = " . $id_komentar;
        $query = $this->db->query($query);
    }

    public function sp_lihat_komentar_pekerjaan($id_detail_pkj, $offset = 0, $limit = 100) {
        $query = "select * from komentar inner join pekerjaan on pekerjaan.id_pekerjaan = komentar.id_pekerjaan  where komentar.id_pekerjaan = " . $id_detail_pkj . " order by tgl_komentar DESC limit $limit offset $offset;";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function sp_lihat_komentar_pekerjaan_by_id($id_komentar) {
        $query = "select * from komentar where komentar.id_komentar = " . $id_komentar . "  order by tgl_komentar DESC;";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_list_draft($user_id, $offset = 0, $limit = 100) {
        $query = "select pekerjaan.* from pekerjaan 
                where (flag_usulan='5' 
                or pekerjaan.id_pekerjaan not in 
                    (select detil_pekerjaan.id_pekerjaan from detil_pekerjaan)) 
                and id_penanggung_jawab='$user_id' 
                order by pekerjaan.level_prioritas limit $limit offset $offset
                ";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_list_tipe_nilai() {
        $qeury = $this->db->get('tipe_nilai');
        return $qeury->result();
    }

    public function get_list_usulan_pekerjaan($list_id_akun, $offset = 0, $limit = 100) {
        if (count($list_id_akun) == 0)
            return NULL;
        $query = "select detil_pekerjaan.id_detil_pekerjaan, pekerjaan.nama_pekerjaan, pekerjaan.tgl_mulai, "
                . "to_char(pekerjaan.tgl_mulai,'DD Mon YYYY') as tanggal_mulai, to_char(pekerjaan.tgl_selesai,'DD Mon YYYY') as tanggal_selesai, " .
                "pekerjaan.tgl_selesai, pekerjaan.flag_usulan, pekerjaan.id_pekerjaan, detil_pekerjaan.id_akun " .
                "from detil_pekerjaan " .
                "inner join pekerjaan on pekerjaan.id_pekerjaan=detil_pekerjaan.id_pekerjaan " .
                "where pekerjaan.flag_usulan='1' and detil_pekerjaan.status!='Batal' and id_akun in (" . implode(",", $list_id_akun) . ") "
                . "limit $limit offset $offset";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function validasi_pekerjaan($id_pekerjaan) {
        $id_pekerjaan = pg_escape_string($id_pekerjaan);
        $query = "update pekerjaan set flag_usulan=2 where id_pekerjaan=" . $id_pekerjaan;
        if ($this->db->query($query)) {
            $query = "update detil_pekerjaan set status='Belum Dibaca', tgl_read=null, tglasli_mulai=null, tglasli_selesai=null, skor=0, progress=0 where id_pekerjaan=$id_pekerjaan";
            $this->db->query($query);
            return 1;
        }
        return 0;
    }

    public function baca_pending_task($id_pekerjaan, $id_user) {
        if ($id_pekerjaan != NULL && $id_user != NULL && strlen($id_pekerjaan) > 0 &&
                strlen($id_user) > 0) {
            $query = "update detil_pekerjaan set tgl_read=now() where id_akun=$id_user and "
                    . "id_pekerjaan=$id_pekerjaan and tgl_read is null";
            $query = "update detil_pekerjaan set tgl_read=now(), status='Sudah Dibaca' "
                    . "from pekerjaan where id_akun=$id_user "
                    . "and pekerjaan.id_pekerjaan=$id_pekerjaan and tgl_read is null and "
                    . "pekerjaan.flag_usulan='2' and pekerjaan.id_pekerjaan = "
                    . "detil_pekerjaan.id_pekerjaan";
            $this->db->query($query);
        }
    }

    public function get_status_usulan($id_pekerjaan) {
        $query = "select flag_usulan from pekerjaan where id_pekerjaan = $id_pekerjaan";
        $query = $this->db->query($query);
        foreach ($query->result() as $row) {
            return $row->flag_usulan;
        }
        return NULL;
    }

    public function get_pekerjaan($id_pekerjaan) {
//        $query = "select pekerjaan.*, now() as sekarang from pekerjaan "
//                . "where pekerjaan.id_pekerjaan = $id_pekerjaan";
//        $query = $this->db->query($query);
        $q = $this->db->query("select *,now() from pekerjaan p inner join sifat_pekerjaan s on s.id_sifat_pekerjaan=p.id_sifat_pekerjaan where id_pekerjaan='$id_pekerjaan'")->result_array();
        if (count($q) > 0) {
            return $q[0];
        }
        return null;
//        return $query->result();
    }

    public function get_pekerjaan_staff($list_staff, $offset = 0, $limit = 100) {
        if (count($list_staff) == 0)
            return NULL;
        $query = "select pekerjaan.*,detil_pekerjaan.*, now() as sekarang "
                . "from pekerjaan inner join detil_pekerjaan on "
                . "detil_pekerjaan.id_pekerjaan=pekerjaan.id_pekerjaan "
                . "where pekerjaan.flag_usulan in ('1','2','9') "
                . "and detil_pekerjaan.id_akun in (" . implode(",", $list_staff) . ")"
                . "order by pekerjaan.id_pekerjaan limit $limit offset $offset";
        $query = "select pekerjaan.*,detil_pekerjaan.*, now() as sekarang, to_char(pekerjaan.tgl_mulai,'YYYY-MM-DD') as tanggal_mulai,to_char(pekerjaan.tgl_selesai,'YYYY-MM-DD') as tanggal_selesai  "
                . "from pekerjaan inner join detil_pekerjaan on "
                . "detil_pekerjaan.id_pekerjaan=pekerjaan.id_pekerjaan "
                . "where pekerjaan.flag_usulan in ('1','2','9') "
                . "and detil_pekerjaan.id_akun in (" . implode(",", $list_staff) . ")"
                . "order by pekerjaan.id_pekerjaan";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_draft($list_id_draft, $offset = 0, $limit = 100) {
        if (count($list_id_draft) == 0)
            return NULL;
        $query = 'select pekerjaan.*,sifat_pekerjaan.* from pekerjaan inner join '
                . ' sifat_pekerjaan '
                . 'on sifat_pekerjaan.id_sifat_pekerjaan=pekerjaan.id_sifat_pekerjaan '
                . 'where pekerjaan.id_pekerjaan in (' . implode(',', $list_id_draft) . ') '
                . 'order by pekerjaan.id_pekerjaan limit ' . $limit . ' offset ' . $offset;
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_detil_pekerjaan($list_id_pekerjaan, $offset = 0, $limit = 100) {
        if (count($list_id_pekerjaan) == 0)
            return NULL;
        $query = "select detil_pekerjaan.*, now() as sekarang "
                . "from detil_pekerjaan inner join pekerjaan on pekerjaan.id_pekerjaan="
                . "detil_pekerjaan.id_pekerjaan where detil_pekerjaan.status!='Batal' and "
                . "detil_pekerjaan.id_pekerjaan in "
                . "(" . implode(",", $list_id_pekerjaan) . ") "
                . "order by detil_pekerjaan.id_pekerjaan, detil_pekerjaan.id_detil_pekerjaan "
                . "limit $limit offset $offset";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_detil_pekerjaan_by_id($list_id_detil_pekerjaan) {
        if (count($list_id_detil_pekerjaan) == 0)
            return NULL;
        $query = "select * from detil_pekerjaan where id_detil_pekerjaan in (" . implode(',', $list_id_detil_pekerjaan) . ')';
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_detil_pekerjaan_of_staff($list_id_pekerjaan, $id_staff, $offset = 0, $limit = 100) {
        if (count($list_id_pekerjaan) == 0)
            return NULL;
        $query = "select detil_pekerjaan.*, pekerjaan.*"
                . "from detil_pekerjaan inner join pekerjaan on pekerjaan.id_pekerjaan="
                . "detil_pekerjaan.id_pekerjaan where detil_pekerjaan.status!='Batal' and "
                . "detil_pekerjaan.id_pekerjaan in "
                . "(" . implode(",", $list_id_pekerjaan) . ") and detil_pekerjaan.id_akun=$id_staff "
                . "and detil_pekerjaan.status!='Batal' "
                . "order by detil_pekerjaan.id_pekerjaan, detil_pekerjaan.id_detil_pekerjaan "
                . "limit $limit offset $offset";
        //echo $query;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function update_pekerjaan($update, $id) {
        $this->db->query("set datestyle to 'European'");
        $this->db->where('id_pekerjaan', $id);
        return $this->db->update('pekerjaan', $update);
    }

    public function batalkan_penugasan_staff($id_akun, $id_pekerjaan) {
        $query = "update detil_pekerjaan set status='Batal' "
                . "where id_pekerjaan=$id_pekerjaan and id_akun=$id_akun";
        $query = $this->db->delete('detil_pekerjaan', array('id_pekerjaan' => $id_pekerjaan, 'id_akun' => $id_akun));
        return $query;
    }

    public function batalkan_task($id_pekerjaan) {
        $query = "delete from detil_progress where detil_progress.id_detil_pekerjaan in (select detil_pekerjaan.id_detil_pekerjaan from detil_pekerjaan where detil_pekerjaan.id_pekerjaan='$id_pekerjaan')";
        $this->db->query($query);
        $query = "delete from komentar where id_pekerjaan='$id_pekerjaan'";
        $this->db->query($query);
        $query = "delete from nilai_pekerjaan where id_detil_pekerjaan in 
                (select id_detil_pekerjaan from detil_pekerjaan 
                where id_pekerjaan='$id_pekerjaan')";
        $this->db->query($query);
        $query = "delete from detil_pekerjaan where id_pekerjaan='$id_pekerjaan' ";
        $this->db->query($query);
        //$query = "update detil_pekerjaan set status='Batal' where id_pekerjaan='$id_pekerjaan' ";
        //$query2 = "update pekerjaan set flag_usulan='3' where id_pekerjaan='$id_pekerjaan'";
        ///$this->db->query($query); //&& $this->db->query($query2);
        $query = "delete from pekerjaan where id_pekerjaan='$id_pekerjaan' ";
        $this->db->query($query);
        return true;
    }

}

?>