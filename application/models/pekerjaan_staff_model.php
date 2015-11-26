<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pekerjaan_staff_model
 *
 * @author mozar
 */
require_once APPPATH . '/libraries/dtpg.php';

class pekerjaan_staff_model extends dtpg {

    function get_list_skp_staff_datatable($my_id = 0, $id_staff = 0, $request = array()) {
        $sql = "select 
            case when dp.tgl_read is null then '1, Belum Dilihat'
                 when dp.tgl_read is not null and dp.sasaran_kuantitas_output <= dp.realisasi_kuantitas_output then '4, Selesai'
                 when dp.tgl_read is not null and now()::date > p.tgl_selesai::date then '5, Terlambat'
                 when dp.tgl_read is not null and now()::date <= p.tgl_selesai::date then '3, Dikerjakan'
                 when dp.tgl_read is not null then '2, Sudah Dibaca'
                 else '10, Undefined'
            end as status_pekerjaan2,
            p.*, 
            dp.sasaran_kuantitas_output, 
            dp.sasaran_waktu, 
            dp.realisasi_kuantitas_output, 
            dp.realisasi_waktu,
            dp.id_akun,
            dp2.id_akuns,
            now() as sekarang
             from pekerjaan p 
             inner join detil_pekerjaan dp
             on p.id_pekerjaan=dp.id_pekerjaan
             inner join (
		select array_agg(dp2.id_akun)as id_akuns, dp2.id_pekerjaan 
                from detil_pekerjaan dp2 
                group by dp2.id_pekerjaan
	     ) as dp2
             on dp2.id_pekerjaan=p.id_pekerjaan
             where p.id_penanggung_jawab='$my_id'
             and dp.id_akun='$id_staff'";
        $columns = array(
            array('name' => 'id_pekerjaan'),
            array('name' => 'nama_pekerjaan'),
            array('name' => 'periode'),
            array('name' => 'id_akuns'),
            array('name' => 'sasaran_kuantitas_output'),
            array('name' => 'sasaran_waktu'),
            array('name' => 'realisasi_kuantitas_output'),
            array('name' => 'realisasi_waktu'),
            array('name' => 'sekarang'),
            array('name' => 'status_pekerjaan2')
        );
        return $this->get_datatable($sql, $columns, $request);
    }

    function get_list_skp_staff($my_id = 0, $id_staff = 0, $periode = 0) {
        $sql = "select 
            case when dp.tgl_read is null then '1, Belum Dilihat'
                 when dp.tgl_read is not null and dp.sasaran_kuantitas_output <= dp.realisasi_kuantitas_output then '4, Selesai'
                 when dp.tgl_read is not null and now()::date > p.tgl_selesai::date then '5, Terlambat'
                 when dp.tgl_read is not null and now()::date <= p.tgl_selesai::date then '3, Dikerjakan'
                 when dp.tgl_read is not null then '2, Sudah Dibaca'
                 else '10, Undefined'
            end as status_pekerjaan2,
            p.*, 
            dp.sasaran_kuantitas_output, 
            dp.sasaran_waktu, 
            dp.realisasi_kuantitas_output, 
            dp.realisasi_waktu,
            dp.id_akun,
            dp2.id_akuns,
            now() as sekarang
             from pekerjaan p 
             inner join detil_pekerjaan dp
             on p.id_pekerjaan=dp.id_pekerjaan
             inner join (
		select array_agg(dp2.id_akun)as id_akuns, dp2.id_pekerjaan 
                from detil_pekerjaan dp2 
                group by dp2.id_pekerjaan
	     ) as dp2
             on dp2.id_pekerjaan=p.id_pekerjaan
             where p.id_penanggung_jawab='$my_id'
             and (p.periode='$periode' or date_part('year',p.tgl_mulai)='$periode' or date_part('year',p.tgl_selesai)='$periode')
             and dp.id_akun='$id_staff'
             order by p.periode, p.tgl_mulai";
        $sql = "select 
            case when dp.tgl_read is null then '1, Belum Dilihat'
                 when p.kategori='skp' then
                 (
                    case when dp.sasaran_kuantitas_output <= dp.realisasi_kuantitas_output then '4, Selesai'
                        when now()::date > p.tgl_selesai::date then '5, Terlambat'
                        when now()::date <= p.tgl_selesai::date and dp.realisasi_kuantitas_output>0 then '3, Dikerjakan'
                        else '2, Sudah Dibaca'
                    end
                 )
                 else (
                    case when dp.progress>=100 then '3, Selesai'
                        when now()::date > p.tgl_selesai::date then '5, Terlambat'
                        when now()::date <= p.tgl_selesai::date and dp.tglasli_mulai is not null then '3, Dikerjakan'
                        else '2, Sudah Dibaca'
                    end
                 )
            end as status_pekerjaan2,
            p.*, 
            dp.sasaran_kuantitas_output, 
            dp.sasaran_waktu, 
            dp.realisasi_kuantitas_output, 
            dp.realisasi_waktu,
            dp.id_akun,
            dp2.id_akuns,
            now() as sekarang
             from pekerjaan p 
             inner join detil_pekerjaan dp
             on p.id_pekerjaan=dp.id_pekerjaan
             inner join (
		select array_agg(dp2.id_akun)as id_akuns, dp2.id_pekerjaan 
                from detil_pekerjaan dp2 
                group by dp2.id_pekerjaan
	     ) as dp2
             on dp2.id_pekerjaan=p.id_pekerjaan
             where p.id_penanggung_jawab='$my_id'
             and (p.periode='$periode' or date_part('year',p.tgl_mulai)='$periode' or date_part('year',p.tgl_selesai)='$periode')
             and dp.id_akun='$id_staff'
             order by p.periode, p.tgl_mulai";

        return $this->db->query($sql)->result_array();
    }

    function get_list_tugas_tambahan($my_id, $id_staff, $periode) {
        $sql = "select 
            case when dp.tgl_read is null then '1, Belum Dilihat'
                 when dp.tgl_read is not null and dp.sasaran_kuantitas_output <= dp.realisasi_kuantitas_output then '4, Selesai'
                 when dp.tgl_read is not null and now()::date > p.tgl_selesai::date then '5, Terlambat'
                 when dp.tgl_read is not null and now()::date <= p.tgl_selesai::date then '3, Dikerjakan'
                 when dp.tgl_read is not null then '2, Sudah Dibaca'
                 else '10, Undefined'
            end as status_pekerjaan2,
            p.*, 
            dp.sasaran_kuantitas_output, 
            dp.sasaran_waktu, 
            dp.realisasi_kuantitas_output, 
            dp.realisasi_waktu,
            dp.id_akun,
            dp2.id_akuns,
            now() as sekarang
             from pekerjaan p 
             inner join detil_pekerjaan dp
             on p.id_pekerjaan=dp.id_pekerjaan
             inner join (
		select array_agg(dp2.id_akun)as id_akuns, dp2.id_pekerjaan 
                from detil_pekerjaan dp2 
                group by dp2.id_pekerjaan
	     ) as dp2
             on dp2.id_pekerjaan=p.id_pekerjaan
             where p.id_penanggung_jawab='$my_id'
             and p.kategori='tambahan'
             and date_part('year',p.tgl_mulai) = '$periode'
             and dp.id_akun='$id_staff'";

        return $this->db->query($sql)->result_array();
    }

    function get_list_tugas_kreativitas($my_id,$id_staff,$periode) {
        $sql = "select 
            case when dp.tgl_read is null then '1, Belum Dilihat'
                 when dp.tgl_read is not null and dp.sasaran_kuantitas_output <= dp.realisasi_kuantitas_output then '4, Selesai'
                 when dp.tgl_read is not null and now()::date > p.tgl_selesai::date then '5, Terlambat'
                 when dp.tgl_read is not null and now()::date <= p.tgl_selesai::date then '3, Dikerjakan'
                 when dp.tgl_read is not null then '2, Sudah Dibaca'
                 else '10, Undefined'
            end as status_pekerjaan2,
            p.*, 
            dp.sasaran_kuantitas_output, 
            dp.sasaran_waktu, 
            dp.realisasi_kuantitas_output, 
            dp.realisasi_waktu,
            dp.id_akun,
            dp2.id_akuns,
            now() as sekarang
             from pekerjaan p 
             inner join detil_pekerjaan dp
             on p.id_pekerjaan=dp.id_pekerjaan
             inner join (
		select array_agg(dp2.id_akun)as id_akuns, dp2.id_pekerjaan 
                from detil_pekerjaan dp2 
                group by dp2.id_pekerjaan
	     ) as dp2
             on dp2.id_pekerjaan=p.id_pekerjaan
             where p.id_penanggung_jawab='$my_id'
             and p.kategori='kreativitas'
             and date_part('year',p.tgl_mulai) = '$periode'
             and dp.id_akun='$id_staff'";

        return $this->db->query($sql)->result_array();
    }

}
