<?php 
	session_start(); 
	/*unset($_SESSION); 
	session_destroy();
	session_start(); */
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>BSI | ONLINE CAMPUS | STUDENTS</title>

<!-- Bootstrap -->
<link href="<?php echo $aset;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $aset;?>/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $aset;?>/css/style.css" rel="stylesheet">
<link href="<?php echo $aset;?>/css/style-responsive.css" rel="stylesheet">
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
if(screen.width<800)
{
alert('Perangkat Anda Tidak Diperbolehkan untuk Ujian Online, resolusi layar anda '+width+'px x '+height+'px');
document.location = "http://bsi.ac.id";
}
}
</script>
<script type="text/javascript">
		window.history.forward();function noBack(){window.history.forward();}
	</script>
</head>

<body class="page-bg" onload="layar()">
<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          &nbsp;
          
        </div>
      </div>
	 </div>
    
<?php

if($_POST['login']){
		include "line/sambungan.php";
	$nip = mysql_real_escape_string($_POST["nip"]); 
	$password = mysql_real_escape_string(md5($_POST["password"])); 

	$login=mysql_query("SELECT
  a.user_name,
  a.userid,
  a.user_passhash,
  a.user_firstname,
  b.groupid,
  b.group_name,
  c.groupid
FROM ".$db_prefix."users AS a,
  ".$db_prefix."groups AS b,
  ".$db_prefix."groups_users AS c
WHERE b.groupid = c.groupid and c.userid=a.userid and a.userid='$nip' and user_passhash='$password' ");

	$ketemu=mysql_num_rows($login);
	$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
	 if ($ketemu > 0){
					// Membaca IP dan Hostname User
			    	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
						$ip=$_SERVER['HTTP_CLIENT_IP'];
					}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
						$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
					}else{
						$ip=$_SERVER['REMOTE_ADDR'];
					}
				 $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				 $useragent = $_SERVER['HTTP_USER_AGENT'];
				 $referer = $_SERVER ['REQUEST_URI'];
		//query jumlah log user pertanggal
		$q_rowlog=mysql_query("SELECT FROM_UNIXTIME(startdate) AS tgl_log, hits FROM ".$db_prefix."visitors WHERE LEFT(FROM_UNIXTIME(startdate),10)='$tgl_sekarang' AND userid='$r[userid]' ORDER BY visitorid DESC ");
		$list_rowlog=mysql_fetch_array($q_rowlog);
		$numslogin=mysql_num_rows($q_rowlog);
		if($numslogin<1 or $list_rowlog['hits']>0){
			mysql_query("INSERT INTO ".$db_prefix."visitors
						(startdate,
						 enddate,
						 userid,host,useragent,referer,inurl)
				VALUES ('$unix_timestamp',
						'$unix_timestamp',
						'$r[userid]','$ip $hostname','$useragent','$path_base','$referer'
						)");
		}
		
		
	/*
	$_SESSION['851namauser'] 	= $r['userid'];
	  //echo $_SESSION['851namauser'];
	$_SESSION['851passuser'] 	= $r['user_passhash'];
	$_SESSION['851nama']		= $r['user_firstname'];
	$_SESSION['851group'] = $r['group_name'];
	$_SESSION['login'] = 1;
	timer();  */
	$firstname=mysql_real_escape_string($r['user_firstname']);
	mysql_query("REPLACE INTO ".$db_prefix."session
            (userid,
             passuser,
             nama,
             groups,
             login)
VALUES ('$r[userid]',
        '$r[user_passhash]',
        '$firstname',
        '$r[group_name]',
        '1')"); 
		
	$time=3600;
	$settime=time()+$time;
	mysql_query("UPDATE ".$db_prefix."session SET timeout='$settime' where id_session='$id_userx'");
	
	
	$sid_lama = session_id();
	
	session_regenerate_id();

	$sid_baru = session_id();

	mysql_query("UPDATE ".$db_prefix."session SET id_session='".$sid_baru."' WHERE userid='".$r['userid']."'");
	
	//echo mysql_result(mysql_query("select * from ".$db_prefix."session where userid='".$r['userid']."' and id_session='".$sid_baru."'"));
	//echo "select * from ".$db_prefix."session where userid='".$r['userid']."' and id_session='".$sid_baru."'";
//exit();
	  ?>
	 <meta http-equiv="Refresh" content="0; URL=<?php echo $path_base."-".base64_encode($sid_baru);?>">

	  <?php
	 
	}else{
	?>
		<div class="alert alert-error" style="margin-top:40px;">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Peringatan!</h4>
		  <strong>User</strong> atau <strong>Password</strong> login anda salah.
		</div>
	<?php 
	}
}
?>
<div class="container">

<div class="row">
	<div class="bglog span4 ">
	<form method="post" action="" style="padding:20px 30px;">
	<table border="0" align="" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" align="center">
				<h2 style="color:#fff;text-shadow: 0.1em 0.1em 0.05em #333">Login Ujian</h2>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr><td width="100"><b style="color:#000;">Username (No Formulir) </b></td></tr>
		<tr>
			<td ><input type="text" name="nip" maxlength="9"/></td>
		</tr>
		<tr><td width="100"><b style="color:#000;">Password</b></td></tr>
		<tr>
			<td><input type="password" name="password" maxlength="10"/></td>
		</tr>
		<tr>
			<td colspan="2" align="left">
				<input class="btn" name="login" type="submit" id="Login" value="LOGIN" />
			</td>
		</tr>
	</table>
	</form>
	<p class="info"><strong>Untuk mahasiswa peserta ujian:</blink></strong><br>
	Username Anda adalah (Nomor Formulir) dan password Anda adalah (Password Formulir Anda)</p>
	</div>

	<div  class="span8 last" style="padding-top:8%;">
	<div class="logo responsive-image">&nbsp;</div>
	<!--	<strong>Tutorial ujian online:</strong><br>
		<a href="http://ujian.bsi.ac.id/her/tutorial/" target=_blank><img src="img/tutor.png" > </a> -->
		<strong><blink>Pengumuman:</blink></strong><br>
		<ol>
		<li>Ujian ORMIK Online Gelombang I berlangsung pada tanggal 7 April s/d 31 Mei 2013 </li>
		<li>Ujian ORMIK Online dilakukan secara online internet dan peserta dapat melakukan ujian sebanyak 3 kali</li>
		</ol>
	</div>
	
	<div class="span12">
		<br>
		<hr style="border-color:#dbd9d9;">

		<p align="center">Copyright &copy; 2014. All Rights Reserved.<br>
	Power by<br>
	<img src="img/logo_bsi.png" width="32"> </p>
	
	</div>
</div>	


</div>
</body>
</html>
