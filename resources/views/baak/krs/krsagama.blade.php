@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="table-container"> 
                    <div class="t-header">
                       
                           <h4> Data Mahasiswa Agama Non Muslim.</h4>


                           <form action="/krs/agama-kristen1" method="post" enctype="multipart/form-data">
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
                
                            <div class="form-group">
                                <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/penilaian agama.xlsx') }}"
                                    class="btn btn-info btn-sm">
                                    Unduh Format File<a></label>
                                <p class="text-danger">{{ $errors->first('file') }}</p>

                                <input type="file" class="btn btn-primary" name="file">
                           
                                <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                            </div>
                        </form>
                        <p>
                         
                        <form action="/krs/agama-kristen/singkron" method="POST">
                            @csrf
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="icon-loader"></i> Singkron Data </button>   
                       
                        </form>
                        <P></P>
                        <form action="/krs/agama-kristen/tran" method="POST">
                            @csrf
                            <button class="btn btn-secondary btn-lg" type="submit">
                                <i class="icon-delete"></i> Kosongkan Data </button>   
                       
                        </form>
                        
</div>
                        <div class="table-responsive">
                              <table id="copy-print-csv" class="table custom-table">
                                <thead>
                                <tr>
                                   
                                    <th scope="col" style="width: 15%">NIM</th>
                                    
                                    <th scope="col">KD MTK</th>
                                   
                                   
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($krsmhsagama as $no => $dosen)
                                    <tr>
                                        
                                        <td>{{ $dosen->nim }}</td>
                                        <td>{{ $dosen->kd_mtk }}</td>
                                       

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                         
                            
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection