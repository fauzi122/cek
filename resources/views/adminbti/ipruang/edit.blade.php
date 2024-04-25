@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >EDIT IP RUANG KELAS </h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
                <form class="row gutters" action="/ip-ruang/update/{{$editip->no_ruang}}" method="POST" enctype="multipart/form-data">
                    @csrf
                     @method('patch')
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">NO Ruang</label>
                        <input type="text" class="form-control  @error('no_ruang') is-invalid @enderror" readonly required data-toggle="tooltip" title="Nilai Kriteria Ketuntasan Minimal (no_ruang)" 
                        name="no_ruang" value="{{ $editip->no_ruang }}">
                      
                      <input type="hidden" class="form-control  @error('no_ruang') is-invalid @enderror" readonly required data-toggle="tooltip" title="Nilai Kriteria Ketuntasan Minimal (no_ruang)" 
                        name="updater" value="{{ Auth::user()->username}}">
                        @error('no_ruang')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">kapasitas</label>
                        <input type="text" class="form-control  @error('kapasitas') is-invalid @enderror" required 
                        data-toggle="tooltip" title="Masukan kapasitas ujian dalam satuan menit" name="kapasitas"
                         value="{{ $editip->kapasitas  }}">
                      
                        @error('kapasitas')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Network Id</label>
                        <input type="text" class="form-control  @error('network_id') is-invalid @enderror" required 
                        data-toggle="tooltip" title="Masukan network_id ujian dalam satuan menit" name="network_id"
                         value="{{ $editip->network_id  }}">
                      
                        @error('network_id')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>
                </div>
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Ip Address 1</label>
                        <input type="text" class="form-control  @error('ip_address') is-invalid @enderror" required 
                        data-toggle="tooltip" title="Masukan ip_address ujian dalam satuan menit" name="ip_address"
                         value="{{ $editip->ip_address  }}">
                      
                        @error('ip_address')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Ip Address 2</label>
                        <input type="text" class="form-control  @error('ip_address_2') is-invalid @enderror"
                        data-toggle="tooltip" title="Masukan ip_address_2 ujian dalam satuan menit" name="ip_address_2"
                         value="{{ $editip->ip_address_2  }}">
                      
                        @error('ip_address_2')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>
                </div>
                 
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Kondisi</label>
                        <input type="text" class="form-control  @error('kondisi') is-invalid @enderror" required 
                        data-toggle="tooltip" title="Masukan kondisi ujian dalam satuan menit" name="kondisi"
                         value="{{ $editip->kondisi  }}">
                      
                        @error('kondisi')
                        <div class="invalid-feedback" style="display: block">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>
                </div>
                   
                                  
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                       
                    </div>
              </div>
              <div class="modal-footer custom">
                
                  <div class="divider"></div>
                  <div class="right-side">
                   @can('ip_ruang.update')
                      <button type="submit" class="btn btn-info">Update </button>
                      @endcan
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