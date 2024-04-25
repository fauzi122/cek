
@extends('layouts.dosen.main')

@section('content')

<div class="main-container">
    <div class="table-container"> 
        <div class="t-header">
            <a href="" class="" style="padding-top: 10px;"><i class="icon-documents"> </i>Rekap Pengajaran Dosen
                </a>
        </div>
  <div class="card-body">
    <h2>{{ Auth::user()->username }} - {{ Auth::user()->name }}</h2>
    <p></p>
    <div class="row gutters">
        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="info-tiles">
                <div class="info-icon">
                    <i class="icon-activity"></i>
                </div>
                <div class="stats-detail">
                    <h3><a href="/lecturer/t/rekap"> Rekap Ajar Teori</a></h3>
                  
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="info-tiles">
                <div class="info-icon">
                    <i class="icon-filter_frames"></i>
                </div>
                <div class="stats-detail">
                    <h3><a href="/lecturer/p/rekap">Rekap Ajar Praktek</a></h3>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
            <div class="info-tiles">
                <div class="info-icon">
                    <i class="icon-filter"></i>
                </div>
                <div class="stats-detail">
                    <h3><a href="/lecturer/praktisi/rekap">Rekap Ajar Praktisi</a></h3>
                    
                </div>
            </div>
        </div>
</div>

@endsection

    