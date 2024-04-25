
<?php 
//ambil id
//$id_user = mysql_real_escape_string(base64_decode($_GET["id"]));
$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid from  ".$db_prefix."session where id_session = '$id_user'"));

if(!isset($_POST['userid']) or !isset($_POST['testid'])){
		$nim=$list_sess['userid'];
		$test_id=$list_sess['testuser'];
	}else{
		$nim=$_POST['userid'];
		$test_id=$_POST['testid'];
	}
		
		
	
	if ($nim=="" or $test_id==""){
	?>
		<script language='javascript'>document.location = '<?php echo $path_base."-".base64_encode($id_user);?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($id_user);?> ">
	<?php
	}else{
	$q_bukti=mysql_query("SELECT a.resultid,a.userid,c.user_firstname,c.user_email,c.user_name,a.testid,
							b.test_name, b.test_attempts, SEC_TO_TIME(a.result_timespent) AS spent_time, 
							MID(FROM_UNIXTIME(b.test_datestart),9,2) AS tanggal, 
							MID(FROM_UNIXTIME(b.test_datestart),6,2) AS bulan,
							LEFT(FROM_UNIXTIME(b.test_datestart),4) AS tahun,
							MID(FROM_UNIXTIME(b.test_dateend),9,2) AS tanggalend, 
							MID(FROM_UNIXTIME(b.test_dateend),6,2) AS bulanend,
							LEFT(FROM_UNIXTIME(b.test_dateend),4) AS tahunend,
							RIGHT(FROM_UNIXTIME(b.test_datestart),8) AS mulai, 
							RIGHT(FROM_UNIXTIME(b.test_dateend),8) AS selesai, 
							a.result_pointsmax
							FROM ".$db_prefix."results AS a, ".$db_prefix."tests AS b, ".$db_prefix."users AS c 
							WHERE a.testid=b.testid AND a.userid=c.userid AND a.userid='$nim' AND a.testid='$test_id'");
	
	$list_bkt=mysql_fetch_array($q_bukti);
	
	$datestart=$list_bkt['tanggal']."/".$list_bkt['bulan']."/".$list_bkt['tahun'];
	$dateend=$list_bkt['tanggalend']."/".$list_bkt['bulanend']."/".$list_bkt['tahunend'];
	/*$q_bukti2=mysql_query("SELECT count(resultid) as jml from ".$db_prefix."results_answers WHERE resultid=$list_bkt[resultid] ");
	$list_bkt2=mysql_fetch_array($q_bukti2); */
?>
	

<script type="text/javascript">
            $(document).ready(function(){

               $('#myModal').modal({
									  keyboard: false,
									  backdrop: false
									});
			
            });
</script>

<style>
.hero-unit{
	height:320px !important;
}
.modal-title{
	background:url('<?php echo "images/".$web_logo; ?>') no-repeat;background-size:50px 50px;height:50px;width:500px;
}
font strong{
	margin-left:58px;margin-top:-6px;display:block;font-size:16px;
}
</style>

	 <!-- Button trigger modal
  <a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg">Launch demo modal</a> -->
<div style="height:420px;">&nbsp;</div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a type="button" class="close"  aria-hidden="true" href="<?php echo $path_base."-".base64_encode($id_user);?>">&times;</a>
           <p class="modal-title">&nbsp;<font><strong><?php echo $web_title; ?></font></p>
        </div>
        <div class="modal-body">
			<table>
		<tr>
			<td><h2><?php echo $list_bkt['test_name'];?></h2></td>
		</tr>
		<tr>
			<td>Tanggal Ujian : <?php echo $datestart; if($datestart<>$dateend){ echo "s/d".$dateend; }?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ujian : <?php echo $list_bkt['mulai']." - ".$list_bkt['selesai'];?></td>
		</tr>
		<tr>
			<td>Lama Waktu Mengerjakan : <?php echo $list_bkt['spent_time'];?></td>
		</tr>
		<!--<tr>
			<td>Jumlah Jawab: <?php echo $list_bkt2['jml'];?> dari <?php echo $list_bkt['result_pointsmax'];?> Soal</td>
		</tr> -->
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>NIM : <?php echo $list_bkt['user_name'];?></td>
		</tr>
		<tr>
			<td>Nama Lengkap : <?php echo $list_bkt['user_firstname'];?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Terimakasih anda telah mengikuti ujian online, anda dapat melakukan ujian sebanyak <?php echo $list_bkt['test_attempts']; ?> Kali, bukti ujian dapat Anda cetak melaui link cetak bukti ujian dibawah </td>
		</tr>
	
		
	</table>
        </div>
        <div class="modal-footer">
          <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
		  <form action="bukti-pdf-<?PHP echo base64_encode($id_user);?>" method="post" style="margin:0;padding:0;" name="bukti" target="_blank">
			<input type="hidden" name="userid" value="<?php echo $nim; ?>">
			<input type="hidden" name="testid" value="<?php echo $test_id; ?>">
			<!--<a  type="button" class="btn btn-primary" onclick="document.forms['bukti-ujian-pdf-<?php echo $test_id;?>'].submit();return false;">Download Bukti Ujian</a>-->
            <input name="cmdbukti" type="submit" value="Cetak Bukti Ujian" class="btn btn-primary" />
		  </form>
          <!--<a type="button" class="btn btn-primary" href="bukti-ujian-pdf">Download PDF</a>-->
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<?php 
	}
	
	if($list_sess['testuser']<>"" or $list_sess['testname']<>""){
				mysql_query("update ".$db_prefix."session set testuser='', testname='', questionid = 0, nomor = 0, resultid=0  where id_session = '$id_user'");
				/*unset($_SESSION['851testuser']);
				unset($_SESSION['851testname']); */
	}
?>

