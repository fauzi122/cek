
<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>KAMPUS ONLINE - UJIAN</title>
<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet">
<link href="plugins/kalendar/kalendar.css" rel="stylesheet">
<link href="css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<style>	
		.box{
  			text-align: center;
  			width: 210px;
  			height: 70px;  			
  			line-height: 70px;
  			background-image: url(660883.jpg);
  			font-size: 20px;
  			font-weight: bold;
  			border: 2px solid #4000ff;
  			margin: 10px;
  		}
  		input[type=text],input[type=submit]
  		{
  			margin-left: 10px;
  		}
</style>
</head>
<body class="dark-theme" onload="layar()">
						<div id="myModal1" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
									<div style="text-align: center; color: #8c0000; font-size: 2.3em; padding-bottom: 10px"><strong>Captcha..!!!</strong></div>
									</div>
									<div class="modal-body"> 
										<center>
											<?php if ($caption!=null) {
												echo $caption;
											} ?>
									<form method="post">
									<div class="box">
											<?php 
											$bil = rand(0,9);
											$bils = rand(0,99);
											$jum = $bil + $bils;
											?>
											<?php echo $bil." + " .$bils; ?>
									</div>
										<input type="hidden" name="text2" value="<?php echo $jum; ?>">
										<input type="text" class="form-control" placeholder="Input Hasil Dari Perhitungan" name="text1">  
										<input type="submit" class="btn btn-warning" name="tom" value="Submit">
									</form>
									</center>
									</div>
								</div>

							</div>
						</div>
						<?php 
// if(isset($_POST['tom']))
// {
// if($_POST['text1']==$_POST['text2'])
// {
// echo "Capha Bener";
// }else{
// echo "Code Captha Salah";
// }
// }
?>

			<?php  
			// if(isset($_POST['tom']))
			// {
			// if($_POST['text1']==$_POST['text2'])
			// {
				session_start(); 
$sid_lama = session_id();
session_regenerate_id(true);
			$db_pt='1';
			include "line/sambungan.php";
			function enkripsime($kata_en, $chipper_en) {
				static $karakter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$chipper_en = (int)$chipper_en % 26;
				if (!$chipper_en) return $kata_en;
				if ($chipper_en == 13) return str_rot13($kata_en);
				for ($i = 0, $l = strlen($kata_en); $i < $l; $i++) {
					$c = $kata_en[$i];
					if ($c >= 'a' && $c <= 'z') {
						$kata_en[$i] = $karakter[(ord($c) - 71 + $chipper_en) % 26];
					} else if ($c >= 'A' && $c <= 'Z') {
						$kata_en[$i] = $karakter[(ord($c) - 39 + $chipper_en) % 26 + 26];
					}
				}
				return $kata_en;
			}
			$dec=base64_decode($_GET['id']);
			$exp=explode(",",$dec);
			$dec_nim=base64_decode($exp[0]);
			$cek_user=mysql_query("SELECT
				  a.user_name,
				  a.kd_lokal,
				  a.userid,
				  a.user_passhash,
				  a.user_firstname,
				  a.sts_bayar, 
				  a.jml_kurang,
				  b.groupid,
				  b.group_name,
				  c.groupid
				FROM ".$db_prefix."users AS a,
				  ".$db_prefix."groups AS b,
				  ".$db_prefix."groups_users AS c
				WHERE b.groupid = c.groupid and c.userid=a.userid and a.userid='$dec_nim'");

			// $ketemu=mysql_num_rows($cek_user);
			// $cek_user=mysql_query("select kd_lokal from b51users where userid='$dec_nim'");
			$r=mysql_fetch_array($cek_user);
			$kd_lokal=base64_encode($r['kd_lokal']);
			$ed_kode=enkripsime($kd_lokal, 213091);
			// var_dump($ed_kode.'-'.$exp[1]);
			if($ed_kode==$exp[1]){
				// var_dump("tes"); die;
				
				if($r['sts_bayar']=='0'){
					?>
					<div class="alert alert-danger" style="margin-top:40px;">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <h2 style="color:red;">Peringatan!</h2>
					  <h3>Status pembayaran anda masih <strong style="color:red;">Kurang 
					 
					  
					  </strong>, silahkan lakukan pembayaran dan konfirmasikan ke bagian administrasi.</h3>
					</div>
					<?php
				}else{
						
						$list_sess=mysql_num_rows(mysql_query("select userid, id_session from  ".$db_prefix."session where userid='".$r['userid']."'"));
						
						$firstname=mysql_escape_string($r['user_firstname']);
						
						$time=3600;
						$settime=time()+$time;
						$sid_baru = $db_pt."".$r['userid']."".session_id();

						if($list_sess>0){
							mysql_query("DELETE FROM ".$db_prefix."session  where userid='".$r['userid']."'");
							
							mysql_query("INSERT INTO ".$db_prefix."session
										(userid,
										 passuser,
										 nama,
										 groups,
										 login,
										 timeout,
										 id_session)
								VALUES ('$r[userid]',
										'$r[user_passhash]',
										'$firstname',
										'$r[group_name]',
										'1',
										'$settime',
										'$sid_baru')"); 
						}else{
							
							mysql_query("INSERT INTO ".$db_prefix."session
										(userid,
										 passuser,
										 nama,
										 groups,
										 login,
										 timeout,
										 id_session)
								VALUES ('$r[userid]',
										'$r[user_passhash]',
										'$firstname',
										'$r[group_name]',
										'1',
										'$settime',
										'$sid_baru')"); 
						}
						
						
						$encode_sid=base64_encode($sid_baru);
						$en_sid=enkripsime($encode_sid, 213091);
						
						  ?>
							<meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".$en_sid;?>">
							<script language='javascript'>document.location = '<?php echo $path_base."-".$en_sid;?>'></script>
						  <?php
				}
					}else{
						
					?>
						<div id="myModal2" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
									<div style="text-align: center; color: #8c0000; font-size: 2.3em; padding-bottom: 10px"><strong>Peringatan..!!!</strong></div>
									</div>
									<div class="modal-body">
									<div style="text-align: center; color: #000066; font-size: 1.5em;">Halaman ini Hanya Bisa Diakses pada Waktu Ujian atau Data Kamu Tidak ada Dalam Peserta Ujian Silahkan Konfrimasi Ke Admin</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
					<?php
					}
				//  }
				//  }
				  ?>
<script src="js/jquery-1.11.1.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="bootstrap/js/bootstrap.min.js"></script> 
<script>
function layar() {
	var width=screen.width;
	var height=screen.height;
	/*
	var cek=alert('Your Screen Resolution '+width+'px x '+height+'px');
	if(cek) {
	document.write('Your Screen Resolution '+width+'px x '+height+'px');
	}
	*/
	// if(screen.width<700){
	// 	alert('Perangkat Anda Tidak Diperbolehkan untuk Ujian Online, resolusi layar anda '+width+'px x '+height+'px');
	// 	document.location = "http://bsi.ac.id";
	// }
}
</script>
<script type="text/javascript">
		window.history.forward();function noBack(){window.history.forward();}
</script>
<script>
$('#myModal').modal('show');
$('#myModal2').modal('show');
</script>
</body>
</html>
