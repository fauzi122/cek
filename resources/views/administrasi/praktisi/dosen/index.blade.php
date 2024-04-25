@extends('layouts.dosen.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Data Dosen Praktisi</h4>
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
                                                        <th>NIP</th>
                                                        <th>Kode Dosen</th>
                                                        <th>Nama Dosen</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($jadwal as $no => $jadwal)
                                                        <tr>
                                                            <td>{{ ++$no }}</td>
                                                            <td>{{ $jadwal->nip }}</td>
                                                            <td>{{ $jadwal->kd_dosen }}</td>
                                                            <td>{{ $jadwal->nama }}</td>
                                                            <td class="text-center">
                                                                @php
                                                                    $id = Crypt::encryptString($jadwal->kd_dosen);
                                                                @endphp
                                                                <a href="/show/jadwal/praktisi/{{ $id }}" class="btn btn-sm btn-info">
                                                                    <i class="icon-check" title="lihat absen mhs"></i>
                                                                    Lihat Jadwal
                                                                </a>
                                                            </td>
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
