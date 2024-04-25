<?php
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
{{$no_urut}}. {!! $soal_essay->soal ?? "Belum ada soal!" !!}

<textarea name="jawab_essay" id="jawab_essay" class="form-control" placeholder="Tulis jawaban kamu disini!" style="margin-top: 15px; height: 100px">{{ $soal_essay->userJawab->jawab ?? "" }}</textarea>

<div class="alert alert-info alert-dismissible" id="notif-essay" style="display: none"></div>
<button class="btn btn-primary" id="simpan-essay" data-id="{{ $soal_essay->id }}" data-soal="{{$soal_essay->id_soal}}">Simpan Jawaban</button>
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