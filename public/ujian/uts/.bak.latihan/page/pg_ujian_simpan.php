<?php
//ambil id
//$id_user = mysql_real_escape_string(base64_decode($_GET["id"]));

	$no=$_POST['nomor'];
	$questionid=$_POST['questionid'];
	
	
if(isset($_POST['s_answer']) or isset($_POST['nomor'])){
	
	?>
		<center><div class="load" alt="Loading...">&nbsp;</div></center>
		
	<?php
	
	//query Table session
	$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid, resultid from  ".$db_prefix."session where id_session = '$id_user'"));
	
	$nim=$list_sess['userid'];
	$test_id=$list_sess['testuser'];
	$resultid=$list_sess['resultid'];
	
	
	//Query Tabel Test
	$q_testuser=mysql_query("SELECT testid, test_datestart, test_dateend, jmlsoal, test_type FROM ".$db_prefix."tests WHERE testid='$test_id' ");
	$list_test=mysql_fetch_array($q_testuser);
	$result_answer_timespent=$unix_timestamp - $list_test['test_datestart'];
	$jmlsoal=$list_test['jmlsoal']; 
	
	if($list_test['test_type']==1){
		$nosanswer="s_answer".$no;
		$s_answer=mysql_real_escape_string($_POST[$nosanswer]);
	}else{
		$s_answer=mysql_real_escape_string($_POST['s_answer']);
	}
	
	
	//Query tabel result
	$q_cekresult=mysql_query("SELECT resultid, result_points FROM ".$db_prefix."results WHERE userid='$nim' AND testid='$test_id' AND resultid='$resultid' ");
	$list_cekresult=mysql_fetch_array($q_cekresult);
	 $row_cekresult=mysql_num_rows($q_cekresult); 
	
	//Query table answer
	$q_answer=mysql_query("SELECT answerid, questionid, answer_correct FROM ".$db_prefix."answers WHERE answerid='$s_answer' AND questionid='$questionid' ");
	$list_answer=mysql_fetch_array($q_answer);
	
	/*
	//memanggil resultid dari tabel result
	$resultid=$list_cekresult['resultid']; */
	
	
	$answer_correct=$list_answer['answer_correct'];
	if($answer_correct>0){
		$result_answer_iscorrect="2";
	}else{
		$result_answer_iscorrect="0";
	}
	
	//Memanggil test questionid pada tabel tests_questions
	$test_questionid=mysql_result(mysql_query("SELECT test_questionid FROM ".$db_prefix."tests_questions WHERE questionid=$questionid "),0,"test_questionid");
	
	//Mengecek questionid sudah ada / belum di tabel result_answer
	$cek_resaswr=mysql_query("SELECT resultid FROM ".$db_prefix."results_answers WHERE resultid='$resultid' AND questionid='$questionid' ");
	$row_resaswr=mysql_num_rows($cek_resaswr);
	
	//Jika Jenis soal Essay
	if($list_test['test_type']==1){
		if($row_resaswr<>0){
				mysql_query("UPDATE ".$db_prefix."results_answers SET
					result_answerid = '$no',
					 resultid = '$resultid',
					 questionid = '$questionid',
					 test_questionid = '$test_questionid',
					 result_answer_text = '$s_answer',
					 result_answer_points = '0',
					 result_answer_iscorrect = '0',
					 result_answer_feedback = '',
					 result_answer_timespent = '$result_answer_timespent',
					 result_answer_timeexceeded = '0' WHERE resultid='$resultid' AND questionid='$questionid' ");
		}else{
			mysql_query("REPLACE INTO ".$db_prefix."results_answers
					(result_answerid,
					 resultid,
					 questionid,
					 test_questionid,
					 result_answer_text,
					 result_answer_points,
					 result_answer_iscorrect,
					 result_answer_feedback,
					 result_answer_timespent,
					 result_answer_timeexceeded)
		VALUES ('$no',
				'$resultid',
				'$questionid',
				'$test_questionid',
				'$s_answer',
				'0',
				'0',
				'',
				'$result_answer_timespent',
				'0')");
		}
		mysql_query("UPDATE ".$db_prefix."results SET 
					result_timespent='$result_answer_timespent', 
					result_timeexceeded='' 
					WHERE userid='$nim' AND testid='$test_id' AND resultid='$resultid' ");
	
	}else{
		
	//Insert Result Answer
		mysql_query("REPLACE INTO ".$db_prefix."results_answers
				(result_answerid,
				 resultid,
				 questionid,
				 test_questionid,
				 result_answer_text,
				 result_answer_points,
				 result_answer_iscorrect,
				 result_answer_feedback,
				 result_answer_timespent,
				 result_answer_timeexceeded)
	VALUES ('$no',
			'$resultid',
			'$questionid',
			'$test_questionid',
			'$s_answer',
			'$answer_correct',
			'$result_answer_iscorrect',
			'',
			'$result_answer_timespent',
			'0')");
	
	
		$result_points=$list_cekresult['result_points'] + $list_answer['answer_correct'];
		
		mysql_query("UPDATE ".$db_prefix."results SET 
					result_timespent='$result_answer_timespent', 
					result_timeexceeded='', 
					result_points='$result_points' 
					WHERE userid='$nim' AND testid='$test_id' AND resultid='$resultid' ");
	
	}
	
	$jmlresaswr=mysql_result(mysql_query("SELECT count(resultid) as jml FROM ".$db_prefix."results_answers WHERE resultid='$resultid'"),0,'jml');

	if($no==$jmlsoal and $jmlresaswr==$jmlsoal){
		$test_attempts=mysql_fetch_array(mysql_query("SELECT test_attempt_count FROM ".$db_prefix."tests_attempts WHERE userid='$nim' AND testid='$test_id' "));
		$newattempts=$test_attempts['test_attempt_count']+1;
		if($test_attempts['test_attempt_count']<1){
			mysql_query("INSERT INTO ".$db_prefix."tests_attempts
									(testid,
									 userid,
									 test_attempt_count)
						VALUES ('$test_id',
								'$nim',
								'1')");
		}else{
			mysql_query("UPDATE ".$db_prefix."tests_attempts SET test_attempt_count='$newattempts' WHERE userid='$nim' AND testid='$test_id'");
		}
		mysql_query("update ".$db_prefix."visitors
						set 
						  hits = '$test_id'
						where userid = '$nim' AND LEFT(FROM_UNIXTIME(startdate),10)='$tgl_sekarang' AND hits=0 ");
						
		//include "pg_bukti_email.php";
		
		if($list_test['test_type']==1){
	?>
			<script language='javascript'>document.location = 'edit<?php echo "-".base64_encode($id_user);?>';</script>
			<meta http-equiv="Refresh" content="0; URL=edit<?php echo "-".base64_encode($id_user);?> ">
	<?php
		}else{
	?>
			<script language='javascript'>document.location = 'bukti-ujian<?php echo "-".base64_encode($id_user);?>';</script>
			<meta http-equiv="Refresh" content="0; URL=bukti-ujian<?php echo "-".base64_encode($id_user);?> ">
	<?php
		}
	}else{
		if(isset($_POST['sdraft'])){
		//unset($_SESSION['questionid']);
			mysql_query("update ".$db_prefix."session set questionid = '$questionid', nomor = '$no' where id_session = '$id_user'");
		}else{
			mysql_query("update ".$db_prefix."session set questionid = 0, nomor = 0 where id_session = '$id_user'");
		}
		?>
		<script language='javascript'>document.location = 'ujian<?php echo "-".base64_encode($id_user);?>';</script>
		<meta http-equiv="Refresh" content="0; URL=ujian<?php echo "-".base64_encode($id_user);?>">
<?php
	}
}else{

?>
	<!-- <script language='javascript'>document.location = '<?php echo $path_base."-".base64_encode($id_user);?>';</script>
	<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($id_user);?> "> -->
	<script language='javascript'>document.location = 'ujian<?php echo "-".base64_encode($id_user);?>';</script>
		<meta http-equiv="Refresh" content="0; URL=ujian<?php echo "-".base64_encode($id_user);?>">
<?php
}
?>
	
