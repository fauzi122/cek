@extends('layouts.dosen.main')


@section('content')
                    <div class="table-container">
                        <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
                        <div class="flash-error" data-flasherror="{{ session('error') }}"></div>          
                        <div class="t-header">
                            {{-- @can('users.create') 
                            <a href="/user/create" class="icon-plus"> </a> 
                             @endcan  --}}
                            List User Staff
                           
                        </div>
                        <div class="table-responsive">
                            <table id="myTable2" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th><center>Departemen</center></th>
                                        <th>email</th>
                                        <th>Akses Level</th>
                                        <th>Action</th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $no => $user)
                                    <tr>
                                        <td>{{ ++$no}}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td><center>{{ $user->kode }} </center></td>
                                        <td>{{ $user->email }} </td>
                                        
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $role)
                                            <h5><label class="badge badge-primary">{{ $role }}</label></h5>
                                            @endforeach
                                        @endif

                                        </td>
                                        <td>
                                             @can('users.edit') 
                                            <a href="/user/edit/{{ $user->id }}" class="btn btn-sm btn-info">
                                                <i class="icon-pencil" title="edit"></i>
                                            </a>
                                          

                                             {{-- {{ route('admin.user.edit', $user->id) }}   --}}
                                         @endcan 
                                        
                                        @can('users.delete')
                                        <form name="form1" id="form1" action="/hapus-user/{{$user->id}}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary"><i class="icon-trash" title="Hapus"></i></button>
                                          </form>
                                        @endcan

                                        
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
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
               </script>
           @endpush
           
    @endsection
    