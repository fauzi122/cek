<!-- SCRIP SEND EMAIL -->
<?php
	$s_code=md5("2014-08-11%11:54:00%81403771%2050630061010");
	$id1=mysql_real_escape_string(base64_encode("81403771"));
	$id2=mysql_real_escape_string(base64_encode("2050630061010"));
	$link_cetak= "http://cdn.ujian.bsi.ac.id/ormik/bukti-pdf-email-".$id1."-".$id2;
	$nim="81403771";
		$to = "nurulaizahh@gmail.com";
		$subject = "BUKTI UJIAN ONLINE (PENDIDIKAN PANCASILA (ORMIK) - 101) - BINA SARANA INFORMATIKA";

		$message = "
		<table align='center' border='0'><tr><td>
		  
		  <p>

		<div  style='float: center;margin-bottom: 10px;width: 678px;line-height: 1.5;	display: block;	padding: 8px;border: 1px #000000 solid;	border-top: 5px #000000 solid;'>
				<div class='ahead' align='center'>
					<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='padding-bottom:10px;border-bottom:#000 solid 1px;'>
					  <!--DWLayoutTable-->
					  <tr > 
						<td width='120' rowspan='3'> <div align='left' style='margin-left:10px;'><img src='http://cdn.ujian.bsi.ac.id/ormik/img/logo%20bsi_150.png' width='100' height='100' align='middle'></div></td>
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
					  <td colspan='3'  align='center'><img src='http://cdn.ujian.bsi.ac.id/ormik/lib/barkode.php?text=".$nim."' alt='".$nim."' width='200' height='40'></td>
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
				  <td width='65%' align='left' bgcolor='#c7c7c7'><font color='#000000' size='-1'>11141369</font></td>
				</tr>
				<tr> 
				  <td width='33%' align='left'><font size='-1'>NAMA</font></td>
				  <td width='2%' align='left'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left'><strong><font color='#000000' size='-1'>NURUL AIZAH</font></strong></td>
				</tr>
				 <tr> 
				  <td width='33%' align='left' bgcolor='#c7c7c7'><font size='-1'>TANGGAL UJIAN</font></td>
				  <td width='2%' align='left' bgcolor='#c7c7c7'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left' bgcolor='#c7c7c7'><strong><font color='#000000' size='-1'>05/07/2014 s/d 01/09/2014</font></strong></td>
				</tr>
				<tr> 
				  <td width='33%' align='left'><font size='-1'>JAM UJIAN</font></td>
				  <td width='2%' align='left'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left'><strong><font color='#000000' size='-1'>00:00:01 - 23:59:59</font></strong></td>
				</tr>
				<tr> 
				  <td width='33%' align='left'  bgcolor='#c7c7c7'><font size='-1'>MATAKULIAH</font></td>
				  <td width='2%' align='left'  bgcolor='#c7c7c7'><strong><font color='#000000' size='-1'>:</font></strong></td>
				  <td width='65%' align='left'  bgcolor='#c7c7c7'><strong><font color='#000000' size='+1'>PENDIDIKAN PANCASILA (ORMIK) - 101</font></strong></td>
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
					  <td colspan='3'  align='center'><img src='http://cdn.ujian.bsi.ac.id/ormik/lib/barkode.php?text=11141369' alt='11141369' width='200' height='40'></td>
				</tr>
				<tr> 
					  <td colspan='3'  align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='-1'>11141369</font></td>
				</tr>
				
			<tr>
			  <td colspan='3' bgcolor='#FFFFFF' align='center'><font face='Verdana, Arial, Helvetica, sans-serif'>&nbsp; </font><font size='1' face='Verdana, Arial, Helvetica, sans-serif'><tr> 
				  <td colspan='3' align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='-4'>Tanggal Cetak: 2014-08-11 - Jam Cetak: 11:54:00 <br> <i>ScurityCode: ".$s_code."</i></font></td>
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

?>
