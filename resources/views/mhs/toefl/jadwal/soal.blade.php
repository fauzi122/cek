
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
<div id="nomerurut" class="soal" data-id="{{$no_urut}}">{{$no_urut}}. {!! $soal->soal !!}
</div>
@if (isset($soal->url))
<a href="{{$soal->url}}" target="_blank">
	<i class="icon-file-text"></i>
	Open Link 
</a>
<hr>
@endif
 @if (isset($soal->file))
@if (substr($soal->file,-3)=='mp3')
	{{--  <audio controls="false">
		<source src="{{ Storage::url('public/soal/'.$soal->file) }}" type="audio/mpeg">
		Browsermu tidak mendukung audio, upgrade donk!
	</audio>  --}}
	<div class="mb-3">
<audio id="audioNotifikasi">
  <source src="{{ Storage::url('public/soal/'.$soal->file) }}" type="audio/mpeg">
</audio>
<button id="play" onclick="playAudio()" class="btn btn-primary btn-sm"><i class="icon-controller-play"></i>Play Audio</button>
<button id="pause" style="display: none; overflow-y: scroll !important;" onclick="pauseAudio()" class="btn btn-danger btn-sm"><i class="icon-controller-paus"></i>Pause Audio</button> 
</div>
@else
<div class="mb-3">
<img src="{{ Storage::url('public/soal/'.$soal->file) }}" class="img-thumbnail" height="300" width="300">
</div>
@endif
@endif
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
	<script type="text/javascript">
var el = document.getElementById("audioNotifikasi"); 
function playAudio() { 
  el.play();
  $('#pause').show(); 
  $('#play').hide(); 
} ;
function pauseAudio() { 
  el.pause(); 
  $('#pause').hide(); 
  $('#play').show();
} ;

$('.selesai').click(function() {
    localStorage.clear();
});
</script>

