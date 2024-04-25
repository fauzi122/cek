@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
		<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
							 <div class="card">
                    <div class="card-header bg-primary">
							
                        <h4 class="m-b-0 text-white">Form Input Soal Pilihan Ganda</h4>
                    </div>
						
								<div class="card-body">
										<form  action="/baak/store/pilih-uts" method="POST" enctype="multipart/form-data">
                    					@csrf
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
										<div class="col-sm-10">
									 <input type="hidden" name="id_user" value="{{Auth::user()->kode}}">
									 <input type="hidden" name="kd_mtk" value="{{$soal->kd_mtk}}">
									 <input type="hidden" name="jenis" value="{{$soal->paket}}">
                                    <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
									<textarea id="summernote2" class="form-control content @error('soal') is-invalid @enderror" name="soal" placeholder="Masukkan Konten / Isi Berita" required
									oninvalid="this.setCustomValidity('Silahkan isi artikel')"
									oninput="setCustomValidity('')">
									{!! old('soal') !!}
								</textarea>
                              			@error('soal')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
                                    <p></p>
                                   <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">

                                @error('file')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

										</div>
									</div>
									<div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Pilihan A</label>
										<div class="col-sm-10">
										<textarea class="form-control content @error('pila') is-invalid @enderror" 
                            			name="pila" placeholder="Masukkan pilihan a " rows="2">{!! old('pila') !!}</textarea>
                              			@error('pila')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
										</div>
									</div>
                  		            <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Pilihan B</label>
										<div class="col-sm-10">
										<textarea class="form-control content @error('pilb') is-invalid @enderror" 
                            			name="pilb" placeholder="Masukkan pilihan b " rows="2">{!! old('pilb') !!}</textarea>
                              			@error('pilb')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
										</div>
									</div>
                  		            <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Pilihan C</label>
										<div class="col-sm-10">
									<textarea class="form-control content @error('pilc') is-invalid @enderror" 
                            			name="pilc" placeholder="Masukkan pilihan c " rows="2">{!! old('pilc') !!}</textarea>
                              			@error('pilc')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
										</div>
									</div>
                  		            <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Pilihan D</label>
										<div class="col-sm-10">
										<textarea class="form-control content @error('pild') is-invalid @enderror" 
                            			name="pild" placeholder="Masukkan pilihan d " rows="2">{!! old('pild') !!}</textarea>
                              			@error('pild')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
										</div>
									</div>
                  	                <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Pilihan E</label>
										<div class="col-sm-10">
										<textarea class="form-control content @error('pile') is-invalid @enderror" 
                            			name="pile" placeholder="Masukkan pilihan e " rows="2">{!! old('pile') !!}</textarea>
                              			@error('pile')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
										</div>
									</div>

                                    <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Jawaban</label>
										<div class="col-sm-10">
									<div class="radio">
                                    <label><input type="radio" name="kunci" id="a" value="A"> Jawaban <b>A</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="b" value="B"> Jawaban <b>B</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="c" value="C"> Jawaban <b>C</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="d" value="D"> Jawaban <b>D</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="e" value="E"> Jawaban <b>E</b></label>
                                    </div>
										</div>
									</div>

                 	                <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Score</label>
										<div class="col-sm-10">
										 <input type="number"  class="form-control  @error('score') is-invalid @enderror"  
											data-toggle="tooltip" title="Masukan score ujian " name="score" placeholder="60" value="1">
											{!! old('score') !!}  
											@error('score')
											<div class="invalid-feedback" style="display: block">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>
                  
                                        <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
										<div class="col-sm-10">
										<label><input type="radio" name="status" id="y" value="Y"> Tampil</label> &nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" name="status" id="n" value="T"> Tidak tampil</label>
										</div>
									</div>
                  
                                <div class="form-group" style="margin-top: 20px">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="notif-soal" style="display: none;"></div>
                                    <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                                    <div id="wrap-btn">
                                     <button type="submit" class="btn btn-info">Simpan Soal </button>
                                     <button type="reset" class="btn btn-secondary">Batal </button>
                                    </div>
                                </div>
                            </div>
						 </form>
                        </div>
	                </div>
                </div>
                </div>
                </div>
       
                


@endsection