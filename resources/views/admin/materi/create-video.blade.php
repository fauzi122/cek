@extends('layouts.dosen.main')

@section('content')
<div class="main-container">

      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >FORM VIDEO PEMBELAJARAN - {{ $video->nm_mtk }}</h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
           
                <form class="row gutters" action="/materi-store" method="POST" enctype="multipart/form-data">
            
                  @csrf

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Nip</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ Auth::user()->username }}" name="nip"
                             value="{{ Auth::user()->username }}" readonly>
                        </div>
                        <div class="form-group">
                           
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ Auth::user()->kode }}" name="kd_dosen"
                             value="{{ Auth::user()->kode }}" readonly hidden>
                        </div>
                    </div>
                   
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                          <label for="dovType">Kode Matakuliah</label>
                          <input type="text" class="form-control" id="dovType" 
                          placeholder="{{ $video->kd_mtk }}" value="{{ $video->kd_mtk }}"
                           name="kd_mtk" readonly>
                      </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Kode Lokal</label>
                        @if ($video->kd_gabung<>'')
                        <input type="text" class="form-control" id="dovType"
                        placeholder="{{ $video->kd_gabung }}" value="{{ $video->kd_gabung }}" 
                        name="kd_lokal" readonly>
                        @elseif($video->kel_praktek<>'')
                        <input type="text" class="form-control" id="dovType"
                        placeholder="{{ $video->kd_lokal }}" value="{{ $video->kd_lokal }}" 
                        name="kd_lokal" readonly>
                        @else
                        <input type="text" class="form-control" id="dovType"
                         placeholder="{{ $video->kd_lokal }}" value="{{ $video->kd_lokal }}" 
                         name="kd_lokal" readonly>
                        @endif
                        
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                      <label for="dovType">Link Video</label>
                      <input type="text" name="isi" class="form-control @error('isi') is-invalid @enderror" placeholder="P7Dz5qzzMBo">

                                @error('isi')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                                
                                https://www.youtube.com/watch?v=<code>P7Dz5qzzMBo</code>&feature=youtu.be
                  </div>
              </div>
                 
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group mb-0">
                            <label for="docDetails">Judul</label>
                            <textarea class="form-control content @error('judul') is-invalid @enderror" name="judul" placeholder="Masukkan Judul Materi" rows="2">{!! old('judul') !!}</textarea>
                            @error('judul')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <p>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="form-group mb">
                          <label for="docDetails">Deskripsi</label>
                          <textarea class="form-control content @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Masukkan deskripsi Materi" rows="5">{!! old('deskripsi') !!}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback" style="display: block">
                                {{  $message }}
                            </div>
                            @enderror
                      </div>
                  </div>
               

               
            </div>
            <div class="modal-footer custom">
              
                <div class="divider"></div>
                <div class="right-side">
                    <button type="submit" class="btn btn-info">Add Video</button>
                </div>
                <div class="left-side">
                    <button type="reset" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
      </form>
    </div>
</div>
</div>

@endsection