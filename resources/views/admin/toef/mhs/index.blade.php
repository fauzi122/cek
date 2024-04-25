@extends('layouts.dosen.main')

@section('content')
<div class="main-container">
  <!-- Flash messages -->
  <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
  <div class="flash-error" data-flasherror="{{ session('error') }}"></div>

  <div class="card-header badge-primary">
    <h4 class="m-b-0 text-white">List Mahasiswa</h4>
  </div>

  <div class="table-container">
    <div class="table-header">
      <h4>
      @can('toef.tambah.mhs') 
        <a href="/toef-create-mhs" class="btn btn-primary btn-lg"><i class="icon-add"></i> Tambah Data</a>
        <a href="" data-toggle="modal" data-target="#basicModal" class="btn btn-info btn-lg"><i class="icon-file-text"></i> Import Excel Data Mahasiswa</a>
      @endcan
      </h4>
      <hr>
    </div>
    <form action="/list-toef-mhs" method="GET">
      <div class="form-group">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="q" placeholder="cari berdasarkan nim mahasiswa">
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI</button>
          </div>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <!-- Student list table -->
      <table class="table custom-table">
        <thead>
          <tr>
            <th><center>No</center></th>                
            <th>NIM</th>               
            <th>Nama</th>
            <th>Kelas</th>       
            <th>Kode MTK</th>
            <th>Kode Dosen</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($usermhs as $no => $mhs)
          <tr>
            <td><center>{{ ++$no }}</center></td>                 
            <td>{{ $mhs->nim }}</td>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->kd_lokal }} </td>                
            <td>{{ $mhs->kd_mtk }}</td>
            <td>{{ $mhs->kd_dosen }}</td>
            <td>
            @can('toef.edit.hapus.mhs') 
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Menu
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('toefmhs.edit', $mhs->id) }}">Edit Data</a>
                  <div class="dropdown-divider"></div>
                  <form action="{{ route('toefmhs.destroy', $mhs->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item">Hapus</button>
                  </form>
                </div>
              </div> 
              @endcan                
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      
      <!-- Pagination links -->
      <div style="text-align: center">
        {{$usermhs->links("vendor.pagination.bootstrap-4")}}
      </div>      
    </div>

    <!-- Remove All button -->
    @can('toef.edit.hapus.mhs')
    <div class="text-center mt-4">
      <form action="/remove-all-mhs" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua data mahasiswa?')">
        @csrf
        <button type="submit" class="btn btn-danger"><i class="icon-trash"></i> Remove All</button>
      </form>
    </div>
    @endcan
    
  </div>
</div>

<!-- Import modal -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="basicModalLabel">Import Excel Data Mahasiswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/toef-upload-mhs" method="post" enctype="multipart/form-data" id="uploadForm">
          @csrf
          <label>File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/mhstoefl.xlsx') }}" class="btn btn-info btn-sm">Unduh Format File</a></label>
          <div class="form-group">
            <br>
            <p class="text-danger">{{ $errors->first('file') }}</p>
            <input type="file" class="btn btn-primary" name="file" id="fileInput">
            <button class="btn btn-info btn-lg" id="uploadBtn"><i class="icon-upload"></i> Upload</button>
          </div>
        </form>
        <hr>
        <label><h5>*Catatan:</h5> 
        <br>
        <h6>1. Upload data mahasiswa harus sesuai format excel yang tersedia.</h6>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('uploadBtn').addEventListener('click', function() {
    var fileInput = document.getElementById('fileInput');
    if (fileInput.files.length === 0) {
      return;
    }

    var form = document.getElementById('uploadForm');
    form.submit();

    // Refresh page after upload
    setTimeout(function() {
      location.reload();
    }, 2000); // Adjust the delay (in milliseconds) as needed
  });
</script>
@endsection
