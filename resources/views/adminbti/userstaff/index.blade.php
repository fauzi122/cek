@extends('layouts.dosen.main')

@section('content')
<div class="card-body">


          
                    <div class="table-container">
                        
                        <div class="t-header">
                            <div class="callout callout-danger">
                                <h4>Form User Staff</h4>
                
                                <p>* Isi Table ini boleh dihapus setelah disingkron
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
                                <i class="icon-delete"></i> Kosongkan User Staff </button>  
                        </form>
                        @endcan 
                          
                        @can('temu_baak.singkron') 
                        <p></p>
                        <form action="/user/singkron" method="POST">
                            @csrf
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="icon-loader"></i> Singkron User Staff </button>   
                       
                        </form>
                        @endcan 

                        </div>
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      <th>Nama</th>
                                      <th>NIP</th>
                                      <th>Akronim</th>
                                      <th>Email</th>
                                      <th>Email Sudah Tersedia</th>
                                      <th>Akronim Sudah Tersedia</th>
                                      <th>Kondisi</th>
                                    
                                  
                                       
                                   
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    @foreach ($userstaff as $user )
                                  <tr>
                                   
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->kode }}</td>
                                    
                                    <td>{{ $user->email }}</td>
                                    <td><b>{{ $user->email_user }}</b></td>
                                    <td><b>{{ $user->kode_dosen }}</b></td>
                                    <td>{{ $user->kondisi }}</td>

                                </tr>
                                @endforeach
                                </tbody>
                               
                        </table>
                        </div>
                    </div>
                </div>
                  
 
    @endsection
 
