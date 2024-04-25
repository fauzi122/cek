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
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
<div class="flash-jam" data-flashjam="{{ session('jam') }}"></div>
	<!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">
          
            @foreach ($jadwal as $jad)
                
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="pricing-plan">
                    <div class="pricing-header">
                        {{-- @php
                          echo $dayList[$day];
                        @endphp --}}
                        <h4 class="pricing-title">{{$jad->nm_mtk}}</h4>
                        <div class="pricing-cost">@if($jad->kd_gabung<>'')
                            <div class="pricing-cost">{{$jad->kd_gabung}}</div>
                            @else
                            <div class="pricing-cost">{{$jad->kd_lokal}}</div>
                            @endif</div>
                        <div class="pricing-save">{{$jad->hari_t}} - {{$jad->jam_t}}</div>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="styled"><i class="icon-user"></i> Kode Dosen : {{$jad->kd_dosen}}</h5>
                        <h5 class="styled"><i class="icon-local_library"></i> Kode MTK : {{$jad->kd_mtk}}</h5>
                        <h5 class="styled"><i class="icon-confirmation_number"></i> SKS : {{$jad->sks}}</h5>
                        <h5 class="styled"><i class="icon-address"></i> No Ruang : {{$jad->no_ruang}}</h5>
                        <h5 class="styled"><i class="icon-home"></i> Kampus : {{$jad->nm_kampus}}</h5>
                        <h5 class="styled @php if ($jad->kel_praktek=='') { echo "text-muted"; }@endphp"><i class="icon-people_outline"></i> Kel Praktek : {{$jad->kel_praktek}}</h5>
                        <h5 class="styled @php if ($jad->kd_gabung=='') { echo "text-muted"; }@endphp"><i class="icon-bookmarks"></i> Kode Gabung : {{$jad->kd_gabung}}</h5>
                    </div>
                    @php
                        if($jad->kd_gabung<>''){
                        @endphp
                        <form action="/pengganti-gabung" method="post">
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
        
                    @php  }elseif($jad->kel_praktek==''){ 
                        @endphp
                        <form action="/pengganti-teori" method="post">
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
                                
                                @php  }else{                                    
                                @endphp
                   
                     <form action="/pengganti-praktek" method="post">
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
                        @php 
                        }
                        @endphp 
                        <button type="submit" class="btn btn-primary btn-lg">Perkuliahan Pengganti</button>
                           
                        </div>
                    </form>

                </div>
            </div>
            
            @endforeach
            
        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->
@endsection