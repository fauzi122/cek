@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="table-container">
        <div class="t-header"> Form Edit Data

        </div>
        <div class="card-body">
            <form action="{{ route('toefmhs.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" value="{{ $data->nim }}" placeholder="Masukkan NIM"
                        class="form-control @error('nim') is-invalid @enderror">

                    @error('nim')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" value="{{ $data->nama }}" placeholder="Masukkan Nama"
                        class="form-control @error('nama') is-invalid @enderror">

                    @error('nama')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kode Lokal</label>
                    <input type="text" name="kd_lokal" value="{{ $data->kd_lokal }}" placeholder="Masukkan Kode Lokal"
                        class="form-control @error('kd_lokal') is-invalid @enderror">

                    @error('kd_lokal')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kode Mata Kuliah</label>
                    <input type="text" name="kd_mtk" value="{{ $data->kd_mtk }}" placeholder="Masukkan Kode Mata Kuliah"
                        class="form-control @error('kd_mtk') is-invalid @enderror">

                    @error('kd_mtk')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kode Dosen</label>
                    <input type="text" name="kd_dosen" value="{{ $data->kd_dosen }}" placeholder="Masukkan Kode Dosen"
                        class="form-control @error('kd_dosen') is-invalid @enderror">

                    @error('kd_dosen')
                    <div class="invalid-feedback" style="display: block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="icon-paper"></i>
                    Update Data</button>
                <a href="{{ route('data.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
            </form>
        </div>
    </div>
</div>

@endsection
