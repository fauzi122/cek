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
{{--  <div onclick="window.open('http://elearning.bsi.ac.id/', 'Stackoverflow' , 'type=fullWindow, fullscreen, scrollbars=yes');">
    Hello Stackoverflow!
</div>  --}}

<div class="row gutters justify-content-center">
    <div class="col-xl-7 col-lg-8 col-md-9 col-sm-10 col-12">
        <!-- Subscribe Form starts -->
        <div class="subscribe-form">
                <h4 class="text-center mb-3">Ujian Sedang Berlangsung</h4>
                <p class="text-center mb-4">Klik tombol untuk membuka halaman ujian dalam mode layar penuh</p>
                <div class="text-center">
                        <button class="btn btn-outline-success btn-rounded" onclick = "openFullscreen();" id="start-exam"> Buka Halaman Ujian Dalam Mode Layar Penuh </button>
                </div>
                <p><small><strong> note: </strong>Tekan tombol "Esc" untuk keluar dari layar penuh.</small></p>
                <div class="text-center">
<img src="{{ Storage::url('public/icon/tutor-ujian.gif') }}" height="200" width="550">
</div
            <!-- Subscribe Form ends -->
        </div>

    </div>
</div>
<div id="specialstuff" class="row gutters" style="display: none; overflow-y: scroll !important;" >
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 specialstuff row" width="100%" controls id="myvideo" >
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
                                                                       <center><button type="button" class="no_soal btn btn-primary" data-id="{{ $soals[0]->id }}" data-no="1"data-toggle="modal" data-target=".bd-example-modal-xl">Lanjut Ujian</button></center><br>
                                                                    @else
                                                                        <span class="detail_soal_id" style="display: none;">{{ $data->id }}</span>
                                                                    <div class="soal">1. {!! $data->soal !!}</div>
                                                                    @if (isset($data->url))
                                                                    <a href="{{$data->url}}" target="_blank">
                                                                    <i class="icon-file-text"></i>
                                                                    Open Link 
                                                                    </a>
                                                                    <hr>
                                                                    @endif
                                                                    @if (isset($data->file))
                                                                    @if (substr($data->file,-3)=='mp3')
                                                                    <div class="mb-3">
                                                                        <audio id="audioNotifikasi">
                                                                          <source src="{{ Storage::url('public/soal/'.$soal->file) }}" type="audio/mpeg">
                                                                        </audio>
                                                                        <button id="play" onclick="playAudio()" class="btn btn-primary btn-sm"><i class="icon-controller-play"></i>Play Audio</button>
                                                                        <button id="pause" style="display: none; overflow-y: scroll !important;" onclick="pauseAudio()" class="btn btn-danger btn-sm"><i class="icon-controller-paus"></i>Pause Audio</button> 
                                                                        </div>
                                                                    @else
                                                                    <img src="{{ Storage::url('public/soal/'.$data->file) }}" class="img-thumbnail" height="300" width="300">
                                                                    @endif
                                                                    @endif
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
                                                                
{{--  <button id="next">Next</button>  --}}
	{{-- <a href="/toefl-selesai-ujian/{{$id}}" class="btn pull-left selesai" id="selesai" style="display: none; background-image: linear-gradient(to right, #4cf315 , #04bd20); border: none; color: #fff;">Selesai Ujian</a> --}}
    <a href="/toefl-selesai-ujian/{{ $id }}" class="btn pull-left selesai" id="selesai" style="display: none; background-image: linear-gradient(to right, #4cf315 , #04bd20); border: none; color: #fff;">Selesai Ujian</a>
                                                            {{--  </div>  --}}
                                                            <div class="box-footer">
                                                                <table width="100%">
                                                                    <tr>
                                                                            <hr>
                                                                              {{--  <a href="/toefl-selesai-ujian/{{$id}}" class="btn pull-left" style="background-image: linear-gradient(to right, #4cf315 , #04bd20); border: none; color: #fff;">Selesai Ujian</a>  --}}
                                                                              {{--  <a href="/exercise" class="btn pull-left" style="background-image: linear-gradient(to right, #f31515 , #c12704); border: none; color: #fff;">Keluar</a>  --}}
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
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="card text-center">
										<div class="card-header">
											<div class="card-title">Nomor Soal Pilihan Ganda</div>
										</div>
										<div class="card-body">
											<div class="categories">
                                        <center>
                                        <div id="maxsoal" data-max="{{$soals->count()}}"></div>
                                            @if($soals->count())
                                                @foreach($soals as $key_number=>$data_number)
                                                <span id="no_soal{{$key_number+1}}" class="no_soal badge badge-pill  {{ $data_number->checkJawab == true ? 'badge-primary' : 'badge-light' }}" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}" ><a href="#" id="{{ 'nava'.$data_number->id }}" style="{{ $data_number->checkJawab == true ? 'color:#fff;' : 'color:#000;' }}">{{ $key_number+1 < 10 ? '0':'' }}{{ $key_number+1 }}</a></span>
                                                @endforeach
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
                                                    <span class="no_soal_essay badge {{ $data_number->userJawab == true ? 'badge-primary' : 'badge-light' }}" id="{{ 'nave'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#">{{ $key_number+1 }}</a></span>
                                                @endforeach
                                            @endif
											</div>
										</div>
									</div>
								</div>
                        </div>
                    </div>
                    

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
<style>
span.soal_terpilih{
    background-color:red !important;
}
span.soal_terjawab{
    background-color:#1a8e5f !important;
}</style>
@endsection
@push('scripts')

<script src="{{ url('js/jquery.fullscreen-min.js') }}"></script>
<script src="{{ url('js/toefl-jquery-ujian.js?v=5') }}"></script>
{{--  <script src="{{ url('js/jquery-right.js?v=1') }}"></script>  --}}

<script>
$('.no_soal_essay').click(function() {
    var $this = $(this);
    var id_soal_esay = $this.attr('data-id');
    var no_urut = $this.attr('data-no');
   $.ajax({
        type: "GET",
        dataType: "json",
        url: "/toefl-get-soal_essay",
        data: {
            id_soal_esay: id_soal_esay,
            no_urut: no_urut
        },
        success: function(data) {
            $('#wrap-soal').html(data.html);
        }
    })
});
  $(document).on('click', '#simpan-essay', function() {
    const jawab_essay = $("#jawab_essay").val();
    const id_soal_esay = $(this).data('id');
    const id_soal = $(this).data('soal');
     $('#nave' + id_soal_esay).css({
        "background-color": "#1a8e5f",
        "color": "#fff"
    });
    $.ajax({
        type: "GET",
        url: "{{ url('/toefl-simpan-jawaban-essay') }}",
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
document.onkeydown = function(e) {
    if (e.ctrlKey && 
        (e.keyCode === 67 || 
         e.keyCode === 86 || 
         e.keyCode === 85 || 
         e.keyCode === 117)) {
        
        return false;
    } else {
        return true;
    }
};
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

</script>
@endpush

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Logika untuk menampilkan tombol
        var kondisiUntukMenampilkan = ...; // Sesuaikan kondisi ini
        if (kondisiUntukMenampilkan) {
            document.getElementById('selesai').style.display = 'block';
        }
    });
</script>