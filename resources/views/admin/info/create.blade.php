@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="table-container">
                    <div class="t-header"> Form Add Pengumuman

                    </div>
                    <div class="card-body">
                        
                        <form action="/information" method="POST" enctype="multipart/form-data">
                            @csrf
    
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" value="{{ old('title') }}" 
                                placeholder="Masukkan title"
                                class="form-control @error('title') is-invalid @enderror">
    
                                @error('title')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>File</label>
                                <input type="file" name="file" value="{{ old('file') }}" placeholder="Masukkan Nama User"
                                class="form-control @error('file') is-invalid @enderror">
    
                                @error('file')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            
                        
                         
                            
    
                            
                            <button class="btn btn-info mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                SIMPAN</button>
                            <button class="btn btn-secondary btn-reset" type="reset"><i class="fa fa-redo"></i> BATAL</button>
    
                        </form>
                            
                        </div>
                    </div>
                </div>
            </div>
      

</div>

    </section>


    @endsection