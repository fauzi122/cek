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
                                            <h4 class="m-b-0 text-white">Form Edit Waktu Ujian</h4>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $id = Crypt::encryptString($wkt_ujian->kel_ujian.','.$wkt_ujian->tgl_ujian.','.$wkt_ujian->hari_ujian.','.$wkt_ujian->paket);
                                                @endphp
                                            <form action="{{ url('/update-time-setting/' . $id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT') <!-- Gunakan directive ini untuk simulasi method PUT di Laravel -->
                                        
                                                <div class="form-group">
                                                    <label>Kelompok Ujian</label>
                                                    <div>
                                                        <input type="radio" id="kel_ujian_a" name="kel_ujian" value="A" {{ $wkt_ujian->kel_ujian == 'A' ? 'checked' : '' }}>
                                                        <label for="kel_ujian_a">A</label>
                                                        <input type="radio" id="kel_ujian_b" name="kel_ujian" value="B" {{ $wkt_ujian->kel_ujian == 'B' ? 'checked' : '' }}>
                                                        <label for="kel_ujian_b">B</label>
                                                    </div>
                                                </div>
                                        
                                                <div class="form-group">
                                                    <label for="tgl_ujian">Tanggal Ujian</label>
                                                    <input type="date" class="form-control" id="tgl_ujian" name="tgl_ujian" value="{{ $wkt_ujian->tgl_ujian }}" required>
                                                </div>
                                        
                                                <div class="form-group">
                                                    <label for="hari_ujian">Hari Ujian</label>
                                                    <input type="text" class="form-control" id="hari_ujian" name="hari_ujian" value="{{ $wkt_ujian->hari_ujian }}" required>
                                                    <input type="hidden" class="form-control" id="hari_ujian" name="paket" value="{{ $wkt_ujian->paket }}" required>
                                                </div>
                                        
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" {{ $wkt_ujian->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ $wkt_ujian->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                    </select>
                                                </div>
                                        
                                                <button type="submit" class="btn btn-primary mr-1 btn-submit"><i class="fa fa-paper-plane"></i> SAVE</button>
                                                <button type="reset" class="btn btn-warning btn-reset"><i class="fa fa-redo"></i> RESET</button>
                                            </form>
                                        </div>
                                        
                                        
                                               
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
