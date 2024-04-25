<?php
//ambil id
//$id_user = mysql_real_escape_string(base64_decode($_GET["id"]));

if(isset($_POST['s_answer']) or isset($_POST['nomor'])){
	?>
		<center><div class="load" alt="Loading...">&nbsp;</div></center>
		
	<?php
	
	$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid from  ".$db_prefix."session where id_session = '$id_user'"));
	$nim=$list_sess['userid'];
	$test_id=$list_sess['testuser'];
	$no=$_POST['nomor'];
	$questionid=$_POST['questionid'];
	

	
	//Query Tabel Test
	$q_testuser=mysql_query("SELECT testid, test_datestart, test_dateend, jmlsoal, test_type FROM ".$db_prefix."tests WHERE testid='$test_id' ");
	$list_test=mysql_fetch_array($q_testuser);
	$result_answer_timespent=$unix_timestamp - $list_test['test_datestart'];
	$jmlsoal=$list_test['jmlsoal'];
	
	if($list_test['test_type']==1){
		$nosanswer="s_answer".$no;
		$s_answer=$_POST[$nosanswer];
	}else{
		$s_answer=$_POST['s_answer'];
	}
	
	//Query tabel result
	$q_cekresult=mysql_query("SELECT resultid, result_points FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim' ");
	$list_cekresult=mysql_fetch_array($q_cekresult);
	/* $row_cekresult=mysql_num_rows($q_cekresult); */
	
		
	
	if($list_test['test_type']==1){
		mysql_query("UPDATE ".$db_prefix."results_answers SET 
		result_answer_text='$s_answer',
		result_answer_timespent='$result_answer_timespent' 
		WHERE resultid='$list_cekresult[resultid]' AND
		questionid='$questionid' AND
		result_answerid='$no'");
		
		/*echo "UPDATE ".$db_prefix."results_answers SET 
		result_answer_text='$s_answer',
		result_answer_timespent='$result_answer_timespent' 
		WHERE resultid='$list_cekresult[resultid]', 
		questionid='$questionid', 
		result_answerid='$no'"; exit(); */
	}else{
		//Query table answer
		$q_answer=mysql_query("SELECT answerid, questionid, answer_correct FROM ".$db_prefix."answers WHERE answerid='$s_answer' AND questionid='$questionid' ");
		$list_answer=mysql_fetch_array($q_answer);
		
		$answer_correct=$list_answer['answer_correct'];
		if($answer_correct>0){
			$result_answer_iscorrect="2";
		}else{
			$result_answer_iscorrect="0";
		}
	
		mysql_query("UPDATE ".$db_prefix."results_answers SET 
		result_answer_text='$s_answer',
		result_answer_points='$answer_correct',
		result_answer_iscorrect='$result_answer_iscorrect',
		result_answer_timespent='$result_answer_timespent' 
		WHERE resultid='$list_cekresult[resultid]' AND 
		questionid='$questionid' AND 
		result_answerid='$no'");
	}
	?>
	<script language='javascript'>document.location = 'edit<?php echo "-".base64_encode($id_user);?>';</script>
	<meta http-equiv="Refresh" content="0; URL=edit<?php echo "-".base64_encode($id_user);?> ">
	<?php
}else{
?>
	<script language='javascript'>document.location = 'eujian<?php echo "-".base64_encode($id_user);?>';</script>
		<meta http-equiv="Refresh" content="0; URL=eujian<?php echo "-".base64_encode($id_user);?>">
<?php 
}
?>