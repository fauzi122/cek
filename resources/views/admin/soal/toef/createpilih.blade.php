@extends('layouts.dosen.main')

@section('content')

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
							 <div class="card">
                    <div class="card-header bg-primary">
							
                        <h4 class="m-b-0 text-white">Form Input Soal Pilihan Ganda</h4>
                    </div>
						
								<div class="card-body">
										<form  action="/toef-store/pilih" method="POST" enctype="multipart/form-data">
                    					@csrf
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-2 col-form-label">Soal</label>
										<div class="col-sm-10">
									 <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
									 <input type="hidden" name="id_soal" value="{{$soal->id}}">
									 <input type="hidden" name="jenis" value="1">
                                    <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                                   		<textarea id="summernote"class="form-control content @error('soal') is-invalid @enderror" 
                            			name="soal" placeholder="Masukkan soal " rows="5">{!! old('soal') !!}</textarea>
                              			

										@error('soal')
                              			<div class="invalid-feedback" style="display: block">
                                  		{{  $message }}
                              			</div>
                              			@enderror
										<p></p>
										<br>
                                   <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
								   placeholder="Masukkan URL :">
									
									{{--  <h5>file|:jpg,jepg,png,mp3|max:2500 kbps</h5>  --}}
									<br>
                                    <p></p>
                                   <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
									
									<h5>file|:jpg,jepg,png,mp3|max:2500 kbps</h5>
									<br>
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
                                        <label><input type="radio" name="status" id="n" value="N"> Tidak tampil</label>
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
       



@endsection

		
@push('scripts')
	<script src="{{asset('assets/plugin/jquery-3.5.1.slim.min.js')}}"></script>
		<script src="{{asset('assets/plugin/popper.min.js')}}"></script>
		<script src="{{asset('assets/plugin/bootstrap.min.js')}}"></script>
		<script src="{{asset('assets/plugin/summernote-bs4.js')}}"></script>
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

