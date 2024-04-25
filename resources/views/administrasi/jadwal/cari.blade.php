@extends('layouts.dosen.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Jadwal Dosen</h4>
                        </div>
                        <div class="alert-notify-text">Kode Dosen: {{ $kd_dosen }}</div>
                        <div class="alert-notify-text">Kelas: {{ $kd_lokal }}</div>
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
                                                        <th>no_ruang</th>
                                                        <th>mtk</th>
                                                        <th>sks</th>
                                                        <th>Jam</th>
                                                        <th>Hari</th>
                                                        <th scope="col">KD GABUNG</th>
                                                        <th scope="col">KEL PRAKTEK</th>
                                                            @can('jadwal_edit.adm') 
                                                            <th scope="col">Aksi</th>
                                                            @endcan
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($result as $no => $jadwal)
                                                        <tr>
                                                            <td>{{ ++$no }}</td>
                                                            <td>{{ $jadwal->nip }}</td>
                                                            <td>{{ $jadwal->kd_dosen }}</td>
                                                            <td>{{ $jadwal->kd_lokal }}</td>
                                                            <td>{{ $jadwal->no_ruang }}</td>
                                                            <td>{{ $jadwal->nm_mtk }} <b> {{ $jadwal->kd_mtk }}</b></td>
                                                            <td>{{ $jadwal->sks }}</td>
                                                            <td>{{ $jadwal->jam_t }}</td>
                                                            <td>{{ $jadwal->hari_t }}</td>
                                                            <td>{{ $jadwal->kd_gabung }} </td>
                                                            <td>{{ $jadwal->kel_praktek }} </td>
                                                            @php
                    $idComponents = [
                        $jadwal->nip,
                        $jadwal->kd_dosen,
                        $jadwal->kd_lokal,
                        $jadwal->kel_praktek,
                        $jadwal->hari_t,
                        $jadwal->jam_t,
                        $jadwal->no_ruang,
                        $jadwal->kd_mtk,
                        $jadwal->sks,
                        $jadwal->mulai,
                        $jadwal->selesai,
                        $jadwal->selesai_interval,
                        $jadwal->kd_gabung
                    ];

                    $idString = implode(',', $idComponents);
                    $id = Crypt::encryptString($idString);
                @endphp


                    @can('jadwal_edit.adm') 
                    <td>  <a href="/lecturer/schedule/edit/{{ $id }}" class=" btn btn-sm btn-info"> Edit</a> </td>
                    @endcan
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
