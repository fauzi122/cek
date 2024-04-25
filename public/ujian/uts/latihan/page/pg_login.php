<?php 
	session_start(); 
	/*unset($_SESSION); 
	session_destroy();
	session_start(); */
	$sid_lama = session_id();
	session_regenerate_id(true);
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
<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>-->
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet">
<link href="plugins/kalendar/kalendar.css" rel="stylesheet">
<link href="css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="dark-theme" onload="layar()">
<div class="header navbar navbar-inverse box-shadow navbar-fixed-top">
  <div class="navbar-inner">
    <div class="header-seperation">
      <ul class="nav navbar-nav">
        <li class="sidebar-toggle-box"> <a href="#"><i class="fa fa-bars"></i></a> </li>
        <li> <a href=""><strong>KAMPUS ONLINE - UJIAN</strong></a> </li>
        <li class="hidden-xs">
          <div class="hov">
            <div class="btn-group"> <a data-toggle="dropdown" href="" class="con"><span class="fa fa-tag"></span></a>
              <ul role="menu" class="dropdown-menu pull-right dropdown-alerts" >
                <li class="title" style="padding-top:0;padding-left:151%;">
                  <img src="images/logo_campus1.png">
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li>&nbsp;</li>
      </ul><!--/nav navbar-nav--> 
    </div><!--/header-seperation--> 
  </div><!--/navbar-inner--> 
</div><!--/header-->

<div class="page-container">
  <div class="nav-collapse top-margin fixed box-shadow2 hidden-xs" id="sidebar">
    <img alt="avatar" src="images/logo_campus.png" width="100%">       
    <ul id="nav-accordion" class="sidebar-menu">
		<li class="sub-menu dcjq-parent-li"> <a href="javascript:;" class="dcjq-parent"> <i class="fa fa-youtube-play"></i> <span>Video Simulasi Ujian</span></a>
        <ul class="sub">
          <li><a href="tutorial/multiplechoice" target=_blank><i class="fa fa-angle-right"></i> Ujian Pilihan Ganda</a></li>
          <li><a href="tutorial/essay" target=_blank><i class="fa fa-angle-right"></i> Ujian Essay</a></li>
        </ul>
		</li>
	  <li> <a href=""> <i class="fa fa-user"></i> <span>Profile Ujian</span> </a> </li>
      <!--<li> <a href=""> <i class="fa fa-dashboard"></i> <span>Info</span> </a> </li>-->
    </ul><!--/nav-accordion sidebar-menu--> 
    </div><!--/leftside-navigation--> 

  
  <div id="main-content">
    <div class="page-content">
      <div class="row">
        <div class="col-md-12">
          <h2>Halaman Login</h2>
        </div><!--/col-md-12--> 
      </div><!--/row-->
      
      <div class="row">
		
        <div class="col-md-4">
          <div class="block-web">
				<div id="dynamic-table_wrapper" class="dataTables_wrapper " >
             <!--<div class="account-status-data">
              <div class="row">
                <div class="col-md-5">
                  <h5><strong>Tanggal</strong></h5> <h4>12-05-2014</h4>
                </div>
                <div class="col-md-5">
                  <h5><strong>Jam</strong></h5> <h4>08:50</h4>
                </div>
              </div>
            </div> -->
          <div class="row">     
          <div class="col-md-12">
          
            <div class="header" style="background:#2e3236 !important;">
              <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> </div>
              <h3 class="content-header" style="color:#FFFFFF;">Pilih Perguruan Tinggi</h3>
            </div>
			<?php
				if(isset($_POST["nip"]) and isset($_POST["password"])){
					$db_pt=mysql_escape_string($_POST['ptinggi']);
					include "line/sambungan.php";					
					
					// fungsi enkripsi //
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
					//====================================//
					
					$nip = antiinjection($_POST["nip"]); 
					$password = antiinjection(md5($_POST["password"])); 

					$login=mysql_query("SELECT
				  a.user_name,
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
				WHERE b.groupid = c.groupid and c.userid=a.userid and a.userid='$nip' and user_passhash='$password' ");
				
					$ketemu=mysql_num_rows($login);
					$r=mysql_fetch_array($login);

				// Apabila username dan password ditemukan
					 if ($ketemu > 0){
						if($r['sts_bayar']=='0'){
							?>
							<div class="alert alert-danger" style="margin-top:40px;">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <h2 style="color:red;">Peringatan!</h2>
							  <h3>Status pembayaran anda masih <strong style="color:red;">Kurang <?php echo "Rp ".number_format($r['jml_kurang'],2,'.',','); ?></strong>, silahkan lakukan pembayaran dan konfirmasikan ke bagian administrasi.</h3>
							</div>
							<?php
						}else{
									// Membaca IP dan Hostname User
									if(!empty($_SERVER['HTTP_CLIENT_IP'])){
										$ip=$_SERVER['HTTP_CLIENT_IP'];
									}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
										$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
									}else{
										$ip=$_SERVER['REMOTE_ADDR'];
									}
									
									//membaca mac address
									$_IP_SERVER = $_SERVER['SERVER_ADDR'];
									$_IP_ADDRESS = $_SERVER['REMOTE_ADDR']; 
									if($_IP_ADDRESS == $_IP_SERVER){
										ob_start();
										system('ipconfig /all');
										$_PERINTAH  = ob_get_contents();
										ob_clean();
										$_PECAH = strpos($_PERINTAH, "Physical");
										$mac = antiinjection(substr($_PERINTAH,($_PECAH+36),17)); 
									}else{
										$_PERINTAH = "arp -a $_IP_ADDRESS";
										ob_start();
										system($_PERINTAH);
										$mac = ob_get_contents();
										ob_clean();
										$_PECAH = strstr($mac, $_IP_ADDRESS);
										$_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
										$mac = antiinjection(substr($_PECAH_STRING[1], 0, 17));
									}
									//end mac addess
								 $hostname = antiinjection(gethostbyaddr($_SERVER['REMOTE_ADDR']));
								 $useragent = antiinjection($_SERVER['HTTP_USER_AGENT']);
								 $referer = antiinjection($_SERVER ['REQUEST_URI']);
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
												'$r[userid]','ip:$ip - hostname:$hostname - macaddrs:$mac','$useragent','$path_base','$referer'
												)");
								}
								
								$list_sess=mysql_num_rows(mysql_query("select userid, id_session from  ".$db_prefix."session where userid='".$r['userid']."'"));
								
								$firstname=mysql_real_escape_string($r['user_firstname']);
								
								$time=3600;
								$settime=time()+$time;
								
								/* $sid_lama = session_id();
								session_regenerate_id(true); */
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
						<div class="alert alert-danger alert-dismissable">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <h4><strong>Peringatan!</strong></h4>
						  Perguruan Tinggi atau User atau Password login anda tidak ditemukan.
						</div> 
					<?php 
					}
				}
				?>
			<form method="post" action="" parsley-validate novalidate>
            <div class="porlets-content">
              
                <div class="form-group">
                  <label>Perguruan Tinggi</label>
                  <div class="input-group"> 
				  <span class="input-group-addon"><i class="fa fa-home"></i></span>
				  <select name="ptinggi" class="form-control" id="show">
					
					<option value="1">AKADEMI BSI (BINA SARANA INFORMATIKA) &nbsp;&nbsp;&nbsp;</option>
					<option value="2">UNIVERSITAS BSI</option>
					<option value="3">STMIK-STBA NUSAMANDIRI</option>
					<!-- <option value="4">STMIK ANTAR BANGSA</option> -->
				  </select>
				  </div>
                </div><!--/form-group-->

			</div>
			  <br>
			  <div class="header" style="background:#2e3236 !important;">
              <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> </div>
              <h3 class="content-header" style="color:#FFFFFF;">Form Login</h3>
            </div>
			  <div class="porlets-content">
			  
				<div id="hidediv">
					<div class="form-group">

					  <label>NIM</label>
					  <div class="input-group"> 
					  <span class="input-group-addon"><i class="fa fa-user"></i></span>
					  <input type="text" name="nip" parsley-trigger="change" required placeholder="No Induk Mahasiswa" class="form-control" maxlength="10">
					  </div>
					</div><!--/form-group-->
					<div class="form-group" id>
					  <label>Password</label>
					  <div class="input-group"> 
					  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
					  <input id="pass1" type="password" name="password" placeholder="Password" required class="form-control">
					  </div>
					</div><!--/form-group-->
					<button class="btn btn-primary" type="submit" name="login">Login</button>
				</div>
              
            </div><!--/porlets-content-->
           </form>
        </div><!--/col-md-12-->
</div>
<hr>
           </div>
          </div><!--/block-web--> 
        </div><!--/col-md-4-->
        
        <div class="col-md-8">
          <div class="block-web full">
            <ul class="nav nav-tabs nav-justified">
              <li class="active"><a data-toggle="tab" href="#about"><i class="fa fa-user"></i> PETUNJUK</a></li>
              <li><a data-toggle="tab" href="#mymessage"><i class="fa fa-envelope"></i> PENGUMUMAN</a></li>
            </ul>
            
            <div class="tab-content"> 
              <div id="about" class="tab-pane active animated fadeInRight">
                <div class="user-profile-content"> <!--style="overflow-y:scroll;height:400px;"-->
                  <h5><strong>PROSEDUR</strong> UJIAN</h5>
                  <p> 
				  <!-- <center><img src="images/prosedur.png" title="prosedur ujian online"></center><br>-->
				  <ol>
					<li>Aktifkan laptop/notebook anda koneksikan ke wireless ruangan kelas, lalu akses mahasiswa.kampus.id</li>
					<li>Untuk dapat masuk ke Sistem Ujian Online pilih Perguruan Tinggi Anda, masukan NIM dan password anda tanggal lahir format(yyyy-mm-dd), jika Anda memilih perguruan tinggi dan memasukan user dan password dengan benar maka Sistem Ujian akan membawa anda pada daftar Matakuliah Ujian Anda (KRS) </li>
					<li>Pada daftar matakuliah ujian Anda link ujian akan dapat diklik apabila tanggal dan jam ujian sudah memasuki waktu ujian</li>
					<li>Jawab Semua pertanyaan ujian, jika sudah selesai Simpan Bukti Ujian sebagai bukti bahwa anda telah mengikuti ujian online pada matakuliah yang anda ujikan</li>
					<li>Jangan Lupa Lakukan Logout setiap kali anda selesai menggunakan sitem ujian online</li>
				  </ol><br>
				  </p>
                  <hr>
                </div>
              </div>

              
 

      
<!-- AKTIFITAS - START -->
			<?php /*
				include "line/sambungan_2.php";
				
				$peng=mysql_query("SELECT * FROM pengumuman WHERE kategori='2' AND aktif_pesan='Y' ORDER BY id_pesan DESC LIMIT 10");
				
				$idpeng=1; */
			?>
          <!--<div id="mymessage" class="tab-pane">
             <div class="panel-group accordion accordion-semi" id="accordion3">
			 <?php while($pengumuman=mysql_fetch_array($peng)){?>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a class="<?php if($idpeng<>1){echo"collapsed";}?>" data-toggle="collapse" data-parent="#accordion3" href="#ac3-<?php echo $idpeng; ?>"> <i class="fa fa-angle-right"></i> <?php echo $pengumuman['judul_pesan'];?> </a> </h4>
                </div>
                <div style="<?php if($idpeng<>1){ echo"height: 0px;"; }else{ echo"height: auto;"; } ?>" id="ac3-<?php echo $idpeng; ?>" class="<?php if($idpeng<>1){ echo"panel-collapse collapse"; }else{ echo"panel-collapse in"; } ?>">
                  <div class="panel-body"> <?php echo $pengumuman['isi_pesan'];?> </div>
                </div>
              </div>
			  <?php 
			  $idpeng++;
			  } ?>
            </div>
          </div> -->


            </div><!--/tab-content--> 
          </div><!--/block-web--> 
        </div><!--/col-md-8--> 
      </div><!--/row--> 

    </div><!--/page-content end--> 
		<div class="thumbnail-footer" style="font-size:11px;">
            <div class="pull-left"> &copy; 2015 Learning Management System (LMS)<br> Power By <font style="color:#115992;">Bina Sarana Informatika</font> </div>
            <div class="pull-right"> <img src="images/logo_kampus_bawah.png" width="60"></div>
        </div>
  </div><!--/main-content end--> 
</div><!--/page-container end--> 

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.1.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="bootstrap/js/bootstrap.min.js"></script> 
<script src="js/accordion.js"></script> 
<script src="js/common-script.js"></script> 
<script src="js/jquery.nicescroll.js"></script> 

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
	if(screen.width<700){
		alert('Perangkat Anda Tidak Diperbolehkan untuk Ujian Online, resolusi layar anda '+width+'px x '+height+'px');
		document.location = "http://bsi.ac.id";
	}
}
</script>
<script type="text/javascript">
		window.history.forward();function noBack(){window.history.forward();}
</script>

</body>
</html>
