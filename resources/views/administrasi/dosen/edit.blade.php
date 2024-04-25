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
                    <div class="card-header bg-primary">
                        <h4 class="m-b-0 text-white">Form Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form action="/lecturer/update/{{ $user->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                
                               <h3> {{ old('name', $user->username) }} - 
                                    {{ old('name', $user->kode) }} </h3>
                                

                            </div>

                            <div class="form-group">
                                
                                <label>NAMA USER</label>
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
                                <label>Email</label>
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
    
                            <div class="form-group">
                                {{--  <label class="font-weight-bold">ROLE</label>  --}}
                                <br>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="role[]" value="{{ $role->name }}" hidden
                                            id="check-{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="check-{{ $role->id }}" >
                                            
                                        </label>
                                    </div>
                                @endforeach
                            </div>
    
                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                UPDATE</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
    
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