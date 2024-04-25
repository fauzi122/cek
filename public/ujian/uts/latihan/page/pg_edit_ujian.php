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
//Query Ke Table session
$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid from  ".$db_prefix."session where id_session = '$id_user'"));
//$nim=$_POST['userid'];
$test_name=$list_sess['testname'];
$questionid=antiinjection($_POST['questionid']);
mysql_query("update ".$db_prefix."session set questionid = '$questionid' where id_session = '$id_user'");

if($_POST['userid']=="" or $_POST['testid']==""){
		$nim=$list_sess['userid'];
		$test_id=$list_sess['testuser'];
}else{
		$nim=antiinjection($_POST['userid']);
		$test_id=antiinjection($_POST['testid']);
}
if($questionid==""){
	?>
		<script language='javascript'>document.location = 'edit-<?php echo $s_id;?>';</script>
		<meta http-equiv="Refresh" content="0; URL=edit-<?php echo $s_id;?> ">
	<?php
}else{
		$q_testuser=mysql_query("SELECT testid, test_datestart, test_dateend, jmlsoal, test_time, test_type FROM ".$db_prefix."tests WHERE testid='$test_id' ");
		$list_test=mysql_fetch_array($q_testuser);
			
			
			date_default_timezone_set("Asia/Jakarta"); 
			$o_skrg = new DateTime();
			$o_batas = new DateTime(date('Y-m-d H:i:s', $list_test['test_dateend']));
			$o_sisa = $o_skrg->diff($o_batas);
			/*print_r($o_sisa);
			echo $o_sisa->format('%R')."<br />";*/
			$sisa_waktu = $o_sisa->format('%R') == '-' ? '00:00:01' : $o_sisa->format('%H:%I:%S');
			
	if($list_test['test_datestart']>$unix_timestamp){
		?>
		<script language='javascript'>document.location = '<?php echo $path_base."-".$s_id;?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$s_id;?>">
		<?php 
	}elseif($list_test['test_dateend']<$unix_timestamp){
		mysql_query("update ".$db_prefix."session set testuser='', testname='', questionid = 0, resultid = 0 where id_session = '$id_user'");
		?>
		<script language='javascript'>document.location = '<?php echo $path_base."-".$s_id;?>';</script>
		<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$s_id;?>">
		<?php 
	}else{
		//Query Ke Table result
		$q_question=mysql_query("SELECT
								  a.resultid,
								  a.result_points,
								  a.result_datestart,
								  b.result_answerid, 
								  b.resultid, 
								  b.questionid,	
								  c.question_text,
								  c.question_pre,
								  c.question_post,
								  c.question_type,
								  b.result_answer_text
								FROM ".$db_prefix."results AS a, ".$db_prefix."results_answers AS b, ".$db_prefix."questions AS c
								WHERE a.resultid=b.resultid AND b.questionid=c.questionid AND a.testid = '$test_id'
									AND a.userid = '$nim' AND b.questionid='$questionid' ORDER BY a.resultid DESC LIMIT 1");
		$list_q=mysql_fetch_array($q_question);
		$nomor=$list_q['result_answerid'];
		/* $q_cekresult=mysql_query("SELECT resultid, result_points, result_datestart FROM ".$db_prefix."results WHERE testid='$test_id' AND userid='$nim' ");
		$l_cekresult=mysql_fetch_array($q_cekresult);
		
		//Query Ke Table result answer
		$q_cekresultans=mysql_query("SELECT result_answerid, resultid, questionid, result_answer_text FROM ".$db_prefix."results_answers WHERE resultid='$l_cekresult[resultid]'");
		$list_q=mysql_fetch_array($q_cekresultans);  */
		
?>
<div class="col-md-12">
	<div class="block-web">
		<center>
		<div class="row" style="background:#363B3F;padding:15px;color:#fff;">
			<div class="col-md-4"><?php echo $test_name; ?></div>
			<div class="col-md-4">Pertanyaan <?php echo $nomor." dari ".$list_test['jmlsoal']; ?></div>
			<div class="col-md-4">
				Sisa waktu :&nbsp;<span class="kkcount-down"><?php echo $sisa_waktu;?></span>
			</div>
		</div>
		</center><br>
		<table border="0" width="100%">
			<tr>
			<td valign="top" width="2%"><?php echo $nomor.". "; ?> &nbsp;</td>
			<td width="98%">
				<form action='eujian.-<?php echo $s_id;?>' method='post' id="form-ujian" novalidate="novalidate" style="width:100%;">
				<input type='hidden' name='nomor' value='<?php echo $nomor; ?>'>
				<input type='hidden' name='questionid' value='<?php echo $list_q['questionid']; ?>'>
				
				<?php 
				if($list_q['question_pre']<>""){ //Soal gambar ?>
					<img src="Image/<?php echo $list_q['question_pre'];?>" style="max-width:450;">
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
					</script>
			<?php
			
				}
				
				echo $list_q['question_text']."<br>";
				
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
					<br>
					<div class="alert alert-danger alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Diharapkan</strong> menyimpan jawaban anda setiap beberapa menit sekali!, jawaban masih dapat diedit selama masih ada sisa waktu ujian.
					</div> 
					<textarea name="s_answer<?php echo $nomor;?>" class="mceEditor<?php echo $nomor;?>" style="width:100%;height:50%;"><?php echo $list_q['result_answer_text']; ?></textarea>
					<?php
				}else{ 
					//menampilkan answer berdasarkan questionid
					$q_answer=mysql_query("SELECT
											  a.answerid,
											  a.answer_text, b.result_answer_text
											FROM ".$db_prefix."answers AS a, ".$db_prefix."results_answers AS b
											WHERE a.questionid=b.questionid AND a.questionid = '$list_q[questionid]' AND b.resultid='$list_q[resultid]'
											ORDER BY RAND()");
					while($list_a=mysql_fetch_array($q_answer)){ ?>
						<label class="radio-inline">
							<input type='radio' value='<?php echo $list_a['answerid']; ?>' name='s_answer' class="s_answer" <?php if($list_a['answerid']==$list_a['result_answer_text']){ echo "checked='checked'";} ?> /> 
							<span class="custom-radio"></span>&nbsp;<?php echo $list_a['answer_text']; ?>
						</label><br>
						<?php
					}
				}
				?>
				<br>
					<input type='submit' class='btn btn-primary' value='Simpan'>&nbsp;
					<a href="edit-<?php echo $s_id;?>" class='btn btn-primary'>Kembali</a>
				</form>
			</td>
			</tr>
		</table>
	</div>
</div>
<?php
	}
}
?>

