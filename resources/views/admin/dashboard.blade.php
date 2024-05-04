@extends('layouts.dosen.main')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f5f7;
        color: #333;
    }
    .main-container {
        padding: 20px;
    }
    .alert {
        background-color: #0056b3;
        color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        margin-bottom: 20px;
    }
    .alert-heading {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .card {
        background-color: #ffffff;
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .card-header {
        background-color: #f8f9fa;
        padding: 16px 24px;
        font-size: 1.25rem;
        font-weight: 500;
        text-align: center;
    }
    .card-body {
        padding: 24px;
        text-align: center;
    }
    .user-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    .user-email {
        color: #555;
        margin-bottom: 24px;
    }
    .btn {
        background-color: #28a745;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        padding: 10px 15px;
        margin-bottom: 10px;
        font-size: 1rem;
        text-decoration: none; /* Remove underline from anchors */
        display: block; /* Make the buttons take the full container width */
        text-align: left;
        transition: background-color 0.3s ease;
    }
    .btn:hover {
        background-color: #218838;
    }
    .btn i {
        margin-right: 8px;
    }
    .exam-tile {
        display: flex;
        margin-bottom: 20px;
        background-color: #e9ecef;
        border-radius: 8px;
        padding: 20px;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }
    .exam-tile:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .exam-icon {
        font-size: 24px;
        margin-right: 15px;
        color: #007bff;
    }
    .exam-link {
        font-size: 18px;
        color: #495057;
        text-decoration: none;
    }
    .exam-link:hover {
        text-decoration: underline;
    }
</style>
<div class="main-container">
    <div class="content-wrapper">
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Selamat Datang</h4>
            <p>Selamat datang di halaman pengawasan ujian, {{ Auth::user()->name }}. Semoga sukses mengawasi ujian yang akan datang.</p>
        </div>
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    
                    <div class="card-body">
                        <h5 class="user-name">{{ Auth::user()->name }}</h5>
                        <h6 class="user-email">{{ Auth::user()->email }}</h6>
                        <a href="{{ Storage::url('public/Panduan MyBest Dosen.pdf') }}" target="_blank" class="btn">
                            <i class="icon-file-text"></i> Panduan Penggunaan
                        </a>
                        <a href="{{ Storage::url('public/PANDUAN_UJIAN_ONLINE DOSEN UBSI.pdf') }}" target="_blank" class="btn">
                            <i class="icon-filter_frames"></i> Panduan Ujian Online
                        </a>
                        <a href="{{ Storage::url('public/Panduan Kuis MyBest Dosen.pdf') }}" target="_blank" class="btn">
                            <i class="icon-edit"></i> Panduan Kuis Online
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="nav-tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <i class="icon-new_releases"></i> Mengawas Ujian
                            </a>
                        </li>
                    </ul>
                    @php
                    $uts='UTS';
                    $uas='UAS';
                    @endphp
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="exam-tile">
                                <i class="icon-activity exam-icon"></i>
                                <h3><a href="/mengawas-uts/{{ $uts }}" class="exam-link">Ujian Tengah Semester (UTS)</a></h3>
                            </div>
                            <div class="exam-tile">
                                <i class="icon-filter_frames exam-icon"></i>
                                <h3><a href="/mengawas-uts/{{ $uas }}" class="exam-link">Ujian Akhir Semester (UAS)</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
