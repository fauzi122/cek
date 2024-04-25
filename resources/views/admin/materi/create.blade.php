@extends('layouts.dosen.main')

@section('content')
<div class="main-container">

      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >FORM MATERI PEMBELAJARAN - {{ $materi->nm_mtk }}</h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
           
                <form class="row gutters" action="/materi" method="POST" enctype="multipart/form-data">
            
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
                          <label for="dovType">Kode Matakuliah </label>
                          <input type="text" class="form-control" id="dovType" 
                          placeholder="{{ $materi->kd_mtk }} " value="{{ $materi->kd_mtk }}"
                           name="kd_mtk" readonly>
                           
                      </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Kode Lokal</label>
                        @if ($materi->kd_gabung<>'')
                        <input type="text" class="form-control" id="dovType"
                        placeholder="{{ $materi->kd_gabung }}" value="{{ $materi->kd_gabung }}" 
                        name="kd_lokal" readonly>
                        @elseif($materi->kel_praktek<>'')
                        <input type="text" class="form-control" id="dovType"
                        placeholder="{{ $materi->kd_lokal }}" value="{{ $materi->kd_lokal }}" 
                        name="kd_lokal" readonly>
                        @else
                        <input type="text" class="form-control" id="dovType"
                         placeholder="{{ $materi->kd_lokal }}" value="{{ $materi->kd_lokal }}" 
                         name="kd_lokal" readonly>
                        @endif
                        
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                      <label for="dovType">File *pdf only, max 2Mb</label>
                      <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">

                                @error('file')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
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
                    <button type="submit" class="btn btn-info">Add Materi</button>
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