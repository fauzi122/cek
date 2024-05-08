@extends('layouts.dosen.ujian.main')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<div class="main-container">
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card-header badge-info">
                    <h4 class="m-b-0 text-white">Edit Jadwal Ujian - {{ $jadwal->paket }}</h4>
                </div>
               
                <div class="row">
                    <div class="col-md-6">
                        <!-- Tabel Informasi Jadwal -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="3">Informasi Jadwal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dosen</td>
                                        <td>{{ $jadwal->nip }} - <b>{{ $jadwal->kd_dosen }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Kode Lokal</td>
                                        <td>{{ $jadwal->kd_lokal }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelompok Ujian</td>
                                        <td>{{ $jadwal->kel_ujian }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Ujian</td>
                                        <td>{{ $jadwal->tgl_ujian }}</td>
                                    </tr>
                                    <tr>
                                        <td>No Ruang</td>
                                        <td>{{ $jadwal->no_ruang }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mata Kuliah</td>
                                        <td>{{ $jadwal->nm_mtk }} - <b>{{ $jadwal->kd_mtk }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Mulai</td>
                                        <td>{{ $jadwal->mulai }}</td>
                                    </tr>
                                    <tr>
                                        <td>Selesai</td>
                                        <td>{{ $jadwal->selesai }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Kampus</td>
                                        <td>{{ $jadwal->nm_kampus }}</td>
                                    </tr>
                                    <tr>
                                        <td>Paket</td>
                                        <td>{{ $jadwal->paket }}</td>
                                    </tr>
                                    <tr>
                                        <td>Waktu</td>
                                        <td>{{ $jadwal->waktu }} menit</td>
                                    </tr>

                                    <tr>
                                        <td>Petugas</td>
                                        <td>
                                            @if (!empty($jadwal->petugas_edit))
                                            {{ $jadwal->petugas_edit }}
                                        @endif
                                        @if (session('success'))
                                        <div class="alert alert-info">
                                            {{ session('success') }}
                                        </div>
                                        @endif
                        
                                        @if (session('error'))
                                        <div class="alert alert-info">
                                            {{ session('error') }}
                                        </div>
                                        @endif
                                            </td>
                                           
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Tabel Form Dosen Pengganti -->
                    <div class="col-md-6">
                        <form method="POST" action="/update/jadwal-ujian"> <!-- Sesuaikan action -->
                            @csrf
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2">Form Edit Jadwal Ujian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kode Dosen Asli</td>
                                            <td><input type="text" class="form-control" name="kd_dosen" value="{{ old('kd_dosen', $jadwal->kd_dosen) }}" required readonly></td>
                                        </tr>
                                        
                                        </tr>
                                        <tr>
                                            <td>NIP/td>
                                            <td><input type="text" class="form-control" name="nip" value="{{ old('nip', $jadwal->nip) }}" required readonly></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Kelompok Ujian</td>
                                            <td><input type="text" class="form-control" name="kel_ujian" value="{{ old('kel_ujian', $jadwal->kel_ujian) }}" required readonly></td>
                                        </tr>
                                        <tr>
                                            <td>Kode Mata Kuliah</td>
                                            <td><input type="text" class="form-control" name="kd_mtk" value="{{ old('kd_mtk', $jadwal->kd_mtk) }}" required readonly></td>
                                        </tr>
                                        <tr>
                                            <td>Paket</td>
                                            <td><input type of="text" class="form-control" name="paket" value="{{ old('paket', $jadwal->paket) }}" required readonly></td>
                                        </tr>

                                        <tr>
                                            <td>Tgl Ujian</td>
                                            <td><input type of="text" class="form-control" name="tgl_ujian" value="{{ old('tgl_ujian', $jadwal->tgl_ujian) }}" required></td>
                                        </tr>
                                        <tr>
                                            <td>Jam_t</td>
                                            <td><input type of="text" class="form-control" name="jam_t" value="{{ old('jam_t', $jadwal->jam_t) }}" required></td>
                                        </tr>
                                        <tr>
                                            <td>Hari</td>
                                            <td><input type of="text" class="form-control" name="hari_t" value="{{ old('hari_t', $jadwal->hari_t) }}" required></td>
                                        </tr>
                                        <tr>
                                            <td>Ruangan</td>
                                            <td><input type of="text" class="form-control" name="no_ruang" value="{{ old('no_ruang', $jadwal->no_ruang) }}" required></td>
                                        </tr>
                                        <tr>
                                            <td>Mulai</td>
                                            <td><input type of="text" class="form-control" name="mulai" value="{{ old('mulai', $jadwal->mulai) }}" required></td>
                                        </tr>
                                        <tr>
                                            <td>Selsai</td>
                                            <td><input type of="text" class="form-control" name="selesai" value="{{ old('selesai', $jadwal->selesai) }}" required></td>
                                        </tr>
                                       
                                        <tr>
                                            <td colspan="2">
                                                <button type="submit" class="btn btn-primary">Update Data</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    

@endsection
