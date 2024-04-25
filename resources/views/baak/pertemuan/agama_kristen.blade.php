@extends('layouts.dosen.main')

@section('content')
<div class="card-body">


          
                    <div class="table-container">
                        
                        <div class="t-header">
                           <h4> Form Pertemuan Dosen Agama Kristen</h4>
                           <form action="/agamakristen1" method="post" enctype="multipart/form-data">
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
                            @can('temu_baak.upload') 
                            <div class="form-group">
                                <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/temuagama.xlsx') }}"
                                    class="btn btn-info btn-sm">
                                    Unduh Format File<a></label> 
                                       
                                <p class="text-danger">{{ $errors->first('file') }}</p>
                                      
                                <input type="file" class="btn btn-primary" name="file">
                           
                                <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                            </div>
                            @endcan 
                        </form>
                        @can('temu_baak.delete') 

                        <form action="/agamakristen/tran" method="POST">
                            @csrf
                            <button class="btn btn-secondary btn-lg" type="submit">
                                <i class="icon-delete"></i> Kosongkan Pertemuan Agama Kristen</button>  
                        </form>
                        @endcan 
                          
                        @can('temu_baak.singkron') 
                        <p></p>
                        <form action="/agamakristen/singkron" method="POST">
                            @csrf
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="icon-loader"></i> Singkron Jadwal </button>   
                       
                        </form>
                        @endcan 

                        </div>
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      
                                      <th>Kode Dosen</th>
                                      <th>Kode MTK</th>
                                      <th>Jam</th>
                                      <th>Hari</th>
                                      <th>Ruang</th>
                                      <th>Kelas</th>
                                      <th>SKS</th>
                                      <th>Kode Gabung</th>
                                      <th>Aksi</th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agamak as $no => $dosen)
                                    <tr>
                                       
                                       
                                        <td>{{ $dosen->kd_dosen }}</td>
                                        <td>{{ $dosen->kd_mtk }}</td>
                                        <td>{{ $dosen->jam_t }}</td>
                                        <td>{{ $dosen->hari_t }}</td>
                                        <td>{{ $dosen->no_ruang }}</td>
                                        <td>{{ $dosen->kd_lokal }}</td>
                                        <td>{{ $dosen->sksajar }}</td>
                                        <td>{{ $dosen->kd_gabung }}</td>
                                           
                                        
                                        <td class="text-center">
                                             {{-- @can('userdosen_adm.edit')  --}}
                                            <a href="/agamak/edit/{{ $dosen->id }}" class="btn btn-sm btn-info">
                                                <i class="icon-pencil" title="edit"></i>
                                            </a>
                                             {{-- @endcan  --}}
                                            
                                          
                                        </td>
                                    </tr>
                                @endforeach
                                    
                                </tbody>
                        </table>
                        </div>
                    </div>
                </div>
           
 
    @endsection
   