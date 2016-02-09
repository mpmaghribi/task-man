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
    1=>'Januari',
    2=>'Februari',
    3=>'Maret',
    4=>'April',
    5=>'Mei',
    6=>'Juni',
    7=>'Juli',
    8=>'Agustus',
    9=>'September',
    10=>'Oktober',
    11=>'November',
    12=>'Desember'
);

$this->load->library('excel');
$xls = new PHPExcel();
$sheet = $xls->setActiveSheetIndex(0);
$sheet->setCellValue('A1', 'FORMULIR SASARAN KERJA')->mergeCells('a1:k1');
$sheet->setCellValue('A2', 'PEGAWAI NEGERI SIPIL')->mergeCells('a2:k2');
$sheet->getStyle('a1:k2')->applyFromArray(array('font'=>array('bold'=>true),'alignment'=>array('horizontal'=>'center')));
$sheet->getColumnDimension('a')->setWidth(4);
$sheet->getColumnDimension('b')->setWidth(20);
$sheet->getColumnDimension('c')->setWidth(70);
$sheet->getColumnDimension('d')->setWidth(4);
$sheet->getColumnDimension('e')->setWidth(5);
$sheet->getColumnDimension('f')->setWidth(6);
$sheet->getColumnDimension('g')->setWidth(5);
$sheet->getColumnDimension('h')->setWidth(13);
$sheet->getColumnDimension('i')->setWidth(5);
$sheet->getColumnDimension('j')->setWidth(5);
$sheet->getColumnDimension('k')->setWidth(13);

$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'I. PEJABAT PENILAI');
$sheet->setCellValue('D3', 'NO');
$sheet->setCellValue('E3', 'II. PEGAWAI NEGERI SIPIL YANG DINILAI');
$sheet->setCellValue('A4', '1');
$sheet->setCellValue('B4', 'Nama');
$sheet->setCellValue('c4', $data_atasan->nama);
$sheet->setCellValue('d4', '1');
$sheet->setCellValue('e4', 'Nama');
$sheet->setCellValue('h4', $data_staff->nama);
$sheet->setCellValue('a5', '2');
$sheet->setCellValue('b5', 'NIP');
$sheet->setCellValue('c5', $data_atasan->nip);
$sheet->setCellValue('d5', '2');
$sheet->setCellValue('e5', 'NIP');
$sheet->setCellValue('h5', $data_staff->nip);
$sheet->setCellValue('a6', '3');
$sheet->setCellValue('b6', 'Pangkat/Gol. Ruang');
$sheet->setCellValue('c6', '-');
$sheet->setCellValue('d6', '3');
$sheet->setCellValue('e6', 'Pangkat/Gol. Ruang');
$sheet->setCellValue('h6', '-');
$sheet->setCellValue('A7', '4');
$sheet->setCellValue('b7', 'Jabatan');
$sheet->setCellValue('c7', $data_atasan->nama_jabatan);
$sheet->setCellValue('d7', '4');
$sheet->setCellValue('e7', 'Jabatan');
$sheet->setCellValue('h7', $data_staff->nama_jabatan);
$sheet->setCellValue('a8', '5');
$sheet->setCellValue('b8', 'Unit Kerja');
$sheet->setCellValue('c8', $data_atasan->nama_departemen);
$sheet->setCellValue('d8', '5');
$sheet->setCellValue('e8', 'Unit Kerja');
$sheet->setCellValue('h8', $data_staff->nama_departemen);
$sheet->setCellValue('a10', 'NO');
$sheet->setCellValue('b10', 'III. KEGIATAN TUGAS JABATAN');
$sheet->setCellValue('D10', 'AK');
$sheet->setCellValue('e10', 'TARGET');
$sheet->setCellValue('e11', 'KUANT/OUTPUT');
$sheet->setCellValue('H11', 'KUAL/MUTU');
$sheet->setCellValue('I11', 'WAKTU');
$sheet->setCellValue('K11', 'BIAYA');
$sheet->getStyle('a4:d8')->applyFromArray(array('alignment'=>array('horizontal'=>'center')));
$sheet->getStyle('b4:c8')->applyFromArray(array('alignment'=>array('horizontal'=>'left')));
$sheet->getStyle('e4:h8')->applyFromArray(array('alignment'=>array('horizontal'=>'left')));
$row_number = 11;
$row_data_skp = 11;
$counter=0;
foreach($nilai_skp as $skp){
    if(in_array($skp['kategori'], array('rutin','project'))==false){
        continue;
    }
    $row_number++;
    $counter++;
    $sheet->setCellValue('a'.$row_number, $counter);
    $sheet->setCellValue('b'.$row_number, $skp['nama_pekerjaan']);
    $sheet->setCellValue('d'.$row_number, $skp['sasaran_angka_kredit']);
    $sheet->setCellValue('e'.$row_number, $skp['sasaran_kuantitas_output']);
    $sheet->setCellValue('f'.$row_number, $skp['satuan_kuantitas']);
    $sheet->setCellValue('h'.$row_number, $skp['sasaran_kualitas_mutu'].'%');
    $sheet->setCellValue('i'.$row_number, $skp['sasaran_waktu']);
    $sheet->setCellValue('j'.$row_number, $skp['satuan_waktu']);
    $sheet->setCellValue('k'.$row_number, ($skp['pakai_biaya'] == '1' ? 'Rp. ' . number_format($skp['sasaran_biaya'],2,',','.') : '-'));
    $sheet->getStyle('a1:k'.$row_number)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
}
$sheet->mergeCells('e11:g11');
$sheet->mergeCells('i11:j11');
$sheet->mergeCells('e10:k10');
$sheet->getRowDimension(9)->setRowHeight(2);
$sheet->getStyle('e10:k11')->applyFromArray(array('alignment'=>array('horizontal'=>'center')));

$sheet->getStyle('a3:k3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('a3:k3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('a1:a'.$row_number)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('a1:a'.$row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('c4:c8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('h4:h8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('k3:k'.$row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('a8:k8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('a11:k11')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('e10:k10')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('d1:d'.$row_number)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('d1:d'.$row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('h11:h'.$row_number)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('h11:h'.$row_number)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('k11:k'.$row_number)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$row_number+=2;
$sheet->setCellValue('h'.$row_number, 'Surabaya, ' . date('d').' '.$nama_bulan[intval(date('m'))].' '.date('Y'));
$row_number++;
$sheet->setCellValue('c'.$row_number, 'Pejabat Penilai');
$sheet->setCellValue('h'.$row_number, 'Pegawai Negeri yang Dinilai');
$row_number+=3;
$sheet->setCellValue('c'.$row_number, $data_atasan->nama);
$sheet->setCellValue('h'.$row_number, $data_staff->nama);
$row_number++;
$sheet->setCellValue('c'.$row_number, $data_atasan->nip);
$sheet->setCellValue('h'.$row_number, $data_staff->nip);
$sheet->getStyle('c'.$row_number.':k'.$row_number)->applyFromArray(array('alignment'=>array('horizontal'=>'left')));
$xls_out = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Formulir CKP '.$data_staff->nama.' - '.$periode.'.xls"');
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