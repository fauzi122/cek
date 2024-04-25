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
			
			if (hours == 0 && minutes == 0 && seconds == 0) clearInterval(interval);
		}, 1000);
	</script>
<?php 
//ambil id
//$id_user = base64_decode(mysql_real_escape_string($_GET["id"]));

		$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid, resultid from  ".$db_prefix."session where id_session = '$id_user'"));
	if($list_sess['testuser']==""){
		$test_id=$_POST['testid'];
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
		
	//jika testid kosong
	if($test_id==""){ //jika testid masih kosong
		?>
			<script language='javascript'>document.location = '<?php echo $path_base."-".base64_encode($id_user);?>';</script>
			 <meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($id_user);?>">
		<?php
	}else{

		$q_testuser=mysql_query("SELECT testid, test_datestart, test_dateend, jmlsoal, test_time, test_attempts FROM ".$db_prefix."tests WHERE testid='$test_id' ");
		$list_test=mysql_fetch_array($q_testuser);
			
			// COUNTDOWN TIMER UJIAN //
			date_default_timezone_set("Asia/Jakarta"); 
			$o_skrg = new DateTime();
			$o_batas = new DateTime(date('Y-m-d H:i:s', $list_test['test_dateend']));
			$o_sisa = $o_skrg->diff($o_batas);
			/*print_r($o_sisa);
			echo $o_sisa->format('%R')."<br />";*/
			$sisa_waktu = $o_sisa->format('%R') == '-' ? '00:00:01' : $o_sisa->format('%H:%I:%S');
			// END COUNTDOWN TIMER UJIAN //
		
		//Query tabel result
		$q_cekresult=mysql_query("SELECT resultid, result_datestart, testid, userid FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim'  ");
		$list_cekresult=mysql_fetch_array($q_cekresult);
		$row_cekresult=mysql_num_rows($q_cekresult);
		
		if($row_cekresult<1){ //Menambahkan user ujian ke tabel Result dan mensetting timer lama mengerjakan soal
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
		
		if($list_sess['resultid']<1){
			$attempresult=mysql_result(mysql_query("SELECT test_attempt_count, count(*) as num FROM ".$db_prefix."tests_attempts WHERE testid='$test_id' AND userid='$nim' "),0,"test_attempt_count");
			
			$jmlresult=mysql_fetch_array(mysql_query("SELECT count(b.resultid) as jml FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b 
									WHERE a.resultid=b.resultid AND a.testid='$test_id' AND a.userid='$nim' 
									GROUP BY b.resultid ASC ORDER BY b.resultid DESC limit 1"));
									
			if($attempresult<$list_test['test_attempts'] and $jmlresult['jml']==$list_test['jmlsoal']){
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
			//Mengambil resultid dari tabel session
			$resultid=mysql_result(mysql_query("SELECT resultid FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim' ORDER BY resultid DESC limit 1 "),0,"resultid");
			mysql_query("update ".$db_prefix."session set resultid = '$resultid' where id_session = '$id_user'");
			$result_id=mysql_result(mysql_query("select resultid from  ".$db_prefix."session where id_session = '$id_user'"),0,"resultid");
		
		//Mengecek Jumlah Result Yang Masuk
		$q_userresult=mysql_query("SELECT a.resultid,a.testid,a.userid, b.questionid
									FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b 
									WHERE a.resultid=b.resultid AND a.testid='$test_id' AND a.userid='$nim' and a.resultid='$result_id' 
									ORDER BY questionid ASC");
		$nums_question=mysql_num_rows($q_userresult);
		
		if($nums_question==$list_test['jmlsoal'] or $nums_question>$list_test['jmlsoal']){ // jika jumlah result jawaban sama dengan  jumlah soal
			
		?>
			<script language='javascript'>document.location = '<?php echo $path_base."-".base64_encode($id_user);?>';</script>
			<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($id_user);?> ">
		<?php
			
		}else{
					
				//jika sudah lewat waktu ujian
				if($list_test['test_dateend']<$unix_timestamp){
					mysql_query("update ".$db_prefix."session set testuser='', testname='', questionid = 0, resultid = 0 where id_session = '$id_user'");
				?>
				<script>
					 alert('Waktu Ujian Habis');
				</script>
				<script language='javascript'>document.location = '<?php echo $path_base."-".base64_encode($id_user);?>';</script>
				<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($id_user);?>">
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
							//menampilkan Pertanyaan dan Tidak menampilkan Pertanyaan yg sudah tayang 
							$q_question=mysql_query("SELECT a.testid,a.questionid,b.questionid,b.question_text,b.question_pre,b.question_post,b.question_type 
														FROM ".$db_prefix."tests_questions AS a,  ".$db_prefix."questions AS b 
														WHERE a.testid='$test_id' AND a.questionid=b.questionid 
														AND b.questionid 
														NOT IN (SELECT b.questionid FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b WHERE a.resultid=b.resultid AND a.testid='$test_id' AND a.userid='$nim' AND a.resultid='$result_id')
														ORDER BY RAND()LIMIT 1");
							
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
						<div class="row" style="background:#363B3F;padding:15px;color:#fff;">
							<div class="col-md-4"><?php echo $test_name; ?></div>
							<div class="col-md-4">Pertanyaan <?php echo $nomor." dari ".$list_test['jmlsoal']; ?></div>
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
							<form action='ujian.-<?php echo base64_encode($id_user);?>' method='post' id="form-ujian" novalidate="novalidate" style="width:100%;">
							<input type='hidden' name='nomor' value='<?php echo $nomor; ?>'>
							<input type='hidden' name='questionid' value='<?php echo $list_q['questionid']; ?>'>
						
								<?php 
								echo $list_q['question_text']."<br>";
								
								if($list_q['question_pre']<>""){ //Soal gambar ?>
									<img src="Image/<?php echo $list_q['question_pre'];?>" style="max-width:500;"><br>
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
							<br><textarea name="s_answer<?php echo $nomor;?>" class="mceEditor<?php echo $nomor;?>"  style="width:100%;height:50%;"></textarea>
							<?php
						}else{
							//menampilkan answer berdasarkan questionid
							$q_answer=mysql_query("SELECT answerid, answer_text
													from ".$db_prefix."answers 
													WHERE questionid='$list_q[questionid]' 
													ORDER BY RAND() ");
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
								<?php if($list_q['question_type']=='1'){ ?>
										<div class="alert alert-danger alert-dismissable">
										  <button type="button" class="close" data-dismiss="alert">&times;</button>
										  <strong>Diharapkan</strong> menyimpan jawaban anda setiap beberapa menit sekali!, jawaban masih dapat diedit selama masih ada sisa waktu ujian.
										</div> 
								<?php } ?>
								<input type='submit' class='btn btn-primary' name="finish" style='font-weight:bold;border:#407b9b solid 1px !important;background:#f7f7f9 !important;color:#407b9b !important;' value='<?php if($list_q['question_type']=='1'){ echo "Simpan"; }else{ echo "Selesai";} ?>'>
							<?php
							}else{
								if($list_q['question_type']=='1'){
							?>
								<br>
								<div class="alert alert-danger alert-dismissable">
								  <button type="button" class="close" data-dismiss="alert">&times;</button>
								  <strong>Diharapkan</strong> menyimpan jawaban anda setiap beberapa menit sekali!, jawaban masih dapat diedit selama masih ada sisa waktu ujian.
								</div> 
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

	