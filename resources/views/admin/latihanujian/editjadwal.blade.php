@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >FORM EDIT JADWAL KUIS  </h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
                <form class="row gutters" action="/jadwal/update/{{$editjadwal->id}}" method="POST" enctype="multipart/form-data">
            
                    @csrf
                    @method('patch')
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="dovType">Matakuliah </label>
                                 <select name="kd_mtk" class="form-control">
                                    <option value="">Pilih Matakuliah</option>
                                    @foreach($materis as $materi)
                                    @if($editjadwal->kd_mtk == $materi->kd_mtk)
                                        <option value="{{ $materi->kd_mtk  }}" selected>{{ $materi->kd_mtk  }} - {{ $materi->nm_mtk }}</option>
                                    @else
                                        <option value="{{ $materi->kd_mtk  }}">{{ $materi->kd_mtk  }} - {{ $materi->nm_mtk }}</option>
                                    @endif
                                @endforeach
                                </select>
                             
                             
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                       
                        <label for="dovType">Paket </label>
                        <input type="text" class="form-control" id="dovType" 
                        placeholder="" value="LATIHAN"
                         name="paket" readonly>
                      </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">KKM</label>
                        <input type="text" class="form-control  @error('kkm') is-invalid @enderror" required data-toggle="tooltip" title="Nilai Kriteria Ketuntasan Minimal (KKM)" 
                        name="kkm" value="{{ $editjadwal->kkm }}">
                      
                        @error('kkm')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Waktu</label>
                        <input type="text" class="form-control  @error('waktu') is-invalid @enderror" required 
                        data-toggle="tooltip" title="Masukan waktu ujian dalam satuan menit" name="waktu"
                         value="{{ $editjadwal->waktu  }}">
                      
                        @error('waktu')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>
                </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                         
                          <label for="dovType">Waktu Mulai </label>
                          <input type="text" class="form-control  @error('tgl_ujian') is-invalid @enderror" id="dovType" 
                          placeholder="" required
                           name="tgl_ujian"  value="{{ $editjadwal->tgl_ujian  }}" >
                         
                          @error('tgl_ujian')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}

                        </div>
                        @enderror 
                        </div>
                    </div>
                    {{--  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="dovType">Tanggal Mulai </label>
                            <input type="time" class="form-control" id="dovType" 
                            placeholder="" 
                             name="jam_mulai_ujian" >
                             
                        </div>
                    </div>  --}}
                 
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                         
                          <label for="dovType">Waktu Selsai </label>
                          <input type="text" class="form-control  @error('tgl_selsai_ujian') is-invalid @enderror" id="dovType" 
                          placeholder="" required
                           name="tgl_selsai_ujian" value="{{ $editjadwal->tgl_selsai_ujian  }}" >
                        
                        @error('tgl_selsai_ujian')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}

                        </div>
                        @enderror 
                        </div>
                    </div>
                    {{--  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="dovType">Tanggal Selsai </label>
                            <input type="time" class="form-control" id="dovType" 
                            placeholder="" 
                             name="jam_selsai_ujian" >
                             
                        </div>
                    </div>  --}}
                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                       <div class="form-group">
                        <label for="dovType">Jumlah Soal</label>
                        <input type="text" class="form-control  @error('jml_soal') is-invalid @enderror" required 
                        data-toggle="tooltip" title="Masukan jml_soal ujian dalam satuan menit" name="jml_soal"
                         value="{{ $editjadwal->jml_soal  }}">
                      
                        @error('jml_soal')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>
                    </div>              
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group mb">
                            <label for="docDetails">Deskripsi</label>
                            <textarea class="form-control content @error('deskripsi') is-invalid @enderror" 
                            name="deskripsi" placeholder="Masukkan deskripsi " rows="5">{!! old('deskripsi',$editjadwal->deskripsi ) !!}</textarea>
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
                      <button type="submit" class="btn btn-info">Update </button>
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