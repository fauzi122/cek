<?php
//echo $db_pt;exit();
if($db_pt=="1"){
	$host='172.16.192.80';
	$user='sibti';
	$pass='51@bt1b51';
	$db='ut5_s1_k0rl4nt45_b51';
	$db_prefix='b51';
	$path_base='../uts/';
	$path_file='http://mahasiswa.kampus.id/ujian/uts';
	$path_fprofile='http://foto.kampus.id/f0t0mhs/';
	$web_title='BSI | UJIAN ONLINE';
	$web_logo='logo bsi_150.png';
	$web_header='header_bsi.jpg';
}elseif($db_pt=="2"){
	$host='172.16.192.80';
	$user='sibti';
	$pass='51@bt1b51';
	$db='ut5_s1_k0rl4nt45_ub51';
	$db_prefix='ub51';
	$path_base='../uts/';
	$path_file='http://mahasiswa.kampus.id/ujian/uts';
	$path_fprofile='http://foto.kampus.id/fotomhsubsi/';
	$web_title='UBSI | UJIAN ONLINE';
	$web_logo='logo ubsi_150.png';
	$web_header='header_ubsi.jpg';
}elseif($db_pt=="3"){
	$host='172.16.192.80';
	$user='sibti';
	$pass='51@bt1b51';
	$db='ut5_s1_k0rl4nt45_nur1';
	$db_prefix='nur1';
	$path_base='../uts/';
	$path_file='http://mahasiswa.kampus.id/ujian/uts';
	$path_fprofile='http://foto.kampus.id/fotomhsnuri/';
	$web_title='NUSAMANDIRI | UJIAN ONLINE';
	$web_logo='logo nuri_150.png';
	$web_header='header_nuri.jpg';
}elseif($db_pt=="4"){
	$host='172.16.192.80';
	$user='sibti';
	$pass='51@bt1b51';
	$db='baak_uas_angsa';
	$db_prefix='4ng54';
	$path_base='../uts/';
	$path_file='http://mahasiswa.kampus.id/ujian/uts';
	$path_fprofile='foto4/';
	$web_title='ANTAR BANGSA | UJIAN ONLINE';
	$web_logo='logo angsa_150.png';
	$web_header='header_angsa.jpg';
}else{
	?>
	<meta http-equiv="Refresh" content="0; URL=login">
	<script language='javascript'>document.location = 'login';</script>
	<?php
}


$connect=mysql_connect($host,$user,$pass) or die ('Server Maintenance');
mysql_select_db($db,$connect) or die ('Upss..!! database tidak ada');

// Antiinjeksi sqlinjeksi, cross script //
function antiinjection($data){
  $filter_sql = mysql_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter_sql;
}



?>