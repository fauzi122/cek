@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
  <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
  <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

      <div class="card-header badge-primary">

        <h4 class="m-b-0 text-white">List Pembelajaran dan Tes TOEFL</h4>
      </div>
      <div class="table-container ">
        <div class="">
          <h4>
          @can('toef.jadwal') 
            <a href="/toef-create"><button class="btn btn-primary btn-lg"><i class="icon-add"> </i> Jadwal Pembelajaran dan Tes </button></a>
           @endcan
            <a href="{{ Storage::url('public/Panduan Kuis MyBest Dosen.pdf') }}" target="_blank" class="btn btn-info btn-lg">
              <i class="icon-file-text"></i>
              Panduan
            </a>
          </h4>
          <hr>
        </div>

        <div class="table-responsive">
          <table id="copy-print-csv" class="table custom-table">
            <thead>
              <tr>
                <th><center>No</center></th>
                <th>Kode Mtk</th>

                <th>Paket</th>

                <th>KKM</th>
                <th>Waktu</th>
                <th><center>Soal</center></th>
                <th><center>Jml</center></th>
                <th>Tanggal Ujian Mulai</th>
                <th>Tanggal Ujian Selsai</th>
                <th>Created</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($soals as $no => $soal)
              @php
              $id=Crypt::encryptString($soal->id.','.$soal->kd_mtk);
              @endphp
              <tr>
                <td><center>{{ ++$no }}</center></td>
                <td><b>{{ $soal->kd_mtk }}</b> - {{ $soal->nm_mtk }}</td>

                <td>{{ $soal->paket }}</td>
                <td>{{ $soal->kkm }}</td>
                <td>{{ $soal->waktu }} menit</td>
                <td><span class='badge badge-pill badge-light'>{{ isset($detailsoal[$soal->id])?$detailsoal[$soal->id]:'0' }} soal </span></td>
                <td><span class='badge badge-pill badge-light'>{{ $soal->jml_soal }} soal </span></td>
                <td>{{ $soal->tgl_ujian }}</td>
                <td>{{ $soal->tgl_selsai_ujian }}</td>
                <td>{{ $soal->kd_dosen }}</td>
                <td>

                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Menu
                    </button>
                    <div class="dropdown-menu">
                       @can('toef.jadwal.edit') 
                      <a class="dropdown-item" href="/edit-jadwal/toef/{{ $id }}">Edit Jadwal</a>
                      @endcan
                       @can('toef.jadwal.show') 
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="/toef-soal-show/{{ $id }}">Master Soal</a>
                     @endcan   
                        <center>
                        <div class="dropdown-divider"></div>
                         @if (isset($soal->file_path))
                      <form action="/download-materi-toef" method="post">
                          @csrf
                          <input type="hidden" name="id" value="{{$soal->id_materi}}">
                          <input type="hidden" name="file" value="{{$soal->file_path}}">
                          <button type="submit" class="btn btn-info btn-rounded btn-sm"> Unduh Materi</button>
                      </form>  
                      @endif 
                      </center>
                    </div>
                  </div>

                  <!-- Button to trigger the modal -->
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModal{{ $soal->id }}">Upload Materi</button>

                  <!-- Modal for uploading materi -->
                  <div class="modal fade" id="uploadModal{{ $soal->id }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="uploadModalLabel">Upload Materi</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="{{ route('toef.materi.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_soal" value="{{ $soal->id }}">
                            <!-- Other input fields for the upload form -->
                            <div class="form-group">
                              <label for="judul">Judul Materi</label>
                              <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="form-group">
                              <label for="file">Pilih File</label>
                              <input type="file" class="form-control-file" id="file" name="file" required accept=".pdf,.doc,.docx">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                              <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                          </form>
                          <h4>Catatan: File yang diunggah harus berformat PDF, DOC, atau DOCX dengan ukuran maksimal 2MB.</h4>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Button to trigger the download -->
                  {{--  <a href="" class="btn btn-success btn-sm">{{$soal->id_materi}}Unduh</a>  --}}
             
                </td>

              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
  <!-- Row end -->
</div>

@endsection
