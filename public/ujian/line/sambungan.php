<?php
//echo $db_pt;exit();
if ($db_pt == "1") {
	$host = '172.16.192.37';
	$user = '3l_ubS1';
	$pass = 'BT!bS12021';
	$db = 'uj14n_d3_b51';
	$db_prefix = 'b51';
	$path_base = '';
	//$path_base = '../ujian/';
	//$path_file='http://mhsonline.bsi.ac.id/ujian';
	$path_file = 'http://ujiankampus.bsi.ac.id';
	//$path_fprofile = 'http://foto.kampus.id/f0t0mhs/';
	$web_title = 'Universitas Bina Sarana Informatika | Ujian Online';
	$web_logo = 'logo bsi_150.png';
	$web_header = 'header_bsi.jpg';
	// $host = '172.16.192.80';
	// $user = 'sibti';
	// $pass = 'Hl8llTT6E9';
	// $db = 'uj14n_d3_b51';
	// $db_prefix = 'b51';
	// $path_base = '';
	// //$path_base = '../ujian/';
	// //$path_file='http://mhsonline.bsi.ac.id/ujian';
	// $path_file = 'http://ujiankampus.bsi.ac.id';
	// //$path_fprofile = 'http://foto.kampus.id/f0t0mhs/';
	// $web_title = 'UNIVERSITAS BINA SARANA INFORMATIKA | UJIAN ONLINE';
	// $web_logo = 'logo bsi_150.png';
	// $web_header = 'header_bsi.jpg';

	// $host = '172.16.192.37';
	// $user = '3l_ubS1';
	// $pass = 'BT!bS12021';
	// $db = 'uj14n_d3_b51';
	// $db_prefix = 'b51';
	// $path_base = '';
	// //$path_base = '../ujian/';
	// //$path_file='http://mhsonline.bsi.ac.id/ujian';
	// $path_file = 'http://ujiankampus.bsi.ac.id';
	// //$path_fprofile = 'http://foto.kampus.id/f0t0mhs/';
	// $web_title = 'UNIVERSITAS BINA SARANA INFORMATIKA | UJIAN ONLINE';
	// $web_logo = 'logo bsi_150.png';
	// $web_header = 'header_bsi.jpg';

} elseif ($db_pt == "2") {
	$host = '172.16.192.80';
	$user = 'sibti';
	$pass = 'Hl8llTT6E9';
	$db = 'uj14n_s1_ub51';
	$db_prefix = 'ub51';
	$path_base = '../ujian/';
	$path_file = 'http://mahasiswa.kampus.id/ujian';
	$path_fprofile = 'http://foto.kampus.id/fotomhsubsi/';
	$web_title = 'UBSI | UJIAN ONLINE';
	$web_logo = 'logo ubsi_150.png';
	$web_header = 'header_ubsi.jpg';
} elseif ($db_pt == "3") {
	$host = '172.16.192.80';
	$user = 'sibti';
	$pass = 'Hl8llTT6E9';
	$db = 'uj14n_s1_nur1';
	$db_prefix = 'nur1';
	$path_base = '../ujian/';
	$path_file = 'http://mahasiswa.kampus.id/ujian';
	$path_fprofile = 'http://foto.kampus.id/fotomhsnuri/';
	$web_title = 'NUSAMANDIRI | UJIAN ONLINE';
	$web_logo = 'logo nuri_150.png';
	$web_header = 'header_nuri.jpg';
} elseif ($db_pt == "4") {
	$host = '172.16.192.80';
	$user = 'sibti';
	$pass = 'Hl8llTT6E9';
	$db = 'baak_uas_angsa';
	$db_prefix = '4ng54';
	$path_base = '../ujian/';
	$path_file = 'http://mahasiswa.kampus.id/ujian';
	$path_fprofile = 'foto4/';
	$web_title = 'ANTAR BANGSA | UJIAN ONLINE';
	$web_logo = 'logo angsa_150.png';
	$web_header = 'header_angsa.jpg';
} else {
?>
	<meta http-equiv="Refresh" content="0; URL=login">
	<script language='javascript'>
		document.location = 'login';
	</script>
<?php
}

define('HOST','172.16.192.37');
define('USER','3l_ubS1');
define('PASS','BT!bS12021');
define('DB1', 'uj14n_d3_b51');
$host = '172.16.192.37';
$user = '3l_ubS1';
$pass = 'BT!bS12021';
$db = 'uj14n_d3_b51';
$db_prefix = 'b51';
$path_base = '';
//$path_base = '../ujian/';
//$path_file='http://mhsonline.bsi.ac.id/ujian';
$path_file = 'http://ujiankampus.bsi.ac.id';
//$path_fprofile = 'http://foto.kampus.id/f0t0mhs/';
$web_title = 'Universitas Bina Sarana Informatika | Ujian Online';
$web_logo = 'logo bsi_150.png';
$web_header = 'header_bsi.jpg';
 
// Buat Koneksinya
// $connect = new mysqli(HOST, USER, PASS, DB1);
// $login=mysqli_query("SELECT * FROM b51users");	
// $sql = "SELECT * FROM b51users";
// $query = mysqli_query($sql);
// if ($connect->connect_error) {
// 	die("<b>Yahh! Koneksi MySQLi Object-Oriented gagal</b> : " . mysqli_connect_error());
// } else {
// 	echo "<b>Hore! Koneksi MySQLi Object-Oriented Berhasil</b>";
// }

$connect = mysqli_connect($host, $user, $pass) or die('Server Maintenance');
mysqli_select_db($db, $connect) or die('Upss..!! database tidak ada');
var_dump($connect);
die;

// Antiinjeksi sqlinjeksi, cross script //
function antiinjection($data)
{
	$filter_sql = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
	return $filter_sql;
}



?>