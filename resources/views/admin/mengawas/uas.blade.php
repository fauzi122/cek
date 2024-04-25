@extends('layouts.dosen.main')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

@section('content')
	<div class="main-container">


				<!-- Page header start -->
			
				<!-- Page header end -->


				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							

							<div class="table-container">
								<div class="t-header">Jadwal Mengawas Ujian</div>
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
											 
											  <th>NM MTK</th>
											  
											  <th>Kelas</th>
											  <th>Hari</th>
											  <th>Waktu</th>
											  <th>Ruang</th>
											  <th>paket</th>
										
											  <th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($uas as $no => $jadwal)
											<tr>
											
											
											
											 <td>{{ $jadwal->nm_mtk }} ({{ $jadwal->kd_mtk }})</td>
											
											 <td>{{ $jadwal->kd_lokal }}</td>
											 <td>{{ $jadwal->hari_t }}</td>
											 <td>{{ $jadwal->jam_t }}</td>
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
											
											 <td>
												<a href="/show/jadwal-uji-baak" class="btn btn-xs btn-info">show</a>
											 </td>
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
