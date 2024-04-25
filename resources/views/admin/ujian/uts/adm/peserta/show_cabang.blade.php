@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">

    <!-- Page header start -->
    <!-- Page header end -->

    <!-- Content wrapper start -->
    <div class="content-wrapper">
        
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card-header badge-success">
                    <h4 class="m-b-0 text-white">Administrasi - Data Kelas UBSI {{ $cabang->nm_kampus }}</h4>
                </div>
            </div>
        </div>
        <!-- Row end -->

        <!-- Tabbed Content -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="nav-tabs-container">

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <br>
                            <div class="table-responsive">
                                <table id="copy-print-csv" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Kelas</th>
                                            <th>Kel-Ujian</th>
                                            <th>Aksi</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas as $no => $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $p->id_kelas }}</td>
                                            <td>{{ $p->no_kel_ujn }}</td>
                                            <td><a href="/adm/lihat-kls-peserta-ujian/{{ $p->id_kelas }}" class="btn btn-xs btn-info">Lihat</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content wrapper end -->

    </div>
@endsection
