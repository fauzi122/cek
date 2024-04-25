
<?php
if(isset($soal->checkJawab))
{
	if ($soal->checkJawab) {
		$jawab_siswa = $soal->checkJawab->pilihan;
	}else{
		$jawab_siswa = '';
	}
}else{
		$jawab_siswa = '';
}
$id=Crypt::encryptString($cek_soal->id.','.$cek_soal->kd_mtk);
date_default_timezone_set("Asia/Jakarta"); 
$o_skrg = new DateTime();
$o_batas = new DateTime(date('Y-m-d H:i:s', STRTOTIME($hasil_ujian->akhir_ujian)));
$o_sisa = $o_skrg->diff($o_batas);
$sisa_waktu = $o_sisa->format('%R') == '-' ? '00:00:01' : $o_sisa->format('%H:%I:%S');
$akhir = date('M d, Y H:i:s', STRTOTIME($hasil_ujian->akhir_ujian));
//echo $akhir;
?>
<div class="alert alert-primary d-flex align-items-center" role="alert">
	<i class="icon-watch_later">
		Sisa waktu :&nbsp;<span id="demo"></span>
	</i>
	<span style="opacity: 0;" id="waktu-akhir">{{$akhir}}</span>
</div>
<span class="detail_soal_id" style="display: none;">{{ $soal->id }}</span>
<div class="soal">{{$no_urut}}. {!! htmlspecialchars($soal->soal) !!}</div>
<?php if (htmlspecialchars($soal->pila)) {?>
	<div class="jawab {{ $jawab_siswa == 'A' ? 'dijawab' : '' }}"
		soal-id="{{ $soal->id_soal }}"
		data-id="{{ $soal->id }}"
		data-jawab="{{ 'A/'.$soal->id.'/'.Auth::user()->id }}">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>A.</span></td>
				<td valign="top" class="pilihan">{!! htmlspecialchars($soal->pila) !!}</td>
			</tr>
		</table>
	</div>
<?php } ?>
<?php if (htmlspecialchars($soal->pilb)) {?>
	<div class="jawab {{ $jawab_siswa == 'B' ? 'dijawab' : '' }}"
		soal-id="{{ $soal->id_soal }}"
		data-id="{{ $soal->id }}"
		data-jawab="{{ 'B/'.$soal->id.'/'.Auth::user()->id }}">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>B.</span></td>
				<td valign="top" class="pilihan">{!! htmlspecialchars($soal->pilb) !!}</td>
			</tr>
		</table>
	</div>
<?php } ?>
<?php if (htmlspecialchars($soal->pilc)) {?>
	<div class="jawab {{ $jawab_siswa == 'C' ? 'dijawab' : '' }}"
		soal-id="{{ $soal->id_soal }}"
		data-id="{{ $soal->id }}"
		data-jawab="{{ 'C/'.$soal->id.'/'.Auth::user()->id }}">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>C.</span></td>
				<td valign="top" class="pilihan">{!! htmlspecialchars($soal->pilc) !!}</td>
			</tr>
		</table>
	</div>
<?php } ?>
<?php if (htmlspecialchars($soal->pild)) {?>
	<div class="jawab {{ $jawab_siswa == 'D' ? 'dijawab' : '' }}"
		soal-id="{{ $soal->id_soal }}"
		data-id="{{ $soal->id }}"
		data-jawab="{{ 'D/'.$soal->id.'/'.Auth::user()->id }}">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>D.</span></td>
				<td valign="top" class="pilihan">{!! htmlspecialchars($soal->pild) !!}</td>
			</tr>
		</table>
	</div>
<?php } ?>
<?php if (htmlspecialchars($soal->pile)) {?>
	<div class="jawab {{ $jawab_siswa == 'E' ? 'dijawab' : '' }}"
		soal-id="{{ $soal->id_soal }}"
		data-id="{{ $soal->id }}"
		data-jawab="{{ 'E/'.$soal->id.'/'.Auth::user()->id }}">
		<table width="100%">
			<tr>
				<td width="15px" valign="top"><span>E.</span></td>
				<td valign="top" class="pilihan">{!! htmlspecialchars($soal->pile) !!}</td>
			</tr>
		</table>
	</div>
<?php } ?>
<script>
// Mengatur waktu akhir perhitungan mundur
var id_soal = document.getElementById("waktu-akhir").innerHTML;
var countDownDate = new Date(id_soal).getTime();

// Memperbarui hitungan mundur setiap 1 detik
var x = setInterval(function() {

  // Untuk mendapatkan tanggal dan waktu hari ini
  var now = new Date().getTime();
  
    
  // Temukan jarak antara sekarang dan tanggal hitung mundur
  var distance = countDownDate - now;
    
  // Perhitungan waktu untuk hari, jam, menit dan detik
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Keluarkan hasil dalam elemen dengan id = "demo"
  document.getElementById("demo").innerHTML = hours + " : "
  + minutes + " : " + seconds + " ";
    
  // Jika hitungan mundur selesai, tulis beberapa teks 
  if (distance < 0) {
	clearInterval(x); alert('Waktu Ujian Anda Habis'); location.reload();
    //clearInterval(x);
    //document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
