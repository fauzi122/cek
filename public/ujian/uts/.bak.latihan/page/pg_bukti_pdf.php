<?php
	//ambil id
$id_user = base64_decode(mysql_escape_string($_GET["id"]));
$db_pt=substr($id_user,0,1);
//session_start();
include "line/sambungan.php";

	include "lib/library.php";
	
	$nim=$_POST['userid'];
	$test_id=$_POST['testid'];
	

	$s_code=md5($tgl_sekarang."%".$jam_sekarang."%".$nim."%".$test_id);
	if ($nim=="" or $test_id==""){
	?>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base;?> ">
	<?php
	}else{
	$q_bukti=mysql_query("SELECT a.userid,c.user_firstname,c.user_email,c.user_name,a.testid,
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
							WHERE a.testid=b.testid AND a.userid=c.userid AND a.userid='$nim' AND a.testid='$test_id'");
	
	$list_bkt=mysql_fetch_array($q_bukti);
	$datestart=$list_bkt['tanggal'].'/'.$list_bkt['bulan'].'/'.$list_bkt['tahun'] ;
	$dateend=$list_bkt['tanggalend'].'/'.$list_bkt['bulanend'].'/'.$list_bkt['tahunend'] ;
	?>

<script>
		window.print();
</script>
<style>
#aplikasicetak {
	float: center;
	margin-bottom: 10px;
	width: 650px;
	line-height: 1.5;
	display: block;
	padding: 8px;
	border: 1px #000000 solid;
	border-top: 5px #000000 solid;
}
.td1{
	background:#c7c7c7;
}
</style>

<table align="center" border="0"><tr><td>
  
  <p>

<div id="aplikasicetak">
		<div class="ahead" align="center">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <!--DWLayoutTable-->
			  <!--<tr > 
				<td width="120" rowspan="3"> <div align="left" style="margin-left:10px;"><img src="images/<?php echo $web_logo; ?>" style="max-height:100px;" align="middle"></div></td>
				<td height="5" valign="middle"> <div align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"> </font> </div></td>
				<td width="1"></td>
			  </tr>
			  <tr > 
				<td width="515" height="25" valign="bottom"> <div align="left"><font size="5" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $web_title; ?></font></div></td>
				<td></td>
			  </tr>
			  <tr> 
				<td height="26" valign="top"> <div align="left" ><font size="4" face="Verdana, Arial, Helvetica, sans-serif">KARTU BUKTI UJIAN ONLINE</font></div></td>
				<td ></td>
			  </tr> -->
			  <tr>
				<td><img src="images/<?php echo $web_header; ?>"></td>
			  </tr>
			</table>
		</div>
		<div class="ahead" align="center"><strong></strong></div>
		<table border="0" cellpadding="3" cellspacing="0" width="80%" align="center">
		<tr> 
          <td colspan="3" align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">&nbsp;</font></td>
        </tr>
		<!--
		<tr> 
			  <td colspan="3"  align="center">NO INDUK MAHASISWA</td>
		</tr> 
		<tr> 
			  <td colspan="3"  align="center"><div id="bc1"></div></td>
		</tr> -->
		<!--<tr> 
			  <td colspan='3'  align='center'><font size=-2><?php echo $nim; ?></font></td>
		</tr>-->
		<tr> 
          <td colspan="3" align="left"><strong><font face="Verdana, Arial, Helvetica, sans-serif" color="#000000" size="-1">&nbsp;</font></strong></td>
        </tr>
		<tr> 
			  <td colspan="3"  align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Terima Kasih Anda Telah Mengikuti Ujian Online</font></td>
		</tr>
		<tr> 
          <td colspan="3" align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">&nbsp;</font></td>
        </tr>
        <tr> 
          <td width="33%" align="left" class="td1"><font size="-1">NIM</font></td>
          <td width="2%" align="left" class="td1"><strong><font color="#000000" size="-1">:</font></strong></td>
          <td width="65%" align="left" class="td1"><div style="font: 12px Georgia; color:#000000; font-weight:bold;" size="-1"><?php echo $list_bkt['user_name'] ;?></div></td>
        </tr>
        <tr> 
          <td width="33%" align="left"><font size="-1">NAMA</font></td>
          <td width="2%" align="left"><strong><font color="#000000" size="-1">:</font></strong></td>
          <td width="65%" align="left"><strong><font color="#000000" size="-1"><?php echo $list_bkt['user_firstname'] ;?></font></strong></td>
        </tr>
         <tr> 
          <td width="33%" align="left" class="td1"><font size="-1">TANGGAL UJIAN</font></td>
          <td width="2%" align="left" class="td1"><strong><font color="#000000" size="-1">:</font></strong></td>
          <td width="65%" align="left" class="td1"><strong><font color="#000000" size="-1"> <?php echo $datestart; if($datestart<>$dateend){ echo "s/d".$dateend; }?></font></strong></td>
        </tr>
        <tr> 
          <td width="33%" align="left"><font size="-1">JAM UJIAN</font></td>
          <td width="2%" align="left"><strong><font color="#000000" size="-1">:</font></strong></td>
          <td width="65%" align="left"><strong><font color="#000000" size="-1"><?php echo $list_bkt['mulai']." - ".$list_bkt['selesai'];?></font></strong></td>
        </tr>
		<tr> 
          <td width="33%" align="left"  class="td1"><font size="-1">MATAKULIAH</font></td>
          <td width="2%" align="left"  class="td1"><strong><font color="#000000" size="-1">:</font></strong></td>
          <td width="65%" align="left"  class="td1"><strong><font color="#000000" size="+1"><?php echo $list_bkt['test_name'];?></font></strong></td>
        </tr>
        <tr> 
          <td colspan="3" align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">&nbsp;</font></td>
        </tr>
        <tr> 
          <td colspan="3" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Simpan sebagai bukti bahwa anda telah mengikuti ujian online</font></td>
        </tr>
		<!--<tr> 
			  <td colspan="3"  align="center">NO INDUK MAHASISWA</td>
		</tr>
		<tr> 
			  <td colspan="3"  align="center"><div id="bc2"></div></td>
		</tr> 
		<tr> 
			  <td colspan='3'  align='center'><font size=-2><?php echo $list_bkt['user_name']; ?></font></td>
		</tr>-->
    <tr>
      <td colspan="3" bgcolor="#FFFFFF" align="center"><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><tr> 
          <td colspan="3" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-4"> 
			<?php echo '<img src="lib/qrcode.php?id='.$s_code.'" />'; ?> <br>
		  <i>ScurityCode: <?php echo $s_code; ?></i><br>
		  Tanggal Cetak: <?php echo $tgl_sekarang; ?> - Jam Cetak: <?php echo $jam_sekarang;?>
		  </font></td>
        </tr></font></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
	  <tr>
		<td><img src="images/footer_all.jpg"></td>
	  </tr>
  </table>


	  					
		
</div>

<!-- Ini Buat  Penutup Tampilan -->
</p>

</td>
</tr>
</table>

<!--
<script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-barcode.min.js"></script>
<script>
	$("#bc1").barcode("<?php echo $nim;?>", "code128", {barWidth:3, barHeight:30, output:'bmp'});
	/*$("#bc2").barcode("<?php echo $list_bkt['user_name']; ?>", "code128", {barWidth:3, barHeight:30, output:'bmp'});*/
</script> -->
	<?php 
	}
	?>