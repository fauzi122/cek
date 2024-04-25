<?php
//ambil id
$id_user = base64_decode(mysql_escape_string($_GET["id"]));
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
header ('location:login');
?>