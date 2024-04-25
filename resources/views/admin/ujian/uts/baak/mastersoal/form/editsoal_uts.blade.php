
@extends('layouts.dosen.ujian.main')

@section('content')
<div class="main-container">
	<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
							 <div class="card">
                    <div class="card-header bg-primary">
							
                        <h4 class="m-b-0 text-white">Edit Soal Pilihan Ganda</h4>
                    </div>
						
								<div class="card-body">
										<form  action="/baak/uts-pilih/update/{{$editsoal->id}}" method="POST" enctype="multipart/form-data">
                    					@csrf
										 @method('patch')
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
										<div class="col-sm-10">
									 <input type="hidden" name="id_user" value="{{Auth::user()->kode}}">
									 <input type="hidden" name="kd_mtk" value="{{$editsoal->kd_mtk}}">
									 <input type="hidden" name="jenis" value="{{$editsoal->jenis}}">
                                    <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                                   		<textarea class="form-control content @error('soal') is-invalid @enderror" 
                            			name="soal" placeholder="Masukkan soal " rows="5">{!! old('soal',$editsoal->soal) !!}</textarea>
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

                                @if ($editsoal->file!=null)
                                    <img src="{{ Storage::url('public/soal/'.$editsoal->file) }}" class="img-thumbnail" height="150" width="200"/>
                                 
                                    @else
                    
                                    {{-- <img src="{{ Storage::url('public/icon/profile.png') }}" class="img-thumbnail" height="150" width="200"> --}}
                                    @endif
										</div>
									</div>
                                    
									<div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Pilihan A</label>
										<div class="col-sm-10">
										<textarea class="form-control content @error('pila') is-invalid @enderror" 
                            			name="pila" placeholder="Masukkan pilihan a " rows="2">{!! old('pila',$editsoal->pila) !!}</textarea>
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
                            			name="pilb" placeholder="Masukkan pilihan b " rows="2">{!! old('pilb',$editsoal->pilb) !!}</textarea>
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
                            			name="pilc" placeholder="Masukkan pilihan c " rows="2">{!! old('pilc',$editsoal->pilc) !!}</textarea>
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
                            			name="pild" placeholder="Masukkan pilihan d " rows="2">{!! old('pild',$editsoal->pild) !!}</textarea>
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
                            			name="pile" placeholder="Masukkan pilihan e " rows="2">{!! old('pile',$editsoal->pile) !!}</textarea>
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
                                    <label><input type="radio" name="kunci" id="a" value="A" @if($editsoal->kunci == "A") checked @endif> Jawaban <b>A</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="b" value="B" @if($editsoal->kunci == "B") checked @endif> Jawaban <b>B</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="c" value="C" @if($editsoal->kunci == "C") checked @endif> Jawaban <b>C</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="d" value="D" @if($editsoal->kunci == "D") checked @endif> Jawaban <b>D</b></label> &nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="kunci" id="e" value="E" @if($editsoal->kunci == "E") checked @endif> Jawaban <b>E</b></label>
                                    </div>
										</div>
									</div>

                 	                <div class="form-group row">
										{{--  <label for="inputPassword" class="col-sm-2 col-form-label">Score</label>  --}}
										<div class="col-sm-10">
                                            <input type="text" class="form-control numOnly" name="score" hidden placeholder="Score" value="1">

										</div>
									</div>
                  
                                        <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
										<div class="col-sm-10">
										<label><input type="radio" name="status" id="y" value="Y" @if($editsoal->status == "Y") checked @endif> Tampil</label> &nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" name="status" id="n" value="N" @if($editsoal->status == "N") checked @endif> Tidak tampil</label>
										</div>
									</div>
                  
                                <div class="form-group" style="margin-top: 20px">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="notif-soal" style="display: none;"></div>
                                    <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                                    <div id="wrap-btn">
                                     <button type="submit" class="btn btn-info">Update Soal </button>
                                     
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