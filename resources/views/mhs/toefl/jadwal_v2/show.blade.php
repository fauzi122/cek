@extends('layouts.mhs.main')
@section('content')
<?php 
date_default_timezone_set("Asia/Jakarta"); 
$o_skrg = new DateTime();
$o_batas = new DateTime(date('Y-m-d H:i:s', STRTOTIME($hasil_ujian->akhir_ujian)));
$o_sisa = $o_skrg->diff($o_batas);
$sisa_waktu = $o_sisa->format('%R') == '-' ? '00:00:01' : $o_sisa->format('%H:%I:%S');
$akhir = date('M d, Y H:i:s', STRTOTIME($hasil_ujian->akhir_ujian));
//echo $akhir;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="modal-body">
                        <div class="row gutters">
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="invoice-container">
                                                <!-- Row start -->
                                                <div class="row gutters">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="box-body">
                                                                <div id="wrap-soal">
                                                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                                                    <i class="icon-watch_later"> Sisa waktu :&nbsp;<span id="demo"></span></i>
                                                                    <span style="opacity: 0;" id="waktu-akhir">{{$akhir}}</span>
                                                                </div>
                                                                    @if($soals->count())
                                                                    @foreach($soals as $key=>$data)
                                                                    @if($key == 0)
                                                                    
                                                                    @if ($data->checkJawab)
                                                                       <center><button type="button" class="no_soal btn btn-primary" data-id="{{ $soals[0]->id }}" data-toggle="modal" data-target=".bd-example-modal-xl">Lanjut Ujian</button></center><br>
                                                                    @else
                                                                        <span class="detail_soal_id" style="display: none;">{{ $data->id }}</span>
                                                                    <div class="soal">1. {!! htmlspecialchars($data->soal) !!}</div>
                                                                    {!! htmlspecialchars($data->pila) ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="A/'.$data->id.'/'.Auth::user()->id.'">
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td width="15px" valign="top"><span>A.</span></td>
                                                                                <td valign="top" class="pilihan">'.$data->pila.'</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>' : '' !!}
                                                                    {!! htmlspecialchars($data->pilb) ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="B/'.$data->id.'/'.Auth::user()->id.'">
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td width="15px" valign="top"><span>B.</span></td>
                                                                                <td valign="top" class="pilihan">'.$data->pilb.'</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>' : '' !!}
                                                                    {!! htmlspecialchars($data->pilc) ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="C/'.$data->id.'/'.Auth::user()->id.'">
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td width="15px" valign="top"><span>C.</span></td>
                                                                                <td valign="top" class="pilihan">'.$data->pilc.'</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>' : '' !!}
                                                                    {!! htmlspecialchars($data->pild) ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="D/'.$data->id.'/'.Auth::user()->id.'">
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td width="15px" valign="top"><span>D.</span></td>
                                                                                <td valign="top" class="pilihan">'.$data->pild.'</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>' : '' !!}
                                                                    {!! htmlspecialchars($data->pile) ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="E/'.$data->id.'/'.Auth::user()->id.'">
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td width="15px" valign="top"><span>E.</span></td>
                                                                                <td valign="top" class="pilihan">'.$data->pile.'</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>' : '' !!}
                                                                   
                                                                    @endif
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                
                                                            {{--  </div>  --}}
                                                            <div class="box-footer">
                                                                <table width="100%">
                                                                    <tr>
                                                                        <!-- <td width="33%" align="center"><button class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Soal Sebelumnya</button></td> -->
                                                                        <!-- <td width="33%" align="center"><button class="btn btn-warning">Ragu-ragu</button></td> -->
                                                                        <!-- <td width="33%" align="center"><button class="btn btn-primary">Soal Berikutnya <i class="fa fa-angle-double-right"></i></button></td> -->
                                                                        <td>
                                                                      
                                                                            <br>
                                                                            <hr>

                                                                              <a href="/selesai-ujian/{{$id}}" class="btn pull-left" style="background-image: linear-gradient(to right, #4cf315 , #04bd20); border: none; color: #fff;">Selesai Ujian</a>
                                                                              <a href="/exercise" class="btn pull-left" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;">Keluar</a>
                                                                            {{--  <button type="button" class="btn pull-left" id="keluar" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;" onclick="$('#specialstuff').fullScreen(false)"><i class="fa fa-times-circle" aria-hidden="true"></i> Keluar</button>
                                                                            <button type="button" class="btn pull-right" id="kirim" style="background-image: linear-gradient(to right, #1523f3 , #0495c1); border: none; color: #fff;"><i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim Hasil Ujian</button>  --}}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <div id="confirm" style="display: none; margin: 15px 0; border: solid thin #aaa; padding: 10px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row end -->
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div id="wrap-nomer"class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                            </div>
                            {{--  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="card text-center">
										<div class="card-header">
											<div class="card-title">Nomor Soal Pilihan Ganda</div>
										</div>
										<div class="card-body">
											<div class="categoriesx">
                                        <center>
                                        @if($soals->count())
                                                @if ($jml_jawab->count())
                                            @foreach ($jml_jawab as $urut=>$jml)
                                                <span class="no_soal badge badge-pill"  style="background-color:#1980d4;" id="{{ 'nav'.$jml->id }}" data-id="{{ $jml->id }}" data-no="{{ $urut+1 }}" data-soal="{{ $jml->id_soal}}"><a href="#">{{ $urut+1 < 10 ? '0':'' }}{{ $urut+1 }}</a></span>
                                            @endforeach
                                                <span class="no_soal badge badge-pill badge-light" id="dis" data-no="{{ $urut+2 }}" data-random="1" style="pointer-events: none;" data-soal="{{ $jml->id_soal}}"><a href="#" >Lanjut</a></span>
                                               
                                                @endif
                                        @endif
                                            </center>
											</div>
										</div>
										<div class="card-header">
											<div class="card-title">Nomor Soal Essay</div>
										</div>
										<div class="card-body">
											<div class="categories">
                                             @if($soal->detail_soal_essays->count())
                                                @foreach($soal->detail_soal_essays as $key_number => $data_number)
                                                    <span class="no_soal_essay badge {{ $data_number->userJawab == true ? 'badge-primary' : 'badge-light' }}" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#">{{ $key_number+1 }}</a></span>
                                                @endforeach
                                            @endif
											</div>
										</div>
									</div>
								</div>  --}}
                        </div>
                    </div>
                    {{--  <div class="table-container">
            <div class="table-responsive">
                <h4 style="margin:  0 0 0 0; color: #184194; font-size: 24pt;">
                    <center>
                        Detail Latihan Soal Ujian</center></h4>
                    <hr>
                <div id="fsstatus" style="font-size: 14pt; margin: 0 0 20px 0; color: #888c8e"></div>
               
                    <table class="table table-striped">
                        
                        <tr>
                            <td style="width: 220px">Paket Ujian</td>
                            <td style="width: 15px">:</td>
                            <td>{{ $soal->paket }}</td>
                        </tr>
                        <tr>
                            <td style="width: 220px">Mulai Ujian</td>
                            <td style="width: 15px">:</td>
                            <td>{{ $soal->tgl_ujian }} - {{$id}}</td>
                        </tr>
                        <tr>
                            <td style="width: 220px">Selsai Ujian</td>
                            <td style="width: 15px">:</td>
                            <td>{{ $soal->tgl_selsai_ujian }}</td>
                        </tr>
                        <tr>
                            <td style="width: 220px">Deskripsi</td>
                            <td style="width: 15px">:</td>
                            <td>{{ $soal->deskripsi }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Soal Pilihan Ganda</td>
                            <td>:</td>
                            <td>{{ $soal->detailSoal ? number_format($soal->detailSoal->count()) : '0' }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Soal Essay</td>
                            <td>:</td>
                            <td>{{ $soal->detail_soal_essays ? number_format($soal->detail_soal_essays->count()) : '0' }}</td>
                        </tr>
                        <tr>
                            <td>KKM</td>
                            <td>:</td>
                            <td>{{ $soal->kkm }}</td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td><b>{{ $soal->waktu }}</b> Menit</td>
                        </tr>
                    </table>
                   
                    <button type="button" class="no_soal btn btn-primary" data-id="{{ $soals[0]->id }}" data-toggle="modal" data-target=".bd-example-modal-xl">Mulai Mengerjakan</button>

                     <button class="btn btn-primary btn-lg btn-block" id="start-exam" onclick="$('#specialstuff').fullScreen(true)">Mulai Mengerjakan Soal!</button>  
                </div>
            </div>
        </div>  --}}
        <!-- tampilkan soal disini -->
        {{--  <div id="specialstuff" class="row" style="display: none; overflow-y: scroll !important;">
            <div style="height: 40px; background: #6c6c70; color: #fff; margin-bottom: 15px">
                <p style="padding-top: 8px; padding-left: 20px; font-weight: bold;">MY-BEST |Universitas Bina Sarana Informatika</p>
            </div>
             <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="box box-primary color-palette-box" style="overflow-y: scroll;">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Soal No:
                            @if($soals->count())
                            @foreach($soals as $key_number=>$data_number)
                            @if($key_number == 0) <span id="no_soal_detail">1</span> @endif
                            @endforeach
                            @endif
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="wrap-soal">
                            @if($soals->count())
                            @foreach($soals as $key=>$data)
                            @if($key == 0)
                            <span class="detail_soal_id" style="display: none;">{{ $data->id }}</span>
                            <div class="soal">{!! $data->soal !!}</div>
                            {!! $data->pila ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="A/'.$data->id.'/'.Auth::user()->id.'">
                                <table width="100%">
                                    <tr>
                                        <td width="15px" valign="top"><span>A.</span></td>
                                        <td valign="top" class="pilihan">'.$data->pila.'</td>
                                    </tr>
                                </table>
                            </div>' : '' !!}
                            {!! $data->pilb ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="B/'.$data->id.'/'.Auth::user()->id.'">
                                <table width="100%">
                                    <tr>
                                        <td width="15px" valign="top"><span>B.</span></td>
                                        <td valign="top" class="pilihan">'.$data->pilb.'</td>
                                    </tr>
                                </table>
                            </div>' : '' !!}
                            {!! $data->pilc ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="C/'.$data->id.'/'.Auth::user()->id.'">
                                <table width="100%">
                                    <tr>
                                        <td width="15px" valign="top"><span>C.</span></td>
                                        <td valign="top" class="pilihan">'.$data->pilc.'</td>
                                    </tr>
                                </table>
                            </div>' : '' !!}
                            {!! $data->pild ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="D/'.$data->id.'/'.Auth::user()->id.'">
                                <table width="100%">
                                    <tr>
                                        <td width="15px" valign="top"><span>D.</span></td>
                                        <td valign="top" class="pilihan">'.$data->pild.'</td>
                                    </tr>
                                </table>
                            </div>' : '' !!}
                            {!! $data->pile ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="E/'.$data->id.'/'.Auth::user()->id.'">
                                <table width="100%">
                                    <tr>
                                        <td width="15px" valign="top"><span>E.</span></td>
                                        <td valign="top" class="pilihan">'.$data->pile.'</td>
                                    </tr>
                                </table>
                            </div>' : '' !!}
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <table width="100%">
                            <tr>
                                <td>
                                   <button type="button" class="btn pull-left" id="keluar" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;" onclick="$('#specialstuff').fullScreen(false)"><i class="fa fa-times-circle" aria-hidden="true"></i> Keluar</button>
                                    <button type="button" class="btn pull-right" id="kirim" style="background-image: linear-gradient(to right, #1523f3 , #0495c1); border: none; color: #fff;"><i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim Hasil Ujian</button>
                                </td>
                            </tr>
                        </table>
                        <div id="confirm" style="display: none; margin: 15px 0; border: solid thin #aaa; padding: 10px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="box box-success color-palette-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Navigasi Soal</h3>
                    </div>
                    <div class="box-body">
                        @if($soals->count())
                        <span>Nomor Soal Pilihan Ganda</span>
                        <nav aria-label="Page navigation">
                            <ul class="pagination" style="margin-top: 5px !important;">
                                @foreach($soals as $key_number=>$data_number)
                                <li class="no_soal" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#">{{ $key_number+1 }}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                        @endif
        
                        @if($soal->detail_soal_essays->count())
                        <span>Nomor Soal Essay</span>
                        <nav aria-label="Page navigation">
                            <ul class="pagination" style="margin-top: 5px !important;">
                                @foreach($soal->detail_soal_essays as $key_number => $data_number)
                                <li class="no_soal_essay" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#">{{ $key_number+1 }}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>  --}}
    {{--  tutup soal  --}}
    <noscript>
        <style type="text/css">
            #specialstuff {
                display: none;
            }
        </style>
        <div class="noscriptmsg">
            You dont have javascript enabled. Good luck with that.
        </div>
    </noscript>

@endsection
@push('scripts')
<script src="{{ url('js/jquery.fullscreen-min.js') }}"></script>
<script>

	$(document).bind("fullscreenchange", function(e) {
		if ($(document).fullScreen()) {
			console.log('sedang ujian!');
		} else {
			$("#specialstuff").hide();
		}
	});

	// var countdownTimer = setInterval('timer()', 1000);
	$(document).ready(function() {
		if (typeof(Storage) !== "undefined") {
			// console.log('browser support localstorage');
		} else {
			// swal(
			// 	'Update Browser!',
			// 	'Browser tidak support untuk proses ujian ini!',
			// 	'warning'
			// )
		}
$('.no_soal_essay').click(function() {
			var id_soal_esay = $(this).data('id');
			var no_urut = $(this).data('no');
			$.ajax({
				url: "{{ url('/get-soal_essay') }}",
				type: "GET",
				data: {
					id_soal_esay: id_soal_esay,
					no_urut: no_urut
				},
				success: function(data) {
                    //console.log(data.html);
					$("#wrap-soal").html(data.html);
				}
			})
		});

		$(document).on('click', '#simpan-essay', function() {
			const jawab_essay = $("#jawab_essay").val();
			const id_soal_esay = $(this).data('id');
			const id_soal = $(this).data('soal');
			$.ajax({
				type: "GET",
				url: "{{ url('/simpan-jawaban-essay') }}",
				data: {
					jawab_essay: jawab_essay,
					id_soal_esay: id_soal_esay,
                    id_soal: id_soal
				},
				success: function(data) {
					console.log(data);
					if (data == 1) {
						$("#notif-essay").html('Jawaban berhasil disimpan.').show();
					}
				}
			})
		});

		$('.no_soal').click(function() {
         
			var $this = $(this);
			var id_soal = $this.attr('data-id');
			var no_urut = $this.attr('data-no');
			var random = $this.attr('data-random');
			var soal = $this.attr('data-soal');
            
			$.ajax({
				type: "GET",
                dataType: "json",
				url: "/get-soal",
                data: {
					id_soal: id_soal,
					no_urut: no_urut,
					random: random,
					soal: soal
				},
				success: function(data) {
                    console.log(data.html);
					$('#wrap-soal').html(data.html);
				}
			})
		});

		// ubah status jawab soal
		$('#kirim').click(function() {
			$('#confirm').html(`
				<pSetelah mengirimkan jawaban, kamu tidak bisa kembali memeriksa jawaban.<p>
  			<button type="button" class="btn" id="batal" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;"><i class="fa fa-ban" aria-hidden="true"></i> Tidak! Saya Mau Cek Lagi.</button>
  			<button type="button" class="btn" id="kirim-jawaban" data-id="{{ $soal->id }}" style="background-image: linear-gradient(to right, #1523f3 , #0495c1); border: none; color: #fff;"><i class="fa fa-check-circle" aria-hidden="true"></i> Iya! Saya Kirim Jawaban Saya Sekarang.</button>
			`).show();
		});

		$(document).on('click', '#batal', function() {
			$('#confirm').hide();
		});

		$(document).on('click', '#kirim-jawaban', function() {
			var $this = $(this);
			var id_soal = $this.attr('data-id');
			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/kirim-jawaban') }}",
				data: {
					id_soal: id_soal
				},
				success: function(data) {
					window.location.href = "{{ url('siswa/ujian/finish/'.$soal->id) }}";
				}
			})
		});

		var jawab = [];
		var detail_soal_id = [];

		$("#start-exam").click(function() {
			$("#specialstuff").show();
		});

		$(document).on('click', ".jawab", function() {
			var $this = $(this);
			var get_jawab = $this.attr('data-jawab');
			var id_soal = $this.attr('data-id');
			var paket_soal = $this.attr('soal-id');
              $('#nav' + id_soal).css({
				"background-color": "#1980d4",
				"color": "#000"
			});
              
			$(".jawab").css({
				"background-color": "#fff",
				"color": "#000",
				"padding": "0",
				"border-radius": "0",
			});
			$this.css({
				"background-color": "#1980d4",
				"color": "#fff",
				"padding": "5px 10px",
				"border-radius": "3px"
			});
            $.ajax({
				type: "GET",
                dataType: "json",
				url: "/penomoran",
				data: {
					'id_soal': paket_soal,
				},
				success: function(data) {
					console.log(data.success);
                    $('#wrap-nomer').html(data.html);
				}
			})
            $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
           });
			$.ajax({
				type: "POST",
                dataType: "json",
				url: "/jawaban",
				data: {
					'get_jawab': get_jawab
				},
				success: function(data) {
					console.log(data.success);
				}
			})

		});
	});
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
@endpush