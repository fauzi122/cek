@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">


				<!-- Page header start -->
				
				<!-- Page header end -->


				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="page-wrapper">
                        <!-- ============================================================== -->
                        <!-- Container fluid  -->
                        <!-- ============================================================== -->
                        <div class="container-fluid">
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-primary">
                                            <h4 class="m-b-0 text-white">Form Input Matakuliah Ujian</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="/adm-panitia-uji" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                               
                                                <div class="form-group">
                                                    
                                                 
                                                    
                    
                                                </div>
                    
                                                {{-- <div class="form-group">
                                                    
                                                    <label>Prodi</label>
                                                    <input type="text" name="kode"
                                                        placeholder="Masukkan Nama User"
                                                        class="form-control @error('kode') is-invalid @enderror">
                        
                                                    @error('kode')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                    
                                                    
                                                </div> --}}

                                                
                        
                                                <div class="form-group">
                                                    <label>Matakuliah</label>
                                                    <select class="form-control select2" name="jenis" style="width: 100%;">
                           
                                                                     
                                                        <option value="1" selected>AKUNTANSI SEKTOR PUBLIK</option>
                                                        <option value="2" selected>PENGANGGARAN PERUSAHAAN</option>
                                                        <option value="3" selected>AUDITING</option>
                                                        
                            
                                                      
                                                      </select>
                                                   
                                                </div>
                                                 <div class="form-group">
                                                    <label>Jenis Ujian</label>
                                                    <select class="form-control select2" name="jenis" style="width: 100%;">
                           
                                                                     
                                                        <option value="1" selected>PG ONLINE</option>
                                                        <option value="2" selected>ESSAY ONLINE</option>
                                                        
                            
                                                      
                                                      </select>
                                                   
                                                </div>
                                                     <div class="form-group">
                                                    
                                                    <label>Jumlah Soal PG</label>
                                                    <input type="number" name="pg"
                                                        placeholder="Masukkan Nama User"
                                                        class="form-control @error('pg') is-invalid @enderror">
                        
                                                    @error('pg')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                    
                                                    
                                                </div>
                                                 <div class="form-group">
                                                    
                                                    <label>Jumlah Soal Essay</label>
                                                    <input type="number" name="essay"
                                                        placeholder="Masukkan Nama User"
                                                        class="form-control @error('essay') is-invalid @enderror">
                        
                                                    @error('essay')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                    
                                                    
                                                </div>

                                                <div class="form-group">
                                                    <label>Kode Matakuliah</label>
                                                    <select class="form-control select2" name="kampus" style="width: 100%;">
                           
                                                       @foreach ($mtk as $mtk)              
                                                        <option value="{{$mtk->kd_mtk}}" selected>{{$mtk->kd_mtk}}</option>
                                                     
                                                         @endforeach
                            
                                                      
                                                      </select>
                                                   
                                                </div>
                                              
                        
                                                
                        
                                                <button class="btn btn-info mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                                    SAVE</button>
                        
                                            </form>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>
@endsection
