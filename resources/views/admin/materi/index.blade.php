
@extends('layouts.dosen.main')

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
             <i class="icon-list"> Materi Pembelajaran </i></a>
          </li>

           <li class="nav-item">
            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home1" role="tab" aria-controls="home1" aria-selected="false">
             <i class="icon-folder">  </i> Sekapur Sirih</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
              <i class="icon-video"> Video Pembelajaran</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
              <i class="icon-download-cloud"> Bahan Pembelajaran</i></a>
          </li>
        
        </ul>
        <div class="tab-content" id="myTabContent">

   {{--  materi tambahan  --}}

          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
           
      
            <p>
          
              <h4>
                      <a href="{{url('/materi-create/'.$id) }}"><button class="btn btn-primary btn-lg"  ><i class="icon-add"> </i> Tambah Materi</button></a>
              </h4>
                    <div class="table-responsive">
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
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
            
                        @foreach ($materi as $no => $materi)
                            
                          <tr>
                            <td>{{++$no}}</td>
                          
                            <td>{{$materi->kd_mtk}}</td>
                            <td>{{$materi->kd_lokal}}</td>
                            <td ><p class="readmore1">{{$materi->judul}}</p></td>
                            <td><p style="text-align: justify;" class="readmore">{{$materi->deskripsi}}</p></td>
                            <td>
                              @if (isset($materi->file))
                              <form action="/download-file-ajarr" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <input type="hidden" name="file" value="{{$materi->file}}">
                                <center><button type="submit" class="btn btn-info btn-rounded"><i class="icon-download"></i> Unduh</button></center>
                            </form>   
                              @endif
                            </td>
                            <td>{{$materi->created_at}}</td>
                            <td>
                                <button onClick="Delete(this.id)" class="btn btn-secondary" id="{{$materi->id}},materi"><i class="icon-trash" title="Hapus"></i></button>
                            </td>
                          </tr>
            
                          @endforeach
                      
                        </tbody>
                      </table>
                    </div>
                  
                    
            </p>
          </div>

          {{-- sapaan    --}}
           <div class="tab-pane fade" id="home1" role="tabpanel" aria-labelledby="home1-tab">
           
      
            <p>
          
              <h4>
                      <a href="{{url('/spa-create/'.$id) }}"><button class="btn btn-primary btn-lg"  ><i class="icon-add"> </i> Tambah Sekapur Sirih </button></a>
              </h4>
                    <div class="table-responsive">
                      <table id="copy-print-csv" class="table custom-table">
                        <thead>
                          <tr>
                            <th>No</th>
                            
                            <th>Kode Mtk</th>
                            <th>Kelas</th>
                            <th>Biodata</th>
                            <th>Deskripsi</th>
                            <th>File</th>
                            <th>Created</th>
                            {{--  <th>Aksi</th>  --}}
                           
                          
                          </tr>
                        </thead>
                        <tbody>
            
                        @foreach ($sapaan as $no => $sapa)
                            
                          <tr>
                           <td>{{++$no}}</td>
                           <td>{{$sapa->kd_mtk}}</td>
                           <td>{{$sapa->kd_lokal}}</td>
                           <td>{{$sapa->judul}}</td>
                           <td>{{$sapa->deskripsi}}</td>
                           <td>
                              @if (isset($sapa->file))
                              <form action="/download-file-sapa" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <input type="hidden" name="file" value="{{$sapa->file}}">
                                <center><button type="submit" class="btn btn-info btn-rounded"><i class="icon-download"></i> Unduh</button></center>
                            </form>   
                              @endif
                            </td>
                           <td>{{$sapa->created_at}}</td>
                          {{--  <td>
                                <button onClick="Delete(this.id)" class="btn btn-secondary" id="{{$sapa->id}},materi"><i class="icon-trash" title="Hapus"></i></button>
                            </td>  --}}
                          </tr>
            
                          @endforeach
                      
                        </tbody>
                      </table>
                    </div>
                  
                    
            </p>
          </div>

{{--  and materi tambahan  --}}

 {{--  start video pembelajaran  --}}

          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <p>
            <h4>
               
			     <a href="{{url('/video-create/'.$id) }}"><button class="btn btn-primary btn-lg"  ><i class="icon-add"> </i> Tambah Video</button></a>
      </h4>
      <div class="row gutters">    
            @foreach ($video as $no => $video)
            <div class="col-lg-4 col-md-4 col-sm-12">
              {{-- <div class="pricing-plan">
                
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$video->link_code}}"></iframe>
                </div>
                <div class="card-body">
                  <h5 class="styled"> {{$video->title_video}}</h5>
                  <hr>
                 
                 <div class="card-sub-title">{{$video->created_at}}</div>
                  
                  
               
                </div>
                <div class="pricing-footer">

                  

                </div>
              </div> --}}
              <div class="card-deck">
								<div class="card">
									<div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$video->link_code}}"></iframe>
                  </div>
									<div class="card-body">
										<h5 class="card-title readmore1">{{$video->title_video}}</h5>
										<p class="card-text readmore">{{$video->des}}</p>
										<p class="card-text">
											<i class="icon-clock"></i> <small class="text-muted">{{$video->created_at}}</small>
										</p>
                    <center>
                    <button onClick="Delete(this.id)" class="btn btn-secondary" id="{{$video->id}},video"><i class="icon-trash" title="Hapus"></i></button>
                    
                  </center>
									</div>
								</div>
            </div>
            </div>
    
            @endforeach 
          </p>        
          </div>       
      </div>

   {{--  and video pembelajaran  --}}

       
 <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <p>
              
              <div class="content-wrapper">
                <div class="documents-header">
                  <h4>
                  {{ $slide->nm_mtk }} -
                  {{ $slide->kd_mtk }}
                  </h4>
                   </div>
               
                   <hr>
                <!-- Row start -->
                <div class="row gutters">
                
                  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
            
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                @php
                   
                    $data = file_get_contents("http://staff.bsi.ac.id/api-azis_{$slide->kd_dosen}_{$slide->jam_t}_{$slide->hari_t}.html"); 
                    $xxx=json_decode($data,TRUE);  
                @endphp
                      <div class="doc-title">Silabus</div>
                      <a href="http://staff.bsi.ac.id/silabus/{{$xxx['kd_gbg']}}.zip" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>

                   <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">RPS</div>
                      <a href="http://staff.bsi.ac.id/sap/{{$xxx['kd_gbg']}}.zip" class="btn btn-primary btn-lg">Download</a>
                    </div>
                  </div>

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">Slide</div>
                      <a href="http://staff.bsi.ac.id/slide/{{ $slide->kd_mtk }}.zip" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>
                 
                   <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">Modul</div>
                      <a href="http://staff.bsi.ac.id/modul/{{ $slide->kd_mtk }}.zip" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">RTM</div>
                      <a href="http://staff.bsi.ac.id/ltm/{{$xxx['kd_gbg']}}.zip" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>

                

                </div>
              </div>
              
            </p>
          </div>  
          
        </div>
      </div>

    </div>
   
 
 
  <!-- Row end -->

@endsection
@push('scripts')
  <script>
    $(document).ready(function () {
  $(".readmore").expander({
        slicePoint : 50,
        expandText: 'More',
        userCollapseText : 'Less'
  });
  $(".readmore1").expander({
        slicePoint : 20,
        expandText: 'More',
        userCollapseText : 'Less'
  });
}); 
  </script>

<script>
//ajax delete
function Delete(id)
{
  var id = id;
  var token = $("meta[name='csrf-token']").attr("content");
  var explode = id.split(",");
  if (explode[1]=='materi') {
    var link = "{{ url('/hapus-materi') }}"+'/'+explode[0];
  } else {
    var link = "{{ url('/hapus-video') }}"+'/'+explode[0];
  }
  // console.log(explode[0]);
   Swal.fire({
    title: 'Yakin akan dihapus?',
    text: "Data yang telah dihapus tidak bisa dikembalikan.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(function(result) {
    // console.log(Swal.DismissReason);
    if (result.dismiss) {

      return true;

    } else {
  console.log(link);
    
      //ajax delete
      jQuery.ajax({
        url: link,
        data: 	{
          "id": explode[0],
          "_token": token
        },
        type: 'DELETE',
        success: function (response) {
          if (response.status == "success") {
            Swal.fire({
              title: 'BERHASIL!',
              text: 'DATA BERHASIL DIHAPUS!',
              type: 'success',
              timer: 1000,
              showConfirmButton: false,
              showCancelButton: false,
              buttons: false,
            }).then(function() {
              location.reload();
            });
          }else{
              Swal.fire({
              title: 'GAGAL!',
              text: 'DATA GAGAL DIHAPUS!',
              type: 'error',
              timer: 1000,
              showConfirmButton: false,
              showCancelButton: false,
              buttons: false,
            }).then(function() {
              location.reload();
            });
          }
        }
      });
    }
  })
}
</script> 
@endpush