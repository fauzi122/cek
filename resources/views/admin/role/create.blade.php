@extends('layouts.dosen.main')

@section('content')

<div class="table-container">
    <div class="t-header"> Form Edit Role

    </div>
    <div class="card-body">
                        <form action="/role" method="POST" enctype="multipart/form-data">
                            @csrf
    
                            <div class="form-group">
                                <label>NAMA ROLE</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Role"
                                    class="form-control @error('title') is-invalid @enderror">
    
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
    
                            <div class="form-group">
                                <label class="font-weight-bold">PERMISSIONS</label>
                                <br>
                                @foreach ($permissions as $permission)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="check-{{ $permission->id }}">
                                    <label class="form-check-label" for="check-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
    
                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                SIMPAN</button>
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