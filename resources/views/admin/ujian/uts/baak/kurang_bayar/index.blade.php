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
									
									List Mahasiswa Kurang Bayar Kuliah</h4>
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
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  
                                                <th>no</th>
                                                <th>nim</th>
                                                <th>nama</th>
                                                <th>kelas</th>
                                                <th>paket</th>
                                                <th>status</th>

                                               
											</tr>
										</thead>
										<tbody>
											 @foreach ($mhs as $no => $jadwal)
											<tr>
											
										
											 <td>{{ $loop->iteration}}</td>
											 <td>{{ $jadwal->nim }}</td>
                                             <td>{{ $jadwal->name }}</td>
											 <td>{{ $jadwal->kd_lokal }}</td>
											 <td>{{ $jadwal->paket }}</td>
											
											 <td>
												@if($jadwal->status_bayar==1)
													lunas
												@elseif($jadwal->status_bayar==0)
												belum lunas
												@endif

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
