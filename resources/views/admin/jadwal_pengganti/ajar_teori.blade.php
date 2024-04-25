@extends('layouts.dosen.main')
@section('content')
@php
    $tanggal = date('Y-m-d');
    $tgl = date('M d, Y');
    $time=date('H:i:s');
    @endphp
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

<div class="">
    
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        </div>
    </div>
    <!-- Row end -->
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            
            <div class="nav-tabs-container">
                <div class="container">
                    <div class="custom-btn-group">
                        <!-- Buttons -->
                        <button type="button" class="btn btn-info btn-rounded">
                            Jumlah Mahasiswa <span class="badge badge-pill badge-danger">
                               {{$jml_mhs}}
                            </span>
                            <span class="sr-only">Jumlah Mahasiswa</span>
                        </button>
                        <button type="button" class="btn btn-info btn-rounded">
                            Mahasiswa Hadir <span class="badge badge-pill badge-danger">{{$jml_hadir}}</span>
                            <span class="sr-only">Mahasiswa Hadir</span>
                        </button>
                        <button type="button" class="btn btn-info btn-rounded">
                            Mahasiswa Tidak Hadir <span class="badge badge-pill badge-danger">{{$jml_mhs-$jml_hadir}}</span>
                            <span class="sr-only">Mahasiswa Tidak Hadir</span>
                        </button>
                        <ul class="app-actions">
                            <li>
                                <a href="#">
                                    ||
                                    @foreach ($jadwal as $jd)
                                    {{$jd->jam_t}}||{{$jd->kd_lokal}}
                                    @endforeach
                                    ||Pertemuan :    
                                    @foreach ($temu_ajar as $temu)
                                   {{$temu->pertemuan}}
                                    @endforeach || {{$tgl}}||<div id="clock"></div>||
                                    <span class="range-text"></span>
                                </a>
                                
                            </li>
                        </ul>
                    </div>
                
                </div>
                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    {{-- <li class="nav-item">
                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home3" aria-selected="true"><i class="icon-wc"></i>Mahasiswa</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link active" id="mhs-tab3" data-toggle="tab" href="#mhs3" role="tab" aria-controls="mhs3" aria-selected="false"><i class="icon-wc"></i>Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile3" aria-selected="false"><i class="icon-assignment"></i>Pokok Pembahasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact3" aria-selected="false"><i class="icon-log-out"></i>Keluar Mengajar</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent3">
                    
            <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									{{-- <div class="card-title">Textarea</div> --}}
                                </div>
                                <form method="post" action="{{url('/berita-acara-teori')}}" enctype="multipart/form-data">
                                {{-- <form name="form1" id="form1" method="post" action="/berita-acara-teori" enctype="multipart/form-data"> --}}
                                    @csrf
								<div class="card-body">
									<div class="form-group">
										<label for="rangkuman">Rangkuman</label>
                                        <textarea class="form-control @error('rangkuman') is-invalid @enderror" id="rangkuman" rows="3" name="rangkuman">{{ old('rangkuman') }}</textarea>
                                        @error('rangkuman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
										<label for="bap">Berita Acara</label>
                                        <textarea class="form-control @error('bap') is-invalid @enderror" id="bap" rows="3" name="bap">{{ old('bap') }}</textarea>
                                        @error('bap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="label">File Bukti Ajar</label>
                                        <div class="custom-date-input">
                                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                                            <code>File PDF Max 2MB</code>
                                            @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
									
                                </div>
                            <input type="hidden" name="pengganti" value="1">

                                <button type="submit" class="btn btn-success btn-rounded"> Simpan</button>
                                {{-- <button type="submit" class="btn btn-success btn-rounded tombol-hapus"> Simpan</button> --}}
                                <input type="hidden" name="id" value="{{$id}}">
                                <input type="hidden" name="kd_lokal" value="{{$jd->kd_lokal}}">
                            </form>
                            </div>
                            <div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-bordered">
											<thead>
												<tr>
													<th>#</th>
													<th>Rangkuman</th>
													<th>Berita Acara</th>
                                                    <th>Jam Masuk/Keluar</th>
													<th>File</th>
													<th>Pertemuan</th>
													
												</tr>
											</thead>
											<tbody>
                                                @foreach ($berita_acara as $bap)
												<tr>
													<td>{{$loop->iteration}}</td>
													<td>{{$bap->rangkuman}}</td>
													<td>{{$bap->berita_acara}}</td>
                                                    <td>{{$bap->jam_masuk}} - {{$bap->jam_keluar}}</td>
													<td>
                                                        @if (isset($bap->file_ajar))
                                                        <form action="/download-file-ajar" method="post">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$id}}">
                                                            <input type="hidden" name="file" value="{{$bap->file_ajar}}">
                                                            <center><button type="submit" class="btn btn-info btn-rounded"><i class="icon-download"></i> Unduh</button></center>
                                                        </form>  
                                                        @endif
                                                        
                                                    </td>
													<td><span class="badge badge-success">{{$bap->pertemuan}}</span></td>
                                                </tr>
                                                @endforeach
                                               
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
            </div>

            <div class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact-tab3">
                <div class="row gutters justify-content-center">
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                        
                        <!-- Subscribe Form starts -->
                        <div class="subscribe-form">
                            <form action="{{url('/absen-keluar')}}" method="POST">
                                <h4 class="text-center mb-3">!! INFO !!</h4>
                                <p class="text-center mb-3">Anda dapat melakukan absensi keluar mengajar pada jam {{$jd->selesai_interval}} sampai dengan jam {{$jd->selesai}}.</p>
                                <h4 class="text-center mb-3">
                                    @csrf
                                  <input type="hidden" name="id" value="{{$id}}">
                                  @if (isset($absen_keluar->jam_keluar))
                                  <span class="btn btn-success">Sudah Absen Keluar Mengajar</span>
                                  @else
                                  <button type="submit" id="submit" name="submit" class="btn btn-danger">Keluar Mengajar</button>
                                  @endif
                                  
                                </h4>
                            <input type="hidden" name="pengganti" value="1">
                            </form>
                            <!-- Subscribe Form ends -->
                        </div>
    
                    </div>
                </div>
            </div>

            <div class="tab-pane fade show active" id="mhs3" role="tabpanel" aria-labelledby="mhs-tab3">
                @if (!isset($mahasiswa))
                <div class="subscribe-form">
                    <form action="/absen-keluar-praktek" method="POST">
                        <h4 class="text-center mb-3">!! INFO !!</h4>
                        <p class="text-center mb-3">Data mahasiwa tidak tersedia, Harap konfirmasi ke BAAK</p>
                       
                    </form>
                    <!-- Subscribe Form ends -->
                </div>
                @else
                <div class="alert alert-warning" role="alert">
                    <li>Untuk melakukan absen mahasiswa dari sisi dosen silahkan beralih ke halaman <a href="/rekap-absen" class="alert-link">Rekap Absen</a></li>
                </div>
                <div class="row gutters justify-content-center">
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header text-right">
                        <form action="{{url('/absen-mhs-teori')}}" method="post">
                                    @csrf
                                    
                                        {{-- <button type="submit" class="btn btn-danger"><i class="icon-save"></i> Simpan Absen Hadir</button> --}}
                                   
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table projects-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Mahasiswa</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>	
                                                @php
                                                    $count=1;
                                                @endphp
                                                @foreach ($mahasiswa as $nim=>$mhs)											
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    <div class="project-details">
                                                        <div class="avatar sm">
                                                            
                                                        
                                                            {{-- <img src="http://api.bsi.ac.id/v2/index.php/mahasiswa/foto/{{$nim}}" class="circle" alt="No Image"/> --}}
                                                            <img src="{{ Storage::url('public/foto_mhs/default.png') }}" class="circle" alt="Kosong"/>
                                                    </div>
                                                        <div class="project-info">
                                                            <p>{{$mhs}}</p>
                                                            <p>{{$nim}}</p>
                                                        </div>
                                                    </div>
                                                </td>										
                                                
                                                <td>
                                                    <div class="project-details">
                                                        <div class="project-info">
                                                            <div class="status approved">
                                                                <input type="hidden" name="tgl_hadir[{{$count}}]" value="
                                                                @php
                                                                if(isset($mhs_hadir[$nim]->tgl_hadir)){
                                                                   echo $mhs_hadir[$nim]->tgl_hadir;
                                                                 }else{
                                                                   echo "$tanggal";
                                                                 }   
                                                                @endphp
                                                                ">
                                                                <input type="hidden" name="jam_t[{{$count}}]" value="@php
                                                                if(isset($mhs_hadir[$nim]->jam_hadir)){
                                                                   echo $mhs_hadir[$nim]->jam_hadir;
                                                                }else{
                                                                   echo "$time";
                                                                }   
                                                               @endphp">
                                    
                                                                <input type="hidden" name="no_urut[{{$count}}]" value="{{$nim}}"/>
                                                                <div class="card-body">

                                                                    <!-- Radios example -->
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="radio[{{$count}}]" name="nama_radio[{{$count}}]" class="custom-control-input" value="1"@php
                                                                        if(isset($mhs_hadir[$nim]->status_hadir)){
                                                                            echo ' checked="checked"';
                                                                        }
                                                                    @endphp>
                                                                        <label class="custom-control-label" for="radio[{{$count}}]">Hadir</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="radio2[{{$count}}]" name="nama_radio[{{$count}}]" class="custom-control-input" value="0" @php
                                                                        if(!isset($mhs_hadir[$nim]->status_hadir)){
                                                                            echo ' checked="checked"';
                                                                        }
                                                                    @endphp>
                                                                        <label class="custom-control-label" for="radio2[{{$count}}]">Tidak Hadir</label>
                                                                    </div>
                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                            $count++;
                                        @endphp
                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="id_ke" value="1">
                            <input type="hidden" name="id" value="{{$id}}">
                            <input type="hidden" name="temuke" value="{{$temu->pertemuan}}">
                            <input type="hidden" name="kd_mtk" value="{{$jd->kd_mtk}}">
                            <input type="hidden" name="kd_lokal" value="{{$jd->kd_lokal}}">
                
                        </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
                </div>
            </div>

        </div>
    </div>
    <!-- Row end -->

</div>
<script type="text/javascript">
    <!--
    function showTime() {
        var a_p = "";
        var today = new Date();
        var curr_hour = today.getHours();
        var curr_minute = today.getMinutes();
        var curr_second = today.getSeconds();
        if (curr_hour < 12) {
            a_p = "AM";
        } else {
            a_p = "PM";
        }
        if (curr_hour == 0) {
            curr_hour = 12;
        }
        if (curr_hour > 12) {
            curr_hour = curr_hour - 12;
        }
        curr_hour = checkTime(curr_hour);
        curr_minute = checkTime(curr_minute);
        curr_second = checkTime(curr_second);
     document.getElementById('clock').innerHTML=curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
        }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    setInterval(showTime, 500);
    //-->
    </script>

    <!-- Menampilkan Hari, Bulan dan Tahun -->
    <br>
   
@endsection

