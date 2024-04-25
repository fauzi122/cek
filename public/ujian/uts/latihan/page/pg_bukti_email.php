<!-- SCRIP SEND EMAIL -->
<?php
$s_code=md5($tgl_sekarang."%".$jam_sekarang."%".$nim."%".$test_id);
$q_bukti=mysql_query("SELECT a.resultid,a.userid,c.user_firstname,c.user_email,c.user_name,a.testid,
							b.test_name, SEC_TO_TIME(a.result_timespent) AS spent_time, 
							MID(FROM_UNIXTIME(b.test_datestart),9,2) AS tanggal, 
							MID(FROM_UNIXTIME(b.test_datestart),6,2) AS bulan,
							LEFT(FROM_UNIXTIME(b.test_datestart),4) AS tahun,
							MID(FROM_UNIXTIME(b.test_dateend),9,2) AS tanggalend, 
							MID(FROM_UNIXTIME(b.test_dateend),6,2) AS bulanend,
							LEFT(FROM_UNIXTIME(b.test_dateend),4) AS tahunend,
							RIGHT(FROM_UNIXTIME(b.test_datestart),8) AS mulai, 
							RIGHT(FROM_UNIXTIME(b.test_dateend),8) AS selesai, a.result_pointsmax
							FROM ".$db_prefix."results AS a, ".$db_prefix."tests AS b, ".$db_prefix."users AS c 
							WHERE a.testid=b.testid AND a.userid=c.userid AND a.userid='$nim' AND a.testid='$test_id'");
	
	$list_bkt=mysql_fetch_array($q_bukti);
	$datestart=$list_bkt['tanggal'].'/'.$list_bkt['bulan'].'/'.$list_bkt['tahun'] ;
	$dateend=$list_bkt['tanggalend'].'/'.$list_bkt['bulanend'].'/'.$list_bkt['tahunend'] ;
	if($datestart<>$dateend){ 
		$dateujian=$datestart." s/d ".$dateend; 
	}else{
		$dateujian=$datestart; 
	}
if(!empty($list_bkt['user_email'])){
	$id1=mysql_real_escape_string(base64_encode($nim));
	$id2=mysql_real_escape_string(base64_encode($test_id));
	$link_cetak= $path_file."bukti-pdf-email-".$id1."-".$id2;

		$to = $list_bkt['user_email'];
		$subject = "BUKTI UJIAN ONLINE (".$list_bkt['test_name'].") - BINA SARANA INFORMATIKA";

		$message = "
		<table align='center' border='0'><tr><td>
		  
		  <p>

		<div  style='float: center;margin-bottom: 10px;width: 678px;line-height: 1.5;	display: block;	padding: 8px;border: 1px #000000 solid;	border-top: 5px #000000 solid;'>
				<div class='ahead' align='center'>
					<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='padding-bottom:10px;border-bottom:#000 solid 1px;'>
					  <!--DWLayoutTable-->
					  <tr > 
						<td width='120' rowspan='3'> <div align='left' style='margin-left:10px;'><img src='".$path_file."img/logo%20bsi_150.png' width='100' height='100' align='middle'></div></td>
						<td height='5' valign='middle'> <div align='center'><font size='3' face='Verdana, Arial, Helvetica, sans-serif'> </font> </div></td>
						<td width='1'></td>
					  </tr>
					  <tr > 
						<td width='515' height='25' valign='bottom'> <div align='left'><font size='5' face='Verdana, Arial, Helvetica, sans-serif'>BINA SARANA INFORMATIKA</font></div></td>
						<td></td>
					  </tr>
					  <tr> 
						<td height='26' valign='top'> <div align='left' ><font size='4' face='Verdana, Arial, Helvetica, sans-serif'>KARTU BUKTI UJIAN ONLINE</font></div></td>
						<td ></td>
					  </tr>

					</table>
				</div>
				<div class='ahead' align='center'><strong></strong></div>
				<table border='0' cellpadding='3' cellspacing='0' width='80%' align='center'>
				<tr> 
				  <td colspan='3' align='left'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>&nbsp;</font></td>
				</tr>
				 
				<tr> 
					  <td colspan='3'  align='center'>NO FORMULIR</td>
				</tr> 
				<tr> 
					  <td colspan='3'  align='center'><img src='".$path_file."lib/barkode.php?text=".$nim."' alt='".$nim."' width='200' height='40'></td>
				</tr>
				<tr> 
					  <td colspan='3'  align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>".$nim."</font></td>
				</tr>
				<tr> 
				  <td colspan='3' align='left'><strong><font face='Verdana, Arial, Helvetica, sans-serif' color='#000000' size='-1'>&nbsp;</font></strong></td>
				</tr>
				<tr> 
					  <td colspan='3'  align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>Terima Kasih Anda Telah Mengikuti Ujian Online</font></td>
				</tr>
				<tr> 
				  <td colspan='3' align='left'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>&nbsp;</font></td>
				</tr>
				<tr> 
				  <td width='33%' align='left' bgcolor='#c7c7c7'><font size='-1'>NIM</font></td>
				  <td width='2%' align='left' bgcolor='#c7c7c7'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left' bgcolor='#c7c7c7'><font color='#000000' size='-1'>". $list_bkt['user_name']."</font></td>
				</tr>
				<tr> 
				  <td width='33%' align='left'><font size='-1'>NAMA</font></td>
				  <td width='2%' align='left'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left'><strong><font color='#000000' size='-1'>". $list_bkt['user_firstname']."</font></strong></td>
				</tr>
				 <tr> 
				  <td width='33%' align='left' bgcolor='#c7c7c7'><font size='-1'>TANGGAL UJIAN</font></td>
				  <td width='2%' align='left' bgcolor='#c7c7c7'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left' bgcolor='#c7c7c7'><strong><font color='#000000' size='-1'>". $dateujian ."</font></strong></td>
				</tr>
				<tr> 
				  <td width='33%' align='left'><font size='-1'>JAM UJIAN</font></td>
				  <td width='2%' align='left'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left'><strong><font color='#000000' size='-1'>".$list_bkt['mulai']." - ".$list_bkt['selesai']."</font></strong></td>
				</tr>
				<tr> 
				  <td width='33%' align='left'  bgcolor='#c7c7c7'><font size='-1'>MATAKULIAH</font></td>
				  <td width='2%' align='left'  bgcolor='#c7c7c7'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left'  bgcolor='#c7c7c7'><strong><font color='#000000' size='+1'>".$list_bkt['test_name']."</font></strong></td>
				</tr>
				<tr> 
				  <td colspan='3' align='left'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>&nbsp;</font></td>
				</tr>
				<tr> 
				  <td colspan='3' align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>Simpan sebagai bukti bahwa anda telah mengikuti ujian online</font></td>
				</tr>
				<tr> 
				  <td colspan='3' align='left'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>&nbsp;</font></td>
				</tr>
				<tr> 
					  <td colspan='3'  align='center'>NO INDUK MAHASISWA</td>
				</tr> 
				<tr> 
					  <td colspan='3'  align='center'><img src='".$path_file."lib/barkode.php?text=".$list_bkt['user_name']."' alt='".$list_bkt['user_name']."' width='200' height='40'></td>
				</tr>
				<tr> 
					  <td colspan='3'  align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>".$list_bkt['user_name']."</font></td>
				</tr>
				
			<tr>
			  <td colspan='3' bgcolor='#FFFFFF' align='center'><font face='Verdana, Arial, Helvetica, sans-serif'>&nbsp; </font><font size='1' face='Verdana, Arial, Helvetica, sans-serif'><tr> 
				  <td colspan='3' align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='-4'>Tanggal Cetak: ".$tgl_sekarang." - Jam Cetak: ".$jam_sekarang." <br> <i>ScurityCode: ".$s_code."</i></font></td>
				</tr></font></td>
			</tr>
		  </table>
		</div>
		</p>
		</td>
		</tr>
		</table>
		<center><a href=".$link_cetak."'>Cetak Bukti Ujian</a></center>
		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		// More headers
		$headers .= 'From: <hasil.ujian@bsi.ac.id>' . "\r\n";
		$headers .= 'Cc: hasil.ujian@bsi.ac.id' . "\r\n";

		mail($to,$subject,$message,$headers);
}
?>
