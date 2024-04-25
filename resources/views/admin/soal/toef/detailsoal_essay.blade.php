@extends('layouts.dosen.main')

@section('content')
    <!-- Content wrapper start -->
    <div class="content-wrapper">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-body">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <p>
                                                <h4>Review Soal Essay</h4>
                                                <hr>
                                            </p>
                                            <p>
                                                <h5>{{ strip_tags($detailsoal->soal) }}</h5>
                                            </p>
                                            <p>
                                                @if ($detailsoal->file != null)
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        @if (substr($detailsoal->file, -3) == 'mp3')
                                                            <audio controls>
                                                                <source
                                                                    src="{{ Storage::url('public/soalessay/'.$detailsoal->file) }}"
                                                                    type="audio/mpeg">
                                                                Browsermu tidak mendukung tag audio, upgrade donk!
                                                            </audio>
                                                        @else
                                                            <img src="{{ Storage::url('public/soalessay/'.$detailsoal->file) }}"
                                                                class="img-thumbnail" height="300" width="300">
                                                        @endif
                                                    </div>
                                                @else
                                                    {{-- <img src="{{ Storage::url('public/icon/profile.png') }}"
                                                        class="img-thumbnail" height="150" width="200"> --}}
                                                @endif
                                            </p>
                                            <p></p>
                                            <?php
                                                if ($detailsoal->status == 'Y') {
                                                    $status_soal = '<span class="badge badge-pill badge-light">Tampil<span>';
                                                } else {
                                                    $status_soal = '<span class="badge badge-pill badge-secondary">Tidak tampil</span>';
                                                }
                                            ?>
                                            <p>Status soal {!! $status_soal !!}</p>
                                            <hr>
                                            @php
                                                $detail_essay = Crypt::encryptString($detailsoal->id);
                                            @endphp
                                            <a href="/toef-edit-essay/soal/{{ $detail_essay }}"
                                                class="btn btn-success">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="row gutters">
                    <div class="box-body">
                        <div class="alert-notify info">
                            <div class="alert-notify-body">
                                <span class="type">Info</span>
                                <div class="alert-notify-text">
                                    Di halaman ini Anda dapat melihat tampilan soal yang akan dikerjakan oleh siswa.
                                    <p></p>
                                    Silahkan koreksi jika soal yang tampil disamping kurang sesuai dengan yang diharapkan,
                                    Anda dapat melakukan perubahan terhadap soal tersebut.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- Content wrapper end -->
@endsection
