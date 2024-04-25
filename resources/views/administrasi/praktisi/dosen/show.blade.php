@extends('layouts.dosen.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Jadwal Dosen Praktisi</h4>
                        </div>
                        <div class="alert-notify-text"></div>
                        <div class="alert-notify-text"></div>
                        <div class="alert-notify-text"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table id="copy-print-csv" class="table custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Kd_dosen</th>
                                                        <th>kel praktek</th>
                                                        <th>kd_lokal</th>
                                                        <th>hari</th>
                                                        <th>jam</th>
                                                        <th>ruang</th>
                                                        <th>mtk</th>
                                                        <th>sks</th>
                                                        <th>gabung</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($absen as $no => $jadwal)
                                                        <tr>
                                                            <td>{{ ++$no }}</td>
                                                            
                                                            <td><b>{{ $jadwal->kd_dosen }} / {{ $jadwal->kd_dosen2 }}</b></td>
                                                            <td>{{ $jadwal->kel_praktek }}</td>
                                                            <td>{{ $jadwal->kd_lokal }}</td>
                                                            <td>{{ $jadwal->hari_t }}</td>
                                                            <td>{{ $jadwal->jam_t }}</td>
                                                            <td>{{ $jadwal->no_ruang }}</td>
                                                            <td>{{ $jadwal->nm_mtk }} <b>{{ $jadwal->kd_mtk }}</b></td>
                                                            <td>{{ $jadwal->sks }}</td>
                                                            <td>{{ $jadwal->kd_gabung }}</td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <b>Catatan: Terdapat dua dosen, utama dan praktisi</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
