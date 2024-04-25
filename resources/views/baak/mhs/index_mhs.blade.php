@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="table-container"> 
                    <div class="t-header">
                        <a href="" class="" style="padding-top: 10px;"><i class="icon-user-check"></i>  Data User Mahasiswa</a>
                    </div>
                
                    <div class="card-body">
                        <br>
                <h5>
                    *Catatan: Pencarian dapat di lakukan salah satu saja contoh *hanya NIM/KELAS
                </h5>
                <p>
                    <form action="/search/users-mhs" method="GET">
                        <table class="table custom-table">
                            <tr>
                                <td>NIM</td>
                                <td>
                                    <input type="number" name="username" placeholder="Masukkan Nim" class="nilai form-control"></td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>
                                    <input type="text" name="kode" placeholder="Masukkan Kelas" class="nilai form-control"></td>

                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" style="text-align: right;">
                                    <button type="submit" class="btn btn-info">Cari Data User</button><br>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                        {{-- <form action="/std/users/baak" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    
                                    <input type="text" class="form-control" name="q"
                                           placeholder="cari berdasarkan nim mahasiswa">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col" style="width: 15%">NIP</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">KODE</th>
                                    <th scope="col">EMAIL</th>
                                    <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usermhs as $no => $dosen)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no + ($usermhs->currentPage()-1) * $usermhs->perPage() }}</th>
                                        <td>{{ $dosen->username }}</td>
                                        <td>{{ $dosen->name }}</td>
                                        <td>{{ $dosen->kode }}</td>
                                        <td>{{ $dosen->email }}</td>
                                        <td class="text-center">
                                             @can('userdosen_adm.edit') 
                                            <a href="/std/edit/baak/{{ $dosen->id }}" class="btn btn-sm btn-info">
                                                <i class="icon-pencil" title="edit"></i>
                                            </a>
                                            <input data-id="{{$dosen->id}}" data-nama="{{$dosen->name }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Sample" data-off="InSample" {{ $dosen->two_password==true ? 'checked' : '' }}> 
                                             @endcan 
                                            
                                          
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: center">
                                {{$usermhs->links("vendor.pagination.bootstrap-4")}}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
    
@push('scripts')
<script>
   $(function() { 
          $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
           $('.toggle-class').change(function() { 
           var status = $(this).prop('checked') == true ? 1 : 0;
           var id_user = $(this).data('id');  
           var name = $(this).data('nama'); 
           $.ajax({ 
               type: "POST", 
               dataType: "json", 
               url: '/std/users/baak', 
               data: {'status': status, 'id_user': id_user, 'name': name}, 
               success: function(data){ 
               console.log(data.success) 
            } 
         }); 
      }) 
   }); 
</script>
@endpush