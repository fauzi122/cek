@extends('layouts.dosen.main')
@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('/update-pengganti-baak') }}" method="POST">  
                @csrf
                <div class="row gutters">
                    <div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="matkul">Matakuliah</label>
                            <input type="text" class="form-control" id="matkul" placeholder="Matakuliah" name="matkul" value="{{$jadwal->nm_mtk}}" readonly>
                            <input type="hidden" name="no_j_klh" value="{{$jadwal->no_j_klh}}">
                            <input type="hidden" name="kd_dosen" value="{{$jadwal->kd_dosen}}">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="kd_mtk">Kode MTK</label>
                            <input type="email" class="form-control" id="kd_mtk" placeholder="Kode MTK" name="kd_mtk" value="{{$jadwal->kd_mtk}}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lglg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="sks">SKS</label>
                            <input type="text" class="form-control" id="sks" placeholder="SKS" name="sks" value="@if(isset($jadwal->sksajar)){{$jadwal->sksajar}}@else{{$jadwal->sks}}@endif" readonly>
                        </div>
                        
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="kampus">Kampus</label>
                            <input class="form-control" id="kampus" type="text" placeholder="Kampus" value="{{$jadwal->nm_kampus}}" name="kampus" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input class="form-control" id="kelas" type="text" placeholder="Kelas" value="@if (isset($jadwal->kel_praktek)){{$jadwal->kel_praktek}}
                            @elseif(isset($jadwal->kd_gabung)){{$jadwal->kd_gabung}}
                            @else{{$jadwal->kd_lokal}}@endif" name="kelas" readonly>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="tgl_sebelum">Tanggal Digantikan</label>
                            <input class="form-control" id="tgl_sebelum" type="date" name="tgl_sebelum" value="@if(isset($jadwal->tgl_yg_digantikan)){{$jadwal->tgl_yg_digantikan}}@else @endif">
                            @if (isset($jadwal->tgl_yg_digantikan))
                            <input type="hidden" name="tgl_sebelum_old" value="{{$jadwal->tgl_yg_digantikan}}">
                        @endif
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="tgl_pengganti">Tanggal Pengganti</label>
                            <input class="form-control" id="tgl_pengganti" type="date" name="tgl_pengganti" 
                            value="@if(isset($jadwal->tgl_klh_pengganti)){{$jadwal->tgl_klh_pengganti}}@else
                            @endif" required>
                        @if (isset($jadwal->tgl_klh_pengganti))
                            <input type="hidden" name="tgl_pengganti_old" value="{{$jadwal->tgl_klh_pengganti}}">
                        @endif
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="jam_masuk">Jam Masuk</label>
                            <input class="form-control" id="jam_masuk" type="time" name="jam_masuk" value="{{$jadwal->mulai}}" required>
                            
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="jam_keluar">Jam Keluar</label>
                            <input class="form-control" id="jam_keluar" type="time" name="jam_keluar" value="{{$jadwal->selesai}}" required>
                            
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="ruang">Ruangan</label>
                            <input class="form-control" id="ruang" type="text" name="ruang" value="{{$jadwal->no_ruang}}">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <div class="form-group">
                            <label for="ruang">Nip</label>
                            <input class="form-control" id="ruang" type="text" name="nip" value="{{$jadwal->nip}}" readonly>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg"><i class="icon-send1"></i> Update</button>
            
            </form>
        </div>
        
    </div>
</div>
{{-- Pemisah --}}

        
    
@endsection
@push('scripts')
		<script type="text/javascript">
		$('#btnDelete').on('click',function(e){
			document.onsubmit=function(){
           return confirm('Sure?');
       }
	});
			</script>
	@endpush
