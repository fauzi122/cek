@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
      <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" >TAMBAH TUGAS - {{ $tugas->nm_mtk }}</h5>
               
                   
                </button>
            </div>
            <div class="modal-body">
           
                <form class="row gutters" action="/tugas" method="POST" enctype="multipart/form-data">
            
                  @csrf

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Nip</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ Auth::user()->username }}" name="nip"
                             value="{{ Auth::user()->username }}" readonly>
                        </div>

                       
                           
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ Auth::user()->kode }}" name="kd_dosen"
                             value="{{ Auth::user()->kode }}" readonly hidden>
                       
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="docTitle">Kode Matakuliah</label>
                            <input type="text" class="form-control" id="docTitle" 
                            placeholder="{{ $tugas->kd_mtk }}" name="kd_mtk"
                             value="{{ $tugas->kd_mtk }}" readonly>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label for="dovType">Tanggal Mulai</label>
                            {{-- <input type="datetime-local" class="form-control" id="dovType" placeholder="" name="mulai" > --}}
                            <div class="custom-date-input">
                              <input type="text" name="tgl_mulai" class="form-control datepicker-date-format2" placeholder="dddd, dd mmm, yyyy">
                          </div>
                        </div>
                    </div>
                      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label for="as">Waktu Mulai</label>
                            {{-- <input type="datetime-local" class="form-control" id="dovType" placeholder="" name="mulai" > --}}
                              <input type="text" name="jam_mulai" class="form-control" placeholder="HH-MM-SS" id="time-formatting1" />
                        </div>
                    </div>
                   
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                      <div class="form-group">
                          <label for="dovType">Tanggal Selesai</label>
                          {{-- <input type="datetime-local" class="form-control" id="dovType" placeholder="" name="selsai" > --}}
                          <div class="custom-date-input">
                            <input type="text" name="tgl_selsai" class="form-control datepicker-date-format2" placeholder="dddd, dd mmm, yyyy">
                        </div>
                      </div>
                  </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                      <div class="form-group">
                          <label for="as">Waktu Selsai</label>
                          {{-- <input type="datetime-local" class="form-control" id="dovType" placeholder="" name="selsai" > --}}
                            <input type="text" name="jam_selsai" class="form-control" placeholder="HH-MM-SS" id="time-formatting" />
                      </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Pertemuan <i class="fas fa-keycdn    "></i></label>
                        <select class="form-control selectpicker" name="pertemuan">
                            <optgroup label="Pertemuan Pengajaran">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                            </optgroup>
                         
                        </select>
                    </div>
                </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="dovType">Kode Lokal</label>
                        @if ($tugas->kd_gabung<>'')
                        <input type="text" class="form-control" id="dovType"
                        placeholder="{{ $tugas->kd_gabung }}" value="{{ $tugas->kd_gabung }}" 
                        name="kd_lokal" readonly>
                        @elseif($tugas->kel_praktek<>'')
                        <input type="text" class="form-control" id="dovType"
                        placeholder="{{ $tugas->kd_lokal }}" value="{{ $tugas->kd_lokal }}" 
                        name="kd_lokal" readonly>
                        @else
                        <input type="text" class="form-control" id="dovType"
                         placeholder="{{ $tugas->kd_lokal }}" value="{{ $tugas->kd_lokal }}" 
                         name="kd_lokal" readonly>
                        @endif
                        
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group">
                      <label for="dovType">File</label>
                      <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>

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
                            <textarea class="form-control content @error('judul') is-invalid @enderror" name="judul" placeholder="Masukkan Judul Tugas" rows="2">{{ old('judul') }}</textarea>
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
                          <textarea class="form-control content @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Masukkan deskripsi Tugas" rows="5">{{ old('deskripsi') }}</textarea>
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