@extends('layouts.dosen.main')
@section('content')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="main-container">
    <div class="table-container"> 
        <div class="t-header">
            <a href="" class="" style="padding-top: 10px;"><i class="icon-documents"> </i>Rekap Ajar Praktek</a>
        </div>
  <div class="card-body">
    {{-- <form action="/lecturer/p/rekap" method="GET">
        <div class="form-group">
            <div class="input-group mb-3">
          
                <input type="text" class="form-control" name="q"
                       placeholder="cari berdasarkan kode dosen">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                    </button>
                </div>
            </div>
        </div>
    </form> --}}
    <div class="table-responsive">
        <table id="myTable2" class="table custom-table">
            <thead>
            <tr>
                
                <th scope="col" style="width: 10%">NIP</th>
               
                <th scope="col">KEL PRAKTEK</th>
                <th scope="col">SKS</th>
                <th scope="col">Kode MTK</th>
                <th scope="col">TANGGAL</th>
                <th scope="col">JAM MASUK</th>
                <th scope="col">JAM KELUAR</th>
                <th scope="col">NO RUANG</th>
                <th scope="col">PERTEMUAN</th>
                <th scope="col">Catatan Kaprodi</th>
          
                
            </tr>
            </thead>
            <tbody>
                @foreach ($rekapajar_p as $role)
                <tr>
                    
                    <td>{{ $role->nip }} 
                    <b> {{ $role->kd_dosen }}</b>
                    </td>
                   
                    <td>{{ $role->kel_praktek }}</td>
                    <td>{{ $role->sks }}</td>
                    <td>{{ $role->nm_mtk }} - <b>{{ $role->kd_mtk }}</b></td>
                    <td>{{ $role->tgl_ajar_masuk }}</td>
                    <td><h5>{{ $role->jam_masuk }}</h5></td>
                    <td><h5>{{ $role->jam_keluar }}</h5></td>
                    <td>{{ $role->no_ruang }}</td>
                    <td><h5>{{ $role->pertemuan }}</h5></td>
                    <td>@if ($role->hasil_prodi=='Y')
                        <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="bottom" data-content="{{ $role->isi_prodi }} - ({{ $role->nama_log }})">
                            Sesuai
                        </button>
                        @elseif($role->hasil_prodi=='T')
                        @php
                        $id=Crypt::encryptString($role->kel_praktek.','.$role->kd_mtk.','.$role->pertemuan);
                        @endphp
                        <a href="/lecturer/p/{{$id}}" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="{{ $role->isi_prodi }} - ({{ $role->nama_log }})" target="blank">Tidak Sesuai</a>
                        {{-- <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="{{ $role->isi_prodi }} - ({{ $role->nama_log }})">
                            Tidak Sesuai
                        </button> --}}
                        @else
                        @endif
                    </td>
                  
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center">
            {{-- {{$rekapajar_p->links("vendor.pagination.bootstrap-4")}} --}}
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
   $('#myTable2').DataTable({
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

 $(document).ready(function () {
    $(".readmore").expander({
          slicePoint : 20,
          expandText: 'More',
          userCollapseText : 'Less'
    });
}); 
  </script>
@endpush

@endsection

    