
@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
  <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
  <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  

      <div class="table-container " >
       <div class="" > 
        <h4> 
		 
          <a href="{{url('tugas-create/'.$id) }}"><button class="btn btn-primary btn-lg"  ><i class="icon-add"> </i> Tambah Tugas</button></a>
          
      </h4>
      <hr>
      </div>
      
        <div class="table-responsive">
          <table id="copy-print-csv" class="table custom-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Mtk</th>
                <th>Kelas</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Pertemuan</th>       
                <th>Mulai</th>
                <th>Selsai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>

            @foreach ($tugas as $no => $tugas)
                
              <tr>
                <td>{{++$no}}</td>
                <td>{{$tugas->kd_mtk}}</td>
                <td>{{$tugas->kd_lokal}}</td>
                <td><p class="readmore1">{{$tugas->judul}}</p></td>
                <td><p style="text-align: justify;" class="readmore">{{$tugas->deskripsi}}</p></td>
                <td><center class="btn btn-info"> {{$tugas->pertemuan}}</class=></td>
                <td>{{$tugas->mulai}}</td>
                <td>{{$tugas->selsai}}</td>
                <td>
                
                 

                  <div class="btn-group">
										<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Pilih
										</button>
										<div class="dropdown-menu">
                    <center>
                      @php    
                       $show=Crypt::encryptString($tugas->id.','.$tugas->kd_lokal.','.$tugas->kd_mtk.','.$tugas->pertemuan);                                    
                      @endphp
                    <a href="/tugas-show/{{ $show }}" class=" btn btn-sm btn-dark"> Show</a>
                    <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{$tugas->id}}">Hapus</button>
                      @if (isset($tugas->file))
                      <form action="/download-file-tugas-dosen" method="post">
                          @csrf
                          <input type="hidden" name="id" value="{{$id}}">
                          <input type="hidden" name="file" value="{{$tugas->file}}">
                          <button type="submit" class="btn btn-info btn-rounded btn-sm"> Unduh</button>
                      </form>  
                      @endif 
                  </center>
										</div>
									</div>
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
@push('scripts')

		<script type="text/javascript">
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
    
      //ajax delete
      jQuery.ajax({
        url: "{{ url('/hapus-tugas') }}"+'/'+id,
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