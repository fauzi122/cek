@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="table-container">
                    <div class="t-header"> Form Add User Staff

                    </div>
                    <div class="card-body">
                        
                        <form action="/lecturer-data" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>NAME USER</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama User"
                                class="form-control @error('name') is-invalid @enderror">
    
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                               <div class="form-group">
                                <label>NIP USER</label>
                                <input type="text" name="username" value="{{ old('username') }}" 
                                placeholder="Masukkan username"
                                class="form-control @error('username') is-invalid @enderror">
    
                                @error('username')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>AKRONIM</label>
                                <input type="text" name="kode" value="{{ old('kode') }}" placeholder="Masukkan Nama User"
                                class="form-control @error('kode') is-invalid @enderror">
    
                                @error('kode')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                          
                         
                            <div class="form-group">
                                <label>EMAIL</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email"
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
                                        <input type="password" name="password" value="{{ old('password') }}" placeholder="Masukkan Password"
                                            class="form-control @error('password') is-invalid @enderror">
            
                                        @error('password')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                               
                            </div>


                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="icon-paper"></i>
                                SAVE USER</button>
                            <button class="btn btn-secondary btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
    
                        </form>
                            
                        </div>
                    </div>
                </div>
            </div>
      

</div>

    </section>


    @endsection