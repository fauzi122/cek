@extends('layouts.dosen.main')

@section('content')
<div class="card-body">

    <div class="table-container">
                        
        <div class="t-header">
          <form action="/mhs1" method="post" enctype="multipart/form-data">
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

                <label for=""><h4>Upload Data Mahasiswa</h4>* File (.xls, .xlsx)</label>
                <p class="text-danger">{{ $errors->first('file') }}</p>
                <input type="file" class="btn btn-primary" name="file" >
                <button class="btn btn-info btn-lg"><i class="icon-upload"> Upload</i></button>
            </div>
        </form>
        </div>
                        <div class="table-responsive">
                            <table id="tbl_list" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      <th>NIM</th>
                                      <th>Nama</th>
                                      <th>Jen Kel</th>
                                      <th>Agama</th>
                                      <th>tgl Lahir</th>
                                       <th>Telp</th>
                                      <th>Kd jrs</th>
                                      <th>Kelas</th>
                                      
                                      
                                   
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
         ajax: '{{ secure_url('/mhs/json') }}',
         columns: [
            { data: 'nim', name: 'nim' },
            { data: 'nm_mhs', name: 'nm_mhs' },
            { data: 'jns_kel', name: 'jns_kel' },
            { data: 'agm', name: 'agm' },
            { data: 'tgl_lhr', name: 'tgl_lhr' },
            { data: 'tlpn', name: 'tlpn' },
            { data: 'kd_jrs', name: 'kd_jrs' },
            { data: 'kd_lokal', name: 'kd_lokal' }
            
			
         ]
     });
  });
</script>
@endpush