
@extends('layouts.mhs.main')

@section('content')
<div class="main-container">

  <!-- Row start -->

<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    
    <div class="nav-tabs-container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
           aria-selected="true" ><i class="icon-list"> Data Penugasan</i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" 
          aria-selected="false"><i class="icon-activity"> Data Nilai Tugas</i></a>
        </li>
        <li class="nav-item">
          {{-- <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a> --}}
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        {{-- list tugas --}}
          <p>
           
            <div class="table-responsive">
              <table id="copy-print-csv" class="table custom-table">
                <thead>
                  <tr>
                    <th>No</th>
                    
                    <th>Kode Mtk</th>
                    <th>Kelas</th>
                    <th>Judul</th>
                    <th>Des</th>
                    <th>Pertemuan</th>       
                    <th>Mulai</th>
                    <th>Selsai</th>
                    <th>created</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
    
                @foreach ($tugasmhs as $no => $tugas)
                    
                  <tr>
                    <td>{{++$no}}</td>
                    
                    <td>{{$tugas->kd_mtk}}</td>
                    <td>{{$tugas->kd_lokal}}</td>
                    <td>{{$tugas->judul}}</td>
                    <td class="readmore" style="text-align: justify">{{$tugas->deskripsi}}</td>
                  
                    <td><center class="btn btn-info"> {{$tugas->pertemuan}}</class=></td>
                    <td>{{$tugas->mulai}}</td>
                    <td>{{$tugas->selsai}}</td>
                    <td>{{$tugas->created_at}}</td>
                    <td>
                    
                     
    
                      <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Pilih
                        </button>
                        <div class="dropdown-menu">
                         
                          @if (isset($tugas->file))
                          <form action="/download-file-tugas" method="post">
                              @csrf
                              <input type="hidden" name="id" value="{{$id}}">
                              <input type="hidden" name="file" value="{{$tugas->file}}">
                              <center><button type="submit" class="btn btn-info btn-rounded btn-sm"> Unduh</button>
                          </form>  
                          @endif
                          <p>
                          </p>
                           @php
                              
                          $id=Crypt::encryptString($tugas->kd_lokal.','.$tugas->kd_mtk.','.$tugas->pertemuan.','.$tugas->id);                                    
                          @endphp
                            <a href="/assignment/send/{{ $id }}" class=" btn btn-success"> Kerjakan</a>
                        
                                  <div class="dropdown-divider"></div>
                     
    
                        </div>
                      </div>
                    </td>
                  </tr>
    
                  @endforeach
              
                </tbody>
              </table>
            </div>
          


        </div>




        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <p>
            <div class="table-responsive">
              <table id="copy-print-csv" class="table custom-table">
                <thead>
                  <tr>
                    <th>No</th>
                    
                    <th>Kode Mtk</th>
                    
                    <th>Judul</th>
                    
                    <th>Link Tugas</th>       
                    <th>Komentar Dosen</th>
                    <th>Nilai</th>
                    <th>created</th>
                    <th>updated</th>
                  </tr>
                </thead>
                <tbody>
    
                @foreach ($nilaitugas as $no => $nilai)
                    
                  <tr>
                    <td>{{++$no}}</td>
                    <td>{{$nilai->kd_mtk}}</td>
                    <td>{{$nilai->judul}}</td>
                    <td><a href="{{$nilai->isi}}">{{$nilai->isi}}</a> </td>
                    <td>{{$nilai->komentar}}</td>
                    <td><h4>{{$nilai->nilai}}</h4></td>
                    <td>{{$nilai->created_at}}</td>
                    <td>{{$nilai->updated_at}}</td>
                    
                  </tr>
    
                  @endforeach
              
                </tbody>
              </table>
            </div>
          </p>


          </p>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <p>
            The best Bootstrap admin template you should be able to find a suitable user for your project. Wafi Admin Store is a modern Bootstrap4 admin template and UI framework. It is fully responsive built using, HTML5, CSS3 and jQuery.
     
 

</div>
       
      </div>

    </div>
  </div>
  <!-- Row end -->

</div>

@endsection
@push('scripts')
		<script>
			$(document).ready(function () {
    $(".readmore").expander({
          slicePoint : 50,
          expandText: 'More',
          userCollapseText : 'Less'
    });
}); 
		</script>
		
	@endpush