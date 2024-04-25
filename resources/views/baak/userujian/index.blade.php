@extends('layouts.dosen.main')

@section('content')
<div class="card-body">
                    <div class="table-container">                       
                        <div class="t-header">
                            <div class="callout callout-danger">
                                <h4>Form User Ujian</h4>
                
                                <p> *Data Yang ditampilkan dan diupload hanya kondisi tertentu atau selain dari kondisi 1 =>>
                                    <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/tes user ujian.xlsx') }}"
                                        class="btn btn-info btn-sm">
                                        Unduh Format File<a></label>
                                </p>
                              </div>
                           <h4> </h4>
                           <form action="/user1" method="post" enctype="multipart/form-data">
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
                                
                                <p class="text-danger">{{ $errors->first('file') }}</p>

                                <input type="file" class="btn btn-primary" name="file">
                           
                                <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                            </div>
                            @endcan 
                        </form>
                        @can('temu_baak.delete') 

                        <form action="/user/tran" method="POST">
                            @csrf
                            <button class="btn btn-secondary btn-lg" type="submit">
                                <i class="icon-delete"></i> Kosongkan User Ujian </button>  
                        </form>
                        @endcan 
                          
                        @can('temu_baak.singkron') 
                        <p></p>
                        <form action="/user/singkron" method="POST">
                            @csrf
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="icon-loader"></i> Singkron User Ujian </button>   
                       
                        </form>
                        @endcan 

                        </div>
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      <th>Nama</th>
                                      <th>NIM</th>
                                      <th>Kelas</th>
                                      <th>Email</th>
                                      <th>Email Sudah Tersedia</th>
                                      <th>NIM Sudah Tersedia</th>
                                      <th>Kondisi</th>
                                      {{--  <th>Aksi</th>  --}}
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    @foreach ($userujian as $user )
                                  <tr>
                                   
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->kode }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->email_user }}</td>
                                    <td>{{ $user->no_induk }}</td>
                                    <td>{{ $user->kondisi }}</td>
                                    {{--  <td>  --}}
                                    {{--  <a href=""class="btn btn-info btn-sm"><i class="icon-pencil"></i> Edit</a>  --}}
                                    {{--  <a href=""class="btn btn-secondary btn-sm"><i class="icon-trash"></i> Hapus</a>  --}}
                                    {{--  <form action="{{ route('userujian.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                </form>  --}}
                                    {{--  </td>  --}}

                                </tr>
                                @endforeach
                                </tbody>
                               
                        </table>

                    @if ($duplicate)
                      <h3>  Ada data yang duplikat. Nama: 
                        {{ $duplicate->email }}, Jumlah: {{ $duplicate->count }}</h3>
                    @else
                       <h3> Tidak ada data duplikat.</h3>
                    @endif

                        </div>
                    </div>
                </div>
                  
 
    @endsection
 
