@extends('layouts.mhs.main')

@section('content')
<div class="main-container">

      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >Form Upload Tugas - <div class="btn btn-secondary">
                    <i class="icon-warning"></i> Pastikan Link google drive anda tidak di private</div>
                    </h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
           
               
            <form action="/assignment" method="post">
                  @csrf

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            
                            <input type="hidden" class="form-control" id="docTitle" 
                            placeholder="{{ $sendtugas->kd_mtk }}" value="{{ $sendtugas->kd_mtk }}" name="kd_mtk"
                            readonly >
                            
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            
                            <input type="hidden" class="form-control" id="docTitle" 
                            placeholder="{{ $sendtugas->id }}" name="id_tugas"
                             value="{{ $sendtugas->id }}" readonly>
                        </div>
                    </div>
                    
                
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="docTitle" 
                            placeholder="{{Auth::user()->username}}"name="nim"
                            value="{{Auth::user()->username}}"readonly>
                        </div>
                    </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="docTitle" 
                        placeholder="{{ $sendtugas->kd_lokal }}" name="kd_lokal"
                        value="{{ $sendtugas->kd_lokal }}" readonly>
                        
                    </div>
                
                </div>
                
               
                 
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group mb-0">
                            <label for="docDetails">Link Tugas</label>
                            {{-- <textarea class="form-control content @error('isi') is-invalid @enderror" name="isi" 
                            placeholder="Masukkan Link Tugas" 
                            rows="2">{{ old('isi') }}</textarea>  --}}

                            <input type="url" class="form-control content @error('isi') is-invalid @enderror" name="isi" 
                            placeholder="Masukkan Link Tugas: https://drive.google.com/file/d/14wUrOkCVbx-e_LaFjXjzKYm0" 
                            {{ old('isi') }}>
                            <div></div>
                        <p>
                           
                            @error('isi')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <p>
  
            
            <div class="modal-footer custom">
                
                <div class="divider"></div>
                <div class="right-side">
                    <button type="submit" class="btn btn-info">Kirim Tugas</button>
                </div>
                <div class="left-side">
                    <button type="reset" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>
               
             
            </div>
        </form>
        </div>
        </div>
     
     
    </div>
    
</div>



@endsection