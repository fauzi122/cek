<html>
<body>
<?php 
$today=date('Y-m-d');
$tgl_mulai="2015-10-22";
$tgl_selesai="2015-10-31";

if($today<$tgl_mulai){
	$url="../";
}elseif($today>$tgl_selesai){
	$url="../";
}elseif($today>=$tgl_mulai){
	$url="login";
}
?>
<meta http-equiv="Refresh" content="0; URL=<?php echo $url;?>">

</body>
</html>                