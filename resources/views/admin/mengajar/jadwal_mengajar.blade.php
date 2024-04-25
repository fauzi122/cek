@extends('layouts.dosen.main')
@section('content')
@php
$tanggal = date('Y-m-d');
$day = date('D', strtotime($tanggal));
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);
$time=date('H:i');
// dd($time);
@endphp
<div class="flash-jam" data-flashjam="{{ session('jam') }}"></div>
<div class="flash-jam" data-flashjam="{{ session('status') }}"></div>
	<!-- Content wrapper start -->
    <div class="content-wrapper">
        <!-- Row start -->
        <div class="row gutters">
          
            @foreach ($jadwal as $jad)
                
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="pricing-plan">
                    <div class="pricing-header @php if ($dayList[$day]<>$jad->hari_t) { echo "secondary"; } @endphp
                    ">
                        {{-- @php
                          echo $dayList[$day];
                        @endphp --}}
                        <h4 class="pricing-title">{{$jad->nm_mtk}}</h4>
                        @if($jad->kd_gabung<>'')
                        <div class="pricing-cost">{{$jad->kd_gabung}}</div>
                        @else
                        <div class="pricing-cost">{{$jad->kd_lokal}}</div>
                        @endif
                        <div class="pricing-save">{{$jad->hari_t}} - {{$jad->jam_t}}</div>
                    </div>
                    
                    <div class="card-body">
                   
                        <h5 class="styled"><i class="icon-user"></i> Kode Dosen : {{$jad->kd_dosen2!=null?$jad->kd_dosen.'/'.$jad->kd_dosen2:$jad->kd_dosen}}</h5>
                        <h5 class="styled"><i class="icon-local_library"></i> Kode MTK : {{$jad->kd_mtk}}</h5>
                        <h5 class="styled"><i class="icon-confirmation_number"></i> SKS : {{$jad->sks}}</h5>
                        <h5 class="styled"><i class="icon-address"></i> No Ruang : {{$jad->no_ruang}}</h5>
                        <h5 class="styled"><i class="icon-home"></i> Kampus : {{$jad->nm_kampus}}</h5>
                        <h5 class="styled @php if ($jad->kel_praktek=='') { echo "text-muted"; }@endphp"><i class="icon-people_outline"></i> Kel Praktek : {{$jad->kel_praktek}}</h5>
                        <h5 class="styled @php if ($jad->kd_gabung=='') { echo "text-muted"; }@endphp"><i class="icon-bookmarks"></i> Kode Gabung : {{$jad->kd_gabung}}</h5>
                    </div>
                        @if($jad->kd_gabung != '')
                        
                @php
                    $id = Crypt::encryptString($jad->kd_gabung != '' ? $jad->kd_gabung.','.$jad->kd_mtk.','.$jad->nip : $jad->kd_lokal.','.$jad->kd_mtk.','.$jad->nip);
                @endphp
                        <form action="/create-gabung" method="post">
                        @csrf
                        <input type="hidden" name="kd_mtk" value="{{$jad->kd_mtk}}">
                        <input type="hidden" name="nm_mtk" value="{{$jad->nm_mtk}}">
                        <input type="hidden" name="kd_dosen" value="{{$jad->kd_dosen}}">
                        <input type="hidden" name="sks" value="{{$jad->sksajar}}">
                        <input type="hidden" name="kd_lokal" value="{{$jad->kd_gabung}}">
                        <input type="hidden" name="hari_t" value="{{$jad->hari_t}}">
                        <input type="hidden" name="jam_t" value="{{$jad->jam_t}}">
                        <input type="hidden" name="no_ruang" value="{{$jad->no_ruang}}">
                        <div class="pricing-footer">
        
                    @elseif($jad->kel_praktek=='')
                        @php
                    $id = Crypt::encryptString($jad->kd_gabung != '' ? $jad->kd_gabung.','.$jad->kd_mtk.','.$jad->nip : $jad->kd_lokal.','.$jad->kd_mtk.','.$jad->nip);

                        // $id=Crypt::encryptString($jad->kd_lokal!= '' ?$jad->kd_mtk.','.$jad->nip);
                        @endphp
                        <form action="/create-teori" method="post">
                            @csrf
                            <input type="hidden" name="kd_mtk" value="{{$jad->kd_mtk}}">
                            <input type="hidden" name="nm_mtk" value="{{$jad->nm_mtk}}">
                            <input type="hidden" name="kd_dosen" value="{{$jad->kd_dosen}}">
                            <input type="hidden" name="sks" value="{{$jad->sksajar}}">
                            <input type="hidden" name="kd_lokal" value="{{$jad->kd_lokal}}">
                            <input type="hidden" name="hari_t" value="{{$jad->hari_t}}">
                            <input type="hidden" name="jam_t" value="{{$jad->jam_t}}">
                            <input type="hidden" name="no_ruang" value="{{$jad->no_ruang}}">
                            <input type="hidden" name="mulai" value="{{$jad->mulai}}">
                            <input type="hidden" name="selesai" value="{{$jad->selesai}}">
                            <div class="pricing-footer">
                                
                         @else
                        @php
                            $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk.','.$jad->nip);                                    
                        @endphp
                   
                     <form action="/create-praktek" method="post">
                        @csrf
                        <input type="hidden" name="kd_mtk" value="{{$jad->kd_mtk}}">
                        <input type="hidden" name="nm_mtk" value="{{$jad->nm_mtk}}">
                        <input type="hidden" name="kd_dosen" value="{{$jad->kd_dosen}}">
                        <input type="hidden" name="sks" value="{{$jad->sksajar}}">
                        <input type="hidden" name="kel_praktek" value="{{$jad->kel_praktek}}">
                        <input type="hidden" name="hari_t" value="{{$jad->hari_t}}">
                        <input type="hidden" name="jam_t" value="{{$jad->jam_t}}">
                        <input type="hidden" name="no_ruang" value="{{$jad->no_ruang}}">
                        <div class="pricing-footer">
                    @endif    
                            
                    <div class="btn-group mt-2" role="group" aria-label="Basic example">
                     @php 
                        $ip = $ip ?? json_decode('{"kd_cabang":""}');
                         @endphp
                        @if ($dayList[$day]==$jad->hari_t)
                        @if ($jad->kd_dosen2 != null && $jad->kd_dosen != Auth::user()->kode)
                        <a href="#absen_praktisi" data-toggle="modal" data-nama="file_pensiun" data-kd_mtk="{{ $jad->kd_mtk }}" data-nm_mtk="{{ $jad->nm_mtk }}" data-kd_dosen="{{ $jad->kd_dosen }}" data-sks="{{ $jad->sksajar }}" data-kd_lokal="{{ $jad->kd_gabung != '' ? $jad->kd_gabung : ($jad->kel_praktek == '' ? $jad->kd_lokal : $jad->kel_praktek) }}" data-hari_t="{{ $jad->hari_t }}" data-jam_t="{{ $jad->jam_t }}" data-no_ruang="{{ $jad->no_ruang }}" data-kelas="{{ $jad->kd_gabung != '' ? 'gabung' : ($jad->kel_praktek == '' ? 'teori' : 'praktek') }}" class="btn btn-primary">Absen Masuk</a>
                    @elseif(in_array(substr($jad->no_ruang, 0, 2), ['EL', 'EN', 'ET', 'EX']) || substr($jad->no_ruang, -2) == $ip->kd_cabang)
                        <button type='submit' class='btn btn-primary left'>Masuk Kelas</button>
                    @else
                        <span class="badge badge-secondary mt-1">Diluar Jaringan Kampus ({{ $ipclient }})</span>
                    @endif
                        @endif
                            
                            <a href="{{ url('/form-diskusi/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Diskusi">
                                <i class="icon-chat"></i>
                               
                            </a>
                            <a href="{{ url('/materi/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Materi">
                                <i class="icon-archive"></i>
                            </a>
                            <a href="{{ url('/tugas/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Tugas">
                                <i class="icon-card_travel"></i>
                                
                            </a>
                             {{--  <a href="{{ url('/grup-wa/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Whatsapp ">
                                <i class="icon-share"></i>
                                
                            </a>  --}}
                        </div>
                           
                        </div>
                    </form>

                </div>
            </div>
           
            @endforeach
            
        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->
    	<div class="modal fade" id="absen_praktisi" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customModalTwoLabel">Form Absen Dosen Praktisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/absen_praktisi" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
										<label for="rangkuman">Rangkuman*</label>
                                        <textarea class="form-control @error('rangkuman') is-invalid @enderror" id="rangkuman" rows="3" name="rangkuman">{{ old('rangkuman') }}</textarea>
                                        @error('rangkuman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
										<label for="bap">Berita Acara*</label>
                                        <textarea class="form-control @error('bap') is-invalid @enderror" id="bap" rows="3" name="bap">{{ old('bap') }}</textarea>
                                        @error('bap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="label">Bukti Foto Kondisi Pemblajaran*</label>
                                        <div class="custom-date-input">
                                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                                            <h5><code>File PDF,JPG,JPEG,DOC,DOCX Max 2MB</code></h5>
                                            @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                        <input type="hidden" name="kd_mtk" value="">
                        <input type="hidden" name="nm_mtk" value="">
                        <input type="hidden" name="kd_dosen" value="">
                        <input type="hidden" name="sks" value="">
                        <input type="hidden" name="kd_lokal" value="">
                        <input type="hidden" name="hari_t" value="">
                        <input type="hidden" name="jam_t" value="">
                        <input type="hidden" name="no_ruang" value="">
                        <input type="hidden" name="kelas" value="">
									
                    </div>
                    <div class="modal-footer custom">
                        
                        <div class="left-side">
                            <button type="button" class="btn btn-link danger" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="divider"></div>
                        <div class="right-side">
                            <button type="submit" class="btn btn-link success">Send Message</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
@push('scripts')
<script>
    $('#absen_praktisi').on('show.bs.modal', function(e) {
        if (e.namespace === 'bs.modal') {
            var kd_mtk = $(e.relatedTarget).data('kd_mtk');
            var nm_mtk = $(e.relatedTarget).data('nm_mtk');
            var kd_dosen = $(e.relatedTarget).data('kd_dosen');
            var sks = $(e.relatedTarget).data('sks');
            var kd_lokal = $(e.relatedTarget).data('kd_lokal');
            var hari_t = $(e.relatedTarget).data('hari_t');
            var jam_t = $(e.relatedTarget).data('jam_t');
            var no_ruang = $(e.relatedTarget).data('no_ruang');
            var kelas = $(e.relatedTarget).data('kelas');
            $(e.currentTarget).find('input[name="kd_mtk"]').val(kd_mtk);
            $(e.currentTarget).find('input[name="nm_mtk"]').val(nm_mtk);
            $(e.currentTarget).find('input[name="kd_dosen"]').val(kd_dosen);
            $(e.currentTarget).find('input[name="sks"]').val(sks);
            $(e.currentTarget).find('input[name="kd_lokal"]').val(kd_lokal);
            $(e.currentTarget).find('input[name="hari_t"]').val(hari_t);
            $(e.currentTarget).find('input[name="jam_t"]').val(jam_t);
            $(e.currentTarget).find('input[name="no_ruang"]').val(no_ruang);
            $(e.currentTarget).find('input[name="kelas"]').val(kelas);
        }
    });
</script>
@endpush
@endsection