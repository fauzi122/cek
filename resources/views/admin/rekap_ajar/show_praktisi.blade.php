@extends('layouts.dosen.main')
@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
            @if (isset($_POST['kirim']))
            <form action="{{ url('/update-pengganti-teori') }}" method="POST">  
                @else
                <form action="{{ url('/simpan-pengganti-teori') }}" method="POST">
            @endif
                @csrf
                <div class="row gutters">
                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="matkul">Matakuliah</label>
                            <input type="text" class="form-control" id="matkul" placeholder="Matakuliah" name="matkul" value="{{$rekapajar_praktisi->nm_mtk}}" readonly>
                            <input type="hidden" name="kd_dosen" value="{{$rekapajar_praktisi->kd_dosen}}">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="kd_mtk">Kode MTK</label>
                            <input type="email" class="form-control" id="kd_mtk" placeholder="Kode MTK" name="kd_mtk" value="{{$rekapajar_praktisi->kd_mtk}}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="sks">SKS</label>
                            <input type="text" class="form-control" id="sks" placeholder="SKS" name="sks" value="@if(isset($rekapajar_praktisi->sksajar)){{$rekapajar_praktisi->sksajar}}@else{{$rekapajar_praktisi->sks}}@endif" readonly>
                        </div>
                        
                    </div>
                    
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input class="form-control" id="kelas" type="text" placeholder="Kelas" value="{{$rekapajar_praktisi->kd_lokal}}" name="kelas" readonly>
                        </div>
                    </div>
                    
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="ruang">Ruangan</label>
                            <input class="form-control" id="ruang" type="text" name="ruang" value="{{$rekapajar_praktisi->no_ruang}}" required>
                        </div>
                    </div>
                </div>
                <div class="row gutters">
                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rangkuman</span>
                                </div>
                                <textarea name="rangkuman" cols="35" id="rangkuman" placeholder="Rangkuman" required>@if(isset($rekapajar_praktisi->rangkuman)){{$rekapajar_praktisi->rangkuman}}</textarea>@else</textarea>@endif
                            </div>
                        </div>
                    </div>       
                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Berita Acara</span>
                                </div>
                                <textarea name="berita_acara" cols="30" id="berita_acara" placeholder="Berita acara" required>@if(isset($rekapajar_praktisi->berita_acara)){{$rekapajar_praktisi->berita_acara}}</textarea>@else</textarea>@endif
                            </div>
                        </div>
                    </div>       
                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">File Bukti Pengajaran</span>
                                </div>
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                                <h5><code>File PDF,JPG,JPEG,DOC,DOCX Max 2MB</code></h5>
                                @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>       
                    <!-- <textarea name="" id="" cols="30" rows="10"></textarea>              -->
                </div>
                @if (isset($_POST['kirim']))
                    <button type="submit" class="btn btn-primary btn-lg"><i class="icon-send1"></i> Update</button>
                @else
                    <button type="submit" class="btn btn-primary btn-lg"><i class="icon-save"></i> Simpan</button>
                @endif
            </form>
            @if (isset($rekapajar_praktisi->file_ajar))
            <form action="/download-file-ajar" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$rekapajar_praktisi->id}}">
                <input type="hidden" name="file" value="{{$rekapajar_praktisi->file_ajar}}">
                <center><button type="submit" class="btn btn-info btn-rounded"><i class="icon-download"></i> Unduh Bukti Ajar</button></center>
            </form>  
            @endif
        </div>
</div>
{{-- Pemisah --}}

        
    
@endsection