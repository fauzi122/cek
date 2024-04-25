@extends('layouts.dosen.main')

@section('content')

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
							 <div class="card">
                    <div class="card-header bg-primary">
							
                        <h4 class="m-b-0 text-white">Form Input Jadwal Kuis</h4>
                    </div>
						
								<div class="card-body">
                                    <form  action="/latihan" method="POST" enctype="multipart/form-data">
                    					@csrf
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
										<div class="col-sm-10">
                                            <select name="kd_mtk" class="form-control">
                                                <option value="">Pilih Matakuliah</option>
                                                @if($materis->count())
                                                @foreach($materis as $materi)
                                                <option value="{{ $materi->kd_mtk }}">{{ $materi->kd_mtk }} - {{ $materi->nm_mtk }}</option>
                                                @endforeach
                                                @endif
                                            </select>

                              			@error('soal')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
                                    <p></p>
                                
										</div>
									</div>
								
                  
                                        <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Paket</label>
										<div class="col-sm-10">
                                            <input type="text" class="form-control" id="dovType" 
                                            placeholder="" value="LATIHAN"
                                             name="paket" readonly>

										</div>
									</div>

                                    <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">KKM</label>
										<div class="col-sm-10">
                                            <input type="text" class="form-control  @error('kkm') is-invalid @enderror" required data-toggle="tooltip" title="Nilai Kriteria Ketuntasan Minimal (KKM)" name="kkm" placeholder="70">
                                            {!! old('kkm') !!}  
                                            @error('kkm')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror

										</div>
									</div>

                                    <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Waktu</label>
										<div class="col-sm-10">
                                            <input type="text" class="form-control  @error('waktu') is-invalid @enderror" required 
                                            data-toggle="tooltip" title="Masukan waktu ujian dalam satuan menit" name="waktu" placeholder="60">
                                            {!! old('waktu') !!}  
                                            @error('waktu')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror 

										</div>
									</div>

                                    <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Jumlah Soal</label>
										<div class="col-sm-10">
                                            <input type="text" class="form-control  @error('jml_soal') is-invalid @enderror" required 
                                            data-toggle="tooltip" title="Masukan jml_soal ujian dalam satuan menit" name="jml_soal" placeholder="60">
                                            {!! old('jml_soal') !!}  
                                            @error('jml_soal')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror 

										</div>
									</div>

                                    <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Waktu Mulai</label>
										<div class="col-sm-4">
                                            <input type="date" class="form-control" id="dovType" 
                                            placeholder="" 
                                            name="tgl_ujian" >
                                            {!! old('tgl_ujian') !!}  
                                            @error('tgl_ujian')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror 
										</div>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="dovType" 
                                            placeholder="" 
                                             name="jam_mulai_ujian" >
                                            {!! old('jam_mulai_ujian') !!}  
                                            @error('jam_mulai_ujian')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror 

										</div>
									</div>
                                    <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Waktu Selsai</label>
										<div class="col-sm-4">
                                            <input type="date" class="form-control" id="dovType" 
                                            placeholder="" 
                                            name="tgl_selsai_ujian" >
                                            {!! old('tgl_selsai_ujian') !!}  
                                            @error('tgl_selsai_ujian')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror 
										</div>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="dovType" 
                                            placeholder="" 
                                             name="jam_selsai_ujian" >
                                            {!! old('jam_selsai_ujian') !!}  
                                            @error('jam_selsai_ujian')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror 

										</div>
									</div>

                                    <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Deskripsi</label>
										<div class="col-sm-10">
                                            <textarea class="form-control content @error('deskripsi') is-invalid @enderror" 
                                            name="deskripsi" placeholder="Masukkan deskripsi " rows="5">{!! old('deskripsi') !!}</textarea>
                                            @error('deskripsi')
                                            <div class="invalid-feedback" style="display: block">
                                                {{  $message }}
                                            </div>
                                            @enderror
										</div>
									</div>
                                 
                                <div class="form-group" style="margin-top: 20px">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="notif-soal" style="display: none;"></div>
                                   
                                    <div id="wrap-btn">
                                        <button type="submit" class="btn btn-info">Save </button>

                                    </div>
                                </div>
                            </form>
                            </div>
                      
						 
                        </div>
	                </div>
                </div>
            
       
                


@endsection