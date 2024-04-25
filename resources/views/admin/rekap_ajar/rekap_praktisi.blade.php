
@extends('layouts.dosen.main')

@section('content')

<div class="main-container">
    <div class="table-container"> 
        <div class="t-header">
            <a href="" class="" style="padding-top: 10px;"><i class="icon-documents"> </i>Rekap Ajar Praktisi</a>
        </div>
  <div class="card-body">
    {{-- <form action="/lecturer/t/rekap" method="GET">
        <div class="form-group">
            <div class="input-group mb-3">
          
                <input type="text" class="form-control" name="q"
                       placeholder="cari berdasarkan kelas">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                    </button>
                </div>
            </div>
        </div>
    </form> --}}
    <div class="table-responsive">
        <table id="myTable1" class="table custom-table">
            <thead>
            <tr>
                
                <th scope="col" style="width: 10%">NIP</th>
                <th scope="col">KELAS</th>
                <th scope="col">SKS</th>
                <th scope="col">Kode MTK</th>
                <th scope="col">TANGGAL</th>
                <th scope="col">JAM MASUK</th>
                <th scope="col">NO RUANG</th>
                <th scope="col">Aksi</th>
                
          
                
            </tr>
            </thead>
            <tbody>
                @foreach ($rekapajar_praktisi as $role)
                <tr>
                    <td>{{ $role->nip }}
                        {{ $role->kd_dosen }}
                    </td>
                    <td>{{ $role->kd_lokal }}</td>
                    <td>{{ $role->sks }}</td>
                    <td>{{ $role->nm_mtk }} - <b>{{ $role->kd_mtk }}</b></td>
                    <td>{{ $role->tgl_ajar_masuk }}</td>
                    <td><h5>{{ $role->jam_masuk }}</h5></td>
                    <td>{{ $role->no_ruang }}</td>
                    <td>  
                        <a href="{{ url('/show/rekap-praktisi/'.Crypt::encryptString($role->id)) }}" type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Show Rekap"><i class="icon-eye"></i> Show
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center">
            {{-- {{$rekapajar_t->links("vendor.pagination.bootstrap-4")}} --}}
        </div>
        
    </div>
</div>
@push('scripts')
<script type="text/javascript">
$('.tombol-hapus').on('click',function(e){
e.preventDefault();
const href=$(this).attr('href');
Swal.fire({
title: 'Apakah anda yakin',
text: "Data akan dihapus",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Hapus Data!'
}).then((result) => {
if (result.value) {
  document.location.href=href;
  
}
})
});
$(document).ready(function () {
   $('#myTable1').DataTable({
    dom: 'Blfrtip',
                lengthMenu: [
                    [ 10, 25, 50, 10000 ],
                    [ '10', '25', '50', 'Show All' ]
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
  responsive: true
    });

 });
  </script>
@endpush

@endsection

    