<?php

//echo 'hehe';
$nama_periode = array(
    'januari' => 'Januari',
    'februari' => 'Februari',
    'maret' => 'Maret',
    'april' => 'April',
    'mei' => 'Mei',
    'juni' => 'Juni',
    'juli' => 'Juli',
    'agustus' => 'Agustus',
    'september' => 'September',
    'oktober' => 'Oktober',
    'november' => 'November',
    'desember' => 'Desember',
    'tri_1' => 'Triwulan I',
    'tri_2' => 'Triwulan II',
    'tri_3' => 'Triwulan III',
    'tri_4' => 'Triwulan IV',
    'sms_1' => 'Semester I',
    'sms_2' => 'Semester II'
);

$nama_bulan = array(
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
);

$this->load->library('excel');
$xls = new PHPExcel();

$sheet = $xls->setActiveSheetIndex(0);
$sheet->setCellValue('A1', 'PENILAIAN CAPAIAN SASARAN KERJA')->mergeCells('a1:k1');
$sheet->setCellValue('A2', 'PEGAWAI NEGERI SIPIL')->mergeCells('a2:k2');
$sheet->setCellValue('A3', 'Jangka Waktu Penilaian');
$sheet->getStyle('a1:k2')->applyFromArray(array('font' => array('bold' => true), 'alignment' => array('horizontal' => 'center')));
$sheet->getColumnDimension('a')->setWidth(4);
$sheet->getColumnDimension('b')->setWidth(70);
$sheet->getColumnDimension('c')->setWidth(6);
$sheet->getColumnDimension('d')->setWidth(6);
$sheet->getColumnDimension('e')->setWidth(6);
$sheet->getColumnDimension('f')->setWidth(6);
$sheet->getColumnDimension('g')->setWidth(6);
$sheet->getColumnDimension('h')->setWidth(6);
$sheet->getColumnDimension('i')->setWidth(10);
$sheet->getColumnDimension('j')->setWidth(6);
$sheet->getColumnDimension('k')->setWidth(6);
$sheet->getColumnDimension('l')->setWidth(6);
$sheet->getColumnDimension('m')->setWidth(6);
$sheet->getColumnDimension('n')->setWidth(6);
$sheet->getColumnDimension('o')->setWidth(6);
$sheet->getColumnDimension('p')->setWidth(10);
$sheet->getColumnDimension('q')->setWidth(16);
$sheet->getColumnDimension('r')->setWidth(17);


$sheet->setCellValue('A4', 'NO');
$sheet->setCellValue('A6', '1');
$sheet->setCellValue('b4', 'I. Kegiatan Tugas Jabatan');
$sheet->setCellValue('b6', '2');
$sheet->setCellValue('c4', 'AK');
$sheet->setCellValue('c6', '3');
$sheet->setCellValue('d4', 'TARGET');
$sheet->setCellValue('d6', '4');
$sheet->setCellValue('J4', 'AK');
$sheet->setCellValue('f6', '5');
$sheet->setCellValue('g6', '6');
$sheet->setCellValue('i6', '7');
$sheet->setCellValue('j6', '8');
$sheet->setCellValue('k6', '9');
$sheet->setCellValue('m6', '10');
$sheet->setCellValue('n6', '11');
$sheet->setCellValue('p6', '12');
$sheet->setCellValue('q6', '13');
$sheet->setCellValue('r6', '14');
$sheet->setCellValue('K4', 'REALISASI');
$sheet->setCellValue('Q4', 'PENGHITUNGAN');
$sheet->setCellValue('R4', 'NILAI CAPAIAN SKP');
$sheet->setCellValue('D5', 'Kuant/Output');
$sheet->setCellValue('f5', 'Kual/Mutu');
$sheet->setCellValue('g5', 'Waktu');
$sheet->setCellValue('i5', 'Biaya');
$sheet->setCellValue('k5', 'Kuant/Output');
$sheet->setCellValue('m5', 'Kual/Mutu');
$sheet->setCellValue('n5', 'Waktu');
$sheet->setCellValue('p5', 'Biaya');

$row_number = 6;
$row_data_skp = 6;
$counter = 0;
$total_skor = 0;
foreach ($nilai_skp as $skp) {
    if (in_array($skp['kategori'], array('rutin', 'project')) == false) {
        continue;
    }
    $row_number++;
    $counter++;
    $sheet->setCellValue('a' . $row_number, $counter);
    $sheet->setCellValue('b' . $row_number, $skp['nama_pekerjaan']);

    $sheet->setCellValue('c' . $row_number, $skp['sasaran_angka_kredit']);
    $sheet->setCellValue('d' . $row_number, $skp['sasaran_kuantitas_output']);
    $sheet->setCellValue('e' . $row_number, $skp['satuan_kuantitas']);
    $sheet->setCellValue('f' . $row_number, $skp['sasaran_kualitas_mutu'] . '%');
    $sheet->setCellValue('g' . $row_number, $skp['sasaran_waktu']);
    $sheet->setCellValue('h' . $row_number, $skp['satuan_waktu']);
    $sheet->setCellValue('i' . $row_number, ($skp['pakai_biaya'] == '1' ? $skp['sasaran_biaya'] : '-'));

    $sheet->setCellValue('j' . $row_number, $skp['realisasi_angka_kredit']);
    $sheet->setCellValue('k' . $row_number, $skp['realisasi_kuantitas_output']);
    $sheet->setCellValue('l' . $row_number, $skp['satuan_kuantitas']);
    $sheet->setCellValue('m' . $row_number, $skp['realisasi_kualitas_mutu'] . '%');
    $sheet->setCellValue('n' . $row_number, $skp['realisasi_waktu']);
    $sheet->setCellValue('o' . $row_number, $skp['satuan_waktu']);
    $sheet->setCellValue('p' . $row_number, ($skp['pakai_biaya'] == '1' ? $skp['realisasi_biaya'] : '-'));



    $sheet->setCellValue('t' . $row_number, '=IF(D' . $row_number . '>0,1,0)');

    $sheet->setCellValue('w' . $row_number, '=100-(N' . $row_number . '/G' . $row_number . '*100)');
    $sheet->setCellValue('x' . $row_number, '=100-(P' . $row_number . '/I' . $row_number . '*100)');
    $sheet->setCellValue('y' . $row_number, '=K' . $row_number . '/D' . $row_number . '*100');
    $sheet->setCellValue('z' . $row_number, '=M' . $row_number . '/F' . $row_number . '*100');

    $sheet->setCellValue('ac' . $row_number, '=((1.76*G' . $row_number . '-N' . $row_number . ')/G' . $row_number . ')*100');
    $sheet->setCellValue('ad' . $row_number, '=76-((((1.76*G' . $row_number . '-N' . $row_number . ')/G' . $row_number . ')*100)-100)');
    $sheet->setCellValue('ae' . $row_number, '=((1.76*I' . $row_number . '-P' . $row_number . ')/I' . $row_number . ')*100');
    $sheet->setCellValue('af' . $row_number, '=76-((((1.76*I' . $row_number . '-P' . $row_number . ')/I' . $row_number . ')*100)-100)');
    $sheet->setCellValue('aa' . $row_number, '=IF(W' . $row_number . '>24,AD' . $row_number . ',AC' . $row_number . ')');
    $sheet->setCellValue('ab' . $row_number, '=IF(X' . $row_number . '>24,AF' . $row_number . ',AE' . $row_number . ')');
    $sheet->setCellValue('ag' . $row_number, '=IFERROR(SUM(Y' . $row_number . ':AB' . $row_number . '),SUM(Y' . $row_number . ':AA' . $row_number . '))');
    $sheet->setCellValue('q' . $row_number, '=AG' . $row_number);
    $sheet->setCellValue('r' . $row_number, '=IF(I' . $row_number . '="-",IF(P' . $row_number . '="-",Q' . $row_number . '/3,Q' . $row_number . '/4),Q' . $row_number . '/4)');

    $sheet->setCellValue('u' . $row_number, '=IFERROR(R' . $row_number . ',0)');


    $detil_pekerjaan = $skp;
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
    $total_skor+=$skor;

    $sheet->setCellValue('q' . $row_number, round($penghitungan, 2));
    $sheet->setCellValue('r' . $row_number, round($skor, 2));

    $sheet->getStyle('a1:r' . $row_number)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
}
$row_number++;
$sheet->setCellValue('a' . $row_number, 'NILAI CAPAIAN SKP');
$sheet->setCellValue('r' . $row_number, '=sum(r7:r' . ($row_number - 1) . ')');
$row_number++;
$sheet->setCellValue('r' . $row_number, $total_skor <= 50 ? 'Buruk' : ($total_skor <= 60 ? 'Sedang' : ($total_skor <= 75 ? 'Cukup' : ($total_skor <= 90.99 ? 'Baik' : 'Sangat Baik'))));

$sheet->getStyle('a6:r6')->applyFromArray(array('alignment' => array('horizontal' => 'center', 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font' => array('size' => 5, 'bold' => true), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'C0C0C0'))));
$sheet->getStyle('a4:r5')->applyFromArray(array('alignment' => array('horizontal' => 'center', 'vertical' => 'center'), 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));

$sheet->getStyle('a4:a' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('b4:b' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('c4:c' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('e4:e' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('f4:f' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('h4:h' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('i4:i' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('j4:j' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('l4:l' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('m4:m' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('o4:o' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('p4:p' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('q4:q' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('r4:r' . $row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->mergeCells('a4:a5');
$sheet->mergeCells('b4:b5');
$sheet->mergeCells('c4:c5');
$sheet->mergeCells('j4:j5');
$sheet->mergeCells('q4:q5');
$sheet->mergeCells('r4:r5');
$sheet->mergeCells('d4:i4');
$sheet->mergeCells('k4:p4');
$sheet->mergeCells('d5:e5');
$sheet->mergeCells('g5:h5');
$sheet->mergeCells('k5:l5');
$sheet->mergeCells('n5:o5');
$sheet->mergeCells('d6:e6');
$sheet->mergeCells('g6:h6');
$sheet->mergeCells('k6:l6');
$sheet->mergeCells('n6:o6');
$sheet->mergeCells('a' . ($row_number - 1) . ':q' . $row_number);
$sheet->getStyle('a' . ($row_number - 1) . ':r' . $row_number)->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => 'center',
                'vertical' => 'center'),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'font' => array(
                'bold' => true
            )
        )
);

$row_number+=2;
$sheet->setCellValue('h' . $row_number, 'Surabaya, ' . date('d') . ' ' . $nama_bulan[intval(date('m'))] . ' ' . date('Y'));
$row_number++;
$sheet->setCellValue('b' . $row_number, 'Pejabat Penilai');
$sheet->setCellValue('h' . $row_number, 'Pegawai Negeri yang Dinilai');
$row_number+=3;
$sheet->setCellValue('b' . $row_number, $data_atasan->nama);
$sheet->setCellValue('h' . $row_number, $data_staff->nama);
$row_number++;
$sheet->setCellValue('b' . $row_number, $data_atasan->nip);
$sheet->setCellValue('h' . $row_number, $data_staff->nip);
$sheet->getStyle('b' . $row_number . ':k' . $row_number)->applyFromArray(array('alignment' => array('horizontal' => 'left')));
$xls_out = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
$xls_out->setPreCalculateFormulas(false);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Formulir CKP ' . $data_staff->nama . ' - ' . $periode . '.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
//header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//header ('Pragma: public'); // HTTP/1.0
//unduh file
//ob_end_clean();
$xls_out->save("php://output");
exit(0);
