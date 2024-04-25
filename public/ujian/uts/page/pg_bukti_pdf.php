<?php 
// fungsi enkripsi //
function enkripsime($kata_en, $chipper_en) {
	static $karakter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chipper_en = (int)$chipper_en % 26;
	if (!$chipper_en) return $kata_en;
	if ($chipper_en == 13) return str_rot13($kata_en);
	for ($i = 0, $l = strlen($kata_en); $i < $l; $i++) {
		$c = $kata_en[$i];
		if ($c >= 'a' && $c <= 'z') {
			$kata_en[$i] = $karakter[(ord($c) - 71 + $chipper_en) % 26];
		} else if ($c >= 'A' && $c <= 'Z') {
			$kata_en[$i] = $karakter[(ord($c) - 39 + $chipper_en) % 26 + 26];
		}
	}
	return $kata_en;
}
//====================================//
// FUNCTION REPLACE STRING //
function BackField($input) {
				$input=str_replace("&lt;","<",$input);
				$input=str_replace("&gt;",">",$input);
				$input=str_replace("&amp;","&",$input);
				$input=str_replace("&lsquo;","'",$input);
				$input=str_replace("&rsquo;","'",$input);
				return $input;
			}
//======================================//

$s_id=$_GET["id"];
/* $encode_sid=base64_encode($s_id);
$en_sid=enkripsime($encode_sid, 213091); */
								
$dec_sid=enkripsime($s_id, -213091);
$decode_sid=base64_decode($dec_sid);

$id_user = $decode_sid;
$db_pt=substr($id_user,0,1);
//session_start();
include "line/sambungan.php";

	include "lib/library.php";
	
	$nim=antiinjection($_POST['userid']);
	$test_id=antiinjection($_POST['testid']);
	

	
	if ($nim=="" or $test_id==""){
	?>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base;?> ">
	<?php
	}else{
		$q_bukti=mysql_query("SELECT a.userid,a.resultid, c.user_firstname,c.user_email,c.user_name,a.testid, b.jmlsoal, b.test_type,
							b.test_name, SEC_TO_TIME(a.result_timespent) AS spent_time, 
							MID(FROM_UNIXTIME(b.test_datestart),9,2) AS tanggal, 
							MID(FROM_UNIXTIME(b.test_datestart),6,2) AS bulan,
							LEFT(FROM_UNIXTIME(b.test_datestart),4) AS tahun,
							MID(FROM_UNIXTIME(b.test_dateend),9,2) AS tanggalend, 
							MID(FROM_UNIXTIME(b.test_dateend),6,2) AS bulanend,
							LEFT(FROM_UNIXTIME(b.test_dateend),4) AS tahunend,
							RIGHT(FROM_UNIXTIME(b.test_datestart),8) AS mulai,
							RIGHT(FROM_UNIXTIME(b.test_dateend),8) AS selesai
							FROM ".$db_prefix."results AS a, ".$db_prefix."tests AS b, ".$db_prefix."users AS c 
							WHERE a.testid=b.testid AND a.userid=c.userid AND a.userid='$nim' AND a.testid='$test_id'
							AND b.jmlsoal<=(SELECT COUNT(result_answerid) FROM ".$db_prefix."results_answers AS d WHERE d.resultid=a.resultid)
							ORDER BY a.resultid DESC LIMIT 1 ");
		
		$list_bkt=mysql_fetch_array($q_bukti);
		$datestart=$list_bkt['tanggal'].'/'.$list_bkt['bulan'].'/'.$list_bkt['tahun'] ;
		$dateend=$list_bkt['tanggalend'].'/'.$list_bkt['bulanend'].'/'.$list_bkt['tahunend'] ;
		
		$nim=$list_bkt['user_name'];
		$nama=$list_bkt['user_firstname'];
		$mulai=$list_bkt['mulai'];
		$selesai=$list_bkt['selesai'];
		$matakuliah=$list_bkt['test_name'];
		$kdmtk=substr($list_bkt['test_name'],-3);
		$jmlsoal=$list_bkt['jmlsoal'];
		if($datestart<>$dateend){  $tglujian=$datestart." - ".$dateend; }else{ $tglujian=$datestart; }
		
		
		$q_answerpoint=mysql_fetch_array(mysql_query("SELECT SUM(result_answer_points) as poin FROM ".$db_prefix."results_answers WHERE resultid='$list_bkt[resultid]' ORDER BY result_answerid ASC LIMIT $list_bkt[jmlsoal] "));
		if($list_bkt['test_type']==1){
			$hum_poin="-";
			$hum_poin_fail="-";
		}else{
			$hum_poin=$q_answerpoint['poin'];
			$hum_poin_fail=$list_bkt['jmlsoal'] - $q_answerpoint['poin'];
		}
		//echo $kdmtk;
		$c_c="%b51@bT1";
		$s_code=md5($tgl_sekarang."".$c_c."".$jam_sekarang."".$c_c."".$nim."".$c_c."".$kdmtk."".$c_c."".$list_bkt['jmlsoal']."".$c_c."".$hum_poin."".$c_c."".$hum_poin_fail);
		
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('times', 'I', 11); 
		// Page number
		$this->Cell(0, 15, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-20, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

//==== Cek Result Answer ========//


// Example of Image from data stream ('PHP rules')
$imgdata = base64_decode('iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABlBMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDrEX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==');

// The '@' character is used to indicate that follows an image data stream and not an image file name
$pdf->Image('@'.$imgdata);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
$pdf->Image('images/'.$web_header, 15, 5, 180, 50, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);


// Set some content to print
$html = <<<EOD
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<span style="text-align:center;">Terima Kasih Anda Telah Mengikuti Ujian Online</span><br><br>

<table>
<tr><td width="10%"></td><td width="20%" style="background-color:#c7c7c7;">  NIM</td><td width="1%" style="background-color:#c7c7c7;">:  </td><td width="59%" style="background-color:#c7c7c7;">$nim</td><td width="10%"></td></tr>
<tr><td width="10%"></td><td width="20%" >  Nama</td><td width="1%">:  </td><td width="59%">$nama</td><td width="10%"></td></tr>
<tr><td width="10%"></td><td width="20%" style="background-color:#c7c7c7;">  Tanggal Ujian</td><td style="background-color:#c7c7c7;">:  </td><td width="59%" style="background-color:#c7c7c7;">$tglujian</td><td width="10%"></td></tr>
<tr><td width="10%"></td><td width="20%" >  Jam Ujian</td><td>:  </td><td width="59%">$mulai - $selesai</td></tr>
<tr><td width="10%"></td><td width="20%" style="background-color:#c7c7c7;">  Matakuliah</td><td style="background-color:#c7c7c7;">:  </td><td width="59%" style="background-color:#c7c7c7;">$matakuliah</td><td width="10%"></td></tr>
<tr><td width="10%"></td><td width="20%" >  Jumlah Soal</td><td>:  </td><td width="59%">$jmlsoal</td><td width="10%"></td></tr>
<tr><td width="10%"></td><td width="20%" style="background-color:#c7c7c7;">  Jumlah Jawab <br>&nbsp;&nbsp;Benar</td><td style="background-color:#c7c7c7;">:  </td><td width="59%" style="background-color:#c7c7c7;">$hum_poin</td><td width="10%"></td></tr>
<tr><td width="10%"></td><td width="20%" >  Jumlah Jawab <br>&nbsp;&nbsp;Salah</td><td >:  </td><td width="59%" >$hum_poin_fail</td><td width="10%"></td></tr>
</table>
<br><br>
<span style="text-align:center;">
Simpan sebagai bukti bahwa anda telah mengikuti ujian online
</span>
<br><br><br><br><br><br><br><br><br><br>
<span style="text-align:center;font-size:12px;">
<i>ScurityCode: $s_code</i><br>
		  Tanggal Cetak: $tgl_sekarang - Jam Cetak: $jam_sekarang<br>
</span><br><br>
<img src="images/footer_all.jpg">
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// set style for barcode
$style = array(
	'border' => 0,
	'vpadding' => 1,
	'hpadding' => 1,
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);


// QRCODE,H : QR-CODE Best error correction
$pdf->write2DBarcode($s_code, 'QRCODE,H', 90, 155, 30, 30, $style, 'N');
// CODE 128 A



//=====================================================================================================//
$pdf->AddPage();
$headcode1= <<<EOD
<span style="color:#c7c7c7;font-size:10px;"><i>$tgl_sekarang / $jam_sekarang </i></span><br>
EOD;
$headcode2 = <<<EOD
<span style="color:#c7c7c7;font-size:10px;"><i>$s_code</i></span><br>
EOD;

$pdf->SetFillColor(255, 255, 255);
$pdf->writeHTMLCell(65, 0, '', '', $headcode1, 0, 0, 0, true, '', true);
$pdf->MultiCell(65, 5, '', 0, 'C', 1, 0, '', '', true);
$pdf->writeHTMLCell(65, 0, '', '', $headcode2, 0, 0, 0, true, '', true);
		$pdf->ln();
		
//$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(10, 5, '', 0, 'C', 1, 0, '', '', true);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(0, 1, 0, 1);

// set color for background
$pdf->SetFillColor(199, 199, 199);


	if($list_bkt['test_type']==1){
		$pdf->MultiCell(10, 5, 'No', 1, 'C', 1, 0, '', '', true);
		$pdf->MultiCell(140, 5, 'Jawaban Anda', 1, 'L', 1, 0, '', '', true);
		$pdf->ln();
	}else{
		$pdf->MultiCell(10, 5, 'No', 1, 'C', 1, 0, '', '', true);
		$pdf->MultiCell(120, 5, 'Jawaban Anda', 1, 'L', 1, 0, '', '', true);
		$pdf->MultiCell(25, 5, 'Hasil', 1, 'C', 1, 0, '', '', true);
		$pdf->ln();
	}
	
$q_cekresultans=mysql_query("SELECT result_answerid, resultid, questionid, result_answer_text, result_answer_points FROM ".$db_prefix."results_answers WHERE resultid='$list_bkt[resultid]' ORDER BY result_answerid ASC LIMIT $list_bkt[jmlsoal] ");
while($l_cekresultans=mysql_fetch_array($q_cekresultans)){
	if($list_bkt['test_type']==1){
		$pdf->SetFillColor(255, 255, 255);
		$pdf->MultiCell(10, 5, '', 0, 'C', 1, 0, '', '', true);
		$jawaban=substr($l_cekresultans['result_answer_text'],0,5500);
$jawabhtml = <<<EOD
$jawaban .......
EOD;

		//$jawabanda= $pdf->writeHTMLCell(135, 5, '', '', $jawabhtml, 0, 1, 0, true, '', true);
		//$jawabanda= substr(antiinjection($l_cekresultans['result_answer_text']),0,1000);
		$pdf->MultiCell(10, 5, $l_cekresultans['result_answerid'], 1, 'C', 0, 0, '', '', true);
		//$pdf->MultiCell(135, 5, $jawabanda, 1, 'L', 0, 0, '', '', true);
		$pdf->writeHTMLCell(140, 5, '', '', $jawabhtml, 1, 1, 0, true, '', true);
				$pdf->ln();
	}else{
		$pdf->SetFillColor(255, 255, 255);
		$pdf->MultiCell(10, 5, '', 0, 'C', 1, 0, '', '', true);
		
		if($l_cekresultans['result_answer_points']==1){
			$bs="B";
		}else{
			$bs="S";
		}
		$jawabanda=mysql_result(mysql_query("SELECT answer_text FROM ".$db_prefix."answers WHERE questionid='$l_cekresultans[questionid]' AND answerid='$l_cekresultans[result_answer_text]'"),0,"answer_text");
		$jawabanda=BackField(substr($jawabanda,0,50));
		if(strlen($jawabanda)==50){$jawabanda=$jawabanda."....";}
		$pdf->MultiCell(10, 5, $l_cekresultans['result_answerid'], 1, 'C', 0, 0, '', '', true);
		$pdf->MultiCell(120, 5,$jawabanda, 1, 'L', 0, 0, '', '', true);
		$pdf->MultiCell(25, 5, $bs, 1, 'C', 0, 0, '', '', true);
				$pdf->ln();
		
	}
}

if($list_bkt['test_type']==0){
		$pdf->SetFillColor(255, 255, 255);
		$pdf->MultiCell(10, 5, '', 0, 'C', 1, 0, '', '', true);
$catatan = <<<EOD
<i>Catatan: Hasil B=Benar, S=Salah</i>
EOD;

		$pdf->writeHTMLCell(140, 5, '', '', $catatan, 0, 0, 0, true, '', true);
				$pdf->ln();
}
	
/*
// Set some content to print
$html = <<<EOD
<img src="images/footer_all.jpg">
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
*/
// This method has several options, check the source code documentation for more information.
$pdf->Output('Bukti Ujian '.$nim.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
	}
?>