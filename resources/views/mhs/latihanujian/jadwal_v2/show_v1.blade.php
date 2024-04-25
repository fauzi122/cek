@extends('layouts.mhs.main')
@section('content')
 @php
$id=Crypt::encryptString($soal->id.','.$soal->kd_mtk);
date_default_timezone_set("Asia/Jakarta"); 
$o_skrg = new DateTime();
$o_batas = new DateTime(date('Y-m-d H:i:s', STRTOTIME($hasil_ujian->akhir_ujian)));
$o_sisa = $o_skrg->diff($o_batas);
$sisa_waktu = $o_sisa->format('%R') == '-' ? '00:00:01' : $o_sisa->format('%H:%I:%S');  
//$jawab_siswa = $soals->checkJawab[0];                          
@endphp

<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="modal-body">
                        <div class="row gutters">
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                   <i class="icon-watch_later"></i>
                                    <div>
                                       <h5 align="right">Sisa waktu :&nbsp;<span class="kkcount-down"><?php echo $sisa_waktu;?></span></h5>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="invoice-container">
                                            <div class="invoice-body">
                                                <!-- Row start -->
                                                <div class="row gutters">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        {{--  <div class="box box-primary color-palette-box" style="overflow-y: scroll;">  --}}
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
                                                                    
                                                                    @if ($data->checkJawab)
                                                                       <center><button type="button" class="no_soal btn btn-primary" data-id="{{ $soals[0]->id }}" data-toggle="modal" data-target=".bd-example-modal-xl">Lanjut Ujian</button></center><br>
                                                                    @else
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
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
                                        <div class="invoice-status">
                                            <i class="icon-check_circle"></i>
                                            <h3 class="status text-success">Navigasi Soal</h3>
                                            <div class="box box-success color-palette-box">
                                                
                                                <div class="box-body">
                                                  <hr>
                                                    @if($soals->count())
                                                    <span><b>Nomor Soal Pilihan Ganda</b></span>
                                                    <p></p>
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination">
                                                     
                                                            @foreach($soals as $key_number=>$data_number)
                                                            <li class="no_soal badge badge-pill  {{ $data_number->checkJawab == true ? 'badge-primary' : 'badge-light' }}" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#">{{ $key_number+1 }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </nav>
                                                    @endif
                                                    <hr>
                                                    @if($soal->detail_soal_essays->count())
                                                    <span><b> Nomor Soal Essay</b></span>
                                                    <p></p>
                                                  
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination" style="margin-top: 5px !important;">
                                                            @foreach($soal->detail_soal_essays as $key_number => $data_number)
                                                            <li class="badge badge-pill badge-light" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#">{{ $key_number+1 }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </nav>
                                                    @endif
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-4">
                                        <div class="invoice-status">
                                            <i class="icon-watch_later"></i>
                                            <h3 class="status text-info">Aktifitas Terkini</h3>
                                            <div class="card-body">
                                                <div class="customScroll5">
                                                    <ul class="project-activity">
                        
                                                        <li class="activity-list">
                                                            <div class="detail-info">
                                                                <p class="date">Today</p>
                                                                <p class="info">Messages accepted with attachments.</p>
                                                            </div>
                                                        </li>
                                                     </ul>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                    {{--  <button class="btn btn-primary btn-lg btn-block" id="start-exam" onclick="$('#specialstuff').fullScreen(true)">Mulai Mengerjakan Soal!</button>  --}}
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

		$(document).on('click', '.no_soal_essay', function() {
			const id_soal_esay = $(this).data('id');
			$.ajax({
				url: "{{ url('siswa/ujian/get-detail-essay') }}",
				type: "GET",
				data: {
					id_soal_esay: id_soal_esay
				},
				success: function(data) {
					$("#wrap-soal").html(data);
				}
			});
		});

		$(document).on('click', '#simpan-essay', function() {
			const jawab_essay = $("#jawab_essay").val();
			const id_soal_esay = $(this).data('id');
			$.ajax({
				type: "GET",
				url: "{{ url('siswa/ujian/simpan-jawaban-essay') }}",
				data: {
					jawab_essay: jawab_essay,
					id_soal_esay: id_soal_esay
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
			$('#wrap-soal').html('<center><i class="fa fa-spinner fa-spin" style="font-size: 30pt; color: #12b9cc; margin: 15px;" aria-hidden="true"></i></center>');
			$('#no_soal_detail').html($this.attr('data-no'));
			var id_soal = $this.attr('data-id');
			$.ajax({
				type: "GET",
                dataType: "json",
				url: "/get-soal/" + id_soal,
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
			$('#nav' + id_soal).find('a').css({
				"background-color": "#1980d4",
				"color": "#fff"
			});
		 //console.log(id_soal);
			$(".jawab").css({
				"background-color": "#fff",
				"color": "#000",
				"padding": "0",
				"border-radius": "0"
			});
			$this.css({
				"background-color": "#1980d4",
				"color": "#fff",
				"padding": "5px 10px",
				"border-radius": "3px"
			});
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

    var interval = setInterval(function() {
			var timer = $('.kkcount-down').html();
			timer = timer.split(':');
			var hours = parseInt(timer[0], 10);
			var minutes = parseInt(timer[1], 10);
			var seconds = parseInt(timer[2], 10);
			seconds -= 1;
			if (hours < 0) return clearInterval(interval);	
			if (seconds < 0 && minutes == 0 && hours != 0) {
				hours -= 1;
				minutes = 59;
				seconds = 59;
			}
			if (seconds < 0 && minutes != 0) {
				minutes -= 1;
				seconds = 59;
			}
			if (hours < 10 && length.hours != 2) hours = '0' + hours;
			if (minutes < 10 && length.minutes != 2) minutes = '0' + minutes;
			if (seconds < 10 && length.seconds != 2) seconds = '0' + seconds;
			$('.kkcount-down').html(hours + ':' + minutes + ':' + seconds);
			
			if (hours == 0 && minutes == 0 && seconds == 0) { clearInterval(interval); alert('Waktu Ujian Anda Habis'); location.reload(); }
		}, 1000);
</script>
@endpush