@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                
                    <div class="card-header badge-secondary">
                        <h4 class="m-b-0 text-white">Edit Waktu Input Niali Essay Online</h4>
                    </div>
                    <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('nilai-essay-online.update', $setting->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="mulai">Tanggal Mulai</label>
                                <input type="datetime-local" class="form-control" id="mulai" name="mulai" value="{{ \Carbon\Carbon::parse($setting->mulai)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="selsai">Tanggal Selesai</label>
                                <input type="datetime-local" class="form-control" id="selsai" name="selsai" value="{{ \Carbon\Carbon::parse($setting->selsai)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="paket">Paket Ujian</label>
                                <input type="text" class="form-control" id="paket" name="paket" value="{{ $setting->paket }}" required>
                            </div>
                            <div class="form-group">
                                <label for="petugas">Petugas</label>
                                <input type="text" class="form-control" id="petugas" name="petugas" value="{{ $setting->petugas }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('perakit_soal.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
