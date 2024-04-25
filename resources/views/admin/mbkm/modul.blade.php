
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
            <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
              <i class="icon-download-cloud"> Modul Pembelajaran</i></a>
              
          </li>
            {{--  <li class="nav-item">
            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home1" role="tab" aria-controls="home1" aria-selected="false">
             <i class="icon-folder">  </i>Rencana Pembelajaran Semester (RPS)</a>
          </li>  --}}
        
        </ul>
        <div class="tab-content" id="myTabContent">

   {{--  and video pembelajaran  --}}

           <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <p>
              
              <div class="content-wrapper">
               
                   <hr>
                <!-- Row start -->
                <div class="row gutters">
                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
            
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title text-center">Materi Metode Kuantitatif</div>
                      {{--  <a href="{{ Storage::url('public/modul/106-Pendidikan Kewarganegaraan-20220824T042018Z-001.zip') }}" class="btn btn-primary btn-lg">Download</a>  --}}
                      <a href="{{ Storage::url('public/modul/mbkm_mhs/Materi Metode Kuantitatif.zip') }}" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>

                   <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">Slide Studi Kelayakan Bisnis - PDK</div>
                      {{--  <a href="{{ Storage::url('public/modul/154-Character Building-20220824T042047Z-001.zip') }}" class="btn btn-primary btn-lg">Download</a>  --}}
                      <a href="{{ Storage::url('public/modul/mbkm_mhs/Slide Studi Kelayakan Bisnis - PDK.zip') }}" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>
                  

                </div>
              </div>
              
            </p>
          {{--  </div> 

                <div class="tab-pane fade" id="home1" role="tabpanel" aria-labelledby="home1-tab">
           
      
            <p>
          
             <div class="content-wrapper">
               
                   <hr>
                <!-- Row start -->
                <div class="row gutters">
                
                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
            
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title text-center">Pendidikan Kewarganegaraan</div>
                      <a href="{{ Storage::url('public/modul/106-Pendidikan Kewarganegaraan-20220824T042018Z-001.zip') }}" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>

                   <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">Character Building</div>
                      <a href="{{ Storage::url('public/modul/154-Character Building-20220824T042047Z-001.zip') }}" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">Sosiologi Komunikasi</div>
                      <a href="{{ Storage::url('public/modul/278-Sosiologi Komunikasi-20220824T042056Z-001.zip') }}" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>
                 
                   <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="doc-block">
                      <div class="doc-icon">
                
                        <img src="{{ Storage::url('public/zip.svg') }}" 
                        "alt="Doc Icon" />
                      </div>
                      <div class="doc-title">Web Programming</div>
                      <a href="{{ Storage::url('public/modul/726-Web Programming-20220824T042100Z-001.zip') }}" class="btn btn-primary btn-lg">Download</a>
                     
                    </div>
                  </div>


                

                </div>
              </div>
                  
                  
                    
            </p>
          </div>    --}}

          
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