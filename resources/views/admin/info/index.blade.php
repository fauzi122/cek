@extends('layouts.dosen.main')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

@section('content')
                    <div class="table-container">
                      
                        {{-- <center>
                       <h1> coming soon</h1>
                        </center> --}}

 <div class="t-header">
                            @can('info.create') 
                            <a href="/create/information" class="icon-plus"> </a> 
                             @endcan 
                           Data Pengumuman
                           
                        </div>
                        <div class="table-responsive">
                          <table id="copy-print-csv" class="table custom-table">
                            <thead>
                              <th>No</th>
                              <th>Judul</th>
                             
                              <th>Aksi</th>
                            </thead>
                            <tbody>
                              @foreach ($info as $no => $info)

                              
                              <tr>
                              <td>{{ ++$no}}</td>
                              <td> 

                                    @if (isset($info->file))
                      <form action="/download-file-pengumuman" method="post">
                          @csrf
                                  <h4 class="status text-info"> <i class="icon-file"></i>
                                      {{ $info->title }} </h4> {{ $info->created_at }}  <span class="badge badge-info badge-pill"></span>
                 
                          <input type="hidden" name="id" value="{{$info->id}}">
                          <input type="hidden" name="file" value="{{$info->file}}">
                          <button type="submit" class="btn btn-info btn-rounded btn-sm"> Unduh</button>
                         
                      </form>  
                      @endif 

                              </td>
                              
                              <td>
                              @can('info.create') 
                                <center>
                                  <button onClick="Delete(this.id)" class="btn btn-secondary" id="{{$info->id}}"><i class="icon-trash" title="Hapus"></i></button>
                              </center>
                               @endcan 
                              </td>
                            </tr>
                            @endforeach
                            </tbody>
                           </table>   
                    </div>  

                </div>
             </div>
           
    @endsection
    @push('script')
    <script>
      //ajax delete
      function Delete(id)
      {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");
       
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
        //console.log(link);
          
            //ajax delete
            jQuery.ajax({
              url: "{{ url('/information-destroy') }}"+'/'+id
              data: 	{
                "id": id,
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