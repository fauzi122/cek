<?php
//ambil id
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
$s_id=$_GET["id"];
/* $encode_sid=base64_encode($s_id);
$en_sid=enkripsime($encode_sid, 213091); */
								
$dec_sid=enkripsime($s_id, -213091);
$decode_sid=base64_decode($dec_sid);

$id_user = $decode_sid;
$db_pt=substr($id_user,0,1);
//session_start();
include "line/sambungan.php";

$list_sess=mysql_fetch_array(mysql_query("select testuser, testname, userid from  ".$db_prefix."session where id_session = '$id_user'"));

$user_id = $list_sess['userid'];
$outurl = $_SERVER['REQUEST_URI'];

//query update log user pertanggal

			mysql_query("UPDATE ".$db_prefix."visitors SET enddate='$unix_timestamp', outurl='$outurl' WHERE LEFT(FROM_UNIXTIME(startdate),10)='$tgl_sekarang' AND userid='$user_id'");


//hapus session
		mysql_query("DELETE FROM ".$db_prefix."session where id_session = '$id_user'");
session_destroy();
header ('location:http://ujiankampus.bsi.ac.id/');
?>