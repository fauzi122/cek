
<script type="text/javascript" src="js/jwplayer/jwplayer.js"></script>
<?php 

//ambil id
//$id_user = mysql_real_escape_string(base64_decode($_GET["id"]));
//Query Ke Table session
$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid from  ".$db_prefix."session where id_session = '$id_user'"));

	/*
	//jika $_POST['userid']; tidak ada
	if(isset($_POST['userid'])){
		$nim=$_POST['userid'];
	}else{ */
		$nim=$list_sess['userid'];
	/* } 
	
	if($list_sess['testuser']==""){
		$test_id=$_POST['testid'];
		mysql_query("update ".$db_prefix."session set testuser = '$test_id' where id_session = '$id_user'");
	}else{ */
		$test_id=$list_sess['testuser'];
	/* }
	
	if($list_sess['testname']==""){
		$test_name=$_POST['testname'];
		mysql_query("update ".$db_prefix."session set testname = '$test_name' where id_session = '$id_user'");
	}else{ */
		$test_name=$list_sess['testname'];
	/* } */

if ($nim=="" or $test_id==""){
	?>
		<script language='javascript'>document.location = '<?php echo $path_base."-".base64_encode($id_user);?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($id_user);?> ">
	<?php
}else{
	//Query Ke Table test
	$q_testuser=mysql_query("SELECT testid, test_datestart, test_dateend, jmlsoal, test_time, test_type FROM ".$db_prefix."tests WHERE testid='$test_id' ");
	$list_test=mysql_fetch_array($q_testuser);
	
	date_default_timezone_set("Asia/Jakarta"); 
	$o_skrg = new DateTime();
	$o_batas = new DateTime(date('Y-m-d H:i:s', $list_test['test_dateend']));
	$o_sisa = $o_skrg->diff($o_batas);
	/*print_r($o_sisa);
	echo $o_sisa->format('%R')."<br />";*/
	$sisa_waktu = $o_sisa->format('%R') == '-' ? '00:00:01' : $o_sisa->format('%H:%I:%S');
	
	
	if($list_test['test_dateend']<$unix_timestamp or $list_test['test_datestart']>$unix_timestamp){
	?>
		<script language='javascript'>document.location = '<?php echo $path_base."-".base64_encode($id_user);?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($id_user);?> ">
	<?php
	}else{
		//Query Ke Table result
		$q_cekresult=mysql_query("SELECT resultid, result_points, result_datestart FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim' ");
		$l_cekresult=mysql_fetch_array($q_cekresult);
		//$r_cekresultans=mysql_num_rows($q_cekresultans);
		?>
<div class="col-md-12">
	<div class="block-web">
		<center>
		<div class="row" style="background:#363B3F;padding:15px;color:#fff;">
			<div class="col-md-4"><?php echo $test_name; ?></div>
			<div class="col-md-4"><a href="bukti-ujian<?php echo "-".base64_encode($id_user);?>" class="btn btn-primary" style='font-weight:bold;border:#407b9b solid 1px !important;background:#f7f7f9 !important;color:#407b9b !important;'>Selesai Ujian</a></div>
			<div class="col-md-4">
				Sisa waktu :&nbsp;<span class="kkcount-down"><?php echo $sisa_waktu;?></span>
			</div>
		</div>
		</center><br>
						
		<table  border="0" cellpadding="0" cellspacing="0" width="100%"  class="table table-striped">
		
		<?php 
		//Query Ke Table result answer
		$q_cekresultans=mysql_query("SELECT result_answerid, resultid, questionid, result_answer_text FROM ".$db_prefix."results_answers WHERE resultid='$l_cekresult[resultid]' ORDER BY result_answerid ASC LIMIT $list_test[jmlsoal] ");
		while($l_cekresultans=mysql_fetch_array($q_cekresultans)){
			$question=mysql_fetch_array(mysql_query("SELECT questionid,question_text, question_pre, question_post FROM ".$db_prefix."questions WHERE questionid='$l_cekresultans[questionid]' "));
		?><tr>
			<td><strong><?php echo $l_cekresultans['result_answerid']; ?>.</strong></td>
			<td>
			
				<?php 
				echo $question['question_text']."<br>"; 
				
				if($question['question_pre']<>""){ //Soal gambar ?>
					<img src="Image/<?php echo $question['question_pre'];?>" style="max-width:500;"><br>
				<?php }
				
				if($question['question_post']<>""){ //Soal Video & Audio ?>

					<div id="myElement<?php echo $question['questionid'];?>">Loading the player...</div>

					<script type="text/javascript">
						jwplayer("myElement<?php echo $question['questionid'];?>").setup({
							file: "File/<?php echo $question['question_post'];?>",
							image: ""
							<?php if(substr($question['question_post'],-3)=='mp3' or substr($question['question_post'],-3)=='m4a'){ ?>
									,
									height: 30
							<?php } ?>
						});
					</script>
			<?php
				}
				
				?>
				<br>
				<div style='padding:10px'>
				<font style="color:green;font-size:16px;display:block;">Jawaban anda:</font><br>
					<?php
					if($list_test['test_type']==1){
						echo $l_cekresultans['result_answer_text'];
					}else{
						$jawabanda=mysql_result(mysql_query("SELECT answer_text FROM ".$db_prefix."answers WHERE questionid='$l_cekresultans[questionid]' AND answerid='$l_cekresultans[result_answer_text]'"),0,"answer_text");
						echo $jawabanda;
					}
					?>
				</div>
				</td>
			<td>
				<form action="eujian-<?php echo base64_encode($id_user); ?>" method="post" style="margin:30px 0px;" name="eujian-<?php echo $krs['testid'];?>">
					<input type="hidden" name="userid" value="<?php echo $nim; ?>">
					<input type="hidden" name="testid" value="<?php echo $list_test['testid']; ?>">
					<input type="hidden" name="resultid" value="<?php echo $l_cekresultans['resultid']; ?>">
					<input type="hidden" name="questionid" value="<?php echo $l_cekresultans['questionid']; ?>">
					<input name="cmdselesai" class="btn btn-primary"  type="submit" value="Edit jawaban" />
				</form>
			</td>
			</tr>
		<?php } ?>
		</table>
		<div  class="row" style="background:#363B3F;padding:15px;color:#fff;"> <center><a href="bukti-ujian<?php echo "-".base64_encode($id_user);?>" class="btn btn-primary" style='font-weight:bold;border:#407b9b solid 1px !important;background:#f7f7f9 !important;color:#407b9b !important;'>Selesai Ujian</a></center></div>
		
	</div>
</div>
		<?php
		
	}
}
?>
<script type="text/javascript">
	var interval = setInterval(function() {
		var timer = $('.kkcount-down').html();
		timer = timer.split(':');
		var hours = parseInt(timer[0], 10);
		var minutes = parseInt(timer[1], 10);
		var seconds = parseInt(timer[2], 10);
		seconds -= 1;
		if (hours < 0) return clearInterval(interval);	
		if (seconds < 0 && minutes == 0 && hours != 0) {
			hours -= 1;
			minutes = 59;
			seconds = 59;
		}
		if (seconds < 0 && minutes != 0) {
			minutes -= 1;
			seconds = 59;
		}
		if (hours < 10 && length.hours != 2) hours = '0' + hours;
		if (minutes < 10 && length.minutes != 2) minutes = '0' + minutes;
		if (seconds < 10 && length.seconds != 2) seconds = '0' + seconds;
		$('.kkcount-down').html(hours + ':' + minutes + ':' + seconds);
		
		if (hours == 0 && minutes == 0 && seconds == 0) clearInterval(interval);
	}, 1000);
</script>