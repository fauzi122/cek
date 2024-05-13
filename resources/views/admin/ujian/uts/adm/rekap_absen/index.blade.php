@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="m-b-0">Data Ujian</h4>
                    </div>
                    <div class="container p-4">
                        {{-- Form pencarian --}}
                        <form action="" method="GET" class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="tgl_ujian">Tanggal Ujian:</label>
                                    <input type="date" class="form-control" name="tgl_ujian" id="tgl_ujian" value="{{ request()->tgl_ujian }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bermasalah">Status Masalah:</label>
                                    <select class="form-control" name="bermasalah" id="bermasalah">
                                        <option value="">Semua Status</option>
                                        <option value="1" @if(request()->bermasalah == '1') selected @endif>Bermasalah</option>
                                        <option value="0" @if(request()->bermasalah == '0') selected @endif>Tidak Bermasalah</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nm_kampus">Cabang:</label>
                                    <select class="form-control" name="nm_kampus" id="nm_kampus">
                                        <option value="">Semua Cabang</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->nm_kampus }}" @if(request()->nm_kampus == $cabang->nm_kampus) selected @endif>{{ $cabang->nm_kampus }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>

                        {{-- Tabel data yang lebih lebar --}}
                        <div class="table-responsive">
                            <table class="table custom-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Status</th>
                                        <th>Paket Absen</th>
                                        <th>Kode Dosen Absen</th>
                                        <th>Kode Lokal</th>
                                        <th>Kode Jurusan</th>
                                        <th>Kode Cabang</th>
                                        <th>No Kelompok Ujian</th>
                                        <th>Hari Ujian</th>
                                        <th>No Ruang</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>Kode Mata Kuliah</th>
                                        <th>Jam Ujian</th>
                                        <th>Nama Kampus</th>
                                        <th>Paket</th>
                                        <th>Tanggal Ujian</th>
                                        <th>Kode Mata Kuliah Absen</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($result as $data)
                                    <tr>
                                        <td>{{ $data->nim }}</td>
                                        <td>{{ $data->nm_mhs }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>{{ $data->paket_absen }}</td>
                                        <td>{{ $data->kd_dosen_absen }}</td>
                                        <td>{{ $data->kd_lokal }}</td>
                                        <td>{{ $data->kd_jurusan }}</td>
                                        <td>{{ $data->kd_cabang }}</td>
                                        <td>{{ $data->no_kel_ujn }}</td>
                                        <td>{{ $data->hari_t }}</td>
                                        <td>{{ $data->no_ruang }}</td>
                                        <td>{{ $data->nm_mtk }}</td>
                                        <td>{{ $data->kd_mtk }}</td>
                                        <td>{{ $data->jam_t }}</td>
                                        <td>{{ $data->nm_kampus }}</td>
                                        <td>{{ $data->paket }}</td>
                                        <td>{{ $data->tgl_ujian }}</td>
                                        <td>{{ $data->kd_mtk_absen }}</td>
                                        <td>{{ $data->ket }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: center">
                                {{$result->links("vendor.pagination.bootstrap-4")}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
