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
									
									List Pengawas Pengganti</h4>
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
											  
                                                <th>DOSEN ASLI</th>
                                                <th>DOSEN PENGGANTI</th>
                                                <th>Kel-Ujian</th>
                                                <th>MTK</th>
                                                <th>paket</th>
                                                <th>PETUGAS</th>
                                                <th>ket</th>
                                                <th>updated_at</th>
                                               
											</tr>
										</thead>
										<tbody>
											 @foreach ($jadwal as $no => $jadwal)
											<tr>
											
										
											 <td>{{ $jadwal->kd_dosen_asli }}</td>
											 <td>{{ $jadwal->kd_dosen_pengganti }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td>{{ $jadwal->kd_mtk }}</td>
											 <td>{{ $jadwal->paket }}</td>
											 <td>{{ $jadwal->petugas_input }}</td>
											 <td>{{ $jadwal->ket }}</td>
											 <td>{{ $jadwal->updated_at }}</td>
											 
                                             @php
                                                $id=Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket);                                    
                                                @endphp
                        
											 {{-- <td>
                                                <a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-xs btn-info">show</a>
                                             </td> --}}

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
