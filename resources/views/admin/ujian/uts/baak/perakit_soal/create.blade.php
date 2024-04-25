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
                                            <h4 class="m-b-0 text-white">Form Perakit Soal Ujian</h4>
                                        </div>
                                        <div class="card-body">

                                            <form action="/adm-perakit-soal" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                </div>
                                                <div class="form-group">
                                                    <label>Kode Dosen</label>
                                                    <select class="form-control select2" name="kd_dosen" style="width: 100%;">
                                                        @foreach ($user as $user)
                                                            <option value="{{$user->kd_dosen}}">{{$user->kd_dosen}} - {{$user->nama}}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Matakuliah</label>
                                                    <input type="number" class="form-control select2" name="kd_mtk" style="width: 100%;">
                                                   
                                                </div>

                                                <div class="form-group">
                                                    <label>Jenis Ujian</label>
                                                    <select class="form-control select2" name="paket" style="width: 100%;">
            
                                                        <option value="UTS" selected>UTS</option>
                                                        <option value="UAS" selected>UAS</option>
                                                        <option value="HER" selected>HER</option>

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
