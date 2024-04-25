<?php
// Mendapatkan IP pengunjung menggunakan getenv()
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP tidak dikenali';
    return $ipaddress;
}
  
  
// Mendapatkan IP pengunjung menggunakan $_SERVER
// function get_client_ip_2() {
//     $ipaddress = '';
//     if (isset($_SERVER['HTTP_CLIENT_IP']))
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if(isset($_SERVER['REMOTE_ADDR']))
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'IP tidak dikenali';
//     return $ipaddress;
// }
  
  
// Mendapatkan jenis web browser pengunjung
function get_client_browser() {
    $browser = '';
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
        $browser = 'Netscape';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
        $browser = 'Firefox';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
        $browser = 'Chrome';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
        $browser = 'Opera';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
        $browser = 'Internet Explorer';
    else
        $browser = 'Other';
    return $browser;
}

// function GetClientMac(){
//     $macAddr=false;
//     $arp=`arp -n`;
//     $lines=explode("\n", $arp);

//     foreach($lines as $line){
//         $cols=preg_split('/\s+/', trim($line));

//         if ($cols[0]==$_SERVER['REMOTE_ADDR']){
//             $macAddr=$cols[2];
//         }
//     }

//     return $macAddr;
// }
?>
<script src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
/**
  * Basic jQuery Validation Form Demo Code
  * Copyright Sam Deering 2012
  * Licence: http://www.jquery4u.com/license/
  */
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#form-ujian").validate({
                rules: {
                    s_answer: "required"
                },
                messages: {
                    s_answer: "Jawaban belum dipilih"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
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
			
			if (hours == 0 && minutes == 0 && seconds == 0) { clearInterval(interval); alert('Waktu Ujian Anda Habis'); location.reload(); }
		}, 1000);
	</script>
<?php 

//######## Query ke tabel SESSION ########//
$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid, resultid from  ".$db_prefix."session where id_session = '$id_user'"));
//========== Mengecek session testuser, testname ============//
if($list_sess['testuser']==""){
	$test_id=antiinjection($_POST['testid']);
	mysql_query("update ".$db_prefix."session set testuser = '$test_id' where id_session = '$id_user'");
}else{
	$test_id=$list_sess['testuser'];
}

if($list_sess['testname']==""){
	$test_name=$_POST['testname'];
	mysql_query("update ".$db_prefix."session set testname = '$test_name' where id_session = '$id_user'");
}else{
	$test_name=$list_sess['testname'];
}

$nim=$list_sess['userid'];
		
	//==========jika testid kosong==============//
if($test_id==""){ 
	?>
	<script language='javascript'>document.location = '<?php echo $path_base."-".$s_id;?>';</script>
	 <meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$s_id;?>">
	<?php
}else{
	$q_cekresult=mysql_query("SELECT resultid, result_datestart, testid, userid FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim'");
		$list_cekresult=mysql_fetch_array($q_cekresult);
		$row_cekresult=mysql_num_rows($q_cekresult);
$ip=get_client_ip();
$browser=get_client_browser();
$os=$_SERVER['HTTP_USER_AGENT'];
$gb='('.$browser.')'.$os;
		
		//========= Jika belum ada resultid/belum pernah ujian Menambahkan ke tabel Result =============//
		if($row_cekresult<1){ 
			mysql_query("INSERT INTO ".$db_prefix."results
								(
								 testid,
								 userid,
								 result_datestart,
								 result_pointsmax,
								 gscaleid,
								 gscale_gradeid,
								 result_endtime,
								 ip_address,
								 browser)
					VALUES (
							'$test_id',
							'$nim',
							'$unix_timestamp',
							'$list_test[jmlsoal]',
							'1',
							'',
							'$unix_endtimestamp',
							'$ip',
							'$gb')");
		}
	//######## Query ke tabel TESTS ########//
	$q_testuser=mysql_query("SELECT testid, test_datestart, test_dateend, jmlsoal, test_time, test_attempts, test_type, test_shuffleq, test_shufflea FROM ".$db_prefix."tests WHERE testid='$test_id' ");
	$list_test=mysql_fetch_array($q_testuser);
	$q_result=mysql_query("SELECT result_endtime FROM ".$db_prefix."results WHERE testid='$test_id' and userid='$nim'");
	$list_result=mysql_fetch_array($q_result);
	//===========jika belum mulai atau sudah lewat waktu ujian============//
	if($list_result['result_endtime'] < $unix_timestamp){
		mysql_query("INSERT INTO ".$db_prefix."tests_attempts
											(testid,
											 userid,
											 test_attempt_count,
											 waktu_habis)
								VALUES ('$test_id',
										'$nim',
										'1',
										'1')");
	?>
	<script language='javascript'>document.location = '<?php echo $path_base."-".$s_id;?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$s_id;?>">
	<?php }elseif($list_test['test_datestart'] > $unix_timestamp){
		?>
		<script language='javascript'>document.location = '<?php echo $path_base."-".$s_id;?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$s_id;?>">
		<?php 
	}elseif($list_test['test_dateend'] < $unix_timestamp){
		mysql_query("update ".$db_prefix."session set testuser='', testname='', questionid = 0, resultid = 0 where id_session = '$id_user'");
		?>
		<script language='javascript'>document.location = '<?php echo $path_base."-".$s_id;?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$s_id;?>">
		<?php 
	}else{
			
		//=============SCRIPT COUNTDOWN TIMER UJIAN==============//
		date_default_timezone_set("Asia/Jakarta"); 
		$o_skrg = new DateTime();
		$o_batas = new DateTime(date('Y-m-d H:i:s', $list_result['result_endtime']));
		$o_sisa = $o_skrg->diff($o_batas);
		//echo date("d-m-Y H:i:s", strtotime($row['data']) + 3600);
		//$o_sisa = $o_skrg + 3600;
		//$cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($startTime)));

		/*print_r($o_sisa);
		echo $o_sisa->format('%R')."<br />";*/
		$sisa_waktu = $o_sisa->format('%R') == '-' ? '00:00:01' : $o_sisa->format('%H:%I:%S');
		
		//=================== END COUNTDOWN TIMER UJIAN =============//
		
		//######## Query ke tabel RESULTS ########//
		$q_cekresult=mysql_query("SELECT resultid, result_datestart, testid, userid FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim'");
		$list_cekresult=mysql_fetch_array($q_cekresult);
		$row_cekresult=mysql_num_rows($q_cekresult);
		
		//========= Jika belum ada resultid/belum pernah ujian Menambahkan ke tabel Result =============//
		if($row_cekresult<1){ 
			mysql_query("INSERT INTO ".$db_prefix."results
								(
								 testid,
								 userid,
								 result_datestart,
								 result_pointsmax,
								 gscaleid,
								 gscale_gradeid,
								 result_endtime)
					VALUES (
							'$test_id',
							'$nim',
							'$unix_timestamp',
							'$list_test[jmlsoal]',
							'1',
							'',
							'$unix_endtimestamp')");
		}
		
		//============= Jika SESSION resultid belum ada di tabel SESSION =============//
		if($list_sess['resultid']<1){
			//######## Query ke tabel TESTS ATTEMPTS ########//
			$testsattempts=mysql_query("SELECT test_attempt_count FROM ".$db_prefix."tests_attempts WHERE testid='$test_id' AND userid='$nim' ");
			
			$attempresult=mysql_fetch_array($testsattempts);
			$attemnumrow=mysql_num_rows($testsattempts);
			
			$jmlresult=mysql_fetch_array(mysql_query("SELECT count(b.resultid) as jml FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b 
									WHERE a.resultid=b.resultid AND a.testid='$test_id' AND a.userid='$nim' 
									GROUP BY b.resultid ASC ORDER BY b.resultid DESC limit 1"));
			
			if($list_test['test_attempts']>1){
				//=========== Jika Jumlah Result = Jumlah Test Attempts count Dan Test Attempt Count Dan Jumlah result answer = Jumlah soal matakuliah ==============================//
				if($row_cekresult==$attempresult['test_attempt_count'] and $attempresult['test_attempt_count']<$list_test['test_attempts'] and $jmlresult['jml']==$list_test['jmlsoal']){
					mysql_query("INSERT INTO ".$db_prefix."results
									(
									 testid,
									 userid,
									 result_datestart,
									 result_pointsmax,
									 gscaleid,
									 gscale_gradeid)
						VALUES (
								'$test_id',
								'$nim',
								'$unix_timestamp',
								'$list_test[jmlsoal]',
								'1',
								'')");
				}
			}else{
				//========== Jika jumlah melakukan ujian < batasan jumlah max melakukan ujian, dan  jumlah jawaban ujian = jumlah soal ujian ===========//
				if($attemnumrow>0 and $attempresult['test_attempt_count']<$list_test['test_attempts'] and $jmlresult['jml']==$list_test['jmlsoal']){
					mysql_query("INSERT INTO ".$db_prefix."results
									(
									 testid,
									 userid,
									 result_datestart,
									 result_pointsmax,
									 gscaleid,
									 gscale_gradeid)
						VALUES (
								'$test_id',
								'$nim',
								'$unix_timestamp',
								'$list_test[jmlsoal]',
								'1',
								'')");
				}
			}
		}
		
		//===== Melakukan Update Resultid pada Tabel SESSION, dengan mengecek tabel result =========//
		$resultid=mysql_result(mysql_query("SELECT resultid FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim' ORDER BY resultid DESC limit 1 "),0,"resultid");
		mysql_query("update ".$db_prefix."session set resultid = '$resultid' where id_session = '$id_user'");
		$result_id=mysql_result(mysql_query("select resultid from  ".$db_prefix."session where id_session = '$id_user'"),0,"resultid");
		
		//=========== Mengecek Jumlah Jawaban Result Yang Masuk pada tabel Result Answer ==============//
		$q_userresult=mysql_query("SELECT a.resultid,a.testid,a.userid, b.questionid
									FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b 
									WHERE a.resultid=b.resultid AND a.testid='$test_id' AND a.userid='$nim' and a.resultid='$result_id' 
									ORDER BY questionid ASC");
		$nums_question=mysql_num_rows($q_userresult);
		
		//============= Jika Jumlah Jawaban Result Yang Masuk = Jumlah Soal yg diujikan, atau Jumlah Jawaban Result Yang Masuk > Jumlah Soal yg diujikan =======//
		if($nums_question==$list_test['jmlsoal'] or $nums_question>$list_test['jmlsoal']){ 			
		?>
			<script language='javascript'>document.location = 'edit-<?php echo $s_id;?>';</script>
			<meta http-equiv="Refresh" content="0; URL=edit-<?php echo $s_id;?> ">
		<?php
			
		}else{
				
					/*if($unix_timestamp>$timedown){
						?>
						<script>
							 alert('Waktu Ujian Habis');
						</script>
						<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$id_user;?>">
						<?php
					}else{ */
				
						
						
						//if($_SESSION['questionid']==""){ //$questionidvar
						//cek questionid di tabel session
						$cekquestionid = mysql_query("select questionid, nomor from ".$db_prefix."session  where id_session = '$id_user'");
						$cekqid=mysql_fetch_array($cekquestionid);
						$questionidx=$cekqid['questionid'];
						
						if($cekqid['nomor']<>0){
							$nomor=$cekqid['nomor'];
						}else{
							$nomor=$nums_question+1;
						}
						
						if($questionidx==0){
								if($list_test['jmlsoal']=='1' and $list_test['test_type']=='1'){
									$q_question=mysql_query("SELECT 
															  a.testid, a.questionid, b.questionid, b.question_text, b.question_pre, b.question_post, b.question_type 
															FROM
															  ".$db_prefix."tests_questions AS a, ".$db_prefix."questions AS b 
															WHERE a.testid = '$test_id' 
															  AND a.questionid = b.questionid 
															  AND RIGHT(b.questionid,1) =".substr($nim,-1)." 
															LIMIT 1");
									$question_numr=mysql_num_rows($q_question);
									if($question_numr<1){
										$q_question=mysql_query("SELECT 
															  a.testid, a.questionid, b.questionid, b.question_text, b.question_pre, b.question_post, b.question_type 
															FROM
															  ".$db_prefix."tests_questions AS a, ".$db_prefix."questions AS b 
															WHERE a.testid = '$test_id' 
															  AND a.questionid = b.questionid 
															  ORDER BY  b.questionid ASC
															LIMIT 1");
									}
								}else{
									//menampilkan Pertanyaan dan Tidak menampilkan Pertanyaan yg sudah tayang 
									/*
									$q_question=mysql_query("SELECT a.testid,a.questionid,b.questionid,b.question_text,b.question_pre,b.question_post,b.question_type 
																FROM ".$db_prefix."tests_questions AS a,  ".$db_prefix."questions AS b 
																WHERE a.testid='$test_id' AND a.questionid=b.questionid 
																AND b.questionid 
																NOT IN (SELECT b.questionid FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b WHERE a.resultid=b.resultid AND a.testid='$test_id' AND a.userid='$nim' AND a.resultid='$result_id')
																ORDER BY RAND()LIMIT 1");*/
									
									$query_qq ="SELECT a.testid,a.questionid,b.questionid,b.question_text,b.question_pre,b.question_post,b.question_type";
									$query_qq .=" FROM ".$db_prefix."tests_questions AS a,  ".$db_prefix."questions AS b";
									$query_qq .=" WHERE a.testid='$test_id' AND a.questionid=b.questionid";
									$query_qq .=" AND b.questionid NOT IN (SELECT b.questionid FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b WHERE a.resultid=b.resultid AND a.testid='$test_id' AND a.userid='$nim' AND a.resultid='$result_id')";
									///// JIKA QUESTION DIRANDOM ///////////
									if($list_test['test_shuffleq']=='1'){
										$query_qq .=" ORDER BY RAND()";
									}else{
										$query_qq .="  ORDER BY b.questionid ASC";
									}
									///////////////////////////////////////
									$query_qq .=" LIMIT 1";
									
									$q_question=mysql_query($query_qq);
								}
							$list_q=mysql_fetch_array($q_question);
							$list_qx = $list_q['questionid'];
							//menyimpan sessi soal yg tampil
							//$_SESSION['questionid']=$list_q['questionid'];
							mysql_query("update ".$db_prefix."session set questionid = '$list_qx', nomor='$nomor' where id_session = '$id_user'");
						
						}else{
							$q_question=mysql_query("SELECT a.testid,a.questionid,b.questionid,b.question_text,b.question_pre,b.question_post,b.question_type 
														FROM ".$db_prefix."tests_questions AS a,  ".$db_prefix."questions AS b 
														WHERE a.testid='$test_id' AND a.questionid=b.questionid 
														AND b.questionid='".$questionidx."' ");
							$list_q=mysql_fetch_array($q_question);
						}
							
						?>
			<div class="col-md-12">
				<div class="block-web">
						<center>
						*Jawaban yang sudah dipilih tetap tersimpan, meskipun diminta login ulang.
						<div class="row" style="background:#363B3F;padding:15px;color:#fff;">

							<div class="col-md-4"><?php echo $test_name; ?> </div>
							<div class="col-md-4">Pertanyaan <?php echo $nomor." dari ".$list_test['jmlsoal']; ?> </div>
							<div class="col-md-4">
									<!--Sisa waktu :&nbsp;<span data-time="<?php echo $timedown;?>" class="kkcount-down"><?php echo $sisa_waktu;?></span>-->
									Sisa waktu :&nbsp;<span class="kkcount-down"><?php echo $sisa_waktu;?></span>
							</div>
					
						</div>
						</center><br>
						<table border="0" width="100%">
						<tr>
						<td valign="top" width="2%"><strong><?php echo $nomor.". "; ?> &nbsp;</strong></td>
						<td width="98%">
							<form action='ujian.-<?php echo $s_id;?>' method='post' id="form-ujian" novalidate="novalidate" style="width:100%;">
							<input type='hidden' name='nomor' value='<?php echo $nomor; ?>'>
							<input type='hidden' name='questionid' value='<?php echo $list_q['questionid']; ?>'>
						
							<div style="max-height:400px;overflow-y:auto;">
								<?php 
								echo $list_q['question_text']."<br>";
								
								if($list_q['question_pre']<>""){ //Soal gambar ?>
									<img src="Image/<?php echo $list_q['question_pre'];?>" style="max-width:100%;"><br>
								<?php }
								
								if($list_q['question_post']<>""){ //Soal Video & Audio ?>
									<script type="text/javascript" src="js/jwplayer/jwplayer.js"></script>
									<div id="myElement<?php echo $list_q['questionid'];?>">Loading the player...</div>

									<script type="text/javascript">
										jwplayer("myElement<?php echo $list_q['questionid'];?>").setup({
											file: "File/<?php echo $list_q['question_post'];?>",
											image: ""
											<?php if(substr($list_q['question_post'],-3)=='mp3' or substr($list_q['question_post'],-3)=='m4a'){ ?>
											,
											height: 30
											<?php } ?>
										});
									</script><br>
							<?php
								}

							?>
							</div>
							<?php
							
							
						if($list_q['question_type']=='1'){
							?>
								<!--- JAVA FOR EDITOR --->
								<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
								<script type="text/javascript" src="js/tinymce/plugins/autosave/plugin.min.js"></script>
								<script type="text/javascript">
								tinymce.init({
									mode : "specific_textareas",
									editor_selector : "mceEditor<?php echo $nomor;?>",
									plugins: "table, paste, autosave, charmap, preview, hr",
									autosave_retention: "30m",
									toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
									 //theme_advanced_buttons3_add : "pastetext,pasteword,selectall",
										paste_auto_cleanup_on_paste : true,
										paste_preprocess : function(pl, o) {
											// Content string containing the HTML from the clipboard
											//alert(o.content);
											o.content = " ";
										},
										paste_postprocess : function(pl, o) {
											// Content DOM node containing the DOM structure of the clipboard
										   // alert(o.node.innerHTML);
											o.node.innerHTML =" ";
										},
									//content_css: "css/content.css",
									style_formats: [
										{title: 'Bold text', inline: 'b'},
										{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
										{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
										{title: 'Example 1', inline: 'span', classes: 'example1'},
										{title: 'Example 2', inline: 'span', classes: 'example2'},
										{title: 'Table styles'},
										{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
									],
									/*
									formats: {
										alignleft: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left'},
										aligncenter: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center'},
										alignright: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right'},
										alignfull: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full'},
										bold: {inline: 'b', classes: 'bold'},
										italic: {inline: 'i', classes: 'italic'},
										underline: {inline: 'u', classes: 'underline', exact: true},
										strikethrough: {inline: 'del'},
										customformat: {inline: 'span', styles: {color: '#00ff00', fontSize: '20px'}, attributes: {title: 'My custom format'}}
									} */
								});
								</script>
								<!--- END JAVA FOR EDITOR --->
							<br>
							<div class="alert alert-danger alert-dismissable">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Diharapkan</strong> menyimpan jawaban anda setiap beberapa menit sekali!, jawaban masih dapat diedit selama masih ada sisa waktu ujian.
							</div> 
							
							<textarea name="s_answer<?php echo $nomor;?>" class="mceEditor<?php echo $nomor;?>"  style="width:100%;height:50%;"></textarea>
							<?php
						}else{
							//menampilkan answer berdasarkan questionid
							/*
							$q_answer=mysql_query("SELECT answerid, answer_text
													from ".$db_prefix."answers 
													WHERE questionid='$list_q[questionid]' 
													ORDER BY RAND() ");*/
							
							$query_qa = "SELECT answerid, answer_text";
							$query_qa .= " FROM ".$db_prefix."answers";
							$query_qa .= " WHERE questionid='$list_q[questionid]' ";
							////////////////// QUERY RANDOM ANSWER /////////////////////
							if($list_test['test_shufflea'] == '1'){
							$query_qa .= " ORDER BY RAND()";
							}else{
							$query_qa .= " ORDER BY answerid ASC";
							}
							///////////////////////////////////////////////////////////
							
							$q_answer=mysql_query($query_qa);
													
							?>
							<div class="form-group">
							<?php
							while($list_a=mysql_fetch_array($q_answer)){ ?>
								
								<label class="radio-inline">
									<input type='radio' value='<?php echo $list_a['answerid']; ?>' name="s_answer" class="s_answer"> 
									<span class="custom-radio"></span>&nbsp;<?php echo $list_a['answer_text']; ?>
								</label><br>
							<?php
							}
							?>
							</div>
							<?php
						}
							
							if($nomor==$list_test['jmlsoal']) // jika jumlah result jawaban sama dengan  jumlah soal
							{
							?>
								<br>
								
								<input type='submit' class='btn btn-primary' name="finish" style='font-weight:bold;border:#407b9b solid 1px !important;background:#f7f7f9 !important;color:#407b9b !important;' value='<?php if($list_q['question_type']=='1'){ echo "Simpan"; }else{ echo "Selesai";} ?>'>
							<?php
							}else{
								if($list_q['question_type']=='1'){
							?>
								<br>
								
								<input type='submit' class='btn btn-primary' name='sdraft' value='Simpan'>&nbsp;&nbsp;<input type='submit' class='btn btn-primary' name='lanjut' value='Simpan dan Lanjut soal berikutnya'>
							<?php
								}else{
							?>
								<input type='submit' class='btn btn-primary' value='Lanjut'>
							<?php
								}
							}
						?>
							</form>
						</td>
						</tr>
						</table>
				</div>
			</div>
				<?php 	/* } */
				}
					
				?>
<?php } ?>
		
<?php
}
?>

	