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

