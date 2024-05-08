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
							<div class="card-header badge-info">
							
								<h4 class="m-b-0 text-white">
									
									REKAPITULASI BAP ALL KAMPUS</h4>
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
                            
							<div class="table-container">
                                <form action="/cari/rekap-bap" method="GET">
									<table class="table custom-table">
										<tr>
											<td>KD Dosen</td>
											<td><input type="text" name="kd_dosen" placeholder="Masukkan Kode Dosen" class="nilai form-control"></td>
										</tr>
										<tr>
											<td>KEL-UJIAN</td>
											<td>
												<input type="text" name="kel_ujian" placeholder="Masukkan Kelompok Ujian Mahasiswa" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td>Kampus</td>
                                        
                                                <td>
                                                    <select class="nilai form-control select2" name="no_ruang">
                                                        <option value="">--Pilih Kampus--</option> <!-- Opsi ini harus di luar loop -->
                                                        @foreach ($kampus as $kampus)
                                                            <option value="{{ $kampus->kd_kampus }}">{{ $kampus->nm_kampus }} - {{ $kampus->kd_kampus }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                         
                                  
										</tr>
                                        <tr>
											<td>Tanggal Ujian</td>
											<td>
												<input type="date" name="tgl_ujian" placeholder="Masukkan tgl ujian" class="nilai form-control">
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align: right;">
												<em style="text-align: left;">Catatan: Anda dapat mengisi salah satu atau semua kriteria pencarian yang tersedia.</em>
												<button type="submit" class="btn btn-info">Cari Data BAP</button>
											</td>
										</tr>
									</table>
								</form>
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
                                                <th>no</th>
                                                <th>dosen</th>
                                                <th>mtk</th>
                                                <th>kel-ujian</th>
                                                <th>ruang</th>
                                                <th>paket</th>
                                                <th>hari</th>
                                                <th>tgl_ujian</th>
                                                <th>isi bap</th>
                                                <th>sts</th>
                                                <th>ot</th>
                                                <th>kampus</th>

                                               
											</tr>
										</thead>
										<tbody>
											 @foreach ($result as $no => $jadwal)
											<tr>
											
										
											 <td>{{$loop->iteration}}</td>
											 <td>{{ $jadwal->kd_dosen }}</td>
                                             <td>{{ $jadwal->kd_mtk }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
											 <td>{{ $jadwal->hari }}</td>
											 <td>{{ $jadwal->tgl_ujian }}</td>
											 <td>{{ $jadwal->isi }}</td>
											 <td>
                                            </button>
											@if ($jadwal->verifikasi == 1)
											<span class='badge badge-pill badge-light'><h6>Ujian Lancar</h6></span>
										@elseif ($jadwal->verifikasi == 2)
											<span class='badge badge-pill badge-secondary'><h6>Ujian Bermasalah</h6></span>
										@else
                                        @endif
                                            </td>
											 <td>{{ $jadwal->ot }}</td>
											 <td>{{ $jadwal->nm_kampus }}</td>
											
											

											</tr>
											@endforeach 
										</tbody>
						    	</table>
								</div>
							</div>

						


						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->


			</div>
@endsection
