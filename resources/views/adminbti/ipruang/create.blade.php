@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="table-container">
                    <div class="t-header"> Form Add IP Ruang

                    </div>
                    <div class="card-body">
                        
                        <form action="/ip-ruang" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>NO Ruang</label>
                                <input type="text" name="no_ruang" value="{{ old('no_ruang') }}" placeholder="Masukkan No Ruang"
                                class="form-control @error('no_ruang') is-invalid @enderror">
    
                                @error('no_ruang')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                               <div class="form-group">
                                <label>Kapasitas</label>
                                <input type="text" name="kapasitas" value="{{ old('kapasitas') }}" 
                                placeholder="Masukkan kapasitas"
                                class="form-control @error('kapasitas') is-invalid @enderror">
    
                                @error('kapasitas')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{--  <div class="form-group">
                                <label>Network ID</label>
                                <input type="text" name="network_id" value="{{ old('network_id') }}" placeholder="Masukkan network id"
                                class="form-control @error('network_id') is-invalid @enderror">
    
                                @error('network_id')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>IP Address</label>
                                <input type="text" name="ip_address" value="{{ old('ip_address') }}" placeholder="Masukkan ip_address"
                                    class="form-control @error('ip_address') is-invalid @enderror">
    
                                @error('ip_address')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>  --}}
{{--      
                           <div class="form-group">
                                <label>IP Address 2</label>
                                <input type="text" name="ip_address_2" value="{{ old('ip_address_2') }}" placeholder="Masukkan ip_address_2"
                                    class="form-control @error('ip_address_2') is-invalid @enderror">
    
                                @error('ip_address_2')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>  --}}


                            <button class="btn btn-info mr-1 btn-submit" type="submit"><i class="icon-save"></i>
                                SIMPAN IP RUANG</button>
                            <button class="btn btn-secondary btn-reset" type="reset"><i class="icon-cancel"></i> BATAL</button>
    
                        </form> 
                            
                        </div>
                    </div>
                </div>
            </div>
      

</div>

    </section>


    @endsection