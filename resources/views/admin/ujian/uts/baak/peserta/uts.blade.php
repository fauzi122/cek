@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">


				<!-- Page header start -->
				
				<!-- Page header end -->


				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							 <div class="card-header badge-success">
							
                                <h4 class="m-b-0 text-white">
								List Peserta Ujian </h4>
                            </div>
  					@if (session('success'))
                            <div class="alert alert-info">
                                {{ session('success') }}
                            </div>
                            @endif
                
                            @if (session('error'))
                                <div class="alert alert-info">
                                    {{ session('error') }}
                                </div>
                            @endif

							{{--  modal start  --}}
																<!-- Modal -->
									<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="basicModalLabel">Import Excel Peserta Ujian</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                         <form action="/upload-peserta-ujian" method="post" enctype="multipart/form-data">
                            @csrf
												  <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/soalpg.xlsx') }}"
                                        class="btn btn-info btn-sm">
                                        Unduh Format File<a></label>

                                         <div class="form-group">
                                
                                    {{--  <input type="number" hidden name="id_soal" value="{{ $soal->id }}">  --}}
                                      <br>
                                    {{--  <input type="text" hidden name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">  --}}
                           
                                <p class="text-danger">{{ $errors->first('file') }}</p>
                                <input type="file" class="btn btn-primary" name="file">                           
                              <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                                   
                            </div>
                        </form>

                            	<hr>
                           <label><h5>*Catatan :</h5> 
                           <br>
                          <h6> 1.Upload soal harus sesuai format excel yang tersedia.  

                           <br>
                           2.Soal yang di upload statusnya <span class='badge badge-pill badge-light'>TAMPIL</span></label> .
                          <br>
                           3.tidak dapat menyertakan  <span class='badge badge-pill badge-info'>Audio/Gambar</span> saat upload excel. </h6> 
												</div>
									
                    
											</div>
										</div>
									</div>
							{{--  modal and  --}}
							
						</div>

					</div>
					<!-- Row end -->
				<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="nav-tabs-container">
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Peserta Ujian ALL</a>
									</li>
									@can('peserta_ujian.singkron')
									<li class="nav-item">
										<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"> Data Peserta Ujian Tambahan</a>
									</li>
									@endcan
									{{--  <li class="nav-item">
										<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
									</li>  --}}
								</ul>
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
										<p>
										
											@can('peserta_ujian.singkron')
									<form action="/baak/pesertauji" method="POST">
										@csrf
										<button class="btn btn-info btn-lg" type="submit">
										<i class="icon-loader"></i>  Singkron Peserta Ujian </button>
									</form> 
									@endcan 
                                <br>
                                <form action="/baak/cari-peserta-ujian" method="GET">
									<table class="table custom-table">
										<tr>
											<td>NIM</td>
											<td><input type="text" name="nim" placeholder="Masukkan NIM Mahasiswa" class="nilai form-control"></td>
										</tr>
										<tr>
											<td>KELAS</td>
											<td>
												<input type="text" name="id_kelas" placeholder="Masukkan Kelas Mahasiswa" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td>KEL-UJIAN</td>
											<td>
												<input type="text" name="no_kel_ujn" placeholder="Masukkan Kelompok Ujian Mahasiswa" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align: right;">
												<button type="submit" class="btn btn-info">Cari Data Mahasiswa </button><br>
											</td>
										</tr>
									</table>
								</form>
								
											<div class="table-responsive">
									 <table class="table custom-table">
										<thead>
											<tr>
											  
											  <th>NIM</th>
											  <th>Nama</th>
											  <th>Kode MTK</th>
											  <th>Kelas</th>
											  <th>Kel-Ujian</th>
											  <th>paket</th>
											  <th>Kondisi</th>
											
											</tr>
										</thead>
										<tbody>
											@foreach ($peserta as $no => $p)
											<tr>
											
											
											 <td>{{ $p->nim }}</td>
											 <td>{{ $p->nm_mhs }}</td>
											 <td>{{ $p->kd_mtk }}</td>
											 <td>{{ $p->id_kelas }}</td>
											 <td>{{ $p->no_kel_ujn }}</td>
											 <td>{{ $p->paket }}</td>
											 <td>{{ $p->kondisi }}</td>
											
											</tr>
											@endforeach
										</tbody>
						    	</table>
                                    <div style="text-align: center">
                                    {{$peserta->links("vendor.pagination.bootstrap-4")}}
                                </div>
								</div>
										</p>
									</div>
									<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
										<p>
											@can('peserta_ujian.add')	
									<div class="btn-group">
										<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Action
										</button>
										<div class="dropdown-menu">

										<form action="/baak/pesertauji-tambahan" method="POST" class="dropdown-item">
										@csrf
										<button type="submit">
										<i class="icon-loader"></i>  Singkron Peserta </button>
										</form>
											
										
											<div class="dropdown-divider"></div>
											<center>
									<a href="/baak-peserta/destroy-all"
									onclick="return confirm('Are you sure?')"
									 class="btn btn-xs btn-secondary"> Hapus Peserta All<a>
											</center>
											
										</div>
									</div>
									@endcan
											 <table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>NIM</th>
											  <th>Nama</th>
											  <th>Kode MTK</th>
											  <th>Kelas</th>
											  <th>Kel-Ujian</th>
											  <th>Kondisi</th>
											  <th>Aksi</th>
											
											</tr>
										</thead>
										<tbody>
											@foreach ($peserta_upload as $no => $p)
											 
											<tr>
											
											
											 <td>{{ $p->nim }}</td>
											 <td>{{ $p->nm_mhs }}</td>
											 <td>{{ $p->kd_mtk }}</td>
											 <td>{{ $p->id_kelas }}</td>
											 <td>{{ $p->no_kel_ujn }}</td>
											 <td>{{ $p->kondisi }}</td>
											 <td>
											          <center>
										<form method="POST" class="d-inline"
										onsubmit="return confirm('Hapus Data?')" 
										action="/baak-peserta/{{ $p->id }}/destroy">
										@csrf
										<input type="hidden" value="DELETE" name="_method">
										<button type="submit" value="Delete" class="btn btn-xs btn-danger">
										<i class="fas fa-trash"></i> Hapus </button>
                        </form>
											
                                                </center>
											 </td>
											
											</tr>
											@endforeach
										</tbody>
						    	</table>
										</p>
									</div>
									<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
										<p>
											The best Bootstrap admin template you should be able to find a suitable user for your project. Wafi Admin Store is a modern Bootstrap4 admin template and UI framework. It is fully responsive built using, HTML5, CSS3 and jQuery.
										</p>
									</div>
								</div>
							</div>

						</div>
				</div>
				<!-- Content wrapper end -->


			</div>
@endsection
