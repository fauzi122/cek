@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >Form Edit Jadwal Dosen</h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
            @php
                    $idComponents = [
                        $tugas->nip,
                        $tugas->kd_dosen,
                        $tugas->kd_lokal,
                        $tugas->kel_praktek,
                        $tugas->hari_t,
                        $tugas->jam_t,
                        $tugas->no_ruang,
                        $tugas->kd_mtk,
                        $tugas->sks,
                        $tugas->mulai,
                        $tugas->selesai,
                        $tugas->selesai_interval,
                        $tugas->kd_gabung
                    ];

                    $idString = implode(',', $idComponents);
                    $id = Crypt::encryptString($idString);
                @endphp

                
            
                <form class="row gutters" action="/lecturer/schedule/update/ {{$id}}" method="POST" enctype="multipart/form-data">
            
                     @csrf
                    @method('PUT')

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Nip</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->nip }}" name="nip"
                             value="{{ $tugas->nip }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Kode Dosen</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->kd_dosen }}" name="kd_dosen"
                             value="{{ $tugas->kd_dosen }}" >
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Kelas</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->kd_lokal }}" name="kd_lokal"
                             value="{{ $tugas->kd_lokal }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">kel_praktek</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->kel_praktek }}" name="kel_praktek"
                             value="{{ $tugas->kel_praktek }}" >
                        </div>
                    </div>
                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">hari_t</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->hari_t }}" name="hari_t"
                             value="{{ $tugas->hari_t }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">jam_t</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->jam_t }}" name="jam_t"
                             value="{{ $tugas->jam_t }}" >
                        </div>
                    </div>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">no_ruang</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->no_ruang }}" name="no_ruang"
                             value="{{ $tugas->no_ruang }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">nm_mtk</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->nm_mtk }}" name="nm_mtk"
                             value="{{ $tugas->nm_mtk }}" >
                        </div>
                    </div>
                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">kd_mtk</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->kd_mtk }}" name="kd_mtk"
                             value="{{ $tugas->kd_mtk }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">sks</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->sks }}" name="sks"
                             value="{{ $tugas->sks }}" >
                        </div>
                    </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">sksajar</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->sksajar }}" name="sksajar"
                             value="{{ $tugas->sksajar }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">sks</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->sks }}" name="sks"
                             value="{{ $tugas->sks }}" >
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">mulai</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->mulai }}" name="mulai"
                             value="{{ $tugas->mulai }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">selesai</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->selesai }}" name="selesai"
                             value="{{ $tugas->selesai }}" >
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">selesai_interval</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->selesai_interval }}" name="selesai_interval"
                             value="{{ $tugas->selesai_interval }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">kd_gabung</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->kd_gabung }}" name="kd_gabung"
                             value="{{ $tugas->kd_gabung }}" >
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">jml_pertemuan</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->jml_pertemuan }}" name="jml_pertemuan"
                             value="{{ $tugas->jml_pertemuan }}" >
                        </div>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">nm_dosen</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->nm_dosen }}" name="nm_dosen"
                             value="{{ $tugas->nm_dosen }}" >
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