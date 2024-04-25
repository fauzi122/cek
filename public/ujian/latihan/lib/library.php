<?php
date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Y-m-d");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");


// produces a timestamp that looks like "YYYY-MM-DD 24:00:00":
$formated_datetime = DATE("Y-m-d H:i:s");
$cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($formated_datetime)));
 
// takes $formated_datetime and converts to "UNIX timestamp":
$unix_timestamp = STRTOTIME($formated_datetime);
$unix_endtimestamp = STRTOTIME($cenvertedTime);

// var_dump($unix_endtimestamp); 
//exit();
 
// converts $unix_timestamp to "normal" formated_datetime:         
$formated_datetime = DATE("Y-m-d H:i:s",$unix_timestamp); 
?>
