<?php
error_reporting(0);
//session_start();
include "../line/sambungan.php";
$list_timeout=mysql_fetch_array(mysql_query("SELECT timeout, login FROM ".$db_prefix."session WHERE id_session='$id_userx'"));

function timer(){
	$time=3600;
	$settime=time()+$time;
	mysql_query("UPDATE ".$db_prefix."session SET timeout='$settime' where id_session='$id_userx'");
	
}

function cek_login(){
	$timeout=$list_timeout['timeout'];
	if(time()<$timeout){
		timer();
		return true;
	}else{
		mysql_query("UPDATE ".$db_prefix."session SET timeout='' where id_session='$id_userx'");
		//unset($_SESSION['timeout']);
		return false;
	}
}
?>
