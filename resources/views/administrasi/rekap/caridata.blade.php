@extends('layouts.dosen.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Rekap Dosen Teori</h4>
                        </div>
                        <div class="alert-notify-text">Tanggal Awal: {{ $tgl_awal }}</div>
                        <div class="alert-notify-text">Tanggal Akhir: {{ $tgl_akhir }}</div>
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
                                                        <th>NIP</th>
                                                        <th>Kd_dosen</th>
                                                        <th>kd_lokal</th>
                                                        <th>No_Ruang</th>
                                                        <th>jam_masuk</th>
                                                        <th>jam_keluar</th>
                                                        <th>Tanggal</th>
                                                        <th>mtk</th>
                                                        <th>sks</th>
                                                        <th>temu</th>
                                                        <th>sts</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rekapData as $no => $jadwal)
                                                        <tr>
                                                            <td>{{ ++$no }}</td>
                                                            <td>{{ $jadwal->nip }}</td>
                                                            <td>{{ $jadwal->kd_dosen }}</td>
                                                            <td>{{ $jadwal->kd_lokal }}</td>
                                                            <td>{{ $jadwal->no_ruang }}</td>
                                                            <td>{{ $jadwal->jam_masuk }}</td>
                                                            <td>{{ $jadwal->jam_keluar }}</td>
                                                            <td>{{ $jadwal->tgl_ajar_masuk }}</td>
                                                            <td>{{ $jadwal->nm_mtk }}</td>
                                                            <td>{{ $jadwal->sks }}</td>
                                                            <td>{{ $jadwal->pertemuan }}</td>
                                                            <td>{{ $jadwal->sts_ajar }}</td>
                                                           
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
                </div>
            </div>
        </div>
    </div>
@endsection
