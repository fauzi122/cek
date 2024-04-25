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
										<form  action="/toef-lat-essay/update/{{$editsoal->id}}" method="POST" enctype="multipart/form-data">
                    					@csrf
                                        @method('patch')
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
										<div class="col-sm-10">
									 <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
									 <input type="hidden" name="id_soal" value="{{$editsoal->id_soal}}">
									 <input type="hidden" name="jenis" value="1">
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
                                <h5>file|:jpg,jepg,png,mp3|max:2500 kbps</h5>
									<br>
									<p></p>
                                @error('file')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

                                @if ($editsoal->file!=null)
                                 @if (substr($editsoal->file,-3)=='mp3')
									<audio controls>
										<source src="{{ Storage::url('public/soalessay/'.$editsoal->file) }}" type="audio/mpeg">
										Browsermu tidak mendukung tag audio, upgrade donk!
									</audio>
								@else
								<img src="{{ Storage::url('public/soalessay/'.$editsoal->file) }}" class="img-thumbnail" height="300" width="300">
 								 @endif
                                 
                                    @else
                    
                                    {{-- <img src="{{ Storage::url('public/icon/profile.png') }}" class="img-thumbnail" height="150" width="200"> --}}
                                    @endif
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
                                     <button type="submit" class="btn btn-info">Update Soal Essay </button>
                                     
                                    </div>
                                </div>
                            </div>
						 </form>
                        </div>
	                </div>
                </div>
       
                


@endsection