	@extends('layouts.dosen.ujian.main')

@section('content')
	
				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row starts -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Hari Ujian</div>
								</div>
								<div class="card-body">
									
									<!-- Row starts -->
									<div class="row gutters">
										<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
											<div class="goal-card">
												<h5>Senin </h5>
												<p class="percentage">sesi ujian</p>
												<div class="progress progress-dot">
													<div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<h4>{{ $senin }}</h4>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
											<div class="goal-card">
												<h5>Selasa</h5>
												<p class="percentage">sesi ujian</p>
												<div class="progress progress-dot">
													<div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<h4>{{ $selasa }}</h4>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
											<div class="goal-card">
												<h5>Rabu</h5>
												<p class="percentage">sesi ujian</p>
												<div class="progress progress-dot">
													<div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="107" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<h4>{{ $rabu }}</h4>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
											<div class="goal-card">
												<h5>Kamis</h5>
												<p class="percentage">sesi ujian</p>
												<div class="progress progress-dot">
													<div class="progress-bar" role="progressbar" style="width: 93%" aria-valuenow="93" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<h4>{{ $kamis }}</h4>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
											<div class="goal-card">
												<h5>Jumat</h5>
												<p class="percentage">sesi ujian</p>
												<div class="progress progress-dot">
													<div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<h4>{{ $jumat }}</h4>
											</div>
										</div>
										<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
											<div class="goal-card">
												<h5>Sabtu</h5>
												<p class="percentage">sesi ujian</p>
												<div class="progress progress-dot">
													<div class="progress-bar" role="progressbar" style="width: 99%" aria-valuenow="99" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<h4>{{ $sabtu }}</h4>
											</div>
										</div>
									</div>
									<!-- Row ends -->

								</div>
							</div>
						</div>
					</div>
					<!-- Row ends -->

					<!-- Row starts -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card h-350">
								<div class="card-header">
									<div class="card-title">Jadwal Ujian Semua kampus </div>
								</div>
								<div class="card-body">
									<div class="table-container">
										<div class="t-header">Jadwal Ujian</div>
										<div class="table-responsive">
											<table id="copy-print-csv" class="table custom-table">
												<thead>
													<tr>
													  
													  <th>NIP</th>
													  <th>kd</th>
													  <th>NM_Matakuliah</th>
													  <th>kd MTK</th>
													  <th>Kelas</th>
													  <th>Hari</th>
													  <th>mulai</th>
													  <th>selsai</th>
													  <th>Ruang</th>
													  <th>paket</th>
													  <th>tanggal</th>
													  {{-- <th>jml soal</th> --}}
													  {{-- <th>Aksi</th> --}}
													</tr>
												</thead>
												<tbody>
													@foreach ($jadwal as $no => $jadwal)
													<tr>
													
													 <td>
														{{ $jadwal->nip }}
														
													 </td>
													 <td>{{ $jadwal->kd_dosen }}</td>
													 <td>{{ $jadwal->nm_mtk }}</td>
													 <td>{{ $jadwal->kd_mtk }}</td>
													 <td>{{ $jadwal->kd_lokal }}</td>
													 <td>{{ $jadwal->hari_t }}</td>
													 <td><h5>{{ $jadwal->mulai }}</h5></td>
													 <td><h5>{{ $jadwal->selesai }}</h5></td>
													 <td>{{ $jadwal->no_ruang }}</td>
													 <td>{{ $jadwal->paket }}</td>
													 <td>{{ $jadwal->tgl_ujian }}</td>
													 {{-- <td>{{ $jadwal->jml_soal }}</td> --}}
													 {{-- <td>
														<a href="" class="btn btn-xs btn-info">show</a>
													 </td> --}}
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
				<!-- Content wrapper end -->

		
@endsection
