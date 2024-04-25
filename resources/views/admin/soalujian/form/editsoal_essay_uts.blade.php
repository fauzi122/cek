@extends('layouts.dosen.main')

@section('content')

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
							 <div class="card">
                    <div class="card-header bg-primary">
							
                        <h4 class="m-b-0 text-white">Edit Soal Essay</h4>
                    </div>
						            {{--  @php
                                      $detail_essay=Crypt::encryptString($editsoal->id);                                    
                                      @endphp  --}}

								<div class="card-body">
										<form  action="/uts-essay/update/{{$editsoal->id}}" method="POST" enctype="multipart/form-data">
                    					@csrf
                                        @method('patch')
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
										<div class="col-sm-10">
									 <input type="hidden" name="id_user" value="{{Auth::user()->kode}}">
									 <input type="hidden" name="kd_mtk" value="{{$editsoal->kd_mtk}}">
									 <input type="hidden" name="jenis" value="{{$editsoal->jenis}}">
                                    <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                                    <textarea id="summernote2" class="form-control content @error('soal') is-invalid @enderror" name="soal" placeholder="Masukkan Konten / Isi Berita" required
									oninvalid="this.setCustomValidity('Silahkan isi artikel')"
									oninput="setCustomValidity('')">
									{!! old('soal',$editsoal->soal) !!}
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

                                @if ($editsoal->file!=null)
                                    <img src="{{ Storage::url('public/soalessay/'.$editsoal->file) }}" class="img-thumbnail" height="150" width="200"/>
                                 
                                    @else
                    
                                    {{-- <img src="{{ Storage::url('public/icon/profile.png') }}" class="img-thumbnail" height="150" width="200"> --}}
                                    @endif
										</div>
									</div>
                                    <div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Jawaban</label>
										<div class="col-sm-10">
									
                                    <textarea id="summernote3" class="form-control content @error('kunci') is-invalid @enderror" name="kunci" placeholder="Masukkan Konten / Isi Berita" required
									oninvalid="this.setCustomValidity('Silahkan isi artikel')"
									oninput="setCustomValidity('')">
									{!! old('kunci',$editsoal->kunci) !!}
								</textarea>
                                        
                              			@error('kunci')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
                                    <p></p>
                                        {{--  <div class="form-group row">
										<label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
										<div class="col-sm-10">
										<label><input type="radio" name="status" id="y" value="Y" @if($editsoal->status == "Y") checked @endif> Tampil</label> &nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" name="status" id="n" value="N" @if($editsoal->status == "N") checked @endif> Tidak tampil</label>
										</div>  --}}
									</div>
                  
                                <div class="form-group" style="margin-top: 20px">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="notif-soal" style="display: none;"></div>
                                    <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                                    <div id="wrap-btn">
                                     <button type="submit" class="btn btn-info">Update Soal Essay </button>
                                     
                                    </div>
                                </div>
                            </div>
						 </form>
                        </div>
	                </div>
                </div>
       
                


@endsection