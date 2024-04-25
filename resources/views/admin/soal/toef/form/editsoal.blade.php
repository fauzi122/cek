@extends('layouts.dosen.main')

@section('content')

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
							 <div class="card">
                    <div class="card-header bg-primary">
							
                        <h4 class="m-b-0 text-white">Edit Soal Pilihan Ganda</h4>
                    </div>
						
								<div class="card-body">
										<form  action="/toef-lat-pilih/update/{{$editsoal->id}}" method="POST" enctype="multipart/form-data">
                    					@csrf
										 @method('patch')
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
										<div class="col-sm-10">
									 <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
									 <input type="hidden" name="id_soal" value="{{$editsoal->id_soal}}">
									 <input type="hidden" name="jenis" value="1">
                                    <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                                   		<textarea id="summernote" class="form-control content @error('soal') is-invalid @enderror" 
                            			name="soal" placeholder="Masukkan soal " rows="5">{!! old('soal',$editsoal->soal) !!}</textarea>
                              			@error('soal')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
											<p></p>
										<br>
                                   <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
								   placeholder="Masukkan URL :">
							@if ($editsoal->url != null)
							<br>
								<a href="{!! old('url', $editsoal->url) !!}" target="_blank" class="audio-button">
									<span class='badge badge-pill badge-info'> Play Audio</span>
								</a>
								<br>
							@endif



									<br>
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
										<source src="{{ Storage::url('public/soal/'.$editsoal->file) }}" type="audio/mpeg">
										Browsermu tidak mendukung tag audio, upgrade donk!
									</audio>
								@else
								<img src="{{ Storage::url('public/soal/'.$editsoal->file) }}" class="img-thumbnail" height="300" width="300">
								@endif
                                 
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
										<label for="inputPassword" class="col-sm-2 col-form-label">Score</label>
										<div class="col-sm-10">
                                            <input type="number" class="form-control numOnly" name="score"  placeholder="Score" title="Masukan score ujian" value="{{ $editsoal->score }}">

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
       
                


@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Masukkan soal',
            height: 300, // Sesuaikan tinggi jika diperlukan
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontsize', ['fontsize']],
                ['fontname', ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36'] // Daftar ukuran font yang tersedia
        });
    });
</script>
@endpush

