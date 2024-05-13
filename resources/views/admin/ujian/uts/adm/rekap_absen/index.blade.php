@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="m-b-0">Download Absen Ujian</h4>
                    </div>
                    <div class="container p-4">
                        {{-- Form pencarian --}}
                        <form action="{{ route('export.excel') }}" method="GET" class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="bermasalah">Status Masalah:</label>
                                    <select class="form-control" name="paket">
                                        
                                        <option value="UTS">UTS</option>
                                        <option value="UAS">UAS</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="tgl_ujian">Tanggal Ujian:</label>
                                    <select class="form-control" name="tgl_ujian" id="tgl_ujian">
                                        <option value="">--Pilih Tanggal--</option>
                                        @foreach ($tgl as $date)
                                            <option value="{{ $date->tgl_ujian }}" {{ request()->tgl_ujian == $date->tgl_ujian ? 'selected' : '' }}>{{ $date->tgl_ujian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="bermasalah">Status Masalah:</label>
                                    <select class="form-control" name="bermasalah" id="bermasalah">
                                        <option value="">Semua Status</option>
                                        <option value="1" {{ request()->bermasalah == '1' ? 'selected' : '' }}>Bermasalah</option>
                                        <option value="0" {{ request()->bermasalah == '0' ? 'selected' : '' }}>Tidak Bermasalah</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nm_kampus">Cabang:</label>
                                    <select class="form-control" name="nm_kampus" id="nm_kampus">
                                        <option value="">Semua Cabang</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->nm_kampus }}" {{ request()->nm_kampus == $cabang->nm_kampus ? 'selected' : '' }}>{{ $cabang->nm_kampus }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Download</button>
                                </div>
                            </div>
                        </form>

                       <br>
                       <p>
                        <h3>
                            *Catatan : "status" absen pada hasil unduh artinya jika 1 itu hadir, selain itu tidak hadir
                        </h3>
                       </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
