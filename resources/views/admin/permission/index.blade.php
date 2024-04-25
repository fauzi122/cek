@extends('layouts.dosen.main')
{{--  @extends('layouts.dosen.baak.main')  --}}
@section('content')

        <div class="card-body">
                    <div class="table-container">
                        <div class="t-header">
                            @can('permissions.index') 
                            <a href="{{url('/permission/create') }}" class="ti-pencil" title="add new"> 
                            <i class="icon-plus"></i> </a>
                            @endcan 
                            List Permissions

                        </div>
                        <div class="table-responsive">
                            <table id="myTable1" class="table custom-table">
                                <thead>
                                    <tr>
                                      <th>Id</th>
                                      <th>Position</th>
                                      <th>Guard</th>
                                      
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $no => $permission)
                                    <tr>
                                      <td>{{ ++$no}}</td>
                                      <td>{{ $permission->name }}</td>
                                      <td>{{ $permission->guard_name }}</td>
                                      
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
   