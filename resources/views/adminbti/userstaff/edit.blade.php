@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-danger">
                        <h4 class="m-b-0 text-white">
                        <i class="icon-pencil"></i>
                        Form Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form action="/update/lecturer-data/{{ $user->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                
                               {{--  <h3> {{ old('name', $user->username) }} - 
                                    {{ old('name', $user->kode) }} </h3>  --}}
                                

                            </div>

                            <div class="form-group">
                                
                                <label>NAME USER</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    placeholder="Masukkan Nama User"
                                    class="form-control @error('name') is-invalid @enderror">
    
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

                                
                            </div>
                              <div class="form-group">
                                
                                <label>NIP USER</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                    placeholder="Masukkan Nama User"
                                    class="form-control @error('username') is-invalid @enderror">
    
                                @error('username')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

                                
                            </div>
                              <div class="form-group">
                                
                                <label>AKRONIM USER</label>
                                <input type="text" name="kode" value="{{ old('kode', $user->kode) }}"
                                    placeholder="Masukkan Nama User"
                                    class="form-control @error('kode') is-invalid @enderror" readonly>
    
                                @error('kode')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror

                                
                            </div>
    
                            <div class="form-group">
                                <label>EMAIL</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    placeholder="Masukkan Nama User"
                                    class="form-control @error('email') is-invalid @enderror">
    
                                @error('email')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                               
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PASSWORD</label>
                                        <input type="password" name="password" value="{{ old('password') }}"
                                            placeholder="Masukkan Password"
                                            class="form-control @error('password') is-invalid @enderror">
    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>PASSWORD</label>
                                        <input type="password" name="password_confirmation"
                                            value="{{ old('password_confirmation') }}"
                                            placeholder="Masukkan Konfirmasi Password" class="form-control">
                                    </div>
                                </div>
                            </div>
    
                         
    
                            <button class="btn btn-info mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                UPDATE USER</button>
                         
                        </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>


   
    @endsection