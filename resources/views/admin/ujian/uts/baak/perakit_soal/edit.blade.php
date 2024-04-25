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
                                            <h4 class="m-b-0 text-white">Form Panitia Ujian</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="/adm-panitia-uji" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                               
                                                <div class="form-group">
                                                    
                                                 
                                                    
                    
                                                </div>
                    
                                                <div class="form-group">
                                                    
                                                    <label>Kode Dosen</label>
                                                    <input type="text" name="kode"
                                                        placeholder="Masukkan Nama User"
                                                        class="form-control @error('kode') is-invalid @enderror">
                        
                                                    @error('kode')
                                                    <div class="invalid-feedback" style="display: block">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                    
                                                    
                                                </div>

                                                
                        
                                                <div class="form-group">
                                                    <label>Panitia</label>
                                                    <select class="form-control select2" name="jenis" style="width: 100%;">
                           
                                                                     
                                                        <option value="1" selected>Kordinator</option>
                                                        <option value="2" selected>Persensi</option>
                                                        <option value="3" selected>Panitia</option>
                                                        
                            
                                                      
                                                      </select>
                                                   
                                                </div>

                                                <div class="form-group">
                                                    <label>Lokasi Kampus</label>
                                                    <select class="form-control select2" name="kampus" style="width: 100%;">
                           
                                                       @foreach ($kampus as $kampus)              
                                                        <option value="{{$kampus->nm_kampus}}" selected><b> {{$kampus->kd_kampus}} - </b>{{$kampus->nm_kampus}}</option>
                                                     
                                                         @endforeach
                            
                                                      
                                                      </select>
                                                   
                                                </div>
                                              
                        
                                                
                        
                                                <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                                                    SAVE</button>
                                                <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                        
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
