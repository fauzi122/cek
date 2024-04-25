@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <div class="content-wrapper">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-container">
                    <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
                    <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
                    <!-- Row start -->
                    <div class="row gutte">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card-header badge-info">
                                <h4 class="m-b-0 text-white">Master Soal Ujian</h4>
                            </div>
                            <div class="table-container">
                                <div>
                                    <br><br><br>
                                    <div class="row gutters">
                                        @can('master_soal_ujian.index') 
                                        @foreach ($encryptedExamTypes as $examType => $encryptedValue)
                                        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="info-tiles">
                                                <div class="info-icon">
                                                    <i class="icon-activity"></i>
                                                </div>
                                                <div class="stats-detail">
                                                    <h3><a href="/soal/ujian-baak/{{ $encryptedValue }}">Master Soal {{ ucwords(strtolower($examType)) }}</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <hr>
                                    @endcan

                                    @can('master_soal_ujian.setting_waktu') 
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card-header badge-secondary">
                                            <h4 class="m-b-0 text-white">Setting Waktu</h4>
                                        </div>
                                        
                                        <div class="row gutters">
                                           
                                            <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="info-tiles">
                                                    <div class="info-icon">
                                                        <i class="icon-activity"></i>
                                                    </div>
                                                    <div class="stats-detail">
                                                        <h3><a href="/time-setting">Informasi Master Soal</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="info-tiles">
                                                    <div class="info-icon">
                                                        <i class="icon-filter_frames"></i>
                                                    </div>
                                                    <div class="stats-detail">
                                                        <h3><a href="/time-setting">Setting Waktu Ujian</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
            </div>
            <!-- Row end -->
        </div>
        <!-- Content wrapper end -->
    </div>
@endsection
