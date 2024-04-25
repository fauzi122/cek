@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >Create Or Update Group whatsapp - {{ $wa->nm_mtk }}</h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
           
                <form class="row gutters" action="/grup-wa" method="POST" enctype="multipart/form-data">
            
                  @csrf

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">NIP</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="" name="nip"
                             value="{{ $wa->nip }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="docTitle">Akronim</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $wa->kd_dosen }}" name="kd_dosen"
                             value="{{ $wa->kd_dosen }}" readonly >
                        </div>
                        <div class="form-group">
                            <label for="docTitle">Kelas</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $wa->kd_lokal }}" name="kd_lokal"
                             value="{{ $wa->kd_lokal }}" readonly >
                        </div>
                       
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Kode Matakuliah</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $wa->kd_mtk }}" name="kd_mtk"
                             value="{{ $wa->kd_mtk }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="docTitle">Nama Grup Whatsapp</label>
                            <input type="text" class="form-control @error('nm_grup') is-invalid @enderror" required
                            name="nm_grup" placeholder="Masukan Nama Grup">
                        </div>
                        <div class="btn btn-secondary"> <i class="icon-warning"></i>
                            *Catatan : Nama Grup Whatsapp yang di input harus sama dengan nama yang tertera di 
                            Handphone, bapak/ibu
                        </div>
                    </div>
                  
              
                    </div>

                   
            <div class="modal-footer custom">
                
                <div class="divider"></div>
                <div class="right-side">
                    <button type="submit" class="btn btn-info">Add</button>
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