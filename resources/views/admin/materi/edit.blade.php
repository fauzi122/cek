@extends('layouts.dosen.main')

@section('content')
<div class="main-container">

      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >Add Document Materi</h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
           
                <form class="row gutters" action="{{url('/materi-update',$materi->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Nip</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ old('nip', $materi->nip) }}" name="nip"
                             value="{{ old('nip', $materi->nip) }}" readonly>
                        </div>
                    </div>
                   
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                          <label for="dovType">Kode Matakuliah</label>
                          <input type="text" class="form-control" id="dovType" 
                          placeholder="{{ $materi->kd_mtk }}" value="{{ $materi->kd_mtk }}"
                           name="kd_mtk" readonly>
                      </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Kode Lokal</label>
                        <input type="text" class="form-control" id="dovType"
                         placeholder="{{ $materi->kd_lokal }}" value="{{ $materi->kd_lokal }}" 
                         name="kd_lokal" readonly>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                      <label for="dovType">File</label>
                      <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">                      
                  </div>
              </div>
                 
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group mb-0">
                            <label for="docDetails">Judul</label>
                            <textarea class="form-control content @error('judul') is-invalid @enderror" name="judul" 
                            placeholder="Masukkan Judul Materi" rows="2">{!! old('judul',$materi->judul) !!}</textarea>
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
                          <textarea class="form-control content @error('deskripsi') is-invalid @enderror" name="deskripsi"
                           placeholder="Masukkan deskripsi Materi" rows="5">{!! old('deskripsi',$materi->deskripsi) !!}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback" style="display: block">
                                {{  $message }}
                            </div>
                            @enderror
                      </div>
                  </div>
               

               
            </div>
            <div class="modal-footer custom">
                <div class="left-side">
                    <button type="reset" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    <button type="submit" class="btn btn-info">Add</button>
                </div>
            </div>
        </div>
      </form>
    </div>
</div>
</div>

@endsection