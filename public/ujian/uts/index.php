<html>
<body>
<?php 
//$today=date('Y-m-d');
$today='2018-10-15';
$tgl_mulai="2018-10-15";
$tgl_selesai="2019-01-24";

if($today<$tgl_mulai){
	?>
		<script>
				document.location = 'http://mahasiswa.kampus.id';
		</script>
	<?php
}elseif($today>$tgl_selesai){
	?>
		<script>
				document.location = 'http://mahasiswa.kampus.id';
		</script>
	<?php
}elseif($today>=$tgl_mulai){
	$url="login";
}
?>
<meta http-equiv="Refresh" content="0; URL=<?php echo $url;?>">

</body>
</html>                