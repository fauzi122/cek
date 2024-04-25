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
                        <a href="" class="" style="padding-top: 10px;"><i class="icon-user1"></i>  User Dosen & Staff Administrasi</a>
                    </div>
                
                    <div class="card-body">
                        {{--  <form action="/lecturer/users" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    
                                    <input type="text" class="form-control" name="q"
                                           placeholder="cari berdasarkan nip dosen">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>  --}}
                        <div class="table-responsive">
                            {{--  <table class="table custom-table">  --}}
                             <table id="copy-print-csv" class="table custom-table">
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
                                    @foreach ($userdosen as $no => $dosen)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no}}</th>
                                        <td>{{ $dosen->username }}</td>
                                        <td>{{ $dosen->name }}</td>
                                        <td>{{ $dosen->kode }}</td>
                                        <td>{{ $dosen->email }}</td>
                                           
                                        
                                        <td class="text-center">
                                             @can('userdosen_adm.edit') 
                                            <a href="/lecturer/edit/{{ $dosen->id }}" class="btn btn-sm btn-info">
                                                <i class="icon-pencil" title="edit"></i>
                                            </a>
                                            {{--  <input data-id="{{$dosen->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $dosen->kondisi ? 'checked' : '' }}>  --}}
                                             @endcan 
                                            
                                          
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--  <div style="text-align: center">
                                {{$userdosen->links("vendor.pagination.bootstrap-4")}}
                            </div>  --}}
                            
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
           var id_dosen = $(this).data('id');  
           $.ajax({ 
    
               type: "POST", 
               dataType: "json", 
               url: '/status/update', 
               data: {'status': status, 'id_dosen': id_dosen}, 
               success: function(data){ 
               console.log(data.success) 
            } 
         }); 
      }) 
   }); 
</script>
@endpush