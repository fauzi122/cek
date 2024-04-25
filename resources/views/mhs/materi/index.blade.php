@extends('layouts.mhs.main')

@section('content')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
<div class="main-container">

  <!-- Row start -->
  <div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

      <div class="nav-tabs-container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
              <i class="icon-add-to-list"> Materi Tambahan</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
              <i class="icon-video"> Video Pembelajaran</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
              <i class="icon-download-cloud"> Slide Pembelajaran</i></a>
          </li>



        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

            <p>



            <div class="table-responsive">
              <h4>
                {{ $slidemhs->nm_mtk }} -
                {{ $slidemhs->kd_mtk }}
              </h4>
              <hr>
              <table id="copy-print-csv" class="table custom-table">
                <thead>
                  <tr>
                    <th>No</th>

                    <th>Kode Mtk</th>
                    <th>Kelas</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th align="center">File</th>
                    <th>Update</th>

                  </tr>
                </thead>
                <tbody>

                  @foreach ($materimhs as $no => $materi)

                  <tr>
                    <td>{{++$no}}</td>

                    <td>{{$materi->kd_mtk}}</td>
                    <td>{{$materi->kd_lokal}}</td>
                    <td>{{$materi->judul}}</td>
                    <td>{{$materi->deskripsi}}</td>
                    <td>
                      @if (isset($materi->file))
                      <form action="/download-file-materi" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="file" value="{{$materi->file}}">
                        <center><button type="submit" class="btn btn-info btn-rounded btn-sm"><i class="icon-download"></i> Unduh</button></center>
                      </form>
                      @endif
                    </td>
                    <td>{{$materi->created_at}}</td>

                  </tr>

                  @endforeach

                </tbody>
              </table>
            </div>
          </div>

          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p>
            <div class="row gutters">
              @foreach ($videomhs as $no => $video)
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="pricing-plan">

                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$video->link_code}}"></iframe>
                  </div>
                  <div class="card-body">
                    <h5 class="styled"> {{$video->title_video}}</h5>


                    {{$video->created_at}}


                  </div>
                  <div class="pricing-footer">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scrollingModalLong">
                      Lihat Deskripsi
                    </button>


                  </div>
                </div>
              </div>

              @endforeach

              </p>
            </div>
          </div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <p>

            <div class="content-wrapper">
              <div class="documents-header">

              </div>
              <hr>
              {{-- <!-- Row start -->
                <div class="row gutters">
                
                  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}"
              "alt="Doc Icon" />
            </div>

            <div class="doc-title">Silabus</div>
            <a href="" class="btn btn-primary btn-lg">Download</a>

          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            <div class="doc-title">RPS</div>
            <a href="{{ Storage::url('public/modul/RPS Sosiologi Komunikasi.pdf') }}" class="btn btn-primary btn-lg">Download</a>

          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            <div class="doc-title">Slide</div>
            <a href="{{ Storage::url('public/modul/Slide Sosiologi Komunikasi.zip') }}" class="btn btn-primary btn-lg">Download</a>

          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            <div class="doc-title">Modul</div>
            <a href="" class="btn btn-primary btn-lg">Download</a>

          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            <div class="doc-title">RTM</div>
            <a href="{{ Storage::url('public/modul/RTM Sosiologi Komunikasi.pdf') }}" class="btn btn-primary btn-lg">Download</a>

          </div>
        </div>



      </div> --}}


      <div class="row gutters">

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            @php
            $kd_lokal=Auth::user()->kode;
            $data = file_get_contents("http://students.bsi.ac.id/mahasiswa/api-azis_{$kd_lokal}_{$slidemhs->kd_mtk}_{$slidemhs->hari_t}.html");
            $xxx=json_decode($data,TRUE);
            @endphp
            <div class="doc-title">Silabus</div>
            <a href="http://students.bsi.ac.id/mahasiswa/silabus/{{$xxx['kd_gbg']}}.zip" class="btn btn-primary btn-lg">Download</a>
            {{-- <a href="" class="btn btn-primary btn-lg">Download</a>  --}}

          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>

            <div class="doc-title">RPS</div>
            <a href="http://students.bsi.ac.id/mahasiswa/silabus/sap/{{$xxx['kd_gbg']}}.zip" class="btn btn-primary btn-lg">Download</a>
            {{-- <a href="" class="btn btn-primary btn-lg">Download</a>  --}}
          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            <div class="doc-title">Slide</div>
            <a href="http://students.bsi.ac.id/mahasiswa/silabus/zip/{{ $slidemhs->kd_mtk }}.zip" class="btn btn-primary btn-lg">Download</a>

          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            <div class="doc-title">Modul</div>
            <a href="http://students.bsi.ac.id/mahasiswa/silabus/modul/{{ $slidemhs->kd_mtk }}.zip" class="btn btn-primary btn-lg">Download</a>

          </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="doc-block">
            <div class="doc-icon">

              <img src="{{ Storage::url('public/zip.svg') }}" "alt=" Doc Icon" />
            </div>
            <div class="doc-title">RTM</div>
            <a href="http://students.bsi.ac.id/mahasiswa/silabus/LTM/{{$xxx['kd_gbg']}}.zip" class="btn btn-primary btn-lg">Download</a>
            {{-- <a href="" class="btn btn-primary btn-lg">Download</a>  --}}

          </div>
        </div>



      </div>
    </div>
    </p>
  </div>
</div>
</div>

</div>

</div>

<!-- Row end -->





</div>

@endsection