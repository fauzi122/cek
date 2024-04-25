<html>
<body>
<?php 
$today=date('Y-m-d');
$tgl_mulai="2019-01-04";
$tgl_selesai="2029-01-20";

if($today<$tgl_mulai){
	echo "<script>window.alert('tgl mulai Ujian $tgl_mulai');</script>";
	?>
	
		<script>
				document.location = 'http://mahasiswa.kampus.id';
		</script>
	<?php
}elseif($today>$tgl_selesai){
	echo "<script>window.alert('tgl selesai Ujian $tgl_selesai');</script>";
	?>
		<script>
				document.location = 'http://mahasiswa.kampus.id';
		</script>
	<?php
}elseif($today>=$tgl_mulai){
	$url="login";
}
elseif($today>=$tgl_mulai){
	$url="loginuri";
}
?>
<meta http-equiv="Refresh" content="0; URL=<?php echo $url;?>">

</body>
</html>                