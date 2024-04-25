@extends('layouts.dosen.main')

@section('content')
<div class="card-body">


          <form action="/krs1" method="post" enctype="multipart/form-data">
            @csrf

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
                <div class="alert alert-success">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <label for="">File (.xls, .xlsx)</label>
                <input type="file" class="form-control" name="file">
                <p class="text-danger">{{ $errors->first('file') }}</p>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-sm">Upload</button>
            </div>
        </form>
                    <div class="table-container">
                        
                        <div class="t-header">
                           <h4> Form Pertemuan Dosen</h4>
                            <a href="{{ secure_url('/permission/create') }}" 
                            title="singkron" class="btn btn-info"> 
                            <i class="icon-loader"></i></a>

                            <a href="" 
                           title="upload" class="btn btn-secondary"data-toggle="modal" data-target="#basicModal"> 
                                <i class="icon-upload"></i></a>
                        
                            <a href=""
                            title="dowload" class="btn btn-primary"> 
                                <i class="icon-download-cloud"></i></a> 

                        </div>
                        <div class="table-responsive">
                            <table id="tbl_list" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      <th>NIM</th>
                                      <th>NO KRS</th>
                                      <th>Kode MTK</th>
                                      <th>Kel Praktek</th>
                                       {{-- <th>Ruang</th>
                                      <th>Kelas</th>
                                      <th>SKS</th>
                                      <th>Kode Gabung</th>  --}}
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                        </table>
                        </div>
                    </div>
                </div>
           
 
    @endsection
    @push('scripts')
<script type="text/javascript">
 $(document).ready(function () {
    $('#tbl_list').DataTable({
     dom: 'Blfrtip',
                 lengthMenu: [
                     [ 10, 25, 50, 10000 ],
                     [ '10', '25', '50', 'Show All' ]
                 ],
                 buttons: [
                     'copy', 'csv', 'excel', 'pdf', 'print',
                   
                 ],    
         paging: true,
         processing: true,
         serverSide: true,
         ajax: '{{ secure_url('/krs/json') }}',
         columns: [
            { data: 'nim', name: 'nim' },
            { data: 'no_krs', name: 'no_krs' },
            { data: 'kd_mtk', name: 'kd_mtk' },
            { data: 'kel_praktek', name: 'kel_praktek' }
			
         ]
     });
  });
</script>
@endpush