<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pekerjaan_saya_model
 *
 * @author mozar
 */
require_once APPPATH . '/libraries/dtpg.php';

class pekerjaan_saya_model extends dtpg {

    function get_list_pekerjaan_saya_datatable($request, $userId) {
        $sql = "select p.id_pekerjaan, p.nama_pekerjaan,
            concat(p.tgl_mulai, p.tgl_selesai) as deadline,
            0 as assignto, s.status_nama
            from pekerjaan p
            left join status s
            on s.status_id=p.status_pekerjaan
            where p.id_pekerjaan in (
                select dp.id_pekerjaan
                from detil_pekerjaan dp
                where dp.id_akun = '$userId'
            )";
        $sql="select 
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
             where dp.id_akun='$userId'";
        $columns = array(
            array('name' => 'id_pekerjaan'),
            array('name' => 'nama_pekerjaan'),
            array('name' => 'tgl_mulai'),
            array('name' => 'id_akuns'),
            array('name' => 'status_pekerjaan2'),
            array('name' => 'tgl_selesai')
        );
        return $this->get_datatable($sql, $columns, $request);
    }

}
