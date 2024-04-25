@extends('layouts.dosen.main')

@section('content')

<div class="table-container">
    <div class="t-header"> Form Tambah Permission

    </div>
    <div class="card-body">
                        <form action="/permission" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>NAMA Permission</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Role"
                                    class="form-control @error('title') is-invalid @enderror">
    
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
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