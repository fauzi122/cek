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
                        <a href="{{ Storage::url('public/panduan/Panduan_Panitia_Ujian.pdf') }}" target="_blank" class="btn">
                            <i class="icon-file-text"></i> Panduan Panitia Ujian 
                        </a>
                        <a href="{{ Storage::url('public/panduan/Panduan_Dosen_Pengawas.pdf') }}" target="_blank" class="btn">
                            <i class="icon-filter_frames"></i> Panduan Mengawas Ujian
                        </a>
                        <a href="{{ Storage::url('public/panduan/Panduan_Perizinan_Lokasi_Pada_Web_Ujian_Online.pdf') }}" target="_blank" class="btn">
                            <i class="icon-edit"></i> Panduan Ujian Online Mhs
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
                        <li class="nav-item">
                            <a class="nav-link" id="home1-tab" data-toggle="tab" href="#home1" role="tab" aria-controls="home1" aria-selected="false">
                                <i class="icon-new_releases"></i> Nilai Essay Online Kusus UTS/UAS Pengganti & HER
                            </a>
                        </li>
                    </ul>
                    @php
                    $uts='UTS';
                    $uas='UAS';
                    $uts_ganti='UTS PENGGANTI';
                    $uas_ganti='UAS PENGGANTI';
                    $her='HER';
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
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading"><strong>INFO:</strong> Jika ada Perubahan BAP dan Absen hanya dapat di lakukan sampai tanggal <strong>19 Mei 2024</strong> jam <strong>12:00 WIB</strong></h4>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="home1" role="tabpanel" aria-labelledby="home1-tab">
                            <!-- Konten untuk tab kedua dapat ditambahkan di sini -->
                            <div class="exam-tile">
                                <i class="icon-activity exam-icon"></i>
                                <h3><a href="/nilai-essay-online/{{ $uts_ganti }}" class="exam-link">Nilai Essay Online (UTS) Pengganti</a></h3>
                            </div>
                            <div class="exam-tile">
                                <i class="icon-filter_frames exam-icon"></i>
                                <h3><a href="/nilai-essay-online/{{ $uas_ganti }}" class="exam-link">Nilai Essay Online (UAS) Pengganti</a></h3>
                            </div>

                            <div class="exam-tile">
                                <i class="icon-filter_frames exam-icon"></i>
                                <h3><a href="/nilai-essay-online/{{ $her }}" class="exam-link">Nilai Essay Online (HER)</a></h3>
                            </div>

                            {{-- <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading"><strong>Peringatan:</strong> Informasi penting untuk tab kedua.</h4>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</div>

@endsection
