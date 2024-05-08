@extends('layouts.dosen.ujian.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Hasil Pencarian Data</h4>
                        </div>
                       
                        
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
                                                        <th>NIM</th>
                                                        <th>NAMA</th>
                                                        <th>KELAS</th>
                                                        <th>KEL - UJIAN</th>
                                                        <th>paket</th>
                                                        <th>kd_MTK</th>
                                                        <th>MTK</th>

                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hasil as $no => $hasil)
                                                        <tr>
                                                            <td>{{ ++$no }}</td>
                                                            <td>{{ $hasil->nim }}</td>
                                                            <td>{{ $hasil->nm_mhs }}</td>
                                                            <td>{{ $hasil->id_kelas }}</td>
                                                            <td>{{ $hasil->no_kel_ujn }}</td>
                                                            <td>{{ $hasil->paket }}</td>
                                                            <td>{{ $hasil->kd_mtk }}</td>
                                                            <td>{{ $hasil->nm_mtk }}</td>
                                                           
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
