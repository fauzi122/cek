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
											  
                                                <th>NIP</th>
                                                <th>NM MTK</th>
                                                <th>Kode MTK</th>

                                                <th>Kelas</th>
                                                <th>Kel-Ujian</th>
                                                <th>Hari</th>
                                                <th>Mulai</th>
                                                <th>Selsai</th>
                                                <th>Ruang</th>
                                                <th>paket</th>
                                                <th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											 @foreach ($jadwal as $no => $jadwal)
											<tr>
											
											
											 
											<td>{{ $jadwal->nip }}
                                                <br>
                                                {{ $jadwal->kd_dosen }}
                                            </td>
										
											 <td>{{ $jadwal->nm_mtk }}</td>
											 <td>{{ $jadwal->kd_mtk }}</td>
											 <td>{{ $jadwal->kd_lokal }}</td>
											 <td>{{ $jadwal->kel_ujian }}</td>
											 <td>{{ $jadwal->hari_t }}</td>
											 <td>{{ $jadwal->mulai }}</td>
											 <td>{{ $jadwal->selesai }}</td>
											 <td>{{ $jadwal->no_ruang }}</td>
											 <td>{{ $jadwal->paket }}</td>
                                             @php
                                                $id=Crypt::encryptString($jadwal->kd_dosen.','.$jadwal->kd_mtk.','.$jadwal->kel_ujian.','.$jadwal->paket);                                    
                                                @endphp
                        
											 <td>
                                                <a href="/show/jadwal-uji-baak/{{ $id }}" class="btn btn-xs btn-info">show</a>
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
