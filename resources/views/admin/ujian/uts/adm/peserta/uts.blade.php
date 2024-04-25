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
								Administrasi - List Peserta Ujian </h4>
                            </div>

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
									{{-- <li class="nav-item">
										<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"> Data Peserta Ujian Berdasarkan Cabang</a>
									</li> --}}
									{{--  <li class="nav-item">
										<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
									</li>  --}}
								</ul>
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
{{-- 
								<h5>
									*Catatan: kode dosen dapat dikosongkan jika pencarian hanya ingin berdasarkan tanggal saja
								</h5> --}}
								<p>
									<form action="/adm/cari-peserta-ujian-uts" method="GET">
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
								</div>
                                {{-- <form action="/peserta-ujian-uts" method="GET">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                        
                                                <input type="text" class="form-control" name="q"
                                                    placeholder="Cari Berdasarkan NIM Mahasiswa">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI DATA
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form> --}}

											<div class="table-responsive">
									 <table class="table custom-table">
										<thead>
											<tr>
											  
											  <th>NO</th>
											  <th>NIM</th>
											  <th>Nama</th>
											  <th>Kode MTK</th>
											  <th>Kelas</th>
											  <th>Kel-Ujian</th>
											  <th>Kondisi</th>
											  <th>Jenis Ujian</th>
											
											</tr>
										</thead>
										<tbody>
											@foreach ($peserta as $no => $p)
											<tr>

											 <td>{{ $loop->iteration }}</td>
											 <td>{{ $p->nim }}</td>
											 <td>{{ $p->nm_mhs }}</td>
											 <td>{{ $p->kd_mtk }}</td>
											 <td>{{ $p->id_kelas }}</td>
											 <td>{{ $p->no_kel_ujn }}</td>
											 <td>{{ $p->kondisi }}</td>
											 <td>{{ $p->paket }}</td>
											
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
										
											 <table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											  <th>NO</th>
											  <th>Nama Kampus</th>
											  <th>Alamat Kampus</th>
											  <th>Kode Cabang</th>
											  <th>Aksi</th>
											
											</tr>
										</thead>
										<tbody>
											@foreach ($kampus as $no => $p)
											 
											<tr>
											
											 <td>{{ $loop->iteration }}</td>
											 <td>{{ $p->nm_kampus }}</td>
											 <td>{{ $p->alm_kampus }}</td>
											 <td>{{ $p->kd_cabang }}</td>
											 {{-- @php
												$id=Crypt::encryptString($p->kd_cabang);                                    
												@endphp --}}
											 <td><a href="/adm/lihat-peserta-ujian/{{ $p->kd_cabang }}" class="btn btn-xs btn-info">Lihat</a></td>

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
