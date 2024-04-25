
@extends('layouts.dosen.main')

@section('content')

<div class="main-container">
    <div class="table-container"> 
        <div class="t-header">
            <a href="" class="" style="padding-top: 10px;"><i class="icon-documents"> </i>Alasan dari komentar Kaprodi</a>
        </div>
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('/alasan-prodi') }}" method="POST">  
                        @csrf
                        <div class="row gutters">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="kd_mtk">Kode MTK</label>
                                    <input type="email" class="form-control" id="kd_mtk" placeholder="Kode MTK" name="kd_mtk" value="{{$request[1]}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="nm_mtk">Matakuliah</label>
                                    <input type="email" class="form-control" id="nm_mtk" placeholder="Kode MTK" name="nm_mtk" value="{{$ajp->nm_mtk}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="sks">Kel Praktek</label>
                                    <input type="text" class="form-control" id="kel_praktek" placeholder="kel_praktek" name="kel_praktek" value="{{$request[0]}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="sks">Pertemuan</label>
                                    <input type="text" class="form-control" id="pertemuan" placeholder="pertemuan" name="pertemuan" value="{{$request[2]}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="sks">Tgl Ajar Masuk</label>
                                    <input type="text" class="form-control" id="tgl_masuk" placeholder="tgl_masuk" name="tgl_masuk" value="{{$ajp->tgl_ajar_masuk}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="jam_masuk">Jam Masuk</label>
                                    <input type="text" class="form-control" id="jam_masuk" placeholder="jam_masuk" name="jam_masuk" value="{{$ajp->jam_masuk}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="jam_keluar">Tgl Ajar Keluar</label>
                                    <input type="text" class="form-control" id="jam_keluar" placeholder="jam_keluar" name="jam_keluar" value="{{$ajp->tgl_ajar_keluar}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="jam_keluar">Jam Keluar</label>
                                    <input type="text" class="form-control" id="jam_keluar" placeholder="jam_keluar" name="jam_keluar" value="{{$ajp->jam_keluar}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="prodi">Nama Kaprodi</label>
                                    <input type="text" class="form-control" id="prodi" placeholder="prodi" name="prodi" value="{{$ajp->nama_log}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="prodi">Komentar Kaprodi</label>
                                    <input type="text" class="form-control" id="prodi" placeholder="prodi" name="prodi" value="{{$ajp->isi_prodi}}" readonly>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="bap">Berita Acara</label>
                                    <textarea name="bap" class="form-control" id="bap" readonly>{{$ajp->berita_acara}}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Rangkuman">Rangkuman</label>
                                    <textarea name="Rangkuman" class="form-control" id="Rangkuman" readonly>{{$ajp->rangkuman}}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ruang">Alasan</label>
                                    <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror" id="alasan" >{{$ajp->alasan}}</textarea>
                                    @error('alasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg"><i class="icon-send1"></i> Save</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection

    