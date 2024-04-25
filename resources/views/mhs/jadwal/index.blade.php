@extends('layouts.mhs.main')
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
<div class="content-wrapper">

    <!-- Row start -->
    <div class="row gutters">
     
        @if ($schedule->count() < 1 )
        @if ($kampus_merdeka->count()>0)
        @foreach ($kampus_merdeka->get() as $jad)
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="pricing-plan">
                <div class="pricing-header @php if ($dayList[$day]<>$jad->hari_t) { echo "secondary"; } @endphp
                    ">
                    <h6 class="pricing-title">{{$jad->nm_mtk}}</h6>

                    <div class="pricing-save">{{$jad->hari_t}} - {{$jad->jam_t}}</div>
                </div>
                <div class="card-body">
                    <h5 class="styled"><i class="icon-user"></i> Kode Dosen : {{$jad->kd_dosen}}</h5>
                    <h5 class="styled"><i class="icon-local_library"></i> Kode MTK : {{$jad->kd_mtk}}</h5>
                    <h5 class="styled"><i class="icon-confirmation_number"></i> SKS : {{$jad->sksajar}}</h5>
                    <h5 class="styled"><i class="icon-address"></i> No Ruang : {{$jad->no_ruang}}</h5>
            
                    <h5 class="styled @php if ($jad->kel_praktek=='') { echo "text-muted"; }@endphp"><i class="icon-people_outline"></i> Kel Praktek : {{$jad->kel_praktek}}</h5>
                    <h5 class="styled @php if ($jad->kd_gabung=='') { echo "text-muted"; }@endphp"><i class="icon-bookmarks"></i> Kode Gabung : {{$jad->kd_gabung}}</h5>
                </div>
                <div class="pricing-footer">
                
                    <div class="btn-group" role="group" aria-label="Basic example">
                    @if($jad->kd_gabung<>'')
                    @php
                        $id=Crypt::encryptString($jad->kd_gabung.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_gabung.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @elseif($jad->kel_praktek=='')
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_lokal.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @else
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);                                    
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kel_praktek.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);                                  
                    @endphp
                    @endif

                        <a href="{{ url('/absen-mhs/'.$jadwal)}}" class="btn btn-primary btn-lg">Masuk Kelas</a>

                        <a href="{{ url('/form-diskusimhs/'.$id)}}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Diskusi">
                            <i class="icon-chat"></i>
                        </a>
                        <a href="{{ url('/learning/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Materi">
                            <i class="icon-archive"></i>
                        </a>
                        <a href="{{ url('/assignment/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Tugas">
                            <i class="icon-archive"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="subscribe-form">
            <form action="/absen-keluar-praktek" method="POST">
            <h4 class="text-center mb-3">!! INFO !!</h4>
            <p class="text-center mb-3">Jadwal Tidak Tersedia, Harap konfirmasi ke BAAK</p>
            
              </form>
                <!-- Subscribe Form ends -->
        </div>
    @endif
        @else
        @foreach ($schedule->get() as $jad)
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="pricing-plan">
                <div class="pricing-header @php if ($dayList[$day]<>$jad->hari_t) { echo "secondary"; } @endphp
                    ">
                    <h6 class="pricing-title">{{$jad->nm_mtk}}</h6>

                    <div class="pricing-save">{{$jad->hari_t}} - {{$jad->jam_t}}</div>
                </div>
                <div class="card-body">
                    <h5 class="styled"><i class="icon-user"></i> Kode Dosen : {{$jad->kd_dosen}}</h5>
                    <h5 class="styled"><i class="icon-local_library"></i> Kode MTK : {{$jad->kd_mtk}}</h5>
                    <h5 class="styled"><i class="icon-confirmation_number"></i> SKS : {{$jad->sksajar}}</h5>
                    <h5 class="styled"><i class="icon-address"></i> No Ruang : {{$jad->no_ruang}}</h5>
            
                    <h5 class="styled @php if ($jad->kel_praktek=='') { echo "text-muted"; }@endphp"><i class="icon-people_outline"></i> Kel Praktek : {{$jad->kel_praktek}}</h5>
                    <h5 class="styled @php if ($jad->kd_gabung=='') { echo "text-muted"; }@endphp"><i class="icon-bookmarks"></i> Kode Gabung : {{$jad->kd_gabung}}</h5>
                </div>
                <div class="pricing-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    @if($jad->kd_gabung<>'')
                    @php
                        $id=Crypt::encryptString($jad->kd_gabung.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_gabung.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @elseif($jad->kel_praktek=='')
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_lokal.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @else
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);                                    
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kel_praktek.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);                                  
                    @endphp
                    @endif

                        <a href="{{ url('/absen-mhs/'.$jadwal)}}" class="btn btn-primary btn-lg">Masuk Kelas</a>

                        <a href="{{ url('/form-diskusimhs/'.$id)}}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Diskusi">
                            <i class="icon-chat"></i>
                        </a>
                        <a href="{{ url('/learning/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Materi">
                            <i class="icon-archive"></i>
                        </a>
                        <a href="{{ url('/assignment/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Tugas">
                            <i class="icon-archive"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @if ($praktek->count()>0)
        @foreach ($praktek->get() as $jad)
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="pricing-plan">
                <div class="pricing-header @php if ($dayList[$day]<>$jad->hari_t) { echo "secondary"; } @endphp
                    ">
                    <h6 class="pricing-title">{{$jad->nm_mtk}}</h6>

                    <div class="pricing-save">{{$jad->hari_t}} - {{$jad->jam_t}}</div>
                </div>
                <div class="card-body">
                    <h5 class="styled"><i class="icon-user"></i> Kode Dosen : {{$jad->kd_dosen}}</h5>
                    <h5 class="styled"><i class="icon-local_library"></i> Kode MTK : {{$jad->kd_mtk}}</h5>
                    <h5 class="styled"><i class="icon-confirmation_number"></i> SKS : {{$jad->sksajar}}</h5>
                    <h5 class="styled"><i class="icon-address"></i> No Ruang : {{$jad->no_ruang}}</h5>
            
                    <h5 class="styled @php if ($jad->kel_praktek=='') { echo "text-muted"; }@endphp"><i class="icon-people_outline"></i> Kel Praktek : {{$jad->kel_praktek}}</h5>
                    <h5 class="styled @php if ($jad->kd_gabung=='') { echo "text-muted"; }@endphp"><i class="icon-bookmarks"></i> Kode Gabung : {{$jad->kd_gabung}}</h5>
                </div>
                <div class="pricing-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    @if($jad->kd_gabung<>'')
                    @php
                        $id=Crypt::encryptString($jad->kd_gabung.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_gabung.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @elseif($jad->kel_praktek=='')
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_lokal.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @else
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);                                    
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kel_praktek.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);                                  
                    @endphp
                    @endif

                        <a href="{{ url('/absen-mhs/'.$jadwal)}}" class="btn btn-primary btn-lg">Masuk Kelas</a>

                        <a href="{{ url('/form-diskusimhs/'.$id)}}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Diskusi">
                            <i class="icon-chat"></i>
                        </a>
                        <a href="{{ url('/learning/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Materi">
                            <i class="icon-archive"></i>
                        </a>
                        <a href="{{ url('/assignment/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Tugas">
                            <i class="icon-archive"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        @if ($kampus_merdeka->count()>0)
        @foreach ($kampus_merdeka->get() as $jad)
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="pricing-plan">
                <div class="pricing-header @php if ($dayList[$day]<>$jad->hari_t) { echo "secondary"; } @endphp
                    ">
                    <h6 class="pricing-title">{{$jad->nm_mtk}}</h6>

                    <div class="pricing-save">{{$jad->hari_t}} - {{$jad->jam_t}}</div>
                </div>
                <div class="card-body">
                    <h5 class="styled"><i class="icon-user"></i> Kode Dosen : {{$jad->kd_dosen}}</h5>
                    <h5 class="styled"><i class="icon-local_library"></i> Kode MTK : {{$jad->kd_mtk}}</h5>
                    <h5 class="styled"><i class="icon-confirmation_number"></i> SKS : {{$jad->sksajar}}</h5>
                    <h5 class="styled"><i class="icon-address"></i> No Ruang : {{$jad->no_ruang}}</h5>
            
                    <h5 class="styled @php if ($jad->kel_praktek=='') { echo "text-muted"; }@endphp"><i class="icon-people_outline"></i> Kel Praktek : {{$jad->kel_praktek}}</h5>
                    <h5 class="styled @php if ($jad->kd_gabung=='') { echo "text-muted"; }@endphp"><i class="icon-bookmarks"></i> Kode Gabung : {{$jad->kd_gabung}}</h5>
                </div>
                <div class="pricing-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    @if($jad->kd_gabung<>'')
                    @php
                        $id=Crypt::encryptString($jad->kd_gabung.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_gabung.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @elseif($jad->kel_praktek=='')
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_lokal.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @else
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);                                    
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kel_praktek.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);                                  
                    @endphp
                    @endif

                        <a href="{{ url('/absen-mhs/'.$jadwal)}}" class="btn btn-primary btn-lg">Masuk Kelas</a>

                        <a href="{{ url('/form-diskusimhs/'.$id)}}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Diskusi">
                            <i class="icon-chat"></i>
                        </a>
                        <a href="{{ url('/learning/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Materi">
                            <i class="icon-archive"></i>
                        </a>
                        <a href="{{ url('/assignment/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Tugas">
                            <i class="icon-archive"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        

        
    </div>
    @endif
    @if ($kampus_merdeka_praktek->count()>0)
        @foreach ($kampus_merdeka_praktek->get() as $jad)
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="pricing-plan">
                <div class="pricing-header @php if ($dayList[$day]<>$jad->hari_t) { echo "secondary"; } @endphp
                    ">
                    <h6 class="pricing-title">{{$jad->nm_mtk}}</h6>

                    <div class="pricing-save">{{$jad->hari_t}} - {{$jad->jam_t}}</div>
                </div>
                <div class="card-body">
                    <h5 class="styled"><i class="icon-user"></i> Kode Dosen : {{$jad->kd_dosen}}</h5>
                    <h5 class="styled"><i class="icon-local_library"></i> Kode MTK : {{$jad->kd_mtk}}</h5>
                    <h5 class="styled"><i class="icon-confirmation_number"></i> SKS : {{$jad->sksajar}}</h5>
                    <h5 class="styled"><i class="icon-address"></i> No Ruang : {{$jad->no_ruang}}</h5>
            
                    <h5 class="styled @php if ($jad->kel_praktek=='') { echo "text-muted"; }@endphp"><i class="icon-people_outline"></i> Kel Praktek : {{$jad->kel_praktek}}</h5>
                    <h5 class="styled @php if ($jad->kd_gabung=='') { echo "text-muted"; }@endphp"><i class="icon-bookmarks"></i> Kode Gabung : {{$jad->kd_gabung}}</h5>
                </div>
                <div class="pricing-footer">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    @if($jad->kd_gabung<>'')
                    @php
                        $id=Crypt::encryptString($jad->kd_gabung.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_gabung.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @elseif($jad->kel_praktek=='')
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kd_lokal.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);
                    @endphp
                    @else
                    @php
                        $id=Crypt::encryptString($jad->kd_lokal.','.$jad->kd_mtk);                                    
                        $jadwal=Crypt::encryptString($jad->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $jad->nm_mtk).','.$jad->kd_dosen.','.$jad->sksajar.','.$jad->kel_praktek.','.$jad->hari_t.','.$jad->jam_t.','.$jad->no_ruang);                                  
                    @endphp
                    @endif

                        <a href="{{ url('/absen-mhs/'.$jadwal)}}" class="btn btn-primary btn-lg">Masuk Kelas</a>

                        <a href="{{ url('/form-diskusimhs/'.$id)}}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Diskusi">
                            <i class="icon-chat"></i>
                        </a>
                        <a href="{{ url('/learning/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Materi">
                            <i class="icon-archive"></i>
                        </a>
                        <a href="{{ url('/assignment/'.$id) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Ruang Tugas">
                            <i class="icon-archive"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    <!-- Row end -->
 
</div>
@endsection