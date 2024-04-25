@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="m-b-0 text-white">Form Input Soal Pilihan Essay</h4>
                    </div>
                    <div class="card-body">
                        <form action="/baak/store/essay-uts" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="id_user" value="{{ Auth::user()->kode }}">
                                    <input type="hidden" name="kd_mtk" value="{{ $soal->kd_mtk }}">
                                    <input type="hidden" name="jenis" value="{{ $soal->paket }}">
                                    <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                                    <textarea id="summernote2" class="form-control content @error('soal') is-invalid @enderror" name="soal" required 
                                              oninvalid="this.setCustomValidity('Silahkan isi artikel')" 
                                              oninput="setCustomValidity('')">{{ old('soal') }}</textarea>
                                    @error('soal')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                                    @error('file')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Jawaban</label>
                                <div class="col-sm-10">
                                    <textarea id="summernote3" class="form-control content @error('kunci') is-invalid @enderror" name="kunci" required
                                              oninvalid="this.setCustomValidity('Silahkan isi artikel')"
                                              oninput="setCustomValidity('')">{{ old('kunci') }}</textarea>
                                    @error('kunci')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <label><input type="radio" name="status" id="y" value="Y"> Tampil</label>
                                    <label><input type="radio" name="status" id="n" value="N"> Tidak tampil</label>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 20px">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="notif-soal" style="display: none;"></div>
                                    <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                                    <div id="wrap-btn">
                                        <button type="submit" class="btn btn-info">Simpan Soal</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
