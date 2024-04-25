@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">

    <!-- Content wrapper start -->
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
                                <h4 class="m-b-0 text-white">Peserta Ujian</h4>
                            </div>

                            <div class="table-container">
                                <!-- Placeholder for additional content, if any -->

                               
                                <div class="row gutters">
                                    @foreach ($encryptedExamTypes as $examType => $encryptedValue)
                                    <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="info-tiles">
                                            <div class="info-icon">
                                                <i class="icon-activity"></i>
                                            </div>
                                            <div class="stats-detail">
                                                <h3><a href="/adm/peserta-ujian/{{ $encryptedValue }}">Peserta {{ ucwords(strtolower($examType)) }}</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach



                                <hr>
                            </div>

                        </div>
                    </div>
                    <!-- Row end -->

                </div>
            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->

</div>

@endsection
